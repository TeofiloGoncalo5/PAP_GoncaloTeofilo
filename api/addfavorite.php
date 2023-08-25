<?php
session_start();

include '../db.php';

$status = 'error';
$message = 'Ocorreu um erro';

$productId = $_POST['productId'];

$fav = $conn->query("SELECT id, favotiro FROM users");

if ($_SESSION['theId']) {
  $status = "success";
  $message = "Equipa adicionada com sucesso";
  $conn->query("UPDATE users SET favotiro ='" . $productId . "'");
}

echo json_encode(["status" => $status, "message" => $message]);
