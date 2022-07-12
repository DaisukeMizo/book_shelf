<?php

require_once __DIR__ . '/mysql.php';

function dropTable($pdo)
{
  try {
    $stmt = $pdo->prepare("DROP TABLE IF EXISTS bookshelf");
    $stmt->execute();
    echo '削除成功' . PHP_EOL;
  } catch (PDOException $e) {
    echo "削除失敗" . $e->getMessage() . PHP_EOL;
    die();
  }
}

function createTable($pdo)
{
  try {
    $stmt = $pdo->prepare("CREATE TABLE bookshelf (
    id INT(11) AUTO_INCREMENT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255),
    image_url VARCHAR(255),
    image_key VARCHAR(255),
    score INT(1),
    mediums VARCHAR(15),
    status VARCHAR(10))
    DEFAULT CHARACTER SET=utf8;");
    $stmt->execute();
    echo "テーブル作成成功" . PHP_EOL;
  } catch (PDOException $e) {
    echo "テーブル作成失敗" . $e->getMessage() . PHP_EOL;
    die();
  }
}

$pdo = dbConnect();
dropTable($pdo);
createTable($pdo);
