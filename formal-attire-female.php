<?php

include "classes/database.php";

$judges = new database();

session_start();

$name = $_SESSION['name'];

$candidates = $judges->mysqli->query("SELECT * FROM female_candidates ORDER BY candidate_number ASC");

if (isset($_POST['submit'])) {
    while ($row = mysqli_fetch_assoc($candidates)) {
        $id = $row['id'];

        $poise_and_bearing = $_POST["poise-and-bearing$id"];
        $stage_presence = $_POST["stage-presence$id"];
        $fitness_and_style = $_POST["fitness-and-style$id"];
        $elegance = $_POST["elegance$id"];

        $judges->insertData('female_formal_attire', ['female_candidate_id'=>$id, 'judge_name'=>$name, 'poise_and_bearing'=>$poise_and_bearing, 'stage_presence'=>$stage_presence, 'fitness_and_style'=>$fitness_and_style, 'elegance'=>$elegance]);
    }

    header("location: formal-attire-male.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formal Attire Female</title>
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

        <h3 class="title-category">Formal Attire Female 25%</h3>
    </nav>

    <div class="main-container">
        <div class="main-content">
            <div class="slider-container">
            <div class="slider">
                    <div class="slides">
                        <?php
                            while ($row = mysqli_fetch_assoc($candidates)) {
                        ?>
                            <div>
                                <h1 class="text-center text-white"><?php echo $row['candidate_number'] ?></h1>
                                <img style="width: 500px" src="uploads/<?php echo $row['image']; ?>"> 
                                <h3 class="text-center text-white"><?php echo $row['name']; ?></h3>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>

        <form class="scoring-container" method="post">
            <table class="table table-striped candidate-table">
                <thead>
                    <tr>
                        <th style="padding: 0;">Candidate No.</th>
                        <th>Candidate Name</th>
                        <th>Poise and Bearing
                            <br>
                            <p class="fst-italic fw-lighter">30%</p>
                        </th>
                        <th>Stage Presence
                            <br>
                            <p class="fst-italic fw-lighter">25%</p>
                        </th>
                        <th>Fitness and Style
                            <br>
                            <p class="fst-italic fw-lighter">25%</p>
                        </th>
                        <th>Elegance
                            <br>
                            <p class="fst-italic fw-lighter">20%</p>
                        </th>
                    </tr>
                </thead>
                <tbody id="myTable">
                    <?php
                        $candidates = $judges->mysqli->query("SELECT * FROM female_candidates ORDER BY candidate_number ASC");

                        $i = 0;

                        while ($row = mysqli_fetch_assoc($candidates)) {
                        $i++;
                    ?>
                    <tr data-index="<?php echo $i; ?>">
                        <td>
                            <h5 class="fw-bold"><?php echo $row['candidate_number']; ?></h5>
                        </td>
                        <td>
                            <h5 class="text-start"><?php echo $row['name']; ?></h5>
                        </td>
                        <td>
                            <input style="width: 4.6rem;" class="candidate-input form-control mx-auto thirty" type="number" name="poise-and-bearing<?php echo $row['id']; ?>" required>
                        </td>
                        <td>
                            <input style="width: 4.6rem;" class="candidate-input form-control mx-auto twentyFive" type="number" name="stage-presence<?php echo $row['id']; ?>" required>
                        </td>
                        <td>
                            <input style="width: 4.6rem;" class="candidate-input form-control mx-auto twentyFive" type="number" name="fitness-and-style<?php echo $row['id']; ?>" required>
                        </td>
                        <td>
                            <input style="width: 4.6rem;" class="candidate-input form-control mx-auto twenty" type="number" name="elegance<?php echo $row['id']; ?>" required>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>


            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Submit
            </button>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Warning</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                    <div class="modal-body" style="margin: 0 auto;">
                        Are you Sure you Want to Submit?
                    </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">No</button>
                            <input class="btn btn-primary" type="submit" name="submit" value="Yes">
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>

    <div id="popup">
      <p id="popupMessage"></p>
    </div>



    <script>
        function showPopup(message) {
            var popup = document.getElementById("popup");
            document.getElementById('popupMessage').innerHTML = message;
            popup.style.display = "block"; // Show the popup

            // Automatically close the popup after 2 seconds
            setTimeout(function() {
                popup.style.display = "none"; // Hide the popup
            }, 1500);
        }

                
            

        function limitInput (cName, limit) {
            let limitTwenty = document.querySelectorAll(`.${cName}`);

            for (let i = 0; i < limitTwenty.length; i++) {
            // Add event listener to the input field
            limitTwenty[i].addEventListener('input', function() {
                // Get the current value of the input field
                let value = parseInt(limitTwenty[i].value);

                // Check if the value is greater than 30
                if (value > limit) {
                    // If greater than 30, set the value to 30
                    limitTwenty[i].value = limit;
                }
            });
            }
        }

        limitInput('twentyFive', 25);
        limitInput('thirty', 30);
        limitInput('twenty', 20);


        document.querySelectorAll('#myTable tr').forEach(row => {
        row.addEventListener('click', function() {
            const index = parseInt(this.dataset.index);
            const slideWidth = document.querySelector('.slider').offsetWidth;
            const slides = document.querySelector('.slides');
            slides.style.transform = `translateX(-${(index - 1) * slideWidth}px)`;
        });
        });



    </script>

    <?php 
        if (!isset($_SESSION['formal-attire-female'])) {
            echo "<script>showPopup('Submitted Sucessfully');</script>";
            $_SESSION['formal-attire-female'] = true;
        }
    ?>
</body>

</html>