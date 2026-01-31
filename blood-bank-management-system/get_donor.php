<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bloodbank"; // your database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die(json_encode(["status" => "error", "message" => "Database connection failed!"]));
}

if (isset($_GET['unique_id'])) {
  $unique_id = $conn->real_escape_string($_GET['unique_id']);

  // ✅ correct table name
  $sql = "SELECT unique_id, name, blood_group, city FROM donor WHERE unique_id = '$unique_id'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode(["status" => "success", "data" => $row]);
  } else {
    echo json_encode(["status" => "error", "message" => "No donor found with that ID!"]);
  }
} else {
  echo json_encode(["status" => "error", "message" => "Unique ID not provided!"]);
}

$conn->close();
?>
