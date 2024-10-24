<?php
ob_start();
session_start();
include '../header.php';

// Tjek om brugeren er logget ind
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_name'])) {
    header("Location: /index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Hent og rens input
    $navn = htmlspecialchars($_POST["navn"]);
    $fabrikant = htmlspecialchars($_POST["fabrikant"]);
    $type = htmlspecialchars($_POST["type"]);
    $milliliter = isset($_POST["milliliter"]) ? str_replace(',', '.', $_POST["milliliter"]) : 0.0;
    $milliliter = floatval($milliliter);
    $fabrikantBeskrivelse = htmlspecialchars($_POST["fabrikantBeskrivelse"]);
    $egneOrd = htmlspecialchars($_POST["egneOrd"]);
    $egnetTil = htmlspecialchars($_POST["egnetTil"]);
    $bedømmelse = intval($_POST["bedømmelse"]);
    $brugsfrekvens = intval($_POST["brugsfrekvens"]);

    // Håndter filupload
    $file = $_FILES['file'];
    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $fileType = $_FILES['file']['type'];

    // Tjek filtypen
    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));
    $allowed = array('jpg', 'jpeg', 'png', 'pdf');

    // Standard værdi for billedfil
    $fileNameNew = null;

    if (in_array($fileActualExt, $allowed)) {
        if ($fileError === 0) {
            if ($fileSize < 10000000) {
                $fileNameNew = uniqid('', true) . "." . $fileActualExt;
                $fileDestination = '../uploads/' . $fileNameNew;
                move_uploaded_file($fileTmpName, $fileDestination);
            } else {
                $_SESSION['message'] = "Din fil er for stor!";
                header("Location: /import/importDuft.php?error=filstor");
                exit();
            }
        } else {
            $_SESSION['message'] = "Der skete en fejl i upload af din fil!";
            header("Location: /import/importDuft.php?error=uploadfejl");
            exit();
        }
    } else {
        $_SESSION['message'] = "Kan ikke uploade denne filtype!";
        header("Location: /import/importDuft.php?error=filtype");
        exit();
    }

    // Start en transaktion
    $mysqli->begin_transaction();

    try {
        // Indsæt i perfumeLog tabellen
        $sql = "INSERT INTO perfumeLog (navn, fabrikant, type, milliliter, billede, fabrikantBeskrivelse, egneOrd, egnetTil, bedømmelse, brugsfrekvens) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $mysqli->prepare($sql);

        if ($stmt === false) {
            throw new Exception($mysqli->error);
        }

        $stmt->bind_param("ssssdssssi", $navn, $fabrikant, $type, $milliliter, $fileNameNew, $fabrikantBeskrivelse, $egneOrd, $egnetTil, $bedømmelse, $brugsfrekvens);
        $stmt->execute();

        // Luk statement
        $stmt->close();

        // Commit transaktionen
        $mysqli->commit();

        // Gå tilbage til bekræftelsessiden
        $_SESSION['message'] = "Parfume blev gemt succesfuldt!";
        header("Location: ../success.php");
        exit();
    } catch (Exception $e) {
        // Rul tilbage ved fejl
        $mysqli->rollback();
        die("Error: " . $e->getMessage());
    }
}
ob_end_flush();
?>

<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>H E A R T B E A T || PARFUME </title>
</head>

<body>
    <?php
    if (isset($_SESSION["message"])) {
        echo "<p>{$_SESSION["message"]}</p>";
        unset($_SESSION["message"]);
    }
    ?>

    <header>
        <button class="hamburger">
            <div class="bar"></div>
        </button>

        <nav class="mobile-nav">
            <a href="../forside.php">Forside</a>
            <a href="../import/importDaily.php">Daglig</a>
            <a href="../import/workoutforms.php">Workout</a>
            <a href="../export/dataOverview.php">Statestik</a>
            <a href="../import/importDuft.php">Duft</a>
            <a href="../logout.php">Log ud</a>
        </nav>
    </header>

    <div class="wrapper">
        <section class="hbHeader">
            <h1 class="headerText">Parfume</h1>
        </section>
        <form class="perfumeForm" action="importDuft.php" method="POST" enctype="multipart/form-data">
            <section class="formSection">
                <label for="navn">Parfumens navn:</label>
                <input type="text" id="navn" name="navn" placeholder="Navn:" required>

                <label for="fabrikant">Fabrikant:</label>
                <input type="text" id="fabrikant" name="fabrikant" placeholder="Fabrikant:" required>

                <label for="type">Parfumetype:</label>
                <select id="type" name="type" required>
                    <option value="EDT">EDT</option>
                    <option value="EDP">EDP</option>
                    <option value="Stick">Stick</option>
                </select>

                <label for="milliliter">Milliliter:</label>
                <input type="text" id="milliliter" name="milliliter" placeholder="Flaskestørrelse (ml):">

                <label for="billede">Billede URL:</label>
                <input type="file" id="file" name="file" placeholder="Billede URL:" required>

                <label for="fabrikantBeskrivelse">Fabrikantens beskrivelse:</label>
                <textarea id="fabrikantBeskrivelse" name="fabrikantBeskrivelse" placeholder="Beskrivelse:"></textarea>

                <label for="egneOrd">Dine egne ord:</label>
                <textarea id="egneOrd" name="egneOrd" placeholder="Dine egne ord om parfumen:"></textarea>

                <label for="egnetTil">Egnet til:</label>
                <select id="egnetTil" name="egnetTil" required>
                    <option value="Daglig">Dag</option>
                    <option value="Sommer">Sommer</option>
                    <option value="Efterår">Efterår</option>
                    <option value="Vinter">Vinter</option>
                    <option value="Fest">Fest</option>
                </select>

                <label for="bedømmelse">Bedømmelse (1-5):</label>
                <input type="number" id="bedømmelse" name="bedømmelse" min="1" max="5" required>

                <label for="brugsfrekvens">Brugsfrekvens (1-10):</label>
                <input type="number" id="brugsfrekvens" name="brugsfrekvens" min="1" max="10" required>
            </section>

            <section>
                <button class="submit" name="submit">Gem Parfume</button>
            </section>
        </form>
    </div>

    <script src="../script.js"></script>
</body>

</html>
