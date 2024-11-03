<?php
ob_start();
session_start();

if (isset($_SESSION['user_id']) && isset($_SESSION['user_name'])) {
    include '../header.php';
    require '../navbar.php';
?>

<!DOCTYPE html>
<html lang="da">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="1500;url=../logout.php" />
    <title>H E A R T B E A T || PARFUME FORM</title>
</head>
<body>

<?php
if (isset($_SESSION["message"])) {
    echo "<p>" . htmlspecialchars($_SESSION["message"]) . "</p>";
    unset($_SESSION["message"]);
}
?>

<!-- Wrapper til indhold -->
<div class="wrapper">
<?php
if (isset($_GET['parfumeID'])) {
    $perfumeId = intval($_GET['parfumeID']); // Konverter ID til heltal for sikkerhed

    // Opdater SQL-forespørgslen til at inkludere fabrikantBeskrivelse, egneOrd og egnetTil
    $sql = "SELECT navn, fabrikant, type, milliliter, bedømmelse, brugsfrekvens, billede, fabrikantBeskrivelse, egneOrd, egnetTil FROM perfumeLog WHERE parfumeID = $perfumeId";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $perfume = mysqli_fetch_assoc($result);

        echo '<div class="product-header">';
        echo '<h1>' . htmlspecialchars($perfume['navn']) . '</h1>';
        echo '<p class="brand">' . htmlspecialchars($perfume['fabrikant']) . '</p>';
        echo '</div>';

        echo '<div class="product-content">';
        if (!empty($perfume['billede'])) {
            $billedeSti = '../uploads/' . htmlspecialchars($perfume['billede']);
            echo '<div class="product-image">';
            echo '<img src="' . $billedeSti . '" alt="' . htmlspecialchars($perfume['navn']) . '">';
            echo '</div>';
        } else {
            echo '<p>Billede ikke tilgængeligt</p>';
        }
        echo '</div>';

        echo '<div class="product-details">';
        
        echo '<div class="detail-item"><h4>Type:</h4><p>' . htmlspecialchars($perfume['type']) . '</p></div>';
        echo '<div class="detail-item"><h4>Størrelse:</h4><p>' . (int)$perfume['milliliter'] . ' ml</p></div>';
        echo '<div class="detail-item"><h4>Holdbarhed:</h4><p>' . htmlspecialchars($perfume['brugsfrekvens']) . ' timer</p></div>';
        echo '<div class="detail-item"><h4>Egnet til:</h4><p>' . htmlspecialchars($perfume['egnetTil']) . '</p></div>';
        echo '<div class="detail-item"><h4>Bedømmelse:</h4><p>' . htmlspecialchars($perfume['bedømmelse']) . ' / 5</p></div>';

        echo '</div>';

        echo '<div class="product-description">';
        echo '<h4>Fabrikantbeskrivelse:</h4><p>' . htmlspecialchars($perfume['fabrikantBeskrivelse']) . '</p> <br>';
        echo '<h4>Mine egne ord:</h4><p>' . htmlspecialchars($perfume['egneOrd']) . '</p></div>';
        echo '</div>';
    } else {
        echo '<p>Parfume ikke fundet.</p>';
    }
} else {
    echo '<p>Ingen parfume valgt.</p>';
}
?>


</div>

<script src="../script.js"></script>
</body>
</html>

<?php
} else {
    header("Location: /index.php");
    exit();
}
?>
