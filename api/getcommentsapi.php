<?php

include '../db.php';

$query = "SELECT * FROM comments INNER JOIN users ON users.id = comments.iduser where idpost = ".$_POST["idpost"];

$i = mysqli_query($conn, $query);
$post = [];
while ($row = mysqli_fetch_assoc($i)) {
    $post[] = [
        "comment" => html_entity_decode($row["userpost"]),
        "nomedouser" => $row["username"]
    ];
}
echo (json_encode($post));
