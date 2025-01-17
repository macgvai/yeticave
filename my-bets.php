<?php
require_once 'helpers.php';
require_once 'init.php';
require_once 'functions.php';

$is_auth = !empty($_SESSION['user']["name"]);
if ($is_auth) {
    $user_name = $_SESSION['user']["name"];
}
$pageName = "Мои ставки";

$sql = "SELECT category_code,  category_name FROM categories";
$result = mysqli_query($con, $sql);
if ($result) {
    $category = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $error = mysqli_error($con);
}

$userId = $_SESSION['user']['id'];

$sql = "SELECT lots.id, `time_create`, `title`, `description`, `image`, `cost`, `time_expired`, categories.category_name FROM lots JOIN categories ON lots.category_id = categories.id WHERE lots.user_id = $userId";
$result = mysqli_query($con, $sql);
$lots = mysqli_fetch_all($result, MYSQLI_ASSOC);
//die();

 print_r($lots);
$mainContent = include_template('myBets.php', [
    'category' => $category,
    'bets' => $lots,
]);
//print_r($mainContent);


$layout = include_template('layout.php', [
    'is_auth' => $is_auth,
    'pageName' => $pageName,
    'user_name' => $user_name,
    'mainContent' => $mainContent
]);



print($layout);