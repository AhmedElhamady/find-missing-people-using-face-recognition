<?php

use PHPMailer\PHPMailer\PHPMailer;
// should be top 

session_start();

if (!isset($_SESSION["admin"])) {
    echo "You can not access this page";
    echo "<br>";
    echo "You will redirect to dashboard page after 3 seconds";
    header("refresh:3;dashboard.php");
    exit;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require("config/database.php");
    if ((isset($_POST['reply']) && !empty($_POST['reply']))) {
        $msg = $_POST["reply"];
        $id = $_POST["id"];
        $query = "SELECT * from contact where id = '" . $id . "'";
        $result = mysqli_query($connection, $query);
        if ($row = mysqli_fetch_assoc($result)) {
            $email = $row["email"];

            //////////////// mail function//////////////
            // $to = $email;
            // $sender = "ahmedmfawzi2019@gmail.com";
            // $subject = "Reply of your massage from FMP ";
            // $headers = "From: " . $sender . "\r\n";
            // // $headers .= "Reply-To: sender@example.com\r\n";
            // // $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
            // $message = $msg;
            // mail($to, $subject, $message, $headers);


            ///////////////   phpmailer   //////////////////
            // $mail = new PHPMailer\PHPMailer\PHPMailer();
            // use PHPMailer\PHPMailer\PHPMailer;
            require "library/PHPMailer-master/src/Exception.php";
            require "library/PHPMailer-master/src/PHPMailer.php";
            require "library/PHPMailer-master/src/SMTP.php";

            $mail = new PHPMailer(true);
            // $mail = new PHPMailer\PHPMailer\PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;

            $mail->Username = 'Your Gmail email address';
            $mail->Password = 'Your Gmail password';

            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;
            $mail->setFrom('Your Gmail email address', 'FMP Organization');
            $mail->addAddress($email);

            // Set the email subject and body
            $mail->Subject = 'The reply of your email on FMP';
            $mail->Body = $msg;
            $mail->send();

            // delete mail after reply
            $query = "DELETE FROM contact WHERE id = '" . $id . "' ";
            if (mysqli_query($connection, $query)) {
                $_SESSION["mail-success"] = "The reply sended successfully";
                header("Location: dashboard.php");
                exit;
            }
        } else {
            echo "There is no such id";
            echo "<br>";
            echo "You will redirect to dashboard page after 3 seconds";
            header("refresh:3;dashboard.php");
            exit;
        }
    } else {
        $_SESSION["reply"] = "Enter your reply";
        header("Location: dashboard.php");
        exit;
    }
} else {
    header("Location: dashboard.php");
    exit;
}
