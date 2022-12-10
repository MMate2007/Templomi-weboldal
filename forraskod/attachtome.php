<html>
<head>
<?php include("head.php"); ?>
<title>Módosítás...</title>
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
<h1><?php echo $sitename; ?> honlapja - Litrugia szerkesztése...</h1>
</div>
</div>
</div>
<hr>
<nav>
<?php include("navbar.php"); ?>
<?php

include("headforadmin.php");

?>
</nav>
<hr>
</header>
<?php
if ($_POST["userid"] == $_SESSION["userId"])
{
    $id = $_SESSION["userId"];
} else {
	$id = null;
}
if ($id != null) {
	if ($_SESSION["egyhszint"] == 2) {
$sql = "UPDATE `szertartasok` SET `celebransID`='".$id."' WHERE `id` = '".$_POST["miseid"]."'"; } else if ($_SESSION["egyhszint"] == 1) {
$sql = "UPDATE `szertartasok` SET `kantorID`='".$id."' WHERE `id` = '".$_POST["miseid"]."'"; }
$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
}
?>
<div class="content">
<div class="tartalom">
<?php
if ($eredmeny == true)
{
	?>
	<p class="succes">Sikeres módosítás!</p>
	<script>
		window.location.replace("admin.php");
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