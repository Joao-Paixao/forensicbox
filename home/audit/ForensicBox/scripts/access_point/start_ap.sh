#!/bin/bash

# Turn on Service for AP
sudo systemctl start hostapd
sudo systemctl start dnsmasq

echo "Access Point turned on"
