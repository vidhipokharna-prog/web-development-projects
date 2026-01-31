<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bloodbank";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Database Connection Failed: " . $conn->connect_error);
}

$successMsg = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST['name'];
  $age = $_POST['age'];
  $blood = $_POST['blood'];
  $city = $_POST['city'];
  $contact = $_POST['contact'];
  $message = $_POST['message'];

  $unique_id = substr(strtoupper(uniqid('ID')), -6);

  $sql = "INSERT INTO donor (unique_id, name, age, blood_group, city, contact, notes)
          VALUES ('$unique_id', '$name', '$age', '$blood', '$city', '$contact', '$message')";

  if ($conn->query($sql) === TRUE) {
    // Instead of returning JSON, we show frontend HTML
    echo "
    <html>
    <head>
      <title>Registration Successful</title>
      <style>
        body {
          font-family: 'Poppins', sans-serif;
          background: linear-gradient(135deg, #ff9a9e, #fad0c4);
          text-align: center;
          margin-top: 100px;
        }
        .card {
          display: inline-block;
          background: white;
          padding: 40px;
          border-radius: 12px;
          box-shadow: 0 5px 15px rgba(0,0,0,0.2);
          max-width: 500px;
        }
        .btn {
          display: inline-block;
          margin-top: 20px;
          background: #d32f2f;
          color: white;
          border: none;
          padding: 12px 25px;
          border-radius: 8px;
          text-decoration: none;
          font-size: 16px;
        }
        .btn:hover {
          background: #b71c1c;
        }
      </style>
    </head>
    <body>
      <div class='card'>
        <h2>🎉 Thank You, $name!</h2>
        <p>You have been registered as a <b>$blood</b> donor.</p>
        <p>Your Donor ID: <b>$unique_id</b></p>
        <a href='card.html' class='btn'>🏠 Generate donor card</a>
      </div>
    </body>
    </html>
    ";
  } else {
    echo "
    <html>
    <head><title>Error</title></head>
    <body><h3>Error: " . $conn->error . "</h3></body>
    </html>";
  }
}
?>
