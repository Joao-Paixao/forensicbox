<!DOCTYPE html>
<html>
<head>
    <title>Deauthentication - Forensic Box</title>
</head>
<body>
    <?php
        if (isset($_COOKIE['ENTITY']))
        {
                setcookie('ENTITY', '', time() - 3600, "/");
                setcookie('CONFIRM_CONFIG', '', time() - 3600, "/");
                setcookie('VIA','', time() - 3600, "/");
                setcookie('SSID','', time() - 3600, "/");
                setcookie('PASSWORD','', time() - 3600, "/");
                setcookie('TOOLS','', time() - 3600, "/");
                setcookie('SCHEDULE','', time() - 3600, "/");
                setcookie('DATE','', time() - 3600, "/");
                setcookie('TIME','', time() - 3600, "/");
        }

        header("Location: index.php");
    ?>
</body>
</html>
