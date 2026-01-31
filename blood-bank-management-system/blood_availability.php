<?php
$conn = new mysqli("localhost", "root", "", "bloodbank");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// JOIN hospitals + blood_stock
$sql = "
    SELECT 
        hospitals.hospital_name,
        hospitals.city,
        blood_stock.blood_type,
        blood_stock.available_units
    FROM blood_stock
    INNER JOIN hospitals 
        ON blood_stock.hospital_id = hospitals.id
    ORDER BY hospitals.hospital_name, blood_stock.blood_type
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Blood Availability</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background:#f7f7f7;
            padding:20px;
        }
        h2 {
            text-align:center;
            margin-bottom:20px;
        }
        table {
            width:100%;
            border-collapse:collapse;
            background:white;
            border-radius:8px;
            overflow:hidden;
            box-shadow:0 3px 10px rgba(0,0,0,0.1);
        }
        th, td {
            padding:12px;
            text-align:center;
            border-bottom:1px solid #ddd;
        }
        th {
            background:#b30000;
            color:white;
        }
        tr:hover {
            background:#ffe6e6;
        }
        .container {
            max-width:900px;
            margin:auto;
        }
    </style>
</head>

<body>
<div class="container">
    <h2>Available Blood Units in Hospitals</h2>
    <!-- 🔙 BACK TO HOME BUTTON -->
    <div class="header">
        <a href="home.html">← Back to Home</a>
        <h2>Blood Availability</h2>
        <div></div>
    </div>

    <table>
        <tr>
            <th>Hospital Name</th>
            <th>City</th>
            <th>Blood Type</th>
            <th>Available Units</th>
        </tr>

        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "
                <tr>
                    <td>{$row['hospital_name']}</td>
                    <td>{$row['city']}</td>
                    <td>{$row['blood_type']}</td>
                    <td>{$row['available_units']}</td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No data available</td></tr>";
        }
        ?>
    </table>
</div>
</body>
</html>
