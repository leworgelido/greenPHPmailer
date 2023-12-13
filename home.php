<?php
session_start();
  $username = $_SESSION["username"];
  $email = $_SESSION["email"];

  if(!isset($email)) {
    header("Location: index.php");
    exit();
  }


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HOME</title>
</head>
<body>
  <div class="main">
    <p>WELCOME, <?php echo $username ?></p>

    <a href="logout.php">LOGOUT</a>
  </div>
</body>
</html>