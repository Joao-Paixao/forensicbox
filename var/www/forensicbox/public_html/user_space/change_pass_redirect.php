<?php
        if(!isset($_COOKIE['ENTITY']))
        {
                header("Location: index");
        }

        if(isset($_POST['back']))
        {
                header("Location: entity");
        }

        if(isset($_POST['update']))
        {
                function generate_hash($password, $salt){
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

                function change_password($target_entity, $password)
                {
                        $content = file_get_contents("/var/www/forensicbox/userspace/userspace");

                        $entity_records = explode("|", $content);

                        foreach($entity_records as $record_key => $record_value)
                        {
                                list($entity,$salt, $hash) = explode(":", $record_value);

                                if ($entity = $target_entity)
                                {
                                        $salt = dechex(time());
                                        $hash = generate_hash($password, $salt);

                                        $entity_records[$record_key] = $entity . ":" . $salt . ":" . $hash;
                                        break;
                                }
                        }

                        $updated_content = implode("|", $entity_records);

                        file_put_contents("/var/www/forensicbox/userspace/userspace", $updated_content);
                }

                $actual = $_POST['actual_password'];
                $new = $_POST['new_password'];

                if(validate_password($_COOKIE['ENTITY'], $actual))
                {
                        change_password($_COOKIE['ENTITY'], $new);
                        setcookie('SUCCESS', '1', time() + 3600, "/");
                }
                else
                {
                        setcookie('FAIL', '1', time() + 3600, "/");
                }

                header("Location: change_pass");
        }
        else
        {
                header("Location: entity");
        }
?>
