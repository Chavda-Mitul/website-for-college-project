<?php
//This script will handle login
session_start();

// check if the user is already logged in
if(isset($_SESSION['username']))
{
    // header("location: welcome.php");
    header("location: /College-Project/html/index.html");
    exit;
}
require_once "config.php";

$username = $password = "";
$err = ""; 

// if request method is post
if ($_SERVER['REQUEST_METHOD'] == "POST"){
    if(empty(trim($_POST['username'])) || empty(trim($_POST['password'])))
    {
        $err = "Please enter username + password";
    }
    else{
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
    }


if(empty($err))
{
    $sql = "SELECT id, username, password FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $param_username);
    $param_username = $username;
    
    
    // Try to execute this statement
    if(mysqli_stmt_execute($stmt)){
        mysqli_stmt_store_result($stmt);
        if(mysqli_stmt_num_rows($stmt) == 1)
                {
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt))
                    {
                        if(password_verify($password, $hashed_password))
                        {
                            // this means the password is corrct. Allow user to login
                            session_start();
                            $_SESSION["username"] = $username;
                            $_SESSION["id"] = $id;
                            $_SESSION["loggedin"] = true;

                            //Redirect user to welcome page
                            // header("location: welcome.php");
                            header("location: /College-Project/html/index.html");
                            
                        }
                    }

                }

    }
}    


}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logi-NGO</title>
    <link rel="stylesheet" href="/College-Project/CSS/main.css">
</head>
<body>
    <div class="loginbox">
        <img src="/College-Project/Images/LoginIconAppl.png" alt="#" class = "avatar">
        <h1>Login Here</h1>
        <form action="" method="post">
            <p>Username</p>
            <input type="text" name="username" placeholder = "Enter Username">
            <p>Password</p>
            <input type="password" name = "password" placeholder = "Enter Password">
            <!-- <input type="submit"  value="Login here" class="login-btn"> -->
            <button type="submit" class="btn btn-primary">Submit</button><br>
            <a href="#" >Forgot Password?</a><br>
            <a href="register.php" >Don't have account?</a><br>
            
            
        </form>
    </div>
</body>
</html>