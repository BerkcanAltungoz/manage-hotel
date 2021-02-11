<!DOCTYPE html>
<html>
<!--    http://localhost/PhpStormProjects/WebProgramming/register.php  -->
<head>
    <meta charset="utf-8">
    <title>Register</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../css/mainCSS.css">
</head>
<body background="../stuff/beach.jpg">
<?php
// connection to database
include "../database/db_connection.php";


$name = $email = $surname = $username = $password = $gender = $img_path = $fileToUploadConfirm = "";
$nameErr = $emailErr = $surnameErr = $usernameErr = $passwordErr = $genderErr = $fileToUploadErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["name"])) {
        $nameErr = "Name is required";
    } else {
        $name = test_input($_POST["name"]);
        if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
            $nameErr = "Only letters and white space allowed ";
            $name = "";
        }
    }

    if (empty($_POST["surname"])) {
        $surnameErr = "Surname is required";
    } else {
        $surname = test_input($_POST["surname"]);
        if (!preg_match("/^[a-zA-Z ]*$/", $surname)) {
            $surnameErr = "Only letters and white space allowed";
            $surname = "";
        }
    }

    if (empty($_POST["username"])) {
        $usernameErr = "Username is required";
    } else {
        $username = test_input($_POST["username"]);
        if (!preg_match("/^[a-zA-Z ]*$/", $username)) {
            $usernameErr = "Only letters and white space allowed";
            $username = "";
        }
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

    if (!empty($_POST["password"])) {
        $password = test_input($_POST["password"]);
    } else {
        $passwordErr = "Password is Required";
    }

    if (!empty($_POST["gender"])) {
        $gender = ($_POST["gender"]);
    } else {
        $genderErr = "Gender is Required";
    }

    //IMAGE UPLOAD
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $fileToUploadErr = "File is not an image.";
            $uploadOk = 0;
        }
    }
// Check if file already exists
    if (file_exists($target_file)) {
        $fileToUploadErr = "Sorry, file already exists.";
        $uploadOk = 0;
    }
// Check file size
    if ($_FILES["fileToUpload"]["size"] > 500000) {
        $fileToUploadErr = "Sorry, your file is too large.";
        $uploadOk = 0;
    }
// Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif") {
        $fileToUploadErr = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }
// Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        $fileToUploadErr = "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            $img_path = "uploads/" . basename($_FILES["fileToUpload"]["name"]);
            $fileToUploadConfirm = "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.";
        } else {
            $fileToUploadErr = "Sorry, there was an error uploading your file.";
        }
    }

    // Insert Data to DB
//    if ($username != "" && $name != "" && $surname != "" && $password != "" && $email != "" && $gender != "" && $img_path != "") {
//        $sql = "INSERT INTO users (name, surname, username, password, email, gender, img_path)
//    VALUES ('$name', '$surname', '$username', '$password', '$email', '$gender' , '$img_path')";
//
//        if ($conn->query($sql) === TRUE) {
//            echo "-New record created successfully";
//        } else {
//            echo "Error: " . $sql . "<br>" . $conn->error;
//        }
//
//    }
    if ($username != "" && $name != "" && $surname != "" && $password != "" && $email != "" && $gender != "" && $img_path != "") {
        $sql = "INSERT INTO bookingagent (bookingAgentFirstname, bookingAgentSurname, bookingAgentUsername, bookingAgentPassword, bookingAgentEmail, bookingAgentGender, bookingAgentIMG_PATH)
    VALUES ('$name', '$surname', '$username', '$password', '$email', '$gender' , '$img_path')";

        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
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
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
        <h2 class="text-center">Please Fill the Fields</h2>
        <div class="form-group">
            <input type="text" class="form-control" id="name" name="name" placeholder="Name" required="required">
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                echo $nameErr;
                echo "Your Input: " . $name;
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
            <input type="text" class="form-control" id="username" name="username" placeholder="Username"
                   required="required">
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                echo $usernameErr;
                echo "    Your Input: " . $username;
            }
            ?>

        </div>
        <div class="form-group">
            <input type="text" class="form-control" id="email" name="email" placeholder="E-mail" required="required">
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                echo $emailErr;
                echo "    Your Input: " . $email;
            }
            ?>
        </div>
        <div class="form-group">
            <input type="password" class="form-control" id="password" name="password" placeholder="Password"
                   required="required">
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                echo $passwordErr;
            }
            ?>
        </div>
        Gender:
        <input type="radio" name="gender"
            <?php if (isset($gender) && $gender == "male") echo "checked"; ?>
               value="male">Male
        <input type="radio" name="gender"
            <?php if (isset($gender) && $gender == "female") echo "checked"; ?>
               value="female">Female
        <input type="radio" name="gender"
            <?php if (isset($gender) && $gender == "other") echo "checked"; ?>
               value="other">Other
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            echo $genderErr;
        }
        ?>
        <br><br>
        Select image to upload:
        <input type="file" name="fileToUpload" id="fileToUpload">
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            echo $fileToUploadErr;
            echo $fileToUploadConfirm;
        }
        ?>
        <br>
        <div class="form-group">
            <button type="submit" name="submit" class="btn btn-primary btn-block">Sign Up</button>
        </div>
    </form>
</div>
<footer class="footer">
    <?php
    include "footer.php";
    ?>
</footer>
</body>
</html>