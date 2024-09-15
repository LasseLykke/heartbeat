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
        <title>H E A R T B E A T || PULLDOWNS STATS </title>
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
            <h1 class="headerText">Pulldown statestik</h1>
        </section>


        <!-- CHARTS.JS GRAF -->
        <section class="wrapper">
            <div class="export-charts">
                <div class="chart-container">
                    <canvas id="pulldownLineChart"></canvas>

                    <?php
                    // Forespørgsel for at hente data fra db
                    $sql = "SELECT DATE_FORMAT(ws.sessionDate, '%Y-%m-%d') AS date, wa.pulldownRep, wa.pulldownKilo
                            FROM woPulldown AS wa
                            INNER JOIN workoutSession AS ws ON wa.sessionID = ws.sessionID
                            ORDER BY date ASC";

                    $result = $conn->query($sql);

                    $pulldownRepData = [];
                    $pulldownKiloData = [];

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $pulldownRepData[] = [
                                'x' => $row['date'],
                                'y' => $row['pulldownRep']
                            ];
                            $pulldownKiloData[] = [
                                'x' => $row['date'],
                                'y' => $row['pulldownKilo']
                            ];
                            // Gemmer rækken for senere brug i tabellen
                            $tableData[] = $row;
                        }
                    } else {
                        echo "<p>Ingen data fundet</p>";
                    }
                    ?>
                </div> <!-- Afslutter graf wrapper -->



                <script>
                    // Genererer JavaScript-variabler fra PHP-data
                    const pulldownRepData = <?php echo json_encode($pulldownRepData); ?>;
                    const pulldownKiloData = <?php echo json_encode($pulldownKiloData); ?>;

                </script>
            </div>


            <?php
            // Sorter $tableData efter dato i DESC (faldende) rækkefølge
            usort($tableData, function ($a, $b) {
                return strtotime($b['date']) - strtotime($a['date']);
            });
            ?>
            <!-- Collapsible Table Section -->
            <div class="collapsibleTables">
                <button class="collapsible">Vis Statistik</button>
                <div class="content">
                    <table id="absStatsTable">
                        <thead>
                            <tr>
                                <th>Dato</th>
                                <th>Reps</th>
                                <th>Kilo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Loop igennem $tableData for at indsætte data i tabellen
                            foreach ($tableData as $row) {
                                // Formatér datoen korrekt som DD-MM-YY
                                $formattedDate = date('d-m-y', strtotime($row['date']));
                                echo "<tr>";
                                echo "<td>{$formattedDate}</td>";
                                echo "<td>{$row['pulldownRep']}</td>";
                                echo "<td>{$row['pulldownKilo']}</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </section>



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