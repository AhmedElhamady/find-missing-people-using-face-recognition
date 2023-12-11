<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/all.min.css" />
    <link rel="stylesheet" href="css/normalize.css" />
    <link rel="stylesheet" href="css/main.css" />
    <link rel="stylesheet" href="css/person.css" />
    <link rel="shortcut icon" type="x-icon" href="images/logo.png" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />

    <title>The missing person</title>
</head>

<body>
    <?php
    include("partials/header.php");
    // echo "<pre>";
    // print_r($_SESSION);
    // echo "</pre>";
    if (isset($_GET["id"])) {
        $id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);
        // require("config/database.php");
        $query = "SELECT * from report WHERE `id`= '" . $id . "'";
        $result = mysqli_query($connection, $query);
        $row = mysqli_fetch_assoc($result);
        if (empty($row)) {
            header("location: all-people.php");
        }
    } else {
        header("location: all-people.php");
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_SESSION["id"])) {
            $contact_id = filter_input(INPUT_POST, "id", FILTER_SANITIZE_NUMBER_INT);
            if ($contact_id == $id) {
                $contact_query = "SELECT `reporter-name`,`reporter-city`,`phone` from report WHERE `id`= '" . $contact_id . "'";
                $contact_result = mysqli_query($connection, $contact_query);
                $contact_row = mysqli_fetch_assoc($contact_result);
                $_SESSION["contact"] = $contact_row;
                header("location: missing.php?id=" . $contact_id);
                exit;
                mysqli_close($connection);
            }
        } else {
            $_SESSION["login"] = "you should login to see contact";
        }
    }
    ?>
    <div class="person">
        <div class="container">
            <div class="photo">
                <img src="uploads/<?= $row["photo"] ?>" alt="The missing person photo">
            </div>
            <div class="info">
                <h2>The information of the <?= $row["type"] == "missed" ? "missing" : "found" ?> person</h2>
                <div class="con">
                    <p><span>name: </span><?= $row["child-name"] ?></p>
                    <p><span>age: </span><?= $row["age"] ?></p>
                    <p><span>gender: </span><?= $row["gender"] ?></p>
                    <p><span>health state: </span><?= $row["health"] ?></p>
                    <p><span>city of absence: </span><?= $row["child-city"] ?></p>
                    <p><span>date of absence: </span><?= $row["date"] ?></p>
                </div>

            </div>
            <form action="" method="post">
                <input type="text" name="id" value="<?= $row["id"] ?>" hidden>
                <input type="submit" value="Show contact with <?= $row["type"] == "missed" ? "the family" : "the finder" ?>">
            </form>
            <?php
            if (isset($_SESSION["login"])) {
                echo "<p class='error-login'>* " . $_SESSION['login'] . "</p>";
                unset($_SESSION["login"]);
            }
            if (isset($_SESSION["contact"])) : ?>
                <div class="rep">
                    <p>Name: <?= $_SESSION["contact"]["reporter-name"] ?></p>
                    <p>City: <?= $_SESSION["contact"]["reporter-city"] ?></p>
                    <p>Phone: 0<?= $_SESSION["contact"]["phone"] ?></p>
                </div>
            <?php endif ?>

            <?php unset($_SESSION["contact"]) ?>

        </div>
    </div>

    <script src="js/header.js"></script>
</body>

</html>