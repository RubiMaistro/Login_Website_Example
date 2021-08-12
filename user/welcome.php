<?php
    // Initialize the session
    session_start();

    echo "WELCOME";
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="">
</head>
<body>
    <div>
        <h1>Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to my website!</h1>
        <p>
            <a href="">Reset password</a>
            <a href="">Log out</a>
        </p>
    </div>
</body>
</html>