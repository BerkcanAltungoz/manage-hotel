<!DOCTYPE html>
<html>
<!--    http://localhost/PhpStormProjects/WebProgramming/addguest.php  -->
<head>
    <meta charset="utf-8">
    <title>Add Guest</title>
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


$firstname = $surname = $uniqueNo = $email = $address = $phoneNo = "";
$firstnameErr = $surnameErr = $uniqueNoErr = $emailErr = $addressErr = $phoneNoErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["firstname"])) {
        $firstnameErr = "Firstname is required";
    } else {
        $firstname = test_input($_POST["firstname"]);
        if (!preg_match("/^[a-zA-Z ]*$/", $firstname)) {
            $firstnameErr = "Only letters and white space allowed ";
            $firstname = "";
        }
    }

    if (empty($_POST["surname"])) {
        $surnameErr = "Surname is required";
    } else {
        $surname = test_input($_POST["surname"]);
        if (!preg_match("/^[a-zA-Z ]*$/", $surname)) {
            $surnameErr = "Only letters and white space allowed ";
            $surname = "";
        }
    }

    if (empty($_POST["uniqueNo"])) {
        $uniqueNoErr = "TC/Passport number is required";
    } else {
        $uniqueNo = test_input($_POST["uniqueNo"]);
    }

    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = test_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
            $email = "";
        }
    }

    if (empty($_POST["address"])) {
        $addressErr = "Address is required";
    } else {
        $address = $_POST["address"];
    }

    if (empty($_POST["phoneNo"])) {
        $phoneNoErr = "Phone number is required";
    } else {
        $phoneNo = test_input($_POST["phoneNo"]);
        if (!preg_match("/^[a-zA-Z ]*$/", $surname)) {
            $phoneNoErr = "Only letters and white space allowed ";
            $phoneNo = "";
        }
    }
    if ($firstname != "" && $surname != "" && $address != "" && $uniqueNo != "" && $email != "" && $phoneNo != "") {
        $sql = "INSERT INTO guests (guestFirstname, guestSurname, guestUniqueNumber, guestAddress, guestPhone, guestEmail)
    VALUES ('$firstname', '$surname', '$uniqueNo', '$address', '$phoneNo', '$email')";

        if ($conn->query($sql) === TRUE) {
            echo "";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

    }
    $conn->close();


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
        <h2 class="text-center">Please Fill the Fields to Add a Guest</h2>
        <div class="form-group">
            <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Firstname"
                   required="required">
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                echo $firstnameErr;
                echo "Your Input: " . $firstname;
            }
            ?>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" id="surname" name="surname" placeholder="Surname"
                   required="required">
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                echo $surnameErr;
                echo "    Your Input: " . $surname;
            }
            ?>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" id="uniqueNo" name="uniqueNo" placeholder="TC/Passport Number"
                   required="required">
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                echo $uniqueNoErr;
                echo "    Your Input: " . $uniqueNo;
            }
            ?>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" id="email" name="email" placeholder="E-Mail" required="required">
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                echo $emailErr;
                echo "    Your Input: " . $email;
            }
            ?>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" id="address" name="address" placeholder="Address"
                   required="required">
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                echo $addressErr;
            }
            ?>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" id="phoneNo" name="phoneNo" placeholder="Phone Number"
                   required="required">
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                echo $phoneNoErr;
            }
            ?>
        </div>
        <div class="form-group">
            <button type="submit" name="submit" class="btn btn-primary btn-block">Add Guest</button>
        </div>
    </form>
</body>

</html>