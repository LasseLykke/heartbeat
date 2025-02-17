<?php
ob_start();
session_start();

if (isset($_SESSION['user_id']) && isset($_SESSION['user_name'])) {
    include '../header.php';
    require '../navbar.php';




    ob_end_flush();
    ?>


    <!DOCTYPE html>
    <html>

    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Logger ud efter 15min -->
        <meta http-equiv="refresh" content="1500;url=../logout.php" />
        <title>H E A R T B E A T || Work Out Forms </title>
    </head>

    <body>

        <?php
        // Viser success eller fejl meddelelse
        if (isset($_SESSION["message"])) {
            echo "<p>{$_SESSION["message"]}</p>";
            unset($_SESSION["message"]);
        }
        ?>




        <div class="wrapper">
            <section class="hbHeader">
                <h1 class="headerText">Workout</h1>
            </section>

            <section class="workoutData">
                <div class="dataCartLarge" id="workout-1">
                    <a href="importCykel.php">
                        <div class="dataBtn">
                            <div class="dataCartHeader">
                                <img src="../img/cykel.png" class="dataIcon" alt="workout icon">
                                <h2>Cykel</h2>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="dataCartLarge" id="workout-2">
                    <a href="importPulldowns.php">
                        <div class="dataBtn">
                            <div class="dataCartHeader">
                                <img src="../img/pullupdown.png" class="dataIcon" alt="workout icon">
                                <h2>Pulldown</h2>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="dataCartLarge" id="workout-3">
                    <a href="importRyg.php">
                        <div class="dataBtn">
                            <div class="dataCartHeader">
                                <img src="../img/ryg.png" class="dataIcon" alt="workout icon">
                                <h2>Rygbøjning</h2>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="dataCartLarge" id="workout-4">
                    <a href="importAbs.php">
                        <div class="dataBtn">
                            <div class="dataCartHeader">
                                <img src="../img/abs.png" class="dataIcon" alt="workout icon">
                                <h2>Abcrunch</h2>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="dataCartLarge" id="workout-5">
                    <a href="importBrystpress.php">
                        <div class="dataBtn">
                            <div class="dataCartHeader">
                                <img src="../img/brystpres.png" class="dataIcon" alt="workout icon">
                                <h2>Brystpres</h2>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="dataCartLarge" id="workout-6">
                    <a href="importLegpress.php">
                        <div class="dataBtn">
                            <div class="dataCartHeader">
                                <img src="../img/legpress.png" class="dataIcon" alt="workout icon">
                                <h2>Legpress</h2>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="dataCartLarge" id="workout-7">
                    <a href="importLegcurl.php">
                        <div class="dataBtn">
                            <div class="dataCartHeader">
                                <img src="../img/legpress.png" class="dataIcon" alt="workout icon">
                                <h2>Legcurl</h2>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="dataCartLarge" id="workout-8">
                    <a href="importLegextension.php">
                        <div class="dataBtn">
                            <div class="dataCartHeader">
                                <img src="../img/legpress.png" class="dataIcon" alt="workout icon">
                                <h2>Legextension</h2>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="dataCartLarge" id="workout-9">
                    <a href="importBiceps.php">
                        <div class="dataBtn">
                            <div class="dataCartHeader">
                                <img src="../img/biceps.png" class="dataIcon" alt="workout icon">
                                <h2>Biceps</h2>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="dataCartLarge" id="workout-10">
                    <a href="importTriceps.php">
                        <div class="dataBtn">
                            <div class="dataCartHeader">
                                <img src="../img/biceps.png" class="dataIcon" alt="workout icon">
                                <h2>Triceps</h2>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="dataCartLarge" id="workout-11">
                    <a href="importNeckpress.php">
                        <div class="dataBtn">
                            <div class="dataCartHeader">
                                <img src="../img/brystpres.png" class="dataIcon" alt="workout icon">
                                <h2>Neckpress</h2>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="dataCartLarge" id="workout-12">
                    <a href="importButtups.php">
                        <div class="dataBtn">
                            <div class="dataCartHeader">
                                <img src="../img/buttups.png" class="dataIcon" alt="workout icon">
                                <h2>Buttups</h2>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="dataCartLarge" id="workout-13">
                    <a href="importPullups.php">
                        <div class="dataBtn">
                            <div class="dataCartHeader">
                                <img src="../img/pullupdown.png" class="dataIcon" alt="workout icon">
                                <h2>Pullups</h2>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="dataCartLarge" id="workout-14">
                    <a href="importLøb.php">
                        <div class="dataBtn">
                            <div class="dataCartHeader">
                                <img src="../img/løb.png" class="dataIcon" alt="workout icon">
                                <h2>Løb</h2>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="dataCartLarge" id="workout-15">
                    <a href="importRyst.php">
                        <div class="dataBtn">
                            <div class="dataCartHeader">
                                <img src="../img/ryste.png" class="dataIcon" alt="workout icon">
                                <h2>Rystemaskine</h2>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="dataCartLarge" id="workout-16">
                    <a href="importVand.php">
                        <div class="dataBtn">
                            <div class="dataCartHeader">
                                <img src="../img/vand.png" class="dataIcon" alt="workout icon">
                                <h2>Vand</h2>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="dataCartLarge" id="workout-17">
                    <a href="importVægt.php">
                        <div class="dataBtn">
                            <div class="dataCartHeader">
                                <img src="../img/vægt.png" class="dataIcon" alt="workout icon">
                                <h2>Vægt</h2>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="dataCartLarge" id="workout-18">
                    <a href="importVarighed.php">
                        <div class="dataBtn">
                            <div class="dataCartHeader">
                                <img src="../img/dumbell.png" class="dataIcon" alt="workout icon">
                                <h2>Varighed</h2>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="dataCartLarge" id="workout-19">
                    <a href="importVærdi.php">
                        <div class="dataBtn">
                            <div class="dataCartHeader">
                                <img src="../img/dumbell.png" class="dataIcon" alt="workout icon">
                                <h2>Værdier</h2>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="dataCartLarge" id="workout-20">
                    <a href="importBemærkning.php">
                        <div class="dataBtn">
                            <div class="dataCartHeader">
                                <img src="../img/dumbell.png" class="dataIcon" alt="workout icon">
                                <h2>Bemærkninger</h2>
                            </div>
                        </div>
                    </a>
                </div>
            </section>

            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    setTimeout(function () {
                        // Hent workout ID fra URL'en
                        const urlParams = new URLSearchParams(window.location.search);
                        const workoutId = urlParams.get("id");

                        if (workoutId) {
                            const workoutElement = document.getElementById(`workout-${workoutId}`);
                            if (workoutElement) {
                                workoutElement.scrollIntoView({ behavior: "smooth", block: "start" });
                            }
                        }
                    }, 500); // 500ms forsinkelse
                });
            </script>

            <script src="../script.js"></script>

    </body>

    </html>
    <?php
    /* Hvis ikke logget ind bliver man sendt tilbage til login skærm */
} else {
    header("Location: /index.php");
    exit();
}
?>