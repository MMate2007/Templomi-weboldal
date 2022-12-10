<html>
<head>
<?php include("head.php"); ?>
<title>Bejelentkezés - <?php echo $sitename; ?></title>

<meta name="title" content="Bejelentkezés - <?php echo $sitename; ?>">
<meta name="description" content="Bejelentkezés után szerkeszteni tudja az oldal bizonyos pontjait. Ha Ön is szeretne segíteni a weboldal jobbá tételében írjon a <?php echo getsetting($mysql, 'main.email'); ?> e-mail címre!">
<meta name="language" content="hu-HU">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
header nav a[href="http://<?php echo $_SERVER['HTTP_HOST']; echo htmlspecialchars($_SERVER['PHP_SELF']);?>"], nav a[href="http://<?php echo $_SERVER['HTTP_HOST']; echo htmlspecialchars($_SERVER['PHP_SELF']);?>"] {font-weight: bold;}

div.fejlecparallax {
    background-image: url("<?php echo getsetting($mysql, 'picture.login'); ?>'");
}
</style>
</head>
<body>
<header>
<div class="head">
<!--<img class="head" src="fejlec.jpg" style="width: 100%;">-->
<!--<img class="head" src="fejlecvekony.jpg" style="width: 100%;">-->
<div class="fejlecparallax">
<div class="head-text">
<h1><?php echo $sitename; ?> honlapja - Bejelentkezés</h1>
</div>
</div>
</div>
<hr>
<nav>
<?php include("navbar.php"); ?>
</nav>
<hr>
</header>
<div class="content">
<div class="tartalom">
<p>Ha szeretné szerkeszteni a weboldal tartalmát kérem jelentkezzen be az alábbi űrlap segítségével!</p>
<form name="login" action="#" method="post">
<?php
if (isset($_POST["username"]) && isset($_POST["pass"]))
{
    //FIXME corret() függvény beépítése a bemenet ellenőrzésére
    //TODO check() függvén beépítése a bemenet ellenőrzésére
    //FIXME ellenőrizzük, hogy a szükséges mezőket kitöltötték-e
    displaymessage();
    $username = correct($_POST["username"]);
    $pass = sha1(md5($_POST["pass"]));
    $usernamevalid = false;
    $sql = "SELECT * FROM `author` WHERE `username` = '".$username."'";
    $eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
    while ($row = mysqli_fetch_array($eredmeny))
    {
        $usernamevalid = true;
        $pass2 = $row["password"];
        $id = $row["id"];
        $name = $row["name"];
        $admin = $row["szint"];
        $egyhsz = $row["egyhaziszint"];
        if ($admin == null)
        {
            ?>
            <p class="warning">Az Ön fiókját törölték, ezért nem léphet be. Ha ezzel nem ért egyet, kérem, keresse a rendszergazdát!</p>
            <?php
        }else if ($pass == $pass2)
        {
            
            $_SESSION["userId"] = $id;
            $_SESSION["name"] = $name;
            $_SESSION["szint"] = $admin;
            $_SESSION["egyhszint"] = $egyhsz;
            header("Location: admin.php");
        }else{
            ?>
            <p class="warning">Helytelen jelszó!</p>
            <input type="hidden" name="username" value="<?php echo $username; ?>">
            <?php
        }
    }
    if ($usernamevalid == false)
    {
        ?>
        <p class="warning">Helytelen felhasználónév!</p>
        <?php
    }
}
?>
<table class="form">
<tr>
<td><label>Felhasználónév: </label></td>
<td><input type="text" name="username" <?php if (isset($_POST["username"])): ?>value="<?php echo correct($_POST["username"]); ?>"<?php endif ?> required autofocus></td>
</tr>
<tr>
<td><label>Jelszó: </label></td>
<td><input type="password" name="pass" required></td>
</tr>
<tr>
<td><label></label></td>
<td><input type="submit" value="Bejelentkezés"></td>
</tr>
</table>
</form>
</div>
</div>
<?php

if (isset($_SESSION["userId"]))
{
	header("Location: admin.php");
}
?>
<div class="sidebar">
</div>
<?php include("footer.php"); ?>
</body>
</html>