<?php ob_start(); ?>
<!DOCTYPE html>
<html>
<head>
<?php include("head.php"); ?>
<meta name="title" content="Képgaléria - <?php echo $sitename; ?>">
<title>Képgaléria - <?php echo $sitename; ?></title>
<meta name="description" content="Ezen az oldalon képeket tekinthet meg a templomunkról és a kápolnánkról. Amennyiben Önnek is van egy jó képe küldje el a <?php echo getsetting('main.email'); ?> email címre!">
<meta name="language" content="hu-HU">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
	#galeria.carousel-item img {  
  object-fit: contain;
  object-position: center;
  overflow: hidden;
  height:50vh;
}
nav#desktop {
	background: linear-gradient(rgba(0,0,0,1), rgba(0,0,0,0.0));
}
</style>
</head>
<body>
<header>
<?php include("navbar.php"); ?>
</header>
<main>
<div class="carousel slide carousel-fade" data-bs-ride="carousel" id="galeria">
<div class="carousel-inner">
<?php
$sql = "SELECT * FROM `kepek`";
$elso = true;
$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
while ($row = mysqli_fetch_array($eredmeny))
{
	$src = $row["src"];
	$des = $row["description"];
	?>
	<div class="carousel-item <?php if ($elso == true) { echo "active"; $elso = false; } ?>" style="height: 100% !important;">
		<img src="img/<?php echo $src; ?>" alt="<?php echo $des; ?>" class="d-block" style="height: 100% !important; width: 100% !important; overflow-x: hidden;">
		<div class="carousel-caption d-none d-md-block">
			<p><?php echo $des; ?></p>
		</div>
	</div>
	<?php
}
?>
</div>
<button class="carousel-control-prev" type="button" data-bs-target="#galeria" data-bs-slide="prev">
<span class="carousel-control-prev-icon" aria-hidden="true"></span>
<span class="visually-hidden">Previous</span>
</button>
<button class="carousel-control-next" type="button" data-bs-target="#galeria" data-bs-slide="next">
<span class="carousel-control-next-icon" aria-hidden="true"></span>
<span class="visually-hidden">Next</span>
</button>
</div>
</main>
<?php include("footer.php"); ?>
</body>
</html>