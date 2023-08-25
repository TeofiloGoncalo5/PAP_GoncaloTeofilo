<?php
include '../../db.php';

function get_server_url(): string {
    return "http://localhost/minha_PAP";
}

$global_configs = [
    "SERVER_URL" => get_server_url(),
];
?>