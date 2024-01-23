<?php 
session_start();

if (isset($_SESSION['user_id']) && isset($_SESSION['user_name'])) {
include 'header.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $painDates = htmlspecialchars($_POST["dato"]);
    $painState = htmlspecialchars($_POST["painState"]);
    $painLevel = htmlspecialchars($_POST["painLevel"]);
    $painType = htmlspecialchars($_POST["painType"]);
    $painKillers = htmlspecialchars($_POST["painKillers"]);
    $painNotes = htmlspecialchars($_POST["painNotes"]);
    
    if ($painDates && $painState && $painLevel !== null || $painType && $painKillers && $painNotes) 
        {
        $mysqli->begin_transaction();


    $sql = "INSERT INTO pain (painDates, painState, painLevel, painType, painKillers, painNotes) VALUES (?,?,?,?,?,?)";

    $stmt = $mysqli->prepare($sql);

    if ($stmt === false) {
        die("Error: " . $mysqli->error);
    }

    $stmt->bind_param("ssssss", $painDates, $painState, $painLevel, $painType, $painKillers, $painNotes);
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
                <h1>Hovedpine form</h1>
                
                <!-- DATO -->
                <div class="painDate">
                <label for="painDates">Dato</label>
                <input type="date" id="painDates" name="dato">
                </div>

                <!-- HAFT HOVEDPINE -->
                <div class="painState">
                <h3> Har du haft hovedpine?</h3>
                <input type="radio" id="painState_ja" name="painState" value="Ja">
                <label for="painState_ja">Ja</label> 
                <input type="radio" id="painState_nej" name="painState" value="Nej">
                <label for="painState_nej">Nej</label>
                </div>

                <!-- SVÆRHEDSGRAD -->
                <div class="painLevel">
                <h3>Sværhedsgrad</h3>
                <input type="radio" id="1" name="painLevel" value="1">
                <label for="1">1</label>
                <input type="radio" id="2" name="painLevel" value="2">
                <label for="2">2</label>
                <input type="radio" id="3" name="painLevel" value="3">
                <label for="3">3</label>
                <input type="radio" id="4" name="painLevel" value="4">
                <label for="4">4</label>
                <input type="radio" id="5" name="painLevel" value="5">
                <label for="5">5</label>
                </div>



                <!-- Pain type -->
                <div class="painType">
                <h3>Hovedpine type</h3>
                <input type="radio" id="spænding" name="painType" value="Spænding">
                <label for="spænding">Spændingshovedpine</label><br>
                <input type="radio" id="migræne" name="painType" value="Migræne">
                <label for="migræne">Migræne</label><br>
                <input type="radio" id="sygdom" name="painType" value="Sygdom">
                <label for="sygdom">Sygdom</label><br>
                <input type="radio" id="andet" name="painType" value="Andet">
                <label for="andet">Andet</label><br>
                </div>

                <!-- EKSTRA MEDICIN -->
                <div class="painKillers">
                <h3>Ekstra medicin</h3>
                <input type="radio" id="0" name="painKillers" value="0">
                <label for="0">0</label>
                <input type="radio" id="1" name="painKillers" value="1">
                <label for="1">1</label>
                <input type="radio" id="2" name="painKillers" value="2">
                <label for="2">2</label>
                <input type="radio" id="3" name="painKillers" value="3">
                <label for="3">3</label>
                </div>

                <!-- BEMÆRKNING -->
                <div class="painNotes">
                <label for="painNotes">Bemærkning</label>
                <textarea id="painNotes" placeholder="Indsæt bemærkning" name="painNotes"></textarea>
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