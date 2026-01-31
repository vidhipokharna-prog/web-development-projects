<?php
$conn = new mysqli('localhost', 'root', '', 'bloodbank');
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Blood Bank Dashboard</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #ffecec;
      margin: 0;
      padding: 20px;
    }
    h1 {
      text-align: center;
      color: #b30000;
    }
    .section {
      margin: 40px auto;
      width: 90%;
      background: #fff;
      box-shadow: 0 0 10px rgba(0,0,0,0.2);
      padding: 20px;
      border-radius: 10px;
    }
    h2 {
      background: #b30000;
      color: white;
      padding: 10px;
      border-radius: 5px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 15px;
    }
    th, td {
      border: 1px solid #ccc;
      padding: 10px;
      text-align: center;
    }
    th {
      background: #f44336;
      color: white;
    }

    .back {
      position: fixed;
      left: 20px;
      top: 20px;
      background: #b30000;
      padding: 10px 15px;
      color: white;
      border-radius: 5px;
      text-decoration: none;
      font-weight: bold;
    }
  </style>
</head>
<body>

<a href="home.html" class="back">⬅ Back to Home</a>

<h1>🩸 Blood Bank Management Dashboard</h1>

<!-- Donors Section -->
<div class="section">
  <h2>Donors List</h2>
  <table>
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Age</th>
      <th>Blood Group</th>
      <th>Contact</th>
      <th>City</th>
      <th>Hospital</th>
    </tr>
    <?php
    $donors = $conn->query("
      SELECT d.*, h.hospital_name 
      FROM donors d 
      LEFT JOIN hospitals h ON d.hospital_id = h.id
    ");
    if ($donors->num_rows > 0) {
      while($d = $donors->fetch_assoc()) {
        echo "<tr>
          <td>{$d['donor_id']}</td>
          <td>{$d['name']}</td>
          <td>{$d['age']}</td>
          <td>{$d['blood_group']}</td>
          <td>{$d['contact']}</td>
          <td>{$d['city']}</td>
          <td>{$d['hospital_name']}</td>
        </tr>";
      }
    } else {
      echo "<tr><td colspan='7'>No donors found</td></tr>";
    }
    ?>
  </table>
</div>

<!-- Receivers Section -->
<div class="section">
  <h2>Receivers List</h2>
  <table>
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Age</th>
      <th>Blood Group</th>
      <th>Contact</th>
      <th>City</th>
      <th>Hospital</th>
    </tr>
    <?php
    $receivers = $conn->query("
      SELECT r.*, h.hospital_name 
      FROM receivers r 
      LEFT JOIN hospitals h ON r.hospital_id = h.id
    ");
    if ($receivers->num_rows > 0) {
      while($r = $receivers->fetch_assoc()) {
        echo "<tr>
          <td>{$r['receiver_id']}</td>
          <td>{$r['name']}</td>
          <td>{$r['age']}</td>
          <td>{$r['blood_group']}</td>
          <td>{$r['contact']}</td>
          <td>{$r['city']}</td>
          <td>{$r['hospital_name']}</td>
        </tr>";
      }
    } else {
      echo "<tr><td colspan='7'>No receivers found</td></tr>";
    }
    ?>
  </table>
</div>

<!-- Blood Stock Section -->
<div class="section">
  <h2>Blood Stock</h2>
  <table>
    <tr>
      <th>ID</th>
      <th>Hospital</th>
      <th>City</th>
      <th>Blood Group</th>
      <th>Available Units</th>
    </tr>
    <?php
    $stock = $conn->query("
      SELECT bs.*, h.hospital_name, h.city 
      FROM blood_stock bs
      LEFT JOIN hospitals h ON bs.hospital_id = h.id
    ");

    if ($stock->num_rows > 0) {
      while ($s = $stock->fetch_assoc()) {
        echo "<tr>
          <td>{$s['id']}</td>
          <td>{$s['hospital_name']}</td>
          <td>{$s['city']}</td>
          <td>{$s['blood_type']}</td>
          <td>{$s['available_units']}</td>
        </tr>";
      }
    } else {
      echo "<tr><td colspan='5'>No blood stock data found</td></tr>";
    }
    ?>
  </table>
</div>

<!-- Requests Section -->
<div class="section">
  <h2>Blood Requests</h2>
  <table>
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Blood Group</th>
      <th>Units Needed</th>
      <th>Reason</th>
      <th>Hospital</th>
    </tr>
    <?php
    $requests = $conn->query("
      SELECT rq.*, h.hospital_name 
      FROM requests rq
      LEFT JOIN hospitals h ON rq.hospital_id = h.id
    ");

    if ($requests->num_rows > 0) {
      while($req = $requests->fetch_assoc()) {
        echo "<tr>
          <td>{$req['request_id']}</td>
          <td>{$req['name']}</td>
          <td>{$req['blood_group']}</td>
          <td>{$req['units_needed']}</td>
          <td>{$req['reason']}</td>
          <td>{$req['hospital_name']}</td>
        </tr>";
      }
    } else {
      echo "<tr><td colspan='6'>No requests found</td></tr>";
    }
    ?>
  </table>
</div>

</body>
</html>
