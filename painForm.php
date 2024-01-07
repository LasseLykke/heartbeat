<?php 
include 'header.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dates = $_POST["dato"];
    $painState = $_POST["painState"];
    $painLevel = $_POST["painLevel"];
    $painType = $_POST["painType"];
    $bemærkning = $_POST["bemærkning"];

    $mysqli->begin_transaction();

    $sql = "INSERT INTO pain (dates, painState, painLevel, painType, bemærkning) VALUES (?,?,?,?,?)";

    $stmt = $mysqli->prepare($sql);

    if ($stmt === false) {
        die("Error: " . $mysqli->error);
    }

    $stmt->bind_param("ssiss", $dates, $painState, $painLevel, $paintType, $bemærkning);
    $stmt->execute();

    // Commit the transaction if the first statement executed successfully
    $mysqli->commit();

    // Close the statement
    $stmt->close();
    
    // Close the database connection
    $mysqli->close();
}
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

                <label for="dates">Dato</label>
                <input type="date" id="dato" name="dato">

                <p> har du hovedpine?</p>
                <input type="radio" id="painState_ja" name="painState" value="Ja">
                <label for="pain_ja">Ja</label> 
                <input type="radio" id="painState_nej" name="painState" value="Nej">
                <label for="pain_nej">Nej</label>


                <label for="painLevel">Sværhedsgrad</label>
                <input type="number" id="painLevel" name="painLevel">

                <label for="painType">Type</label>
                <input type="text" id="painType" name="painType">

                <label for="bemærkning">Bemærkning</label>
                <input type="text" id="bemærkning" name="bemærkning">

                <button class="submit">save</button>
            </form>
        </div>
        

    </body>
</html>