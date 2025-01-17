<?php
require_once 'helpers.php';
require_once 'init.php';


$is_auth = rand(0, 1);

$user_name = 'Виктор'; // укажите здесь ваше имя

$page_name = 'Лот';

$tpl_data = [];

$sql = "SELECT * FROM categories";

$result = mysqli_query($con, $sql);

if ($result == false) {
    print("Произошла ошибка при выполнении запроса");
}

$category = mysqli_fetch_all($result, MYSQLI_ASSOC);
$tpl_data['category'] = $category;



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $form = $_POST;

    $errors = [];

    $req_fields = ['email', 'password', 'name', 'message'];

    foreach ($req_fields as $field) {
        if (empty($form[$field])) {
            $errors[$field] = "Не заполнено поле " . $field;
        }
    }

    if (empty($errors)) {
        $email = mysqli_real_escape_string($con, $form['email']);
        $sql = "SELECT id FROM users WHERE email = '$email'";
        $res = mysqli_query($con, $sql);
        if (mysqli_num_rows($res) > 0) {
            $errors[] = 'Пользователь с этим email уже зарегистрирован';
        }
        else {
            $password = password_hash($form['password'], PASSWORD_DEFAULT);

            $sql = 'INSERT INTO users (date_created, email, name, password, contacts) VALUES (NOW(), ?, ?, ?, ?)';
            $stmt = db_get_prepare_stmt($con, $sql, [$form['email'], $form['name'], $password, $form['message']]);
            $res = mysqli_stmt_execute($stmt);
        }
        if ($res && empty($errors)) {
            header("Location: ./login.php");
            exit();
        }
    }

}

$tpl_data['errors'] = $errors;
// var_dump($tpl_data);
$tpl_data['values'] = $form;


$mainContent = include_template('register.php', $tpl_data);

$layout = include_template('layout.php', [
    'is_auth' => $is_auth,
    'pageName' => $page_name,
    'user_name' => $user_name,
    'mainContent' => $mainContent
]);



print($layout);