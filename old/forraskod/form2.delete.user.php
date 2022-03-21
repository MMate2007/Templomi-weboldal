<html>
<head>
<title>Felhasználó törlése - Példa plébánia</title>
<meta charset="utf-8">
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
	left: 30px;
}
div.head-text h1 {font-size: 20pt;}
}
@media only screen and (min-width: 600px) {
div.head-text {
	position: absolute;
	top: 10px;
	left: 50px;
}
div.head-text h1 {font-size: 72pt;}
}
@media only screen and (min-width: 1349px) {
div.head-text {
	position: absolute;
	top: 25px;
	left: 100px;
}
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
<h1>Példa plébánia honlapja - Felhasználó törlése</h1>
</div>
</div>
</div>
<hr>
<nav>
<?php include("navbar.php"); ?>
<?php
session_start();
if (!isset($_SESSION["userId"]))
{
	header("Location: hozzaferes.php");
}
$mysql = mysqli_connect("localhost", "mysqlfelhasznalo", "mysqljelszo", "adatbazisnev") or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
mysqli_query($mysql, "SET NAMES utf8");
$sql = "SELECT `name` FROM `author` WHERE `id` = '".$_SESSION["userId"]."'";
$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
while ($row = mysqli_fetch_array($eredmeny))
{
	$name = $row["name"];
	if ($name != $_SESSION["name"])
	{
		mysqli_close($mysql);
		header("Location: hozzaferes.php");
	}
}
if ($_SESSION["admin"] == 0)
{
	header("Location: admin.php");
}
$id = $_POST["user-id"];
$torles = $_POST["tartalomtorlese"];
mysqli_query($mysql, "SET NAMES utf8");
$sql = "SELECT `name` FROM `author` WHERE `id` = '".$id."'";
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
mysqli_close($mysql);
?>
<a href="logout.php" class="right">Kijelentkezés</a>
<a href="form.create.hirdetes.php" class="right">Hirdetés létrehozása</a>
<a href="form.create.szertartas.php" class="right">Liturgia hozzáadása</a>
<a href="admin.php" class="right" id="right-elso">Adminisztráció</a>
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
	$mysql = mysqli_connect("localhost", "mysqlfelhasznalo", "mysqljelszo", "adatbazisnev") or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
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
	mysqli_close($mysql);
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