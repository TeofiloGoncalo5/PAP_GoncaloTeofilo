<?php

$db_host = 'localhost'; // database host
$db_user = 'root'; // database user
$db_pass = ''; // database password
$db_name = 'sportscare'; // database name

$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if (!$conn) {
    die("Conexão falhou: " . mysqli_connect_error());
}