<?php
$link = mysqli_connect('practica-php_db_1', 'root', 'test', 'tasks');
mysqli_set_charset($link, 'utf8');

session_start();

function create_user_session($userRow, $password)
{
    $valid_password = password_verify($password, $userRow["password"]);

    if ($valid_password) {
        $_SESSION["username"] = $userRow["username"];
        $_SESSION["user_id"] = $userRow["user_id"];
        return true;
    }

    return false;
}
