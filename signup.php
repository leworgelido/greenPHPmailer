<?php 
require_once 'OTP.php';
session_start();


if($_SERVER["REQUEST_METHOD"] === "POST"){
  $username = $_POST["username"];
  $email = filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);

  $_SESSION["email"] = $email;
  $_SESSION["username"] = $username;
  
  if(empty($username) || empty($email)){
    $error = "kumpleto dapat lods";
  } else {
    sendMail($email, $username);
    header("Location: verify-otp.php");
    exit();
  }

} 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PHP MAILER</title>
</head>
<style>
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: sans-serif;
  }
  .main {
  background-color: rgb(223, 223, 223);
    height: 100vh;
  }
.container {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  background-color: white;
  padding: 100px;
  width: 500px;
  border-radius: 2px;
  
}

form {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-content: center;
}

form input {
  padding: 14px;
  margin-bottom: 10px;
  border: 1px solid gray;
  border-radius: 2px;
  font-size: 16px;
  outline: none;
}

form input:nth-child(4){
  background-color: #1e1e1e;
  color: white;
  border-radius: 4px;
  cursor: pointer;
  transition: all .15s ease-in;
}

form input:nth-child(4):hover {
  background-color: transparent;
  color: black;
}

a{
  color: rgb(85, 26, 139);
  text-decoration: none;
  transition: all .15s ease;
}

a:hover{
  text-decoration: underline;
}
</style>
<body>
  <div class="main">
    <div class="container">
      <form action="" method="POST">
        <h2 style="text-align: center; margin-bottom: 10px" >Register your account</h2>
        <input type="text" name="username" value="" placeholder="Username">
        <input type="text" name="email" value="" placeholder="Email">
        <input type="submit" name="submit" value="Sign Up">
      </form>
      <p>Have an account? <a href="index.php">Login Here! </a></p>
      <?php
        if(isset($error))
        {
          echo " <strong>" .$error . "</strong>";
        }
      ?>
    </div>
  </div>
  
</body>
</html>