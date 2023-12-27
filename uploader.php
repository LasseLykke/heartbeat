<?php

if (isset($_POST['submit'])) {
    $file = $_FILES['file'];

    /*Henter data fra Array*/
    $fileName = $_FILES['file'] ['name'];
    $fileTmpName = $_FILES['file'] ['tmp_name'];
    $fileSize = $_FILES['file'] ['size'];
    $fileError = $_FILES['file'] ['error'];
    $fileType = $_FILES['file'] ['type'];

    /*sørger for det kun er JPG, PNG og PDF der kan uploades*/
    $fileExt = explode('.', $fileName);
    /*Konvater filtype til lowercase, så PHP script kan læse det uanset om det er med stort eller småt*/
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array('jpg', 'jpeg', 'png', 'pdf');

    if(in_array($fileActualExt, $allowed)) {
        if ($fileError === 0) {
            if ($fileSize < 10000000) {
                $fileNameNew = uniqid('', true).".".$fileActualExt;
                $fileDestination = 'uploads/' .$fileNameNew;
                move_uploaded_file($fileTmpName, $fileDestination);
                /* Lav en success besked her istedet for alm header location*/
                header("Location: index.php?uploadsuccess");
            } else {
                echo "Din fil er for stor!";
            }
        } else {
            echo "Der skete en fejl i upload af din fil!";
        }
    } else {
        echo "Kan ikke uploade denne filtype";
    }
};
?>