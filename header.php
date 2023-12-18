<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="sweetalert.min.js"></script>
  <title>Document</title>
</head>
<style>
  * {
    padding: 0;
    margin: 0;
    box-sizing: border-box;
    font-family: sans-serif;
  }

.header {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    height: 60px;
    background-color: white;
    z-index: 1000;

    display: flex;
    justify-content: space-between;
  }

.header .left-section {
    width: fit-content;
    margin-left: 50px;

    display: flex;
    flex-direction: row;
  }

.header .right-section {
    width: 200px;
    margin-right: 50px;

    display: flex;
    align-items: center;
    justify-content: center;

  }

.header .left-section .logo {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
  }

.header .left-section .logo img {
    width: 60px;
    height: 60px;
  }


.header .left-section .nav-menu .nav a li {
  list-style: none;
  width: 110px;
 }

.header .left-section .nav-menu .nav {
  display: flex;
  margin-left: 15px;
  
 }

.header .left-section .nav-menu .nav a {
  text-decoration: none;
  color: #1e1e1e;
  text-wrap: nowrap;
  line-height: 60px;
  text-align: center;
  font-weight: 600;
  transition: all 0.15s ease-in-out;
 }

.header .left-section .nav-menu .nav a:hover {
  background-color: #1e1e1e;
  color: white;
 }

.header .right-section .btn .btn-logout {
  padding: 10px 14px 10px 14px;
  border: 1px solid black;
  border-radius: 2px;
  background-color: #1e1e1e;
  color: white;
  font-size: 16px;
  transition: all .15s ease-in-out;
  cursor: pointer;
 }

 .header .right-section .btn .btn-logout:hover {
  background-color: white;
  color: #1e1e1e;
 }

</style>
<body>
  <div class="header">
    <div class="left-section">
      <div class="logo">
        <img src="./pic/5.png" alt="">
      </div>
      <div class="nav-menu">
        <ul class="nav">
        <a href="#"><li>HOME</li></a>
        <a href="#"><li>PRODUCTS</li></a>
        <a href="#"><li>ABOUT US</li></a>
        <a href="#"><li>CONTACT US</li></a>
        </ul>

      </div>
    </div>
    <div class="right-section">
      <div class="btn">
        <?php

        if(!empty($username)){
          if(!isset($username)){
          } else {
          
            ?>
            <form action="logout.php" method="POST" onsubmit="return submitForm(this)">
              <button type="submit" class="btn-logout">Logout</button>
            </form>
            <?php
          }
        }

        ?>
      </div>
      <script>
          function submitForm(form) {
              swal({
                  title: "Signout?",
                  text: "Are you sure you want to leave me? :((",
                  icon: "warning",
                  buttons: true,
                  dangerMode: true,
              })
              .then(function (isOkay) {
                  if (isOkay) {
                      form.submit();
                  }
              });
              return false;
          }
</script>
    </div>
  </div>
</body>
</html>