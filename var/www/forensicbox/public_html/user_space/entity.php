<?php
        if (!isset($_COOKIE['ENTITY']))
        {
            header("Location: index");
        }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Entity Management - Forensic Box</title>
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
    </style>
</head>
<body>
    <h1>Forensic Box</h1>
    <h4>With this web interface you can configure the Forensic Box to your needs.</h4>
    <h2>Entity Management</h2>
    <div style="width: 100%">
        <div style="margin: 10px;">
                <a href="userspace">
                        <button
                        style="border: 0; border-radius: 5px;padding: 10px 20px; width: 120px;cursor: pointer; background-color: #0c2340; color: white;"
                        >Back</button>
                </a>
        </div>
        <div style="margin: 10px;">
                <form method="post" action="change_pass">
                        <input type="submit" name="change_pass" value="Change Password"
                        style="border: 0; border-radius: 5px;padding: 10px 0px; width: 120px;cursor: pointer; background-color: #0c2340; color: white;">
                </form>
        </div>
        <div style="margin: 10px;">
                <form method="post" action="delete">
                        <input type="submit" name="delete_entity" value="Delete Entity"

                        style="border: 0; border-radius: 5px;padding: 10px 20px; width: 120px;background-color: #8B0000;color: white;cursor: pointer">
                </form>
        </div>
    </div>
</body>
</html>
