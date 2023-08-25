<?php

include '../db.php';
include 'verification.php';

$status = 'error';
$message = 'Ocorreu um erro';

$id = $_POST['login-form-submit'];


if($result){
    $status = 'success';
    $message = 'Login realizado';
}

echo json_encode(["status" => $status, "message" => $message]);
?>