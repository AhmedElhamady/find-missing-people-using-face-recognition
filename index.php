<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/all.min.css" />
    <link rel="stylesheet" href="css/normalize.css" />
    <link rel="stylesheet" href="css/main.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
    <link rel="shortcut icon" type="x-icon" href="images/logo.png" />
    <title>Find Missing People</title>
</head>

<body>
    <?php include "partials/header.php" ?>
    <?php
    // echo "<pre>";
    // print_r($_SESSION);
    // echo "<pre>";
    ?>
    <div class="landing">
        <div class="overlay"></div>
        <div class="text">
            <h1>Help us return the missing children to their families.</h1>
            <p>
                Find missing people is a humanitarian and social initiative that works
                to reunite the missing with their families, children, youth and the
                elderly.
            </p>
            <a href="search-image.php" class="search">
                <!-- <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-card-image" viewBox="0 0 16 16">
                    <path d="M6.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z" />
                    <path
                        d="M1.5 2A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13zm13 1a.5.5 0 0 1 .5.5v6l-3.775-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12v.54A.505.505 0 0 1 1 12.5v-9a.5.5 0 0 1 .5-.5h13z" />
                </svg>  -->
                <i class="fa-solid fa-image"></i>
                Search By Image
            </a>
        </div>
    </div>
    <div class="recent">
        <div class="container">
            <span>the most recent</span>
            <div class="content">
                <?php
                // require("config/database.php");
                $query = "SELECT * FROM `report` ORDER BY `report-data` DESC LIMIT 10";
                $result = mysqli_query($connection, $query);
                while ($row = mysqli_fetch_assoc($result)) :
                ?>
                    <div class="box">
                        <a href="missing.php?id=<?= $row["id"] ?>">
                            <div class="photo">
                                <img src="uploads/<?= $row["photo"] ?>" alt="" />
                            </div>
                            <div class="text">
                                <h3>Name: <?= $row["child-name"] ?></h3>
                                <p>Date of absence: <?= $row["date"] ?></p>
                            </div>
                            <div class="type <?= $row["type"] ?>"><?= $row["type"] ?></div>
                        </a>
                    </div>
                <?php endwhile ?>
            </div>
        </div>
    </div>
    <div class="operations">
        <h2>basic operations</h2>
        <div class="container">
            <div class="person-missing option">
                <img src="images/missed.svg" alt="">
                <p>missing person</p>
                <h3>To report a missing person by providing info to help find him</h3>
                <a href="missing-person.php">more</a>
            </div>
            <div class="person-found option">
                <img src="images/found.svg" alt="">
                <p>found person</p>
                <h3>To report a person who has been found to help him return home</h3>
                <a href="found-person.php">more</a>
            </div>
            <div class="all-person option">
                <img src="images/all.svg" alt="">
                <p>all persons</p>
                <h3>To search in the missing or found persons and filter the results</h3>
                <a href="all-people.php">more</a>
            </div>
            <div class="image-search option">
                <img src="images/search image.svg" alt="">
                <p>search by image</p>
                <h3>To search by the missing person photo and return the result</h3>
                <a href="search-image.php">more</a>
            </div>
        </div>
    </div>
    <div class="contact-link">
        <div class="container">
            <a href="contact.php">contact us</a>
            <div>
                <p>Do you have a complaint or inquiry ?</p>
                <h3>Contact us and help us to return the missing to their homes</h3>
            </div>
        </div>
    </div>
    <?php include("partials/footer.php") ?>
    <script src="js/main.js"></script>
    <script src="js/header.js"></script>
</body>

</html>