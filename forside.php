<?php
ob_start();
session_start();

if (isset($_SESSION['user_id']) && isset($_SESSION['user_name'])) {

    include 'header.php';
    require 'navbar.php';
    ?>
    <!DOCTYPE html>
    <html>

    <head>
        <!-- Logger ud efter 15min -->
        <meta http-equiv="refresh" content="1500;url=logout.php" />
        <title>HEARTBEAT || FORSIDE</title>
        <link rel="shortcut icon" href="" type="image/x-icon" />
    </head>

    <body>

        <!-- INPUT SECTION -->
        <div class="wrapper">
            <section class="hbHeader">
                <h1 class="headerText">Hej <?php echo $_SESSION['name']; ?> 👋🏻</h1>
                <div class="formContainer">
                    <a href="../import/importDaily.php"><button class="formBtn">Daglig log</button></a>
                    <a href="../import/workoutforms.php"><button class="formBtn">Workout's</button></a>
                </div>
            </section>

            <!-- CHARTS.JS GRAF -->
            <div class="frontpage-charts">
                <div class="chart-container">
                    <canvas id="workoutBarChart"></canvas>
                    <?php
                    // Forespørgsel for at hente antal workouts pr. måned
                    $sql = "SELECT DATE_FORMAT(sessionDate, '%Y-%m') AS month, COUNT(DISTINCT DATE(sessionDate)) AS workoutCount 
                    FROM workoutSession 
                    GROUP BY month 
                    ORDER BY month ASC";
                    $result = $conn->query($sql);

                    $workoutData = [];
                    while ($row = $result->fetch_assoc()) {
                        $workoutData[] = [
                            'x' => $row['month'],  // Gruppér datoerne pr. måned
                            'y' => $row['workoutCount']  // Antallet af workouts i den måned
                        ];
                    }


                    // Forespørgsel for at hente hovedpine data fra headacheLog og painSession tabellerne
                    $sql2 = "SELECT DATE_FORMAT(ps.sessionDate, '%Y-%m') AS month, 
                    COUNT(CASE WHEN hasHeadache = 1 THEN 1 END) AS headacheCount
                    FROM painSession ps
                    INNER JOIN headacheLog hl ON ps.sessionID = hl.sessionID
                    GROUP BY month
                    ORDER BY month ASC";
                    $result2 = $conn->query($sql2);

                    $headacheData = [];
                    while ($row2 = $result2->fetch_assoc()) {
                        $headacheData[] = [
                            'x' => $row2['month'],  // Gruppér datoerne pr. måned
                            'y' => $row2['headacheCount']  // Antallet af hovedpine episoder i den måned
                        ];
                    }
                    ?>
                </div> <!-- Afslutter wrapper -->

                <script>
                    // Genererer JavaScript-variabler fra PHP-data
                    const workoutData = <?php echo json_encode($workoutData); ?>;
                    const headacheData = <?php echo json_encode($headacheData); ?>; // Tilføj hovedpine data
                </script>
            </div>
        </div> <!-- afslutning af wrapper -->
        </div>

        <script src="./script.js"></script>

    </body>

    </html>

    <?php
    /* Hvis ikke logget ind bliver man sendt tilbage til login skærm */
} else {
    header("Location: index.php");
    exit();
}
?>