<?php
        if (!isset($_COOKIE['ENTITY']))
        {
                header("Location: index");
        }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Userspace - Forensic Box</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <style>
        html { height: 100%; }
        body {
                display: flex;
                flex-direction: column;
                align-items: center;
                text-align: center;
                margin: 0;
                height: 100%;
        }

        .options {
                display: flex;
                flex-direction: column;
                justify-content: space-evenly;
                align-items: center;
                height: 100%;
                width: 100%;
        }

        .option {
                background-color: #c1c1c1;
                padding: 14px 0px;
                width: 100%;
                max-width: 400px;
        }

        .option_button {
                background-color: #0c2340;
                color: white;
                border: none;
                padding: 10px 20px;
                border-radius: 5px;
                cursor: pointer;
        }

        .deauth_button {
                background-color: #8B0000;
                color: white;
                border: none;
                padding: 10px 20px;
                border-radius: 5px;
                cursor: pointer;
        }
    </style>
</head>
<body>
    <h1>Forensic Box</h1>
    <h4>With this web interface you can configure the Forensic Box to your needs.</h4>
    <div class="options">
        <div class="option">
            <h2>Entity Management</h2>
            <p>Here you can manage your entity settings.</p>
            <span>
                <a href="deauthenticate" style="text-decoration: none">
                        <button class="deauth_button">Deauthenticate</button>
                </a>
            </span>
            <span>
                <a href="user_space/entity">
                        <button class="option_button">Manage Entity</button>
                </a>
            </span>
        </div>
        <div class="option">
            <h2>Report History</h2>
            <p>Here you can view the history of audit reports.</p>
            <a href="user_space/history">
                <button class="option_button">View History</button>
            </a>
        </div>
        <div class="option">
            <h2>Network Audit Options</h2>
            <p>Here you can configure the network audit options.</p>
            <a href="user_space/network">
                <button class="option_button">Configure Network Audit</button>
            </a>
        </div>
    </div>
</body>
</html>
