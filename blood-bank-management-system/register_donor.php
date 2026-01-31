<?php
include('db_config.php'); // Include database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $blood = $_POST['blood'];
    $city = $_POST['city'];
    $contact = $_POST['contact'];
    $message = $_POST['message'];

    // Generate unique donor ID (OTP style)
    $unique_id = 'BB' . rand(100000, 999999);

    // Save donor to database
    $sql = "INSERT INTO donor (unique_id, name, age, blood_group, city, contact, notes)
            VALUES ('$unique_id', '$name', '$age', '$blood', '$city', '$contact', '$message')";

    if ($conn->query($sql) === TRUE) {
        echo "
        <html>
        <head>
            <style>
                body { 
                    font-family: Poppins, sans-serif;
                    background: #fff4f4; 
                    text-align: center; 
                    padding-top: 50px;
                }
                h2 { color: #d32f2f; }
                .box {
                    display: inline-block;
                    background: #fff;
                    padding: 25px;
                    border-radius: 15px;
                    box-shadow: 0 0 10px rgba(0,0,0,0.15);
                }
                a {
                    text-decoration: none;
                    background: #d32f2f;
                    color: white;
                    padding: 10px 15px;
                    border-radius: 8px;
                    display: inline-block;
                    margin-top: 15px;
                }
                a:hover { background: #b71c1c; }
            </style>
        </head>
        <body>
            <div class='box'>
                <h2>🎉 Donor Registered Successfully!</h2>
                <p><b>Your Unique Donor ID:</b> $unique_id</p>
                <p>We’ve also sent this ID via SMS to your phone.</p>
                <a href='index.html'>Go Back</a>
            </div>
        </body>
        </html>
        ";

        // OPTIONAL — Send SMS using Fast2SMS
        $apiKey = urlencode('YOUR_FAST2SMS_API_KEY');
        $sender_id = urlencode('FSTSMS');
        $message = rawurlencode("Thank you for registering as a donor! Your BloodBank ID is $unique_id.");
        $numbers = urlencode($contact);

        $data = array(
            'sender_id' => $sender_id,
            'message' => $message,
            'language' => 'english',
            'route' => 'v3',
            'numbers' => $contact,
        );

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://www.fast2sms.com/dev/bulkV2",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array(
                "authorization: $apiKey",
                "accept: */*",
                "cache-control: no-cache",
                "content-type: application/json"
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
}
?>
