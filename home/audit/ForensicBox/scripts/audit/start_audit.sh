#!/bin/bash
echo "$(date '+%Y-%m-%d %H:%M:%S') - Script: $0 - Start Audit" >> "/home/audit/ForensicBox/log.txt"

CIDR=$(ip -oneline -family inet addr | awk '/scope global/ {print $4}')

echo "$(date '+%Y-%m-%d %H:%M:%S') - Script: $0 - Initiate Nmap Scan" >> "/home/audit/ForensicBox/log.txt"
echo "$(date '+%Y-%m-%d %H:%M:%S') - Script: $0 - CIDR: $CIDR" >> "/home/audit/ForensicBox/log.txt"
sudo nmap -T5 -oX /home/audit/ForensicBox/outputs/nmap.xml -O -sV $CIDR &

nmap_pid=$!

counter=0

while ps -p "$nmap_pid" > /dev/null; do
        ((counter++))
        if ((counter == 60)); then
                echo "$(date '+%Y-%m-%d %H:%M:%S') - Script: $0 - Nmap Scanning" >> "/home/audit/ForensicBox/log.txt"
                counter=0
        fi
        sleep 1
done

echo "$(date '+%Y-%m-%d %H:%M:%S') - Script: $0 - Nmap Finish" >> "/home/audit/ForensicBox/log.txt"
wait "$nmap_pid"

echo "$(date '+%Y-%m-%d %H:%M:%S') - Script: $0 - Parsing Output" >> "/home/audit/ForensicBox/log.txt"
sudo python3 /home/audit/ForensicBox/scripts/audit/controller.py /home/audit/ForensicBox/outputs/nmap.xml
