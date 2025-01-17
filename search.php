<?php

require_once 'helpers.php';
require_once 'init.php';
require_once "functions.php";


$categories = get_categories($con);
$categories_id = array_column($categories, "id");


$mainContent = include_template('search-result.php', [
    "categories" => $categories
]);

$search = $_GET['search'] ?? '';
if ($search) {
    $limit = 10;
    $offset = 9;

    $sql = "SELECT lots.id, lots.title, lots.cost, lots.image, lots.time_expired, lots.description, categories.category_name FROM lots" .
    " JOIN categories ON lots.category_id=categories.id" .
    " WHERE MATCH(title, description) AGAINST(?) ORDER BY time_expired ";


    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, 's', $search);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $rows = mysqli_fetch_all($res, MYSQLI_ASSOC);
//    $rows = get_arrow($res, MYSQLI_ASSOC);

    $mainContent = include_template('search-result.php', [
        'search' => $search,
        "categories" => $categories,
        'lots' => $rows
    ]);
}

// die();

$layout = include_template('layout.php', [
    'search' => $search,
    'is_auth' => $is_auth,
    'pageName' => $page_name,
    'user_name' => $user_name,
    'mainContent' => $mainContent,
]);

print($layout);


