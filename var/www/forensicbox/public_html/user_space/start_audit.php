<?php
        if (!isset($_COOKIE['START_AUDIT']))
        {
                header('Location: userspace');
        }

        echo '-connection ' . $_COOKIE['VIA'] . '<br>';
        echo '-ssid ' . $_COOKIE['SSID'] . '<br>';
        echo '-pass ' . $_COOKIE['PASSWORD'] . '<br>';
        foreach((unserialize($_COOKIE['TOOLS'])) as $tool)
        {
                if($tool == 1)
                {
                        echo '-nmap  1' . '<br>';
                }

                if($tool == 2)
                {
                        echo '-zap 1' . '<br>';
                }
        }

        echo '-schedule ' . $_COOKIE['SCHEDULE'] . '<br>';
        echo '-date ' . $_COOKIE['DATE'] . '<br>';
        echo '-time ' . $_COOKIE['TIME'] . '<br>';

        $file = fopen('/home/audit/ForensicBox/outputs/audit.conf', 'w');
        fwrite($file, '-entity ' . $_COOKIE['ENTITY'] . PHP_EOL);
        fwrite($file, '-connection ' . $_COOKIE['VIA'] . PHP_EOL);
        fwrite($file, '-ssid ' . $_COOKIE['SSID'] . PHP_EOL);
        fwrite($file, '-pass ' . $_COOKIE['PASSWORD'] . PHP_EOL);
        foreach((unserialize($_COOKIE['TOOLS'])) as $tool)
        {
                if($tool == 1)
                {
                        fwrite($file, '-nmap 1' . PHP_EOL);
                }

                if($tool == 2)
                {
                        fwrite($file, '-zap 1' . PHP_EOL);
                }
        }
        fwrite($file, '-schedule ' . $_COOKIE['SCHEDULE'] . PHP_EOL);
        fwrite($file, '-date ' . $_COOKIE['DATE'] . PHP_EOL);
        fwrite($file, '-time ' . $_COOKIE['TIME'] . PHP_EOL);
        fclose($file);

        exec('sudo /home/audit/ForensicBox/scripts/audit/init.sh', $output, $return_code);
        echo $return_code;
        echo 'SUCCESSO';
?>
