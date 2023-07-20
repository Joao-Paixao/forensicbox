#!/bin/bash

# Copy report to entity folder
ENTITY=$(awk '/-connection/ {print $2}' /home/audit/ForensicBox/outputs/audit.conf)
mv /home/audit/ForensicBox/outputs/report*.pdf /var/www/forensicbox/userspace/$ENTITY/

# Remove audit outputs
sudo rm /home/audit/ForensicBox/outputs/*

# Remove network connections
sudo systemctl stop wpa_supplicant
sudo rm /var/run/wpa_supplicant/wlan0
cp /home/audit/ForensicBox/defaults/dhcpcd_deactivate_wlan0.conf /etc/dhcpcd.conf
sudo systemctl restart dhcpcd

sudo ifconfig eth0 down

# Start access point
sudo /home/audit/ForensicBox/scripts/access_point/stop_ap.sh
sudo /home/audit/ForensicBox/scripts/access_point/start_ap.sh
