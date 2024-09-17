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
        <title>H E A R T B E A T || VARIGHED STATS </title>
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
            <h1 class="headerText">Varighed statestik</h1>
        </section>


        <!-- CHARTS.JS GRAF -->
        <section class="wrapper">
            <div class="export-charts">
                <div class="chart-container">
                    <canvas id="workoutLineChart"></canvas>

                    <?php
                    // Forespørgsel for at hente data fra db
                    $sql = "SELECT DATE_FORMAT(ws.sessionDate, '%Y-%m-%d') AS date, 
               TIME_TO_SEC(wa.varighed) AS varighedTidInSeconds 
        FROM woVarighed AS wa
        INNER JOIN workoutSession AS ws ON wa.sessionID = ws.sessionID
        ORDER BY date ASC";

                    $result = $conn->query($sql);

                    $varighedTidData = [];

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $varighedTidData[] = [
                                'x' => $row['date'],
                                'y' => $row['varighedTidInSeconds'] / 60 // Konverterer sekunder til minutter
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
                    const varighedTidData = <?php echo json_encode($varighedTidData); ?>;

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
                                <th>Tid</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Loop igennem $tableData for at indsætte data i tabellen
                            foreach ($tableData as $row) {
                                // Formatér datoen korrekt som DD-MM-YY
                                $formattedDate = date('d-m-y', strtotime($row['date']));

                                // Konverter sekunder til minutter og sekunder
                                $minutes = floor($row['varighedTidInSeconds'] / 60);
                                $seconds = $row['varighedTidInSeconds'] % 60;
                                $formattedTime = sprintf('%02d:%02d', $minutes, $seconds);
                                echo "<tr>";
                                echo "<td>{$formattedDate}</td>";
                                echo "<td>{$formattedTime}</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </section>

        <script>
            // Formaterer datoerne manuelt til DD/MM format
            const formattedDates = varighedTidData.map((data) => {
                const date = new Date(data.x); // Opretter dato objekt
                const day = String(date.getDate()).padStart(2, "0"); // Henter dag med 2 cifre
                const month = String(date.getMonth() + 1).padStart(2, "0"); // Henter måned med 2 cifre (0-indekseret)
                return `${day}/${month}`; // Returnerer i DD/MM format
            });

            // Chart.js konfiguration
            const ctx = document.getElementById("workoutLineChart").getContext("2d");
            const workoutLineChart = new Chart(ctx, {
                type: "line",
                data: {
                    labels: formattedDates, // Brug de formaterede datoer som labels
                    datasets: [
                        {
                            label: "Tid",
                            data: varighedTidData.map((data) => data.y), // Brug kun y-værdierne (reps)
                            borderColor: "rgba(75, 192, 192, 1)",
                            borderWidth: 1,
                            fill: false,
                        },
                        
                    ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    aspectRatio: 4,
                    scales: {
                        x: {
                            type: "category",
                            time: {
                                unit: "day",
                                tooltipFormat: "DD/MM",
                                displayFormats: {
                                    day: "DD/MM",
                                },
                            },
                            ticks: {
                                source: "auto",
                            },
                        },

                        y: {
                            position: "right",
                            beginAtZero: true,
                            suggestedMax: 60, // Antag at den maksimale tid er 60 minutter, du kan justere efter behov
                            title: {
                                display: true,
                                text: 'Tid (minutter)' // Tilføj en titel til y-aksen
                            },
                        },
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: "top",
                            labels: {
                                padding: 20,
                                font: {
                                    size: 12,
                                },
                            },
                        },
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    let label = context.dataset.label || "";
                                    if (label) {
                                        label += ": ";
                                    }
                                    if (context.parsed.y !== null) {
                                        label += context.parsed.y;
                                    }
                                    return label;
                                },
                            },
                        },
                    },
                },
            });

            // Scroll til den seneste dato når grafen er færdig med at loade
            setTimeout(function () {
                // Find containeren for grafen (f.eks. chart-container div'en)
                const chartContainer = document.querySelector(".export-charts");

                // Beregn total bredde af grafens scrollede område
                const totalWidth = chartContainer.scrollWidth;

                // Find indekset for den sidste dato i absRepData
                const lastIndex = varighedTidData.length - 1;

                // Beregn scroll-position
                const scrollPosition = (totalWidth / varighedTidData.length) * lastIndex;

                // Scroll containeren til sidste dato med data
                chartContainer.scrollLeft = scrollPosition - chartContainer.clientWidth / 2;
            }, 100); // Vent et øjeblik for at sikre, at grafen er loadet


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