<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require("config/database.php");
    $extention = pathinfo($_FILES["img"]["name"], PATHINFO_EXTENSION);
    $dst_fname = getcwd() . '/model/' . time() . uniqid(rand()) . '.' . $extention;
    $dst_fname = str_replace('\\', '/', $dst_fname);
    move_uploaded_file($_FILES["img"]["tmp_name"], $dst_fname);

    $Data = array('path' => $dst_fname);
    $options = array(
        'http' => array(
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($Data)
        )
    );
    $context = stream_context_create($options);
    $url = "http://127.0.0.1:9000/test";
    $result = file_get_contents($url, false, $context);
    $resultObj = json_decode($result);


    if (isset($resultObj->found) && $resultObj->found == 'yes') {
        $found =  $resultObj->found;
        $image =  $resultObj->image;
        $sim =  $resultObj->sim;

        $resImage = substr($image, 0, -4);
        $query = "SELECT * FROM `report` where `photo` LIKE '%" . $resImage . "%'";
        $result_query = mysqli_query($connection, $query);
        $row = mysqli_fetch_assoc($result_query);
        $person = ["found" => $found, "image" => $row["photo"], "id" => $row["id"], "sim" => $sim];
        echo json_encode($person);
    } else {
        $found =  $resultObj->found;
        $person = ["found" => $found];
        echo json_encode($person);
    }
}


// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     require("../config/database.php");
//     $query_report = "SELECT * FROM `report` WHERE `id`=" . $_POST["id"];
//     $result_report = mysqli_query($connection, $query_report);
//     $row_report = mysqli_fetch_assoc($result_report);
//     $user_id = $row_report["user-id"];

//     $query_user = "SELECT * FROM `users` WHERE `id`=" . $user_id;
//     $result_user = mysqli_query($connection, $query_user);
//     $row_user = mysqli_fetch_assoc($result_user);
//     $row_report["user"] = $row_user;
//     // return Json
//     echo json_encode($row_report);
// }