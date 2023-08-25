<?php

session_start();

include '../db.php';

if (!isset($_SESSION['theId']) || empty($_SESSION['theId'])) {
  echo json_encode(["status" => "error", "message" => "Sessão inválida"]);
  exit();
}

$status = 'error';
$message = 'Ocorreu um erro';

if (isset($_SESSION['theId'])) {
    $oldpsw = $conn->query("SELECT password FROM users WHERE id = " . $_SESSION['theId']);

    $canChange = false;
    if ($oldpsw) {
        while ($row = $oldpsw->fetch_assoc()) {
            if (hash('sha256', $_POST['oldpsw']) == $row['password']) {
                $canChange = true;
            } else {
                $message = 'Password antiga errada';
            }
        }
    }

    if ($canChange) {
        $edit = $conn->query("UPDATE users SET password = '"  . hash('sha256', $_POST['newpsw']) . "' WHERE id =" . $_SESSION['theId']);
        if ($edit) {
            $status = "success";
            $message = "Password editada com sucesso";
        }
    }
} else {
    $message = 'Sessão inválida';
}

echo json_encode(["status" => $status, "message" => $message]);