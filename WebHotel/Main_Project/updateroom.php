<!DOCTYPE html>
<html>
<!--    http://localhost/PhpStormProjects/WebProgramming/dashboard.php  -->
<head>
    <meta charset="utf-8">
    <title>Dashboard</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../css/mainCSS.css">
</head>
<body background="../stuff/background.jpg">
<?php
session_start();
include "../database/db_connection.php";
include "header.php";
if($_SESSION["loggedIn"] == false) {
    header("Location:login.php");
}

$changeType = $changePrice = $changeDesc = $changingRoomID ="";
$changeTypeErr = $changePriceErr = $changeDescErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $changingRoomID = $_POST["roomOption"];

    if (empty($_POST["changeType"])) {
        $changeTypeErr = "Type is not changed";
    } else {
        $changeType = test_input($_POST["changeType"]);
        if (!preg_match("/^[a-zA-Z ]*$/", $changeType)) {
            $changeTypeErr = "Only letters and white space allowed ";
            $changeType = "";
        }
    }

    if (empty($_POST["changePrice"])) {
        $changePriceErr = "Price is not changed";
    } else {
        $changePrice = $_POST["changePrice"];
    }

    if (empty($_POST["changeDesc"])) {
        $changeDescErr = "Description is not changed";
    } else {
        $changeDesc = test_input($_POST["changeDesc"]);
        if (!preg_match("/^[a-zA-Z ]*$/", $changeDesc)) {
            $changeDescErr = "Only letters and white space allowed ";
            $changeDesc = "";
        }
    }

    if($changePrice != ""){
        $sql = "UPDATE rooms SET roomPrice ='$changePrice' WHERE roomID = '$changingRoomID'";
        if ($conn->query($sql) === TRUE) {
            echo "";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    if($changeType != ""){
        $sql2 = "UPDATE rooms SET roomType ='$changeType' WHERE roomID = '$changingRoomID'";
        if ($conn->query($sql2) === TRUE) {
            echo "";
        } else {
            echo "Error: " . $sql2 . "<br>" . $conn->error;
        }
    }
    if($changeDesc != ""){
        $sql3 = "UPDATE rooms SET roomDesc = '$changeDesc' WHERE roomID = '$changingRoomID'";
        if ($conn->query($sql3) === TRUE) {
            echo "";
        } else {
            echo "Error: " . $sql3 . "<br>" . $conn->error;
        }
    }


}
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>
<div class="login-form">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <h2 class="text-center">Change Settings of Your Choosing</h2>
        Room:
        <select name="roomOption" id="roomOption">
            <?php
            $sql = "SELECT roomNumber,roomType,roomFloor,roomID,roomStatus FROM rooms";
            $result = $conn->query($sql);
            if (mysqli_num_rows($result) > 0) {
                // output data of each row
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='" . $row['roomID'] . "'>No: " . $row['roomNumber'] . " - Type: " . $row['roomType'] . " - Floor: " . $row['roomFloor'] . "</option>";
                }
            }
            ?>
        </select>
        <div class="form-group">
            <input type="text" class="form-control" id="changeType" name="changeType" placeholder="Change Type">
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                echo $changeTypeErr;
                echo " Your Input: " . $changeType;
            }
            ?>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" id="change" name="changePrice" placeholder="Change Price">
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                echo $changePriceErr;
                echo " Your Input: " . $changePrice;
            }
            ?>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" id="changeDesc" name="changeDesc" placeholder="Change Description">
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                echo $changeDescErr;
                echo " Your Input: " . $changeDesc;
            }
            ?>
        </div>
        <div class="form-group">
            <button type="submit" name="submit" class="btn btn-primary btn-block">Update</button>
        </div>
    </form>
</body>

</html>
