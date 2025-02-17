<?php 
session_start();
include 'header.php';
if (isset($_SESSION['user_id']) && isset($_SESSION['user_name'])) {

// Tjek om trænings-ID er med i URL'en
$workout_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="refresh" content="10.5; url=../import/workoutforms.php?id=<?php echo $workout_id; ?>" />
    <title>HEARTBEAT || SUCCESS</title>
    <link rel="shortcut icon" href="fav.ico" type="image/x-icon"/>
</head>
<body>
    <div class="success-wrapper">
        <div class="success-checkmark">
            <div class="check-icon">
                <span class="icon-line line-tip"></span>
                <span class="icon-line line-long"></span>
                <div class="icon-circle"></div>
                <div class="icon-fix"></div>
            </div>
        </div>
        <a href="../import/workoutforms.php?id=<?php echo $workout_id; ?>"> 
            <button class="successBtn">Tilbage til workouts</button>
        </a>
    </div>
</body>
</html>

<?php
} else {
    header("Location: /index.php");
    exit();
}
?>
