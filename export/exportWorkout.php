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
        <title>H E A R T B E A T || ALL STATS </title>
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
            <h1 class="headerText">Samlede træningsdata</h1>
        </section>

        <!-- CHARTS.JS GRAF -->
        <section class="wrapper">
            <div class="export-charts">
                <div class="chart-container">
                    <canvas id="workoutLineChart"></canvas>

                    <?php
                    // Forespørgsel for at hente data fra flere tabeller
                    $sql = "
                        SELECT DATE_FORMAT(ws.sessionDate, '%Y-%m-%d') AS date, 
                            wa.absRep, wa.absKilo, 
                            wb.bicepsRep, wb.bicepsKilo,
                            wbpress.brystpressRep, wbpress.brystpressKilo,
                            wbutt.buttupsRep, wcyk.cykelTid, wcyk.cykelBelastning,
                            wext.legextensionRep, wext.legextensionKilo,
                            wlcurl.legcurlRep, wlcurl.legcurlKilo,
                            wlp.legpressRep, wlp.legpressKilo,
                            wløb.løbTid, wløb.løbBelastning,
                            wneck.neckpressRep, wneck.neckpressKilo,
                            wpull.pulldownRep, wpull.pulldownKilo,
                            wpup.pullupsRep, wpup.pullupsKilo,
                            wryg.rygRep, wryst.rystTid, wvand.vand, wvægt.vægt, wvar.varighed
                        FROM workoutSession AS ws
                        LEFT JOIN woAbs AS wa ON wa.sessionID = ws.sessionID
                        LEFT JOIN woBiceps AS wb ON wb.sessionID = ws.sessionID
                        LEFT JOIN woBrystpress AS wbpress ON wbpress.sessionID = ws.sessionID
                        LEFT JOIN woButtups AS wbutt ON wbutt.sessionID = ws.sessionID
                        LEFT JOIN woCykel AS wcyk ON wcyk.sessionID = ws.sessionID
                        LEFT JOIN woExtension AS wext ON wext.sessionID = ws.sessionID
                        LEFT JOIN woLegcurl AS wlcurl ON wlcurl.sessionID = ws.sessionID
                        LEFT JOIN woLegpress AS wlp ON wlp.sessionID = ws.sessionID
                        LEFT JOIN woLøb AS wløb ON wløb.sessionID = ws.sessionID
                        LEFT JOIN woNeck AS wneck ON wneck.sessionID = ws.sessionID
                        LEFT JOIN woPulldown AS wpull ON wpull.sessionID = ws.sessionID
                        LEFT JOIN woPullups AS wpup ON wpup.sessionID = ws.sessionID
                        LEFT JOIN woRyg AS wryg ON wryg.sessionID = ws.sessionID
                        LEFT JOIN woRyst AS wryst ON wryst.sessionID = ws.sessionID
                        LEFT JOIN woVand AS wvand ON wvand.sessionID = ws.sessionID
                        LEFT JOIN woVægt AS wvægt ON wvægt.sessionID = ws.sessionID
                        LEFT JOIN woVarighed AS wvar ON wvar.sessionID = ws.sessionID
                        ORDER BY date ASC";

                    $result = $conn->query($sql);

                    $allData = [];

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $allData[] = $row;
                        }
                    } else {
                        echo "<p>Ingen data fundet</p>";
                    }
                    ?>
                </div> <!-- Afslutter graf wrapper -->

                <script>


                    // Genererer JavaScript-variabler fra PHP-data
                    const allData = <?php echo json_encode($allData); ?>;



                    // Chart.js konfiguration med unikke farver til hver dataset
                    const ctx = document.getElementById("workoutLineChart").getContext("2d");
                    const workoutLineChart = new Chart(ctx, {
                        type: "line",
                        data: {
                            labels: allData.map(data => data.date),
                            datasets: [
                                {
                                    label: "Abs Reps",
                                    data: allData.map(data => data.absRep),
                                    borderColor: "rgba(75, 192, 192, 1)",
                                    borderWidth: 1,
                                    fill: false,
                                },
                                {
                                    label: "Biceps Reps",
                                    data: allData.map(data => data.bicepsRep),
                                    borderColor: "rgba(153, 102, 255, 1)",
                                    borderWidth: 1,
                                    fill: false,
                                },
                                {
                                    label: "Brystpress Reps",
                                    data: allData.map(data => data.brystpressRep),
                                    borderColor: "rgba(255, 99, 132, 1)",
                                    borderWidth: 1,
                                    fill: false,
                                },
                                {
                                    label: "Buttups Reps",
                                    data: allData.map(data => data.buttupsRep),
                                    borderColor: "rgba(54, 162, 235, 1)",
                                    borderWidth: 1,
                                    fill: false,
                                },
                                {
                                    label: "Cykel Tid",
                                    data: allData.map(data => data.cykelTid),
                                    borderColor: "rgba(255, 206, 86, 1)",
                                    borderWidth: 1,
                                    fill: false,
                                },
                                {
                                    label: "Cykel Belastning",
                                    data: allData.map(data => data.cykelBelastning),
                                    borderColor: "rgba(75, 192, 192, 1)",
                                    borderWidth: 1,
                                    fill: false,
                                },
                                {
                                    label: "Leg Extension Reps",
                                    data: allData.map(data => data.legextensionRep),
                                    borderColor: "rgba(153, 102, 255, 1)",
                                    borderWidth: 1,
                                    fill: false,
                                },
                                {
                                    label: "Leg Curl Reps",
                                    data: allData.map(data => data.legcurlRep),
                                    borderColor: "rgba(255, 159, 64, 1)",
                                    borderWidth: 1,
                                    fill: false,
                                },
                                {
                                    label: "Leg Press Reps",
                                    data: allData.map(data => data.legpressRep),
                                    borderColor: "rgba(54, 162, 235, 1)",
                                    borderWidth: 1,
                                    fill: false,
                                },
                                {
                                    label: "Løb Tid",
                                    data: allData.map(data => data.løbTid),
                                    borderColor: "rgba(255, 99, 132, 1)",
                                    borderWidth: 1,
                                    fill: false,
                                },
                                {
                                    label: "Løb Belastning",
                                    data: allData.map(data => data.løbBelastning),
                                    borderColor: "rgba(75, 192, 192, 1)",
                                    borderWidth: 1,
                                    fill: false,
                                },
                                {
                                    label: "Neck Press Reps",
                                    data: allData.map(data => data.neckpressRep),
                                    borderColor: "rgba(153, 102, 255, 1)",
                                    borderWidth: 1,
                                    fill: false,
                                },
                                {
                                    label: "Pulldown Reps",
                                    data: allData.map(data => data.pulldownRep),
                                    borderColor: "rgba(255, 159, 64, 1)",
                                    borderWidth: 1,
                                    fill: false,
                                },
                                {
                                    label: "Pullups Reps",
                                    data: allData.map(data => data.pullupsRep),
                                    borderColor: "rgba(54, 162, 235, 1)",
                                    borderWidth: 1,
                                    fill: false,
                                },
                                {
                                    label: "Ryg Reps",
                                    data: allData.map(data => data.rygRep),
                                    borderColor: "rgba(255, 206, 86, 1)",
                                    borderWidth: 1,
                                    fill: false,
                                },
                                {
                                    label: "Ryst Tid",
                                    data: allData.map(data => data.rystTid),
                                    borderColor: "rgba(75, 192, 192, 1)",
                                    borderWidth: 1,
                                    fill: false,
                                },
                                {
                                    label: "Vand",
                                    data: allData.map(data => data.vand),
                                    borderColor: "rgba(153, 102, 255, 1)",
                                    borderWidth: 1,
                                    fill: false,
                                },
                                {
                                    label: "Vægt",
                                    data: allData.map(data => data.vægt),
                                    borderColor: "rgba(255, 99, 132, 1)",
                                    borderWidth: 1,
                                    fill: false,
                                },
                                {
                                    label: "Varighed",
                                    data: allData.map(data => data.varighed),
                                    borderColor: "rgba(255, 159, 64, 1)",
                                    borderWidth: 1,
                                    fill: false,
                                },
                            ],
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: true,
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
                                    suggestedMax: 200,
                                    title: {
                                        display: true,
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
                        const lastIndex = $allData.length - 1;

                        // Beregn scroll-position
                        const scrollPosition = (totalWidth / $allData.length) * lastIndex;

                        // Scroll containeren til sidste dato med data
                        chartContainer.scrollLeft = scrollPosition - chartContainer.clientWidth / 2;
                    }, 100); // Vent et øjeblik for at sikre, at grafen er loadet
                </script>
            </div>

            <!-- Collapsible Table Section -->
            <div class="collapsibleTables">
                <button class="collapsible">Vis Statistik</button>
                <div class="content">
                    <table id="allStatsTable">
                        <thead>
                            <tr>
                                <th>Dato</th>
                                <th>Abs Reps</th>
                                <th>Biceps Reps</th>
                                <th>Brystpress Reps</th>
                                <!-- Flere kolonner for de andre øvelser -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($allData as $row) {
                                $formattedDate = date('d-m-y', strtotime($row['date']));
                                echo "<tr>";
                                echo "<td>{$formattedDate}</td>";
                                echo "<td>{$row['absRep']}</td>";
                                echo "<td>{$row['bicepsRep']}</td>";
                                echo "<td>{$row['brystpressRep']}</td>";
                                // Flere datafelter for de andre øvelser
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
} else {
    header("Location: index.php");
    exit();
}
?>