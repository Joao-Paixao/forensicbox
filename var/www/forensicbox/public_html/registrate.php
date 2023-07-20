<!DOCTYPE html>
<html>
<head>
    <title>Registration - Forensic Box</title>
</head>
<body>
    <?php
        if (isset($_COOKIE['ENTITY']))
        {
                header("Location: userspace.php");
        }

        if (!isset($_POST['registrate']))
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
                                // Format -> entity:salt:hash

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

        function register_entity($entity, $password)
        {
                $filename = "/var/www/forensicbox/userspace/userspace";
                $file = fopen($filename, "a");

                $salt = dechex(time());
                $hash_password = generate_hash($password, $salt);

                $user = $entity . ":" . $salt . ":" . $hash_password . "|";
                fwrite($file, $user);
                fclose($file);

                mkdir("/var/www/forensicbox/userspace/" . $entity, 0777, true);
        }

        //======================================================================================================================

        $entity = $_POST['entity'];
        $password = $_POST['password'];

        $pattern_entity_valid = '/^([a-zA-Z0-9]{1}[a-zA-Z0-9\-_ ]*)/';
        $pattern_password_valid = '/(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[\@\$\!\%\*\#\?\&\^\.\:\,\;\-_\+\(\)])[a-zA-Z0-9\@\$\!\%\*\#\?\&\^\.\:\,\;\-_\+\(\)]{8,}/';

        if(preg_match($pattern_entity_valid, $entity) && preg_match($pattern_password_valid, $password))
        {
                if(check_if_entity_exists($entity))
                {
                        setcookie('ERROR_ENTITY_EXISTS', '1', time() + 3600, '/');
                }
                else
                {
                        register_entity($entity, $password);
                        setcookie('SUCCESS_REGISTER', '1', time() * 3600, '/');
                }
        }
        else
        {
                setcookie('ERROR_PATTERN', '1', time() + 3600, '/');
        }

        header('Location: index');
    ?>
</body>
</html>
