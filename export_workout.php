<?php
ob_start();
session_start();

if (isset($_SESSION['user_id']) && isset($_SESSION['user_name'])) {

    include 'header.php';
    ?>

    <!DOCTYPE html>
    <html>

    <head>
        <title>H E A R T B E A T || W O R K O U T </title>

    </head>

    <body> <!-- SKIFT WRAPPER CLASS UD -->
        <div class="dataWrapper">
            <div class="dataHeader">
                <h1>Træninger:</h1><br>
                <a href="forside.php"><button class="backBtn">Tilbage</button></a>
            </div>

            <div class="dataResultat">

                <?php

$sql = "SELECT DISTINCT workoutDates FROM workout  ORDER BY workoutDates DESC";
$result = mysqli_query($conn, $sql);
$queryResult = mysqli_num_rows($result);

// Output the count of results
echo '<div class="resultat">';
echo "Der er " . $queryResult . " træninger logget";
echo '</div>';

if ($queryResult > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $painDate = date("d/m Y", strtotime($row["workoutDates"])); // Ændret formatet på datoen her

        // Output a collapsible button for each date
        echo '<button type="button" class="collapsible">' . htmlspecialchars($painDate) . '</button>';
        echo '<div class="content">';
        
        // Retrieve data for the current date using prepared statement
        $dateQuery = "SELECT * FROM workout WHERE workoutDates = ?";
        $stmt = mysqli_prepare($conn, $dateQuery);
        mysqli_stmt_bind_param($stmt, "s", $row["workoutDates"]); // Brug oprindeligt datoformat i query
        mysqli_stmt_execute($stmt);
        $dateResult = mysqli_stmt_get_result($stmt);

        echo '<table class="rowData">';

        while ($dataRow = mysqli_fetch_assoc($dateResult)) {
            // Output the table row for each data point
            
            // Row for Cykel
            echo '<tr>';
            echo '<td><strong>Cykel:</strong></td>';
            echo '</tr>';

            echo '<tr>';
            echo '<td class="dataWorkouts">' . $dataRow["cykelTid"] . 'min' . '</td>';
            echo '<td class="dataWorkouts">' . 'Niveau' . ' ' . $dataRow["cykelBelastning"] . '</td>';
            echo '</tr>';

             // Row for Pulldown
             echo '<tr>';
             echo '<td><strong>Pull Down:</strong></td>';
             echo '</tr>';
 
             echo '<tr>';
             echo '<td class="dataWorkouts">' . $dataRow["pulldownRep"] . ' ' . 'Rep' . '</td>';
             echo '<td class="dataWorkouts">' . $dataRow["pulldownKilo"] . ' ' . 'Kilo' . '</td>';
             echo '</tr>';
        
            
        
            // Row for Skade Bemærkning
            echo '<tr>';
            echo '<td><strong>Skadet:</strong></td>';
            echo '</tr>';

            // Row for Skade Bemærkning's data
            echo '<tr>';
            echo '<td class="dataNotes">' . $dataRow["workoutSkade"] . '</td>';
            echo '</tr>';

            // Row for Bemærkning
            echo '<tr>';
            echo '<td><strong>Bemærkning:</strong></td>';
            echo '</tr>';

            // Row for Bemærkning's data
            echo '<tr>';
            echo '<td class="dataNotes">' . $dataRow["bemærkning"] . '</td>';
            echo '</tr>';
        }
        
        echo '</table></div>';
        
    }
}

}

mysqli_free_result($result);

// Close the database connection
mysqli_close($conn);
?>

        </div>

        <script>
var coll = document.getElementsByClassName("collapsible");
var i;

for (i = 0; i < coll.length; i++) {
  coll[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var content = this.nextElementSibling;
    if (content.style.maxHeight){
      content.style.maxHeight = null;
    } else {
      content.style.maxHeight = content.scrollHeight + "px";
    }
  });
}
</script>
</body>

</html>