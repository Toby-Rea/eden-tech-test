<?php

// Retrieve the PUT request data and parse it as JSON
$request_data = file_get_contents("php://input");
$user = json_decode($request_data, true);

// Ensure the id is valid
if (!isset($user["id"]) || !is_numeric($user["id"])) {
    http_response_code(400);
    header('Content-Type: application/json; charset=utf-8');
    die(json_encode(array("message" => "Missing or invalid id parameter")));
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
$id = filter_var($user['id'], FILTER_SANITIZE_NUMBER_INT);
$sql = "DELETE FROM users WHERE id = :id";
$statement = $connection->prepare($sql);
$statement->bindParam(':id', $id, PDO::PARAM_INT);

// Execute the SQL statement and check if user was deleted
$statement->execute();
if ($statement->rowCount() > 0) {
    http_response_code(200);
    header('Content-Type: application/json; charset=utf-8');
    die(json_encode(array("message" => "User deleted successfully")));
} else {
    http_response_code(500);
    header('Content-Type: application/json; charset=utf-8');
    die(json_encode(array("message" => "Failed to delete user with id: $id")));
}