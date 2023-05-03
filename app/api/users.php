<?php

// Set database credentials
$server = "db";
$dbname = "eden-tech-test";
$username = "root";
$password = "password";

// Establish a connection to the database
try {
    $connection = new PDO('mysql:host=' . $server . ';dbname=' . $dbname, $username, $password);
    $connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $error) {
    http_response_code(500);
    header('Content-Type: application/json; charset=utf-8');
    die(json_encode(array("message" => "Error connecting to database")));
}

// Query to select data from the users table
$sql = "SELECT id, title, first_name, surname FROM users";
$result = $connection->query($sql);

// Check if we have any results
$users = $result->fetchAll(PDO::FETCH_ASSOC);
header('Content-Type: application/json; charset=utf-8');
if (count($users) > 0) {
    die(json_encode($users));
} else {
    die(json_encode(array("message" => "No users found")));
}