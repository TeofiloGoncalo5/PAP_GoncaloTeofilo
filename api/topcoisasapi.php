<?php

include '../db.php';

$text = htmlentities($_POST['text']);

$query = "INSERT INTO user_posts (userpost) VALUES ('$text')";

if (mysqli_query($conn, $query)) {
    echo "User registered successfully";
} else {
    echo "Error: " . $query . "<br>" . mysqli_error($conn);
}