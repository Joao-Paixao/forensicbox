#!/bin/bash

# Turn Off Access Point
sudo /home/audit/ForensicBox/scripts/access_point/stop_ap.sh

# Connect to the target Network if not already
sudo /home/audit/ForensicBox/scripts/audit/connect_network.sh

# Update System Time
sudo ntpdate pool.ntp.org

# Create cron job
sudo /home/audit/ForensicBox/scripts/audit/schedule.sh
