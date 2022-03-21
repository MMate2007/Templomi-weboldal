<html>
<head>
<meta charset="utf-8">
<meta name="title" content="Templomunkról - Példa plébánia">
<title>Templomunkról - Példa plébánia</title>
<meta name="language" content="hu-HU">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="style.css">
<link rel="icon" type="image/pnp" href="icon.png">
<!--<meta name="keywords" content="">-->
<!--<meta name="theme-color" content="#ffea00">-->
<style>
header nav a[href="http://<?php echo $_SERVER['HTTP_HOST']; echo $_SERVER['PHP_SELF'];?>"], nav a[href="http://<?php echo $_SERVER['HTTP_HOST']; echo $_SERVER['PHP_SELF'];?>"] {font-weight: bold;}
@media only screen and (max-width: 800px) {
div.head-text {
	position: absolute;
	top: 10px;
	left: 0px;
}
div.head-text h1 {font-size: 27pt;}
}
@media only screen and (min-width: 600px) {
div.head-text {
	position: absolute;
	top: 60px;
	left: 0px;
	right: 220px;
}
div.head-text h1 {font-size: 45pt;}
}
@media only screen and (min-width: 1349px) {
div.head-text {
	position: absolute;
	top: 100px;
	left: 100px;
}
}
</style>
</head>
<body>
<header>
<div class="head">
<img class="head" src="templom.jpg" style="width: 100%;">
<div class="head-text">
<h1>Példa plébánia honlapja - Templomunkról</h1>
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
<?php
/*$mysql = mysqli_connect("localhost", "mysqlfelhasznalo", "mysqljelszo", "adatbazisnev") or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
mysqli_query($mysql, "SET NAMES utf8");
$sql = "SELECT `content` FROM `contents` WHERE `name` = 'history.tartalom'";
$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
while ($row = mysqli_fetch_array($eredmeny))
{
	$content = $row["content"];
}
echo $content;
mysqli_close($mysql);*/
?>
<h1>A templomunkról</h1>
<p>Feltöltés alatt áll. Szíves türelmét kérjük!</p>
<p>Köszönjük!</p>
</div>
<div class="infok">
<h2>Néhány adat</h2>
<?php
/*$mysql = mysqli_connect("localhost", "mysqlfelhasznalo", "mysqljelszo", "adatbazisnev") or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
mysqli_query($mysql, "SET NAMES utf8");
$sql = "SELECT `content` FROM `contents` WHERE `name` = 'history.adatok'";
$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
while ($row = mysqli_fetch_array($eredmeny))
{
	$content = $row["content"];
}
echo $content;
mysqli_close($mysql);*/
?>
<table class="infok">
<tbody><tr>
<th>Plébános:</th>
<td></td>
</tr>
<tr>
<th>Védőszent:</th>
<td></td>
</tr>
<tr>
<th>Búcsú:</th>
<td></td>
</tr>
</tbody></table>
</div>
<div class="sidebar">
</div>
<?php include("footer.php"); ?>
</body>
</html>
