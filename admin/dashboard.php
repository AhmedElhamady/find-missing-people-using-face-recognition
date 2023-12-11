<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/all.min.css" />
    <link rel="stylesheet" href="../css/normalize.css" />
    <link rel="stylesheet" href="../css/main.css" />
    <link rel="shortcut icon" type="x-icon" href="images/logo.png" />
    <!-- <link rel="stylesheet" href="../css/manage-reports.css" /> -->
    <link rel="stylesheet" href="../css/dashboard.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
    <title>Dashboard</title>
</head>

<body>
    <?php
    include("partials/header.php");
    if (!isset($_SESSION["admin"]))
        header("location: " . ROOT_URL);

    ?>
    <?php
    $query = "SELECT * FROM `report` ORDER BY `report-data` DESC";
    $result = mysqli_query($connection, $query);
    ?>
    <div class="dashboard">
        <div class="container">
            <ul class="tasks">
                <li class="clicked" data-task=".reports">
                    <i class="fa-regular fa-address-card"></i>
                    <p>manage reports</p>
                </li>
                <li data-task=".user">
                    <i class="fa-solid fa-users"></i>
                    <p>manage users</p>
                </li>
                <li data-task=".admin">
                    <i class="fa-solid fa-user-plus"></i>
                    <p>add admin</p>
                </li>
                <li data-task=".call">
                    <i class="fa-solid fa-phone-volume"></i>
                    <p>show contact</p>
                </li>
            </ul>
            <div class="content">
                <div class="task reports clicked">
                    <h2>manage reports</h2>
                    <?php if (isset($_SESSION["report-success"])) : ?>
                        <p class="success">
                            <?= $_SESSION["report-success"];
                            unset($_SESSION["report-success"]); ?>
                        </p>
                    <?php endif ?>

                    <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                        <div class="report">
                            <div class="info">
                                <div class="img">
                                    <img src="../uploads/<?= $row["photo"] ?>" alt="photo">
                                </div>
                                <div class="data">
                                    <div class="box">
                                        <h2>name:</h2>
                                        <p><?= $row["child-name"] ?></p>
                                    </div>
                                    <div class="box">
                                        <h2>date:</h2>
                                        <p><?= $row["date"] ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="operation">
                                <button class="delete" data-id="<?= $row["id"] ?>">Delete</button>
                                <button class="more" data-id="<?= $row["id"] ?>">More</button>
                            </div>
                        </div>
                    <?php endwhile ?>
                </div>
                <div class="task user">
                    <h2>manage users</h2>
                    <div class="fltr">
                        <div data-task=".usr" class="clicked">user</div>
                        <div data-task=".admn">admin</div>
                        <div data-task=".banned">banned</div>
                    </div>
                    <?php if (isset($_SESSION["user-success"])) : ?>
                        <p class="success">
                            <?= $_SESSION["user-success"];
                            unset($_SESSION["user-success"]); ?>
                        </p>
                    <?php endif ?>
                    <div class="table head">
                        <p>email</p>
                        <p>name</p>
                        <p>operation</p>
                    </div>
                    <div class="table fltr-users usr clicked">
                        <?php
                        $query_user = "SELECT * FROM `users` where is_admin = 0 and banned = 0";
                        $result_user = mysqli_query($connection, $query_user);
                        while ($row_user = mysqli_fetch_assoc($result_user)) : ?>
                            <div class="table usr">
                                <p><span><?= $row_user["email"] ?></span> </p>
                                <p><span><?= $row_user["fname"] . " " . $row_user["lname"] ?></span> </p>
                                <p><a href="ban.php?id=<?= $row_user["id"] ?>">ban</a></p>
                            </div>
                        <?php endwhile ?>
                    </div>
                    <div class="table fltr-users admn">
                        <?php
                        $query_admin = "SELECT * FROM `users` where is_admin = 1 and banned = 0";
                        $result_admin = mysqli_query($connection, $query_admin);
                        while ($row_admin = mysqli_fetch_assoc($result_admin)) : ?>
                            <div class="table usr">
                                <p><span><?= $row_admin["email"] ?></span> </p>
                                <p><span><?= $row_admin["fname"] . " " . $row_admin["lname"] ?></span> </p>
                                <p><a href="ban.php?id=<?= $row_admin["id"] ?>">ban</a></p>
                            </div>
                        <?php endwhile ?>
                    </div>
                    <div class="table fltr-users banned">
                        <?php
                        $query_ban = "SELECT * FROM `users` where banned = 1";
                        $result_ban = mysqli_query($connection, $query_ban);
                        while ($row_ban = mysqli_fetch_assoc($result_ban)) : ?>
                            <div class="table usr">
                                <p><span><?= $row_ban["email"] ?></span> </p>
                                <p><span><?= $row_ban["fname"] . " " . $row_ban["lname"] ?></span> </p>
                                <p><a href="ban.php?id=<?= $row_ban["id"] ?>">unban</a></p>
                            </div>
                        <?php endwhile ?>
                    </div>
                </div>
                <div class="task admin">

                    <h2>add admin</h2>
                    <form action="add-admin.php" method="post">
                        <?php
                        if (isset($_SESSION["admin-success"])) : ?>
                            <p class="success">
                                <?= $_SESSION["admin-success"];
                                unset($_SESSION["admin-success"]); ?>
                            </p>
                        <?php endif ?>
                        <?php if (isset($_SESSION["error_fields"])) if (in_array("exist", $_SESSION["error_fields"])) echo "<p class='error'>This user already exist</p>" ?>
                        <input type="text" name="fname" id="" placeholder="first name" value="<?= isset($_SESSION["backdata"]) ? $_SESSION["backdata"]["fname"] : "" ?>">
                        <?php if (isset($_SESSION["error_fields"])) if (in_array("fname", $_SESSION["error_fields"])) echo "<p class='error-top'>Enter first name </p>" ?>
                        <input type="text" name="lname" id="" placeholder="last name" value="<?= isset($_SESSION["backdata"]) ? $_SESSION["backdata"]["lname"] : "" ?>">
                        <?php if (isset($_SESSION["error_fields"])) if (in_array("lname", $_SESSION["error_fields"])) echo "<p class='error-top'>Enter last name </p>" ?>
                        <input type="email" name="email" id="" placeholder="email" value="<?= isset($_SESSION["backdata"]) ? $_SESSION["backdata"]["email"] : "" ?>">
                        <?php if (isset($_SESSION["error_fields"])) if (in_array("email", $_SESSION["error_fields"])) echo "<p class='error-top'>Enter correct email</p>" ?>
                        <input type="password" name="pass" id="" placeholder="password">
                        <?php if (isset($_SESSION["error_fields"])) if (in_array("pass", $_SESSION["error_fields"])) echo "<p class='error-top'>Enter password more than 5 char</p>" ?>
                        <input type="password" name="passConfirm" id="" placeholder="confirm password">
                        <?php if (isset($_SESSION["error_fields"])) if (in_array("passConfirm", $_SESSION["error_fields"]))  echo "<p class='error-top'>Not the same password</p>" ?>
                        <?php
                        unset($_SESSION["backdata"]);
                        unset($_SESSION["error_fields"]);
                        ?>
                        <input type="submit" value="add">
                    </form>
                </div>
                <div class="task call">
                    <h2>show contact</h2>
                    <?php
                    if (isset($_SESSION["mail-success"])) { ?>
                        <p class="success"><?= $_SESSION["mail-success"] ?></p>
                    <?php unset($_SESSION["mail-success"]);
                    } ?>
                    <?php
                    if (isset($_SESSION["reply"])) { ?>
                        <p class="success"><?= $_SESSION["reply"] ?></p>
                    <?php unset($_SESSION["reply"]);
                    } ?>
                    <?php
                    if (isset($_SESSION["mail-delete"])) { ?>
                        <p class="success"><?= $_SESSION["mail-delete"] ?></p>
                    <?php unset($_SESSION["mail-delete"]);
                    } ?>
                    <?php
                    $query = "SELECT * from contact ORDER BY `date` DESC";
                    $result = mysqli_query($connection, $query);
                    while ($row = mysqli_fetch_assoc($result)) : ?>
                        <div class="problem">
                            <div class="n-f">
                                <p><span>Name: </span><?= $row["name"] ?></p>
                                <p><span>Phone: </span><?= $row["phone"] ?></p>
                            </div>
                            <p class="data"><span>Email: </span><?= $row["email"] ?></p>
                            <p class="data"><span>Subject: </span><?= $row["subject"] ?></p>
                            <div class="show">
                                <span class="show-text">Show</span>
                            </div>
                            <div class="action">
                                <p class="message"><?= $row["message"] ?></p>
                                <div class="rep-con">
                                    <form action="contact.php" method="post">
                                        <input type="hidden" name="id" value="<?= $row["id"] ?>">
                                        <input type="text" required name="reply" placeholder="Enter the reply of email">
                                        <div class="submit">
                                            <input type="submit" value="Send">
                                            <i class="fa-solid fa-paper-plane"></i>
                                            <a href="delete-mail.php?id=<?= $row["id"] ?>"><i class="fa-sharp fa-solid fa-trash"></i>Delete</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endwhile ?>
                </div>
            </div>
        </div>
    </div>
    <div class="model-view">
        <h2>person info</h2>
        <p class="child-name">Name : <span></span></p>
        <p class="age">Age : <span></span></p>
        <p class="gender">Gender : <span></span></p>
        <p class="health-state">Health state : <span></span></p>
        <p class="type">Type : <span></span></p>
        <h2>The date and city of missing</h2>
        <p class="date">Date : <span></span></p>
        <p class="child-city">City : <span></span></p>
        <h2>reporter info</h2>
        <p class="reporter-name">Name : <span></span></p>
        <p class="reporter-city">City : <span></span></p>
        <p class="phone">Phone : <span></span></p>
        <p class="ssn">SSN : <span></span></p>
        <p class="relation">Relation : <span></span></p>
        <h2>The user who created the report</h2>
        <p class="id">ID : <span></span></p>
        <p class="email">Email : <span></span></p>
        <p class="name">Name : <span></span></p>
        <div class="close">x</div>
    </div>
    <div class="overlay"></div>
    <div class="delete-report">
        <p>Are you sure to delete</p>
        <p>this report</p>
        <div class="order">
            <button class="cancle">Cancle</button>
            <a href="" class="ok">Ok</a>
        </div>
    </div>
    <script src="../js/dashboard.js"></script>
    <script src="../js/header.js"></script>
</body>

</html>