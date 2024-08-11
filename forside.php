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
            <a href="#">Statestik</a>
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
           <canvas id="workoutScatterChart"></canvas>
       <?php
           $sql = "SELECT workoutDates FROM workout";
        $result = $conn->query($sql);

        $data = [];

        // Behandler workoutDates-resultaterne
        while($row = $result->fetch_assoc()) {
        $data[] = [
        'x' => $row['workoutDates'], // Sætter datoen som x-værdi
        'y' => 1 // En konstant værdi for hver dato, da vi ikke har et andet parameter her
    ];
// Behandler PAIN data
            // Forespørgsel til at hente alle datoer, hvor painState = 'Ja'
$sql2 = "SELECT DISTINCT painDates FROM pain WHERE painState = 'Ja'";
$result2 = $conn->query($sql2);

$data = [];

// Behandler painDates-resultaterne
while($row2 = $result2->fetch_assoc()) {
    $data[] = [
        'x' => $row2['painDates'], // Sætter datoen som x-værdi
        'y' => 1 // En konstant værdi for hver dato
    ];
}}
?>
           <script>
               // Genererer JavaScript-variabel fra PHP-data
               const workoutData = <?php echo json_encode($data); ?>;
               const painData = <?php echo json_encode($data); ?>;
           </script>
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