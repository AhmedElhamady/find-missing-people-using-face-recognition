<?php
require 'config/database.php';
?>

<div class="header">
    <div class="container">
        <div class="logo">
            <a href="<?= ROOT_URL ?>">
                <div class="content">
                    <img src="images/logo.png" alt="logo" />
                    <p>fmp</p>
                </div>
            </a>
        </div>
        <div class="toggle-menu">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <div class="nav">
            <ul class="links">
                <?php
                session_start();
                if (isset($_SESSION["admin"])) {
                ?>
                    <li><a href="<?= ROOT_URL . "admin/dashboard.php" ?>">dashboard</a></li>
                <?php } ?>
                <li><a href="<?= ROOT_URL . "missing-person.php" ?>">missing person</a></li>
                <li><a href="<?= ROOT_URL . "found-person.php" ?>">found person</a></li>
            </ul>
            <?php
            if (isset($_SESSION["id"])) : ?>
                <div class="profile">
                    <p>Hello <?= $_SESSION["fname"] ?></p>
                    <div class="data">
                        <div class="info">
                            <div class="link">
                                <i class="fa-solid fa-user"></i>
                                <div class="text">
                                    <p>Hello <?= $_SESSION["fname"] ?></p>
                                    <p><?= $_SESSION["email"] ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="info">
                            <div class="link">
                                <i class="fa-regular fa-address-card"></i>
                                <a href="<?= ROOT_URL . "profile.php" ?>">edit profile</a>
                            </div>
                        </div>
                        <div class="info">
                            <div class="link">
                                <i class="fa-solid fa-envelope-open-text"></i>
                                <a href="<?= ROOT_URL . "manage-reports.php" ?>">manage reports</a>
                            </div>
                        </div>
                        <div class="info">
                            <div class="link">
                                <i class="fa-solid fa-right-from-bracket"></i>
                                <a href="<?= ROOT_URL . "logout.php" ?>">logout</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php else : ?>
                <div class="profile"><a href="<?= ROOT_URL . "login.php" ?>">sign in / sign up</a></div>
            <?php endif ?>
            <div class="mood"><i class="fa-solid fa-moon"></i></div>
            <div class="lang">ar</div>
        </div>
    </div>
</div>