<?php
session_start();
require_once './includes/connect.php';

if($_SERVER["REQUEST_METHOD"] === "POST") {
  $pwd = trim($_POST["pwd"]);
  $email = trim($_POST["email"]);

  if(empty($email) || empty($pwd)){
    $error = "kumpletuhin mo laman idol, tnx";
  } else {

    $qry = "SELECT * FROM users WHERE email = :email";
    $stmt = $pdo->prepare($qry);
    $stmt->bindParam(":email", $email);
    $stmt->execute();  

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if(!$user) {
      $error = "Invalid email or password";
    } else {
      $db_pwd = $user["pwd"];
      $email = $user["email"];
      $username = $user["username"];

      if($db_pwd === $pwd){
        $_SESSION["email"]  = $email;
        $_SESSION["username"] = $username;
        header("Location: home.php");
        exit();
      } else {
        $error = "mali pass";
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