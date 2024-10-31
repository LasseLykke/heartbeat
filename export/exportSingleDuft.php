<?php
ob_start();
session_start();

if (isset($_SESSION['user_id']) && isset($_SESSION['user_name'])) {
    include '../header.php';
?>

<!DOCTYPE html>
<html lang="da">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="1500;url=../logout.php" />
    <title>H E A R T B E A T || DUFT</title>
</head>
<body>

<?php
if (isset($_SESSION["message"])) {
    echo "<p>" . htmlspecialchars($_SESSION["message"]) . "</p>";
    unset($_SESSION["message"]);
}
?>

<!-- Header med navigation -->
<header>
    <button class="hamburger">
        <div class="bar"></div>
    </button>
    <nav class="mobile-nav">
        <a href="../forside.php">Forside</a>
        <a href="../import/importDaily.php">Daglig</a>
        <a href="../import/workoutforms.php">Workout</a>
        <a href="../export/dataOverview.php">Statistik</a>
        <a href="../logout.php">Log ud</a>
    </nav>
</header>

<!-- Wrapper til indhold -->
<div class="wrapper">
    

    <?php
    // Tjekker om parfumeID er sat og henter data fra databasen
    if (isset($_GET['parfumeID'])) {
        $perfumeId = intval($_GET['parfumeID']); // Konverter ID til heltal for sikkerhed

        $sql = "SELECT navn, fabrikant, type, milliliter, bedømmelse, brugsfrekvens, billede FROM perfumeLog WHERE parfumeID = $perfumeId";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $perfume = mysqli_fetch_assoc($result);
            echo '<h1>' . htmlspecialchars($perfume['navn']) . '</h1>';
            echo '<p>Fabrikant: ' . htmlspecialchars($perfume['fabrikant']) . '</p>';
            echo '<p>Type: ' . htmlspecialchars($perfume['type']) . '</p>';
            echo '<p>Størrelse: ' . htmlspecialchars($perfume['milliliter']) . ' ml</p>';
            echo '<p>Holdbarhed: ' . htmlspecialchars($perfume['brugsfrekvens']) . ' timer</p>';
            echo '<p>Bedømmelse: ' . htmlspecialchars($perfume['bedømmelse']) . ' / 5</p>';

            if (!empty($perfume['billede'])) {
                $billedeSti = '../uploads/' . htmlspecialchars($perfume['billede']);
                echo '<img src="' . $billedeSti . '" alt="' . htmlspecialchars($perfume['navn']) . '">';
            } else {
                echo '<p>Billede ikke tilgængeligt</p>';
            }
        } else {
            echo '<p>Parfume ikke fundet.</p>';
        }
    } else {
        echo '<p>Ingen parfume valgt.</p>';
    }
    ?>
</div>

<script src="../script.js"></script>
</body>
</html>

<?php
// Hvis brugeren ikke er logget ind, omdirigeres de til login
} else {
    header("Location: /index.php");
    exit();
}
?>
