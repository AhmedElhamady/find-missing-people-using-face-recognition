<?php
session_start();
require("config/database.php");
if (isset($_SESSION["id"]) && isset($_SESSION["admin"])) {
    if (isset($_GET["id"])) {
        $id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);
        $report = "SELECT `id`, `user-id`, `photo` from report WHERE `id`= '" . $id . "'";
        $report_result = mysqli_query($connection, $report);
        $report_row = mysqli_fetch_assoc($report_result);
        if (!empty($report_row)) {
            $photo = $report_row["photo"];
            unlink("../uploads/$photo");
            $query = "DELETE FROM report WHERE id = '" . $id . "' ";
            if (mysqli_query($connection, $query)) {
                $_SESSION['report-success'] = "The report has been deleted successfully";
                header("location: " . ROOT_URL . "admin/dashboard.php");
            }
        } else {
            header("location: " . ROOT_URL . "admin/dashboard.php");
        }
    } else {
        header("location: " . ROOT_URL . "admin/dashboard.php");
    }
} else {
    header("location: " . ROOT_URL);
}
