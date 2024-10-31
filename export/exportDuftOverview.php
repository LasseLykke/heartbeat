<?php
ob_start();
session_start();

if (isset($_SESSION['user_id']) && isset($_SESSION['user_name'])) {
    include '../header.php';
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="refresh" content="1500;url=../logout.php" />
        <title>H E A R T B E A T || PERFUME</title>
    </head>
    <body>
    
    <?php
    if (isset($_SESSION["message"])) {
        echo "<p>{$_SESSION['message']}</p>";
        unset($_SESSION["message"]);
    }
    ?>

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

    <div class="wrapper">
        <section class="hbHeader">
            <h1 class="headerText">Perfumes</h1>
        </section>
        <div class="INDSÆT DIV CLASS HER SOM PASSER">
        <?php
// Database-forespørgsel for at hente parfumer
$sql = "SELECT parfumeID, navn, fabrikant, type, milliliter, bedømmelse, brugsfrekvens, billede FROM perfumeLog ORDER BY fabrikant DESC;";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    while ($perfume = mysqli_fetch_assoc($result)) {
        echo '<div class="cart">';
        echo '<h3>' . htmlspecialchars($perfume['navn']) . '</h3>';
        echo '<p>' . htmlspecialchars($perfume['fabrikant']) . '</p>';
        echo '<br>';
        if (!empty($perfume['billede'])) {
            $billedeSti = '../uploads/' . htmlspecialchars($perfume['billede']);
            echo '<img src="' . $billedeSti . '" alt="' . htmlspecialchars($perfume['navn']) . '">';
        } else {
            echo '<p>Billede ikke tilgængeligt</p>';
        }
        echo '<p>Type: ' . htmlspecialchars($perfume['type']) . '</p>';
        echo '<p>' . htmlspecialchars($perfume['milliliter']) . ' ml</p>';
        echo '<p>Holdbarhed: ' . htmlspecialchars($perfume['brugsfrekvens']) . ' timer</p>';
        echo '<p>Bedømmelse: ' . htmlspecialchars($perfume['bedømmelse']) . ' / 5</p>';
        echo '<br>';
        echo '<a href="exportSingleDuft.php?parfumeID=' . htmlspecialchars($perfume['parfumeID']) . '" class="primBtn">Se mere</a>';

        echo '</div>';
    }
} else {
    echo '<p>Ingen parfumer fundet.</p>';
}
?>



    </div>
    </div>

    <script src="../script.js"></script>
    </body>
    </html>

    <?php
} else {
    header("Location: /index.php");
    exit();
}
?>
