<html>
<head>
<meta charset="utf-8">
<meta name="title" content="Kápolnánkról - Példa plébánia">
<title>Kápolnánkról - Példa plébánia</title>
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
	left: 10px;
}
div.head-text h1 {font-size: 25pt;}
}
@media only screen and (min-width: 600px) {
div.head-text {
	position: absolute;
	top: 5px;
	left: 30px;
}
div.head-text h1 {font-size: 55pt;}
}
@media only screen and (min-width: 1349px) {
div.head-text {
	position: absolute;
	top: 40px;
	left: 100px;
}
}
</style>
</head>
<body>
<header>
<div class="head">
<!--<img class="head" src="fejlec.jpg" style="width: 100%;">-->
<img class="head" src="kapolna.jpg" style="width: 100%;">
<div class="head-text">
<h1>Példa plébánia honlapja - Kápolnánkról</h1>
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
$sql = "SELECT `content` FROM `contents` WHERE `name` = 'kapolna.tartalom'";
$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
while ($row = mysqli_fetch_array($eredmeny))
{
	$content = $row["content"];
}
echo $content;
mysqli_close($mysql);*/
?>
<h1>Kápolnánkról</h1>
<p>Feltöltés alatt! Szíves türelmét kérjük!</p>
<p>Köszönjük!</p>
</div>
</div>
<div class="sidebar">
</div>
<?php include("footer.php"); ?>
</body>
</html>
