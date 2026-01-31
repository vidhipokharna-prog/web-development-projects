<?php
$city = $_GET['city'];

$conn = new mysqli("localhost", "root", "", "bloodbank");

$query = "SELECT id, hospital_name FROM hospitals WHERE city LIKE ?";
$stmt = $conn->prepare($query);
$cityLike = "%$city%";
$stmt->bind_param("s", $cityLike);
$stmt->execute();

$result = $stmt->get_result();
$hospitals = [];

while ($row = $result->fetch_assoc()) {
    $hospitals[] = $row;
}

echo json_encode($hospitals);
?>
