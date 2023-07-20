<?php
        if (!isset($_COOKIE['ENTITY']))
        {
            header("Location: index");
        }

        if (isset($_COOKIE['SUCCESS']))
        {
                setcookie('SUCCESS', '', time() - 3600, "/");
        }

        if (isset($_COOKIE['FAIL']))
        {
                setcookie('FAIL', '', time() - 3600, "/");
        }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Delete Entity - Forensic Box</title>
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
        .info {
                display: flex;
                flex-direction: column;
                align-items: center;
                background-color: #ff0000;
                margin: 10px;
                border-radius: 5px;
                color: white;
                padding: 10px;
        }

        button, input[type="submit"] {
                border: 0;
                border-radius: 5px;
                padding: 10px 0px;
                width: 120px;
                cursor: pointer;
                background-color: #0c2340;
                color: white;
        }

        input[type="submit"] {
                margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <h1>Forensic Box</h1>
    <h4>With this web interface you can configure the Forensic Box to your needs.</h4>
    <h2>Delete Entity</h2>
    <div style="width: 100%">
        <p class="info">By deleting the entity account, you are aware that will erase all of your data permanently,
        <br>
        including any audit reports left associate to your account.</p>
        <form method="post" action="delete_confirm">
                <input type="submit" name="delete" value="Delete" style="background-color: #8b0000">
        </form>
        <a href="entity">
                <button>Back</button>
        </a>
    </div>
</body>
</html>
