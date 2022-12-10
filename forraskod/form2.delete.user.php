<?php ob_start(); ?>
<html>
<head>
<?php include("head.php"); ?>
<title>Felhasználó törlése - <?php echo $sitename; ?></title>

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
<h1><?php echo $sitename; ?> honlapja - Felhasználó törlése</h1>
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
$id = correct($_POST["user-id"]);
$torles = correct($_POST["tartalomtorlese"]);
mysqli_query($mysql, "SET NAMES utf8");
$sql = "SELECT `name` FROM `author` WHERE `id` = '".correct($id)."'";
$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
$name = "Ismeretlen";
while ($row = mysqli_fetch_array($eredmeny))
{
	$name = $row["name"];
}
if ($id == "N/A")
{
	header("Location: form.delete.user.php");
}

?>

</nav>
<hr>
</header>
<div class="content">
<div class="tartalom">
<form name="delete2-user" action="delete.user.php" method="post">
<table class="form">
<tr>
<td><label>Törölni kívánt felhasználó: </label></td>
<td><label><?php echo $name; ?></td>
</tr>
<tr>
<td><label>Törölje a rendszer a felhasználó által írt tartalmakat is?</label></td>
<td><input type="radio" name="tartalomtorlese" value="1" id="igen" disabled 
<?php
if ($torles == 1) 
{
	?>checked<?php
}
?>><label for="igen">Igen</label>
<input type="radio" name="admin" value="0" id="nem" disabled
<?php
if ($torles == 0)
{
	?>checked<?php
}
?>><label for="nem">Nem</label></td>
</tr>
<?php
if ($torles == 1)
{
	$mysql = mysqli_connect("localhost", "filia", "borszorcsokfilia8479", "filia") or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
	mysqli_query($mysql, "SET NAMES utf8");
	$sql = "SELECT `id`, `title` FROM `blog` WHERE `authorId` = '".$id."'";
	$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
	$sql = "SELECT `ID`, `title` FROM `hirdetesek` WHERE `authorid` = '".$id."'";
	$eredmeny2 = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
	?>
	<tr>
	<td><label>Tartalmak amelyek törlésre kerülnek: <label></td>
	<td><label>
Blogbejegyzések: 
	<?php
	while ($row = mysqli_fetch_array($eredmeny))
	{
		$blogid = $row["id"];
		$blogtitle = $row["title"];
		?><br><a href="blog.php#<?php echo $blogid; ?>"><?php echo $blogtitle;?></a>
		<?php
	}
	?>
<br>
	Hirdetések
	<?php
	while ($row = mysqli_fetch_array($eredmeny2))
	{
		$hid = $row["ID"];
		$htitle = $row["title"];
		?>
		<br><a href="index.php#<?php echo $hid; ?>"><?php echo $htitle; ?></a>
		<?php
	}
	?>
<br>
	</label>
	</td>
	</tr>
	<?php
	
}
?>
<input type="hidden" name="id" value="<?php echo $id; ?>">
<input type="hidden" name="torles" value="<?php echo $torles; ?>">
<tr>
<td><label></label></td>
<td><input type="submit" value="Törlés"><input type="button" value="Vissza" onclick="window.location.replace('form.delete.user.php');"></td>
<td><label></label></td>
</tr>
</table>
</form>
</div>
</div>
<div class="sidebar">
</div>
<?php include("footer.php"); ?>
</body>
</html>