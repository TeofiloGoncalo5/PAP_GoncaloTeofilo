<?php

include '../db.php';

$query = "SELECT * FROM user_posts ";

$i = mysqli_query($conn, $query);
$post = [];
while ($row = mysqli_fetch_assoc($i)) {
    $post[] = [
        "post" => html_entity_decode($row["userpost"]),
        "id" => $row["id"]
    ];
}
echo (json_encode($post));
