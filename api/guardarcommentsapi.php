<?php

session_start();

include '../db.php';

$text = htmlentities($_POST['text']);

$query = "INSERT INTO comments (idpost, userpost, iduser) VALUES ($_POST[id], '$text', ".$_SESSION['theId'].")";

if (mysqli_query($conn, $query)) {
    echo "User registered successfully";
} else {
    echo "Error: " . $query . "<br>" . mysqli_error($conn);
}