<?php
session_start();
include("connection.php");

if (isset($_POST['uname']) && isset($_POST['password'])) {

    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;

    }
    $uname = validate($_POST['uname']);
    $pass = validate($_POST['password']);

    if (empty($uname)) {
        header("location: index.php?error=Brugernavn er påkrævet");
        exit();
    } else if (empty($pass)) {
        header("location: index.php?error=Password er påkrævet");
        exit();
    } else {
        $pass = md5($pass);
        $sql = "SELECT * FROM users WHERE user_name='$uname' AND password='$pass'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            if ($row['user_name'] === $uname && $row['password'] === $pass) {
                $_SESSION['user_name'] = $row['user_name'];
                $_SESSION['name'] = $row['name'];
                $_SESSION['users_id'] = $row['users_id'];
                header("Location: forside.php"); /*sender bruger til velkommen siden.*/
                exit();
            } else {
                header("Location: index.php?error=Forkert brugernavn eller password");
                exit();
            }
        } else {
            header("Location: index.php?error=Forkert brugernavn eller password");
            exit();
        }

    }

} else {
    header("Location: index.php");
    exit();
}