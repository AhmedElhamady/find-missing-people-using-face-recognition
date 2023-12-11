<?php
$error_fields = array();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //validation
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

    if (!$error_fields) {
        require("config/database.php");
        $fname = mysqli_escape_string($connection, $_POST["fname"]);
        $lname = mysqli_escape_string($connection, $_POST["lname"]);
        $email = mysqli_escape_string($connection, $_POST["email"]);
        $pass = sha1($_POST["pass"]);
        $is_admin = 0;

        $check_exist = "SELECT email FROM users WHERE email = '" . $email . "'";
        $result = mysqli_query($connection, $check_exist);
        if ($row = mysqli_fetch_assoc($result)) {
            $error_fields[] = "exist";
            mysqli_free_result($result);
        } else {
            $query = "INSERT INTO users (fname,lname,email,pass,is_admin) VALUES ('" . $fname . "','" . $lname . "','" . $email . "','" . $pass . "',$is_admin)";
            if (mysqli_query($connection, $query)) {
                header("Location: login.php");
                exit;
            } else {
                echo mysqli_error($connection);
            }
        }
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
    <title>Create account / sign up</title>
</head>

<body>
    <div class="signup-content">
        <div class="signup">
            <span>fmp</span>
            <h1>Create account</h1>
            <form method="post">
                <?php if (in_array("exist", $error_fields)) echo "<p class='error'>This user already exist</p>" ?>
                <div class="cont">
                    <div class="name">
                        <div class="box">
                            <input type="text" name="fname" id="" placeholder="first name" value="<?= isset($_POST["fname"]) ? $_POST["fname"] : "" ?>" />
                            <?php if (in_array("fname", $error_fields)) echo "<p class='error-top'>Enter first name </p>" ?>
                        </div>
                        <div class="box">
                            <input type="text" name="lname" id="" placeholder="last name" value="<?= isset($_POST["lname"]) ? $_POST["lname"] : "" ?>" />
                            <?php if (in_array("lname", $error_fields)) echo "<p class='error-top'>Enter last name </p>" ?>
                        </div>
                    </div>
                </div>
                <div class="cont">
                    <input type="email" name="email" id="" placeholder="email" value="<?= isset($_POST["email"]) ? $_POST["email"] : "" ?>" />
                    <?php if (in_array("email", $error_fields)) echo "<p class='error-top'>Enter correct email</p>" ?>
                </div>
                <div class="cont">
                    <div class="password">
                        <div class="box">
                            <input type="password" name="pass" id="" placeholder="password" />
                            <?php if (in_array("pass", $error_fields)) echo "<p class='error-top'>Enter password more than 5 char</p>" ?>
                        </div>
                        <div class="box">
                            <input type="password" name="passConfirm" id="" placeholder="confirm password" />
                            <?php if (in_array("passConfirm", $error_fields)) echo "<p class='error-top'>Not the same password</p>" ?>
                        </div>
                    </div>
                </div>
                <input type="submit" value="login" />
            </form>
        </div>
    </div>
</body>

</html>