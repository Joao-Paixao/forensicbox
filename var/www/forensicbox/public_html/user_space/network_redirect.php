<?php
        if (isset($_POST['BACK']))
        {
                header("Location: userspace");
        }
        else if (isset($_POST['RESET']))
        {
                setcookie('CONFIRM_CONFIG', '', time() - 3600, "/");
                setcookie('VIA', '', time() - 3600, "/");
                setcookie('SSID', '', time() - 3600, "/");
                setcookie('PASSWORD', '', time() - 3600, "/");
                setcookie('TOOLS', '', time() - 3600, "/");
                setcookie('SCHEDULE', '', time() - 3600, "/");
                setcookie('DATE', '', time() - 3600, "/");
                setcookie('TIME', '', time() - 3600, "/");
                header("Location: network");
        }
        else if (isset($_POST['CONFIRM']))
        {
                setcookie('CONFIRM_CONFIG', '1', time() + 3600, "/");
                setcookie('VIA', $_POST['via'], time() + 3600, "/");
                setcookie('SSID', $_POST['ssid'], time() + 3600, "/");
                setcookie('PASSWORD', $_POST['password'], time() + 3600, "/");
                $tools = serialize($_POST['tools']);
                setcookie('TOOLS', $tools, time() + 3600, "/");
                setcookie('SCHEDULE', $_POST['schedule'], time() + 3600, "/");
                setcookie('DATE', $_POST['date'], time() + 3600, "/");
                setcookie('TIME', $_POST['time'], time() + 3600, "/");
                header("Location: network_confirm");
        }
        else if (isset($_POST['EDIT_CONFIG']))
        {
                header("Location: network");
        }
        else if (isset($_POST['START_AUDIT']))
        {
                setcookie('START_AUDIT', '1', time() + 3600, '/');
                header("Location: start_audit");
        }
        else
        {
                header('Location: network');
        }
?>
