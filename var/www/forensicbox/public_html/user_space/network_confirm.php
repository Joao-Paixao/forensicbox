<?php
        if (!isset($_COOKIE['ENTITY']))
        {
                header('Location: index');
        }

        if (!isset($_COOKIE['CONFIRM_CONFIG']))
        {
                setcookie('CONFIRM_CONFIG', '', time() - 3600, '/');
                header('Location: network');
        }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Confirm Network Audit Configuration - Forensic Box</title>
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
</head
<body>
        <h1>Forensic Box</h1>
        <h4>With this web interface you can configure the Forensic Box to your needs.</h4>
        <?php
                echo '
                        <div style="display: flex; flex-direction: column; align-items: center; max-width: 600px">
                                <div style="background-color: lightgray; padding: 10px 0px 20px 0px; margin: 10px 0px 10px 0px; width: 100%">
                                        <h2 style="margin: 0px; flex-grow: 1">Network Identification </h2>
                ';
                if ( $_COOKIE['VIA'] == 1 ) // Ethernet Connection
                {
                        setcookie('SSID', '', time() - 3601);
                        setcookie('PASSWORD', '', time() - 3601);
                        echo '
                                <h3 style="flex-grow: 1">Connection via: <u>Ethernet</u> </h3>
                                <p style="background: white; margin: 0px 20px; flex-grow: 3; max-width: 600px;">
                                Please connect the device to the network via Ethernet before starting the audit process.
                                <br>
                                If the device detects a connection, the audit will start based on the schedule.
                                <br>
                                Otherwise, the audit configuration will be discarded.
                                </p>
                        ';
                }
                if ($_COOKIE['VIA'] == 2 ) // Wireless Connection
                {
                        echo '
                                <h3 style="flex-grow: 1">Connection via: <u>Wireless</u> </h3>
                                <p style="flex-grow: 1">
                                <b>Wireless Network:</b> ' . $_COOKIE['SSID'] . '
                                <br>
                                <b>Password:</b> ' . $_COOKIE['PASSWORD'] . '
                                </p>
                                <p style="background: white; margin: 0px 20px; flex-grow: 1;">
                                    The device will connect to the specified parameters.
                                    <br>
                                    If the device detects a connection, the audit will start based on the schedule.
                                    <br>
                                    Otherwise, the audit configuration will be discarded.
                                </p>
                            ';
                }
                echo '</div>';
                // Tools
                echo '
                        <div style="background-color: lightgray; padding: 10px 0px; margin: 10px 0px; width: 100%">
                                <h2 style="margin: 0px 0px 20px 0px"> Auditing Tools </h2>
                                The following tools will be used during the audit:
                ';
                $tools = unserialize($_COOKIE['TOOLS']);

                if (count($tools) == 1) // Only Nmap
                {
                        echo '
                            <div style="background-color: white; margin: 10px 10px; padding: 10px 0px">
                                <h3 style="10px 0px">Nmap</h3>
                                Network Scanner and Mapper
                            </div>
                        ';
                }
                else
                {
                        foreach ($tools as $tool)
                        {
                            if ( $tool == 1 ) // Nmap
                            {
                                echo '
                                    <div style="background-color: white; margin: 10px 10px; padding: 10px 0px">
                                        <h3 style="10px 0px">Nmap</h3>
                                        Network Scanner and Mapper
                                    </div>
                                ';
                            }

                            if ( $tool == 2 ) // OWASP ZAP
                            {
                                echo '
                                    <div style="background-color: white; margin: 10px 10px; padding: 10px 0px">
                                        <h3 style="10px 0px">OWASP ZAP</h3>
                                        Web Application Security Scanner
                                    </div>
                                ';
                            }
                        }
                }
                echo '</div>';
                // Schedule
                echo '
                        <div style="background-color: lightgray; padding: 10px 0px; margin: 10px 0px; width: 100%">
                        <h2 style="margin: 0px 0px 20px 0px"> Schedule </h2>
                ';
                if($_COOKIE['DATE'] <= date("Y-m-d") && $_COOKIE['TIME'] <= date("H:i"))
                {
                        $_COOKIE['SCHEDULE'] = 1;
                }

                if ( $_COOKIE['SCHEDULE'] == 1 ) // Right Now
                {
                        setcookie('DATE', '', time() - 3600);
                        setcookie('TIME', '', time() - 3600);
                        echo '
                                <div>
                                        <h3> Schedule: Right Now </h3>
                                        <div style="background: white; margin: 10px 10px; padding: 10px 0px">
                                        The audit will start as soon as the device establishes a connection to the network.
                                        </div>
                                </div>
                        ';
                }

                if ( $_COOKIE['SCHEDULE'] == 2 ) // Custom Schedule
                {
                        echo '
                            <div>
                                <h3> Schedule: Custom </h3>
                                <div style="display: flex; flex-direction: row; align-items: center;">
                                    <div style="flex-grow: 1; background: white; margin: 0px 10px; height: 40px; display: flex; flex-direction: row; align-items: center;">
                                        <div style="flex-grow: 1;display: flex; flex-direction: column; align-items: center;">
                                            <span><b>Date:</b>';
                        echo $_COOKIE['DATE'] . '</span>
                                        </div>
                                    </div>
                                    <div style="flex-grow: 1; background: white; margin: 0px 10px; height: 40px; display: flex; flex-direction: row; align-items: center;">
                                        <div style="flex-grow: 1;display: flex; flex-direction: column; align-items: center;">
                                            <span><b>Time:</b>';
                        echo $_COOKIE['TIME'] . '</span>
                                        </div>
                                    </div>
                                </div>
                                <div style="background: white; margin: 10px 10px; padding: 10px 0px">
                                    The audit will start on the specified date and time.
                                    <br>
                                    Until then, the device will be in sleep mode.
                                    <br>
                                    <b>You cannot change the audit configuration after confirming it unless you restart the device.</b>
                                </div>
                            </div>
                        ';
                }
                echo '</div>';
                // Warnings
                echo '
                        <div style="background-color: lightgray; padding: 10px 0px; margin: 10px 0px; width: 100%">
                            <h3> Warnings </h3>
                            <div style="padding: 0px 10px">
                                <div style="display: flex; flex-direction: row; align-items: center; background: white; margin: 10px 0px;">
                                    <b style="min-width: 80px">Warning 1:</b>
                                    <p style="flex-grow: 1"> The device will be in sleep mode until the audit starts. </p>
                                </div>
                                <div style="display: flex; flex-direction: row; align-items: center; background: white; margin: 10px 0px;">
                                    <b style="min-width: 80px">Warning 2:</b>
                                    <p style="flex-grow: 2"> Any access to the device will be blocked during the audit process. </p>
                                </div>
                                <div style="display: flex; flex-direction: row; align-items: center; background: white; margin: 10px 0px;">
                                    <b style="min-width: 80px">Warning 3:</b>
                                    <p style="flex-grow: 2"> As consequence, you cannot change the audit configuration after confirming it, unless you restart the device. </p>
                                </div>
                                <div style="display: flex; flex-direction: row; align-items: center; background: white; margin: 10px 0px;">
                                    <b style="min-width: 80px">Warning 4:</b>
                                    <p style="flex-grow: 2"> At the end of the audit, the device will be restarted, and the last audit report will be available. </p>
                                </div>
                                <div style="display: flex; flex-direction: row; align-items: center; background: white; margin: 10px 0px;">
                                    <b style="min-width: 80px">Warning 5:</b>
                                    <p style="flex-grow: 2"> If the device cannot connect to the network, the audit configuration will be discarded. </p>
                                </div>
                            </div>
                        </div>
                ';

                // Buttons
                echo '
                        <div style="padding: 10px 0px; margin: 10px 0px; width: 100%">
                            <form method="post" action="network_redirect">
                                <div style="display:flex; flex-direction:row; align-items: center;">
                                    <input type="submit" name="EDIT_CONFIG" value="Edit Configuration"
                                        style="flex-grow: 1; background-color: #0C2340; color: white;border: 0; border-radius: 5px;padding: 10px 20px; margin: 0px 10px; cursor: pointer ">
                                    <input type="submit" name="START_AUDIT" value="Start Audit"
                                        style="flex-grow: 1; background: lawngreen;border: 0; border-radius: 5px;padding: 10px 20px; margin: 0px 10px; cursor: pointer">
                                </div>
                            </form>
                        </div>
                ';
                echo '</div>';
                echo $_SESSION['entity'];
        ?>
</body>
</html>
