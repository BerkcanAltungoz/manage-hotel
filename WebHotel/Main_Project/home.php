<!DOCTYPE html>
<html>
<!--    http://localhost/PhpStormProjects/WebProgramming/home.php  -->

<head>
    <meta charset="utf-8">
    <title>Home</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../css/mainCSS.css">
</head>
<body background="../stuff/beach.jpg">
<?php
session_start();
include "header.php";
if ($_SESSION["loggedIn"] == false) {
    header("Location:login.php");
}
?>
<h1 align="center">
    <span class="label label-primary">Welcome Administrator</span>
</h1>
<br>
<?php
$profilePicture ="../" . $_SESSION["bookingAgentIMG_PATH"];
echo "<div align='center'>";
echo "<img src='" . $profilePicture . "'alt='Profile Picture'>";
echo "</div>";
?>
<br><br>
<div class="form-group" align="center">
    <a href="addguest.php" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Add a Guest</a>
    <a href="addbooking.php" class="btn btn-warning btn-lg active" role="button" aria-pressed="true">Add a Booking</a>
    <a href="updateroom.php" class="btn btn-success btn-lg active" role="button" aria-pressed="true">Update Room</a>

</div>
</body>
</html>