<?php

include '../db.php';

$text = htmlentities($_POST['text']);

$query = "INSERT INTO noticia (noticias) VALUES ('$text')";

if (mysqli_query($conn, $query)) {
    echo "User registered successfully";
} else {
    echo "Error: " . $query . "<br>" . mysqli_error($conn);
}