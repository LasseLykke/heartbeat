<?php
ob_start();
session_start();
include 'header.php';

if (isset($_SESSION['user_id']) && isset($_SESSION['user_name'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $painDates = htmlspecialchars($_POST["dato"]);
        // Sanitize input and set default values if fields are empty
        $dailyJob = isset($_POST["dailyJob"]) ? htmlspecialchars($_POST["dailyJob"]) : '';
        $dailyAktivitet = isset($_POST["dailyAktivitet"]) ? htmlspecialchars($_POST["dailyAktivitet"]) : '';
        $dailyAktivitetNotes = isset($_POST["dailyAktivitetNotes"]) ? htmlspecialchars($_POST["dailyAktivitetNotes"]) : '';
        $painState = isset($_POST["painState"]) ? htmlspecialchars($_POST["painState"]) : '';
        $painLevel = isset($_POST["painLevel"]) ? htmlspecialchars($_POST["painLevel"]) : '';
        $painType = isset($_POST["painType"]) ? htmlspecialchars($_POST["painType"]) : '';
        $painKillers = isset($_POST["painKillers"]) ? htmlspecialchars($_POST["painKillers"]) : '';
        $painDuration = isset($_POST["painDuration"]) ? htmlspecialchars($_POST["painDuration"]) : '';
        $painWorkout = isset($_POST["painWorkout"]) ? htmlspecialchars($_POST["painWorkout"]) : '';
        $painNotes = isset($_POST["painNotes"]) ? htmlspecialchars($_POST["painNotes"]) : '';

        
        
            // Begin a database transaction
            $mysqli->begin_transaction();
            
            $sql1 = "INSERT INTO daily (dailyJob, dailyAktivitet, dailyAktivitetNotes) VALUES (?,?,?)";
            $sql2 = "INSERT INTO pain (painDates, painState, painLevel, painType, painKillers, painDuration, painWorkout, painNotes) VALUES (?,?,?,?,?,?,?,?)";
            
            $stmt1 = $mysqli->prepare($sql1);
            $stmt2 = $mysqli->prepare($sql2);
            
            if ($stmt1 === false || $stmt2 === false) {
                die("Error: " . $mysqli->error);
            }
            
            $stmt1->bind_param("sss", $dailyJob, $dailyAktivitet, $dailyAktivitetNotes);
            $stmt2->bind_param("ssssssss", $painDates, $painState, $painLevel, $painType, $painKillers, $painDuration, $painWorkout, $painNotes);
            
            // Execute the statements
            $stmt1->execute();
            $stmt2->execute();
            
            // Commit the transaction if both statements executed successfully
            $mysqli->commit();
            
            // Close the statements
            $stmt1->close();
            $stmt2->close();
            
            // Close the database connection
            $mysqli->close();
            
            // Redirect to success page
            header("Location: success.php");
            exit(); 
       
    
}
ob_end_flush();
?>


<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- Logger ud efter 15min -->
        <meta http-equiv="refresh" content="1500;url=logout.php" />
        <title>H E A R T B E A T || DAILY </title>
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
            <form class="painForm" action="" method="POST">
                <h1>Daily:</h1>
                
                <!-- DATO -->
                <div class="painDate">
                    <h3>Dato:</h3>
                <label for="painDates"></label>
                <input type="date" id="painDates" name="dato" required>
                </div>

                <!-- JOB -->
                <div class="dailyJob">
                <h3>Været på Job?</h3><br>
                <input type="radio" id="dailyJob_ja" name="dailyJob" value="Ja" required checked>
                <label for="dailyJob_ja">Ja</label> 
                <input type="radio" id="dailyJob_nej" name="dailyJob" value="Nej" required>
                <label for="dailyJob_nej">Nej</label>
                </div>

                <!-- AKTIVITETSNIVEAU -->
                <div class="dailyAktivitet">
                <h3>Aktivitets niveau:</h3><br>
                <input type="radio" id="0" name="dailyAktivitet" value="0" checked>
                <label for="0">0</label>
                <input type="radio" id="1" name="dailyAktivitet" value="1">
                <label for="1">1</label>
                <input type="radio" id="2" name="dailyAktivitet" value="2">
                <label for="2">2</label>
                <input type="radio" id="3" name="dailyAktivitet" value="3">
                <label for="3">3</label>
                <input type="radio" id="4" name="dailyAktivitet" value="4">
                <label for="4">4</label>
                <input type="radio" id="5" name="dailyAktivitet" value="5">
                <label for="5">5</label>
                </div>
                
                <!-- AKTIVITETS NOTE -->
                <div class="dailyAktivitetNotes">
                    <h3>Bemærkning:</h3>
                <label for="dailyAktivitetNotes"></label>
                <textarea id="dailyAktivitetNotes" placeholder="Indsæt bemærkning" name="dailyAktivitetNotes"></textarea>
                </div>


                <!-- HAFT HOVEDPINE -->
                <div class="painState">
                <h3>Haft hovedpine?</h3><br>
                <input type="radio" id="painState_ja" name="painState" value="Ja" required>
                <label for="painState_ja">Ja</label> 
                <input type="radio" id="painState_nej" name="painState" value="Nej" required>
                <label for="painState_nej">Nej</label>
                </div>

                <!-- SVÆRHEDSGRAD -->
                <div class="painLevel">
                <h3>Sværhedsgrad:</h3><br>
                <input type="radio" id="0" name="painLevel" value="0" checked>
                <label for="0">0</label>
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
                <h3>Type:</h3><br>
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
                <h3>Ekstra medicin:</h3><br>
                <input type="radio" id="0" name="painKillers" value="0" checked required>
                <label for="0">0</label>
                <input type="radio" id="1" name="painKillers" value="1" required>
                <label for="1">1</label>
                <input type="radio" id="2" name="painKillers" value="2" required>
                <label for="2">2</label>
                <input type="radio" id="3" name="painKillers" value="3" required>
                <label for="3">3</label>
                </div>

                <div class="painDuration">
                    <h3>Varighed:</h3>
                    <label for="painDuration"></label>
                    <input type="number" id="painDuration" name="painDuration" placeholder="Angiv i timer">
                </div>

                <!-- TRÆNET DAGEN FØR? -->
                <div class="painWorkout">
                <h3>Trænet dagen før?</h3><br>
                <input type="radio" id="painWorkout_ja" name="painWorkout" value="Ja" required>
                <label for="painState_ja">Ja</label> 
                <input type="radio" id="painWorkout_nej" name="painWorkout" value="Nej" checked required>
                <label for="painWorkout_nej">Nej</label>
                </div>

                <!-- BEMÆRKNING -->
                <div class="painNotes">
                    <h3>Bemærkning:</h3>
                <label for="painNotes"></label>
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