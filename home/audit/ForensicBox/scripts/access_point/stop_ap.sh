#!/bin/bash

# Turn off Services for AP
sudo systemctl stop hostapd
sudo systemctl stop dnsmasq
sudo systemctl stop apache2

echo "Access Point turned off"
