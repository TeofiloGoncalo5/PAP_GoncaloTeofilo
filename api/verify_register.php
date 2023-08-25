<?php

session_start();

include '../db.php';

function validate_input($input) {
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = validate_input($_POST["username"]);
    $email = validate_input($_POST["email"]);
    $password = validate_input($_POST["password"]);


    // Check if the username is already taken
    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        echo "Username already taken";
        exit();
    }

    
    // Insert the new user into the database
    $hashedPassword = hash('sha256', $password);
    $query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashedPassword')";
    if (mysqli_query($conn, $query)) {
        echo "User registered successfully";
    } else {
        echo "User registered successfully";
    }

    mysqli_close($conn);
}
