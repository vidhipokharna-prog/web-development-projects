echo "<pre>";
print_r($_POST);
echo "</pre>";

<?php
$conn = new mysqli("localhost", "root", "", "bloodbank");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$role         = $_POST['role'];
$name         = $_POST['name'];
$age          = $_POST['age'];
$contact      = $_POST['contact'];
$blood_group  = $_POST['blood_group'];
$city         = $_POST['city'];

if (!isset($_POST['hospital_id']) || $_POST['hospital_id'] == "") {
    die("Error: No hospital selected.");
}

$hospital_id = $_POST['hospital_id'];

// --------------------------------------------------------------------
// ROLE: DONOR
// --------------------------------------------------------------------
if ($role === "donor") {

    $units = $_POST['total_donated'];

    // Insert donor
    $conn->query("INSERT INTO donors (name, age, contact, blood_group, city, total_donated, hospital_id)
                  VALUES ('$name', '$age', '$contact', '$blood_group', '$city', '$units', '$hospital_id')");

    // Update blood stock
    $update = $conn->query("UPDATE blood_stock 
                            SET available_units = available_units + $units 
                            WHERE hospital_id = $hospital_id 
                            AND blood_type = '$blood_group'");

    // If row does NOT exist → insert
    if ($conn->affected_rows == 0) {
        $conn->query("INSERT INTO blood_stock (hospital_id, blood_type, available_units)
                      VALUES ($hospital_id, '$blood_group', $units)");
    }
}

// --------------------------------------------------------------------
// ROLE: RECEIVER
// --------------------------------------------------------------------
else if ($role === "receiver") {

    $units = $_POST['total_received'];

    // Insert receiver
    $conn->query("INSERT INTO receivers (name, age, contact, blood_group, city, total_received, hospital_id)
                  VALUES ('$name', '$age', '$contact', '$blood_group', '$city', '$units', '$hospital_id')");

    // Decrease blood stock
    $conn->query("UPDATE blood_stock 
                  SET available_units = available_units - $units 
                  WHERE hospital_id = $hospital_id 
                  AND blood_type = '$blood_group'");
}

// --------------------------------------------------------------------
// ROLE: REQUEST
// --------------------------------------------------------------------
else if ($role === "request") {

    $units  = $_POST['units_needed'];
    $reason = $_POST['reason'];

    // Insert request
    $conn->query("INSERT INTO requests (name, age, contact, blood_group, city, units_needed, reason, hospital_id)
                  VALUES ('$name', '$age', '$contact', '$blood_group', '$city', '$units', '$reason', '$hospital_id')");
}

echo "<script>alert('Form submitted successfully!'); window.location='home.html';</script>";
?>
