<!DOCTYPE html>
<html>
<!--    http://localhost/PhpStormProjects/WebProgramming/addbooking.php  -->


<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../css/mainCSS.css">
    <link rel="stylesheet" href="../css/dateCSS.css">
    <title>Add Booking</title>
</head>
<body background="../stuff/background.jpg">
<?php
session_start();
include "../database/db_connection.php";
include "header.php";
if ($_SESSION["loggedIn"] == false) {
    header("Location:login.php");
}

$dateMade = date("Y-m-d");
$timeMade = date("H:i:s");
$startDate = $endDate = $guestOption = $roomOption = "";
$startDateErr = $endDateErr = $guestOptionErr = $roomOptionErr = "";
$myID = $_SESSION["bookingAgentID"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["startDate"])) {
        $startDateErr = "Start Date is required";
    } else {
        $startDate = $_POST["startDate"];
    }

    if (empty($_POST["endDate"])) {
        $endDateErr = "End Date is required";
    } else {
        $endDate = $_POST["endDate"];
    }
    $roomOption = $_POST["roomOption"];
    $guestOption = $_POST["guestOption"];

    if ($startDate != "" && $endDate != "") {
        $sql = "INSERT INTO bookings (FK_bookingAgentID,bookingDateMade, bookingTimeMade, bookingStartDate, bookingEndDate) 
VALUES ('$myID','$dateMade', '$timeMade' , '$startDate' , '$endDate')";

        if ($conn->query($sql) === TRUE) {
            $bookingID = $conn->insert_id;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $sql2 = "INSERT INTO bookingsrooms (FK_bookingID,FK_roomID,FK_guestID) 
VALUES('$bookingID','$roomOption','$guestOption')";
        if ($conn->query($sql2) === TRUE) {
            echo "";
        } else {
            echo "Error: " . $sql2 . "<br>" . $conn->error;
        }

        $sql3 = "UPDATE rooms SET roomStatus='Occupied' WHERE roomID='$roomOption'";
        if ($conn->query($sql3) === TRUE) {
            echo "";
        } else {
            echo "Error: " . $sql3 . "<br>" . $conn->error;
        }
    }


}


?>
<div class="login-form">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <h2 class="text-center">Select The Dates And The Guest For The Booking</h2>
        Start Date: <input type="date" id="startDate" name="startDate" required="required">
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            echo $startDateErr;
            echo "Your Input: " . $startDate;
        }
        ?>
        <br><br>
        End Date: <input type="date" name="endDate" id="endDate" required="required">
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            echo $endDateErr;
            echo "Your Input: " . $endDate;
        }
        ?>
        <br><br>
        Guest:
        <select name="guestOption" id="guestOption">
            <?php
            $sql = "SELECT guestFirstname,guestSurname,guestUniqueNumber,guestID FROM guests";
            $result = $conn->query($sql);
            if (mysqli_num_rows($result) > 0) {
                // output data of each row
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='" . $row['guestID'] . "'.>" . $row['guestFirstname'] . "  " . $row['guestSurname'] . "-" . $row['guestUniqueNumber'] . "</option>";
                }
            }
            ?>
        </select>
        <br><br>
        Room:
        <select name="roomOption" id="roomOption">
            <?php
            $sql = "SELECT roomNumber,roomType,roomFloor,roomID,roomStatus FROM rooms WHERE roomStatus='Available' ";
            $result = $conn->query($sql);
            if (mysqli_num_rows($result) > 0) {
                // output data of each row
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='" . $row['roomID'] . "'>No: " . $row['roomNumber'] . " - Type: " . $row['roomType'] . " - Floor: " . $row['roomFloor'] . "</option>";
                }
            }
            ?>
        </select>

        <br><br>
        <div class="form-group">
            <button type="submit" name="submit" class="btn btn-primary btn-block">Book</button>
        </div>
    </form>
</body>
</html>
