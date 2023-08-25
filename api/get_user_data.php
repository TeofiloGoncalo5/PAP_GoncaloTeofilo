<?php

include '../../db.php';

function getUsers() {
    global $conn; // Make sure $conn is accessible within this function

    $query = "SELECT * FROM users";
    $result = mysqli_query($conn, $query);

    $users = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $users[] = $row;
    }

    return $users;
}

$users = getUsers(); // Call the getUsers() function to fetch user records
?>
