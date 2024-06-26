<?php
    include "classes/database.php";
    include "calculate.php";

    $admin = new database();

    $result_table = array();
    
    $female_production_number = 0;
    $female_casual_wear = 0;
    $female_sports_wear = 0;
    $female_formal_attire = 0;


    if (isset($_POST['submit'])) {
        $winner_candidates = $admin->mysqli->query("SELECT * FROM male_candidates ORDER BY score DESC limit 5");

        while ($row = mysqli_fetch_assoc($winner_candidates)) {
            $admin->updateData('male_candidates', ['winner'=>'qualified'], ['id'=>$row['id']]);
        }

        $winner_candidates_female = $admin->mysqli->query("SELECT * FROM female_candidates ORDER BY score DESC limit 5");

        while ($row = mysqli_fetch_assoc($winner_candidates_female)) {
            $admin->updateData('female_candidates', ['winner'=>'qualified'], ['id'=>$row['id']]);
        }

        header("location: final-ranking-female.php");
    }
?>

<!-- <td>
    <a class="btn btn-primary px-2 py-0" href="edit-candidate-score.php?id=<?php echo $row['female_candidate_id'] ?>&sex=female&category=female_production_number">Edit</a>
</td> -->


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://kit.fontawesome.com/5ad1518180.js" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="images/infor.png" type="image/x-icon">
    <link rel="stylesheet" href="style.css?<?php echo time(); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="script.js" defer></script>
    <style>
                
    .qa-nav:hover {
        background-color: rgb(0,90,215) !important;
    }

    </style>

    <title>List of Summary Female</title>

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
                <a onclick="myFunction();" class="dropbtn"><i class="fa-regular fa-user"></i>Candidates <i class="fa-solid fa-angle-down"></i></a></a>
                <div id="myDropdown" class="dropdown-content">
                    <a href="list-of-male-candidates.php">Mr.</a>
                    <a href="list-of-female-candidates.php">Ms.</a>
                </div>
            </div>

            <div class="dropdown">
                <a onclick="myFunction2();" class="dropbtn"><i class="fa-solid fa-square-poll-vertical"></i>votes/rankings <i class="fa-solid fa-angle-down"></i></a></a>

                <div id="myDropdown2" class="dropdown-content2">
                    <a href="ranking-male.php">Mr.</a>
                    <a href="ranking-female.php">Ms.</a>
                </div>
            </div>


            <div class="dropdown">
              
                <a onclick="myFunction3();" class="dropbtn"><i class="fa-solid fa-square-poll-vertical"></i>Summary <i class="fa-solid fa-angle-down"></i></a></a>

                <div id="myDropdown3" class="dropdown-content3">
                  <a href="summary-male.php">Mr.</a>
                  <a href="summary-female.php">Ms.</a>
                </div>
            </div>

        </div>
    </div>

    <div id="main">
        <div id="title">summary of female candidates</div>


        <nav class="d-flex justify-content-center mb-3">
            <a style="border-right: 1px solid black;" class="qa-nav text-bg-primary py-1 px-2 rounded-1" href="summary-female.php">Elimination</a>
            <a class="qa-nav text-bg-primary py-1 px-2 rounded-1 text-decoration-none" href="final-summary-female.php">QA</a>
        </nav>

        <div class="text-end pe-1">
            <a class="btn btn-secondary mb-2" href="print-summary-female.php" target="_blank">Print</a>
        </div>

        <div class="box">



            <h4 class="text-center fw-bold pt-3">Production Number</h4>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>contestant</th>
                    <?php
                        $production_number_result = $admin->mysqli->query("SELECT DISTINCT judge_name FROM female_production_number ORDER BY judge_name DESC");

                        while ($row = mysqli_fetch_assoc($production_number_result)) {
                    ?>
                        <th><?php echo $row['judge_name'] ;?></th>
                    <?php } ?>
                            
                        <th>Average</th>

                    </tr>
                </thead>
                <tbody>
                    <tbody id="female_production_number">
                        <?php
                            $production_number_result = $admin->mysqli->query("SELECT DISTINCT female_candidate_id FROM female_production_number ORDER BY judge_name DESC, female_candidate_id DESC");

                            $times2 = 0;
                            $highest_score = 0;
                            while ($row = mysqli_fetch_assoc($production_number_result)) {
                                $sum = 0;
                                $times = 0;

                        ?>
                            <tr>
                                <td><?php echo $admin->getName('female_candidates', $row['female_candidate_id'], "name"); ?></td>

                                <?php
                                    $judges_score = $admin->mysqli->query("SELECT * FROM female_production_number WHERE female_candidate_id = $row[female_candidate_id] ORDER BY judge_name DESC");

                                    while ($row2 = mysqli_fetch_assoc($judges_score)) {
                                        $sum += average($row2['poise_and_bearing'], $row2['fitness'], $row2['uniqueness_and_style']);
                                        $times++;
                                ?>
                                
                                <td>
                                    <a class="text-decoration-none text-dark edit-score" href="edit-candidate-score.php?id=<?php echo $row2['id']; ?>&category=female_production_number&sex=female">
                                        <?php echo average($row2['poise_and_bearing'], $row2['fitness'], $row2['uniqueness_and_style']); ?>
                                    </a>
                                </td>

                                <?php }
                                $times2++;
                                
                                if ($highest_score < number_format($sum / $times, 2)) {
                                    $highest_score = number_format($sum / $times, 2);
                                    $female_production_number = $times2;
                                }

                                ?>

                                <td>
                                    <?php echo number_format($sum / $times, 2);?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </tbody>
            </table>



            <h4 style="border-top: 2px dashed black;"  class="text-center fw-bold mt-3 pt-3">Casual Wear</h4>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>contestant</th>
                    <?php
                        $casual_wear_result = $admin->mysqli->query("SELECT DISTINCT judge_name FROM female_casual_wear ORDER BY judge_name DESC");

                        while ($row = mysqli_fetch_assoc($casual_wear_result)) {
                    ?>
                        <th><?php echo $row['judge_name'] ;?></th>
                    <?php } ?>

                        <th>Average</th>


                    </tr>
                </thead>
                <tbody>
                    <tbody id="female_casual_wear">
                        <?php
                            $casual_wear_result = $admin->mysqli->query("SELECT DISTINCT female_candidate_id FROM female_casual_wear ORDER BY judge_name DESC, female_candidate_id DESC");

                            $times2 = 0;
                            $highest_score = 0;
                            while ($row = mysqli_fetch_assoc($casual_wear_result)) {
                            $sum = 0;
                            $times = 0;
                        ?>
                            <tr>
                                <td><?php echo $admin->getName('female_candidates', $row['female_candidate_id'], "name"); ?></td>

                                <?php
                                    $judges_score = $admin->mysqli->query("SELECT * FROM female_casual_wear WHERE female_candidate_id = $row[female_candidate_id] ORDER BY judge_name DESC");

                                    while ($row2 = mysqli_fetch_assoc($judges_score)) {
                                    $sum += average($row2['poise_and_bearing'], $row2['fitness'], $row2['stage_deportment']);
                                    $times++;
                                ?>
                                <td>
                                    <a class="text-decoration-none text-dark edit-score" href="edit-candidate-score.php?id=<?php echo $row2['id']; ?>&category=female_casual_wear&sex=female">    
                                        <?php echo average($row2['poise_and_bearing'], $row2['fitness'], $row2['stage_deportment']); ?>
                                    </a>
                                </td>
                                <?php }
                                
                                $times2++;
                                
                                if ($highest_score < number_format($sum / $times, 2)) {
                                    $highest_score = number_format($sum / $times, 2);
                                    $female_casual_wear = $times2;
                                }
                                ?>

                                <td>
                                    <?php echo number_format($sum / $times, 2);?>
                                </td>

                            </tr>
                        <?php } ?>
                    </tbody>
                </tbody>
            </table>




            
            <h4 style="border-top: 2px dashed black;"  class="text-center fw-bold mt-3 pt-3">Sports Wear</h4>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>contestant</th>
                    <?php
                        $sports_wear_result = $admin->mysqli->query("SELECT DISTINCT judge_name FROM female_sports_wear ORDER BY judge_name DESC");

                        while ($row = mysqli_fetch_assoc($sports_wear_result)) {
                    ?>
                        <th><?php echo $row['judge_name'] ;?></th>
                    <?php } ?>

                    <th>Average</th>

                    </tr>
                </thead>
                <tbody id="female_sports_wear">

                        <?php
                            $sports_wear_result = $admin->mysqli->query("SELECT DISTINCT female_candidate_id FROM female_sports_wear ORDER BY judge_name DESC, female_candidate_id DESC");

                            $times2 = 0;
                            $highest_score = 0;
                            while ($row = mysqli_fetch_assoc($sports_wear_result)) {
                            $sum = 0;
                            $times = 0;
                        ?>
                            <tr>
                                <td><?php echo $admin->getName('female_candidates', $row['female_candidate_id'], "name"); ?></td>

                                <?php
                                    $judges_score = $admin->mysqli->query("SELECT * FROM female_sports_wear WHERE female_candidate_id = $row[female_candidate_id] ORDER BY judge_name DESC");

                                    while ($row2 = mysqli_fetch_assoc($judges_score)) {
                                    $sum += average($row2['poise_and_bearing'], $row2['stage_deportment'], $row2['fitness']);
                                    $times++;
                                ?>
                                <td>
                                    <a class="text-decoration-none text-dark edit-score" href="edit-candidate-score.php?id=<?php echo $row2['id']; ?>&category=female_sports_wear&sex=female">    
                                        <?php echo average($row2['poise_and_bearing'], $row2['stage_deportment'], $row2['fitness']); ?>
                                    </a>
                                </td>

                                <?php }
                                
                                $times2++;
                                
                                if ($highest_score < number_format($sum / $times, 2)) {
                                    $highest_score = number_format($sum / $times, 2);
                                    $female_sports_wear = $times2;
                                }
                                ?>

                                <td>
                                    <?php echo number_format($sum / $times, 2);?>
                                </td>

                            </tr>
                        <?php } ?>

                </tbody>
            </table>




                        
            <h4 style="border-top: 2px dashed black;" class="text-center fw-bold mt-3 pt-3">Formal Attire</h4>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>contestant</th>
                    <?php
                        $formal_attire_result = $admin->mysqli->query("SELECT DISTINCT judge_name FROM female_formal_attire ORDER BY judge_name DESC");

                        while ($row = mysqli_fetch_assoc($formal_attire_result)) {
                    ?>
                        <th><?php echo $row['judge_name'] ;?></th>
                    <?php } ?>

                    <th>Average</th>

                    </tr>
                </thead>
                <tbody id="female_formal_attire">

                        <?php
                            $formal_attire_result = $admin->mysqli->query("SELECT DISTINCT female_candidate_id FROM female_formal_attire ORDER BY judge_name DESC, female_candidate_id DESC");

                            $times2 = 0;
                            $highest_score = 0;
                            while ($row = mysqli_fetch_assoc($formal_attire_result)) {
                            $sum = 0;
                            $times = 0;
                        ?>
                            <tr>
                                <td><?php echo $admin->getName('female_candidates', $row['female_candidate_id'], "name"); ?></td>

                                <?php
                                    $judges_score = $admin->mysqli->query("SELECT * FROM female_formal_attire WHERE female_candidate_id = $row[female_candidate_id] ORDER BY judge_name DESC");

                                    while ($row2 = mysqli_fetch_assoc($judges_score)) {
                                    $sum += average($row2['poise_and_bearing'], $row2['stage_presence'], $row2['fitness_and_style'], $row2['elegance']);
                                    $times++;
                                ?>
                                <td>
                                    <a class="text-decoration-none text-dark edit-score" href="edit-candidate-score.php?id=<?php echo $row2['id']; ?>&category=female_formal_attire&sex=female">    
                                        <?php echo average($row2['poise_and_bearing'], $row2['stage_presence'], $row2['fitness_and_style'], $row2['elegance']); ?>
                                    </a>
                                </td>


                                <?php }
                                
                                $times2++;
                                
                                if ($highest_score < number_format($sum / $times, 2)) {
                                    $highest_score = number_format($sum / $times, 2);
                                    $female_formal_attire = $times2;
                                }
                                ?>

                                <td>
                                    <?php echo number_format($sum / $times, 2);?>
                                </td>
                                
                            </tr>
                        <?php } ?>
                    </tbody>

            </table>


        </div>

        <!-- Button trigger modal -->
            <div class="text-center">
            <button type="button" class="btn btn-success mt-2 mx-auto" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Start QA
            </button>
        </div>


        <!-- Modal -->

        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Warning!</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body mx-auto" style="margin:0; text-align: center;">
                Are you Sure You want to Start QA?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"  style="font-size: .7rem; padding: 2px 5px" data-bs-dismiss="modal">Cancel</button>
                <form method="post" class="text-center">
                    <input class="btn btn-primary" style="font-size: .7rem; padding: 2px 17px; position: relative; bottom: 1px;" type="submit" name="submit" value="Yes">
                </form >
            </div>
            </div>
        </div>
        </div>

    </div>

    <script defer>

        production_number = document.getElementById("female_production_number");
        production_number.getElementsByTagName('tr')[<?php echo $female_production_number - 1; ?>].style.border = '2px solid yellow';

        casual_wear = document.getElementById("female_casual_wear");
        casual_wear.getElementsByTagName('tr')[<?php echo $female_casual_wear - 1; ?>].style.border = '2px solid yellow';

        sports_wear = document.getElementById("female_sports_wear");
        sports_wear.getElementsByTagName('tr')[<?php echo $female_sports_wear - 1; ?>].style.border = '2px solid yellow';

        formal_attire = document.getElementById("female_formal_attire");
        formal_attire.getElementsByTagName('tr')[<?php echo $female_formal_attire - 1; ?>].style.border = '2px solid yellow';
        
    </script>

</body>

</html>