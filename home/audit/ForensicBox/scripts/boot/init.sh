#!/bin/bash

# Stop services
sudo systemctl stop hostapd.service
sudo systemctl stop dnsmasq.service
sudo systemctl stop wpa_supplicant.service
sudo kill $(sudo pgrep wpa_supplicant)
sudo rm /var/run/wpa_supplicant/wlan0
sudo dhclient -r wlan0
sudo systemctl stop dhcpcd.service

sudo ifconfig eth0 down

# Set defaults
sudo cp /home/audit/ForensicBox/defaults/hostapd.conf /etc/hostapd/hostapd.conf
sudo cp /home/audit/ForensicBox/defaults/dhcpcd_deactivate_wlan0.conf /etc/dhcpcd.conf
sudo cp /home/audit/ForensicBox/defaults/wpa_supplicant.conf /etc/wpa_supplicant/wpa_supplicant.conf

# Remove previous Forensic Box outputs
sudo rm /home/audit/ForensicBox/outputs/*
sudo rm /home/audit/ForensicBox/scripts/audit/zap_report/*
sudo rm /home/audit/ForensicBox/scripts/audit/reports/*

# Turn off Access Point
sudo /home/audit/ForensicBox/scripts/access_point/stop_ap.sh
# Turn on Access Point
sudo /home/audit/ForensicBox/scripts/access_point/start_ap.sh
