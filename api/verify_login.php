<?php

session_start();

include '../db.php';

$status = 'error';
$message = 'Ocorreu um erro';

$tipo = $conn->query("SELECT id, email, isAdmin, password FROM users");

$email = $_POST['email'];
$psw = $_POST['password'];

while ($row = $tipo->fetch_assoc()) {
    if ($email == $row['email'] && hash('sha256', $psw) == $row['password']) {
        $status = "success";
        $message = "Login com sucesso";
        $_SESSION['email'] = $email;
        $_SESSION['theId'] = $row['id'];
        $_SESSION['isAdmin'] = $row['isAdmin'];
        break;
    } else if ($email != $row['email'] && hash('sha256', $psw) != $row['password']) {
        $status = 'error';
        $message = 'Credencias erradas';
    }
}

echo json_encode(["status" => $status, "message" => $message, "admin" => $_SESSION['isAdmin']]);
