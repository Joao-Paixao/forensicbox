<!DOCTYPE html>
<html>
<head>
    <title>Authentication - Forensic Box</title>
</head>
<body>
    <?php
        if (isset($_COOKIE['ENTITY']))
        {
                header("Location: userspace.php");
        }

        if (!isset($_POST['authenticate']))
        {
                header("Location: index");
        }

        function check_if_entity_exists($entity)
        {
                $filename = "/var/www/forensicbox/userspace/userspace";
                $file = fopen($filename, "r");

                while (!feof($file))
                {
                        $content = fgets($file);
                        $users = explode("|", $content);

                        foreach ($users as $user)
                        {
                                $properties = explode(":", $user);
                                if ($properties[0] == $entity)
                                {
                                        fclose($file);
                                        return true;
                                }
                        }
                }
                fclose($file);
                return false;
        }

        function generate_hash($password, $salt)
        {
                return hash("sha256", $password . $salt);
        }

        function validate_password($entity, $password)
        {
                $filename = "/var/www/forensicbox/userspace/userspace";
                $file = fopen($filename, "r");

                while (!feof($file))
                {
                        $content = fgets($file);
                        $users = explode("|", $content);

                        foreach ($users as $user)
                        {

                                $properties = explode(":", $user);
                                if ($properties[0] == $entity)
                                {
                                        $salt = $properties[1];
                                        $hash_password = $properties[2];

                                        if (generate_hash($password, $salt) == $hash_password)
                                        {
                                                fclose($file);
                                                return true;
                                        }
                                }
                        }
                }
                fclose($file);
                return false;
        }

        $entity = $_POST['entity'];
        $password = $_POST['password'];

        $pattern_entity_valid = '/^([a-zA-Z0-9]{1}[a-zA-Z0-9\-_ ]*)/';
        $pattern_password_valid = '/(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[\@\$\!\%\*\#\?\&\^\.\:\,\;\-_\+\(\)])[a-zA-Z0-9\@\$\!\%\*\#\?\&\^\.\:\,\;\-_\+\(\)]{8,}/';

        if (preg_match($pattern_entity_valid, $entity) && preg_match($pattern_password_valid, $password))
        {
                if (check_if_entity_exists($entity))
                {
                        if (validate_password($entity, $password))
                        {
                                setcookie('ENTITY', $entity, time() + 3600, '/');
                        }
                        else
                        {
                                setcookie('ERROR_AUTH', '1', time() + 3600, '/');
                        }
                }
                else
                {
                        setcookie('ERROR_AUTH', '1', time() + 3600, '/');
                }
        }
        else
        {
                setcookie('ERROR_AUTH_PATTERN', '1', time() + 3600, '/');
        }
        header('Location: index');
    ?>
</body>
</html>
