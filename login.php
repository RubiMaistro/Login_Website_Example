<?php
    // Initialize the session
    session_start();

    // Connect to database
    require_once("connect.php");

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
        if(empty($usernameErr) && empty($passwordErr)){
            // Select statement
            $sql_query = "SELECT id, username, password FROM users WHERE username = :username";

            if($stmt = $pdo->prepare($sql_query)){
                // Bind variables
                $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);

                // Set parameters
                $param_username = trim($_POST['username']);

                if($stmt->execute()){
                    // Check username exist
                    if($stmt->rowCount() == 1){
                        if($row = $stmt->fetch()){
                            $id = $row['id'];
                            $username = $row['username'];
                            $hashed_password = $row['password'];
                            if(password_verify($password, $hashed_password)){
                                // Password is correct, so start a new session
                                session_start();

                                // Save data in session variables
                                $_SESSION["loggedin"] = true;
                                $_SESSION["id"] = $id;
                                $_SESSION["username"] = $username;

                                header("location: welcome.php");
                            }else{
                                // Password is not valid.
                                $loginErr = "Invalid password.";
                            }
                        }
                    }else{
                        // Username doesn't exist in database
                        $loginErr = "Invalid username.";
                    }
                }else{

                    echo "Please try again later.";
                }

                // Close statement
                unset($stmt);
            }
        }

        // Close database connection
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
        <h2>Login</h2>

        <?php 
        if(!empty($loginErr)){ 
            echo '<div>'. $loginErr .'</div>'; 
        }
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <div>
                <label>Username</label>
                <input type="text" name="username" required />
                <?php 
                if(!empty($usernameErr)){ 
                    echo '<div>'. $usernameErr .'</div>'; 
                }
                ?>
            </div>
            <div>
                <label>Password</label>
                <input type="password" name="password" required />
                <?php 
                if(!empty($passwordErr)){ 
                    echo '<div>'. $passwordErr .'</div>'; 
                }
                ?>
            </div>
            <div>
                <input type="submit" name="submitBtn" value="Login" />
            </div>
            <p>Don't have an account? <a href="registration.php">Sign up now</a>.</p>
        </form>
    </div>
</body>
</html>