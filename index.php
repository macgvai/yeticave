<?php
require_once 'helpers.php';
require_once 'init.php';


if (!$con) {
     $error = mysqli_connect_error();
}

$sql = "SELECT category_code,  category_name FROM categories";
$result = mysqli_query($con, $sql);
if ($result) {
    $category = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $error = mysqli_error($con);
}


$is_auth = !empty($_SESSION['user']["name"]);
if ($is_auth) {
    $user_name = $_SESSION['user']["name"];
}

// print_r($is_auth);
// 'print_r($user_name);'



//$sql = "SELECT lots.id, title, cost, image, category_name, time_create FROM lots
//    JOIN categories c on c.id = lots.category_id
//    WHERE time_expired IS NULL
//    ORDER BY time_create ASC;";
$sql = "SELECT lots.id, title, cost, image, category_name, time_create, time_expired FROM lots
    JOIN categories c on c.id = lots.category_id
    ORDER BY time_create ASC;";
$result = mysqli_query($con, $sql);
if ($result) {
    $records_count = mysqli_num_rows($result);
    $lots = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $error = mysqli_error($con);
}




$page_name = 'Главная';


$cur_page = $_GET['page'] ?? 1;
$page_items = 6;

$result = mysqli_query($con, "SELECT COUNT(*) as cnt FROM gifs");
$items_count = mysqli_fetch_assoc($result)['cnt'];

$pages_count = ceil($items_count / $page_items);
$offset = ($cur_page - 1) * $page_items;

$pages = range(1, $pages_count);

// запрос на показ девяти самых популярных гифок
$sql = 'SELECT gifs.id, title, path, like_count, users.name FROM gifs '
    . 'JOIN users ON gifs.user_id = users.id '
    . 'ORDER BY show_count DESC LIMIT ' . $page_items . ' OFFSET ' . $offset;


//print_r($lots);
$mainContent = include_template('main.php', [
    'category' => $category,
    'lots' => $lots,
]);

$layout = include_template('layout.php', [
    'is_auth' => $is_auth,
    'pageName' => $page_name,
    'user_name' => $user_name,
    'mainContent' => $mainContent
]);



print($layout);

?>