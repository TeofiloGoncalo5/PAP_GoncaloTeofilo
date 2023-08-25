<?php
// update_admin_status.php

include '../db.php';

$userid = mysqli_real_escape_string($conn,$_POST['userid']);
$status = mysqli_real_escape_string($conn,$_POST['status']);

$tipo2 = $conn->query("UPDATE users SET isAdmin ='" . $status . "' WHERE id = " . $userid);
if($tipo2) echo true;
?>
