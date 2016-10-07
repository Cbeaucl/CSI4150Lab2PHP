<!DOCTYPE html>
<html>
<head>
	<title>Mkay</title>
</head>
<body>
<?php
require __DIR__ . '/vendor/autoload.php';
use Twilio\Rest\Client;

// Step 2: set our AccountSid and AuthToken from https://twilio.com/console
$AccountSid = "AC348ab27f6449ab735e000a5ad9f1a107";
$AuthToken  = "2ac9298e2d4655da9fa879151d408765";
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "lab1test";
$name = htmlspecialchars($_POST['name']);
$sql = "SELECT * FROM users WHERE username = '$name'	";
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$number = "";
$alpha  = 1;
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        echo " - Phone: " . $row["phone"] . " Alpha" . $row["alpha"] . "<br>";
        $number = $row["phone"];
        $alpha  = $row["alpha"];
    }
} else {
    echo "0 results";
}
$conn->close();

$b = rand(1,100);
$p = 23;
$g =  5;

$beta = pow($g,$b) % $p;
echo "$beta";
// Step 3: instantiate a new Twilio Rest Client
$client = new Client($AccountSid, $AuthToken);

// Step 4: make an array of people we know, to send them a message.
// Feel free to change/add your own phone number and name here.
$people = array(
    "+$number" => htmlspecialchars($_POST['name']),
);

// Step 5: Loop over all our friends. $number is a phone number above, and
// $name is the name next to it
foreach ($people as $number => $name) {

    $sms = $client->account->messages->create(

        // the number we are sending to - Any phone number
        $number,

        array(
            // Step 6: Change the 'From' number below to be a valid Twilio number
            // that you've purchased
            'from' => "+16132097226",

            // the sms body
            'body' => "Two Factor Auth Thing = $beta",
        )
    );

    // Display a confirmation message on the screen
    echo "Sent message to $name";
    function hmac_sign($message, $key)
    {
        return hash_hmac('sha256', $message, $key) . $message;
    }
    function hmac_verify($bundle, $key)
    {
        $msgMAC  = mb_substr($bundle, 0, 64, '8bit');
        $message = mb_substr($bundle, 64, null, '8bit');
        return hash_equals(
            hash_hmac('sha256', $message, $key),
            $msgMAC
        );
    }
}
?>

</body>
</html>