<?php
ob_start();
session_start();


if (isset($_SESSION['user_id']) && isset($_SESSION['user_name'])) {

    include '../header.php';
    require '../navbar.php';
    ?>

    


    <!-- Import of datapoints from db -->
    <?php

$sqls = [
    "SELECT painSession.sessionDate, headacheLog.headacheDuration 
 FROM painSession 
 JOIN headacheLog ON painSession.sessionID = headacheLog.sessionID 
 WHERE headacheLog.hasHeadache = 1 
 AND headacheLog.headacheDuration  
 ORDER BY painSession.sessionDate DESC LIMIT 1",
    "SELECT cykelTid, cykelBelastning FROM woCykel ORDER BY cykelID DESC LIMIT 1",
    "SELECT pulldownRep, pulldownKilo FROM woPulldown ORDER BY pulldownID DESC LIMIT 1",
    "SELECT rygRep FROM woRyg ORDER BY rygID DESC LIMIT 1",
    "SELECT absRep, absKilo FROM woAbs ORDER BY absID DESC LIMIT 1",
    "SELECT brystpressRep, brystpressKilo FROM woBrystpress ORDER BY brystpressID DESC LIMIT 1",
    "SELECT legpressRep, legpressKilo FROM woLegpress ORDER BY legpressID DESC LIMIT 1",
    "SELECT legcurlRep, legcurlKilo FROM woLegcurl ORDER BY legcurlID DESC LIMIT 1",
    "SELECT legextensionRep, legextensionKilo FROM woExtension ORDER BY legextensionID DESC LIMIT 1",
    "SELECT bicepsRep, bicepsKilo FROM woBiceps ORDER BY bicepsID DESC LIMIT 1",
    "SELECT tricepsRep, tricepsKilo FROM woTriceps ORDER BY tricepsID DESC LIMIT 1",
    "SELECT neckpressRep, neckpressKilo FROM woNeck ORDER BY neckpressID DESC LIMIT 1",
    "SELECT pullupsRep, pullupsKilo FROM woPullups ORDER BY pullupsID DESC LIMIT 1",
    "SELECT loebTid, loebBelastning FROM woLoeb ORDER BY loebID DESC LIMIT 1",
    "SELECT rystTid FROM woRyst ORDER BY rystID DESC LIMIT 1",
    "SELECT buttupsRep FROM woButtups ORDER BY buttupsID DESC LIMIT 1",
    "SELECT gnsPuls FROM woVaerdi ORDER BY vaerdiID DESC LIMIT 1",
    "SELECT kcal FROM woVaerdi ORDER BY vaerdiID DESC LIMIT 1",
    "SELECT vand FROM woVand ORDER BY vandID DESC LIMIT 1",
    "SELECT vaegt FROM woVaegt ORDER BY vaegtID DESC LIMIT 1",
    "SELECT varighed FROM woVarighed ORDER BY varighedID DESC LIMIT 1",
    "SELECT ps.sessionDate, bp.painLevel 
    FROM painSession AS ps 
    JOIN bodyPainLog AS bp ON ps.sessionID = bp.sessionID 
    WHERE bp.painLevel > 0 
    ORDER BY ps.sessionDate DESC LIMIT 1",
    "SELECT ps.sessionDate, ps.mentalState 
    FROM painSession AS ps 
    WHERE ps.mentalState IS NOT NULL 
    ORDER BY ps.sessionDate DESC LIMIT 1",
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

$painDate = $results[0]['sessionDate'] ?? "Ingen data";
$headacheDuration = $results[0]['headacheDuration'] ?? "Ingen data";

$cykelTid = $results[1]['cykelTid'] ?? "Ingen data";
$cykelBelastning = $results[1]['cykelBelastning'] ?? "Ingen data";

$pulldownRep = $results[2]['pulldownRep'] ?? "Ingen data";
$pulldownKilo = $results[2]['pulldownKilo'] ?? "Ingen data";

$rygRep = $results[3]['rygRep'] ?? "Ingen data";

$absRep = $results[4]['absRep'] ?? "Ingen data";
$absKilo = $results[4]['absKilo'] ?? "Ingen data";

$brystpressRep = $results[5]['brystpressRep'] ?? "Ingen data";
$brystpressKilo = $results[5]['brystpressKilo'] ?? "Ingen data";

$legpressRep = $results[6]['legpressRep'] ?? "Ingen data";
$legpressKilo = $results[6]['legpressKilo'] ?? "Ingen data";

$legcurlRep = $results[7]['legcurlRep'] ?? "Ingen data";
$legcurlKilo = $results[7]['legcurlKilo'] ?? "Ingen data";

$legextensionRep = $results[8]['legextensionRep'] ?? "Ingen data";
$legextensionKilo = $results[8]['legextensionKilo'] ?? "Ingen data";

$bicepsRep = $results[9]['bicepsRep'] ?? "Ingen data";
$bicepsKilo = $results[9]['bicepsKilo'] ?? "Ingen data";

$tricepsRep = $results[10]['tricepsRep'] ?? "Ingen data";
$tricepsKilo = $results[10]['tricepsKilo'] ?? "Ingen data";

$neckpressRep = $results[11]['neckpressRep'] ?? "Ingen data";
$neckpressKilo = $results[11]['neckpressKilo'] ?? "Ingen data";

$pullupsRep = $results[12]['pullupsRep'] ?? "Ingen data";
$pullupsKilo = $results[12]['pullupsKilo'] ?? "Ingen data";

$loebTid = $results[13]['loebTid'] ?? "Ingen data";
$loebBelastning = $results[13]['loebBelastning'] ?? "Ingen data";

$rystTid = $results[14]['rystTid'] ?? "Ingen data";

$buttupsRep = $results[15]['buttupsRep'] ?? "Ingen data";

$gnsPuls = $results[16]['gnsPuls'] ?? "Ingen data"; 
$kcal = $results[17]['kcal'] ?? "Ingen data";    

$vand = $results[18]['vand'] ?? "Ingen data";

$vaegt = $results[19]['vaegt'] ?? "Ingen data";

$lastWorkoutDate = $results[20]['sessionDate'] ?? "Ingen data";
$lastWorkoutDuration = $results[20]['varighed'] ?? "Ingen data";

$bodyPainDate = $results[21]['sessionDate'] ?? "Ingen data";
$bodyPainLevel = $results[21]['painLevel'] ?? "Ingen data";

$mentalStateDate = $results[22]['sessionDate'] ?? "Ingen data";
$mentalState = $results[22]['mentalState'] ?? "Ingen data";

// Close Connection
$conn->close();
?>



    <!DOCTYPE html>
    <html>

    <head>
        <!-- Logger ud efter 15min -->
        <meta http-equiv="refresh" content="1500;url=../logout.php" />
        <title>H E A R T B E A T || D A T A </title>
        <link rel="shortcut icon" href="" type="image/x-icon" />

    </head>

    <body>
    
        <div class="wrapper">
            <section class="hbHeader">
                <h1 class="headerText">Statestik</h1>
            </section>



            <section class="data">
                <div class="dataCart">
                    <a href="../export/exportHeadache.php">
                        <div class="dataBtn">
                            <div class="dataCartHeader">
                                <img src="../img/headache.png" class="dataIcon" alt="workout icon">
                                <h3>Hovedpine</h3>
                            </div>
                            <div class="dataCartInfo">
                                <div class="inline">
                                    <p class="dataBtnInfo"><?php echo date('d/m', strtotime($painDate)); ?> |</p>
                                    <p class="dataBtnInfo">
                                        <?php echo ($headacheDuration !== "Ingen data") ? $headacheDuration . "t" : "Ingen data"; ?>
                                    </p>

                                    <br>
                                    <button class="primBtn">Se mere</button>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="dataCart">
                    <a href="../export/exportCykling.php">
                        <div class="dataBtn">
                            <div class="dataCartHeader">
                                <img src="../img/cykel.png" class="dataIcon" alt="workout icon">
                                <h3>Cykling</h3>
                            </div>
                            <div class="dataCartInfo">
                                <div class="inline">
                                    <p class="dataBtnInfo"><?php echo $cykelBelastning; ?> |</p>
                                    <p class="dataBtnInfo"><?php echo $cykelTid; ?></p>
                                    <br>
                                    <button class="primBtn">Se mere</button>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="dataCart">
                    <a href="../export/exportPulldown.php">
                        <div class="dataBtn">
                            <div class="dataCartHeader">
                                <img src="../img/pullupdown.png" class="dataIcon" alt="workout icon">
                                <h3>PullDown</h3>
                            </div>
                            <div class="dataCartInfo">
                                <div class="inline">
                                    <p class="dataBtnInfo"><?php echo $pulldownKilo; ?>kg |</p>
                                    <p class="dataBtnInfo"><?php echo $pulldownRep; ?>rep</p>
                                    <br>
                                    <button class="primBtn">Se mere</button>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="dataCart">
                    <a href="../export/exportRyg.php">
                        <div class="dataBtn">
                            <div class="dataCartHeader">
                                <img src="../img/ryg.png" class="dataIcon" alt="workout icon">
                                <h3>Rygbøjning</h3>
                            </div>
                            <div class="dataCartInfo">
                                <div class="inline">
                                    <p class="dataBtnInfo"><?php echo $rygRep; ?>rep</p>
                                    <br>
                                    <button class="primBtn">Se mere</button>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="dataCart">

                    <a href="../export/exportAbchruns.php">
                        <div class="dataBtn">
                            <div class="dataCartHeader">
                                <img src="../img/abs.png" class="dataIcon" alt="workout icon">
                                <h3>Abchrunch</h3>
                            </div>
                            <div class="dataCartInfo">
                                <div class="inline">
                                    <p class="dataBtnInfo"><?php echo $absKilo; ?>kg |</p>
                                    <p class="dataBtnInfo"><?php echo $absRep; ?>rep</p>
                                    <br>
                                    <button class="primBtn">Se mere</button>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="dataCart">
                    <a href="../export/exportBrystpres.php">
                        <div class="dataBtn">
                            <div class="dataCartHeader">
                                <img src="../img/brystpres.png" class="dataIcon" alt="workout icon">
                                <h3>Brystpres</h3>
                            </div>
                            <div class="dataCartInfo">
                                <div class="inline">
                                    <p class="dataBtnInfo"><?php echo $brystpressKilo; ?>kg |</p>
                                    <p class="dataBtnInfo"><?php echo $brystpressRep; ?>rep</p>
                                    <br>
                                    <button class="primBtn">Se mere</button>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="dataCart">
                    <a href="../export/exportLegpress.php">
                        <div class="dataBtn">
                            <div class="dataCartHeader">
                                <img src="../img/legpress.png" class="dataIcon" alt="workout icon">
                                <h3>Legpres</h3>
                            </div>
                            <div class="dataCartInfo">
                                <div class="inline">
                                    <p class="dataBtnInfo"><?php echo $legpressKilo; ?>kg |</p>
                                    <p class="dataBtnInfo"><?php echo $legpressRep; ?>rep</p>
                                    <br>
                                    <button class="primBtn">Se mere</button>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="dataCart">
                    <a href="../export/exportLegcurl.php">
                        <div class="dataBtn">
                            <div class="dataCartHeader">
                                <img src="../img/legpress.png" class="dataIcon" alt="workout icon">
                                <h3>Curl</h3>
                            </div>
                            <div class="dataCartInfo">
                                <div class="inline">
                                    <p class="dataBtnInfo"><?php echo $legcurlKilo; ?>kg |</p>
                                    <p class="dataBtnInfo"><?php echo $legcurlRep; ?>rep</p>
                                    <br>
                                    <button class="primBtn">Se mere</button>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="dataCart">
                    <a href="../export/exportLegextension.php">
                        <div class="dataBtn">
                            <div class="dataCartHeader">
                                <img src="../img/legpress.png" class="dataIcon" alt="workout icon">
                                <h3>Extension</h3>
                            </div>
                            <div class="dataCartInfo">
                                <div class="inline">
                                    <p class="dataBtnInfo"><?php echo $legextensionKilo; ?>kg |</p>
                                    <p class="dataBtnInfo"><?php echo $legextensionRep; ?>rep</p>
                                    <br>
                                    <button class="primBtn">Se mere</button>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="dataCart">
                    <a href="../export/exportBiceps.php">
                        <div class="dataBtn">
                            <div class="dataCartHeader">
                                <img src="../img/biceps.png" class="dataIcon" alt="workout icon">
                                <h3>Bicpes</h3>
                            </div>
                            <div class="dataCartInfo">
                                <div class="inline">
                                    <p class="dataBtnInfo"><?php echo $bicepsKilo; ?>kg |</p>
                                    <p class="dataBtnInfo"><?php echo $bicepsRep; ?>rep</p>
                                    <br>
                                    <button class="primBtn">Se mere</button>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="dataCart">
                    <a href="../export/exportTriceps.php">
                        <div class="dataBtn">
                            <div class="dataCartHeader">
                                <img src="../img/biceps.png" class="dataIcon" alt="workout icon">
                                <h3>Triceps</h3>
                            </div>
                            <div class="dataCartInfo">
                                <div class="inline">
                                    <p class="dataBtnInfo"><?php echo $tricepsKilo; ?>kg |</p>
                                    <p class="dataBtnInfo"><?php echo $tricepsRep; ?>rep</p>
                                    <br>
                                    <button class="primBtn">Se mere</button>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="dataCart">
                    <a href="../export/exportNeckpress.php">
                        <div class="dataBtn">
                            <div class="dataCartHeader">
                                <img src="../img/brystpres.png" class="dataIcon" alt="workout icon">
                                <h3>Neckpres</h3>
                            </div>
                            <div class="dataCartInfo">
                                <div class="inline">
                                    <p class="dataBtnInfo"><?php echo $neckpressKilo; ?>kg |</p>
                                    <p class="dataBtnInfo"><?php echo $neckpressRep; ?>rep</p>
                                    <br>
                                    <button class="primBtn">Se mere</button>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>


                <div class="dataCart">
                    <a href="../export/exportButtups.php">
                        <div class="dataBtn">
                            <div class="dataCartHeader">
                                <img src="../img/buttups.png" class="dataIcon" alt="workout icon">
                                <h3>Buttups</h3>
                            </div>
                            <div class="dataCartInfo">
                                <div class="inline">
                                    <p class="dataBtnInfo"><?php echo $buttupsRep; ?>rep</p>
                                    <br>
                                    <button class="primBtn">Se mere</button>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>


                <div class="dataCart">
                    <a href="../export/exportPullups.php">
                        <div class="dataBtn">
                            <div class="dataCartHeader">
                                <img src="../img/pullupdown.png" class="dataIcon" alt="workout icon">
                                <h3>Pullups</h3>
                            </div>
                            <div class="dataCartInfo">
                                <div class="inline">
                                    <p class="dataBtnInfo"><?php echo $pullupsKilo; ?>kg |</p>
                                    <p class="dataBtnInfo"><?php echo $pullupsRep; ?>rep</p>
                                    <br>
                                    <button class="primBtn">Se mere</button>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="dataCart">
                    <a href="../export/exportLøb.php">
                        <div class="dataBtn">
                            <div class="dataCartHeader">
                                <img src="../img/løb.png" class="dataIcon" alt="workout icon">
                                <h3>Løb</h3>
                            </div>
                            <div class="dataCartInfo">
                                <div class="inline">
                                    <p class="dataBtnInfo"><?php echo $loebBelastning; ?> |</p>
                                    <p class="dataBtnInfo"><?php echo $loebTid; ?>min</p>
                                    <br>
                                    <button class="primBtn">Se mere</button>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="dataCart">
                    <a href="../export/exportRyst.php">
                        <div class="dataBtn">
                            <div class="dataCartHeader">
                                <img src="../img/ryste.png" class="dataIcon" alt="workout icon">
                                <h3>Ryst</h3>
                            </div>
                            <div class="dataCartInfo">
                                <div class="inline">
                                    <p class="dataBtnInfo"><?php echo $rystTid; ?>min </p>
                                    <br>
                                    <button class="primBtn">Se mere</button>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="dataCart">
                    <a href="../export/exportVand.php">
                        <div class="dataBtn">
                            <div class="dataCartHeader">
                                <img src="../img/vand.png" class="dataIcon" alt="workout icon">
                                <h3>Vand</h3>
                            </div>
                            <div class="dataCartInfo">
                                <div class="inline">
                                    <p class="dataBtnInfo"><?php echo $vand; ?> liter</p>
                                    <br>
                                    <button class="primBtn">Se mere</button>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="dataCart">
                    <a href="../export/exportVærdier.php">
                        <div class="dataBtn">
                            <div class="dataCartHeader">
                                <img src="../img/buttups.png" class="dataIcon" alt="workout icon">
                                <h3>Værdier</h3>
                            </div>
                            <div class="dataCartInfo">
                                <div class="inline">
                                <p class="dataBtnInfo"><?php echo $gnsPuls; ?>P |</p>
                                    <p class="dataBtnInfo"><?php echo $kcal; ?>kcal</p>
                                    <br>
                                    <button class="primBtn">Se mere</button>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="dataCart">
                    <a href="../export/exportVægt.php">
                        <div class="dataBtn">
                            <div class="dataCartHeader">
                                <img src="../img/vægt.png" class="dataIcon" alt="workout icon">
                                <h3>Vægt</h3>
                            </div>
                            <div class="dataCartInfo">
                                <div class="inline">
                                    <p class="dataBtnInfo"><?php echo $vaegt; ?>kg </p>
                                    <br>
                                    <button class="primBtn">Se mere</button>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="dataCart">
                    <a href="../export/exportVarighed.php">
                        <div class="dataBtn">
                            <div class="dataCartHeader">
                                <img src="../img/workout.png" class="dataIcon" alt="workout icon">
                                <h3>Varighed</h3>
                            </div>
                            <div class="dataCartInfo">
                                <div class="inline">
                                    <p class="dataBtnInfo"><?php echo $lastWorkoutDuration ?: "Ingen varighed fundet"; ?>
                                    </p>
                                    <br>
                                    <button class="primBtn">Se mere</button>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="dataCart">
                    <a href="../export/exportBodyPain.php">
                        <div class="dataBtn">
                            <div class="dataCartHeader">
                                <img src="../img/headache.png" class="dataIcon" alt="workout icon">
                                <h3>Bodypain</h3>
                            </div>
                            <div class="dataCartInfo">
                                <div class="inline">
                                    <p class="dataBtnInfo"><?php echo date('d/m', strtotime($bodyPainDate)); ?> |</p>
                                    <p class="dataBtnInfo">
                                        <?php echo ($bodyPainLevel !== "Ingen data") ? $bodyPainLevel : "Ingen data"; ?>
                                    </p>

                                    <br>
                                    <button class="primBtn">Se mere</button>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="dataCart">
                    <a href="../export/exportMentalState.php">
                        <div class="dataBtn">
                            <div class="dataCartHeader">
                                <img src="../img/headache.png" class="dataIcon" alt="workout icon">
                                <h3>Mental</h3>
                            </div>
                            <div class="dataCartInfo">
                                <div class="inline">
                                    <p class="dataBtnInfo"><?php echo date('d/m', strtotime($mentalStateDate)); ?> |</p>
                                    <p class="dataBtnInfo">
                                        <?php echo ($mentalState !== "Ingen data") ? $mentalState : "Ingen data"; ?>
                                    </p>

                                    <br>
                                    <button class="primBtn">Se mere</button>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

            </section>
        </div>

        <script src="../script.js"></script>
    </body>

    </html>
    <?php
    /* Hvis ikke logget ind bliver man sendt tilbage til login skærm */
} else {
    header("Location: /index.php");
    exit();
}
?>