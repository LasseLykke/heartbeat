<?php
ob_start();
session_start();

if (isset($_SESSION['user_id']) && isset($_SESSION['user_name'])) {

    include 'header.php';
    ?>


<!-- Import of datapoints from db -->
<?php 
        $sql1 = "SELECT COUNT(workoutID) AS totalWorkouts FROM workout";
        $result1 = $conn->query($sql1);

        $sql2 = "SELECT COUNT(DISTINCT painDates) AS num_rows FROM pain WHERE painState = 'Ja'";
        $result2 = $conn->query($sql2);

        $sql3 = "SELECT cykelTid, cykelBelastning FROM workout ORDER BY workoutID DESC LIMIT 1;";
        $result3 = $conn->query($sql3);

        $sql4 = "SELECT pulldownRep, pulldownKilo FROM workout ORDER BY workoutID DESC LIMIT 1;";
        $result4 = $conn->query($sql4);

        $sql5 = "SELECT rygbøjningRep, rygbøjningKilo FROM workout ORDER BY workoutID DESC LIMIT 1;";
        $result5 = $conn->query($sql5);

        $sql6 = "SELECT abcrunchRep, abcrunchKilo FROM workout ORDER BY workoutID DESC LIMIT 1;";
        $result6 = $conn->query($sql6);

        $sql7 = "SELECT brystpresRep, brystpresKilo FROM workout ORDER BY workoutID DESC LIMIT 1;";
        $result7 = $conn->query($sql7);

        $sql8 = "SELECT legpressRep, legpressKilo FROM workout ORDER BY workoutID DESC LIMIT 1;";
        $result8 = $conn->query($sql8);

        $sql9 = "SELECT legcurlRep, legcurlKilo FROM workout ORDER BY workoutID DESC LIMIT 1;";
        $result9 = $conn->query($sql9);

        $sql10 = "SELECT legextensionRep, legextensionKilo FROM workout ORDER BY workoutID DESC LIMIT 1;";
        $result10 = $conn->query($sql10);

        $sql11 = "SELECT bicepsRep, bicepsKilo FROM workout ORDER BY workoutID DESC LIMIT 1;";
        $result11 = $conn->query($sql11);

        $sql12 = "SELECT neckRep, neckKilo FROM workout ORDER BY workoutID DESC LIMIT 1;";
        $result12 = $conn->query($sql12);

        $sql13 = "SELECT pullupsRep, pullupsKilo FROM workout ORDER BY workoutID DESC LIMIT 1;";
        $result13 = $conn->query($sql13);

        $sql14 = "SELECT løbTid, løbBelastning  FROM workout ORDER BY workoutID DESC LIMIT 1;";
        $result14 = $conn->query($sql14);

        $sql15 = "SELECT rystemaskineTid FROM workout ORDER BY workoutID DESC LIMIT 1;";
        $result15 = $conn->query($sql15);

        $sql16 = "SELECT buttupsRep FROM workout ORDER BY workoutID DESC LIMIT 1;";
        $result16 = $conn->query($sql16);

        $sql17 = "SELECT vand FROM workout ORDER BY workoutID DESC LIMIT 1;";
        $result17 = $conn->query($sql17);

        $sql18 = "SELECT workoutVarighed FROM workout ORDER BY workoutID DESC LIMIT 1;";
        $result18 = $conn->query($sql18);
?>

    <!DOCTYPE html>
    <html>

    <head>
         <!-- Logger ud efter 15min -->
        <meta http-equiv="refresh" content="1500;url=logout.php" />
        <title>H E A R T B E A T || D A T A </title>
        <link rel="shortcut icon" href="" type="image/x-icon"/>

    </head>

    <body>
        <header>
            <button class="hamburger">
                <div class="bar"></div>
            </button>

            <nav class="mobile-nav">
                <a href="forside.php">Forside</a>
                <a href="dataOverview.php">Statestik</a>
                <a href="logout.php">Log ud</a>
            </nav>
        </header>




       <div class="wrapper">
        <section class="hbHeader">
            <h1 class="headerText">Statestik</h1>
        </section>

        <section class="data">
            <div class="dataCart">
            <a href="export_workout.php"><button class="dataBtn">
                <img src="./img/workout.png" class="dataIcon" alt="workout icon">
                <span class="dataBtnInfo">TEST</span>
                <h3 class="dataBtnInfo">Workout's</h3>
                <p class="dataBtnInfo">DATO</p>
                <p class="dataBtnInfo">TID</p>
                <p class="dataBtnInfo">Se mere -></p>
            </button></a>
            </div>
            
<!--
            <a href="painform.php"><button class="dataBtn">
                <h3>Hovedpine</h3>
                <p>DATO</p>
                <p>TID</p>
                <p>Se mere -></p>
            </button></a>

            <div class="dataCart">
            <a href="export_workout.php"><button class="dataBtn">
                <h3>Cykling</h3>
                <p>DATO</p>
                <p>TID</p>
                <p>Se mere -></p>
            </button></a>


            <a href="painform.php"><button class="dataBtn">
                <h3>Pulldown's</h3>
                <p>DATO</p>
                <p>TID</p>
                <p>Se mere -></p>
            </button></a>

            <div class="dataCart">
            <a href="export_workout.php"><button class="dataBtn">
                <h3>Rygbøjning</h3>
                <p>DATO</p>
                <p>TID</p>
                <p>Se mere -></p>
            </button></a>

            <a href="painform.php"><button class="dataBtn">
                <h3>Ab Crunchs</h3>
                <p>DATO</p>
                <p>TID</p>
                <p>Se mere -></p>
            </button></a>

            <div class="dataCart">
            <a href="export_workout.php"><button class="dataBtn">
                <h3>Brystpres</h3>
                <p>DATO</p>
                <p>TID</p>
                <p>Se mere -></p>
            </button></a>

            <a href="painform.php"><button class="dataBtn">
                <h3>Benpres</h3>
                <p>DATO</p>
                <p>TID</p>
                <p>Se mere -></p>
            </button></a>

            <div class="dataCart">
            <a href="export_workout.php"><button class="dataBtn">
                <h3>Leg Curls</h3>
                <p>DATO</p>
                <p>TID</p>
                <p>Se mere -></p>
            </button></a>

            <a href="painform.php"><button class="dataBtn">
                <h3>Leg Extension</h3>
                <p>DATO</p>
                <p>TID</p>
                <p>Se mere -></p>
            </button></a>

            <div class="dataCart">
            <a href="export_workout.php"><button class="dataBtn">
                <h3>Biceps</h3>
                <p>DATO</p>
                <p>TID</p>
                <p>Se mere -></p>
            </button></a>

            <a href="painform.php"><button class="dataBtn">
                <h3>Neckpress</h3>
                <p>DATO</p>
                <p>TID</p>
                <p>Se mere -></p>
            </button></a>

            <div class="dataCart">
            <a href="export_workout.php"><button class="dataBtn">
                <h3>PullUps</h3>
                <p>DATO</p>
                <p>TID</p>
                <p>Se mere -></p>
            </button></a>

            <a href="painform.php"><button class="dataBtn">
                <h3>Løb</h3>
                <p>DATO</p>
                <p>TID</p>
                <p>Se mere -></p>
            </button></a>

            <div class="dataCart">
            <a href="export_workout.php"><button class="dataBtn">
                <h3>Rystemaskine</h3>
                <p>DATO</p>
                <p>TID</p>
                <p>Se mere -></p>
            </button></a>

            <a href="painform.php"><button class="dataBtn">
                <h3>ButtUps</h3>
                <p>DATO</p>
                <p>TID</p>
                <p>Se mere -></p>
            </button></a>

            <div class="dataCart">
            <a href="export_workout.php"><button class="dataBtn">
                <h3>Vand</h3>
                <p>DATO</p>
                <p>TID</p>
                <p>Se mere -></p>
            </button></a>

            <a href="painform.php"><button class="dataBtn">
                <h3>Varighed</h3>
                <p>DATO</p>
                <p>TID</p>
                <p>Se mere -></p>
            </button></a> -->

        </section>
       </div>

<script src="script.js"></script>
</body>

</html>
<?php
/* Hvis ikke logget ind bliver man sendt tilbage til login skærm */
} else {
    header("Location: index.php");
    exit();
}
?>
