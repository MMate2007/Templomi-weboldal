<html>
<head>
<title>Felhasználó létrehozása - Példa plébánia</title>
<meta charset="utf-8">
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
<h1>Példa plébánia honlapja - Felhasználó létrehozása</h1>
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
if ($_SESSION["admin"] == 0)
{
	header("Location: admin.php");
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
<div class="content">
<div class="tartalom">
<form name="create-user" action="create.user.php" method="post">
<table>
<tr>
<td><label>Felhasználónév:</label></td>
<td><input type="text" name="username"></td>
<td><label>Rövid, könnyen megjegyezhető név. Pl.: gipszjakab7</label></td>
</tr>
<tr>
<td><label>Megjelenítendő név:</label></td>
<td><input type="text" name="name"></td>
<td><label>Ez a név jelenik majd meg a blogbejegyzések mellett szerzőként. Pl.: Gipsz Jakab.</label></td>
</tr>
<tr>
<td><label>Jelszó:</label></td>
<td><input type="password" name="password"></td>
<td><label>Nehezen kitalálható, viszont megjegyezhető jelszó. Jó, ha tartalmaz kis- és nagybetűket, számokat és írásjeleket. Ezt a jelszót jegyezzük fel! Pl.: JakabG19'.</label></td>
</tr>
<tr>
<td><label>Adminisztrátor?</label></td>
<td><input type="radio" name="admin" value="1" id="igen"><label for="igen">Igen</label><input type="radio" name="admin" value="0" id="nem" checked><label for="nem">Nem</label></td>
<td><label>Az adminisztrátor létrehozhat felhasználókat, illetve blogbejegyzéseket tölthet fel más helyett, más nevében.</label></td>
</tr>
<tr>
<td><label></label></td>
<td><input type="submit" value="Létrehozás"></td>
<td><label></label></td>
</table>
</form>
</div>
</div>
<div class="sidebar">
</div>
<?php include("footer.php"); ?>
</body>
</html>