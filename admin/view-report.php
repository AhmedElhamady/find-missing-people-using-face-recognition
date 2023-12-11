<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require("../config/database.php");

    $query_report = "SELECT * FROM `report` WHERE `id`=" . $_POST["id"];
    $result_report = mysqli_query($connection, $query_report);
    $row_report = mysqli_fetch_assoc($result_report);
    $user_id = $row_report["user-id"];

    $query_user = "SELECT * FROM `users` WHERE `id`=" . $user_id;
    $result_user = mysqli_query($connection, $query_user);
    $row_user = mysqli_fetch_assoc($result_user);
    $row_report["user"] = $row_user;
    // return Json
    echo json_encode($row_report);
    // return json_encode($row_report);
}