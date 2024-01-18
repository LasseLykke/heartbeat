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
    
    if ($painDates && $painState && $painLevel !== null && $painType && $painKillers && $painNotes) {
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


                /* Pain type*/
                <input type="radio" id="8001" name="passepartoutFarve" value="8001">
                <label for="profil_8001">Hvidt med hvid kerne</label><br>
                <input type="radio" id="8213" name="passepartoutFarve" value="8213">
                <label for="profil_8213">Knækket hvid med hvid kerne</label><br>
                <input type="radio" id="profil_8011" name="passepartoutFarve" value="8011">
                <label for="profil_8011">Sort med hvid kerne</label><br>
                <input type="radio" id="7011" name="passepartoutFarve" value="7011">
                <label for="profil_7011">Sort med sort kerne</label><br>

                <p>Piller</p>
                <input type="radio" id="painKillers_ja" name="painKillers" value="Ja">
                <label for="painKillers_ja">Ja</label> 
                <input type="radio" id="painKillers_nej" name="painKillers" value="Nej">
                <label for="painKillers_nej">Nej</label>

                <label for="painNotes">Bemærkning</label>
                <textarea id="painNotes" placeholder="Indsæt bemærkning" name="painNotes"></textarea>
    
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