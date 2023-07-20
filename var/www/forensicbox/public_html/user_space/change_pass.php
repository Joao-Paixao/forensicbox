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
    <title>Change Password Entity - Forensic Box</title>
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
                background-color: #C6D1E0;
                margin: 10px;
                border-radius: 5px;
        }

        .error {
                display: flex;
                flex-direction: column;
                align-items: center;
                background-color: #ff0000;
                margin: 10px;
                border-radius: 5px;
        }

        .error p {
                color: #fff;
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
    <h2>Change Password Entity</h2>
    <div style="width: 100%">
        <form method="post" action="change_pass_redirect">
                <label for="actual_password">Actual Password</label>
                <input type="text" id="actual_password" name="actual_password" required
                pattern="(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[\@\$\!\%\*\#\?\&\^\.\:\,\;\-_\+\(\)])[a-zA-Z0-9\@\$\!\%\*\#\?\&\^\.\:\,\;\-_\+\(\)]{8,}"
                title="At least 8 characters, including 1 uppercase letter, 1 lowercase letter, 1 digit, and 1 special character.">
                <br>
                <br>
                <label for="new_password">New Password</label>
                <input type="text" id="new_password" name="new_password" required
                pattern="(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[\@\$\!\%\*\#\?\&\^\.\:\,\;\-_\+\(\)])[a-zA-Z0-9\@\$\!\%\*\#\?\&\^\.\:\,\;\-_\+\(\)]{8,}"
                title="At least 8 characters, including 1 uppercase letter, 1 lowercase letter, 1 digit, and 1 special character.">
                <br>
                <br>
                <input type="submit" name="update" value="Update">
                <?php
                        if(isset($_COOKIE['SUCCESS']))
                        {
                                echo "
                                <div class='info'>
                                        <p>Password changed successfully!</p>
                                </div>
                                ";
                        }
                        if(isset($_COOKIE['FAIL']))
                        {
                                echo "
                                <div class='error'>
                                        <p>Password doesn't match!</p>
                                </div>
                                ";
                        }
                ?>
        </form>
        <a href="entity">
                <button>Back</button>
        </a>
    </div>
</body>
</html>
