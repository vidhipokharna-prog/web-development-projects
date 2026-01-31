<?php
include 'db_config.php'; // include your database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $blood = $_POST['blood'];
    $city = $_POST['city'];
    $contact = $_POST['contact'];
    $notes = $_POST['message'];

    // Generate a unique ID like OTP (6-digit random number)
    $unique_id = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 6);

    // Insert donor data
    $sql = "INSERT INTO donor (unique_id, name, age, blood_group, city, contact, notes)
            VALUES ('$unique_id', '$name', '$age', '$blood', '$city', '$contact', '$notes')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode([
            "status" => "success",
            "message" => "Donor registered successfully!",
            "unique_id" => $unique_id
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Error: " . $conn->error
        ]);
    }

    $conn->close();
}
?>
