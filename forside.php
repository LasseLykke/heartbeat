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
            <h1>Hej 
                <?php
                /* Trækker login bruger ind*/
                echo $_SESSION['name'];
                ?> 👋🏻</h1>
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
        </div>

        <script>
            // PHP til at hente data fra SQL
            <?php
            $sql = "SELECT workoutDate, COUNT(workoutID) AS workoutCount FROM workout GROUP BY workoutDate ORDER BY workoutDate ASC";
            $result = $conn->query($sql);

            $data = [];
            while($row = $result->fetch_assoc()) {
                $data[] = [
                    'x' => $row['workoutDate'],
                    'y' => $row['workoutCount']
                ];
            }
            ?>
            
            // Konverterer PHP data til JavaScript
            const workoutData = <?php echo json_encode($data); ?>;

            const ctx = document.getElementById('workoutScatterChart').getContext('2d');
            const workoutScatterChart = new Chart(ctx, {
                type: 'scatter',
                data: {
                    datasets: [{
                        label: 'Workouts Over Time',
                        data: workoutData,
                        backgroundColor: 'rgba(75, 192, 192, 0.6)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1,
                        pointRadius: 5
                    }]
                },
                options: {
                    scales: {
                        x: {
                            type: 'time',
                            time: {
                                unit: 'day',
                                tooltipFormat: 'MMM DD, YYYY',
                                displayFormats: {
                                    day: 'MMM DD'
                                }
                            },
                            title: {
                                display: true,
                                text: 'Date'
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Number of Workouts'
                            },
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>

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