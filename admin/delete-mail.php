<?php
session_start();
require("config/database.php");
if (isset($_SESSION["admin"])) {
    if (isset($_GET["id"])) {
        $id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);
        $mail = "SELECT `id`from contact WHERE `id`= '" . $id . "'";
        $mail_result = mysqli_query($connection, $mail);
        $mail_row = mysqli_fetch_assoc($mail_result);
        if (!empty($mail_row)) {
            $query = "DELETE FROM contact WHERE id = '" . $id . "' ";
            if (mysqli_query($connection, $query)) {
                $_SESSION['mail-delete'] = "The mail has been deleted successfully";
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
