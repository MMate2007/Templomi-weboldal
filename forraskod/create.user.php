<?php ob_start(); ?>
<html>
<head>
<?php include("head.php"); ?>
<title>Létrehozás...</title>
<meta name="language" content="hu-HU">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
	header nav a[href="http://<?php echo $_SERVER['HTTP_HOST']; echo htmlspecialchars($_SERVER['PHP_SELF']);?>"], nav a[href="http://<?php echo $_SERVER['HTTP_HOST']; echo htmlspecialchars($_SERVER['PHP_SELF']);?>"] {font-weight: bold;}
</style>
</head>
<body>
<header>
<div class="head">
<!--<img class="head" src="fejlec.jpg" style="width: 100%;">-->
<!--<img class="head" src="fejlecvekony.jpg" style="width: 100%;">-->
<div class="fejlecparallax">
<div class="head-text">
<h1><?php echo $sitename; ?> honlapja - Felhasználó létrehozása...</h1>
</div>
</div>
</div>
<hr>
<nav>
<?php include("navbar.php"); ?>
<?php

include("headforadmin.php");
if ($_SESSION["szint"] != 10)
{
	header("Location: admin.php");
}

?>

</nav>
<hr>
</header>
<?php

$sql = "SELECT `id` FROM `author`";
$id = 0;
$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
while ($row = mysqli_fetch_array($eredmeny))
{
	$_id = $row['id'];
	$id = $_id + 1;
}

if ($_POST["password"] == $_POST["password2"])
{
	//TODO űrlapon feltüntetni, hogy a felhasználónév milyen karakterekből állhat
	//TODO űrlapok összevonása az action lapokkal, tehát egy fájl legyen a most 2 fájl
$sql = "INSERT INTO `author`(`id`, `name`, `password`, `username`, `szint`, `egyhaziszint`) VALUES ('".$id."','".correct($_POST["name"])."','".sha1(md5($_POST["password"]))."','".correct($_POST["username"])."','".correct($_POST["szint"])."','".correct($_POST["egyhaziszint"])."')";
$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
} else {
	$eredmeny = false;
	?>
	<p>A két jelszó nem egyezik!</p>
	<?php
}
?>
<div class="content">
<div class="tartalom">
<?php
if ($eredmeny == true)
{
	?>
	<p class="succes">Sikeres létrehozás!</p>
	<script>
	alert("Sikeres létrehozás!");
	</script>
	<?php
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