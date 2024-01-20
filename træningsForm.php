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
    
    
    if ($workoutDates) {
        $mysqli->begin_transaction();

       

    $sql = "INSERT INTO workout 
    (workoutDates, cykelTid, cykelBelastning, pulldownRep, pulldownKilo, rygbøjningRep, rygbøjningKilo, abcrunchRep,
     abcrunchKilo, brystpresRep, brystpresKilo, legpressRep, legpressKilo, legcurlRep, legcurlKilo, legextensionRep, legextensionKilo, bicepsRep, bicepsKilo, buttupsRep, pullupsRep, pullupsKilo, 
     løbTid, løbBelastning, rystemaskineTid, musik, vand, vægt) 
     VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

    $stmt = $mysqli->prepare($sql);

    if ($stmt === false) {
        die("Error: " . $mysqli->error);
    }

    $stmt->bind_param("ssssssssssssssssssssssssssss", $workoutDates, $cykelTid, $cykelBelastning, $pulldownRep, $pulldownKilo, $rygbøjningRep, $rygbøjningKilo, $abcrunchRep, $abcrunchKilo, 
    $brystpresRep, $brystpresKilo, $legpressRep, $legpressKilo, $legcurlRep, $legcurlKilo, $legextensionRep, $legextensionKilo, $bicepsRep, $bicepsKilo, $buttupsRep, $pullupsRep, $pullupsKilo, 
    $løbTid, $løbBelastning, $rystemaskineTid, $musik, $vand, $vægt);
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

        <div class="workoutWrapper">
            <form class="træningsForm" action="" method="POST">
                <h2>Trænings log</h2>

                <label for="workoutDates">Dato</label>
                <input type="date" id="workoutDates" name="dato">

                <!-- CYKEL -->
                <label for="cykelTid">Cykel Tid</label>
                <input type="number" id="cykelTid" name="cykelTid">

                <label for="cykelBelastning">Belastning</label>
                <input type="number" id="cykelBelastning" name="cykelBelastning">

                <!-- PULLDOWN -->
                <label for="pulldownRep">Pull Down Rep.</label>
                <input type="number" id="pulldownRep" name="pulldownRep">

                <label for="pulldownKilo">Pull Down Kilo</label>
                <input type="text" id="pulldownKilo" name="pulldownKilo">

                <!-- RYGBØJNING --> 
                <label for="rygbøjningRep">Rygbøjning Rep.</label>
                <input type="number" id="rygbøjningRep" name="rygbøjningRep">

                <label for="rygbøjningKilo">Rygbøjning Kilo</label>
                <input type="text" id="rygbøjningKilo" name="rygbøjningKilo">
                
                <!-- ABCRUNCH --> 
                <label for="abcrunchRep">Abcrunch Rep.</label>
                <input type="number" id="abcrunchRep" name="abcrunchRep">

                <label for="abcrunchKilo">Abcrunch Kilo</label>
                <input type="text" id="abcrunchKilo" name="abcrunchKilo">
                
                <!-- BRYSTPRES --> 
                <label for="brystpresRep">Brystpres Rep.</label>
                <input type="number" id="brystpresRep" name="brystpresRep">

                <label for="brystpresKilo">Brystpres Kilo</label>
                <input type="text" id="brystpresKilo" name="brystpresKilo">
                
                <!-- LEGPRESS --> 
                <label for="legpressRep">Legpress Rep.</label>
                <input type="number" id="legpressRep" name="legpressRep">

                <label for="legpressKilo">Legpress Kilo</label>
                <input type="text" id="legpressKilo" name="legpressKilo">
                
                <!-- LEGCURL --> 
                <label for="legcurlRep">Legcurl Rep.</label>
                <input type="number" id="legcurlRep" name="legcurlRep">

                <label for="legpressKilo">Legcurl Kilo</label>
                <input type="text" id="legpcurlKilo" name="legcurlKilo">
                
                <!-- LEGEXTENSION --> 
                <label for="legextensionRep">Legextension Rep.</label>
                <input type="number" id="legextensionRep" name="legextensionRep">

                <label for="legpressKilo">Legextension Kilo</label>
                <input type="text" id="legpextensionKilo" name="legextensionKilo">
                
                <!-- BICEPS --> 
                <label for="bicepsRep">Biceps Rep.</label>
                <input type="number" id="bicepsRep" name="bicepsRep">

                <label for="bicepsKilo">Biceps Kilo</label>
                <input type="text" id="bicepsKilo" name="bicepsKilo">
                
                <!-- BUTTUPS --> 
                <label for="buttupsRep">Buttups Rep.</label>
                <input type="number" id="buttupsRep" name="buttupsRep">
                
                <!-- PULLUPS --> 
                <label for="pullupsRep">Pullups Rep.</label>
                <input type="number" id="pullupsRep" name="pullupsRep">
                
                <label for="pullupsKilo">Pullups Kilo</label>
                <input type="number" id="pullupskilo" name="pullupsKilo">
                
                <!-- LØB --> 
                <label for="løbTid">Løb Tid</label>
                <input type="number" id="løbTid" name="løbTid">
                
                <label for="løbBelastning">Løb Belastning</label>
                <input type="number" id="løbBelastning" name="løbBelastning">

                <!-- RYSTEMASKINE --> 
                <label for="rystemaskineTid">Rystemaskine</label>
                <input type="number" id="rystemaskineTid" name="rystemaskineTid">
                
                <!-- MUSIK & GENRE --> 
                <input type="radio" id="podcast" name="musik" value="Podcast">
                <label for="podcast">Podcast</label><br>
                <input type="radio" id="rock" name="musik" value="Rock">
                <label for="rock">Rock // Metalcore</label><br>
                <input type="radio" id="intet" name="musik" value="intet">
                <label for="intet">Intet // TV i centeret</label><br>

                <!-- VAND --> 
                <label for="vand">Drukket vand?</label>
                <input type="text" id="vand" name="vand">
                
                <!-- VÆGT --> 
                <label for="vægt">Vægt</label>
                <input type="text" id="vægt" name="vægt">




                
    
                <button class="submit">save</button>
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