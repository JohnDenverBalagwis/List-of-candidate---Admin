<?php
include "classes/database.php";

session_start();

if (!isset($_COOKIE['name'])) {
    header('location: index.php');
}


$judges = new database();

if (isset($_POST['submit'])) {
    setcookie('category', 'qa-female.php', time() + (7 * 24 * 60 * 60));

    header("location: qa-female.php");
    
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Judge for QA</title>
    <link rel="stylesheet" href="css/image-slider.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="style.css?<?php echo time(); ?>">
    <link rel="shortcut icon" href="images/infor.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="image-slider.js" defer></script>
</head>

<body>
    <nav class="top-nav">
        <div class="logo-container">
            <img class="logo" src="images/info logo.png" alt="">
            <div class="logo-text">
                <h5>Informatics</h5>
                <h6>College</h6>
            </div>
        </div>
    </nav>

    <h1 class="text-white fw-bold text-center" style="margin-top: 20vh;">Question & Answer Portion</h1>


    <?php
        if ($judges->isExisted('male_candidates', ['winner'=>'qualified']) || $judges->isExisted('female_candidates', ['winner'=>'qualified'])) {
    ?>
    <form action="" method="post" class="text-center">
        <input class="btn btn-primary fs-4" name="submit" type="submit" value="Get Started">
    </form>
    <?php }else {
        echo '<h3 class="text-white text-center">Stand by</h3>';
    } ?>

</body>

</html>