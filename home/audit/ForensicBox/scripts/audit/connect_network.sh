#!/bin/bash

CONNECTION_MODE=$(awk '/-connection/ {print $2}' '/home/audit/ForensicBox/outputs/audit.conf')

# Ethernet Connection
if [ "$CONNECTION_MODE" -eq 1 ]; then
        echo "$(date '+%Y-%m-%d %H:%M:%S') - Script: $0 - Ethernet Mode" >> "/home/audit/ForensicBox/log.txt"
        sudo ifconfig eth0 up
        # Is Interface UP
        if [[ -n $(ip link show eth0 up) ]]; then
                # Is Connected to a network
                if [[ -n $(ip -4 addr show eth0 | grep -oP "(?<=inet\s)\d+(\.\d+){3}") ]]; then
                        echo "$(date '+%Y-%m-%d %H:%M:%S') - Script: $0 - Ethernet Connected" >> "/home/audit/ForensicBox/log.txt"
                        exit 0
                else
                        echo "$(date '+%Y-%m-%d %H:%M:%S') - Script: $0 - Ethernet Fail 1" >> "/home/audit/ForensicBox/log.txt"
                        exit 1
                fi
        else
                echo "$(date '+%Y-%m-%d %H:%M:%S') - Script: $0 - Ethernet Fail 2" >> "/home/audit/ForensicBox/log.txt"
                exit 1
        fi
fi

# Wireless Connection
if [ "$CONNECTION_MODE" -eq 2 ]; then
        echo "$(date '+%Y-%m-%d %H:%M:%S') - Script: $0 - Wifi Mode" >> "/home/audit/ForensicBox/log.txt"
        SSID=$(awk '/-ssid/ {print $2}' '/home/audit/ForensicBox/outputs/audit.conf')
        PASS=$(awk '/-pass/ {print $2}' '/home/audit/ForensicBox/outputs/audit.conf')

        cp /home/audit/ForensicBox/defaults/dhcpcd_activate_wlan0.conf /etc/dhcpcd.conf
        cp /home/audit/ForensicBox/defaults/wpa_supplicant.conf /etc/wpa_supplicant/wpa_supplicant.conf
        sudo systemctl stop wpa_supplicant
        sudo rm /var/run/wpa_supplicant/wlan0
        sudo sh -c "wpa_passphrase '$SSID' '$PASS' >> /etc/wpa_supplicant/wpa_supplicant.conf"
        sudo wpa_supplicant -B -iwlan0 -c/etc/wpa_supplicant/wpa_supplicant.conf -Dnl80211
        sudo dhclient wlan0

        if iwconfig wlan0 | grep -q "ESSID"; then
                echo "$(date '+%Y-%m-%d %H:%M:%S') - Script: $0 - Wifi Connected" >> "/home/audit/ForensicBox/log.txt"
                exit 0
        else
                echo "$(date '+%Y-%m-%d %H:%M:%S') - Script: $0 - Wifi Fail" >> "/home/audit/ForensicBox/log.txt"
                exit 1
        fi
fi
