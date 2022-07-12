<?php

require __DIR__ . '/vendor/autoload.php';

function dbConnect()
{
  $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
  $dotenv->load();

  $dsn = "mysql:charset=UTF8;dbname=" . $_ENV['DB_NAME'] . ";host=" . $_ENV['DB_HOST'];;
  $user = $_ENV['DB_USERNAME'];
  $pass = $_ENV['DB_PASSWORD'];

  try {
    $pdo = new PDO($dsn, $user, $pass);
  } catch (PDOException $e) {
    echo "接続失敗: " . $e->getMessage() . PHP_EOL;
    exit();
  }

  return $pdo;
}
