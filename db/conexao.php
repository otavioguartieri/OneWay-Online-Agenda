<?php
    $dbserver = "mysql";
    $dbuser = "root";
    $dbpass = "root";
    $dbname = "oneway";

    $conn = new mysqli($dbserver, $dbuser, $dbpass);

    $conn->query("CREATE DATABASE IF NOT EXISTS `$dbname` DEFAULT CHARACTER SET utf8 COLLATE utf8mb3_general_ci");

    $conn = mysqli_connect($dbserver, $dbuser, $dbpass, $dbname);
    if (!$conn) {
        echo 'Error DB Connection';
    }
?>