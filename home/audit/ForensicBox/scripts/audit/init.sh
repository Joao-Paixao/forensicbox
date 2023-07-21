#!/bin/bash

# Turn Off Access Point
echo "$(date '+%Y-%m-%d %H:%M:%S') - Script: $0 - Turn Off Access Point" >> "/home/audit/ForensicBox/log.txt"
sudo /home/audit/ForensicBox/scripts/access_point/stop_ap.sh

# Connect to the target Network if not already
echo "$(date '+%Y-%m-%d %H:%M:%S') - Script: $0 - Connect to Target Network" >> "/home/audit/ForensicBox/log.txt"
sudo /home/audit/ForensicBox/scripts/audit/connect_network.sh

if [ $? -eq 0 ]; then
        echo "$(date '+%Y-%m-%d %H:%M:%S') - Script: $0 - Successfully Connected" >> "/home/audit/ForensicBox/log.txt"
        # Update System Time
        echo "$(date '+%Y-%m-%d %H:%M:%S') - Script: $0 - Updating System Time" >> "/home/audit/ForensicBox/log.txt"
        sudo ntpdate pool.ntp.org

        # Schedule Audit
        echo "$(date '+%Y-%m-%d %H:%M:%S') - Script: $0 - Scheduling Audit" >> "/home/audit/ForensicBox/log.txt"
        sudo /home/audit/ForensicBox/scripts/audit/schedule.sh
else
        # Restart
        echo "$(date '+%Y-%m-%d %H:%M:%S') - Script: $0 - Error Connecting to Target Network (Restarting)" >> "/home/audit/ForensicBox/log.txt"
        sudo /home/audit/ForensicBox/scripts/audit/finish.sh
fi
