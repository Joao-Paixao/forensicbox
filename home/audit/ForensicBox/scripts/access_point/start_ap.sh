#!/bin/bash

# Turn on Service for AP
sudo systemctl start hostapd
sudo systemctl start dnsmasq
sudo systemctl start apache2

echo "Access Point turned on"
