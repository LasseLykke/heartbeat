<?php
ob_start();
session_start();

include '../header.php';
require '../navbar.php';

if (isset($_SESSION['user_id']) && isset($_SESSION['user_name'])) {

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Hent og rens input
        $workoutDate = htmlspecialchars($_POST["dato"]);
        $varighed = isset($_POST["varighed"]) ? htmlspecialchars($_POST["varighed"]) : 0;

        // Hvis workoutDate er tom, brug den aktuelle dato
        if (empty($workoutDate)) {
            $workoutDate = date('Y-m-d'); // Brug kun dato (YYYY-MM-DD)
        }

        // Konverter varighed (minutter) til TIME-format (HH:MM:SS)
        $hours = floor($varighed / 60);
        $minutes = $varighed % 60;
        $timeFormatted = sprintf('%02d:%02d:00', $hours, $minutes);

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
            $sql = "INSERT INTO woVarighed (sessionID, varighed) VALUES (?, ?)";
            $stmt = $mysqli->prepare($sql);

            if ($stmt === false) {
                throw new Exception($mysqli->error);
            }

            $stmt->bind_param("is", $sessionID, $timeFormatted);
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
    <title>H E A R T B E A T || Varighed </title>
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
            <h1 class="headerText">Varighed</h1>
        </section>
        <form class="workoutForm" action="" method="POST">

            <section class="workoutlabel">
                <label for="varighed"></label>
                <input type="number" id="varighed" name="varighed" placeholder="Tid i minutter:" required>
            </section>

            <section>
                <button class="submit">Gem</button>
            </section>
    </div>


    <script src="../script.js"></script>
</body>

</html>