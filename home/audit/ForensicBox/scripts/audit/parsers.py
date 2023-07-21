import xml.etree.ElementTree as ElementTree

def parse_hostname(data, host):
    """
    Parse the first hostname if available
    """

    HOSTNAME_ELEMENT = data.find('hostnames').find('hostname')

    if HOSTNAME_ELEMENT is not None:
        host['name'] = HOSTNAME_ELEMENT.get('name')

    return host


def parse_address(data, host):
    """
    Parse the address, mac, and vendor if available

    Doens't support ipv6
    """

    ADDRESS_LIST = data.findall('address')

    for address in ADDRESS_LIST:

        if address.get('addrtype') == 'ipv4':
            host['address'] = address.get('addr')

        elif address.get('addrtype') == 'mac':
            host['mac'] = address.get('addr')
            host['vendor'] = address.get('vendor')

    return host


def parse_operating_system(data, host):
    """
    Parse the operating system if available
    """

    OPERATING_SYSTEM_ELEMENT = data.find('os').find('osmatch')

    if OPERATING_SYSTEM_ELEMENT is not None:
        host['operating_system'] = OPERATING_SYSTEM_ELEMENT.get('name')

    return host


def parse_ports(data, host):
    """
    Parse the ports and services if available
    """

    PORTS_LIST = data.find('ports').findall('port')

    for port in PORTS_LIST:

        NUMBER = port.get('portid')
        PROTOCOL = port.get('protocol')

        SERVICE = port.find('service')

        SERVICE_PRODUCT = SERVICE.get('product')
        if SERVICE_PRODUCT is None:
            SERVICE_PRODUCT = ''

        SERVICE_NAME = SERVICE.get('name')
        if SERVICE_NAME is None:
            SERVICE_NAME = ''

        SERVICE_VERSION = SERVICE.get('version')
        if SERVICE_VERSION is None:
            SERVICE_VERSION = ''

        PORT_INFO = {
            'number': NUMBER,
            'protocol': PROTOCOL,
            'service': SERVICE_PRODUCT,
            'service_name': SERVICE_NAME,
            'service_version': SERVICE_VERSION
        }

        host['ports'].append(PORT_INFO)
        host['port_count'] += 1

    return host


def nmap_parser(nmap_output):
    """
    Parse the nmap output and return a list of hosts
    """

    XML_TREE = ElementTree.parse(nmap_output)

    ROOT_ELEMENT = XML_TREE.getroot()

    HOST_ELEMENTS = ROOT_ELEMENT.findall('host')

    hosts = []
    host_count = 0

    for host in HOST_ELEMENTS:

        hosts.append({
            'name': '',
            'address': '',
            'mac': '',
            'vendor': '',
            'operating_system': '',
            'ports': [],
            'port_count': 0,
        })

        hosts[host_count] = parse_hostname(host, hosts[host_count])
        hosts[host_count] = parse_address(host, hosts[host_count])
        hosts[host_count] = parse_operating_system(host, hosts[host_count])
        hosts[host_count] = parse_ports(host, hosts[host_count])

        host_count += 1

    return hosts

def zap_parser(host):
    """
    Parse the OWASP ZAP output and return the host updated
    """

    try:
        ZAP_OUTPUT = "/home/audit/ForensicBox/scripts/audit/zap_report/report_" + host['address'] + ".xml"
        XML_TREE = ElementTree.parse(ZAP_OUTPUT)
    except FileNotFoundError as e:
        print("[ERROR:zap_parser:12] File not found: " + ZAP_OUTPUT)
        print(e)
        return host

    host['alert_count'] = 0
    host['alerts'] = []

    ROOT_ELEMENT = XML_TREE.getroot()

    ALERTS = ROOT_ELEMENT.findall('site/alerts/alertitem')

    for alert in ALERTS:

        risk_code = alert.find('riskcode').text
        if risk_code != "2" and risk_code != "3":
            # Discard low risk alerts
            continue

        name = alert.find('name').text

        if risk_code == "2":
            risk_code = "Medium"
        else:
            risk_code = "High"

        confidence = alert.find('confidence').text
        if confidence == "1":
            confidence = "Low"
        elif confidence == "2":
            confidence = "Medium"
        else:
            confidence = "High"

        description = alert.find('desc').text

        solution = alert.find('solution').text

        reference = alert.find('reference').text

        ALERT_INFO = {
            "name": name,
            "risk": risk_code,
            "confidence": confidence,
            "description": description,
            "solution": solution,
            "reference": reference
        }

        host['alert_count'] += 1
        host['alerts'].append(ALERT_INFO)

    return host
