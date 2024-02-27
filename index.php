<?php
header("Content-Type: application/json; charset=UTF-8");

require_once __DIR__ . '/vendor/autoload.php';

use sainthouse\api\api;

$api = new api();
$api->handleRequest();