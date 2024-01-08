<?php 
include 'header.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $painDates = htmlspecialchars($_POST["dato"]);
    $painState = htmlspecialchars($_POST["painState"]);
    $painLevel = htmlspecialchars($_POST["painLevel"]);
    $painType = htmlspecialchars($_POST["painType"]);
    $painNotes = htmlspecialchars($_POST["painNotes"]);
    
    if ($painDates && $painState && $painLevel !== null && $painType && $painNotes) {
        $mysqli->begin_transaction();


    $sql = "INSERT INTO pain (painDates, painState, painLevel, painType, painNotes) VALUES (?,?,?,?,?)";

    $stmt = $mysqli->prepare($sql);

    if ($stmt === false) {
        die("Error: " . $mysqli->error);
    }

    $stmt->bind_param("sssss", $painDates, $painState, $painLevel, $painType, $painNotes);
    $stmt->execute();

    // Commit the transaction if the first statement executed successfully
    $mysqli->commit();

    // Close the statement
    $stmt->close();
    
    // Close the database connection
    $mysqli->close();
}}
?>


<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>H E A R T B E A T || Pain </title>
    </head>
    <body>

    <?php
        // Viser success eller fejl meddelelse
        if (isset($_SESSION["message"])) {
        echo "<p>{$_SESSION["message"]}</p>";
        unset($_SESSION["message"]);
        } 
    ?>

        <div class="painWrapper">
            <form class="painForm" action="" method="POST">
                <h2>Hovedpine form</h2>

                <label for="painDates">Dato</label>
                <input type="date" id="painDates" name="dato">

                <p> har du hovedpine?</p>
                <input type="radio" id="painState_ja" name="painState" value="Ja">
                <label for="painState_ja">Ja</label> 
                <input type="radio" id="painState_nej" name="painState" value="Nej">
                <label for="painState_nej">Nej</label>


                <label for="painLevel">Sværhedsgrad</label>
                <input type="number" id="painLevel" name="painLevel">

                <label for="painType">Type</label>
                <input type="text" id="painType" name="painType">

                <label for="painNotes">Bemærkning</label>
                <input type="text" id="painNotes" name="painNotes">
    
                <button class="submit">save</button>
            </form>
        </div>
        

    </body>
</html>