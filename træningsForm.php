<?php 
session_start();

if (isset($_SESSION['user_id']) && isset($_SESSION['user_name'])) {
include 'header.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $workoutDates = htmlspecialchars($_POST["dato"]);
    $cykelTid = htmlspecialchars($_POST["cykelTid"]);
    $cykelBelastning = htmlspecialchars($_POST["cykelBelastning"]);
    $pulldownRep = htmlspecialchars($_POST["pulldownRep"]);
    $pulldownKilo = htmlspecialchars($_POST["pulldownKilo"]);
    $rygbøjningRep = htmlspecialchars($_POST["rygbøjningRep"]);
    $rygbøjningKilo = htmlspecialchars($_POST["rygbøjningKilo"]);
    $abcrunchRep = htmlspecialchars($_POST["abcrunchRep"]);
    $abcrunchKilo = htmlspecialchars($_POST["abcrunchKilo"]);
    $brystpresRep = htmlspecialchars($_POST["brystpresRep"]);
    $brystpresKilo = htmlspecialchars($_POST["brystpresKilo"]);
    $legpressRep = htmlspecialchars($_POST["legpressRep"]);
    $legpressKilo = htmlspecialchars($_POST["legpressKilo"]);
    $legcurlRep = htmlspecialchars($_POST["legcurlRep"]);
    $legcurlKilo = htmlspecialchars($_POST["legcurlKilo"]);
    $legextensionRep = htmlspecialchars($_POST["legextensionRep"]);
    $legextensionKilo = htmlspecialchars($_POST["legextensionKilo"]);
    $bicepsRep = htmlspecialchars($_POST["bicepsRep"]);
    $bicepsKilo = htmlspecialchars($_POST["bicepsKilo"]);
    $buttupsRep = htmlspecialchars($_POST["buttupsRep"]);
    $pullupsRep = htmlspecialchars($_POST["pullupsRep"]);
    $pullupsKilo = htmlspecialchars($_POST["pullupsKilo"]);
    $løbTid = htmlspecialchars($_POST["løbTid"]);
    $løbBelastning = htmlspecialchars($_POST["løbBelastning"]);
    $rystemaskineTid = htmlspecialchars($_POST["rystemaskineTid"]);
    $musik = htmlspecialchars($_POST["musik"]);
    $vand = htmlspecialchars($_POST["vand"]);
    $vægt = htmlspecialchars($_POST["vægt"]);
    $bemærkning = htmlspecialchars($_POST["bemærkning"]);
    
    
    if ($workoutDates) {
        $mysqli->begin_transaction();

       

    $sql = "INSERT INTO workout 
    (workoutDates, cykelTid, cykelBelastning, pulldownRep, pulldownKilo, rygbøjningRep, rygbøjningKilo, abcrunchRep,
     abcrunchKilo, brystpresRep, brystpresKilo, legpressRep, legpressKilo, legcurlRep, legcurlKilo, legextensionRep, legextensionKilo, bicepsRep, bicepsKilo, buttupsRep, pullupsRep, pullupsKilo, 
     løbTid, løbBelastning, rystemaskineTid, musik, vand, vægt, bemærkning) 
     VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

    $stmt = $mysqli->prepare($sql);

    if ($stmt === false) {
        die("Error: " . $mysqli->error);
    }

    $stmt->bind_param("sssssssssssssssssssssssssssss", $workoutDates, $cykelTid, $cykelBelastning, $pulldownRep, $pulldownKilo, $rygbøjningRep, $rygbøjningKilo, $abcrunchRep, $abcrunchKilo, 
    $brystpresRep, $brystpresKilo, $legpressRep, $legpressKilo, $legcurlRep, $legcurlKilo, $legextensionRep, $legextensionKilo, $bicepsRep, $bicepsKilo, $buttupsRep, $pullupsRep, $pullupsKilo, 
    $løbTid, $løbBelastning, $rystemaskineTid, $musik, $vand, $vægt, $bemærkning);
    $stmt->execute();

    // Commit the transaction if the first statement executed successfully
    $mysqli->commit();

    // Close the statement
    $stmt->close();
    
    // Close the database connection
    $mysqli->close();

        //  Går tilbage til bekræftelses side fra form.
        header("Location: forside.php");
        exit();
}}
?>


<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>H E A R T B E A T || WorkOut Log </title>
    </head>
    <body>

    <?php
        // Viser success eller fejl meddelelse
        if (isset($_SESSION["message"])) {
        echo "<p>{$_SESSION["message"]}</p>";
        unset($_SESSION["message"]);
        } 
    ?>

        <div class="formWrapper">
            <form class="træningsForm" action="" method="POST">
                <h1>Trænings log</h1>

                <!-- DATE -->
                <div class="workoutDate">
                    <h3>Dato:</h3>
                <label for="workoutDates"></label>
                <input type="date" id="workoutDates" name="dato">
                </div>

                <!-- CYKEL -->
                <div class="workoutCykel">
                    <h3>Cykling:</h3>
                <label for="cykelTid"></label>
                <input type="number" id="cykelTid" name="cykelTid" placeholder="Tid:">

                <label for="cykelBelastning"></label>
                <input type="number" id="cykelBelastning" name="cykelBelastning" placeholder="Belastning">
                </div>

                <!-- PULLDOWN -->
                <div class="workoutPulldown">
                    <h3>PullDown:</h3>
                <label for="pulldownRep"></label>
                <input type="number" id="pulldownRep" name="pulldownRep" placeholder="Rep">
                

                <label for="pulldownKilo"></label>
                <input type="text" id="pulldownKilo" name="pulldownKilo" placeholder="Kilo">
                </div>

                <!-- RYGBØJNING --> 
                <div class="workoutRygbøjning">
                    <h3>Rygbøjning:</h3>
                <label for="rygbøjningRep"></label>
                <input type="number" id="rygbøjningRep" name="rygbøjningRep" placeholder="Rep">
                

                <label for="rygbøjningKilo"></label>
                <input type="text" id="rygbøjningKilo" name="rygbøjningKilo" placeholder="Kilo">
                </div>
                
                <!-- ABCRUNCH --> 
                <div class="workoutAbs">
                    <h3>Abcrunch:</h3>
                <label for="abcrunchRep"></label>
                <input type="number" id="abcrunchRep" name="abcrunchRep" placeholder="Rep">

                <label for="abcrunchKilo"></label>
                <input type="text" id="abcrunchKilo" name="abcrunchKilo" placeholder="Kilo">
                </div>

                <!-- BRYSTPRES --> 
                <div class="workoutBrystpres">
                    <h3>Brystpres:</h3>
                <label for="brystpresRep"></label>
                <input type="number" id="brystpresRep" name="brystpresRep" placeholder="Rep">
                

                <label for="brystpresKilo"></label>
                <input type="text" id="brystpresKilo" name="brystpresKilo" placeholder="Kilo">
                </div>

                <!-- LEGPRESS --> 
                <div class="workoutLegpress">
                    <h3>Legpress:</h3>
                <label for="legpressRep"></label>
                <input type="number" id="legpressRep" name="legpressRep" placeholder="Rep">

                <label for="legpressKilo"></label>
                <input type="text" id="legpressKilo" name="legpressKilo" placeholder="Kilo">
                </div>

                <!-- LEGCURL --> 
                <div class="workoutLegcurl">
                    <h3>Legcurl:</h3>
                <label for="legcurlRep"></label>
                <input type="number" id="legcurlRep" name="legcurlRep" placeholder="Rep">

                <label for="legpressKilo"></label>
                <input type="text" id="legpcurlKilo" name="legcurlKilo" placeholder="Kilo">
                </div>
                
                <!-- LEGEXTENSION --> 
                <div class="workoutLegextension">
                    <h3>Legextension:</h3>
                <label for="legextensionRep"></label>
                <input type="number" id="legextensionRep" name="legextensionRep" placeholder="Rep">

                <label for="legpressKilo"></label>
                <input type="text" id="legpextensionKilo" name="legextensionKilo" placeholder="Kilo">
                </div>

                <!-- BICEPS --> 
                <div class="workoutBiceps">
                    <h3>Biceps:</h3>
                <label for="bicepsRep"></label>
                <input type="number" id="bicepsRep" name="bicepsRep" placeholder="Rep">

                <label for="bicepsKilo"></label>
                <input type="text" id="bicepsKilo" name="bicepsKilo" placeholder="Kilo">
                </div>

                <!-- BUTTUPS --> 
                <div class="workoutButtups">
                    <h3>ButtUps:</h3>
                <label for="buttupsRep"></label>
                <input type="number" id="buttupsRep" name="buttupsRep" placeholder="Rep">
                </div>
                
                <!-- PULLUPS --> 
                <div class="workoutPullups">
                    <h3>PullUps:</h3>
                <label for="pullupsRep"></label>
                <input type="number" id="pullupsRep" name="pullupsRep" placeholder="Rep">
                
                <label for="pullupsKilo"></label>
                <input type="number" id="pullupskilo" name="pullupsKilo" placeholder="Kilo">
                </div>

                <!-- LØB --> 
                <div class="workoutLøb">
                    <h3>Løb:</h3>
                <label for="løbTid"></label>
                <input type="number" id="løbTid" name="løbTid" placeholder="Tid">
                
                <label for="løbBelastning"></label>
                <input type="number" id="løbBelastning" name="løbBelastning" placeholder="Belastning">
                </div>

                <!-- RYSTEMASKINE --> 
                <div class="workoutRyst">
                    <h3>Rystemaskine:</h3>
                <label for="rystemaskineTid"></label>
                <input type="number" id="rystemaskineTid" name="rystemaskineTid" placeholder="Tid">
                </div>
                
                <!-- MUSIK & GENRE --> 
                <div class="workoutMusik">
                    <h3>Musik Genre:</h3>
                <input type="radio" id="podcast" name="musik" value="Podcast">
                <label for="podcast">Podcast</label><br>
                <input type="radio" id="rock" name="musik" value="Rock">
                <label for="rock">Rock // Metalcore</label><br>
                <input type="radio" id="intet" name="musik" value="intet">
                <label for="intet">Intet // TV i centeret</label><br>
                </div>

                <!-- VAND --> 
                <div class="workoutVandOgVægt">
                <h3>Vand:</h3>
                
                <input type="text" id="vand" name="vand" placeholder="Drukket vand?">
                
                <!-- VÆGT --> 
                <h3>Vægt:</h3>
                
                <input type="text" id="vægt" name="vægt" placeholder="Vægt">
                </div>

                <!-- BEMÆRKNING -->
                <div class="workoutBemærkning">
                    <h3>Bemærkning:</h3>
                <label for="bemærkning"></label>
                <textarea id="bemærkning" placeholder="Indsæt bemærkning" name="bemærkning"></textarea>
                </div>




                
    
                <button class="submit">Gem</button>
            </form>
        </div>
        

    </body>
</html>
<?php
/* Hvis ikke logget ind bliver man sendt tilbage til login skærm */
} else {
    header("Location: index.php");
    exit();
}
?>