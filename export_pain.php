<?php
ob_start();
session_start();

if (isset($_SESSION['user_id']) && isset($_SESSION['user_name'])) {

    include 'header.php';
    ?>

    <!DOCTYPE html>
    <html>

    <head>
        <title>H E A R T B E A T || P A I N </title>

    </head>

    <body> <!-- SKIFT WRAPPER CLASS UD -->
        <div class="dataWrapper">
            <div class="dataHeader">
                <h1>Hovedpiner:</h1><br>
                <a href="forside.php"><button class="backBtn">Tilbage</button></a>
            </div>

            <div class="dataResultat">

                <?php

                $sql = "SELECT painDates, painState, painLevel, painType, painKillers, painDuration, painWorkout, painNotes FROM pain WHERE painState = 'Ja'";

                $result = mysqli_query($conn, $sql);
                $queryResult = mysqli_num_rows($result);

                echo '<table>
                        <tr>
                        <th> Dato </th>
                        <th> Sværhedsgrad </th>
                        <th> Type </th>
                        <th> Varighed </th>
                        <th> Ekstra Medicin </th>
                        <th> Trænet dagen før </th>
                        <th> Bemærkning </th>
                        </tr>
                        ';
                ?>

                <!-- Viser hvor mange resultater der er. -->
                <div class="resultat">
                    <?php echo "Der er " . $queryResult . " hovedepiner logget"; ?>
                </div>

                <?php
                if ($queryResult > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<tr> 
                        <td>' . $row["painDates"] . '</td>
                        <td>' . $row["painLevel"] . '</td>
                        <td> ' . $row["painType"] . '</td> 
                        <td> ' . $row["painDuration"] . '</td> 
                        <td> ' . $row["painKillers"] . '</td> 
                        <td> ' . $row["painWorkout"] . '</td> 
                        <td> ' . $row["painNotes"] . '</td>
                        </tr>';
                    }
                    echo '</table>';
                }


                mysqli_free_result($result);

                // Lukker forbindelsen.
                mysqli_close($conn);
}
?>
</div>
</body>

</html>