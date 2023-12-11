<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //validation
    session_start();
    require("config/database.php");
    $error_fields = array();
    if (!(isset($_POST['fname']) && !empty($_POST['fname']))) {
        $error_fields[] = "fname";
    }
    if (!(isset($_POST['lname']) && !empty($_POST['lname']))) {
        $error_fields[] = "lname";
    }
    if (!(isset($_POST['email']) && filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL))) {
        $error_fields[] = "email";
    }
    if (!(isset($_POST['pass']) && strlen($_POST['pass']) > 5)) {
        $error_fields[] = "pass";
    }
    if ($_POST["pass"] !== $_POST["passConfirm"]) {
        $error_fields[] = "passConfirm";
    }
    if ($error_fields) {
        $_SESSION["error_fields"] = $error_fields;
    }

    if (!$error_fields) {
        $fname = mysqli_escape_string($connection, $_POST["fname"]);
        $lname = mysqli_escape_string($connection, $_POST["lname"]);
        $email = mysqli_escape_string($connection, $_POST["email"]);
        $pass = sha1($_POST["pass"]);
        $is_admin = 1;

        $check_exist = "SELECT email FROM users WHERE email = '" . $email . "'";
        $result = mysqli_query($connection, $check_exist);
        if ($row = mysqli_fetch_assoc($result)) {
            $error_fields[] = "exist";
            $_SESSION["error_fields"] = $error_fields;
            header("Location: " . ROOT_URL . "admin/dashboard.php");
            mysqli_free_result($result);
        } else {
            $query = "INSERT INTO users (fname,lname,email,pass,is_admin) VALUES ('" . $fname . "','" . $lname . "','" . $email . "','" . $pass . "',$is_admin)";
            if (mysqli_query($connection, $query)) {
                $_SESSION["admin-success"] = "the admin has been added successfully";
                header("Location: " . ROOT_URL . "admin/dashboard.php");
                exit;
            } else {
                echo mysqli_error($connection);
            }
        }
        mysqli_close($connection);
    } else {
        $_SESSION["backdata"] = $_POST;
        header("Location: " . ROOT_URL . "admin/dashboard.php");
    }
}
