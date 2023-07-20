<?php

        if (!isset($_COOKIE['ENTITY']))
        {
                header('Location: index');
        }

        if (!isset($_POST['delete']))
        {
                header('Location: entity');
        }
        else
        {
                function delete_entity_folder_data($entity)
                {
                        $directory = "/var/www/forensicbox/userspace/" . $entity;
                        $files = glob($directory . '/*');

                        foreach ($files as $file)
                        {
                                if (is_file($file))
                                {
                                        unlink($file);
                                }
                        }

                        rmdir($directory);
                }

                function delete_entity_existance($entity_name)
                {
                        $entities_file = '/var/www/forensicbox/userspace/userspace';
                        $file_content = file_get_contents($entities_file);

                        $entities = explode('|', $file_content);

                        print_r($entities);

                        foreach ($entities as $index => $entity)
                        {
                                $properties = explode(':', $entity);

                                if ($properties[0] === $entity_name)
                                {
                                        unset($entities[$index]);
                                        break;
                                }
                        }

                        print_r($entities);

                        $updated_file_content = implode('|', $entities);

                        print_r($updated_file_content);

                        file_put_contents($entities_file, $updated_file_content);
                }

                function delete_entity($entity)
                {
                        delete_entity_folder_data($entity);
                        delete_entity_existance($entity);
                }

                delete_entity($_COOKIE['ENTITY']);
                setcookie('ENTITY', '', time() - 3600, '/');
                header('Location: index');
        }

?>
