<html>
<head>
<meta charset="utf-8">
<meta name="title" content="Imádságok - Példa plébánia">
<title>Imádságok - Példa plébánia</title>
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
	top: 0px;
	left: 15px;
	right: 10px;
}
div.head-text h1 {font-size: 22pt;}
}
@media only screen and (min-width: 600px) {
div.head-text {
	position: absolute;
	top: 0px;
	left: 20px;
}
div.head-text h1 {font-size: 50pt;}
}
@media only screen and (min-width: 1349px) {
div.head-text {
	position: absolute;
	top: 25px;
	left: 80px;
}
}
div.fejlecparallax {
    background-image: url("misekonyv.jpg");
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
<h1>Példa plébánia honlapja - Imádságok</h1>
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
<?php
/*$mysql = mysqli_connect("localhost", "mysqlfelhasznalo", "mysqljelszo", "adatbazisnev") or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
mysqli_query($mysql, "SET NAMES utf8");
$sql = "SELECT `content` FROM `contents` WHERE `name` = 'imak.tartalom'";
$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
while ($row = mysqli_fetch_array($eredmeny))
{
	$content = $row["content"];
}
echo $content;
mysqli_close($mysql);*/
?>
<h2>Feltöltés alatt!</h2>
<p>Ez az oldal feltöltés alatt áll! Szíves türelmét kérjük!</p>
<p>Köszönjük!</p>
</div>
</div>
<div class="sidebar">
</div>
<?php include("footer.php"); ?>
</body>
</html>
