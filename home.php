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
<style>
  * {
    padding: 0;
    margin: 0;
    font-family: sans-serif;
    box-sizing: border-box;
  }
  .main {
    height: 100vh;
    padding-top: 60px;
    background-color: rgb(223, 223, 223);

    background-image: url(./pic/12.jpg);
    background-repeat: no-repeat;
    background-size: cover;
  }

.main .grid {
  display: grid;
  grid-template-rows: 1fr 3fr;
  height: 100%;
}


.top .img {
  margin-top: 10px;
  width: 100%;
  
  display: flex;
  justify-content: center;
}

.top .img img {
  width: 200px;
}

.bottom {
  display: grid;
  grid-template-columns: 1fr 1fr 1fr;
  
}

.bottom .left {
  justify-self: end;
}

.bottom .left img {
  width: 300px;
}


.bottom .right img {
  width: 300px;
}

.h1 {
  margin-top: 80px;
  font-size: 30px;
  text-align: center;
  color: white;
  text-shadow: 1px 1px 10px rgba(0, 0, 0, .50);
}

.h2 {
  font-size: 22px;
  text-align: center;
  color: white;
  text-shadow: 1px 1px 10px rgba(0, 0, 0, .50);

}


.text {
  font-size: 18px;
  font-weight: 700;
  text-align: center;
  color: white;
  text-shadow: 1px 1px 10px rgba(0, 0, 0, .50);
}

.opacity {
  position: relative;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
}

.jif {
  width: 200px;
  height: 200px;
}

.jif-container {
  display: flex;
  justify-content: center;
}

</style>
<body>
  <?php
    include 'header.php';
  ?>
  <div class="main">
    <div class="grid">
      <div class="top">
        <div class="img">
          <img src="./pic/6.png" alt="">
        </div>
      </div>
      <div class="bottom">
        <div class="left">
          <img src="./pic/7.png" alt="">
        </div>
        <div class="middle">
          <div class="h1">you got it, bro</div>
          <div class="h2">I'm so proud of u</div>
          <div class="text"><?php echo htmlspecialchars($username)?></div>
          <div class="jif-container">
            <img class="jif"src="./pic/happy-cat.gif" alt="">
          </div>
        </div>
        <div class="right">
          <img src="./pic//8.png" alt="">
        </div>
    </div>
  </div>
</body>
</html>