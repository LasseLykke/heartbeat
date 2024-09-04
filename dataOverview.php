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
        "SELECT vægt FROM workout ORDER BY workoutID DESC LIMIT 1",
        "SELECT workoutDates, workoutVarighed FROM workout ORDER BY workoutDates DESC LIMIT 1",
        "SELECT painDates, painDuration FROM pain ORDER BY painDates DESC LIMIT 1"
    ];
    
    $results = [];
    foreach ($sqls as $key => $sql) {
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $results[$key] = $result->fetch_assoc();
        } else {
            $results[$key] = null;
        }
    }
    
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
    
    $vægt = $results[16]['vægt'] ?? "Ingen data";
    
    $lastWorkoutDate = $results[17]['workoutDates'] ?? "Ingen data";
    $lastWorkoutDuration = $results[17]['workoutVarighed'] ?? "Ingen data";

    $painDates = $results[18]['painDates'] ?? "Ingen data";
    $painDuration = $results[18]['painDuration'] ?? "Ingen data";
    
    // Close Connection
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

        <

        <section class="data">
            <div class="dataCart">
            <a href="./export/workout.php">
                <div class="dataBtn">
                <div class="dataCartHeader">
                    <img src="./img/workout.png" class="dataIcon" alt="workout icon">
                    <h3>Workout</h3>
                </div>
                    <div class="dataCartInfo">
                        <div class="inline">
                    <p class="dataBtnInfo"><?php echo date('d/m', strtotime($lastWorkoutDate)); ?> |</p>
                    <p class="dataBtnInfo"><?php echo $lastWorkoutDuration; ?>min</p>
                    <br>
                    <button class="primBtn">Se mere</button>
                </div></div>
                </div></a>
            </div>

            <div class="dataCart">
            <a href="export_workout.php">
                <div class="dataBtn">
                <div class="dataCartHeader">
                    <img src="./img/headache.png" class="dataIcon" alt="workout icon">
                    <h3>Pain</h3>
                </div>
                    <div class="dataCartInfo">
                        <div class="inline">
                    <p class="dataBtnInfo"><?php echo date('d/m', strtotime($painDates)); ?> |</p>
                    <p class="dataBtnInfo"><?php echo $painDuration; ?>t</p>
                    <br>
                    <button class="primBtn">Se mere</button>
                </div></div>
                </div></a>
            </div>

            <div class="dataCart">
            <a href="export_workout.php">
                <div class="dataBtn">
                <div class="dataCartHeader">
                    <img src="./img/cykel.png" class="dataIcon" alt="workout icon">
                    <h3>Cykling</h3>
                </div>
                    <div class="dataCartInfo">
                        <div class="inline">
                    <p class="dataBtnInfo"><?php echo $cykelBelastning; ?> |</p>
                    <p class="dataBtnInfo"><?php echo $cykelTid; ?>min</p>
                    <br>
                    <button class="primBtn">Se mere</button>
                </div></div>
                </div></a>
            </div>

            <div class="dataCart">
            <a href="export_workout.php">
                <div class="dataBtn">
                <div class="dataCartHeader">
                    <img src="./img/pullupdown.png" class="dataIcon" alt="workout icon">
                    <h3>PullDown</h3>
                </div>
                    <div class="dataCartInfo">
                        <div class="inline">
                    <p class="dataBtnInfo"><?php echo $pulldownKilo; ?>kg |</p>
                    <p class="dataBtnInfo"><?php echo $pulldownRep; ?>rep</p>
                    <br>
                    <button class="primBtn">Se mere</button>
                </div></div>
                </div></a>
            </div>

            <div class="dataCart">
            <a href="export_workout.php">
                <div class="dataBtn">
                <div class="dataCartHeader">
                    <img src="./img/ryg.png" class="dataIcon" alt="workout icon">
                    <h3>Rygbøjning</h3>
                </div>
                    <div class="dataCartInfo">
                        <div class="inline">
                        <p class="dataBtnInfo"><?php echo $rygbøjningKilo; ?>kg |</p>
                    <p class="dataBtnInfo"><?php echo $rygbøjningRep; ?>rep</p>
                    <br>
                    <button class="primBtn">Se mere</button>
                </div></div>
                </div></a>
            </div>

            <div class="dataCart">
            <a href="export_workout.php">
                <div class="dataBtn">
                <div class="dataCartHeader">
                    <img src="./img/abs.png" class="dataIcon" alt="workout icon">
                    <h3>Abchrunch</h3>
                </div>
                    <div class="dataCartInfo">
                        <div class="inline">
                        <p class="dataBtnInfo"><?php echo $abcrunchKilo; ?>kg |</p>
                    <p class="dataBtnInfo"><?php echo $abcrunchRep; ?>rep</p>
                    <br>
                    <button class="primBtn">Se mere</button>
                </div></div>
                </div></a>
            </div>

            <div class="dataCart">
            <a href="export_workout.php">
                <div class="dataBtn">
                <div class="dataCartHeader">
                    <img src="./img/brystpres.png" class="dataIcon" alt="workout icon">
                    <h3>Brystpres</h3>
                </div>
                    <div class="dataCartInfo">
                        <div class="inline">
                        <p class="dataBtnInfo"><?php echo $brystpresKilo; ?>kg |</p>
                    <p class="dataBtnInfo"><?php echo $brystpresRep; ?>rep</p>
                    <br>
                    <button class="primBtn">Se mere</button>
                </div></div>
                </div></a>
            </div>

            <div class="dataCart">
            <a href="export_workout.php">
                <div class="dataBtn">
                <div class="dataCartHeader">
                    <img src="./img/legpress.png" class="dataIcon" alt="workout icon">
                    <h3>Legpres</h3>
                </div>
                    <div class="dataCartInfo">
                        <div class="inline">
                        <p class="dataBtnInfo"><?php echo $legpressKilo; ?>kg |</p>
                    <p class="dataBtnInfo"><?php echo $legpressRep; ?>rep</p>
                    <br>
                    <button class="primBtn">Se mere</button>
                </div></div>
                </div></a>
            </div>

            <div class="dataCart">
            <a href="export_workout.php">
                <div class="dataBtn">
                <div class="dataCartHeader">
                    <img src="./img/legpress.png" class="dataIcon" alt="workout icon">
                    <h3>Curl</h3>
                </div>
                    <div class="dataCartInfo">
                        <div class="inline">
                        <p class="dataBtnInfo"><?php echo $legcurlKilo; ?>kg |</p>
                    <p class="dataBtnInfo"><?php echo $legcurlRep; ?>rep</p>
                    <br>
                    <button class="primBtn">Se mere</button>
                </div></div>
                </div></a>
            </div>

            <div class="dataCart">
            <a href="export_workout.php">
                <div class="dataBtn">
                <div class="dataCartHeader">
                    <img src="./img/legpress.png" class="dataIcon" alt="workout icon">
                    <h3>Extension</h3>
                </div>
                    <div class="dataCartInfo">
                        <div class="inline">
                        <p class="dataBtnInfo"><?php echo $legextensionKilo; ?>kg |</p>
                    <p class="dataBtnInfo"><?php echo $legextensionRep; ?>rep</p>
                    <br>
                    <button class="primBtn">Se mere</button>
                </div></div>
                </div></a>
            </div>

            <div class="dataCart">
            <a href="export_workout.php">
                <div class="dataBtn">
                <div class="dataCartHeader">
                    <img src="./img/biceps.png" class="dataIcon" alt="workout icon">
                    <h3>Bicpes</h3>
                </div>
                    <div class="dataCartInfo">
                        <div class="inline">
                    <p class="dataBtnInfo"><?php echo $bicepsKilo; ?>kg |</p>
                    <p class="dataBtnInfo"><?php echo $bicepsRep; ?>rep</p>
                    <br>
                    <button class="primBtn">Se mere</button>
                </div></div>
                </div></a>
            </div>

            <div class="dataCart">
            <a href="export_workout.php">
                <div class="dataBtn">
                <div class="dataCartHeader">
                    <img src="./img/brystpres.png" class="dataIcon" alt="workout icon">
                    <h3>Neckpres</h3>
                </div>
                    <div class="dataCartInfo">
                        <div class="inline">
                        <p class="dataBtnInfo"><?php echo $neckKilo; ?>kg |</p>
                    <p class="dataBtnInfo"><?php echo $neckRep; ?>rep</p>
                    <br>
                    <button class="primBtn">Se mere</button>
                </div></div>
                </div></a>
            </div>
            

            <div class="dataCart">
            <a href="export_workout.php">
                <div class="dataBtn">
                <div class="dataCartHeader">
                    <img src="./img/buttups.png" class="dataIcon" alt="workout icon">
                    <h3>Buttups</h3>
                </div>
                    <div class="dataCartInfo">
                        <div class="inline">
                        <p class="dataBtnInfo"><?php echo $buttupsRep; ?>rep</p>
                    <br>
                    <button class="primBtn">Se mere</button>
                </div></div>
                </div></a>
            </div>

            <div class="dataCart">
            <a href="export_workout.php">
                <div class="dataBtn">
                <div class="dataCartHeader">
                    <img src="./img/pullupdown.png" class="dataIcon" alt="workout icon">
                    <h3>Pullups</h3>
                </div>
                    <div class="dataCartInfo">
                        <div class="inline">
                        <p class="dataBtnInfo"><?php echo $pullupsKilo; ?>kg |</p>
                    <p class="dataBtnInfo"><?php echo $pullupsRep; ?>rep</p>
                    <br>
                    <button class="primBtn">Se mere</button>
                </div></div>
                </div></a>
            </div>

            <div class="dataCart">
            <a href="export_workout.php">
                <div class="dataBtn">
                <div class="dataCartHeader">
                    <img src="./img/løb.png" class="dataIcon" alt="workout icon">
                    <h3>Løb</h3>
                </div>
                    <div class="dataCartInfo">
                        <div class="inline">
                        <p class="dataBtnInfo"><?php echo $løbBelastning; ?>kg |</p>
                    <p class="dataBtnInfo"><?php echo $løbTid; ?>min</p>
                    <br>
                    <button class="primBtn">Se mere</button>
                </div></div>
                </div></a>
            </div>

            <div class="dataCart">
            <a href="export_workout.php">
                <div class="dataBtn">
                <div class="dataCartHeader">
                    <img src="./img/ryste.png" class="dataIcon" alt="workout icon">
                    <h3>Ryst</h3>
                </div>
                    <div class="dataCartInfo">
                        <div class="inline">
                        <p class="dataBtnInfo"><?php echo $rystemaskineTid; ?>min </p>
                    <br>
                    <button class="primBtn">Se mere</button>
                </div></div>
                </div></a>
            </div>

            <div class="dataCart">
            <a href="export_workout.php">
                <div class="dataBtn">
                <div class="dataCartHeader">
                    <img src="./img/vand.png" class="dataIcon" alt="workout icon">
                    <h3>Vand</h3>
                </div>
                    <div class="dataCartInfo">
                        <div class="inline">
                        <p class="dataBtnInfo"><?php echo $vand; ?> liter</p>
                    <br>
                    <button class="primBtn">Se mere</button>
                </div></div>
                </div></a>
            </div>

            <div class="dataCart">
            <a href="export_workout.php">
                <div class="dataBtn">
                <div class="dataCartHeader">
                    <img src="./img/vægt.png" class="dataIcon" alt="workout icon">
                    <h3>Vægt</h3>
                </div>
                    <div class="dataCartInfo">
                        <div class="inline">
                        <p class="dataBtnInfo"><?php echo $vægt; ?>kg </p>
                    <br>
                    <button class="primBtn">Se mere</button>
                </div></div>
                </div></a>
            </div>

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
