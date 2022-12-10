<html>
<head>
<?php include("head.php"); ?>
<title>Törlés...</title>
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
<h1><?php echo $sitename; ?> honlapja - Felhasználó törlése...</h1>
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
//TODO felfüggesztés funkció hozzáadása
$id = correct($_POST["id"]);
$torles = correct($_POST["torles"]);
$sql = "UPDATE `author` SET `password`='törölt',`username`='törölt',`szint`= null WHERE `id` = '".$id."'";
$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
if ($torles == 1)
{
	$sql = "DELETE FROM `blog` WHERE `authorId` = '".$id."'";
	$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
	$sql = "DELETE FROM `hirdetesek` WHERE `authorid` = '".$id."'";
	$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
	$sql = "DELETE FROM `author` WHERE `id` = '".$id."'";
	$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
}

?>
<div class="content">
<div class="tartalom">
<?php
if ($eredmeny == true)
{
	mail("info@mmate.nhely.hu", "Felhasznalo torolve", "ID:".$id." Tartalom torlese: ".$torles, "From: <?php echo getsetting($mysql, 'main.email'); ?>");
	?>
	<p class="succes">Sikeres törlés!</p>
	<?php
}else{
	?>
	<p class="warning">Valami hiba történt!</p>
	<p>Kérem, kattintson az alábbi gombra!</p>
	<form action="delete.user.php" method="post">
	<input type="hidden" name="id" value="<?php echo $id;?>">
	<input type="hidden" name="torles" value="<?php echo $torles;?>">
	<input type="submit" value="Újrapróbálkozás">
	</form>
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