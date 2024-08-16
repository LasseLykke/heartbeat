<?php
ob_start();
session_start();


if (isset($_SESSION['user_id']) && isset($_SESSION['user_name'])) {

    include 'header.php';
    ?>
<!DOCTYPE html>
    <html>

    <head>
    <!-- Logger ud efter 15min -->
    <meta http-equiv="refresh" content="1500;url=logout.php" />
    <title>HEARTBEAT || FORSIDE</title>
    <link rel="shortcut icon" href="" type="image/x-icon"/>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Chart.js inkludering -->
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-moment@1.0.0"></script>

</head>

<body>
    <nav>
        <button class="hamburger">
            <div class="bar"></div>
        </button>

        <nav class="mobile-nav">
            <a href="forside.php">Forside</a>
            <a href="dataOverview.php">Statestik</a>
            <a href="logout.php">Log ud</a>
        </nav>
    </nav>
    <div class="forsideWrapper">
        <div class="hello">
            <h1>Hej <?php echo $_SESSION['name']; ?> 👋🏻</h1>
        </div>
        <div class="formContainer">
            <h2 class="formHeader"></h2>
            <a href="daily.php"><button class="formBtn">Daglig log</button></a>
            <a href="træningsForm.php"><button class="formBtn">Workout's</button></a>
        </div>
        
        <div class="dataContainer">
            <?php 
            $sql1 = "SELECT COUNT(workoutID) AS totalWorkouts FROM workout";
            $result1 = $conn->query($sql1);

            $sql2 = "SELECT COUNT(DISTINCT painDates) AS num_rows FROM pain WHERE painState = 'Ja'";
            $result2 = $conn->query($sql2);
            ?>
        </div>


        <div class="frontpage-charts">
         <div class="chart-container">
        <canvas id="workoutBarChart"></canvas>
           <?php
// Forespørgsel for at hente antal workouts pr. måned
$sql = "SELECT DATE_FORMAT(workoutDates, '%Y-%m') AS month, COUNT(*) AS workoutCount 
        FROM workout 
        GROUP BY month 
        ORDER BY month ASC";
$result = $conn->query($sql);

$workoutData = [];

while($row = $result->fetch_assoc()) {
    $workoutData[] = [
        'x' => $row['month'],  // Gruppér datoerne pr. måned
        'y' => $row['workoutCount']  // Antallet af workouts i den måned
    ];
}

// Forespørgsel for at hente antal pain episodes pr. måned
$sql2 = "SELECT DATE_FORMAT(painDates, '%Y-%m') AS month, COUNT(*) AS painCount 
         FROM pain 
         WHERE painState = 'Ja' 
         GROUP BY month 
         ORDER BY month ASC";
$result2 = $conn->query($sql2);

$painData = [];

while($row2 = $result2->fetch_assoc()) {
    $painData[] = [
        'x' => $row2['month'],  // Gruppér datoerne pr. måned
        'y' => $row2['painCount']  // Antallet af pain episodes i den måned
    ];
}
?>

<script>
// Genererer JavaScript-variabler fra PHP-data
const workoutData = <?php echo json_encode($workoutData); ?>;
const painData = <?php echo json_encode($painData); ?>;
</script>
</div>
       </div>       

</div>



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