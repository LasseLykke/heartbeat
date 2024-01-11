<?php 
session_start();

if (isset($_SESSION['user_id']) && isset($_SESSION['user_name'])) {
include 'header.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $painDates = htmlspecialchars($_POST["dato"]);
    
    
    if ($painDates) {
        $mysqli->begin_transaction();


    $sql = "INSERT INTO pain (painDates,) VALUES (?,)";

    $stmt = $mysqli->prepare($sql);

    if ($stmt === false) {
        die("Error: " . $mysqli->error);
    }

    $stmt->bind_param("s", $painDates);
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

                <label for="painDates">Dato</label>
                <input type="date" id="painDates" name="dato">

                
    
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