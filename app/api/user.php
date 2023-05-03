<?php

// Check if id parameter is set and is numeric
if(empty($_GET['id']) || !is_numeric($_GET['id'])) {
    $error = array("error" => "incorrect/missing id parameter");
    header('Content-Type: application/json; charset=utf-8');
    http_response_code(400);
    die(json_encode($error));
}

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

// Prepare and execute SQL statement to fetch user with given id
$id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
$sql = "SELECT * FROM users WHERE id = :id";
$statement = $connection->prepare($sql);
$statement->bindParam(':id', $id, PDO::PARAM_INT);

// execute the statement and if we return true, return the user json
header('Content-Type: application/json; charset=utf-8');
$statement->execute();
$user = $statement->fetch(PDO::FETCH_ASSOC);
if (!$user) {
    http_response_code(404);
    die(json_encode(array("error" => "user not found")));
}
http_response_code(200);
die(json_encode($user));