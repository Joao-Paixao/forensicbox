#!/bin/bash

# Turn off Services for AP
sudo systemctl stop hostapd
sudo systemctl stop dnsmasq

echo "Access Point turned off"
