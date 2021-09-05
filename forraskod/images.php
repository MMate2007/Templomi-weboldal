<html>
<head>
<meta charset="utf-8">
<meta name="title" content="Képgaléria - Példa plébánia">
<title>Képgaléria - Példa plébánia</title>
<meta name="description" content="Ezen az oldalon képeket tekinthet meg a templomunkról és a kápolnánkról. Amennyiben Önnek is van egy jó képe küldje el a bszfilia@fabianistva.nhely.hu email címre!">
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
	left: 0px;
}
div.head-text h1 {font-size: 25pt;}
}
@media only screen and (min-width: 600px) {
div.head-text {
	position: absolute;
	top: 10px;
	left: 40px;
}
div.head-text h1 {font-size: 50pt;}
}
@media only screen and (min-width: 1349px) {
div.head-text {
	position: absolute;
	top: 50px;
	left: 100px;
}
}
div.fejlecparallax {
    background-image: url("keresztbarany.jpg");
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
<h1>Példa plébánia honlapja - Képgaléria</h1>
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
<h1>Képgaléria</h1>
<p><b>A képek kinagyításához, kérem, kattiontson a képekre!</b></p>
<img src="toronyegesz.jpg" id="nagyitas" style="max-width: 100%; display: none;">
<table class="kepek">
<tr>
<?php
$mysql = mysqli_connect("localhost", "mysqlfelhasznalo", "mysqljelszo", "adatbazisnev") or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
mysqli_query($mysql, "SET NAMES utf8");
$sql = "SELECT * FROM `kepek`";
$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
$oszlop = 1;
while ($row = mysqli_fetch_array($eredmeny))
{
	$src = $row["src"];
	$des = $row["description"];
	?>
	<td>
	<div class="kepek" id="<?php echo $oszlop; ?>">
	<img src="<?php echo $src; ?>" style="max-width: 100%; cursor: zoom-in;" onclick="document.getElementById('nagyitas').style.display = 'block'; document.getElementById('nagyitas').src = '<?php echo $src; ?>'; window.location.replace('images.php#nagyitas');">
	<label><?php if ($des != null) { echo $des; } ?></label>
	</div>
	</td>
	<?php
	if ($oszlop == 3)
	{
		?>
		</tr>
		<tr>
		<?php
		$oszlop = 0;
	}
	$oszlop++;
}
mysqli_close($mysql);
?>

</table>
</div>
</div>
<div class="sidebar">
</div>
<?php include("footer.php"); ?>
</body>
</html>