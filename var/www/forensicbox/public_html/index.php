<?php
        // Validate User
        if (isset($_COOKIE['ENTITY']))
        {
                header("Location: userspace.php");
        }

        // Register COOKIES
        if (isset($_COOKIE['ERROR_ENTITY_EXISTS']))
                setcookie('ERROR_ENTITY_EXISTS', '', time() - 3600, '/');

        if (isset($_COOKIE['ERROR_PATTERN']))
                setcookie('ERROR_PATTERN', '', time() - 3600, '/');

        if (isset($_COOKIE['SUCCESS_REGISTER']))
                setcookie('SUCCESS_REGISTER', '', time() - 3600, '/');

        // Authenticater COOKIES
        if (isset($_COOKIE['ERROR_AUTH']))
                setcookie('ERROR_AUTH', '', time() - 3600, '/');

        if (isset($_COOKIE['ERROR_AUTH_PATTERN']))
                setcookie('ERROR_AUTH_PATTERN', '', time() - 3600, '/');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Index - Forensic Box</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <style>
    body {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        margin: 0;
        padding: 0px 0px 10px 0px;
    }

    .userspace {
        display: flex;
        flex-direction: column;
        align-items: center;
        background-color: #c1c1c1;
        padding: 10px 30px;
        border-radius: 15px;
    }

    .authentication, .registration {
        display: flex;
        flex-direction: column;
        align-items: center;
        background-color: #fff;
        width: 100%;
        padding: 10px;
        margin: 10px 0px;
        border-radius: 15px;
        box-shadow: 3px 3px 5px black;
    }

    .info {
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 100%;
        background-color: #C6D1E0;
        margin: 10px 0px;
        border-radius: 15px;
    }

    .info p {
        margin: 10px 0px;
        padding: 0px 10px;
    }

    .error {
        display: flex;
        flex-direction: column;
        align-items: center;
        background-color: #ff0000;
        margin: 10px;
        padding: 0px 10px;
    }

    .error p {
        margin: 0px;
        padding: 0px;
        color: #fff;
    }

    .button {
        padding: 10px;
        background-color: #192b5e;
        color: #fff;
        border: none;
        text-align: center;
        text-decoration: none;
        font-size: 14px;
        cursor: pointer;
        border-radius: 5px;
    }

    .button:hover {
        background-color: #45a049;
    }

    .button:active {
        background-color: #3e8e41;
    }

    input{
        width: 100%;
        padding: 10px;
        margin: 5px 0px;
        border: 2px solid #ccc;
        border-radius: 4px;
        background-color: #fff;
    }

    </style>
</head>
<body>
    <h1>Forensic Box</h1>
    <h4>With this web interface you can configure the Forensic Box to your needs.</h4>
    <h2> Userspace </h2>
    <div class="userspace">
        <div class="authentication">
            <h3>Authenticate</h3>
            <form action="authenticate" method="post">
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <input type="text" name="entity" placeholder="Type the name of the Entity" style="margin: 5px;"
                        pattern="^([a-zA-Z0-9]{1}[a-zA-Z0-9\-_ ]*)" title="The name should only contain letters, numbers, hyphens (-), underscores (_), or spaces, and should not start with a special character!" required>
                    <input type="password" name="password" placeholder="Password" required style="margin: 5px;"
                        pattern="(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[\@\$\!\%\*\#\?\&\^\.\:\,\;\-_\+\(\)])[a-zA-Z0-9\@\$\!\%\*\#\?\&\^\.\:\,\;\-_\+\(\)]{8,}"
                        title="Must contain at least 8 characters, including 1 uppercase letter, 1 lowercase letter, 1 digit, and 1 special character @$!%*#&^.:,;-_=*() .">
                    <input type="submit" name="authentication" class="button" value="Authenticate" style="margin: 5px;">
                </div>
            </form>
            <?php
                if (isset($_COOKIE['ERROR_AUTH']))
                {
                    echo "
                        <div class='error'>
                            <p>An error occured. Some of the information you provided is incorrect.</p>
                        </div>
                    ";
                }

                if (isset($_COOKIE['ERROR_AUTH_PATTERN']))
                {
                        echo "
                                <div> class='error'>
                                        <p>Invalid input pattern</p>
                                </div>
                        ";
                }
            ?>
        </div>
        <div class="registration">
            <h3>Register</h3>
            <div class="info">
                <p>Register your userspace to be able to configure the Forensic Box to your needs.</p>
                <p>You will need to remember your password to be able to see the report of your network audit.</p>
            </div>
            <form action="registrate" method="post">
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <input type="text" name="entity" placeholder="Type the name of the Entity"style="margin: 5px;"
                        pattern="^([a-zA-Z0-9]{1}[a-zA-Z0-9\-_ ]*)"
                        title="The name should only contain letters, numbers, hyphens (-), underscores (_), or spaces, and should not start with a special character!"
                        required >
                    <input type="password" name="password" placeholder="Password" style="margin: 5px;"
                        pattern="(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[\@\$\!\%\*\#\?\&\^\.\:\,\;\-_\+\(\)])[a-zA-Z0-9\@\$\!\%\*\#\?\&\^\.\:\,\;\-_\+\(\)]{8,}"
                        title="Must contain at least 8 characters, including 1 uppercase letter, 1 lowercase letter, 1 digit, and 1 special character @$!%*#?&^.:,;-_=+() ."
                        required >
                    <input type="submit" name="registration" class="button" value="Register" style="margin: 5px;">
                </div>
            </form>
            <?php
                if (isset($_COOKIE['ERROR_ENTITY_EXISTS']))
                {
                        echo "
                                <div class='error'>
                                        <p>Entity already registered</p>
                                </div>
                        ";
                }

                if (isset($_COOKIE['ERROR_PATTERN']))
                {
                        echo "
                                <div class='error'>
                                        <p>Invalid input pattern</p>
                                </div>
                        ";
                }

                if (isset($_COOKIE['SUCCESS_REGISTER']))
                {
                        echo "
                                <div class='info'>
                                <p>You are registered. You can now authenticate.</p>
                                </div>
                        ";
                }
           ?>
        </div>
    </div>
</body>
</html>
