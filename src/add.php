<?php

require_once __DIR__ . '/mysql.php';
include './validate.php';
require_once __DIR__ . '/S3Client.php';

use Aws\S3\Exception\S3Exception;

function addElement($pdo, $element)
{
  try {
    $stmt = $pdo->prepare("INSERT INTO bookshelf (title, image_url, image_key, score, mediums, status) VALUES (:title, :image_url, :image_key, :score, :mediums, :status)");
    $stmt->bindParam(":title", $element['title'], PDO::PARAM_STR);
    $stmt->bindParam(":image_url", $element['image_url'], PDO::PARAM_STR);
    $stmt->bindParam(":image_key", $element['image_key'], PDO::PARAM_STR);
    $stmt->bindParam(":score", $element['score'], PDO::PARAM_INT);
    $stmt->bindParam(":mediums", $element['mediums'], PDO::PARAM_STR);
    $stmt->bindParam(":status", $element['status'], PDO::PARAM_STR);
    $stmt->execute();
  } catch (PDOException $e) {
    echo "データ追加失敗" . $e->getMessage() . PHP_EOL;
    die();
  }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (empty($_POST['status'])) {
    $_POST['status'] = '';
  }

  $allow_exts = array("png", "pdf", "jpg", "jpeg");
  $tmp_file   = $_FILES['image']['tmp_name'];
  $file_name  = basename($_FILES['image']['name']);
  $tmp_file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

  $action = "add.php";

  $element = [
    'title' => $_POST['title'],
    'score' => $_POST['score'],
    'image_url' => '',
    'image_key' => '',
    'mediums' => $_POST['mediums'],
    'status' => $_POST['status']
  ];

  $errors = validate($element);

  if (!in_array($tmp_file_ext, $allow_exts)) {
    $errors['image'] = 'png, pdf, jpgのいずれかのファイルを選択してください';
  }

  if (!count($errors)) {
    try {
      $result = $s3->putObject([
        'Bucket' => $_ENV['S3_BUCKET_NAME'],
        'Key'    => $file_name,
        'SourceFile' => $tmp_file,
        'ContentType' => $_FILES['image']['type'],
        'ACL'    => 'public-read',
      ]);
    } catch (S3Exception $e) {
      echo $e->getMessage() . PHP_EOL;
    }

    $element['image_key'] = $file_name;
    $element['image_url'] = $result['ObjectURL'];
    $pdo = dbConnect();
    addElement($pdo, $element);
    header("Location: ./index.php");
  }
}


$title = "新規登録";

include './form.php';
