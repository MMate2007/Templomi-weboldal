<html>
<head>
<title>Liturgiák rendje - Példa plébánia</title>
<meta charset="utf-8">
<meta name="title" content="Liturgiák rendje - Példa plébánia">
<meta name="language" content="hu-HU">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="style.css">
<link rel="icon" type="image/pnp" href="icon.png">
<!--<meta name="theme-color" content="#ffea00">-->
<style>
	header nav a[href="http://<?php echo $_SERVER['HTTP_HOST']; echo $_SERVER['PHP_SELF'];?>"], nav a[href="http://<?php echo $_SERVER['HTTP_HOST']; echo $_SERVER['PHP_SELF'];?>"] {font-weight: bold;}
@media only screen and (min-width: 1349px) {
div.head-text {
	position: absolute;
	top: 25px;
	left: 10px;
}
}
@media only screen and (max-width: 600px) {
div.head-text {
	position: absolute;
	top: 3px;
	left: 0px;
}
div.head-text h1 {font-size: 20pt;}
}
@media only screen and (min-width: 600px) {
div.head-text {
	position: absolute;
	top: 20px;
	left: 20px;
}
div.head-text h1 {font-size: 35pt;}
}
div.fejlecparallax {
    background-image: url("oltarfeszulet.jpg");
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
<h1>Példa plébánia honlapja - Liturgiák rendje</h1>
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
<div class="miserend">
<h2>Liturgiák rendje</h2>
<table>
<tr>
<th>Időpont</th>
<th>Megnevezés</th>
<th>Hely</th>
</tr>
<?php
$mysql = mysqli_connect("localhost", "mysqlfelhasznalo", "mysqljelszo", "adatbazisnev") or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
mysqli_query($mysql, "SET NAMES utf8");
$sql = "SELECT `date`, `name`, `place` FROM `szertartasok` ORDER BY `date`";
$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
while ($row = mysqli_fetch_array($eredmeny))
{
	$date = $row["date"];
	$d = substr($date, 0, 16);
	$name = $row["name"];
	$place = $row["place"];
	?>
	<tr>
	<td><?php echo $d;?></td>
	<td><?php echo $name;?></td>
	<td><?php echo $place;?></td>
	</tr>
	<?php
}
mysqli_close($mysql);
?>
</table>
</div>
</div>
</div>
<div class="sidebar">
</div>
<?php include("footer.php"); ?>
</body>
</html>
