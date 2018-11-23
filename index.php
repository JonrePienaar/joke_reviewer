<?php

// I ran the init.sql in PHPmyadmin because it still gives me a syntax error even though there isn't any.s

require("header.php");

if($_SESSION['login'] == true){
    header("location: jokes.php");
}

if(isset($_POST["submit"])) {
    if(!empty($_POST["email"]) && !empty($_POST["password"])){
        $_SESSION["email"] = $_POST["email"];
        $_SESSION["password"] = $_POST["password"];

        connect_login();
    } else {
        echo "Pleae enter a name and password.";
    }
}

?>

<h1>Login</h1>

<form action="index.php" method="POST">
<input type="text" name="email" value="" placeholder="">
<input type="password" name="password" value="" placeholder=""">
<input type="submit" value="submit" name="submit">




</form>

<?php require "footer.php"; ?>