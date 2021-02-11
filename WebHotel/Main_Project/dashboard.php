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

$changeUsername = $changeEmail = $changePassword ="";
$changeUsernameErr = $changeEmailErr = $changePasswordErr = "";
$myID = $_SESSION["bookingAgentID"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["changeUsername"])) {
        $changeUsernameErr = "Username is not changed";
    } else {
        $changeUsername = test_input($_POST["changeUsername"]);
        if (!preg_match("/^[a-zA-Z ]*$/", $changeUsername)) {
            $changeUsernameErr = "Only letters and white space allowed ";
            $changeUsername = "";
        }
    }

    if (empty($_POST["changeEmail"])) {
        $changeEmailErr = "Email is not changed";
    } else {
        $changeEmail = test_input($_POST["changeEmail"]);
        if (!filter_var($changeEmail, FILTER_VALIDATE_EMAIL)) {
            $changeEmailErr = "Invalid email format";
            $changeEmail = "";
        }
    }

    if (empty($_POST["changePassword"])) {
        $changePasswordErr = "Password is not changed";
    } else {
        $changePassword = $_POST["changePassword"];
    }

    if($changeUsername != ""){
        $sql = "UPDATE bookingagent SET bookingAgentUsername ='$changeUsername' WHERE bookingAgentID = '$myID'";
        if ($conn->query($sql) === TRUE) {
            echo "";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    if($changeEmail != ""){
        $sql2 = "UPDATE bookingagent SET bookingAgentEmail ='$changeEmail' WHERE bookingAgentID = '$myID'";
        if ($conn->query($sql2) === TRUE) {
            echo "";
        } else {
            echo "Error: " . $sql2 . "<br>" . $conn->error;
        }
    }
    if($changePassword != ""){
        $sql3 = "UPDATE bookingagent SET bookingAgentPassword = '$changePassword' WHERE bookingAgentID = '$myID'";
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
        <div class="form-group">
            <input type="text" class="form-control" id="changeUsername" name="changeUsername" placeholder="Change Username">
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                echo $changeUsernameErr;
                echo " Your Input: " . $changeUsername;
            }
            ?>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" id="changeEmail" name="changeEmail" placeholder="Change E-Mail">
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                echo $changeEmailErr;
                echo " Your Input: " . $changeEmail;
            }
            ?>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" id="changePassword" name="changePassword" placeholder="Change Password">
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                echo $changePasswordErr;
                echo " Your Input: " . $changePassword;
            }
            ?>
        </div>
        <div class="form-group">
            <button type="submit" name="submit" class="btn btn-primary btn-block">Update</button>
        </div>
    </form>
</body>

</html>
