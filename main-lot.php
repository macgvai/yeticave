<?php
require_once 'helpers.php';
require_once 'init.php';


$url = $_SERVER['REQUEST_URI'];

if(isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM lots  JOIN categories c on c.id = lots.category_id  WHERE lots.id = ?";

    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "i", $_GET['id']);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $rows = mysqli_fetch_all($res, MYSQLI_ASSOC);


    if ($rows) {
//        $records_count = mysqli_num_rows($result);
        $lot = $rows;
    } else {
        $error = mysqli_error($con);
    }
}

if (!isset($lot)) {
    $mainContent = include_template('404.php');

    $layout = include_template('layout.php', [
        'is_auth' => $is_auth,
        'pageName' => $page_name,
        'user_name' => $user_name,
        'mainContent' => $mainContent
    ]);
    print($layout);
    die();
}

$userId = $_SESSION['user']['id'];

// История ставок
$sql = "select DATE_FORMAT(bets.date_bet, '%d.%m.%y %H:%i') AS date_bet, bets.price_bet, users.name from bets join users on bets.user_id = users.id WHERE bets.lots_id = $id ORDER BY bets.date_bet DESC LIMIT 10;";
$result = mysqli_query($con, $sql);
$history = mysqli_fetch_all($result, MYSQLI_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bet = filter_input(INPUT_POST, "cost", FILTER_VALIDATE_INT);

    if ($bet < $min_bet) {
        $error = "Ставка не может быть меньше $min_bet";
    }
    if (empty($bet)) {
        $error = "Ставка должна быть целым числом, болше ноля";
    }

    if ($error) {
        $mainContent = include_template("main-lot.php", [
            "categories" => $categories,
            "header" => $header,
            "lot" => $lot,
            "is_auth" => $is_auth,
            "current_price" => $current_price,
            "min_bet" => $min_bet,
            "error" => $error,
            "id" => $id,
            "history" => $history
        ]);
    } else {

        // сделать транзакцию
        $sql = "INSERT INTO bets (price_bet, user_id, lots_id) VALUES ($bet, $userId, $id)";
        $result = mysqli_query($con, $sql);
        $costSql = "UPDATE lots SET cost = $bet WHERE id = $id;";
        $costResult = mysqli_query($con, $costSql);


        header("Location: ./main-lot.php?id=" .$id);
    }
}

$current_price = max($lot[0]["cost"], $history[0]["price_bet"]);
print_r($lot);

$mainContent = include_template('lot.php', [
    'is_auth' => $is_auth,
    'title' => $lot[0]['title'],
    'category' => $lot[0]['category_name'],
    'description' => $lot[0]['description'],
    'image' => $lot[0]['image'],
    'time_create' => $lot[0]['time_create'],
    'cost' => $lot[0]['cost'],
    'time_expired' => $lot[0]['time_expired'],
    "history" => $history,
    'id' => $id,
    'current_price' => $current_price
]);

$layout = include_template('layout.php', [
    'is_auth' => $is_auth,
    'pageName' => $page_name,
    'user_name' => $user_name,
    'mainContent' => $mainContent
]);



print($layout);