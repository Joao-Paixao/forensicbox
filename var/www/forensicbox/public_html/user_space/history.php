<?php
        if (!isset($_COOKIE['ENTITY']))
        {
            header("Location: index");
        }
?>
<!DOCTYPE html>
<html>
<head>
    <title>History Report - Forensic Box</title>
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
    <?php
        if (isset($_POST['download']))
        {
                $filename = $_POST['filename'];
                header('Content-Description: File Transfer');
                header('Content-Type: application/pdf');
                header('Content-Disposition: attachment; filename="' . $filename . '"');
                header('Content-Length: ' . filesize("/var/www/forensicbox/userspace/" . $_COOKIE['ENTITY'] . "/" . $filename));
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Expires: 0');

                readfile("/var/www/forensicbox/userspace/" . $_COOKIE['ENTITY'] . "/" . $filename);
                exit;
        }

        if (isset($_POST['delete']))
        {
                $filename = $_POST['filename'];
                unlink('/var/www/forensicbox/userspace/' . $_COOKIE['ENTITY'] . '/' . $filename);
        }
    ?>
    <h1>Forensic Box</h1>
    <h4>With this web interface you can configure the Forensic Box to your needs.</h4>
    <div style="height: 100%; width: 100%;background-color: #c1c1c1;display: flex; flex-direction: column; align-items: center;">
        <h2>History Reports</h2>
        <a href="userspace">
                <button
                style="border: 0; border-radius: 5px;padding: 10px 20px; width: 100px; background-color: #0c2340; color: white;margin: 10px 0px;cursor: pointer"
                >
                        Back
                </button>
        </a>
        <div style="background-color: white;padding: 10px 10px; width: 90%">
        <?php
                function has_reports($entity)
                {
                        $reports = scandir("/var/www/forensicbox/userspace/" . $entity);

                        if (count($reports) == 2)
                        {
                                return false;
                        }
                        else
                        {
                                return true;
                        }
                }

                if (has_reports($_COOKIE['ENTITY']))
                {
                        echo '
                                <table style="width: 100%;">
                                        <thead>
                                                <tr>
                                                        <th>Filename</th>
                                                        <th>Date</th>
                                                        <th>Options</th>
                                                </tr>
                                        </thead>
                                        <tbody>
                        ';

                        $reports = scandir("/var/www/forensicbox/userspace/" . $_COOKIE['ENTITY']);

                        $reports = array_diff($reports, array('.', '..'));
                        $directory = '/var/www/forensicbox/userspace/' . $_COOKIE['ENTITY'];

                        usort($reports, function($a, $b) use ($directory) {
                                $fileA = $directory . '/' . $a;
                                $fileB = $directory . '/' . $b;
                                return filemtime($fileB) - filemtime($fileA);
                        });

                        foreach($reports as $report)
                        {
                                if ($report != '.' && $report != '..' )
                                {
                                        $fileinfo = stat("/var/www/forensicbox/userspace/" . $_COOKIE['ENTITY'] . "/" . $report);
                                        $filename = basename("/var/www/forensicbox/userspace/" . $_COOKIE['ENTITY'] . "/" . $report);
                                        $creation_time = date("Y-m-d H:i:s", $fileinfo['ctime']);
                                        echo '<tr>
                                                <td>' . $filename . '</td>
                                                <td>' . $creation_time . '</td>
                                                <td>
                                                        <form method="post">
                                                                <input type="hidden" name="filename" value=' . $filename . '>
                                                                <input type="submit" name="download" value="DOWNLOAD"
                                                                style="border: 0; border-radius: 5px;padding: 10px 0px; width: 100px; background-color: #0c2340; color: white; cursor: pointer">
                                                                <input type="submit" name="delete" value="DELETE"
                                                                style="border : 0; border-radius: 5px; padding: 10px 0px; width: 100px; background-color: #8b0000; color: white; cursor: pointer">
                                                        </form>
                                                </td>
                                        </tr>
                                        ';
                                }
                        }
                }
                else
                {
                        echo "<p>There's no audit reports yet.</p>";
                }
        ?>
        </div>
    </div>
</body>
</html>
