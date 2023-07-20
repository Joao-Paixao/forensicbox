<?php
        if(!isset($_COOKIE['ENTITY']))
        {
                header('Location: index');
        }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Network Audit Configuration - Forensic Box</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
    body {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    margin: 0;
    padding: 0px 0px 10px 0px;
    }

    h2 {
    margin-top: 20px;
    }

    .wireless_information {
        display: none;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .custom_schedule {
        display: none;
    }
    </style>
</head>
<body>
        <h1>Forensic Box</h1>
        <h4>With this web interface you can configure the Forensic Box to your needs.</h4>
        <h3>Network Audit Configuration</h3>
    <?php
        echo '
        <form method="post" action="network_redirect">
                <div style="background-color: lightgray; padding: 10px 0px 20px 0px; margin: 10px 0px;">
                    <h2 style="margin: 0px"> Network Identification </h2>
                    <h3>Connection via:</h3>
                    <input type="radio" id="ethernet" name="via" value="1" onchange="toggle_connection(this)"' .
                    (isset($_COOKIE['VIA']) && $_COOKIE['VIA'] == 1 ? 'checked' : '') . ' required>
                    <label for="ethernet">Ethernet</label>
                    <br>
                    <input type="radio" id="wireless" name="via" value="2" onchange="toggle_connection(this)" onload="toggle_connection(this)"'
                    . (isset($_COOKIE['VIA']) && $_COOKIE['VIA'] == 2 ? 'checked' : '') . ' required>
                    <label for="wireless">Wireless</label>
                    <div class="wireless_information">
                        <h3>Wireless Network</h3>
                        <label for="ssid">SSID(Network Name):</label>
                        <input type="text" name="ssid" id="ssid"' . (isset($_COOKIE['SSID']) ? 'value="' . $_COOKIE['SSID'] . '"' : '') . '>
                        <br>
                        <label for="password">Password:</label>
                        <input type="text" name="password" id="password"' . (isset($_COOKIE['PASSWORD']) ? 'value="' . $_COOKIE['PASSWORD'] . '"' : '') . '>
                    </div>
                </div>
                <div style="background-color: lightgray; padding: 10px 0px; margin: 10px 0px;">
                    <h2 style="margin: 0px 0px 20px 0px"> Auditing Tools </h2>
                    <div style="display:flex; flex-direction: row; align-items: center; text-align: center; background-color: white; margin: 0px 10px">
                        <div style="margin: 10px 0px">
                            <label for="nmap" style="display:flex; flex-direction: column; align-items: center; text-align: center;">
                                <span>
                                    <b>Nmap</b> - Network Scanner and Mapper
                                </span>
                                <br>
                                <span style="max-width: 400px;">
                                    This tool is used to scan network and map the hosts and services running on the network.
                                    <b>It cannot be deactivated.</b>
                                </span>
                            </label>
                        </div>
                        <div>
                            <input type="checkbox" name="tools[]" id="nmap" value="1" checked style="height:20px; width:20px; margin:20px;" onchange="enable_nmap(this)">
                        </div>
                    </div>
                    <br>
                    <div style="display:flex; flex-direction: row; align-items: center; text-align: center; background-color: white; margin: 0px 10px">
                        <div style="margin: 10px 0px">
                            <label for="zap" style="display:flex; flex-direction: column; align-items: center; text-align: center;">
                                <span>
                                    <b>OWASP ZAP</b> - Web Application Security Scanner
                                </span>
                                <br>
                                <span style="max-width: 400px;">
                                    This tool is used to scan web applications for security vulnerabilities.
                                </span>
                            </label>
                        </div>
                        <div>
                            <input type="checkbox" name="tools[]" id="zap" value="2"' . (isset($_COOKIE['TOOLS']) && in_array(2, unserialize($_COOKIE['TOOLS'])) ? 'checked' : '') . ' style="height:20px; width:20px; margin:20px;">
                        </div>
                    </div>
                </div>
                <div style="background-color: lightgray; padding: 10px 0px; margin: 10px 0px;">
                    <h2 style="margin: 0px 0px 20px 0px"> Schedule </h2>
                    <input type="radio" name="schedule" id="right_now" value="1" onchange="toggle_schedule(this)"' .
                    (isset($_COOKIE['SCHEDULE']) && $_COOKIE['SCHEDULE'] == 1 ? 'checked' : '') .' required>
                    <label for="right_now">Right Now</label>
                    <br>
                    <input type="radio" name="schedule" id="custom_schedule" value="2" onchange="toggle_schedule(this)" onload="toggle_schedule(this)"' .
                    (isset($_COOKIE['SCHEDULE']) && $_COOKIE['SCHEDULE'] == 2 ? 'checked' : '') .' required>
                    <label for="custom_schedule">Custom schedule</label>
                    <br>
                    <div class="custom_schedule">
                        <h3>Custom schedule</h3>
                        <label for="date">Date:</label>
                        <input type="date" name="date" id="date"'. (isset($_COOKIE['DATE']) ? 'value="' . $_COOKIE['DATE'] . '"' : '') .'>
                        <br>
                        <label for="time">Time:</label>
                        <input type="time" name="time" id="time"'. (isset($_COOKIE['TIME']) ? 'value="' . $_COOKIE['TIME'] . '"' : '') .'>
                    </div>
                </div>
                <div style="display:flex; flex-direction:row; align-items: center; justify-content: center;">
                    <input type="submit" name="BACK" value="Back" style="background-color: #0c2340;color: white;border: 0; border-radius: 5px;padding: 10px 20px; width: 120px; margin: 0px 10px; cursor: pointer" onclick="clear_required()">
                    <input type="submit" name="RESET" value="Reset" style=" background-color: #0c2340;color: white; border: 0; border-radius: 5px;padding: 10px 20px; width: 120px; margin: 0px 10px; cursor: pointer" onclick="clear_required()">
                    <input type="submit" name="CONFIRM" value="Confirm" style="background-color: lawngreen;border: 0; border-radius: 5px;padding: 10px 20px; width: 120px; margin: 0px 10px; cursor: pointer">
                </div>
            </form>
        ';
    ?>
    <script>
        document.querySelector('input[name="via"][value="2"]').addEventListener('load', toggle_connection(document.querySelector('input[name="via"][value="2"]')));
        document.querySelector('input[name="schedule"][value="2"]').addEventListener('load', toggle_schedule(document.querySelector('input[name="schedule"][value="2"]')));

        function toggle_connection(checkbox)
        {
            let ethernet_checkbox = document.getElementsByName("via")[0];
            let wireless_checkbox = document.getElementsByName("via")[1];

            let wireless_connection = document.getElementsByClassName("wireless_information")[0];

            if (checkbox.checked)
            {
                if (checkbox.value == 1) // Ethernet
                {
                    wireless_connection.style.display = "none";
                    wireless_connection.getElementsByTagName("input")[0].required = false;
                    wireless_checkbox.checked = false;
                }
                else // Wireless
                {
                    wireless_connection.style.display = "flex";
                    wireless_connection.getElementsByTagName("input")[0].required = true;
                    ethernet_checkbox.checked = false;
                }
            }
            else
            {
                    wireless_connection.style.display = "none";
                    wireless_connection.getElementsByTagName("input")[0].required = false;
            }
        }

        function toggle_schedule(checkbox)
        {
            let no_schedule_checkbox = document.getElementsByName("schedule")[0];
            let custom_schedule_checkbox = document.getElementsByName("schedule")[1];

            let custom_schedule = document.getElementsByClassName("custom_schedule")[0];

            if (checkbox.checked)
            {
                if (checkbox.value == 1) // No custom schedule
                {
                    custom_schedule.style.display = "none";
                    custom_schedule.getElementsByTagName("input")[0].required = false;
                    custom_schedule.getElementsByTagName("input")[1].required = false;
                    custom_schedule_checkbox.checked = false;
                }
                else // Custom schedule
                {
                    custom_schedule.style.display = "block";
                    custom_schedule.getElementsByTagName("input")[0].required = true;
                    custom_schedule.getElementsByTagName("input")[1].required = true;
                    no_schedule_checkbox.checked = false;
                }
            }
            else
            {
                custom_schedule.style.display = "none";
                custom_schedule.getElementsByTagName("input")[0].required = false;
                custom_schedule.getElementsByTagName("input")[1].required = false;
            }
        }

        function enable_nmap(checkbox)
        {
            let nmap_checkbox = document.getElementsByName("tools[]")[0];

            if (!checkbox.checked)
            {
                nmap_checkbox.checked = true;
            }
        }

        function clear_required(){
            document.getElementsByName("via")[0].required = false; // Ethernet
            document.getElementsByName("via")[1].required = false; // Wireless
            document.getElementsByName("ssid")[0].required = false; // SSID
            document.getElementsByName("password")[0].required = false; // Password
            document.getElementsByName("schedule")[0].required = false; // Right now
            document.getElementsByName("schedule")[1].required = false; // Custom
            document.getElementsByName("date")[0].required = false; // Date
            document.getElementsByName("time")[0].required = false; // Time
        }

    </script>
</body>
</html>
