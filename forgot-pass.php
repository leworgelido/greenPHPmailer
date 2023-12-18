<?php
session_start();
require_once './includes/connect.php';
require_once 'OTP.php';

if($_SERVER["REQUEST_METHOD"] === "POST") {
  
  $email = trim($_POST["email"]);

  if(empty($email)) {

    $error = "Please enter your email address.";

  } else {

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){

      $error = "Please enter a valid email address.";

    } else {

      $qry = "SELECT * FROM users WHERE email = :email";
      $stmt = $pdo->prepare($qry);
      $stmt->bindParam(":email", $email);
      $stmt->execute();
  
      $user = $stmt->fetch(PDO::FETCH_ASSOC);
  
      if($user) {

        $token = random_bytes(8);
        $hex_token = bin2hex($token);
        date_default_timezone_set("Asia/Manila");
        $exp_resetpass = date("y/m/d H:i:s", time() + 60 * 30);


        sendResetPassword($email, $hex_token);

        $hash_token = password_hash($token, PASSWORD_DEFAULT);

        updateToken($pdo, $email, $hash_token, $exp_resetpass);

        header("location: index.php?text=mes");
        
      } else {
        $error = "The email you entered does not exists!";

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

form .btn{
  background-color: #1e1e1e;
  color: white;
  border-radius: 4px;
  cursor: pointer;
  transition: all .25s ease-in;
}

form .btn:hover {
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
  background-color: #90ee90;
  border: none;
  padding: 14px;
  border-radius: 2px;
  text-align: center;
  margin-bottom: 10px;
  font-size: 15px;
  color: darkgreen;
}

.text1  {
  margin-left: 5px;
  font-size: 15px;
  margin-bottom: 5px;
}


.error {
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
        <h2 style="text-align: center; margin-bottom: 10px" >Forgot password?</h2>
        <input type="text" name="email" value="" placeholder="Email">
        <input class="btn" type="submit" name="submit" value="Reset">
      </form>
      <p class="text1">Back to <a href="index.php">Login</a></p>
      <?php 
          if(isset($error)){
            echo "<p class='error'>" . $error . "</p>";
          }
        ?>
    </div>
  </div>
  
</body>
</html>