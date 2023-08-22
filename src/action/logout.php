<?php

require_once __DIR__ . '/../helpers.php';

if ($_SERVER['REQUEST_METHOD'] == "POST"){
    logout();
}

http_response_code(404);