<?php
session_start();
require_once './includes/connect.php';

if($_SERVER["REQUEST_METHOD"] === "POST") {
  $pwd = trim($_POST["pwd"]);
  $email = trim($_POST["email"]);

  if(empty($email) || empty($pwd)){
    $error = "Please fill out the all fields.";
  } else {

    $qry = "SELECT * FROM users WHERE email = :email";
    $stmt = $pdo->prepare($qry);
    $stmt->bindParam(":email", $email);
    $stmt->execute();  

    $user = $stmt->fetch();

    if(!$user) {
      $error = "Invalid Email or Password!";
    } else {
      $db_pwd = $user["pwd"];
      
      if(password_verify($pwd, $db_pwd)){
        $username = $user["username"];
        $_SESSION["email"]  = $email;
        $_SESSION["username"] = $username;

        header("Location: home.php");
        die();
      } else {
        $error = "Invalid Email or Password!";
        
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

.text2 {
  margin-left: 5px;
  font-size: 15px;
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

.gif-container {
  position: absolute;
  top: 200px;
  right: 50px;

}

.jif {
  width: 300px;
  height: 200px;
  border-radius: 3px;
}

.gif-container2 {
  position: absolute;
  top: 200px;
  left: 50px  ;
}
</style>

<body>
  <?php
    include 'header.php';
  ?>
  <div class="main">
    <div class="container">
    <?php 
          if(isset($_GET["text"])){
            if($_GET["text"] == "success")
            echo "<p class='text'>We've sent an email to login your account.</p>";
          }

          if(isset($_GET["text"])){
            if($_GET["text"] == "mes")
            echo "<p class='text'>We've sent you the password reset link.</p>";
          }

          if(isset($_GET["text"])){
            if($_GET["text"] == "passchange")
            echo "<p class='text'>Successfully changed your password.</p>";
          }
        ?>
      <form action="" method="POST">
        <h2 style="text-align: center; margin-bottom: 10px" >Login your account</h2>
        <input type="text" name="email" value="" placeholder="Email">
        <input type="password" name="pwd" value="" placeholder="Password">
        <input class="btn" type="submit" name="submit" value="Sign in">
      </form>
      <p class="text1"><a href="forgot-pass.php">Forgot your Password?</a></p>
      <p class="text2">Don't have an account? <a href="signup.php">Register here!</a></p>
      <?php 
          if(isset($error)){
            echo "<p class='error'>" . $error . "</p>";
          }
        ?>
    </div>
    
  </div>
    <?php
      if(isset($error)){
    ?>
      <div class="gif-container">
        <img class="jif" src="./pic//meme-1.gif" alt="">
      </div>

      <div class="gif-container2">
        <img class="jif" src="./pic//meme-2.gif" alt="">
      </div>
      <?php
        }
      ?>
</body>
</html>