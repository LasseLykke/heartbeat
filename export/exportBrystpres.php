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
    <title>H E A R T B E A T || BRYSTPRESS STATS </title>
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
      <h1 class="headerText">Brystpres</h1>
    </section>


    <!-- CHARTS.JS GRAF -->
    <section class="wrapper">
      <div class="export-charts">
        <div class="chart-container">
          <canvas id="workoutLineChart"></canvas>

          <?php
          // Forespørgsel for at hente data fra db
          $sql = "SELECT DATE_FORMAT(ws.sessionDate, '%Y-%m-%d') AS date, wa.brystpressRep, wa.brystpressKilo
                            FROM woBrystpress AS wa
                            INNER JOIN workoutSession AS ws ON wa.sessionID = ws.sessionID
                            ORDER BY date ASC";

          $result = $conn->query($sql);

          $brystpressRepData = [];
          $brystpressKiloData = [];

          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              $brystpressRepData[] = [
                'x' => $row['date'],
                'y' => $row['brystpressRep']
              ];
              $brystpressKiloData[] = [
                'x' => $row['date'],
                'y' => floatval ($row['brystpressKilo'])
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
          const brystpressRepData = <?php echo json_encode($brystpressRepData); ?>;
          const brystpressKiloData = <?php echo json_encode($brystpressKiloData); ?>;

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
                <th>Reps</th>
                <th>Kilo</th>
              </tr>
            </thead>
            <tbody>
              <?php
              // Loop igennem $tableData for at indsætte data i tabellen
              foreach ($tableData as $row) {
                // Formatér datoen korrekt som DD-MM-YY
                $formattedDate = date('d-m-Y', strtotime($row['date']));
                echo "<tr>";
                echo "<td>{$formattedDate}</td>";
                echo "<td>{$row['brystpressRep']}</td>";
                echo "<td>{$row['brystpressKilo']}</td>";
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
      const formattedDates = brystpressRepData.map((data) => {
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
              label: "Reps",
              data: brystpressRepData.map((data) => data.y), // Brug kun y-værdierne (reps)
              borderColor: "rgba(185, 132 , 115, 1)",
              borderWidth: 1,
              fill: false,
              pointBorderWidth: 3,
              pointHoverBorderColor: 'rgba(255, 255, 255, 0.2)',
              pointHoverBorderWidth: 10,
              lineTension: 0.2,
            },
            {
              label: "Kilo",
              data: brystpressKiloData.map((data) => data.y), // Brug kun y-værdierne (kilo)
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
              suggestedMax: 103,
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
        const lastIndex = brystpressRepData.length - 1;

        // Beregn scroll-position
        const scrollPosition = (totalWidth / brystpressRepData.length) * lastIndex;

        // Scroll containeren til sidste dato med data
        chartContainer.scrollLeft = scrollPosition - chartContainer.clientWidth / 2;
      }, 100); // Vent et øjeblik for at sikre, at grafen er loadet


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