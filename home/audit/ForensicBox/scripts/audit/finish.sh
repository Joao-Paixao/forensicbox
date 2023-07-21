#!/bin/bash

# Copy report to entity folder
echo "$(date '+%Y-%m-%d %H:%M:%S') - Script: $0 - Copying Report" >> "/home/audit/ForensicBox/log.txt"
ENTITY=$(awk '/-connection/ {print $2}' /home/audit/ForensicBox/outputs/audit.conf)
mv /home/audit/ForensicBox/outputs/report*.pdf /var/www/forensicbox/userspace/$ENTITY/

# Remove audit outputs
echo "$(date '+%Y-%m-%d %H:%M:%S') - Script: $0 - Removing Outputs" >> "/home/audit/ForensicBox/log.txt"
sudo rm /home/audit/ForensicBox/outputs/*
sudo rm /home/audit/ForensicBox/scripts/audit/zap_report/*
sudo rm /home/audit/ForensicBox/scripts/audit/report/*

echo "$(date '+%Y-%m-%d %H:%M:%S') - Script: $0 - Turn Off Wifi Mode" >> "/home/audit/ForensicBox/log.txt"
# Stop wpa_supplicant
sudo kill $(sudo pgrep wpa_supplicant)
# Release DHCP lease
sudo dhclient -r wlan0

# Remove network connections
sudo systemctl stop wpa_supplicant
sudo rm /var/run/wpa_supplicant/wlan0
sudo cp /home/audit/ForensicBox/defaults/dhcpcd_deactivate_wlan0.conf /etc/dhcpcd.conf
sudo cp /home/audit/ForensicBox/defaults/wpa_supplicant.conf /etc/wpa_supplicant/wpa_supplicant.conf
sudo systemctl restart dhcpcd.service

echo "$(date '+%Y-%m-%d %H:%M:%S') - Script: $0 - Turn Off Ethernet Mode" >> "/home/audit/ForensicBox/log.txt"
sudo ifconfig eth0 down

# Start access point
echo "$(date '+%Y-%m-%d %H:%M:%S') - Script: $0 - Restart System" >> "/home/audit/ForensicBox/log.txt"
sudo /home/audit/ForensicBox/scripts/access_point/stop_ap.sh
sudo /home/audit/ForensicBox/scripts/access_point/start_ap.sh
