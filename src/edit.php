<?php

require_once __DIR__ . '/mysql.php';
require_once __DIR__ . '/S3Client.php';

use Aws\S3\Exception\S3Exception;

function deleteImage($image_key, $s3)
{
  $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
  $dotenv->load();

  try {
    $s3->deleteObject([
      'Bucket' => $_ENV['S3_BUCKET_NAME'],
      'Key'    => $image_key,
    ]);
  } catch (S3Exception $e) {
    echo $e->getMessage() . PHP_EOL;
  }
}

function deleteElement($pdo, $id, $s3)
{
  try {
    $stmt = $pdo->prepare("SELECT image_key FROM bookshelf WHERE id=:id");
    $stmt->bindParam(":id", $id, PDO::PARAM_STR);
    $stmt->execute();
    $image_key = $stmt->fetchColumn();

    deleteImage($image_key, $s3);

    $stmt = $pdo->prepare("DELETE FROM bookshelf WHERE id=:id");
    $stmt->bindParam(":id", $id, PDO::PARAM_STR);
    $stmt->execute();
  } catch (PDOException $e) {
    echo "要素削除失敗" . $e->getMessage() . PHP_EOL;
    die();
  }
};

function getElement($pdo, $id)
{
  try {
    $stmt = $pdo->prepare("SELECT * FROM bookshelf WHERE id=:id ORDER BY score DESC");
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $result = $stmt->fetch();
    return $result;
  } catch (PDOException $e) {
    echo "要素取得失敗" . $e->getMessage() . PHP_EOL;
    die();
  }
}

function updateElement($pdo, $element)
{
  try {
    $stmt = $pdo->prepare("UPDATE bookshelf SET title = :title, image_url = :image_url, image_key = :image_key, score = :score, mediums = :mediums, status = :status WHERE id = :id");
    $stmt->bindParam(":id", $element['id']);
    $stmt->bindParam(":title", $element['title']);
    $stmt->bindParam(":image_url", $element['image_url']);
    $stmt->bindParam(":image_key", $element['image_key']);
    $stmt->bindParam(":score", $element['score']);
    $stmt->bindParam(":mediums", $element['mediums']);
    $stmt->bindParam(":status", $element['status']);
    $stmt->execute();
    $result = $stmt->fetch();
    return $result;
  } catch (PDOException $e) {
    echo "アップデート失敗" . $e->getMessage() . PHP_EOL;
    die();
  }
}

$pdo = dbConnect();
$action = "./edit.php";
$title = "編集";
$btn_name = "update";

if (isset($_POST['delete'])) {
  $element[''] = $_POST['delete'];
  $image = deleteElement($pdo, $element[''], $s3);
  header("Location: ./index.php");
}

if (isset($_POST['edit'])) {
  $id = $_POST['edit'];
  $element = getElement($pdo, $id);
}

if (isset($_POST['update'])) {
  include "./validate.php";

  if (empty($_POST['status'])) {
    $_POST['status'] = '';
  }

  $allow_exts = array("png", "pdf", "jpg", "jpeg");
  $tmp_file   = $_FILES['image']['tmp_name'];
  $file_name  = basename($_FILES['image']['name']);
  $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
  $old_image = $_POST['old_image_key'];

  $element = [
    'title' => $_POST['title'],
    'image_url' => $_POST['old_image_URL'],
    'score' => $_POST['score'],
    'mediums' => $_POST['mediums'],
    'status' => $_POST['status'],
    'id' => $_POST['id']
  ];

  $errors = validate($element, $file_ext, $allow_exts);

  if (empty($tmp_file)) {
    $save_file_name = $old_image;
  } else {
    deleteImage($old_image, $s3);

    $save_file_name = $file_name;

    try {
      $result = $s3->putObject([
        'Bucket' => $_ENV['S3_BUCKET_NAME'],
        'Key'    => $save_file_name,
        'SourceFile' => $tmp_file,
        'ContentType' => $_FILES['image']['type'],
        'ACL'    => 'public-read',

      ]);

      $element['image_url'] = $result['ObjectURL'];
    } catch (S3Exception $e) {
      echo $e->getMessage() . PHP_EOL;
    }
  }
  if (!count($errors)) {
    $element['image_key'] = $save_file_name;
    $pdo = dbConnect();
    updateElement($pdo, $element);
    header("Location: ./index.php");
  }
}


include './form.php';
