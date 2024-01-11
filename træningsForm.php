<?php 
session_start();

if (isset($_SESSION['user_id']) && isset($_SESSION['user_name'])) {
include 'header.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $workoutDates = htmlspecialchars($_POST["dato"]);
    $cykelTid = htmlspecialchars($_POST["cykelTid"]);
    $cykelBelastning = htmlspecialchars($_POST["cykelBelastning"]);
    $pulldownRep = htmlspecialchars($_POST["pulldownRep"]);
    $pulldownKilo = floatval($_POST["pulldownKilo"]);
    
    
    if ($workoutDates) {
        $mysqli->begin_transaction();

       

    $sql = "INSERT INTO workout (workoutDates, cykelTid, cykelBelastning, pulldownRep, pulldownKilo) VALUES (?,?,?,?,?)";

    $stmt = $mysqli->prepare($sql);

    if ($stmt === false) {
        die("Error: " . $mysqli->error);
    }

    $stmt->bind_param("ssssd", $workoutDates, $cykelTid, $cykelBelastning, $pulldownRep, $pulldownKilo);
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
                <input type="number" id="pulldownKilo" name="pulldownKilo">



                
    
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