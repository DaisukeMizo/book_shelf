<?php

require_once __DIR__ . '/mysql.php';

function getLists($pdo, $status)
{
  try {
    $stmt = $pdo->prepare("SELECT * FROM bookshelf WHERE status = :status ORDER BY score DESC");
    $stmt->bindParam(":status", $status);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
  } catch (PDOException $e) {
    echo "リスト取得失敗" . $e->getMessage() . PHP_EOL;
    die();
  }
}

function escape($string)
{
  return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

$pdo = dbConnect();
