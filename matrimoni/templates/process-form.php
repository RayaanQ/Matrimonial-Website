<?php

if(empty($_POST["name"])){
    die("Name is required");
}

if(! filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
    die("Valid email is required");
}

if (strlen($_POST["password"]) < 4) {
    die("Password must be at least 4 characters");
}

if ($_POST["password"] !== $_POST["confirm_password"]) {
    die("Passwords must match");
}

$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

$mysqli = require __DIR__ . "/database.php";

$sql = "INSERT INTO user (name, email, password_hash,city,number,interests,age,gender)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $mysqli->stmt_init();

if ( ! $stmt->prepare($sql)) {
    die("SQL error: " . $mysqli->error);
}

$stmt->bind_param("ssssssss",
                  $_POST["name"],
                  $_POST["email"],
                  $password_hash,
                  $_POST["city"],
                  $_POST["number"],
                  $_POST["interests"],
                  $_POST["age"],
                  $_POST["gender"],
                  );

if ($stmt->execute()) {

    header("Location: matrimoni.html");
    exit;
    
} else {
    
    if ($mysqli->errno === 1062) {
        die("email already taken");
    } else {
        die($mysqli->error . " " . $mysqli->errno);
    }
}

// $name = $_POST["name"];
// $city = $_POST["city"];
// $email = $_POST["email"];
// $number = $_POST["number"];
// $password = $_POST["password"];
// $confirm_password = $_POST["confirm_password"];
// $interests = $_POST["interests"];
// $age = $_POST["age"];
// $gender = $_POST["gender"];

// print_r($_POST);

// var_dump($password_hash);
