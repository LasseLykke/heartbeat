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
            <a href="painForm.php"><button class="submit">Hovedpine Form</button></a>
            <a href="træningsForm.php"><button class="submit">Workout Form</button></a>
        </div>
        
        <div class="dataContainer">
            <h2 class="formHeader">Data Summary:</h2>
        <a href="painForm.php"><button class="submit">Hovedpine</button></a>
        <a href="painForm.php"><button class="submit">Workouts</button></a>
        <a href="painForm.php"><button class="submit">Hovedpine X Workout</button></a>
        </div>
                <footer>
            <nav class="nav">
            <a href="logout.php"><button class="signOut" alt="LogOut">Log ud</button>
        </a>
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