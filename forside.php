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
        <title>HEARTBEAT || FORSIDE</title>
        <link rel="shortcut icon" href="" type="image/x-icon"/>
    </head>

    <body>
    <div class="forsideWrapper">
        </nav>
        <div class="hello">
            <h1>Hej 
                <?php
                /* Trækker login bruger ind*/
                echo $_SESSION['name'];
                ?> 👋🏻</h1>
        </div>
        <div class="formContainer">
            <h2 class="formHeader"></h2>
            <a href="daily.php"><button class="formBtn">Daglig log</button></a>
            <a href="træningsForm.php"><button class="formBtn">Workout's</button></a>
        </div>
        
        
        <div class="dataContainer">
        <?php 
        $sql1 = "SELECT COUNT(workoutID) AS totalWorkouts FROM workout";
        $result1 = $conn->query($sql1);

        $sql2 = "SELECT COUNT(DISTINCT painDates) AS num_rows FROM pain WHERE painState = 'Ja'";
        $result2 = $conn->query($sql2);
        ?>
    
        <h2 class="formHeader">Summary:</h2>
        
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
        </div>

<!-- TEST AF LARGE CART. -->
            <div class="cartWrapper">
            <div class="cart-xs">
                <h3 class="cartheader">Alle statestikker</h3>
                <a href="dataOverview.php"><button class="cartBtn">
                <h1 class="cartNumber">
                
                </h1>
                </button></a>
            </div>

        </div> 
    </div> 
        <div class="footer">
            <a href="logout.php"><button class="signOut" alt="LogOut">Log ud</button></a>
                </div> 
        </div>
</body>

</html>

<?php
/* Hvis ikke logget ind bliver man sendt tilbage til login skærm */
} else {
    header("Location: index.php");
    exit();
}
?>