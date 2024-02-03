<?php 
session_start();
if (isset($_SESSION['user_id']) && isset($_SESSION['user_name'])) {

include 'header.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>



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
    <a href="forside.php"> <button class="successBtn">Tilbage til forsiden</button></a>
    </div>

    <script>
        $("button").click(function () {
  $(".check-icon").hide();
  setTimeout(function () {
    $(".check-icon").show();
  }, 10);
});
    </script>
</body>

</html>
<?php
/* Hvis ikke logget ind bliver man sendt tilbage til login skærm */
} else {
    header("Location: forside.php");
    exit();
}
?>