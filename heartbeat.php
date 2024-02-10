<?php 
include 'header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>H E A R T B E A T</title>
</head>
<body>
    <div class="loginWrapper">
    <form class="loginform" action="login.php" method="POST">
        <div class="centerLogo">
        <img src="/img/logo.png" alt="logo" class="logo"></div>
        <h1 class="header">Heartbeat</h1>
    
    <?php /*Udgiver fejlmedelelse */
        if(isset($_GET['error'])) {?>
        <p class="error"><?php echo $_GET['error']; ?></p>

    <?php }?>


    <div class="loginarea">
        <div class="user-name">
            <label for="">Brugernavn</label>
            <input type="text" name="uname" placeholder="Brugernavn">
        </div>
        <div class="user-pass">
            <label for="">Password</label>
            <input type="password" name="password" placeholder="Password">
        </div>
    </div>
    <button class="loginBtn" type="submit">Login</button><br>
        </form>
    </div>
     
</body>
</html>