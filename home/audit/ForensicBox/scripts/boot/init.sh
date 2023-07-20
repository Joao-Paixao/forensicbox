#!/bin/bash

# Set defaults
sudo cp /home/audit/ForensicBox/defaults/hostapd.conf /etc/hostapd/hostapd.conf
sudo cp /home/audit/ForensicBox/defaults/dhcpcd_deactivate_wlan0.conf /etc/dhcpcd.conf
sudo cp /home/audit/ForensicBox/defaults/wpa_supplicant.conf /etc/wpa_supplicant/wpa_supplicant.conf

# Remove previous Forensic Box outputs
sudo rm /home/audit/ForensicBox/outputs/*

# Turn off Access Point
sudo /home/audit/ForensicBox/scripts/access_point/stop_ap.sh
# Turn on Access Point
sudo /home/audit/ForensicBox/scripts/access_point/start_ap.sh
