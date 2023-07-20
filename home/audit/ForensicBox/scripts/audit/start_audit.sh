#!/bin/bash

CIDR=$(ip -oneline -family inet addr | awk '/scope global/ {print $4}')

echo $CIDR

echo 'Initiate Nmap Scan'
sudo nmap -T5 -oX /home/audit/ForensicBox/outputs/nmap.xml -O -sV $CIDR
