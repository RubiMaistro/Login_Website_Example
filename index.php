<?php
    // Initialize the session
    session_start();

    // Define variables and initialize with empty values
    $username = $password = "";
    $usernameErr = $passwordErr = $loginErr = "";

    // Processing form data when form is submitted
    if($_SERVER["REQUEST_METHOD"] == "POST"){

        // Check if username is empty
        if(empty(trim($_POST['username']))){
            $usernameErr = "Please enter your username.";
        }else{
            $username = $_POST['username'];
            $_SESSION["username"] = $username;
        }

        // Check if password is empty
        if(empty(trim($_POST['password']))){
            $passwordErr = "Please enter your password.";
        }else{
            $password = $_POST['password'];
        }

        // TEMPORARY WHILE NO HAVE DATABASE CONNECTION
        if(isset($_POST['username']) && isset($_POST['password']) && !empty($_POST['username']) && !empty($_POST['password'])){
            header("location: welcome.php");
            exit;
        }

    }

?>
<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet">
</head>
<body>
    <div>
        <h2>Login</h2>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <div>
                <label>Username</label>
                <input type="text" name="username" required />
            </div>
            <div>
                <label>Password</label>
                <input type="password" name="password" required />
            </div>
            <div>
                <input type="submit" name="submitBtn" value="Login" />
            </div>
            <p>Don't have an account? <a href="">Sign up now</a>.</p>
        </form>
    </div>
</body>
</html>