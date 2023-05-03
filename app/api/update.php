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

$title = !empty($user['title']) ? $user['title'] : NULL;
$first_name = !empty($user['first_name']) ? $user['first_name'] : NULL;
$surname = !empty($user['surname']) ? $user['surname'] : NULL;
$gender = !empty($user['gender']) ? $user['gender'] : NULL;
$informal_name = !empty($user['informal_name']) ? $user['informal_name'] : NULL;
$address = !empty($user['address']) ? $user['address'] : NULL;
$town = !empty($user['town']) ? $user['town'] : NULL;
$postcode = !empty($user['postcode']) ? $user['postcode'] : NULL;
$ni_number = !empty($user['ni_number']) ? $user['ni_number'] : NULL;
$mobile_tel = !empty($user['mobile_tel']) ? $user['mobile_tel'] : NULL;
$home_tel = !empty($user['home_tel']) ? $user['home_tel'] : NULL;
$other_tel = !empty($user['other_tel']) ? $user['other_tel'] : NULL;
$date_of_birth = !empty($user['date_of_birth']) ? $user['date_of_birth'] : NULL;
$personal_email = !empty($user['personal_email']) ? $user['personal_email'] : NULL;
$initials = !empty($user['initials']) ? $user['initials'] : NULL;
$emergency_contact_name = !empty($user['emergency_contact_name']) ? $user['emergency_contact_name'] : NULL;

// Filter to prevent XSS injection attempts if variable is not null
if (!empty($title)) {
    $title = htmlspecialchars($title);
}
if (!empty($first_name)) {
    $first_name = htmlspecialchars($first_name);
}
if (!empty($surname)) {
    $surname = htmlspecialchars($surname);
}
if (!empty($gender)) {
    $gender = htmlspecialchars($gender);
}
if (!empty($informal_name)) {
    $informal_name = htmlspecialchars($informal_name);
}
if (!empty($address)) {
    $address = htmlspecialchars($address);
}
if (!empty($town)) {
    $town = htmlspecialchars($town);
}
if (!empty($postcode)) {
    $postcode = htmlspecialchars($postcode);
}
if (!empty($ni_number)) {
    $ni_number = htmlspecialchars($ni_number);
}
if (!empty($mobile_tel)) {
    $mobile_tel = htmlspecialchars($mobile_tel);
}
if (!empty($home_tel)) {
    $home_tel = htmlspecialchars($home_tel);
}
if (!empty($other_tel)) {
    $other_tel = htmlspecialchars($other_tel);
}
if (!empty($date_of_birth)) {
    $date_of_birth = htmlspecialchars($date_of_birth);
}
if (!empty($personal_email)) {
    $personal_email = htmlspecialchars($personal_email);
}
if (!empty($initials)) {
    $initials = htmlspecialchars($initials);
}
if (!empty($emergency_contact_name)) {
    $emergency_contact_name = htmlspecialchars($emergency_contact_name);
}

// Validate the input
$errors = array();

// Ensure title is one of the allowed values
if (!in_array($title, array("Mr", "Mrs", "Miss", "Ms", "Dr"))) {
    $errors[] = "Title must be one of Mr, Mrs, Miss, Ms, Dr";
}

// Ensure gender is one of the allowed values
if (!in_array($gender, array("male", "female", "other"))) {
    $errors[] = "Gender must be one of: male, female, other";
}

// Ensure none of the other required fields are empty
if (empty($first_name)) {
    $errors[] = "First name is required";
}
if (empty($surname)) {
    $errors[] = "Surname is required";
}
if (empty($address)) {
    $errors[] = "Address is required";
}
if (empty($postcode)) {
    $errors[] = "Postcode is required";
}

// Ensure date_of_birth is valid date
if (!empty($date_of_birth) && !DateTime::createFromFormat('Y-m-d', $date_of_birth)) {
    $errors[] = "Invalid date of birth format";
}

// Ensure fields are the correct length
if (!empty($first_name) && strlen($first_name) > 20) {
    $errors[] = "First name must not exceed 20 characters";
}
if (!empty($surname) && strlen($surname) > 20) {
    $errors[] = "Surname must not exceed 20 characters";
}
if (!empty($address) && strlen($address) > 60) {
    $errors[] = "Address must not exceed 60 characters";
}
if (!empty($town) && strlen($town) > 20) {
    $errors[] = "Town must not exceed 20 characters";
}
if (!empty($postcode) && strlen($postcode) > 8) {
    $errors[] = "Postcode must not exceed 8 characters";
}
if (!empty($ni_number) && strlen($ni_number) > 9) {
    $errors[] = "NI number must not exceed 9 characters";
}
if (!empty($mobile_tel) && strlen($mobile_tel) > 17) {
    $errors[] = "Mobile telephone number must not exceed 17 characters";
}
if (!empty($home_tel) && strlen($home_tel) > 17) {
    $errors[] = "Home telephone number must not exceed 17 characters";
}
if (!empty($other_tel) && strlen($other_tel) > 17) {
    $errors[] = "Other telephone number must not exceed 17 characters";
}
if (!empty($personal_email) && strlen($personal_email) > 50) {
    $errors[] = "Personal email must not exceed 50 characters";
}
if (!empty($initials) && strlen($initials) > 6) {
    $errors[] = "Initials must not exceed 6 characters";
}
if (!empty($emergency_contact_name) && strlen($emergency_contact_name) > 60) {
    $errors[] = "Emergency contact name must not exceed 60 characters";
}

// If there are any errors, return a 400 response with the errors
if (!empty($errors)) {
    http_response_code(400);
    header('Content-Type: application/json; charset=utf-8');
    die(json_encode(array("message" => "User update failed", "errors" => $errors)));
}

// Prepare the SQL statement to update the users table with the new data
$sql = "
    UPDATE users SET 
        title = :title,
        first_name = :first_name,
        surname = :surname,
        informal_name = :informal_name,
        gender = :gender,
        address = :address,
        town = :town,
        postcode = :postcode,
        ni_number = :ni_number,
        date_of_birth = :date_of_birth,
        mobile_tel = :mobile_tel,
        home_tel = :home_tel,
        other_tel = :other_tel,
        personal_email = :personal_email,
        initials = :initials,
        emergency_contact_name = :emergency_contact_name
    WHERE id = :id
";

$statement = $connection->prepare($sql);
$statement->bindParam(':title', $title);
$statement->bindParam(':first_name', $first_name);
$statement->bindParam(':surname', $surname);
$statement->bindParam(':informal_name', $informal_name);
$statement->bindParam(':gender', $gender);
$statement->bindParam(':address', $address);
$statement->bindParam(':town', $town);
$statement->bindParam(':postcode', $postcode);
$statement->bindParam(':ni_number', $ni_number);
$statement->bindParam(':date_of_birth', $date_of_birth);
$statement->bindParam(':mobile_tel', $mobile_tel);
$statement->bindParam(':home_tel', $home_tel);
$statement->bindParam(':other_tel', $other_tel);
$statement->bindParam(':personal_email', $personal_email);
$statement->bindParam(':initials', $initials);
$statement->bindParam(':emergency_contact_name', $emergency_contact_name);
$statement->bindParam(':id', $user['id']);

// Execute the SQL statement and return the response
header('Content-Type: application/json; charset=utf-8');
if($statement->execute()) {
    http_response_code(200);
    die(json_encode(array("message" => "User updated successfully")));
} else {
    http_response_code(400);
    die(json_encode(array("message" => "User update failed")));
}