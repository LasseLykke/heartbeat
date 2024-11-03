<?php
ob_start();
session_start();

include '../header.php';
require '../navbar.php';

if (isset($_SESSION['user_id']) && isset($_SESSION['user_name'])) {

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Hent og rens input
        $workoutDate = htmlspecialchars($_POST["dato"]);
        $legpressRep = isset($_POST["legpressRep"]) ? intval($_POST["legpressRep"]) : 0;
        $legpressKilo = isset($_POST["legpressKilo"]) ? str_replace(',', '.', $_POST["legpressKilo"]) : 0.0;
        $legpressKilo = floatval($legpressKilo);
        $legpressKilo = number_format($legpressKilo, 1);

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
            $sql = "INSERT INTO woLegpress (sessionID, legpressRep, legpressKilo) VALUES (?, ?, ?)";
            $stmt = $mysqli->prepare($sql);

            if ($stmt === false) {
                throw new Exception($mysqli->error);
            }

            $stmt->bind_param("iid", $sessionID, $legpressRep, $legpressKilo);
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
    <title>H E A R T B E A T || Legpress </title>
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
            <h1 class="headerText">Legpress</h1>
        </section>
        <form class="workoutForm" action="" method="POST">

            <section class="workoutlabel">
                <label for="legpressRep"></label>
                <input type="number" id="legpressRep" name="legpressRep" placeholder="Rep:" required>

                <label for="legpressKilo"></label>
                <input type="text" id="legpressKilo" name="legpressKilo" placeholder="Kilo:" required>
            </section>

            <section>
                <button class="submit">Gem</button>
            </section>
    </div>


    <script src="../script.js"></script>
</body>

</html>