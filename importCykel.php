<?php
ob_start();
session_start();

include 'header.php';


if (isset($_SESSION['user_id']) && isset($_SESSION['user_name'])) {

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Hent og rens input
        $workoutDate = htmlspecialchars($_POST["dato"]);
        $cykelTid = isset($_POST["cykelTid"]) ? intval($_POST["cykelTid"]) : 0;
        $cykelBelastning = isset($_POST["cykelBelastning"]) ? intval($_POST["cykelBelastning"]) : 0;

        // Hvis workoutDate er tom, brug den aktuelle dato
        if (empty($workoutDate)) {
            $workoutDate = date('Y-m-d'); // Brug kun dato (YYYY-MM-DD)
        }

        // Start en transaktion
        $mysqli->begin_transaction();

        try {
            // Først indsæt i workoutSession for at få sessionID
            $sql = "INSERT INTO workoutSession (sessionDate) VALUES (?)";
            $stmt = $mysqli->prepare($sql);

            if ($stmt === false) {
                throw new Exception($mysqli->error);
            }

            $stmt->bind_param("s", $workoutDate);
            $stmt->execute();

            // Hent det genererede sessionID
            $sessionID = $stmt->insert_id;

            // Luk statement for workoutSession
            $stmt->close();

            // Indsæt i woCykel med det hentede sessionID som FK
            $sql = "INSERT INTO woCykel (sessionID, cykelTid, cykelBelastning) VALUES (?, ?, ?)";
            $stmt = $mysqli->prepare($sql);

            if ($stmt === false) {
                throw new Exception($mysqli->error);
            }

            $stmt->bind_param("iii", $sessionID, $cykelTid, $cykelBelastning);
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
    <!-- Logger ud efter halvanden time -->
    <meta http-equiv="refresh" content="5400;url=logout.php" />
    <title>H E A R T B E A T || Cykling </title>
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
    <form class="træningsForm" action="" method="POST">
        <h1>Trænings log</h1>

        <!-- DATE -->
        <div class="workoutDate">
            <h3>Dato:</h3>
            <label for="workoutDates"></label>
            <input type="date" id="workoutDates" name="dato">
        </div>

        <!-- CYKEL -->
        <div class="workoutCykel">
            <h3>Cykling:</h3>
            <label for="cykelTid"></label>
            <input type="number" id="cykelTid" name="cykelTid" placeholder="Tid:">

            <label for="cykelBelastning"></label>
            <input type="number" id="cykelBelastning" name="cykelBelastning" placeholder="Belastning">
        </div>

        <button class="submit">Gem</button>
    </form>
</div>

</body>
</html>
