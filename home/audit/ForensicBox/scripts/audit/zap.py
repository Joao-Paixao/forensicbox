import time
import os
import sys
import datetime
import subprocess

from zapv2 import ZAPv2

API_KEY = '4fchi334102rube158mc8afv67'

LOCAL_PROXY = {
    "http": "http://127.0.0.1:8091",
    "https": "http://127.0.0.1:8091"
}

SESSION_NAME = "test_session"

if len(sys.argv) != 2:
    print('Wrong number of arguments!\n')
    print('Usage: python3 zap.py ip_address\n')
    sys.exit()

TARGET = "http://" + sys.argv[1]

print('Starting ZAP ...')
with open("/home/audit/ForensicBox/log.txt", "a") as file:
        file.write(datetime.datetime.now().strftime('%Y-%m-%d %H:%M:%S') + " - Script: zap.py - Starting ZAP\n")
subprocess.Popen(['/home/audit/ForensicBox/scripts/audit/ZAP_2.13.0/zap.sh','-daemon', '-port','8091'],stdout=open(os.devnull,'w'))
print('Waiting for ZAP to load, 90 seconds ...')
time.sleep(90)

# Connect ZAP API Client to the listening address of ZAP instance
zap = ZAPv2(proxies=LOCAL_PROXY, apikey=API_KEY)

core = zap.core
print("Create ZAP session: " + SESSION_NAME + " ->")
core.new_session(name=SESSION_NAME, overwrite=True)
print("Session created")

core.access_url(url=TARGET, followredirects=True)
time.sleep(2) # Give the sites tree a chance to get updated

print("Starting Scans on target: " + TARGET)
with open("/home/audit/ForensicBox/log.txt", "a") as file:
        file.write(datetime.datetime.now().strftime('%Y-%m-%d %H:%M:%S') + " - Script: zap.py - Starting Scans on target: " + TARGET + "\n")

# Start spidering the site from the specified URL
# Note that the exception here isn't an error, I think
# it's a bug in the client as the content of the error
# says OK
print("----------------------------------")
print("Initiating spidering scan ...")
with open("/home/audit/ForensicBox/log.txt", "a") as file:
        file.write(datetime.datetime.now().strftime('%Y-%m-%d %H:%M:%S') + " - Script: zap.py - Spider Scan Init\n")
try:
    SCAN_ID = zap.spider.scan(
        url=TARGET, maxchildren=None,
        recurse=True, contextname=None,
        subtreeonly=None)
except Exception as e:
    print("[Error] L57 | Spidering: " + str(e))
    pass

print("Spider Scan ID: " + str(SCAN_ID))
time.sleep(2) # Give the spider a chance to start

while (int(zap.spider.status(SCAN_ID)) < 100):
    print("Spider progress: " + zap.spider.status(SCAN_ID) + " %")
    time.sleep(2)
print("Spider scan completed!")
print("----------------------------------")
with open("/home/audit/ForensicBox/log.txt", "a") as file:
        file.write(datetime.datetime.now().strftime('%Y-%m-%d %H:%M:%S') + " - Script: zap.py - Spider Scan Done\n")

use_ajax_spider = True

if use_ajax_spider:
    print("Initiating AJAX spidering scan ...")
    with open("/home/audit/ForensicBox/log.txt", "a") as file:
        file.write(datetime.datetime.now().strftime('%Y-%m-%d %H:%M:%S') + " - Script: zap.py - Ajax Spider Scan Init\n")
    try:
        zap.ajaxSpider.scan(url=TARGET, inscope=None)
    except Exception as e:
        print("[Error] L75 | AJAX Spidering: " + str(e))
        pass

    time.sleep(10) # Give the AJAX spider a chance to start

    while(zap.ajaxSpider.status != 'stopped'):
        print("AJAX Spider progress: " + zap.ajaxSpider.status)
        time.sleep(5)
    print("AJAX Spider scan completed!")
    print("----------------------------------")
    with open("/home/audit/ForensicBox/log.txt", "a") as file:
        file.write(datetime.datetime.now().strftime('%Y-%m-%d %H:%M:%S') + " - Script: zap.py - Ajax Spider Scan Done\n")

print("Initiating active scan ...")
with open("/home/audit/ForensicBox/log.txt", "a") as file:
        file.write(datetime.datetime.now().strftime('%Y-%m-%d %H:%M:%S') + " - Script: zap.py - Active Scan Init\n")
try:
    SCAN_ID = zap.ascan.scan(
        url=TARGET, recurse=True,
        inscopeonly=None, scanpolicyname=None,
        method=None, postdata=True)
except Exception as e:
    print("[Error] L91 | Active Scan: " + str(e))
    pass

print("Active Scan ID: " + str(SCAN_ID))
if str(SCAN_ID) != "url_not_found":
    while(int(zap.ascan.status(SCAN_ID)) < 100):
        print("Active Scan progress: " + zap.ascan.status(SCAN_ID) + " %")
        time.sleep(5)
    print("Active Scan completed!")
    print("----------------------------------")
    with open("/home/audit/ForensicBox/log.txt", "a") as file:
         file.write(datetime.datetime.now().strftime('%Y-%m-%d %H:%M:%S') + " - Script: zap.py - Actice Scan Done\n")

# Give the passive scanner a chance to finish
time.sleep(5)

print("XML Report")
xml_report = core.xmlreport()

with open('/home/audit/ForensicBox/scripts/audit/zap_report/report_' + sys.argv[1] + '.xml', 'w') as f:
    f.write(xml_report)
print("Report exported!")

print("Shutdown ZAP ...")
core.shutdown()
print("ZAP shutdown completed!")
