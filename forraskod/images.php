<?php ob_start(); ?>
<html>
<head>
<?php include("head.php"); ?>
<meta name="title" content="Képgaléria - <?php echo $sitename; ?>">
<title>Képgaléria - <?php echo $sitename; ?></title>
<meta name="description" content="Ezen az oldalon képeket tekinthet meg a templomunkról és a kápolnánkról. Amennyiben Önnek is van egy jó képe küldje el a <?php echo getsetting($mysql, 'main.email'); ?> email címre!">
<meta name="language" content="hu-HU">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
header nav a[href="http://<?php echo $_SERVER['HTTP_HOST']; echo htmlspecialchars($_SERVER['PHP_SELF']);?>"], nav a[href="http://<?php echo $_SERVER['HTTP_HOST']; echo htmlspecialchars($_SERVER['PHP_SELF']);?>"] {font-weight: bold;}

div.fejlecparallax {
    background-image: url("ablakuveg.jpg");
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
<h1><?php echo $sitename; ?> honlapja - Képgaléria</h1>
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

?>

</table>
</div>
</div>
<div class="sidebar">
</div>
<?php include("footer.php"); ?>
</body>
</html>