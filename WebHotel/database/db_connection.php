<!--http://localhost/PhpStormProjects/WebProgramming/database/db_connection.php-->
<?php
$servername = "localhost";
$dbusername = "genuser";
$dbpassword = "genuser1234";
$db = "webprogram";

// Create connection
global $conn;
$conn = new mysqli($servername, $dbusername, $dbpassword,$db);
mysqli_set_charset($conn,'utf8');

// Check connection
if ($conn->connect_error) {
    echo "Access Denied";
}
?>