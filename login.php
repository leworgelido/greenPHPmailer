<?php
session_start();
require_once 'OTP.php';
require_once './includes/connect.php';

if($_SERVER["REQUEST_METHOD"] === "POST") {

  $Generated_pass = isset($_SESSION["pass"]) ? trim($_SESSION["pass"]) : '';
  $email_verify = isset($_SESSION["email-verify"]) ? trim($_SESSION["email-verify"]) : '';

  $email = $_POST["email"];
  $password = $_POST["pwd"];
  $username = $_SESSION["username"];
  
  if(empty($email) || empty($password)) {
    $error = "kumpletuhin mo lods";
  } else {
    if($email != $email_verify) {
      $error = "your email is wrong";
  
    } else {
      if($password != $Generated_pass) {
        $error = "your password is wrong.";
      } else {

          insertUser($pdo, $email, $username, $Generated_pass);
          unset($Generated_pass);
          header("location: home.php");
          $_SESSION["email"] = $_POST["email"];
          exit();
        }
       
      }
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
  padding: 70px;
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

form .btn{
  background-color: #1e1e1e;
  color: white;
  border-radius: 4px;
  cursor: pointer;
  transition: all .15s ease-in;
}

form .btn:hover {
  background-color: transparent;
  color: black;
}
a {
  color: rgb(85, 26, 139);
  text-decoration: none;
  transition: all .15s ease;
}

a:hover{
  text-decoration: underline;
}

.text {
  background-color: lightgreen;
  border: 1px solid green;
  padding: 7px;
  border-radius: 2px;
  text-align: center;
  margin-bottom: 10px;
}
</style>
<body>
  <div class="main">
    <div class="container">
      <form action="" method="POST">
      <?php
          if(isset($_GET["text"])) {
            
            echo "<div class='text'>" .$_GET['text'].  "</div>";
          }
      ?>
        <h2 style="text-align: center; margin-bottom: 10px" >Login your account</h2>
        <input type="text" name="email" value="" placeholder="Email">
        <input type="password" name="pwd" value="" placeholder="Password">
        <input class="btn" type="submit" name="submit" value="Log in">
      </form>
      <p>Don't have an account? <a href="signup.php">Register Here! </a></p>
        <?php 
          if(isset($error)){
            echo "<p style='text-align: center; padding: 7px; color:#ff0033;'>" . $error ."</p>";
          }
        ?>
    </div>
  </div>
  
</body>
</html>