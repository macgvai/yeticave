<?php

require_once 'helpers.php';
require_once 'init.php';
require_once "functions.php";


$categories = get_categories($con);
$categories_id = array_column($categories, "id");

$userId = $_SESSION['user']['id'];


$mainContent = include_template("add-lot.php", [
    "categories" => $categories
]);


if (!$is_auth) {
    $mainContent = include_template("403.php", [
    ]);

    $layout = include_template('layout.php', [
        'is_auth' => $is_auth,
        'pageName' => $page_name,
        'user_name' => $user_name,
        'mainContent' => $mainContent
    ]);
    
    print($layout);
    die();
}

$form = $_POST;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $required = ["lot-name", "lot-category", "message", "lot-rate", "lot-step", "lot-date"];
    $errors = [];



    $rules = [
        "lot-category" => function($value) use ($categories_id) {
            return validate_category($value, $categories_id);
        },
        "lot-rate" => function($value) {
            return validate_number ($value);
        },
        "lot-step" => function($value) {
            return validate_number ($value);
        },
        "lot-date" => function($value) {
            return validate_date ($value);
        }
    ];

    $lot = filter_input_array(INPUT_POST,
        [
            "lot-name"=>FILTER_DEFAULT,
            "lot-category"=>FILTER_DEFAULT,
            "message"=>FILTER_DEFAULT,
            "lot-rate"=>FILTER_DEFAULT,
            "lot-step"=>FILTER_DEFAULT,
            "lot-date"=>FILTER_DEFAULT
        ], true);

    foreach ($lot as $field => $value) {
        if (isset($rules[$field])) {
            $rule = $rules[$field];
            $errors[$field] = $rule($value);
        }
        if (in_array($field, $required) && empty($value)) {
            $errors[$field] = "Поле $field нужно заполнить";
        }
    }

    $errors = array_filter($errors);


    //    $lotName = $form['lot-name'];
    //    $lotCategory = $form['lot-category'];
    //    $message = $form['message'];
    //    $lotRate = $form['lot-rate'];
    //    $lotStep = $form['lot-step'];
    //    $lotDate = $form['lot-date'];



    // получаем файл
    if (!empty($_FILES["lot_img"]["name"])) {
        $tmp_name = $_FILES["lot_img"]["tmp_name"];
        $path = $_FILES["lot_img"]["name"];

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $file_type = finfo_file($finfo, $tmp_name);
        if ($file_type === "image/jpeg") {
            $ext = ".jpg";
        } else if ($file_type === "image/png") {
            $ext = ".png";
        };



        if ($ext) {
            $filename = uniqid() . $ext;
            $lot["path"] = "uploads/". $filename;

            move_uploaded_file($_FILES["lot_img"]["tmp_name"], __DIR__ . "/uploads/". $filename);
        } else {
            $errors["lot_img"] = "Допустимые форматы файлов: jpg, jpeg, png";
        }
    } else {
        $errors["lot_img"] = "Вы не загрузили изображение";
    }


    if (count($errors)) {
        $mainContent = include_template("add-lot.php", [
            "categories" => $categories,
            "lot" => $lot,
            "errors" => $errors
        ]);

    } else {
//        print_r($userId);
//        die();
        $sql = get_query_create_lot($userId);
        $stmt = db_get_prepare_stmt_version($con, $sql, $lot);
        $res = mysqli_stmt_execute($stmt);


        if ($res) {
            $lot_id = mysqli_insert_id($con);
            header("Location: ./main-lot.php?id=" . $lot_id);
        } else {
            $error = mysqli_error($con);
        }
    }
}


// echo '<pre>';
// print_r($errors);
// echo '</pre>';



$layout = include_template('layout.php', [
    'is_auth' => $is_auth,
    'pageName' => $page_name,
    'user_name' => $user_name,
    'mainContent' => $mainContent
]);

print($layout);