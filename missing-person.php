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
    <link rel="shortcut icon" type="x-icon" href="images/logo.png" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <title>Report-missing person</title>
</head>

<body>
    <?php include "partials/header.php" ?>
    <div class="mis-text">
        <h1>Report a missing person</h1>
    </div>
    <div class="missing-content">
        <?php if (isset($_SESSION["report-errors"])) : ?>
        <p class="error">
            <?= $_SESSION["report-errors"];
                unset($_SESSION["report-errors"]); ?>
        </p>
        <?php endif ?>
        <?php if (isset($_SESSION["report-success"])) : ?>
        <p class="success">
            <?= $_SESSION["report-success"];
                unset($_SESSION["report-success"]); ?>
        </p>
        <?php endif ?>
        <?php if (isset($_SESSION["noface"])) : ?>
        <p class="error">
            <?= $_SESSION["noface"];
                unset($_SESSION["noface"]); ?>
        </p>
        <?php endif ?>
        <?php if (isset($_SESSION["exist"])) : ?>
        <p class="success" style="display: flex; justify-content: space-between">
            <?= $_SESSION["exist"];
                unset($_SESSION["exist"]); ?>
            <a href="search-image.php" style="color: var(--main-color)">Search here</a>
        </p>
        <?php endif ?>
        <form action="upload-report-missed.php" method="post" enctype="multipart/form-data">
            <div class="person-info">
                <p class="heading">Missing person information</p>
                <div class="person-img">
                    <input type="file" id="file" accept="image/*" name="photo" hidden />
                    <div class="img-area" data-img="">
                        <i class="fa-solid fa-cloud-arrow-up"></i>
                        <h3>Upload image for person</h3>
                    </div>
                    <button class="select-image">Select Image</button>
                </div>
                <div class="person-name box">
                    <label for="person-name" class="title">person name</label>
                    <input type="text" placeholder="Person name" id="person-name" name="child-name"
                        value="<?= $_SESSION['report-data']["child-name"] ?? "";
                                                                                                            unset($_SESSION["report-data"]["child-name"]); ?>" />
                </div>
                <div class="person-age box">
                    <label for="person-age" class="title">person age</label>
                    <input type="text" placeholder="Person age" id="person-age" name="age"
                        value="<?= $_SESSION['report-data']["age"] ?? "";
                                                                                                    unset($_SESSION["report-data"]["age"]) ?>" />
                </div>
                <div class="person-gender box">
                    <p class="title">person gender</p>
                    <div class="male gen">
                        <?php
                        $gen = "";
                        $heal = "";
                        if (isset($_SESSION["report-data"]["gender"])) {
                            $gen = $_SESSION["report-data"]["gender"];
                            unset($_SESSION["report-data"]["gender"]);
                        }
                        if (isset($_SESSION["report-data"]["health"])) {
                            $heal = $_SESSION["report-data"]["health"];
                            unset($_SESSION["report-data"]["health"]);
                        }
                        ?>
                        <input type="radio" name="gender" value="male" id="male"
                            <?= ($gen == "male") ? "checked" : "" ?> />
                        <label for="male">male</label>
                    </div>
                    <div class="female gen">
                        <input type="radio" name="gender" value="female" id="female"
                            <?= ($gen == "female") ? "checked" : "" ?> />
                        <label for="female">female</label>
                    </div>
                </div>
                <div class="person-health">
                    <p class="title">health status</p>
                    <div class="content">
                        <div class="normal">
                            <input type="radio" value="normal" name="health" id="normal"
                                <?= ($heal == "normal") ? "checked" : "" ?> />
                            <label for="normal">normal</label>
                        </div>
                        <div class="normal">
                            <input type="radio" value="chronic" name="health" id="chronic"
                                <?= ($heal == "chronic") ? "checked" : "" ?> />
                            <label for="chronic">have chronic disease</label>
                        </div>
                        <div class="normal">
                            <input type="radio" value="disabled" name="health" id="disabled"
                                <?= ($heal == "disabled") ? "checked" : "" ?> />
                            <label for="disabled">disabled</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="place-date">
                <p class="heading">The place and date of the person's loss</p>
                <div class="date">
                    <label for="date" class="title">Date</label>
                    <input type="date" name="date" id="date" value="<?= $_SESSION['report-data']["date"] ?? "";
                                                                    unset($_SESSION["report-data"]["date"]) ?>" />
                </div>
                <div class="place">
                    <div class="city">
                        <label for="city" class="title">City</label>
                        <select id="child-city" name="child-city"
                            data-city="<?= $_SESSION['report-data']["child-city"] ?? "";
                                                                                unset($_SESSION["report-data"]["child-city"]) ?>">
                            <option value="القاهرة" selected>القاهرة</option>
                            <option value="الإسكندرية">الإسكندرية</option>
                            <option value="الإسماعيلية">الإسماعيلية</option>
                            <option value="كفر الشيخ">كفر الشيخ</option>
                            <option value="أسوان">أسوان</option>
                            <option value="أسيوط">أسيوط</option>
                            <option value="الأقصر">الأقصر</option>
                            <option value="الوادي الجديد">الوادي الجديد</option>
                            <option value="شمال سيناء">شمال سيناء</option>
                            <option value="البحيرة">البحيرة</option>
                            <option value="بني سويف">بني سويف</option>
                            <option value="بورسعيد">بورسعيد</option>
                            <option value="البحر الأحمر">البحر الأحمر</option>
                            <option value="الجيزة">الجيزة</option>
                            <option value="الدقهلية">الدقهلية</option>
                            <option value="جنوب سيناء">جنوب سيناء</option>
                            <option value="دمياط">دمياط</option>
                            <option value="سوهاج">سوهاج</option>
                            <option value="السويس">السويس</option>
                            <option value="الشرقية">الشرقية</option>
                            <option value="الغربية">الغربية</option>
                            <option value="الفيوم">الفيوم</option>
                            <option value="القليوبية">القليوبية</option>
                            <option value="قنا">قنا</option>
                            <option value="مطروح">مطروح</option>
                            <option value="المنوفية">المنوفية</option>
                            <option value="المنيا">المنيا</option>
                        </select>
                    </div>
                    <!-- <div class="town">
                        <label for="town" class="title">Town</label>
                        <select name="town" id="town"></select>
                    </div> -->
                </div>
            </div>
            <div class="reporter-info">
                <p class="heading">Reporter information</p>
                <div class="reporter-name box">
                    <label for="reporter-name" class="title">name</label>
                    <input type="text" placeholder="Full name" id="reporter-name" name="reporter-name"
                        value="<?= $_SESSION['report-data']["reporter-name"] ?? "";
                                                                                                                unset($_SESSION["report-data"]["reporter-name"]) ?>" />
                </div>
                <div class="reporter-relation box">
                    <label for="reporter-relation" class="title">Relevance to the missed person</label>
                    <input type="text" placeholder="Relevance to the missed person" id="reporter-relation"
                        name="relevance"
                        value="<?= $_SESSION['report-data']["relevance"] ?? "";
                                                                                                                                    unset($_SESSION["report-data"]["relevance"]) ?>" />
                </div>
                <div class="reporter-ssn box">
                    <label for="reporter-ssn" class="title">SSN</label>
                    <input type="text" placeholder="SSN" maxlength="14" id="reporter-ssn" name="ssn"
                        value="<?= $_SESSION['report-data']["ssn"] ?? "";
                                                                                                            unset($_SESSION["report-data"]["ssn"]) ?>" />
                </div>
                <div class="reporter-phone box">
                    <label for="reporter-phone" class="title">phone</label>
                    <input type="text" maxlength="11" name="phone" placeholder="Phone number" id="reporter-phone"
                        value="<?= $_SESSION['report-data']["phone"] ?? "";
                                                                                                                            unset($_SESSION["report-data"]["phone"]) ?>" />
                </div>
                <div class="place">
                    <div class="city">
                        <label class="title">City</label>
                        <select id="reporter-city" name="reporter-city"
                            data-city="<?= $_SESSION['report-data']["reporter-city"] ?? "" ?>">
                            <option value="القاهرة" selected>القاهرة</option>
                            <option value="الإسكندرية">الإسكندرية</option>
                            <option value="الإسماعيلية">الإسماعيلية</option>
                            <option value="كفر الشيخ">كفر الشيخ</option>
                            <option value="أسوان">أسوان</option>
                            <option value="أسيوط">أسيوط</option>
                            <option value="الأقصر">الأقصر</option>
                            <option value="الوادي الجديد">الوادي الجديد</option>
                            <option value="شمال سيناء">شمال سيناء</option>
                            <option value="البحيرة">البحيرة</option>
                            <option value="بني سويف">بني سويف</option>
                            <option value="بورسعيد">بورسعيد</option>
                            <option value="البحر الأحمر">البحر الأحمر</option>
                            <option value="الجيزة">الجيزة</option>
                            <option value="الدقهلية">الدقهلية</option>
                            <option value="جنوب سيناء">جنوب سيناء</option>
                            <option value="دمياط">دمياط</option>
                            <option value="سوهاج">سوهاج</option>
                            <option value="السويس">السويس</option>
                            <option value="الشرقية">الشرقية</option>
                            <option value="الغربية">الغربية</option>
                            <option value="الفيوم">الفيوم</option>
                            <option value="القليوبية">القليوبية</option>
                            <option value="قنا">قنا</option>
                            <option value="مطروح">مطروح</option>
                            <option value="المنوفية">المنوفية</option>
                            <option value="المنيا">المنيا</option>
                        </select>
                    </div>
                    <!-- <div class="town">
                        <label class="title">Town</label>
                        <select name="town" id="town"></select>
                    </div> -->
                </div>
            </div>
            <input type="submit" value="Send" />
        </form>
    </div>
    <?php
    unset($_SESSION["report-data"]);
    ?>
    <?php if (!isset($_SESSION["id"])) : ?>
    <div class="login-error">
        <p>You must login first to</p>
        <p>upload a report</p>
        <div class="order">
            <button class="ok">OK</button>
            <button><a href="login.php">Login</a></button>
        </div>
    </div>
    <div class="login-overlay"></div>
    <?php endif ?>
    <script src="js/missing-found.js"></script>
    <script src="js/header.js"></script>
</body>

</html>