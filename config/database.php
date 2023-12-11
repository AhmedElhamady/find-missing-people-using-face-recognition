<?php
require 'constants.php';
//connect to the database 
$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if (!$connection) {
    echo mysqli_connect_errno();
    exit;
}
