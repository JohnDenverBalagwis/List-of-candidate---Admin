<?php
    include "classes/database.php";

    $admin = new database();

    $id = $_GET['id'];

    if ($_GET['sex'] == 'male') {
        $candidate = $admin->select('male_candidates', '*', ['id'=>$id]);
    } else if ($_GET['sex'] == "female") {
        $candidate = $admin->select('female_candidates', '*', ['id'=>$id]);
    }

    $candidate_number;
    $name;
    $age;
    $course;
    $image;

    while ($row = mysqli_fetch_assoc($candidate)) {
        $candidate_number = $row['candidate_number'];
        $name = $row['name'];
        $age = $row['age'];
        $course = $row['course'];
        $image = $row['image'];
    }

    if (isset($_POST['submit'])) {
        $candidate_number = $_POST['candidate-number'];
        $name = mysqli_escape_string($admin->mysqli, $_POST['name']);
        $age = mysqli_escape_string($admin->mysqli, $_POST['age']);
        $course = mysqli_escape_string($admin->mysqli, $_POST['course']);

        if ($admin->checkIfImage('candidate-image') || $_FILES['candidate-image']['size'] == 0) {
            if ($_GET['sex'] == 'male') {
                $candidate = $admin->updateData('male_candidates', ['candidate_number'=>$candidate_number, 'name'=>$name, 'age'=>$age, 'course'=>$course], ['id'=>$id]);

                if ($_FILES['candidate-image']['size'] == 1) {
                    $admin->updateImage('candidate-image', 'male_candidates', 'image', 'uploads/');
                }

                header("location: list-of-male-candidates.php?edit");
            } else if ($_GET['sex'] == "female") {
                $candidate = $admin->updateData('female_candidates', ['candidate_number'=>$candidate_number, 'name'=>$name, 'age'=>$age, 'course'=>$course], ['id'=>$id]);

                if ($_FILES['candidate-image']['size'] == 1) {
                    $admin->updateImage('candidate-image', 'female_candidates', 'image', 'uploads/');
                }
                header("location: list-of-female-candidates.php?edit");

            }
        }

    }   

    
?>





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://kit.fontawesome.com/5ad1518180.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css?<?php echo time(); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <title>List of Candidates</title>

</head>

<body>
    <div id="sidebar">
        <div class="upper-logo">
            <figure class="logo">
                <img src="images/infor.png" alt="logo">
            </figure>
            <div class="name">
                <div class="informatics">Informatics</div>
                <div class="college">COLLEGE</div>
            </div>
        </div>

        <div class="nav-links">
            <div class="dropdown">
                <a onclick="myFunction()" class="dropbtn"><i class="fa-regular fa-user"></i>Candidates <i class="fa-solid fa-angle-down"></i></a></a>
                <div id="myDropdown" class="dropdown-content">
                    <a href="#">Mr.</a>
                    <a href="#">Ms.</a>
                </div>
            </div>

            <div class="dropdown">
                <a onclick="myFunction2()" class="dropbtn"><i class="fa-solid fa-square-poll-vertical"></i>votes/rankings <i class="fa-solid fa-angle-down"></i></a></a>

                <div id="myDropdown2" class="dropdown-content2">
                    <a href="/ranking-male.php">Mr.</a>
                    <a href="ranking-female.php">Ms.</a>
                </div>
            </div>

            <a href="#"> <i class="fa-solid fa-square-poll-vertical"></i> summary</a>
        </div>
    </div>

    <div id="main">
        <div id="title">edit male candidates</div>



        <div class="box">
            <form method="post" class="modal-main-content" enctype="multipart/form-data" style="margin: 50px 0;">
                <div class="modal-inputs">
                    <label for="">Number:</label>
                    <input class="form-control" type="text" name="candidate-number" value="<?php echo $candidate_number; ?>" required>
                </div>
                <div class="modal-inputs">
                    <label for="">Name:</label>
                    <input class="form-control" type="text" value="<?php echo $name; ?>"  name="name" required>
                </div>
                <div class="modal-inputs">
                    <label for="">Age:</label>
                    <input class="form-control" type="number" value="<?php echo $age; ?>"  name="age" required>
                </div>
                <div class="modal-inputs">
                    <label for="">Course:</label>
                    <input class="form-control" type="text" value="<?php echo $course; ?>" name="course" required>
                </div>
                <div class="" style="width: 10rem;">
                    <img style="width: 100%;" src="uploads/<?php echo $image; ?>" alt="">
                </div>
                <div class="modal-inputs" class="input-group mb-3">
                    <label class="form-label">Image</label>
                    <input type="file" class="form-control" name="candidate-image" id="inputGroupFile01">
                </div>

                <div class="modal-buttons">
                    <a style="padding: 1px 5px;" class="btn btn-danger" href="list-of-male-candidates.php?edited">Cancel</a>
                    <input class="btn btn-primary" class="bacground-color: #004e92;" type="submit" name="submit" value="Submit">
                </div>
            </form >
        </div>

    </div>

    <div id="myModal" class="modal">
        <div class="modal-body">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h4>Registration</h4>
            </div>

            <form method="post" class="modal-main-content" enctype="multipart/form-data">
                <div class="modal-inputs">
                    <label for="">Number:</label>
                    <input class="form-control" type="text" name="candidate-number" value="<?php echo $candidateNumber; ?>" required>
                </div>
                <div class="modal-inputs">
                    <label for="">Name:</label>
                    <input class="form-control" type="text" name="name" required>
                </div>
                <div class="modal-inputs">
                    <label for="">Age:</label>
                    <input class="form-control" type="number" name="age" required>
                </div>
                <div class="modal-inputs">
                    <label for="">Course:</label>
                    <input class="form-control" type="text" name="course" required>
                </div>
                <div class="modal-inputs" class="input-group mb-3">
                    <label class="form-label">Image</label>
                    <input type="file" class="form-control" name="candidate-image" id="inputGroupFile01" required>
                </div>
    
                <div class="modal-buttons">
                    <span id="cancel">Cancel</span>
                    <input type="submit" name="submit" value="Submit">
                </div>
            </form >
        </div>
    </div>


    <div id="errorPopup" class="popup">
      <div class="popup-content">
        <span class="close" onclick="hideError()">&times;</span>
        <p id="errorMessage">Error Message Here</p>
      </div>
    </div>

    <?php

    ?>

</body>

</html>