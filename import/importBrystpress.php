<?php
ob_start();
session_start();


include '../header.php';
require '../navbar.php';

if (isset($_SESSION['user_id']) && isset($_SESSION['user_name'])) {

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Hent og rens input
        $workoutDate = htmlspecialchars($_POST["dato"]);
        $brystpressRep = isset($_POST["brystpressRep"]) ? intval($_POST["brystpressRep"]) : 0;
        $brystpressKilo = isset($_POST["brystpressKilo"]) ? str_replace(',', '.', $_POST["brystpressKilo"]) : 0.0;
        $brystpressKilo = floatval($brystpressKilo);
        $brystpressKilo = number_format($brystpressKilo, 1);



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
            $sql = "INSERT INTO woBrystpress (sessionID, brystpressRep, brystpressKilo) VALUES (?, ?, ?)";
            $stmt = $mysqli->prepare($sql);

            if ($stmt === false) {
                throw new Exception($mysqli->error);
            }

            $stmt->bind_param("iid", $sessionID, $brystpressRep, $brystpressKilo);
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
    <title>H E A R T B E A T || Brystpres </title>
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
            <h1 class="headerText">Brystpres</h1>
        </section>

        <section class="lastStats">
            <?php
            // Funktion til at hente de sidste data for en given øvelse
            function getLastExerciseData($conn, $woBrystpress)
            {
                $sql = "SELECT 
                brystpressRep, 
                brystpressKilo, 
                sessionDate
            FROM 
                $woBrystpress
            JOIN 
                workoutSession ON $woBrystpress.sessionID = workoutSession.sessionID
            WHERE 
                brystpressID = (SELECT MAX(brystpressID) FROM $woBrystpress WHERE sessionID = workoutSession.sessionID)
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
            $woBrystpress = "woBrystpress"; // Skift dette til andre tabeller som "triceps", "legs" osv.
            $data = getLastExerciseData($conn, $woBrystpress);

            if ($data) {
                // Formatér datoen som DD/MM/YYYY
                $formattedDate = date('d/m/Y', strtotime($data['sessionDate']));
                echo "<p>Last Session</p>";
                echo "<p>{$formattedDate}</p>";
                echo "<p>{$data['brystpressRep']} Rep | {$data['brystpressKilo']} Kilo</p>";
            } else {
                echo "<p>Ingen data fundet for $woBrystpress.</p>";
            }
            ?>
        </section>


        <form class="workoutForm" action="" method="POST">

            <section class="workoutlabel">
                <label for="brystpressRep"></label>
                <input type="number" id="brystpressRep" name="brystpressRep" placeholder="Rep:" required>

                <label for="brystpressKilo"></label>
                <input type="text" id="brystpressKilo" name="brystpressKilo" placeholder="Kilo:" required>

            </section>

            <section>
                <button class="submit">Gem</button>
            </section>
    </div>


    <script src="../script.js"></script>
</body>

</html>