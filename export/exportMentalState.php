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
        <!-- Logger ud efter 15min -->
        <meta http-equiv="refresh" content="1500;url=logout.php" />
        <title>H E A R T B E A T || HEADACHE MENTALSTATE </title>
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
            <a href="../forside.php">Forside</a>
            <a href="../import/importDaily.php">Daglig</a>
            <a href="../import/workoutforms.php">Workout</a>
            <a href="../export/dataOverview.php">Statestik</a>
            <a href="../logout.php">Log ud</a>
        </nav>
    </header>

    <div class="wrapper">
        <section class="hbHeader">
            <h1 class="headerText">Mentalstate</h1>
        </section>

        <!-- CHARTS.JS GRAF -->
        <section class="wrapper">
            <div class="export-charts">
                <div class="chart-container">
                    <canvas id="workoutLineChart"></canvas>

                    <?php
                    // Forespørgsel for at hente fra databasen
                    $sql = "SELECT DATE_FORMAT(ps.sessionDate, '%Y-%m-%d') AS date, ps.mentalState, ps.notes
                    FROM painSession AS ps
                    WHERE ps.mentalState IS NOT NULL
                    ORDER BY ps.sessionDate ASC";


                    $result = $conn->query($sql);

                    $mentalStateData = [];

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $mentalStateData[] = [
                                'x' => $row['date'],
                                'y' => $row['mentalState'],
                                'notes' => $row['notes'],
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
                    const mentalStateData = <?php echo json_encode($mentalStateData); ?>;
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
                    <table id="statsTable">
                        <thead>
                            <tr>
                                <th>Dato</th>
                                <th>State</th>
                                <th>Noter</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Loop igennem $tableData for at indsætte data i tabellen
                            foreach ($tableData as $row) {
                                if ($row['mentalState'] > 0) {
                                    // Formatér datoen korrekt som DD-MM-YY
                                    $formattedDate = date('d-m-Y', strtotime($row['date']));
                                    echo "<tr>";
                                    echo "<td>{$formattedDate}</td>";
                                    echo "<td>{$row['mentalState']}</td>";
                                    echo "<td>{$row['notes']}</td>";
                                    echo "</tr>";
                                }
                            }
                            ?>
                        </tbody>


                    </table>
                </div>
            </div>

        </section>

        <script>
            // Formaterer datoerne manuelt til DD/MM format
            const formattedDates = mentalStateData.map((data) => {
                const date = new Date(data.x);
                const day = String(date.getDate()).padStart(2, "0");
                const month = String(date.getMonth() + 1).padStart(2, "0");
                return `${day}/${month}`;
            });

            // Chart.js konfiguration
            const ctx = document.getElementById("workoutLineChart").getContext("2d");
            const workoutLineChart = new Chart(ctx, {
                type: "line",
                data: {
                    labels: formattedDates,
                    datasets: [
                        {
                            label: "Mental State",
                            data: mentalStateData.map((data) => data.y),
                            borderColor: "rgba(255, 79, 24, 1)",
                            borderWidth: 1,
                            fill: false,
                            pointBorderWidth: 3,
                            pointHoverBorderColor: 'rgba(255, 255, 255, 0.2)',
                            pointHoverBorderWidth: 10,
                            lineTension: 0.2,
                        },
                    ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    aspectRatio: 4,
                    elements: {
                        point: {
                            radius: 2,
                            hitRadius: 5,
                            hoverRadius: 10,
                        }
                    },
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
                            suggestedMax: 3,
                            title: {
                                display: true,
                            },
                        },
                    },
                    plugins: {
                        legend: {
                            display: false,
                            position: "top",
                        },
                        tooltip: {
                            displayColors: false,
                            callbacks: {
                                label: function (context) {
                                    let label = context.dataset.label || "";
                                    if (label) {
                                        label += ": ";
                                    }
                                    if (context.parsed.y !== null) {
                                        label += context.parsed.y + " ";
                                    }

                                    // Hent bodyPart fra bodyPainData
                                    const mentalState = mentalStateData[context.dataIndex]?.mentalState;
                                    if (mentalState) {
                                        // Returner en array med to elementer for at få dem på forskellige linjer
                                        return [label, `${mentalState} (Mental State)`];
                                    }

                                    // Returner kun label, hvis bodyPart ikke findes
                                    return [label];
                                },
                            },
                        },
                    },
                },
            });


            // Scroll til den seneste dato når grafen er færdig med at loade
            setTimeout(function () {
                const chartContainer = document.querySelector(".export-charts");
                const totalWidth = chartContainer.scrollWidth;
                const lastIndex = mentalStateData.length - 1;
                const scrollPosition = (totalWidth / mentalStateData.length) * lastIndex;
                chartContainer.scrollLeft = scrollPosition - chartContainer.clientWidth / 2;
            }, 100);

        </script>

        <script src="../script.js"></script>
        </body>

    </html>

    <?php
    /* Hvis ikke logget ind bliver man sendt tilbage til login skærm */
} else {
    header("Location: /index.php");
    exit();
}
?>