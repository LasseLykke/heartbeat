<?php 
session_start();
include 'header.php';

// Enable error reporting for development
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Function to sanitize and validate input
function sanitizeInput($input) {
    // Trim whitespace
    $input = trim($input);
    // Remove HTML and PHP tags
    $input = strip_tags($input);
    // Escape special characters to prevent SQL injection
    $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
    return $input;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Henter data fra form og trækker det over i db via POST
    $dates = sanitizeInput($_POST["dato"]);
    $sværhedsgrad = sanitizeInput($_POST["sværhedsgrad"]);
    $type = sanitizeInput($_POST["type"]);
    $bemærkning = sanitizeInput($_POST["bemærkning"]);
}

$mysqli->begin_transaction();

// Definere SQL queries som placeholder for hver table
$sql ="INSERT INTO pain (dates, sværhedsgrad, type, bemærkning) VALUES (?,?,?,?)";

// Laver en forberedende statement for hver query
$stmt = $mysqli->prepare($sql);

if ($stmt === false) {
    die("Error: " . $mysqli->error);
}

// Binder parameter og values sammen.
$stmt->bind_param("siss", $dates, $sværhedsgrad, $type, $bemærkning);

// Error check 
if ($stmt->errno) {
    $mysqli->rollback();
    die("Error: " . $stmt->error);
}

$mysqli->commit();

// lukker statements og forbindelse til database.
$stmt->close();
$mysqli->close();



?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>H E A R T B E A T || Pain </title>  <!-- Også det filen hedder -->
    </head>
    <body>

    <?php
// Viser success eller fejl meddelelse
if (isset($_SESSION["message"])) {
    echo "<p>{$_SESSION["message"]}</p>";
    unset($_SESSION["message"]);
} 
?>

        <h1>Pain header</h1>

    </body>
</html>