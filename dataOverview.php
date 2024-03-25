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
                <a href="export_workout.php"><button class="cartBtn">
                <h1 class="cartNumber">
                    
                <!-- Indsæt PHP med antal cyklet minutter ialt -->

                </h1>
                </button></a>
            </div>

            <div class="cart-xs">
                <h3 class="cartheader">Pulldowns</h3>
                <a href="export_pain.php"><button class="cartBtn">
                <h1 class="cartNumber">
                    
                    
                </h1>
                </button></a>
            </div>
        </div>

        <div class="cartWrapper">
            <div class="cart-xs">
                <h3 class="cartheader">Rygbøjning</h3>
                <a href="export_workout.php"><button class="cartBtn">
                <h1 class="cartNumber">
                    
                    
                </h1>
                </button></a>
            </div>

            <div class="cart-xs">
                <h3 class="cartheader">Abcrunch</h3>
                <a href="export_pain.php"><button class="cartBtn">
                <h1 class="cartNumber">
                    
                    
                </h1>
                </button></a>
            </div>
        </div>

        <div class="cartWrapper">
            <div class="cart-xs">
                <h3 class="cartheader">Brystpres</h3>
                <a href="export_workout.php"><button class="cartBtn">
                <h1 class="cartNumber">
                   
                   
                </h1>
                </button></a>
            </div>

            <div class="cart-xs">
                <h3 class="cartheader">Legpress</h3>
                <a href="export_pain.php"><button class="cartBtn">
                <h1 class="cartNumber">
                    
                    
                </h1>
                </button></a>
            </div>
        </div>

        <div class="cartWrapper">
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
        <!-- WO: Bemærkninger -->

</body>

</html>
<?php
/* Hvis ikke logget ind bliver man sendt tilbage til login skærm */
} else {
    header("Location: index.php");
    exit();
}
?>