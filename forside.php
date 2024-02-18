<?php
session_start();


if (isset($_SESSION['user_id']) && isset($_SESSION['user_name'])) {

    include 'header.php';

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $workoutID = htmlspecialchars($_POST["workoutID"]); 
    } 

    $_SESSION['workoutID'] = $workoutID;
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
        <h2 class="formHeader">Data Summary:</h2>
        
        <div class="cartWrapper">
            <div class="cart">
                <h3>Workouts:</h3>
                <a href="painForm.php"><button class="cartBtn">
                <h1 class="test">
                    <?php 
                    echo $_SESSION['workoutID'];
                    ?>
                </h1>
                <p>-></p>
                </button></a>
            </div>

            <div class="cart">
                <h3>Workouts:</h3>
                <a href="painForm.php"><button class="cartBtn">
                <h1 class="test">55</h1>
                <p>-></p>
                </button></a>
            </div>

            <div class="cart">
                <h3>Workouts:</h3>
                <a href="painForm.php"><button class="cartBtn">
                <h1 class="test">55</h1>
                <p>-></p>
                </button></a>
            </div>
        </div>
            
        <!-- 
        <a href="træningsForm.php"><button class="cart">
                <h4 class="name">Workout's</h4>
                <p>data point</p></button></a>

            <a href="painForm.php"><button class="cart">
                <div class="name">
                    <h4>Workout's</h4>
                </div>
                <div class="data">
                    <p>data point</p>
                </div>
            </button></a>
-->
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