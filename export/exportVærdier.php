<?php
ob_start();
session_start();

if (isset($_SESSION['user_id']) && isset($_SESSION['user_name'])) {
    include '../header.php';
    require '../navbar.php';
    ?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Logger ud efter 15min -->
        <meta http-equiv="refresh" content="1500;url=../logout.php" />
        <title>H E A R T B E A T || HEADACHE VÆRDIER </title>
    </head>

    <?php
    // Viser success eller fejl meddelelse
    if (isset($_SESSION["message"])) {
        echo "<p>{$_SESSION["message"]}</p>";
        unset($_SESSION["message"]);
    }
    ?>

    <div class="wrapper">
        <section class="hbHeader">
            <h1 class="headerText">Værdier</h1>
        </section>

        <!-- CHARTS.JS GRAF -->
        <section class="wrapper">
            <div class="export-charts">
                <div class="chart-container">
                    <canvas id="workoutLineChart"></canvas>

                    <?php
                    // Forespørgsel for at hente sessionDate fra workoutSession og værdier fra woVærdi
                    $sql = "SELECT 
            DATE_FORMAT(ws.sessionDate, '%Y-%m-%d') AS date, 
            wv.gnsPuls, 
            wv.kcal
        FROM workoutSession AS ws
        INNER JOIN woVærdi AS wv ON ws.sessionID = wv.sessionID
        WHERE wv.gnsPuls > 0 OR wv.kcal > 0
        ORDER BY ws.sessionDate ASC";

                    $result = $conn->query($sql);

                    $woData = [];
                    $tableData = [];

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            // Data til grafen
                            $woData[] = [
                                'x' => $row['date'],
                                'gnsPuls' => $row['gnsPuls'],
                                'kcal' => $row['kcal']
                            ];
                            // Data til tabellen
                            $tableData[] = $row;
                        }
                    } else {
                        echo "<p>Ingen data fundet</p>";
                    }
                    ?>

                    <script>
                        // Genererer JavaScript-variabler fra PHP-data
                        const woData = <?php echo json_encode($woData); ?>;
                    </script>

                    <?php
                    // Sorter $tableData efter dato i DESC (faldende) rækkefølge
                    usort($tableData, function ($a, $b) {
                        return strtotime($b['date']) - strtotime($a['date']);
                    });
                    ?>
                </div> <!-- Afslutter graf wrapper -->

                <script>
                    // Genererer JavaScript-variabler fra PHP-data
                    const woData = <?php echo json_encode($woData); ?>;
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
                                <th>GNS Puls</th>
                                <th>kcal ialt</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Loop igennem $tableData for at indsætte data i tabellen
                            foreach ($tableData as $row) {
                                // Tjek om headacheLevel eller headacheDuration er til stede (indikerer hovedpine)
                                if ($row['gnsPuls'] > 0 || $row['kcal'] > 0) {
                                    // Formatér datoen korrekt som DD-MM-YY
                                    $formattedDate = date('d-m-Y', strtotime($row['date']));
                                    echo "<tr>";
                                    echo "<td>{$formattedDate}</td>";
                                    echo "<td>{$row['gnsPuls']}</td>";
                                    echo "<td>{$row['kcal']}</td>";
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
            const formattedDates = woData.map((data) => {
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
                            label: "GNS Puls",
                            data: woData.map((data) => data.gnsPuls), // Brug headacheLevel til graf
                            borderColor: "rgba(185, 132 , 115, 1)",
                            borderWidth: 1,
                            fill: false,
                            pointBorderWidth: 3,
                            pointHoverBorderColor: 'rgba(255, 255, 255, 0.2)',
                            pointHoverBorderWidth: 10,
                            lineTension: 0.2,
                        },
                        {
                            label: "Kcal",
                            data: woData.map((data) => data.kcal), // Brug headacheDuration til graf
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
                            suggestedMax: 24,
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
                            displayColors: false, // Fjerner farve for når man hover over.
                            callbacks: {
                                label: function (context) {
                                    let label = context.dataset.label || "";
                                    if (label) {
                                        label += ": ";
                                    }
                                    if (context.parsed.y !== null) {
                                        // Hvis dataset er for "Varighed", tilføj "timer"
                                        if (label === "Kcal: ") {
                                            label += context.parsed.y + "";
                                        } else {
                                            label += context.parsed.y;
                                        }
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
                const chartContainer = document.querySelector(".export-charts");
                const totalWidth = chartContainer.scrollWidth;
                const lastIndex = woData.length - 1;
                const scrollPosition = (totalWidth / woData.length) * lastIndex;
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