<?php

// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)
{
  header("location: setup_page_landing.php");
  exit;
}
 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, username, password FROM users WHERE binary username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // Redirect user to welcome page
                            header("location: setup_page_landing.php");
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = "No account found with that username.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    
    
    <meta charset="UTF-8">
    
    
    <title>Login</title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
		<link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="/bootstrap/css/bootstrap.css">
		<script src="/bootstrap/js/bootstrap.min.js"></script>
		<script src="/jquery/jquery-3.5.1.min.js"></script>
        
    
    
    <style >
        
        body
        {
             font: 14px sans-serif; 
             /*background-image: url("/upload/b.png"); */
             backgroud-repeat: repeat;
             background-size: 100px 100px;
             background-color: #fcf9e7;
        }
        
        .wrapper
        {
             width: 350px; 
             padding: 20px; 
        }
        
        div.centrethis
        {
            margin: 0;
            background-color: #162f3e; /*login box*/
            position: absolute;
            top: 50%;
            left: 50%;
            
            transform: translate(-50%,-50%)
        }
        
       
        
        a:hover
        {
            color: black;
            text-shadow: 2px 2px 50px #000000;
            text-decoration: underline;
        }
        
        .boxnshadow
        {
            border: 1px solid;
            padding: 10px;
            background-color: black;
            
            box-shadow:  5px 10px 8px 10px #888888;
        }
        
        </style>
</head>

<body>
    
    <div class ="centrethis boxnshadow">
    
    
    <div class="wrapper">
        <h1 style="color: white; text-align: center" class="centrethis"> Login</h1>
        <p style="color: white; text-align: center">Please fill in your credentials to login.</p>
        
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>" style="color: white">
                <label style="color: white">Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>   
             
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>" style="color: white">
                <label style="color: white">Password</label>
                <input type="password" name="password" class="form-control">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            
            <div class="form-group text-center" >
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            
            <p style="color: white">
                Don't have an account? 
                <a style="color: white" href="register.php">
                    Sign up now
                </a>
            </p>
            
            <p style="color:#ffffff">
                Forgot password?
                <a style="color: white" href="forgot_pwd_ui.php" >
                    Click here
                </a>
            </p>
            
            <p style="color:#ffffff">                
                <a style="color: white" href="admin_login_ui.php" >
                    Admins click here
                </a>
            </p>
            
        </form>
        
        
    </div>    
    
    </div>
</body>



</html><?php //Author: Asesh Basu. Time: December 2020 Topic: For Wireless Queue Management?>

