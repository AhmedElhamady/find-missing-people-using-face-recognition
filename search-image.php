<?php
//if ($_SERVER["REQUEST_METHOD"] == "POST") {
// $extention = pathinfo($_FILES["img"]["name"], PATHINFO_EXTENSION);
// $dst_fname = getcwd() . '/model/' . time() . uniqid(rand()) . '.' . $extention;
// $dst_fname = str_replace('\\', '/', $dst_fname);
// move_uploaded_file($_FILES["img"]["tmp_name"], $dst_fname);
// $Data = array('path' => $dst_fname);
// $options = array(
//     'http' => array(
//         'header' => "Content-type: application/x-www-form-urlencoded\r\n",
//         'method' => 'POST',
//         'content' => http_build_query($Data)
//     )
// );
// $context = stream_context_create($options);
// $url = "http://127.0.0.1:5000/test";
// $result = file_get_contents($url, false, $context);
// $resultObj = json_decode($result);
//}
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
    <link rel="stylesheet" href="css/missing.css" />
    <link rel="stylesheet" href="css/search-image.css" />
    <link rel="shortcut icon" type="x-icon" href="images/logo.png" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <title>Search by image</title>
</head>

<body>
    <?php include "partials/header.php" ?>
    <div class="image-text">
        <div class="container">
            <p>Upload image and search</p>
        </div>
    </div>
    <div class="search-image">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="container">
                <div class="person-img">
                    <input type="file" id="file" accept="image/*" name="img" hidden required />
                    <div class="img-area" data-img="">
                        <i class="fa-solid fa-cloud-arrow-up"></i>
                        <h3>Upload image for person</h3>
                    </div>
                    <button class="select-image">Select Image</button>
                </div>
                <!-- <div class="search"> -->
                <input type="submit" class="search test-ajax" value="Search">
                <!-- </div> -->
                <?php
                if (isset($resultObj)) {
                    $resImage = substr($resultObj->image, 0, -4);
                    $query = "SELECT * FROM `report` where `photo` LIKE '%" . $resImage . "%'";
                    $result = mysqli_query($connection, $query);
                    $row = mysqli_fetch_assoc($result);
                }
                ?>
                <div class="result">
                    <div class="img-area">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <h3>No result yet</h3>
                        <img src="" hidden alt="photo">
                    </div>
                    <a href="" class="text off">Show Details</a>
                </div>
            </div>
        </form>
    </div>
    <div class="con-loader hide">
        <div class="loader"></div>Please Wait...
    </div>
    <div class="overlay hide"></div>

    <script src="js/missing-found.js"></script>
    <!-- <script src="js/search-image.js"></script> -->
    <script src="js/header.js"></script>
    <script>
    let disLink = document.querySelector(".result a");
    disLink.addEventListener("click", function(e) {
        if (disLink.getAttribute("href") == "") {
            e.preventDefault();
        }
    });
    // Add an event listener to the form submission
    document.querySelector('form').addEventListener('submit', function(event) {
        event.preventDefault();

        // loading
        let load = document.querySelector(".con-loader");
        let overlay = document.querySelector(".overlay");
        load.classList.remove("hide");
        overlay.classList.remove("hide");

        var formData = new FormData(this);
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'res-image.php', true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                console.log('Form data submitted successfully:');
                load.classList.add("hide");
                overlay.classList.add("hide");
                let res = document.querySelector(".result");
                let link = res.querySelector("a");
                let img = res.querySelector("img");
                let imgArea = document.querySelector(".result .img-area");
                let txt = imgArea.querySelector("h3");
                let icon = imgArea.querySelector("i");
                var jsonObject = JSON.parse(this.responseText);

                if (jsonObject.found == "error") {
                    let error = "No face found in image";
                    txt.innerHTML = error;
                    txt.classList.add("warning");
                    icon.classList.add("warning");
                    img.setAttribute("src", "");
                    img.setAttribute("hidden", "");
                    link.setAttribute("href", "");
                    link.classList.add("off");
                    console.log(error);

                } else if (jsonObject.found == "no") {
                    let face = "No person found with this face";
                    txt.innerHTML = face;
                    txt.classList.add("warning");
                    icon.classList.add("warning");
                    img.setAttribute("src", "");
                    link.setAttribute("href", "");
                    link.classList.add("off");
                    img.setAttribute("hidden", "");
                    console.log(face);

                } else {
                    let modelImage = jsonObject.image;
                    let modelSim = jsonObject.sim;
                    let modelId = jsonObject.id;
                    console.log(modelSim);

                    img.removeAttribute("hidden");
                    link.classList.remove("off");
                    img.setAttribute("src", "uploads/" + modelImage);
                    link.setAttribute("href", "missing.php?id=" + modelId);
                }
            } else {
                console.log('Form data submission failed.');
            }
        };
        xhr.send(formData);
        // console.log(file.files[0]);
        // xhr.open('POST', 'res-image.php', true);
        // xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

        // xhr.onreadystatechange = function() {
        //     if (xhr.readyState === 4 && xhr.status === 200) {
        //         // var response = JSON.parse(xhr.responseText);
        //         var response = xhr.responseText;
        //         console.log(response);
        //     }
        // };
    });

    // function updateResult(response) {
    //     var resultImage = document.getElementById('result-image');
    //     var resultDetails = document.getElementById('result-details');

    //     resultImage.src = 'uploads/' + response.image;
    //     resultDetails.classList.remove('off');
    //     if (response.id) {
    //         resultDetails.innerHTML = '<a href="missing.php?id=' + response.id + '" class="text">Show Details</a>';
    //     } else {
    //         resultDetails.innerHTML = '<div class="text off">Waiting result</div>';
    //     }
    // }
    </script>
</body>

</html>