<?php
ob_start();
session_start();

include 'header.php';

if (isset($_SESSION['user_id']) && isset($_SESSION['user_name'])) {

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Hent og rens input
        $painDate = htmlspecialchars($_POST["dato"]);
        $notes = htmlspecialchars($_POST["notes"]);
        $mentalState = isset($_POST["mentalState"]) ? intval($_POST["mentalState"]) : 0;
        $atWork = isset($_POST["atWork"]) ? 1 : 0;

        // Hovedpine
        $hasHeadache = isset($_POST["hasHeadache"]) ? 1 : 0;
        $headacheLevel = isset($_POST["headacheLevel"]) ? intval($_POST["headacheLevel"]) : 0;
        $headacheType = isset($_POST["headacheType"]) ? $_POST["headacheType"] : '';
        $headacheDuration = isset($_POST["headacheDuration"]) ? intval($_POST["headacheDuration"]) : 0;

        // Kropssmerter
        $bodyPainLevel = isset($_POST["bodyPainLevel"]) ? intval($_POST["bodyPainLevel"]) : 0;
        $bodyPart = htmlspecialchars($_POST["bodyPart"]);

        // Medicin
        $tookMedication = isset($_POST["tookMedication"]) ? 1 : 0;
        $medicationAmount = isset($_POST["medicationAmount"]) ? intval($_POST["medicationAmount"]) : 0;

        // Hvis painDate er tom, brug den aktuelle dato
        if (empty($painDate)) {
            $painDate = date('Y-m-d'); // Brug kun dato (YYYY-MM-DD)
        }

        // Start en transaktion
        $mysqli->begin_transaction();

        try {
            // Først indsæt i painSession for at få sessionID
            $sql = "INSERT INTO painSession (sessionDate, notes, mentalState, atWork) VALUES (?, ?, ?, ?)";
            $stmt = $mysqli->prepare($sql);

            if ($stmt === false) {
                throw new Exception($mysqli->error);
            }

            $stmt->bind_param("sssi", $painDate, $notes, $mentalState, $atWork);
            $stmt->execute();

            // Hent det genererede sessionID
            $sessionID = $stmt->insert_id;

            // Luk statement for painSession
            $stmt->close();

            // Indsæt i headacheLog
            $sql = "INSERT INTO headacheLog (sessionID, hasHeadache, headacheLevel, headacheType, headacheDuration) VALUES (?, ?, ?, ?, ?)";
            $stmt = $mysqli->prepare($sql);

            if ($stmt === false) {
                throw new Exception($mysqli->error);
            }

            $stmt->bind_param("iiisi", $sessionID, $hasHeadache, $headacheLevel, $headacheType, $headacheDuration);
            $stmt->execute();
            $stmt->close();

            // Indsæt i bodyPainLog
            $sql = "INSERT INTO bodyPainLog (sessionID, bodyPart, painLevel) VALUES (?, ?, ?)";
            $stmt = $mysqli->prepare($sql);

            if ($stmt === false) {
                throw new Exception($mysqli->error);
            }

            $stmt->bind_param("isi", $sessionID, $bodyPart, $bodyPainLevel);
            $stmt->execute();
            $stmt->close();

            // Indsæt i medicationLog
            $sql = "INSERT INTO medicationLog (sessionID, tookMedication, medicationAmount) VALUES (?, ?, ?)";
            $stmt = $mysqli->prepare($sql);

            if ($stmt === false) {
                throw new Exception($mysqli->error);
            }

            $stmt->bind_param("iii", $sessionID, $tookMedication, $medicationAmount);
            $stmt->execute();

            // Commit transaktionen
            $mysqli->commit();

            // Luk statement og databaseforbindelse
            $stmt->close();
            $mysqli->close();

            // Gå tilbage til bekræftelsessiden
            header("Location: success.php");
            exit();
        } catch (Exception $e) {
            // Rul tilbage ved fejl
            $mysqli->rollback();
            die("Error: " . $e->getMessage());
        }
    }
} else {
    // Hvis brugeren ikke er logget ind, send dem tilbage til login siden
    header("Location: index.php");
    exit();
}
ob_end_flush();
?>

<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="1500;url=logout.php" />
    <title>Daglig Logging</title>
</head>

<body>

    <?php
    if (isset($_SESSION["message"])) {
        echo "<p>{$_SESSION["message"]}</p>";
        unset($_SESSION["message"]);
    }
    ?>

    <header>
        <button class="hamburger">
            <div class="bar"></div>
        </button>

        <nav class="mobile-nav">
            <a href="forside.php">Forside</a>
            <a href="dataOverview.php">Statistik</a>
            <a href="logout.php">Log ud</a>
        </nav>
    </header>

    <div class="wrapper">
        <section class="hbHeader">
            <h1 class="headerText">Daily</h1>
        </section>
        <form class="dailyForm" action="" method="POST">

            <section class="dailyFormSubPain">
                <div class="hasHeadache">
                    <label for="hasHeadache">Har du haft hovedpine?</label>
                    <div class="headacheOptions">
                        <div>
                            <input type="radio" id="hasHeadacheYes" name="hasHeadache" value="1">
                            <label for="hasHeadacheYes">Ja</label>
                        </div>
                        <div>
                            <input type="radio" id="hasHeadacheNo" name="hasHeadache" value="0" checked>
                            <label for="hasHeadacheNo">Nej</label>
                        </div>
                    </div>
                </div>

                <div class="headacheLevel">
                    <label for="headacheLevel">Sværhedsgrad:</label>
                    <div class="headacheLevelOptions">
                        <div>
                            <input type="radio" id="level1" name="headacheLevel" value="1">
                            <label for="level1">1</label>
                        </div>
                        <div>
                            <input type="radio" id="level2" name="headacheLevel" value="2">
                            <label for="level2">2</label>
                        </div>
                        <div>
                            <input type="radio" id="level3" name="headacheLevel" value="3">
                            <label for="level3">3</label>
                        </div>
                        <div>
                            <input type="radio" id="level4" name="headacheLevel" value="4">
                            <label for="level4">4</label>
                        </div>
                        <div>
                            <input type="radio" id="level5" name="headacheLevel" value="5">
                            <label for="level5">5</label>
                        </div>
                    </div>
                </div>

                <div class="headacheType">
                    <label for="headacheType">Type:</label>
                    <select id="headacheType" name="headacheType">
                        <option value="" disabled selected>Vælg type</option>
                        <option value="Spændings">Spændings</option>
                        <option value="Migræne">Migræne</option>
                        <option value="Sygdom">Sygdom</option>
                        <option value="Andet">Andet</option>
                    </select>
                </div>

                <div class="headacheDuration">
                    <label for="headacheDuration"></label>
                    <input type="number" id="headacheDuration" name="headacheDuration"
                        placeholder="Varighed i minutter">
                </div>
            </section>



            <section class="dailyFormSubBodyPain">
                <div class="bodyPart">
                    <label for="bodyPart">Smerter i kroppen?</label>
                    <input type="text" id="bodyPart" name="bodyPart" placeholder="Hvilken Kropsdel">
                </div>

                <div class="bodyPainLevel">
                    <label for="bodyPainLevel">Sværhedsgrad af smerte:</label>
                    <div class="bodyPainLevelOptions">
                        <div>
                            <input type="radio" id="painLevel1" name="bodyPainLevel" value="1">
                            <label for="painLevel1">1</label>
                        </div>
                        <div>
                            <input type="radio" id="painLevel2" name="bodyPainLevel" value="2">
                            <label for="painLevel2">2</label>
                        </div>
                        <div>
                            <input type="radio" id="painLevel3" name="bodyPainLevel" value="3">
                            <label for="painLevel3">3</label>
                        </div>
                        <div>
                            <input type="radio" id="painLevel4" name="bodyPainLevel" value="4">
                            <label for="painLevel4">4</label>
                        </div>
                        <div>
                            <input type="radio" id="painLevel5" name="bodyPainLevel" value="5">
                            <label for="painLevel5">5</label>
                        </div>
                    </div>
                </div>
            </section>



            <section class="dailyFormSubMedication">
                <div class="tookMedication">
                    <label for="tookMedication">Har du taget ekstra medicin?</label>
                    <input type="checkbox" id="tookMedication" name="tookMedication">
                </div>

                <div class="medicationAmount">
                    <label for="medicationAmount">Antal:</label>
                    <input type="number" id="medicationAmount" name="medicationAmount" placeholder="Antal piller">
                </div>
            </section>



            <section class="dailyFormSubMentalState">
                <div class="atWork">
                    <label for="atWork">Været på arbejde?</label>
                    <input type="checkbox" id="atWork" name="atWork">
                </div>

                <div class="notes">
                    <label for="notes">Bemærkninger:</label>
                    <input type="text" id="notes" name="notes" placeholder="Bemærkninger">
                </div>

                <div class="mentalState">
                    <label for="mentalState">Mental tilstand:</label>
                    <div class="mentalStateOptions">
                        <div>
                            <input type="radio" id="mentalStateNeg3" name="mentalState" value="-3">
                            <label for="mentalStateNeg3">-3</label>
                        </div>
                        <div>
                            <input type="radio" id="mentalStateNeg2" name="mentalState" value="-2">
                            <label for="mentalStateNeg2">-2</label>
                        </div>
                        <div>
                            <input type="radio" id="mentalStateNeg1" name="mentalState" value="-1">
                            <label for="mentalStateNeg1">-1</label>
                        </div>
                        <div>
                            <input type="radio" id="mentalState0" name="mentalState" value="0">
                            <label for="mentalState0">0</label>
                        </div>
                        <div>
                            <input type="radio" id="mentalStatePos1" name="mentalState" value="1">
                            <label for="mentalStatePos1">1</label>
                        </div>
                        <div>
                            <input type="radio" id="mentalStatePos2" name="mentalState" value="2">
                            <label for="mentalStatePos2">2</label>
                        </div>
                        <div>
                            <input type="radio" id="mentalStatePos3" name="mentalState" value="3">
                            <label for="mentalStatePos3">3</label>
                        </div>
                    </div>
                </div>
            </section>

            <section class="dailyFormSubmit">
                <button class="submit">Gem</button>
            </section>

        </form>
    </div>

    <script src="script.js"></script>
</body>

</html>