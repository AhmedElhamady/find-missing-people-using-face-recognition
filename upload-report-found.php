<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("location: found-person.php");
} else {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $photo = $_FILES["photo"];
        $time = time(); //make echo image name uniqe
        $photo_name = $time . $photo['name'];
        $photo_name = basename($photo_name);
        $photo_dir = "uploads/" . $photo_name;
        $photo_tmp_name = $photo['tmp_name'];
        $allowed_files = ['png', 'jpg', 'jpeg'];
        $extension = explode('.', $photo_name);
        $extension = end($extension);
        // move_uploaded_file($photo_tmp_name, $photo_dir);

        if ($_FILES["photo"]["error"] != UPLOAD_ERR_OK) {
            $_SESSION["report-errors"] = "Enter the person found photo";
        } elseif (!in_array($extension, $allowed_files)) {
            $_SESSION['report-errors'] = "File should be png , jpg or jpeg";
        } elseif (!(isset($_POST['child-name']) && !empty($_POST['child-name']))) {
            $_SESSION["report-errors"] = "Enter the person found name";
        } elseif (!(isset($_POST['age']) && $_POST['age'] < 200) || empty($_POST["age"])) {
            $_SESSION["report-errors"] = "Enter the person found age";
        } elseif (!isset($_POST["gender"])) {
            $_SESSION["report-errors"] = "Enter the person found gender";
        } elseif (!isset($_POST["health"])) {
            $_SESSION["report-errors"] = "Enter the person found health state";
        } elseif (!(isset($_POST["date"]) && !empty($_POST['date']))) {
            $_SESSION["report-errors"] = "Enter the person found date";
        } elseif (!isset($_POST["child-city"])) {
            $_SESSION["report-errors"] = "Enter the person found city";
        } elseif (!(isset($_POST['reporter-name']) && !empty($_POST['reporter-name']))) {
            $_SESSION["report-errors"] = "Enter your name";
        } elseif (!(isset($_POST['ssn']) && strlen($_POST['ssn']) == 14)) {
            $_SESSION["report-errors"] = "Enter your SSN";
        } elseif (!(isset($_POST['phone']) && strlen($_POST['phone']) == 11)) {
            $_SESSION["report-errors"] = "Enter your phone number";
        } elseif (!isset($_POST["reporter-city"])) {
            $_SESSION["report-errors"] = "Enter city where you live ";
        }

        if (isset($_SESSION["report-errors"])) {
            $_SESSION['report-data'] = $_POST;
            header("location: found-person.php");
        } else {
            require("config/database.php");

            $extention = pathinfo($_FILES["photo"]["name"], PATHINFO_EXTENSION);
            // $dst_fname = getcwd() . '/model/' . time() . uniqid(rand()) . '.' . $extention;
            $m_name = time() . uniqid(rand()) . '.' . $extention;
            $dst_fname = getcwd() . '/model/' . $m_name;
            $dir = getcwd() . '/uploads/' . $m_name;
            // $dst_fname = str_replace('\\', '/', $dst_fname);
            move_uploaded_file($_FILES["photo"]["tmp_name"], $dst_fname);

            $Data = array('path' => $dst_fname);
            $options = array(
                'http' => array(
                    'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method' => 'POST',
                    'content' => http_build_query($Data)
                )
            );
            $context = stream_context_create($options);
            $url = "http://127.0.0.1:9000/upload";
            $result = file_get_contents($url, false, $context);
            $resultObj = json_decode($result);
            if ($resultObj->save == "noface") {
                $_SESSION['noface'] = "No face found in image";
                $_SESSION['report-data'] = $_POST;
                header("Location: found-person.php");
            } elseif ($resultObj->save == "exist") {
                $_SESSION['exist'] = "This person exist in all people page";
                $_SESSION['report-data'] = $_POST;
                header("Location: found-person.php");
            } elseif ($resultObj->save == "success") {
                // move_uploaded_file($photo_tmp_name, $photo_dir);
                copy($dst_fname, $dir);
                $child_name = mysqli_escape_string($connection, $_POST["child-name"]);
                $age = mysqli_escape_string($connection, $_POST["age"]);
                $gender = mysqli_escape_string($connection, $_POST["gender"]);
                $health = mysqli_escape_string($connection, $_POST["health"]);
                $date = mysqli_escape_string($connection, $_POST["date"]);
                $child_city = mysqli_escape_string($connection, $_POST["child-city"]);
                $reporter_name = mysqli_escape_string($connection, $_POST["reporter-name"]);
                $relevance = "none";
                $ssn = mysqli_escape_string($connection, $_POST["ssn"]);
                $phone = mysqli_escape_string($connection, $_POST["phone"]);
                $reporter_city = mysqli_escape_string($connection, $_POST["reporter-city"]);
                $type = "found";
                $query = "INSERT INTO report (`photo`,`child-name`,`age`,`gender`,`health`,`date`,`child-city`,`reporter-name`,`relevance`,`ssn`,`phone`,`reporter-city`,`type`,`user-id`) VALUES 
                ('" . $m_name . "','" . $child_name . "','" . $age . "','" . $gender . "','" . $health . "','" . $date . "','" . $child_city . "','" . $reporter_name . "','" . $relevance . "','" . $ssn . "','" . $phone . "','" . $reporter_city . "','" . $type . "','" . $_SESSION["id"] . "')";
                if (mysqli_query($connection, $query)) {
                    $_SESSION['report-success'] = "The report has been uploaded successfully";
                    header("Location: found-person.php");
                    exit;
                } else {
                    echo mysqli_error($connection);
                }
                mysqli_close($connection);
            }

            // move_uploaded_file($photo_tmp_name, $photo_dir);
            // $child_name = mysqli_escape_string($connection, $_POST["child-name"]);
            // $age = mysqli_escape_string($connection, $_POST["age"]);
            // $gender = mysqli_escape_string($connection, $_POST["gender"]);
            // $health = mysqli_escape_string($connection, $_POST["health"]);
            // $date = mysqli_escape_string($connection, $_POST["date"]);
            // $child_city = mysqli_escape_string($connection, $_POST["child-city"]);
            // $reporter_name = mysqli_escape_string($connection, $_POST["reporter-name"]);
            // $relevance = "none";
            // $ssn = mysqli_escape_string($connection, $_POST["ssn"]);
            // $phone = mysqli_escape_string($connection, $_POST["phone"]);
            // $reporter_city = mysqli_escape_string($connection, $_POST["reporter-city"]);
            // $type = "found";
            // $query = "INSERT INTO report (`photo`,`child-name`,`age`,`gender`,`health`,`date`,`child-city`,`reporter-name`,`relevance`,`ssn`,`phone`,`reporter-city`,`type`,`user-id`) VALUES 
            // ('" . $photo_name . "','" . $child_name . "','" . $age . "','" . $gender . "','" . $health . "','" . $date . "','" . $child_city . "','" . $reporter_name . "','" . $relevance . "','" . $ssn . "','" . $phone . "','" . $reporter_city . "','" . $type . "','" . $_SESSION["id"] . "')";
            // if (mysqli_query($connection, $query)) {
            //     $_SESSION['report-success'] = "The report has been uploaded successfully";
            //     header("Location: found-person.php");
            //     exit;
            // } else {
            //     echo mysqli_error($connection);
            // }
            // mysqli_close($connection);
        }
    }
}
