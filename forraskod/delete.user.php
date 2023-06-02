<?php ob_start(); ?>
<!DOCTYPE html>
<html>
<head>
<?php include("head.php"); ?>
<title>Felhasználó törlése - <?php echo $sitename; ?></title>
<meta name="language" content="hu-HU">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<?php
displayhead("Felhasználó törlése");
include("headforadmin.php");
if (!checkpermission("removeuser")){
	displaymessage("danger", "Nincs jogosultsága felhasználó törléséhez!");
	exit;
}
?>
<div class="content">
<div class="tartalom">
<?php
if (!isset($_POST["stage"])) { ?>
	<form name="delete1-user" action="#" method="post">
	<table class="form">
		<tr>
			<td><label>Törölni vagy csak ideiglenesen felfüggeszteni szeretnénk a felhasználót?</label></td>
			<td><input type="radio" name="felfuggesztes" value="0" required>Törölni</input><input type="radio" name="felfuggesztes" value="1">Felfüggeszteni</input></td>
			<td>Felfüggesztéskor a felhasználónak csak megtiltjuk a belépést, de semmi mást nem módosítunk, törléskor pedig adatokat is törlünk.</td>
		</tr>
	<tr>
	<td><label>Törölni/felfüggeszteni kívánt felhasználó: </label></td>
	<td>
	<select name="user-id" required>
	<option value="N/A">---Kérem válasszon!---</option>
	<?php
	//TODO 2 lap egyesítése
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
	<td><label>Csak törlés esetén töltse ki: törölje a rendszer a felhasználó által írt tartalmakat is?</label></td>
	<td><input type="radio" name="tartalomtorlese" value="1" id="igen"><label for="igen">Igen</label><input type="radio" name="tartalomtorlese" value="0" id="nem" checked><label for="nem">Nem</label></td>
	<td><label><i>Igen</i>: azokat a <b>tartalmakat</b>(hirdetések és blogbejegyzések), melyek szerzőjének a fent kiválasztott felhasználó van megjelölve, illetve a <b>felhasználó összes adatát</b> törli a rendszer. <br><i>Nem</i>: ekkor a rendszer nem teszi lehetővé a fent kijelölt felhasználónak a belépést, csak a nevét és az azonosítóját (a jelszavát és felhasználónevét törli) nem törli, így továbbra is látható lesz a neve tartalmainál.</label></td>
	</tr>
	<tr>
	<td><label></label></td>
	<td><input type="submit" value="Tovább"></td>
	<td><label></label></td>
	</tr>
	<input type="hidden" name="stage" value="1">
	</table>
	</form>
	<?php
}
if (isset($_POST["stage"]))
{
	if ($_POST["stage"] == 1)
	{
		$id = correct($_POST["user-id"]);
		$torles = correct($_POST["tartalomtorlese"]);
		$sql = "SELECT `name` FROM `author` WHERE `id` = '".correct($id)."'";
		$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
		$name = "Ismeretlen";
		while ($row = mysqli_fetch_array($eredmeny))
		{
			$name = $row["name"];
		}
		?>
		<form name="delete2-user" action="#" method="post">
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
<input type="hidden" name="stage" value="2">
</tr>
</table>
</form>
<?php
}
if ($_POST["stage"] == 2) {
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
if ($eredmeny == true)
{
	?>
	<p class="succes">Sikeres törlés!</p>
	<?php
}else{
	?>
	<p class="warning">Valami hiba történt!</p>
	<p>Kérem, kattintson az alábbi gombra!</p>
	<form action="#" method="post">
	<input type="hidden" name="id" value="<?php echo $id;?>">
	<input type="hidden" name="torles" value="<?php echo $torles;?>">
	<input type="submit" value="Újrapróbálkozás">
	<input type="hidden" name="stage" value="2">
	</form>
	<?php
}
}
}
?>
</div>
</div>
<div class="sidebar">
</div>
<?php include("footer.php"); ?>
</body>
</html>