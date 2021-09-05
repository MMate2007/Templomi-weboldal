<html>
<head>
<title>Hirdetés törlése - Példa plébánia</title>
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
	top: 100px;
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
<h1>Példa plébánia honlapja - Hirdetés törlése</h1>
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
<div class="content">
<div class="tartalom">
<form name="delete1-hirdetes" action="delete.hirdetes.php" method="post">
<?php
$id = $_POST["hirdetes-id"];
if ($id == "N/A")
{
	header("Location: form.delete.hirdetes.php");
}
$mysql = mysqli_connect("localhost", "mysqlfelhasznalo", "mysqljelszo", "adatbazisnev") or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
mysqli_query($mysql, "SET NAMES utf8");
$sql = "SELECT `title`, `content` FROM `hirdetesek` WHERE `ID` = '".$id."'";
$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
$title = "Ismeretlen";
$content = "";
while ($row = mysqli_fetch_array($eredmeny))
{
	$title = $row["title"];
	$content = $row["content"];
}
mysqli_close($mysql);
?>
<p>Biztosan szeretné törölni ezt a hirdetést?</p>
<table class="form">
<tr>
<td><label>A kiválasztott hirdetés címe: </label></td>
<td><label><?php echo $title; ?></label></td>
</tr>
<tr>
<td><label>A kiválasztott hirdetés leírása: </label></td>
<td><label><?php echo $content; ?></label></td>
</tr>
<input type="hidden" name="id" value="<?php echo $id; ?>">
<tr>
<td><label></label></td>
<td><input type="submit" value="Törlés"><input type="button" value="Vissza" onclick="window.location.replace('form.delete.hirdetes.php');"><input type="button" value="Mégsem" onclick="window.location.replace('admin.php');"></td>
<td><label></label></td>
</tr>
</table>
</form>
</div>
</div>
<div class="sidebar">
</div>
<?php include("footer.php"); ?>
</body>
</html>