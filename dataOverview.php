<?php
ob_start();
session_start();

if (isset($_SESSION['user_id']) && isset($_SESSION['user_name'])) {

    include 'header.php';
    ?>

    <!DOCTYPE html>
    <html>

    <head>
         <!-- Logger ud efter 15min -->
        <meta http-equiv="refresh" content="1500;url=logout.php" />
        <title>H E A R T B E A T || D A T A </title>
        <link rel="shortcut icon" href="" type="image/x-icon"/>

    </head>

    <body>
        <header>
            <button class="hamburger">
                <div class="bar"></div>
            </button>

            <nav class="mobile-nav">
                <a href="forside.php">Forside</a>
                <a href="dataOverview.php">Statestik</a>
                <a href="logout.php">Log ud</a>
            </nav>
        </header>




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

        $sql8 = "SELECT legpressRep, legpressKilo FROM workout ORDER BY workoutID DESC LIMIT 1;";
        $result8 = $conn->query($sql8);

        $sql9 = "SELECT legcurlRep, legcurlKilo FROM workout ORDER BY workoutID DESC LIMIT 1;";
        $result9 = $conn->query($sql9);

        $sql10 = "SELECT legextensionRep, legextensionKilo FROM workout ORDER BY workoutID DESC LIMIT 1;";
        $result10 = $conn->query($sql10);

        $sql11 = "SELECT bicepsRep, bicepsKilo FROM workout ORDER BY workoutID DESC LIMIT 1;";
        $result11 = $conn->query($sql11);

        $sql12 = "SELECT neckRep, neckKilo FROM workout ORDER BY workoutID DESC LIMIT 1;";
        $result12 = $conn->query($sql12);

        $sql13 = "SELECT pullupsRep, pullupsKilo FROM workout ORDER BY workoutID DESC LIMIT 1;";
        $result13 = $conn->query($sql13);

        $sql14 = "SELECT løbTid, løbBelastning  FROM workout ORDER BY workoutID DESC LIMIT 1;";
        $result14 = $conn->query($sql14);

        $sql15 = "SELECT rystemaskineTid FROM workout ORDER BY workoutID DESC LIMIT 1;";
        $result15 = $conn->query($sql15);

        $sql16 = "SELECT buttupsRep FROM workout ORDER BY workoutID DESC LIMIT 1;";
        $result16 = $conn->query($sql16);

        $sql17 = "SELECT vand FROM workout ORDER BY workoutID DESC LIMIT 1;";
        $result17 = $conn->query($sql17);

        $sql18 = "SELECT workoutVarighed FROM workout ORDER BY workoutID DESC LIMIT 1;";
        $result18 = $conn->query($sql18);

        

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
                        echo "<p class='dataNumberText'> Tid: " . $cykelTid . 'min' . "</p>";
                        echo "<p class='dataNumberText'>Belastning: " . $cykelBelastning . "</p>";
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
                        echo "<p class='dataNumberText'>Kilo: " . $pulldownKilo . "</p>";
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
                        echo "<p class='dataNumberText'>Kilo: " . $rygbøjningKilo . "</p>";
                        echo "</div>";
                    }
                    ?>

                </div>
                </button></a>
            </div>

        <div class="cart-xs">
                <h3 class="cartheader">Ab Crunchs</h3>
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
                        echo "<p class='dataNumberText'>Kilo: " . $abcrunchKilo . "</p>";
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
                        echo "<p class='dataNumberText'>Kilo: " . $brystpresKilo . "</p>";
                        echo "</div>";
                    }
                    ?>

                </div>
                </button></a>
            </div>

                    <!-- LEGPRESS -->
            <div class="cart-xs">
                <h3 class="cartheader">Benpres</h3>
                <a class="dataNumberText" href="export_workout.php"><button class="cartBtn">
                <div class="dataNumber">
                    
                <?php 
                    if ($result8->num_rows > 0) {
                        $row3 = $result8->fetch_assoc();
                        $legpressRep = $row3['legpressRep'];
                        $legpressKilo = $row3['legpressKilo'];
                    
                        // Display data
                        echo "<div id='latest-workout'>";
                        echo "<p class='dataNumberText'> Seneste data " . "</p>";
                        echo "<p class='dataNumberText'> Rep: " . $legpressRep . "</p>";
                        echo "<p class='dataNumberText'>Kilo: " . $legpressKilo . "</p>";
                        echo "</div>";
                    }
                    ?>

                </div>
                </button></a>
            </div>
        </div>

        <div class="cartWrapper">

            <!-- LEG CURLS -->
        <div class="cart-xs">
                <h3 class="cartheader">Leg Curls</h3>
                <a class="dataNumberText" href="export_workout.php"><button class="cartBtn">
                <div class="dataNumber">
                    
                <?php 
                    if ($result9->num_rows > 0) {
                        $row3 = $result9->fetch_assoc();
                        $legcurlRep = $row3['legcurlRep'];
                        $legcurlKilo = $row3['legcurlKilo'];
                    
                        // Display data
                        echo "<div id='latest-workout'>";
                        echo "<p class='dataNumberText'> Seneste data " . "</p>";
                        echo "<p class='dataNumberText'> Rep: " . $legcurlRep . "</p>";
                        echo "<p class='dataNumberText'>Kilo: " . $legcurlKilo . "</p>";
                        echo "</div>";
                    }
                    ?>

                </div>
                </button></a>
            </div>

                    <!-- LEG EXTENSION -->
            <div class="cart-xs">
                <h3 class="cartheader">Leg Extension</h3>
                <a class="dataNumberText" href="export_workout.php"><button class="cartBtn">
                <div class="dataNumber">
                    
                <?php 
                    if ($result10->num_rows > 0) {
                        $row3 = $result10->fetch_assoc();
                        $legextensionRep = $row3['legextensionRep'];
                        $legextensionKilo = $row3['legextensionKilo'];
                    
                        // Display data
                        echo "<div id='latest-workout'>";
                        echo "<p class='dataNumberText'> Seneste data " . "</p>";
                        echo "<p class='dataNumberText'> Rep: " . $legextensionRep . "</p>";
                        echo "<p class='dataNumberText'>Kilo: " . $legextensionKilo . "</p>";
                        echo "</div>";
                    }
                    ?>

                </div>
                </button></a>
            </div>
        </div>

        <div class="cartWrapper">

            <!-- BICEPS -->
        <div class="cart-xs">
                <h3 class="cartheader">Biceps</h3>
                <a class="dataNumberText" href="export_workout.php"><button class="cartBtn">
                <div class="dataNumber">
                    
                <?php 
                    if ($result11->num_rows > 0) {
                        $row3 = $result11->fetch_assoc();
                        $bicepsRep = $row3['bicepsRep'];
                        $bicepsKilo = $row3['bicepsKilo'];
                    
                        // Display data
                        echo "<div id='latest-workout'>";
                        echo "<p class='dataNumberText'> Seneste data " . "</p>";
                        echo "<p class='dataNumberText'> Rep: " . $bicepsRep . "</p>";
                        echo "<p class='dataNumberText'>Kilo: " . $bicepsKilo . "</p>";
                        echo "</div>";
                    }
                    ?>

                </div>
                </button></a>
            </div>

                     <!-- NECKPRESS -->
        <div class="cart-xs">
                <h3 class="cartheader">Neckpress</h3>
                <a class="dataNumberText" href="export_workout.php"><button class="cartBtn">
                <div class="dataNumber">
                    
                <?php 
                    if ($result12->num_rows > 0) {
                        $row3 = $result12->fetch_assoc();
                        $neckRep = $row3['neckRep'];
                        $neckKilo = $row3['neckKilo'];
                    
                        // Display data
                        echo "<div id='latest-workout'>";
                        echo "<p class='dataNumberText'> Seneste data " . "</p>";
                        echo "<p class='dataNumberText'> Rep: " . $neckRep . "</p>";
                        echo "<p class='dataNumberText'>Kilo: " . $neckRep . "</p>";
                        echo "</div>";
                    }
                    ?>

                </div>
                </button></a>
            </div>
                </div>

        <div class="cartWrapper">

<!-- PULLUPS -->
<div class="cart-xs">
    <h3 class="cartheader">Pull Ups</h3>
    <a class="dataNumberText" href="export_workout.php"><button class="cartBtn">
    <div class="dataNumber">
        
    <?php 
        if ($result13->num_rows > 0) {
            $row3 = $result13->fetch_assoc();
            $pullupsRep = $row3['pullupsRep'];
            $pullupsKilo = $row3['pullupsKilo'];
        
            // Display data
            echo "<div id='latest-workout'>";
            echo "<p class='dataNumberText'> Seneste data " . "</p>";
            echo "<p class='dataNumberText'> Rep: " . $pullupsRep . "</p>";
            echo "<p class='dataNumberText'>Kilo: " . $pullupsKilo . "</p>";
            echo "</div>";
        }
        ?>

    </div>
    </button></a>
</div>

        <!-- LØB -->
<div class="cart-xs">
    <h3 class="cartheader">Løb</h3>
    <a class="dataNumberText" href="export_workout.php"><button class="cartBtn">
    <div class="dataNumber">
        
    <?php 
        if ($result14->num_rows > 0) {
            $row3 = $result14->fetch_assoc();
            $løbTid = $row3['løbTid'];
            $løbBelastning = $row3['løbBelastning'];
        
            // Display data
            echo "<div id='latest-workout'>";
            echo "<p class='dataNumberText'> Seneste data " . "</p>";
            echo "<p class='dataNumberText'> Tid: " . $løbTid . "</p>";
            echo "<p class='dataNumberText'>Belastning: " . $løbBelastning . "</p>";
            echo "</div>";
        }
        ?>

    </div>
    </button></a>
</div>
</div>

<div class="cartWrapper">

<!-- RYSTEMASKINEN -->
<div class="cart-xs">
    <h3 class="cartheader">Rystemaskine</h3>
    <a class="dataNumberText" href="export_workout.php"><button class="cartBtn">
    <div class="dataNumber">
        
    <?php 
        if ($result15->num_rows > 0) {
            $row3 = $result15->fetch_assoc();
            $rystemaskineTid = $row3['rystemaskineTid'];
        
            // Display data
            echo "<div id='latest-workout'>";
            echo "<p class='dataNumberText'> Seneste data " . "</p>";
            echo "<p class='dataNumberText'> Tid: " . $rystemaskineTid . 'min' . "</p>";
            echo "</div>";
        }
        ?>

    </div>
    </button></a>
</div>

        <!-- BUTTUPS -->
<div class="cart-xs">
    <h3 class="cartheader">Buttups</h3>
    <a class="dataNumberText" href="export_workout.php"><button class="cartBtn">
    <div class="dataNumber">
        
    <?php 
        if ($result16->num_rows > 0) {
            $row3 = $result16->fetch_assoc();
            $buttupsRep = $row3['buttupsRep'];
        
            // Display data
            echo "<div id='latest-workout'>";
            echo "<p class='dataNumberText'> Seneste data " . "</p>";
            echo "<p class='dataNumberText'> Rep: " . $buttupsRep . "</p>";
            echo "</div>";
        }
        ?>

    </div>
    </button></a>
</div>
</div>

<div class="cartWrapper">

<!-- VAND -->
<div class="cart-xs">
    <h3 class="cartheader">Vand</h3>
    <a class="dataNumberText" href="export_workout.php"><button class="cartBtn">
    <div class="dataNumber">
        
    <?php 
        if ($result17->num_rows > 0) {
            $row3 = $result17->fetch_assoc();
            $vand = $row3['vand'];
        
            // Display data
            echo "<div id='latest-workout'>";
            echo "<p class='dataNumberText'> Seneste data " . "</p>";
            echo "<p class='dataNumberText'> Drukket: " . $vand . 'liter' . "</p>";
            echo "</div>";
        }
        ?>

    </div>
    </button></a>
</div>

        <!-- VARIGHED -->
<div class="cart-xs">
    <h3 class="cartheader">Varighed</h3>
    <a class="dataNumberText" href="export_workout.php"><button class="cartBtn">
    <div class="dataNumber">
        
    <?php 
        if ($result18->num_rows > 0) {
            $row3 = $result18->fetch_assoc();
            $workoutVarighed = $row3['workoutVarighed'];
        
            // Display data
            echo "<div id='latest-workout'>";
            echo "<p class='dataNumberText'> Seneste data " . "</p>";
            echo "<p class='dataNumberText'> Tid: " . $workoutVarighed . 'min' . "</p>";
            echo "</div>";
        }
        ?>

    </div>
    </button></a>
</div>


        <!-- MANGLER DISSE QUERIES -->
        <!-- Hovedpiner (Laves som dato oversigt graf.) -->
        <!-- Hovedpiner med træning dagen før -->
        <!-- Hovedpiner hvor det er spænding -->
        <!-- Hovedpiner varighed  -->

<br>

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
