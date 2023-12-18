<?php 
require_once 'OTP.php';
session_start();


if($_SERVER["REQUEST_METHOD"] === "POST"){
  $username = trim($_POST["username"]);
  $email = trim($_POST["email"]);

  $_SESSION["email"] = $email;
  $_SESSION["username"] = $username;
  
  if(empty($username) || empty($email)){
    $error = "Please fill out the all fields.";
  } else {
    if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $qry = "SELECT * FROM users WHERE email = :email";
      $stmt = $pdo->prepare($qry);
      $stmt->bindParam(":email", $email);
      $stmt->execute();
  
      $user = $stmt->fetch(PDO::FETCH_ASSOC);
  
      if(!$user) {
        sendMail($email, $username);
        header("Location: verify-otp.php");
        exit();
      } else {
        $error = "The email you entered already exists!";
    }

    } else {
      
      $error = "Please enter a valid email address.";
   
    }

  }} 
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
  padding: 70px;
  width: 500px;
  border-radius: 2px;
  box-shadow: 2px 2px 20px rgba(0, 0, 0, .05);

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
  transition: all .25s ease-in;
}

form input:nth-child(4):hover {
  background-color: transparent;
  color: black;
}

a{
  color: #7630ff;
  text-decoration: none;
  transition: all .15s ease;
}

a:hover{
  text-decoration: underline;
}
.text1 {
  font-size: 15px;
  margin-left: 5px;
}

.text2 {
  padding: 12px;
  background-color: #ffcccb;
  margin-top: 10px;
  border-radius: 2px;
  text-align: center;
  font-size: 15px;
  color: darkred;
}
</style>
<body>
  <?php
    include 'header.php';
  ?>
  <div class="main">
    <div class="container">
      <form action="" method="POST">
        <h2 style="text-align: center; margin-bottom: 10px" >Register your account</h2>
        <input type="text" name="username" value="" placeholder="Username">
        <input type="text" name="email" value="" placeholder="Email">
        <input type="submit" name="submit" value="Sign Up">
      </form>
      <p class="text1">Already have an account? <a href="index.php">Login here!</a></p>
      <?php
        if(isset($error))
        {
          echo "<p class='text2'>" .$error . "</p>";
        }
      ?>
    </div>
  </div>
  
</body>
</html>