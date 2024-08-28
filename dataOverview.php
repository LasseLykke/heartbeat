<?php
ob_start();
session_start();

if (isset($_SESSION['user_id']) && isset($_SESSION['user_name'])) {

    include 'header.php';
    ?>


<!-- Import of datapoints from db -->
<?php 
       
       $sqls = [
        "SELECT COUNT(DISTINCT painDates) AS num_rows FROM pain WHERE painState = 'Ja'",
        "SELECT cykelTid, cykelBelastning FROM workout ORDER BY workoutID DESC LIMIT 1",
        "SELECT pulldownRep, pulldownKilo FROM workout ORDER BY workoutID DESC LIMIT 1",
        "SELECT rygbøjningRep, rygbøjningKilo FROM workout ORDER BY workoutID DESC LIMIT 1",
        "SELECT abcrunchRep, abcrunchKilo FROM workout ORDER BY workoutID DESC LIMIT 1",
        "SELECT brystpresRep, brystpresKilo FROM workout ORDER BY workoutID DESC LIMIT 1",
        "SELECT legpressRep, legpressKilo FROM workout ORDER BY workoutID DESC LIMIT 1",
        "SELECT legcurlRep, legcurlKilo FROM workout ORDER BY workoutID DESC LIMIT 1",
        "SELECT legextensionRep, legextensionKilo FROM workout ORDER BY workoutID DESC LIMIT 1",
        "SELECT bicepsRep, bicepsKilo FROM workout ORDER BY workoutID DESC LIMIT 1",
        "SELECT neckRep, neckKilo FROM workout ORDER BY workoutID DESC LIMIT 1",
        "SELECT pullupsRep, pullupsKilo FROM workout ORDER BY workoutID DESC LIMIT 1",
        "SELECT løbTid, løbBelastning FROM workout ORDER BY workoutID DESC LIMIT 1",
        "SELECT rystemaskineTid FROM workout ORDER BY workoutID DESC LIMIT 1",
        "SELECT buttupsRep FROM workout ORDER BY workoutID DESC LIMIT 1",
        "SELECT vand FROM workout ORDER BY workoutID DESC LIMIT 1",
        "SELECT workoutDates, workoutVarighed FROM workout ORDER BY workoutDates DESC LIMIT 1" 
    ];
    
    // Eksekver forespørgslerne og gem resultaterne
    $results = [];
    foreach ($sqls as $key => $sql) {
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $results[$key] = $result->fetch_assoc();
        } else {
            $results[$key] = null;
        }
    }
    
    // Ekstraktion af resultater
    $num_rows = $results[0]['num_rows'] ?? "Ingen data";
    
    $cykelTid = $results[1]['cykelTid'] ?? "Ingen data";
    $cykelBelastning = $results[1]['cykelBelastning'] ?? "Ingen data";
    
    $pulldownRep = $results[2]['pulldownRep'] ?? "Ingen data";
    $pulldownKilo = $results[2]['pulldownKilo'] ?? "Ingen data";
    
    $rygbøjningRep = $results[3]['rygbøjningRep'] ?? "Ingen data";
    $rygbøjningKilo = $results[3]['rygbøjningKilo'] ?? "Ingen data";
    
    $abcrunchRep = $results[4]['abcrunchRep'] ?? "Ingen data";
    $abcrunchKilo = $results[4]['abcrunchKilo'] ?? "Ingen data";
    
    $brystpresRep = $results[5]['brystpresRep'] ?? "Ingen data";
    $brystpresKilo = $results[5]['brystpresKilo'] ?? "Ingen data";
    
    $legpressRep = $results[6]['legpressRep'] ?? "Ingen data";
    $legpressKilo = $results[6]['legpressKilo'] ?? "Ingen data";
    
    $legcurlRep = $results[7]['legcurlRep'] ?? "Ingen data";
    $legcurlKilo = $results[7]['legcurlKilo'] ?? "Ingen data";
    
    $legextensionRep = $results[8]['legextensionRep'] ?? "Ingen data";
    $legextensionKilo = $results[8]['legextensionKilo'] ?? "Ingen data";
    
    $bicepsRep = $results[9]['bicepsRep'] ?? "Ingen data";
    $bicepsKilo = $results[9]['bicepsKilo'] ?? "Ingen data";
    
    $neckRep = $results[10]['neckRep'] ?? "Ingen data";
    $neckKilo = $results[10]['neckKilo'] ?? "Ingen data";
    
    $pullupsRep = $results[11]['pullupsRep'] ?? "Ingen data";
    $pullupsKilo = $results[11]['pullupsKilo'] ?? "Ingen data";
    
    $løbTid = $results[12]['løbTid'] ?? "Ingen data";
    $løbBelastning = $results[12]['løbBelastning'] ?? "Ingen data";
    
    $rystemaskineTid = $results[13]['rystemaskineTid'] ?? "Ingen data";
    
    $buttupsRep = $results[14]['buttupsRep'] ?? "Ingen data";
    
    $vand = $results[15]['vand'] ?? "Ingen data";
    
    $lastWorkoutDate = $results[16]['workoutDates'] ?? "Ingen data";
    $lastWorkoutDuration = $results[16]['workoutVarighed'] ?? "Ingen data";
    
    // Luk forbindelse til databasen
    $conn->close();
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
                <div class="dataCartHeader">
                    <img src="./img/workout.png" class="dataIcon" alt="workout icon">
                    <h3>Workout's</h3>
                </div>
                <div class="dataCartInfo">
                <p class="dataBtnInfo"><?php echo date('d/m/y', strtotime($lastWorkoutDate)); ?></p>

                <p class="dataBtnInfo"><?php echo $lastWorkoutDuration; ?>min</p>
                <br>
                <p class="dataBtnInfo">Se mere -></p>
                </div>
            </button></a>
            </div>
            
            <div class="dataCart">
            <a href="export_workout.php"><button class="dataBtn">
                <div class="dataCartHeader">
                    <img src="./img/workout.png" class="dataIcon" alt="workout icon">
                    <h3>Pain</h3>
                </div>
                <div class="dataCartInfo">
                <p class="dataBtnInfo"><?php echo date('d/m/y', strtotime($lastWorkoutDate)); ?></p>
                <p class="dataBtnInfo"><?php echo $lastWorkoutDuration; ?>timer</p>
                <br>
                <p class="dataBtnInfo">Se mere -></p>
                </div>
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
