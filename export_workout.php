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

/* INDSÆT SQL */

}

mysqli_free_result($result);

// Close the database connection
mysqli_close($conn);
?>

        </div>

        <script>
var coll = document.getElementsByClassName("collapsible");
var i;

for (i = 0; i < coll.length; i++) {
  coll[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var content = this.nextElementSibling;
    if (content.style.maxHeight){
      content.style.maxHeight = null;
    } else {
      content.style.maxHeight = content.scrollHeight + "px";
    }
  });
}
</script>
</body>

</html>