<?php
session_start();
require_once 'OTP.php';

$username = $_SESSION["username"];
$email = $_SESSION["email"];
$OTP = $_SESSION["OTP"];

if($_SERVER["REQUEST_METHOD"] === "POST"){
  $userOTP = $_POST["otpCode"];
  
  if(empty($userOTP)){
    $error = "Please enter your OTP code.";
  } else {
    if($OTP == $userOTP) {
    
    
      sendVerificationEmail($email, $username);
      $Generated_pass = isset($_SESSION["pass"]) ? trim($_SESSION["pass"]) : '';
      insertUser($pdo, $email, $username, $Generated_pass);
      unset($Generated_pass);
      unset($_SESSION["OTP"]);
      header("Location: index.php?text=success");
      exit();
      
  
    } else{
      
      $error = "You entered the wrong OTP. Please check your email and correct it.";
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

form input:nth-child(3){
  background-color: #1e1e1e;
  color: white;
  border-radius: 4px;
  cursor: pointer;
  transition: all .25s ease-in-out;
}

form input:nth-child(3):hover {
  background-color: transparent;
  color: black;
}
a {
  color: #7630ff;
  text-decoration: none;
  transition: all .15s ease;
}

a:hover{
  text-decoration: underline;
}

.text {
  font-size: 16px;
  margin-bottom: 20px;
  text-align: center;
  
}

.text span {
  font-weight: 700;
}

.text1 {
  padding: 12px;
  background-color: #ffcccb;
  margin-top: 10px;
  border-radius: 2px;
  text-align: center;
  font-size: 15px;
  color: darkred;
}

.text2  {
  margin-left: 5px;
  font-size: 15px;
  margin-bottom: 5px;
}
</style>
<body>
  <div class="main">
    <div class="container">
      <form action="" method="POST">
        <p class="text">We've sent the OTP to <span><?php echo htmlspecialchars($email);?></span></p>
        <input type="text" name="otpCode" value="" placeholder="Enter OTP" maxlength="6">
        <input type="submit" name="submit" value="Submit">
      </form>
      <p class="text2">Back to <a href="index.php">Login</a></p>
      <?php 
        if(isset($error)){
          echo "<p class='text1'>" . $error . "</p>";
        }
      ?>
    </div>
  </div>
  
</body>
</html>