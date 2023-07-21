import sys
import datetime
import subprocess

from parsers import nmap_parser, zap_parser
from report_generator import report_generator

if __name__ == '__main__':

    NMAP_OUTPUT = sys.argv[1]

    with open("/home/audit/ForensicBox/log.txt", "a") as file:
        file.write(datetime.datetime.now().strftime('%Y-%m-%d %H:%M:%S') + " - Script: controller.py - Parsing Nmap Output\n")

    hosts = nmap_parser(NMAP_OUTPUT)

    with open("/home/audit/ForensicBox/log.txt", "a") as file:
        file.write(datetime.datetime.now().strftime('%Y-%m-%d %H:%M:%S') + " - Script: controller.py - NMAP Parser - DONE\n")

    use_tool_zap = False
    try:
        with open("/home/audit/ForensicBox/outputs/audit.conf", 'r') as file:
            for line in file:
                if "-zap" in line:
                    use_tool_zap = True
    except FileNotFoundError:
        pass

    if use_tool_zap:
        with open("/home/audit/ForensicBox/log.txt", "a") as file:
            file.write(datetime.datetime.now().strftime('%Y-%m-%d %H:%M:%S') + " - Script: controller.py - ZAP Tool Selected For Audit\n")

        for host in hosts:
            with open("/home/audit/ForensicBox/log.txt", "a") as file:
                file.write(datetime.datetime.now().strftime('%Y-%m-%d %H:%M:%S') + " - Script: controller.py - ZAP Analysing host[" + host['address'] + "]\n")
            process = subprocess.Popen(['python3','/home/audit/ForensicBox/scripts/audit/zap.py',host['address']],stdout=None)
            process.wait()

            with open("/home/audit/ForensicBox/log.txt", "a") as file:
                file.write(datetime.datetime.now().strftime('%Y-%m-%d %H:%M:%S') + " - Script: controller.py - ZAP Parsing Host" + host['address'] + " Output\n")
            hosts[hosts.index(host)] = zap_parser(host)
        with open("/home/audit/ForensicBox/log.txt", "a") as file:
            file.write(datetime.datetime.now().strftime('%Y-%m-%d %H:%M:%S') + " - Script: controller.py - ZAP - DONE\n")
    with open("/home/audit/ForensicBox/log.txt", "a") as file:
            file.write(datetime.datetime.now().strftime('%Y-%m-%d %H:%M:%S') + " - Script: controller.py - Generate report\n")
    report_generator(hosts)
    with open("/home/audit/ForensicBox/log.txt", "a") as file:
            file.write(datetime.datetime.now().strftime('%Y-%m-%d %H:%M:%S') + " - Script: controller.py - Generated report\n")
        
    process = subprocess.Popen(['sudo', '/home/audit/ForensicBox/scripts/audit/finish.sh'],stdout=None)
    process.wait()
