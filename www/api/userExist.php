<?php
require_once('../conx.php');

$username = $_GET["username"];

$sql = "SELECT COUNT(user_id) FROM users WHERE username = ?;";
$stmt = mysqli_prepare($link, $sql);
$stmt -> bind_param("s", $username);
$stmt -> execute();
$results = $stmt -> get_result();
$results = $results -> fetch_array()[0];

$response = [
    "exist" => !!$results
];

echo json_encode($response);
