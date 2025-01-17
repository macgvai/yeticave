<?php
session_start();
// print_r($_SESSION);


define('CACHE_DIR', basename(__DIR__ . DIRECTORY_SEPARATOR . 'cache'));
define('UPLOAD_PATH', basename(__DIR__ . DIRECTORY_SEPARATOR . 'uploads'));

//$con = mysqli_connect('MySQL-8.0', 'root', '', 'yeticave');
$con = mysqli_connect('localhost', 'root', 'vXJQ88DgJg', 'yeticave');

mysqli_set_charset($con, 'utf8');

if (!$con) {
    print_r('ошибка подключения базе данных');
    $error = mysqli_connect_error();
}

$is_auth = !empty($_SESSION['user']["name"]);
if ($is_auth) {
    $user_name = $_SESSION['user']["name"];
}

// print_r($is_auth);
// print_r($user_name);

$categories = [];
$content = '';