<?php
ob_start();
session_start();

include 'header.php';

if (isset($_SESSION['user_id']) && isset($_SESSION['user_name'])) {

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Hent og rens input
        $workoutDate = htmlspecialchars($_POST["dato"]);
        $legcurlRep = isset($_POST["legcurlRep"]) ? intval($_POST["legcurlRep"]) : 0;
        $legcurlKilo = isset($_POST["legcurlKilo"]) ? str_replace(',', '.', $_POST["legcurlKilo"]) : 0.0;
        $legcurlKilo = floatval($legcurlKilo);
        $legcurlKilo = number_format($legcurlKilo, 1);

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
            $sql = "INSERT INTO woLegcurl (sessionID, legcurlRep, legcurlKilo) VALUES (?, ?, ?)";
            $stmt = $mysqli->prepare($sql);

            if ($stmt === false) {
                throw new Exception($mysqli->error);
            }

            $stmt->bind_param("iii", $sessionID, $legcurlRep, $legcurlKilo);
            $stmt->execute();

            // Commit transaktionen
            $mysqli->commit();

            // Luk statement og databaseforbindelse
            $stmt->close();
            $mysqli->close();

            // Gå tilbage til bekræftelsessiden
            header("Location: successWorkout.php");
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
    <title>H E A R T B E A T || Legcurl </title>
</head>
<body>

<?php
    // Viser success eller fejl meddelelse
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
            <a href="dataOverview.php">Statestik</a>
            <a href="workoutforms.php">Workout Forms</a>
            <a href="logout.php">Log ud</a>
        </nav>
    </header>

    <div class="wrapper">
        <section class="hbHeader">
                <h1 class="headerText">Legcurl</h1>
            </section>
            <form class="workoutForm" action="" method="POST">

            <section class="workoutlabel">
                <label for="legcurlRep"></label>
                <input type="number" id="legcurlRep" name="legcurlRep" placeholder="Rep:" required>

                <label for="legcurlKilo"></label>
                <input type="number" id="legcurlKilo" name="legcurlKilo" placeholder="Kilo:"required>
            </section>

            <section>
                <button class="submit">Gem</button>
            </section>
    </div>


<script src="script.js"></script>
</body>
</html>
