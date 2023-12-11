<?php
session_start();
if (isset($_SESSION["id"])) {
    header("Location: index.php");
}
$error = array();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!(isset($_POST['email']) && filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL))) {
        $error[] = "email";
    }
    if (!(isset($_POST['pass']) && strlen($_POST['pass']) > 5)) {
        $error[] = "pass";
    }
    if (!$error) {
        require("config/database.php");
        $email = mysqli_escape_string($connection, $_POST["email"]);
        $pass = sha1($_POST["pass"]);
        $query = "SELECT * FROM `users` WHERE email = '" . $email . "' and pass = '" . $pass . "' LIMIT 1";
        $result = mysqli_query($connection, $query);
        if ($row = mysqli_fetch_assoc($result)) {
            if ($row["banned"] == 1) {
                $error[] = "banned";
            } else {
                $_SESSION["id"] = $row["id"];
                $_SESSION["email"] = $row["email"];
                $_SESSION["fname"] = $row["fname"];
                if ($row["is_admin"] == 1) {
                    $_SESSION["admin"] = "yes";
                    header("Location: admin/dashboard.php");
                } else {
                    header("Location: index.php");
                }
                exit;
            }
        } else {
            $error[] = "not_exist";
        }
        // close connection
        mysqli_free_result($result);
        mysqli_close($connection);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/all.min.css" />
    <link rel="stylesheet" href="css/normalize.css" />
    <link rel="stylesheet" href="css/main.css" />
    <link rel="shortcut icon" type="x-icon" href="images/logo.png" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
    <title>Login</title>
</head>

<body>
    <div class="login-content">
        <div class="login">
            <span>fmp</span>
            <h1>login now</h1>
            <form method="post">
                <?php
                if (in_array("not_exist", $error)) {
                    echo "<p class='error'>Invalid email or password</p>";
                }
                if (in_array("banned", $error)) {
                    echo "<p class='error'>Account was banned</p>";
                }
                ?>
                <div class="cont">
                    <input type="email" name="email" id="" placeholder="enter your email" value="<?= isset($_POST["email"]) ? $_POST["email"] : "" ?>" />
                    <?php if (in_array("email", $error)) {
                        echo "<p class='error-top'>Enter correct email</p>";
                    } ?>
                </div>
                <div class="cont">
                    <input type="password" name="pass" id="" placeholder="enter your password" />
                    <?php if (in_array("pass", $error)) {
                        echo "<p class='error-top'>enter pass more than 5 char</p>";
                    } ?>
                </div>
                <input type="submit" value="login" />
            </form>
            <div class="other">
                <a href="signup.php">Don't have an account?</a>
                <a href="#">forgit password?</a>
            </div>
        </div>
    </div>
</body>

</html>