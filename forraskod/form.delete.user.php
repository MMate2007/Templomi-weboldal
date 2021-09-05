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
<form name="delete1-user" action="form2.delete.user.php" method="post">
<table class="form">
<tr>
<td><label>Törölni kívánt felhasználó: </label></td>
<td>
<select name="user-id">
<option value="N/A">---Kérem válasszon!---</option>
<?php
$mysql = mysqli_connect("localhost", "mysqlfelhasznalo", "mysqljelszo", "adatbazisnev") or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
mysqli_query($mysql, "SET NAMES utf8");
$sql = "SELECT `id`, `name` FROM `author` WHERE `id` > 0";
$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
while ($row = mysqli_fetch_array($eredmeny))
{
	$id = $row["id"];
	$name = $row["name"];
	?>
	<option value="<?php echo $id; ?>"><?php echo $name; ?></option>
	<?php
}
mysqli_close($mysql);
?>
</select>
</td>
<td><label>Kérem válassza ki a törölni kívánt felhasználót a listából!</label></td>
</tr>
<tr>
<td><label>Törölje a rendszer a felhasználó által írt tartalmakat is?</label></td>
<td><input type="radio" name="tartalomtorlese" value="1" id="igen"><label for="igen">Igen</label><input type="radio" name="tartalomtorlese" value="0" id="nem" checked><label for="nem">Nem</label></td>
<td><label><i>Igen</i>: azokat a <b>tartalmakat</b>(hirdetések és blogbejegyzések), melyek szerzőjének a fent kiválasztott felhasználó van megjelölve, illetve a <b>felhasználó összes adatát</b> törli a rendszer. <br><i>Nem</i>: ekkor a rendszer nem teszi lehetővé a fent kijelölt felhasználónak a belépést, csak a nevét és az azonosítóját (a jelszavát és felhasználónevét törli) nem törli, így továbbra is látható lesz a neve tartalmainál.</label></td>
</tr>
<tr>
<td><label></label></td>
<td><input type="submit" value="Tovább"></td>
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