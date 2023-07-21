#!/bin/bash

SCHEDULE_MODE=$(awk '/-schedule/ {print $2}' '/home/audit/ForensicBox/outputs/audit.conf')

if [ "$SCHEDULE_MODE" -eq 1 ]; then
        echo "$(date '+%Y-%m-%d %H:%M:%S') - Script: $0 - Scheduling Right Now" >> "/home/audit/ForensicBox/log.txt"
        sudo /home/audit/ForensicBox/scripts/audit/start_audit.sh
fi

if [ "$SCHEDULE_MODE" -eq 2 ]; then
        echo "$(date '+%Y-%m-%d %H:%M:%S') - Script: $0 - Scheduling For Later" >> "/home/audit/ForensicBox/log.txt"
        DATE=$(awk '/-date/ {print $2}' '/home/audit/ForensicBox/outputs/audit.conf')
        TIME=$(awk '/-time/ {print $2}' '/home/audit/ForensicBox/outputs/audit.conf')

        DAY=$(date -d "$DATE" + "%d")
        MONTH=$(date -d "$DATE" + "%m")
        HOUR=$(date -d "$TIME" + "%H")
        MIN=$(date -d "$TIME" + "%M")

        (crontab -l 2>/dev/null; echo "$cron_time $cron_date sudo /home/audit/ForensicBox/scripts/audit/start_audit.sh") | crontab -
fi
