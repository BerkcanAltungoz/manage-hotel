<?php
session_start();
include "../database/db_connection.php";
include "header.php";
if ($_SESSION["loggedIn"] == false) {
    header("Location:login.php");
}
?>
<!--    http://localhost/PhpStormProjects/WebProgramming/roomlist.php  -->


<html>
<head>
    <meta charset="UTF-8">
    <title>Room List</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
    <style rel="stylesheet">
        .wrapper {
            width: 1000px;
            margin: 0 auto;
        }

        .page-header h2 {
            margin-top: 0;
            margin-right: 20px;
        }

        .search{
            font-size: 20px;
        }

    </style>
    <script type="text/javascript">
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
</head>
<body background="../stuff/background.jpg">
<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-15">
                <div class="page-header clearfix">
                    <h2 class="pull-left">Room List</h2>
                    <input type="text" class ="search" id="myInput" onkeyup="myFunction()" placeholder="Search for Status">
                </div>
                <?php
                // Include config file
                require_once "../database/db_connection.php";

                // Attempt select query execution
                $sql = "SELECT * FROM rooms";
                if ($result = mysqli_query($conn, $sql)) {
                    if (mysqli_num_rows($result) > 0) {
                        echo "<table id = 'myTable'class='table table-bordered table-striped'>";
                        echo "<thead>";
                        echo "<tr class ='header'>";
                        echo "<th>ID</th>";
                        echo "<th>Number</th>";
                        echo "<th>Type</th>";
                        echo "<th>Floor</th>";
                        echo "<th>Price</th>";
                        echo "<th>Description</th>";
                        echo "<th>Status</th>";
                        echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";
                        while ($row = mysqli_fetch_array($result)) {
                            echo "<tr>";
                            echo "<td>" . $row['roomID'] . "</td>";
                            echo "<td>" . $row['roomNumber'] . "</td>";
                            echo "<td>" . $row['roomType'] . "</td>";
                            echo "<td>" . $row['roomFloor'] . "</td>";
                            echo "<td>" . $row['roomPrice'] . "</td>";
                            echo "<td>" . $row['roomDesc'] . "</td>";
                            echo "<td>" . $row['roomStatus'] . "</td>";
                            echo "</tr>";
                        }
                        echo "</tbody>";
                        echo "</table>";
                        // Free result set
                        mysqli_free_result($result);
                    } else {
                        echo "<p class='lead'><em>No records were found.</em></p>";
                    }
                } else {
                    echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
                }

                // Close connection
                mysqli_close($conn);
                ?>
            </div>
        </div>
    </div>
</div>
<script>
    function myFunction() {
        // Declare variables
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("myTable");
        tr = table.getElementsByTagName("tr");

        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[6];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
</script>

</body>
</html>
