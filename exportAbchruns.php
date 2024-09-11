<?php
ob_start();
session_start();


if (isset($_SESSION['user_id']) && isset($_SESSION['user_name'])) {

    include 'header.php';
    ?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Logger ud efter halvanden time -->
    <meta http-equiv="refresh" content="5400;url=logout.php" />
    <title>H E A R T B E A T || ABS STATS </title>
</head>


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
                <h1 class="headerText">Abs stats</h1>
            </section>


            <!-- CHARTS.JS GRAF -->
            <section class="wrapper">
                <div class="frontpage-charts">
                    <div class="chart-container">
                    <canvas id="workoutLineChart"></canvas>
                    <?php
    // Forespørgsel for at hente absRep og absKilo fra woAbs og sessionDate fra workoutSession
    $sql = "SELECT DATE_FORMAT(ws.sessionDate, '%Y-%m-%d') AS date, wa.absRep, wa.absKilo
            FROM woAbs AS wa
            INNER JOIN workoutSession AS ws ON wa.sessionID = ws.sessionID
            ORDER BY date ASC";
    
    $result = $conn->query($sql);

    $absRepData = [];
    $absKiloData = [];

    while($row = $result->fetch_assoc()) {
        $absRepData[] = [
            'x' => $row['date'],  // Session dato
            'y' => $row['absRep']  // Reps for den session
        ];
        $absKiloData[] = [
            'x' => $row['date'],  // Session dato
            'y' => $row['absKilo']  // Kilo for den session
        ];
    }
?>
                </div> <!-- Afslutter wrapper -->

                <script>
                // Genererer JavaScript-variabler fra PHP-data
                const absRepData = <?php echo json_encode($absRepData); ?>;
                const absKiloData = <?php echo json_encode($absKiloData); ?>;
                </script>
                </div>
            </div>     <!-- afslutning af wrapper -->
            </div>
        </section>

            

            
    </div> <!-- wrapper close -->


<script src="script.js"></script>
</body>
</html>

<?php
/* Hvis ikke logget ind bliver man sendt tilbage til login skærm */
} else {
    header("Location: index.php");
    exit();
}
?>