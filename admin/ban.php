<?php
session_start();
if (isset($_SESSION["id"]) && isset($_SESSION["admin"])) {
    if (isset($_GET["id"])) {
        $id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);
        require("config/database.php");
        // check if exist this user
        $query = "SELECT * from users WHERE `id`= '" . $id . "'";
        $query_result = mysqli_query($connection, $query);
        $query_row = mysqli_fetch_assoc($query_result);
        if (!empty($query_row)) {
            if ($query_row["banned"] == 0) {
                $report = "SELECT * from report WHERE `user-id`= '" . $id . "'";
                $report_result = mysqli_query($connection, $report);
                while ($report_row = mysqli_fetch_assoc($report_result)) {
                    $photo = $report_row["photo"];
                    unlink("../uploads/$photo");
                }
                $delete_report = "DELETE FROM report WHERE `user-id` = '" . $id . "' ";
                mysqli_query($connection, $delete_report);

                $ban_user = "UPDATE users set banned = 1 WHERE `id` = '" . $id . "' ";
                mysqli_query($connection, $ban_user);
                $_SESSION['user-success'] = "The user and his reports has been deleted successfully ";
            } elseif ($query_row["banned"] == 1) {
                $unban_user = "UPDATE users set banned = 0 WHERE `id` = '" . $id . "' ";
                mysqli_query($connection, $unban_user);
                $_SESSION['user-success'] = "The user has been unbanned successfully ";
            }
        }
    }
    header("location: " . ROOT_URL . "admin/dashboard.php");
    exit;
} else {
    header("location: " . ROOT_URL);
    exit;
}
