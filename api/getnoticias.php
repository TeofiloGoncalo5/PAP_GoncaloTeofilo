<?php

include '../db.php';

$query = "SELECT * FROM noticia ";

$i = mysqli_query($conn, $query);
$noticias = [];
while ($row = mysqli_fetch_assoc($i)) {
    $noticias[] = html_entity_decode($row["noticias"]);
}
echo (json_encode($noticias));
