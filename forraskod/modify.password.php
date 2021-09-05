<html>
<head>
<meta charset="utf-8">
<title>Módosítás...</title>
<meta name="language" content="hu-HU">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="style.css">
<link rel="icon" type="image/pnp" href="icon.png">
<!--<meta name="theme-color" content="#ffea00">-->

<style>
	header nav a[href="http://<?php echo $_SERVER['HTTP_HOST']; echo $_SERVER['PHP_SELF'];?>"], nav a[href="http://<?php echo $_SERVER['HTTP_HOST']; echo $_SERVER['PHP_SELF'];?>"] {font-weight: bold;}
@media only screen and (max-width: 800px) {
div.head-text {
	position: absolute;
	top: 10px;
	left: 30px;
}
div.head-text h1 {font-size: 20pt;}
}
@media only screen and (min-width: 600px) {
div.head-text {
	position: absolute;
	top: 10px;
	left: 50px;
}
div.head-text h1 {font-size: 72pt;}
}
@media only screen and (min-width: 1349px) {
div.head-text {
	position: absolute;
	top: 25px;
	left: 100px;
}
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
<h1>Példa plébánia honlapja - Jelszó módosítása...</h1>
</div>
</div>
</div>
<hr>
<nav>
<?php include("navbar.php"); ?>
<?php
session_start();
if (!isset($_SESSION["userId"]))
{
	header("Location: hozzaferes.php");
}
$mysql = mysqli_connect("localhost", "mysqlfelhasznalo", "mysqljelszo", "adatbazisnev") or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
mysqli_query($mysql, "SET NAMES utf8");
$sql = "SELECT `name` FROM `author` WHERE `id` = '".$_SESSION["userId"]."'";
$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
while ($row = mysqli_fetch_array($eredmeny))
{
	$name = $row["name"];
	if ($name != $_SESSION["name"])
	{
		mysqli_close($mysql);
		header("Location: hozzaferes.php");
	}
}
mysqli_close($mysql);
?>
<a href="logout.php" class="right">Kijelentkezés</a>
<a href="form.create.hirdetes.php" class="right">Hirdetés létrehozása</a>
<a href="form.create.szertartas.php" class="right">Liturgia hozzáadása</a>
<a href="admin.php" class="right" id="right-elso">Adminisztráció</a>
</nav>
<hr>
</header>
<?php
$pass1 = sha1(md5($_POST["pass1"]));
$pass2 = sha1(md5($_POST["pass2"]));
$sqlpass = "mysqljelszo";
if ($pass1 != $pass2)
{
	$sqlpass = "";
	?>
	<script>
	alert("A két jelszó nem egyezik! Kérem próbálja újra!");
	window.location.replace("form.modify.password.php");
	</script>
	<?php
}else{
$mysql = mysqli_connect("localhost", "filia", $sqlpass, "filia");
mysqli_query($mysql, "SET NAMES utf8");
$sql = "UPDATE `author` SET `password`= '".$pass1."' WHERE `id` = '".$_SESSION["userId"]."'";
$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
mysqli_close($mysql);}
?>
<div class="content">
<div class="tartalom">
<?php
if ($eredmeny == true)
{
	?>
	<p class="succes">Sikeres jelszó módosítás!</p>
	<?php
	header("Location: logout.php");
}else{
	?>
	<p class="warning">Valami hiba történt!</p>
	<p>Kérem, próbálja újra!</p>
	<?php
}
?>
</div>
</div>
<div class="sidebar">
</div>
<?php include("footer.php"); ?>
</body>
</html>