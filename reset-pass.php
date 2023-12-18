<?php
  session_start();
  require_once './includes/connect.php';

  if($_SERVER["REQUEST_METHOD"] === "POST"){
    $new_pwd = $_POST["new_pwd"];
    $con_new_pwd = $_POST["confirm_new_pwd"];

    $hex_token = $_GET["code"];
    $bin_token = hex2bin($hex_token);
    $email = $_SESSION["email-verify"];
    
    if(empty($new_pwd) || empty($con_new_pwd)){
      $error = "Please fill out the all fields.";
    } else {
      if($new_pwd !== $con_new_pwd){
        $error = "Your new password and confirm password do not match!";
      } else {

        $qry = "SELECT * FROM users WHERE email = :email";
        $stmt = $pdo->prepare($qry);
        $stmt->bindParam(":email", $email);
        $stmt->execute();  

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach($results as $row){
            $token = $row["hash_token"];
        }

        if(!password_verify($bin_token, $token)){
          $error = "There was an error!";
        } else {
          $token_null = null;
          $exp_null = null;
  
          $hash_pwd = password_hash($new_pwd, PASSWORD_DEFAULT);

          $qry = "UPDATE users SET pwd = :pwd, hash_token = :hash_token, exp_resetpass = :exp_resetpass WHERE email = :email";
          $stmt = $pdo->prepare($qry);
          $stmt->bindParam(":pwd", $hash_pwd);
          $stmt->bindParam(":hash_token", $token_null);
          $stmt->bindParam(":exp_resetpass", $exp_null);
          $stmt->bindParam(":email", $email);
          $stmt->execute();
          
          header("Location: index.php?text=passchange");
          die();
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
    <?php 
          if(isset($message)){
            echo "<p class='text'>" . $message . "</p>";
          }
        ?>

        <?php
        date_default_timezone_set("Asia/Manila");
        $email = $_SESSION["email-verify"];
        $qry = "SELECT * FROM users WHERE email = :email";
        $stmt = $pdo->prepare($qry);
        $stmt->bindParam(":email", $email);
        $stmt->execute();  

        $results = $stmt->fetch();


        if(!$results) {
          $error = "There was an error!";
        } else {
          $hash_token = $results["hash_token"];
          $time = $results["exp_resetpass"];
        }
        
          if(empty($_GET["code"])) {
            $error = "token not found.";
          } else {

            $token = $_GET["code"];
            if (strlen($token) % 2 !== 0) {
              $token = "0" . $token;
            }

            if(ctype_xdigit($token)){
              $bin_token = hex2bin($token);
                
                if(!password_verify($bin_token, $hash_token)){
                  $error = "token does not match.";
                } else {
                  if(time() >= strtotime($time)){
    
                    $error = "Your token has expired.";

                  } else {                  
                      ?>
                        <form action="" method="POST">
                          <h2 style="text-align: center; margin-bottom: 10px" >Reset Password?</h2>
                          <input type="password" name="new_pwd" placeholder="New Password">
                          <input type="password" name="confirm_new_pwd" placeholder="Confirm Password">
                          <input class="btn" type="submit" name="submit" value="Reset Password">
                        </form>
                    <?php
                  }
                 
                }
              } else {
                $error = "Invalid token.";

              }
           
          }

        ?>
       
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