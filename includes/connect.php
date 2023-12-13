<?php

try {
  $host = "localhost";
  $root = "root";
  $password = "";
  $dbname = "users_db";

  $dsn = ("mysql:host={$host};dbname={$dbname}");

  $pdo = new PDO($dsn,$root,$password);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch(PDOException $exc) {
  echo $exc->getMessage();
}