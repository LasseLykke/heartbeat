<?php
ob_start();
session_start();

include '../header.php';
require '../navbar.php';

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

        // Konverter cykelTid (minutter) til TIME-format (HH:MM:SS)
        $hours = floor($cykelTid / 60);
        $minutes = $cykelTid % 60;
        $cykelTidFormatted = sprintf('%02d:%02d:00', $hours, $minutes);

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

            $stmt->bind_param("isi", $sessionID, $cykelTidFormatted, $cykelBelastning);
            $stmt->execute();

            // Commit transaktionen
            $mysqli->commit();

            // Luk statement og databaseforbindelse
            $stmt->close();
            $mysqli->close();

            // Gå tilbage til bekræftelsessiden
            header("Location: /successWorkout.php");
            exit();
        } catch (Exception $e) {
            // Rul tilbage ved fejl
            $mysqli->rollback();
            die("Error: " . $e->getMessage());
        }


    }
} else {
    // Hvis brugeren ikke er logget ind, send dem tilbage til login siden
    header("Location: /index.php");
    exit();
}
ob_end_flush();
?>

<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Logger ud efter halvanden time -->
    <meta http-equiv="refresh" content="5400;url=../logout.php" />
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

    <div class="wrapper">
        <section class="hbHeader">
            <h1 class="headerText">Cykling</h1>
        </section>

        <section class="lastStats">
            <?php
            // Funktion til at hente de sidste data for en given øvelse
            function getLastExerciseData($conn, $woCykel)
            {
                $sql = "SELECT 
                cykelTid, 
                cykelBelastning, 
                sessionDate
            FROM 
                $woCykel
            JOIN 
                workoutSession ON $woCykel.sessionID = workoutSession.sessionID
            WHERE 
                cykelID = (SELECT MAX(cykelID) FROM $woCykel WHERE sessionID = workoutSession.sessionID)
            ORDER BY 
                sessionDate DESC
            LIMIT 1;";

                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    return $result->fetch_assoc();
                } else {
                    return null;
                }
            }

            // Eksempel på at hente data for en øvelse
            $woCykel = "woCykel"; // Skift dette til andre tabeller som "triceps", "legs" osv.
            $data = getLastExerciseData($conn, $woCykel);

            if ($data) {
                // Formatér datoen som DD/MM/YYYY
                $formattedDate = date('d/m/Y', strtotime($data['sessionDate']));
                echo "<p>Last Session</p>";
                echo "<p>{$formattedDate}</p>";
                echo "<p>{$data['cykelTid']} Min | {$data['cykelBelastning']} Kilo</p>";
            } else {
                echo "<p>Ingen data fundet for $woCykel.</p>";
            }
            ?>
        </section>


        <form class="workoutForm" action="" method="POST">

            <section class="workoutlabel">
                <label for="cykelTid"></label>
                <input type="text" id="cykelTid" name="cykelTid" placeholder="Tid:" required>

                <label for="cykelBelastning"></label>
                <input type="text" id="cykelBelastning" name="cykelBelastning" placeholder="Belastning:" required>
            </section>

            <section>
                <button class="submit">Gem</button>
            </section>
    </div>


    <script src="../script.js"></script>
</body>

</html>