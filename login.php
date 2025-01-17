<?php
require_once 'helpers.php';
require_once 'init.php';


$is_auth = rand(0, 1);

$user_name = 'Виктор'; // укажите здесь ваше имя

$page_name = 'Лот';

$sql = "SELECT * FROM categories";

$result = mysqli_query($con, $sql);

if ($result == false) {
    print("Произошла ошибка при выполнении запроса");
}

$category = mysqli_fetch_all($result, MYSQLI_ASSOC);


$mainContent = include_template('login.php', [
    'value' => $_POST['value'],
//    'title' => $lot[0]['title'],
    'category' => $category,
//    'description' => $lot[0]['description'],
//    'image' => $lot[0]['image'],
//    'time_create' => $lot[0]['time_create'],
//    'cost' => $lot[0]['cost'],
//    'time_expired' => $lot[0]['time_expired']
]);


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $form = $_POST;
// print_r($form);
    $required = ['email', 'password'];
    $errors = [];
    foreach ($required as $field) {
        if (empty($form[$field])) {
            $errors[$field] = 'Это поле надо заполнить';
        }
    }

    $email = mysqli_real_escape_string($con, $form['email']);
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $res = mysqli_query($con, $sql);

    $user = $res ? mysqli_fetch_array($res, MYSQLI_ASSOC) : null;

    if (!count($errors) and $user) {
        if (password_verify($form['password'], $user['password'])) {
            $_SESSION['user'] = $user;
        }
        else {
            $errors['password'] = 'Неверный пароль';
        }
    }
    else {
        $errors['email'] = 'Такой пользователь не найден';
    }

    if (count($errors)) {
       $mainContent = include_template('login.php', ['form' => $form, 'errors' => $errors]);
        print_r($errors);
    }
    else {
        header("Location: ./index.php");
        exit();
    }
} else {
    $mainContent = include_template('login.php', []);

    if (isset($_SESSION['user'])) {
        header("Location: ./index.php");
        exit();
    }
}

$layout = include_template('layout.php', [
    'is_auth' => $is_auth,
    'pageName' => $page_name,
    'user_name' => $user_name,
    'mainContent' => $mainContent
]);



print($layout);