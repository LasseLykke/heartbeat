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
        <div class="centerImg">
        <img src="/img/logo.png" alt="logo" class="logo"></div>
        <h1 class="header">Heartbeat</h1>
    
    <?php /*Udgiver fejlmedelelse */
        if(isset($_GET['error'])) {?>
        <p class="error"><?php echo $_GET['error']; ?></p>

    <?php }?>

        <label for="">Brugernavn</label>
        <input type="text" name="uname" placeholder="Brugernavn"></br>
        <label for="">Password</label>
        <input type="password" name="password" placeholder="Password"></br>
        <button class="loginBtn" type="submit">Login</button><br>
        <a href="register.php" class="ca">Opret konto</a>
    </form>

    </div>
</body>
</html>