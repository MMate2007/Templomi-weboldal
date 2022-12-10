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

?>

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
//TODO felfüggesztés funkció hozzáadása - űrlap
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