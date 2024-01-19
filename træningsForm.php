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
    
    
    if ($workoutDates) {
        $mysqli->begin_transaction();

       

    $sql = "INSERT INTO workout (workoutDates, cykelTid, cykelBelastning, pulldownRep, pulldownKilo, rygbøjningRep, rygbøjningKilo, abcrunchRep, abcrunchKilo, brystpresRep, brystpresKilo, legpressRep, legpressKilo) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";

    $stmt = $mysqli->prepare($sql);

    if ($stmt === false) {
        die("Error: " . $mysqli->error);
    }

    $stmt->bind_param("sssssssssssss", $workoutDates, $cykelTid, $cykelBelastning, $pulldownRep, $pulldownKilo, $rygbøjningRep, $rygbøjningKilo, $abcrunchRep, $abcrunchKilo, $brystpresRep, $brystpresKilo, $legpressRep, $legpressKilo);
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