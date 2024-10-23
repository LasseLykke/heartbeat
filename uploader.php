<?php
session_start();

// Tjek om brugeren er logget ind
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_name'])) {
    header("Location: index.php");
    exit();
}

if (isset($_POST['submit'])) {
    // Hent fildata fra $_FILES arrayet
    $file = $_FILES['file'];
    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $fileType = $_FILES['file']['type'];

    // Sørg for, at det kun er JPG, PNG og PDF, der kan uploades
    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));
    $allowed = array('jpg', 'jpeg', 'png', 'pdf');

    if (in_array($fileActualExt, $allowed)) {
        // Tjekker om der er fejl under upload
        if ($fileError === 0) {
            // Begrænser filstørrelse til 10MB
            if ($fileSize < 10000000) {
                // Giver filen et unikt navn for at undgå overlap
                $fileNameNew = uniqid('', true) . "." . $fileActualExt;
                $fileDestination = './uploads/' . $fileNameNew;
                
                // Flytter filen til uploads mappen
                if (move_uploaded_file($fileTmpName, $fileDestination)) {
                    // Success besked
                    $_SESSION['message'] = "Upload succesfuld!";
                    header("Location: success.php");
                } else {
                    $_SESSION['message'] = "Fejl under flytning af filen!";
                    header("Location: index.php?uploaderror");
                }
            } else {
                $_SESSION['message'] = "Din fil er for stor!";
                header("Location: index.php?uploaderror");
            }
        } else {
            $_SESSION['message'] = "Der skete en fejl i upload af din fil!";
            header("Location: index.php?uploaderror");
        }
    } else {
        $_SESSION['message'] = "Kan ikke uploade denne filtype!";
        header("Location: index.php?uploaderror");
    }
    exit();
}
