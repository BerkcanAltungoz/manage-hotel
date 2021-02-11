<!DOCTYPE html>
<html>
<!--    http://localhost/PhpStormProjects/WebProgramming/Main_Project/login.php  -->

<head>
    <meta charset="utf-8">
    <title>Login Page</title>
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
// connection to database
include "../database/db_connection.php";

$username = $password = $welcome = $incorrectErr = $usernameErr = $passwordErr = $boolean = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["username"])) {
        $usernameErr = "Username is required";
    } else {
        $username = test_input($_POST["username"]);
        if (!preg_match("/^[a-zA-Z ]*$/", $username)) {
            $usernameErr = "Only letters and white space allowed";
            $username = "";
        }
    }
    if (empty($_POST["password"])) {
        $passwordErr = "Password is required";
    } else {
        $password = $_POST["password"];
    }


    //VERIFY FROM DATABASE
    $sql = "SELECT bookingAgentUsername, bookingAgentPassword , bookingAgentID ,bookingAgentIMG_PATH FROM bookingagent";
    $result = $conn->query($sql);

    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            if($row["bookingAgentUsername"] ==  $username && $row["bookingAgentPassword"] == $password){
                $boolean = true;
                $bookingAgentID = $row["bookingAgentID"];
                $bookingAgentIMG_PATH = $row["bookingAgentIMG_PATH"];
                break;
            }
        }
    } else {
        $boolean = false;
    }

    if ($boolean == true) {
        $_SESSION["username"] = $username;
        $_SESSION["password"] =  $password;
        $_SESSION["loggedIn"] = true;
        $_SESSION["bookingAgentID"] = $bookingAgentID;
        $_SESSION["bookingAgentIMG_PATH"] = $bookingAgentIMG_PATH;
        header('Location: home.php');
    } else {
        echo'<div class="alert alert-danger">Incorrect Username or Password</div>';
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
<h1 align="center" >
    <span class="label label-primary">Welcome to Paradise Hotel</span>
</h1>
<div class="login-form">
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
        <h2 class="text-center">Login</h2>
        <div class="form-group">
            <input type="text" class="form-control" id="username" name="username" placeholder="Username"
                   required="required">
            <?php echo $usernameErr; ?>
        </div>
        <div class="form-group">
            <input type="password" class="form-control" id="password" name="password" placeholder="Password"
                   required="required">
            <?php echo $passwordErr; ?>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block">Login</button>
        </div>
        <a href="register.php" class="pull-right">Don't Have an Account?</a>
    </form>
</div>

</body>
<footer class="footer">
    <?php
    include "footer.php";
    ?>
</footer>
</html>