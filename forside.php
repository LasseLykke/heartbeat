<?php
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
            <h2 class="formHeader">Forms:</h2>
            <a href="painForm.php"><button class="formBtn">Hovedpine Form</button></a>
            <a href="træningsForm.php"><button class="formBtn">Workout Form</button></a>
        </div>
        
        
        <div class="dataContainer">
        <?php 
        $sql1 = "SELECT workoutID FROM workout";
        $result1 = $conn->query($sql1);

        $sql2 = "SELECT COUNT(*) AS num_rows FROM pain WHERE painState = 'Ja'";
        $result2 = $conn->query($sql2);
        ?>
    
        <h2 class="formHeader">Data Summary:</h2>
        
        <div class="cartWrapper">
            <div class="cart">
                <h3 class="cartheader">Workouts:</h3>
                <a href="træningsform.php"><button class="cartBtn">
                <h1 class="test">
                    <?php 
                    if ($result1->num_rows > 0) {
                        // Display workoutID
                            $row1 = $result1->fetch_assoc();
                            echo "<div id='cartBtn'>";
                            echo "<h3>" . $row1["workoutID"] . "</h3>";
                            echo "</div>";
                        } else {
                            echo "0";
                        }
                    ?>
                </h1>
                </button></a>
            </div>


            <div class="cart">
                <h3 class="cartheader">Hovedpine:</h3>
                <a href="painForm.php"><button class="cartBtn">
                <h1 class="test">
                    <?php 
                    if ($result2->num_rows > 0) {
                        $row2 = $result2->fetch_assoc();
                        $count = $row2['num_rows'];
                    
                        // Display the count
                        echo "<div id='cart'>";
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
            
        </div>
                <footer>
            <nav class="nav">
            <a href="logout.php"><button class="signOut" alt="LogOut">Log ud</button>
        </a>
            </nav>
        </footer>
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