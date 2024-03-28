<?php
ob_start();
session_start();

if (isset($_SESSION['user_id']) && isset($_SESSION['user_name'])) {

    include 'header.php';
    ?>

    <!DOCTYPE html>
    <html>

    <head>
        <title>H E A R T B E A T || D A T A </title>

    </head>

    <body>
        <div class="dataWrapper">
            <div class="dataHeader">
                <h1>Dataoversigt:</h1><br>
                <a href="forside.php"><button class="backBtn">Tilbage</button></a>
            </div>

            <div class="dataResultat">

            <?php 
        $sql1 = "SELECT COUNT(workoutID) AS totalWorkouts FROM workout";
        $result1 = $conn->query($sql1);

        $sql2 = "SELECT COUNT(DISTINCT painDates) AS num_rows FROM pain WHERE painState = 'Ja'";
        $result2 = $conn->query($sql2);

        $sql3 = "SELECT cykelTid, cykelBelastning FROM workout ORDER BY workoutID DESC LIMIT 1;";
        $result3 = $conn->query($sql3);

        $sql4 = "SELECT pulldownRep, pulldownKilo FROM workout ORDER BY workoutID DESC LIMIT 1;";
        $result4 = $conn->query($sql4);

        $sql5 = "SELECT rygbøjningRep, rygbøjningKilo FROM workout ORDER BY workoutID DESC LIMIT 1;";
        $result5 = $conn->query($sql5);

        $sql6 = "SELECT abcrunchRep, abcrunchKilo FROM workout ORDER BY workoutID DESC LIMIT 1;";
        $result6 = $conn->query($sql6);

        $sql7 = "SELECT brystpresRep, brystpresKilo FROM workout ORDER BY workoutID DESC LIMIT 1;";
        $result7 = $conn->query($sql7);

        ?>
    
        <h2 class="dataOverview">Smerter:</h2>
        
        <div class="cartWrapper">
            <div class="cart-xs">
                <h3 class="cartheader">Workouts</h3>
                <a href="export_workout.php"><button class="cartBtn">
                <h1 class="cartNumber">
                    <?php 
                    if ($result1->num_rows > 0) {
                        $row1 = $result1->fetch_assoc();
                        $totalWorkouts = $row1["totalWorkouts"];
                        echo "<div id='cartBtn'>";
                        echo "<h3>" . $totalWorkouts . "</h3>";
                        echo "</div>";
                    } else {
                        echo "0";
                    }
                    ?>
                </h1>
                </button></a>
            </div>

            <div class="cart-xs">
                <h3 class="cartheader">Hovedpiner</h3>
                <a href="export_pain.php"><button class="cartBtn">
                <h1 class="cartNumber">
                    <?php 
                    if ($result2->num_rows > 0) {
                        $row2 = $result2->fetch_assoc();
                        $count = $row2['num_rows'];
                    
                        // Display the count
                        echo "<div id='cart-xs'>";
                        echo "<h3>" . $count . "</h3>";
                        echo "</div>";
                    } else {
                        echo "Ingen resultater fundet";
                    }
                    ?>
                </h1>
                </button></a>
            </div>
        </div><br>


        <h2 class="dataOverview">Workouts:</h2>


        <div class="cartWrapper">
            <div class="cart-xs">
                <h3 class="cartheader">Cykling</h3>
                <a class="dataNumberText" href="export_workout.php"><button class="cartBtn">
                <div class="dataNumber">
                    
                <?php 
                    if ($result3->num_rows > 0) {
                        $row3 = $result3->fetch_assoc();
                        $cykelTid = $row3['cykelTid'];
                        $cykelBelastning = $row3['cykelBelastning'];
                    
                        // Display data
                        echo "<div id='latest-workout'>";
                        echo "<p class='dataNumberText'> Seneste data " . "</p>";
                        echo "<p class='dataNumberText'> Tid: " . $cykelTid . "</p>";
                        echo "<p class='dataNumberText'>Belastning " . $cykelBelastning . "</p>";
                        echo "</div>";
                    }
                    ?>

                </div>
                </button></a>
            </div>

            <div class="cart-xs">
                <h3 class="cartheader">Pulldowns</h3>
                <a class="dataNumberText" href="export_workout.php"><button class="cartBtn">
                <div class="dataNumber">
                    
                <?php 
                    if ($result4->num_rows > 0) {
                        $row3 = $result4->fetch_assoc();
                        $pulldownRep = $row3['pulldownRep'];
                        $pulldownKilo = $row3['pulldownKilo'];
                    
                        // Display data
                        echo "<div id='latest-workout'>";
                        echo "<p class='dataNumberText'> Seneste data " . "</p>";
                        echo "<p class='dataNumberText'> Rep: " . $pulldownRep . "</p>";
                        echo "<p class='dataNumberText'>Kilo " . $pulldownKilo . "</p>";
                        echo "</div>";
                    }
                    ?>

                </div>
                </button></a>
            </div>
                </div>

        <div class="cartWrapper">
        <div class="cart-xs">
                <h3 class="cartheader">Rygbøjninger</h3>
                <a class="dataNumberText" href="export_workout.php"><button class="cartBtn">
                <div class="dataNumber">
                    
                <?php 
                    if ($result5->num_rows > 0) {
                        $row3 = $result5->fetch_assoc();
                        $rygbøjningRep = $row3['rygbøjningRep'];
                        $rygbøjningKilo = $row3['rygbøjningKilo'];
                    
                        // Display data
                        echo "<div id='latest-workout'>";
                        echo "<p class='dataNumberText'> Seneste data " . "</p>";
                        echo "<p class='dataNumberText'> Rep: " . $rygbøjningRep . "</p>";
                        echo "<p class='dataNumberText'>Kilo " . $rygbøjningKilo . "</p>";
                        echo "</div>";
                    }
                    ?>

                </div>
                </button></a>
            </div>

        <div class="cart-xs">
                <h3 class="cartheader">Abs</h3>
                <a class="dataNumberText" href="export_workout.php"><button class="cartBtn">
                <div class="dataNumber">
                    
                <?php 
                    if ($result6->num_rows > 0) {
                        $row3 = $result6->fetch_assoc();
                        $abcrunchRep = $row3['abcrunchRep'];
                        $abcrunchKilo = $row3['abcrunchKilo'];
                    
                        // Display data
                        echo "<div id='latest-workout'>";
                        echo "<p class='dataNumberText'> Seneste data " . "</p>";
                        echo "<p class='dataNumberText'> Rep: " . $abcrunchRep . "</p>";
                        echo "<p class='dataNumberText'>Kilo " . $abcrunchKilo . "</p>";
                        echo "</div>";
                    }
                    ?>

                </div>
                </button></a>
            </div>
        </div>

        <div class="cartWrapper">
        <div class="cart-xs">
                <h3 class="cartheader">Brystpres</h3>
                <a class="dataNumberText" href="export_workout.php"><button class="cartBtn">
                <div class="dataNumber">
                    
                <?php 
                    if ($result7->num_rows > 0) {
                        $row3 = $result7->fetch_assoc();
                        $brystpresRep = $row3['brystpresRep'];
                        $brystpresKilo = $row3['brystpresKilo'];
                    
                        // Display data
                        echo "<div id='latest-workout'>";
                        echo "<p class='dataNumberText'> Seneste data " . "</p>";
                        echo "<p class='dataNumberText'> Rep: " . $brystpresRep . "</p>";
                        echo "<p class='dataNumberText'>Kilo " . $brystpresKilo . "</p>";
                        echo "</div>";
                    }
                    ?>

                </div>
                </button></a>
            </div>

            <div class="cart-xs">
                <h3 class="cartheader">LegCurls</h3>
                <a href="export_workout.php"><button class="cartBtn">
                <h1 class="cartNumber">
                   
                   
                </h1>
                </button></a>
            </div>

            <div class="cart-xs">
                <h3 class="cartheader">LegExtension</h3>
                <a href="export_pain.php"><button class="cartBtn">
                <h1 class="cartNumber">
                    
                    
                </h1>
                </button></a>
            </div>
        </div>

        <div class="cartWrapper">
            <div class="cart-xs">
                <h3 class="cartheader">Biceps</h3>
                <a href="export_workout.php"><button class="cartBtn">
                <h1 class="cartNumber">
                   
                   
                </h1>
                </button></a>
            </div>

            <div class="cart-xs">
                <h3 class="cartheader">Buttups</h3>
                <a href="export_pain.php"><button class="cartBtn">
                <h1 class="cartNumber">
                    
                    
                </h1>
                </button></a>
            </div>
        </div>

        <div class="cartWrapper">
            <div class="cart-xs">
                <h3 class="cartheader">Pullups</h3>
                <a href="export_workout.php"><button class="cartBtn">
                <h1 class="cartNumber">
                   
                   
                </h1>
                </button></a>
            </div>

            <div class="cart-xs">
                <h3 class="cartheader">Løb</h3>
                <a href="export_pain.php"><button class="cartBtn">
                <h1 class="cartNumber">
                    
                    
                </h1>
                </button></a>
            </div>
        </div>

        <div class="cartWrapper">
            <div class="cart-xs">
                <h3 class="cartheader">Rystemaskine</h3>
                <a href="export_workout.php"><button class="cartBtn">
                <h1 class="cartNumber">
                   
                   
                </h1>
                </button></a>
            </div>

            <div class="cart-xs">
                <h3 class="cartheader">Musik</h3>
                <a href="export_pain.php"><button class="cartBtn">
                <h1 class="cartNumber">
                    
                    
                </h1>
                </button></a>
            </div>
        </div>

        <div class="cartWrapper">
            <div class="cart-xs">
                <h3 class="cartheader">Vand</h3>
                <a href="export_workout.php"><button class="cartBtn">
                <h1 class="cartNumber">
                   
                   
                </h1>
                </button></a>
            </div>

            <div class="cart-xs">
                <h3 class="cartheader">Vægt</h3>
                <a href="export_pain.php"><button class="cartBtn">
                <h1 class="cartNumber">
                    
                    
                </h1>
                </button></a>
            </div>
        </div>

        <div class="cartWrapper">
            <div class="cart-xs">
                <h3 class="cartheader">Varighed</h3>
                <a href="export_workout.php"><button class="cartBtn">
                <h1 class="cartNumber">
                   
                   
                </h1>
                </button></a>
            </div>

            <div class="cart-xs">
                <h3 class="cartheader">Skader</h3>
                <a href="export_pain.php"><button class="cartBtn">
                <h1 class="cartNumber">
                    
                    
                </h1>
                </button></a>
            </div>
        </div>
        <br>

        </div>


        <!-- Hovedpiner (Laves som dato oversigt graf.) -->
        <!-- Hovedpiner med træning dagen før -->
        <!-- Hovedpiner hvor det er spænding -->
        <!-- Hovedpiner varighed  -->
        <!-- WO: Cykel -->
        <!-- WO: Pulldowns -->
        <!-- WO: Rygbøjninger -->
        <!-- WO: Abs -->
        <!-- WO: Brystpres -->
        <!-- WO: Legpres -->
        <!-- WO: LegCurls -->
        <!-- WO: LegExtension -->
        <!-- WO: Biceps -->
        <!-- WO: Buttups -->
        <!-- WO: Pulldowns -->
        <!-- WO: Løb -->
        <!-- WO: Rystemaskine -->
        <!-- WO: Musik -->
        <!-- WO: Vand -->
        <!-- WO: Vægt -->
        <!-- WO: Varighed -->
        <!-- WO: Skader -->
        <!-- WO: Bemærkninger - Er ikke sikker på denne skal med, er ikke taget med for nu. -->

</body>

</html>
<?php
/* Hvis ikke logget ind bliver man sendt tilbage til login skærm */
} else {
    header("Location: index.php");
    exit();
}
?>