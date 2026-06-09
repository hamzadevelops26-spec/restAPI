<?php
$parts = explode("/", $_SERVER['REQUEST_URI']);
if ($parts[2] !== "products") {
    http_response_code(404);
    exit;
}
$id = $parts[3] ?? null;
var_dump($id);
