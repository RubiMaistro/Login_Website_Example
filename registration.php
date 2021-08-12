<?php
    // Initialize the session
    session_start();

    // Connect to database
    require_once("connect.php");

    // Define variables and initialize with empty values
    $username = $password = $confirm_password = "";
    $usernameErr = $passwordErr = $confirm_passwordErr = "";

    // Processing form data when form is submitted
    if($_SERVER["REQUEST_METHOD"] == "POST"){

        // Validate username 
        if(empty(trim($_POST['username']))){
            $usernameErr = "Please enter your username.";
        }elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST['username'])) && strlen(trim($_POST['username'])) < 4 && strlen(trim($_POST['username'])) > 50){
           $usernameErr = "Username lenght must be 4-50 character and only contains letter, numbers and underscores.";
        }else{
            // Prepare a select statement
            $sql_query = "SELECT id FROM users WHERE username = :username";

            if($stmt = $pdo->prepare($sql_query)){
                // Bind variables
                $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);

                // Set parameter
                $param_username = trim($_POST['username']);

                // Attempt to execute the prepared statement
                if($stmt->execute()){
                    if($stmt->rowCount() == 1){
                        $usernameErr = "This username is already taken.";
                    }else{
                        $username = trim($_POST['username']);
                    }
                }else{
                    echo "Please try again later.";
                }
                // Close statement
                unset($stmt);
            }
        }

        // Validate password 
        if(empty(trim($_POST['password']))){
            $passwordErr = "Please enter your password.";
        }elseif(!preg_match('/^[a-zA-Z0-9_?!-+=*]$/', trim($_POST['password'])) && strlen(trim($_POST['password'])) < 6 && strlen(trim($_POST['password'])) > 50){
            $passwordErr = "Password lenght must be 4-50 character and only contains letter, numbers and _, ?, !, -, +, =, * characters.";
        }else{
            $password = trim($_POST['password']);
        }

        // Validate confirm password
        if(empty(trim($_POST['confirm_password']))){
            $confirm_passwordErr = "Please confirm password.";
        }else{
            $confirm_password = trim($_POST['confirm_password']);
            if(empty($passwordErr) && ($password != $confirm_password)){
                $confirm_passwordErr = "Password did not match.";
            }
        }

        // Check input errors before inserting database
        if(empty($usernameErr) && empty($passwordErr) && empty($confirm_passwordErr)){

            // Prepare an insert statement
            $sql_query = "INSERT INTO users (username, password) VALUES (:username, :password)";

            if($stmt = $pdo->prepare($sql_query)){
                // Bind variables
                $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
                $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);

                //Set parameters
                $param_username = $username;
                $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

                if($stmt->execute()){
                    header("location: login.php");
                }else{
                    echo "Please try again later.";
                }

                // Close statement
                unset($stmt);
            }
        }

        // Close connection with database
        unset($pdo);
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
        <h2>Registration</h2>
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
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" required />
            </div>
            <div>
                <input type="submit" name="submitBtn" value="Register" />
            </div>
        </form>
    </div>
</body>
</html>