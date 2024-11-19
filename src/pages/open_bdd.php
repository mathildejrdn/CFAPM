<?php

try {
    $server_name = "db";
    $db_name = "cfapm";
    $user_name = "test";
    $db_password = "test";
    $db = new PDO("mysql:host=$server_name; dbname=$db_name;charset=utf8mb4", $user_name, $db_password);
} catch (PDOException $e) {
    echo "Échec de connexion : " . $e->getMessage();
}