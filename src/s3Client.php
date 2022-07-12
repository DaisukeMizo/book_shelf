<?php

require 'vendor/autoload.php';

use Aws\S3\S3Client;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$s3 = new S3Client([
    'credentials' => [
        'key' => $_ENV['AWS_ACCESS_KEY_ID'],
        'secret' => $_ENV['AWS_SECRET_ACCESS_KEY']
    ],
    'region' => 'ap-northeast-1',
    'version' => 'latest',
]);
