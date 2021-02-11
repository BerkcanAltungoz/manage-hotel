<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" a href="../css/header.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
<div class="custom-padding">
    <nav role="navigation">
        <h4 class="header4">Paradise Hotel</h4>
        <ul class="menu-area">
            <li><a href="home.php">Home</a></li>
            <li><a href="guestlist.php">Guests</a></li>
            <li><a href="roomlist.php">Rooms</a></li>
            <li><a href="bookinglist.php">Bookings</a></li>
            <li><a href="bookingagentlist.php">Booking Agents</a></li>
            <?php
            if ($_SESSION["loggedIn"] == true) {
                echo '<li><a href="#" aria-haspopup="true"><i class="fa fa-user"> </i>' . htmlspecialchars($_SESSION["username"]) . '<i class="fa fa-chevron-down"></i></a>';
                echo '<ul class="dropdown" aria-label="submenu">';
                echo '<li><a href="dashboard.php">Dashboard</a></li>';
                echo '<li><a href="logout.php" class="logout">Logout</a></li>';
                echo "</ul>";
                echo "</li>";
                echo "</ul>";
            } else {
                echo '<li><a href ="login.php">Login</a></li>';
            }
            ?>
    </nav>
</div>
</body>
</html>