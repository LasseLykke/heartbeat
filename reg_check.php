<?php
include("connection.php");

if (
    isset($_POST['uname']) && isset($_POST['password'])
    && isset($_POST['name']) && isset($_POST['re_password'])
) {
    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    $uname = validate($_POST['uname']);
    $password = validate($_POST['password']);

    $name = validate($_POST['name']);
    $re_password = validate($_POST['re_password']);

    $user_data = 'uname' . $uname . '&name=' . $name;

    if (empty($uname)) {
        header("Location: register.php?error=User name is required&$user_data");
        exit();
    } else if (empty($password)) {
        header("Location: register.php?error=Password is required&$user_data");
        exit();
    } else if (empty($name)) {
        header("Location: register.php?error=Name is required&$user_data");
        exit();
    } else if (empty($re_password)) {
        header("Location: register.php?error=Re_password is required&$user_data");
        exit();
    } else if ($password !== $re_password) {
        header("Location: register.php?error=The confirmation password  does not match&$user_data");
        exit();
    } else {
        $password = md5($password);
        $sql = "SELECT * FROM users WHERE user_name='$uname' ";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            header("Location: register.php?error=The user is taken Try another&$user_data");
            exit();
        } else {
            $sql2 = "INSERT INTO users(`user_name`, `password`, `name`) VALUES ('$uname','$password','$name')";
            $result2 = mysqli_query($conn, $sql2);
            if ($result2) {
                header("Location: register.php?success=Your account has been created successfully.");
                exit();

            } else {
                header("Location: register.php?error=Unknown error occurrd&$user_data");
                exit();
            }
        }
    }
} else {
    header("Location: register.php");
    exit();
}
?>