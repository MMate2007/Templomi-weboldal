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
<main class="container">
<?php
if (!isset($_POST["stage"])) { ?>
	<form name="delete1-user" action="#" method="post">
	<div class="row my-3">
		<label class="form-label col-sm">Törölni vagy csak ideiglenesen felfüggeszteni szeretnénk a felhasználót?</label>
		<div class="col-sm">
			<div class="form-check form-check-inline">
				<input type="radio" name="felfuggesztes" value="0" required class="form-check-input" id="felfuggesztes0">
				<label for="felfuggesztes0" class="form-check-label">Törölni</label>
			</div>
			<div class="form-check form-check-inline">
				<input type="radio" name="felfuggesztes" value="1" class="form-check-input" id="felfuggesztes1">
				<label for="felfuggesztes1" class="form-check-label">Felfüggeszteni</label>
			</div>
		</div>
		<label class="form-text col-sm">Felfüggesztéskor a felhasználónak csak megtiltjuk a belépést, de semmi mást nem módosítunk, törléskor pedig adatokat is törlünk.</label>
	</div>
	<div class="row my-3">
		<label class="form-label col-sm" for="user-id">Törölni/felfüggeszteni kívánt felhasználó:</label>
		<select name="user-id" required id="user-id" class="col-sm form-select">
		<option value="N/A">---Kérem válasszon!---</option>
		<?php
		//TODO 2 lap egyesítése
		$sql = "SELECT `id`, `name` FROM `author` WHERE `password` != 'törölt'";
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
		<label class="form-text col-sm">Kérem válassza ki a törölni kívánt felhasználót a listából!</label>
	</div>
	<div class="row my-3">
		<label class="form-label col-sm">Csak törlés esetén töltse ki: törölje a rendszer a felhasználó által írt tartalmakat is?</label>
		<div class="col-sm">
			<div class="form-check form-check-inline">
				<input type="radio" name="tartalomtorlese" value="1" id="igen" class="form-check-input">
				<label for="igen" class="form-check-label">Igen</label>
			</div>
			<div class="form-check form-check-inline">
				<input type="radio" name="tartalomtorlese" value="0" id="nem" checked class="form-check-input">
				<label for="nem" class="form-check-label">Nem</label>
			</div>
		</div>
		<label class="form-text col-sm"><i>Igen</i>: azokat a <b>tartalmakat</b>(hirdetések és blogbejegyzések), melyek szerzőjének a fent kiválasztott felhasználó van megjelölve, illetve a <b>felhasználó összes adatát</b> törli a rendszer. <br><i>Nem</i>: ekkor a rendszer nem teszi lehetővé a fent kijelölt felhasználónak a belépést, csak a nevét és az azonosítóját (a jelszavát és felhasználónevét törli) nem törli, így továbbra is látható lesz a neve tartalmainál.</label>
	</div>
	<button type="submit" class="btn btn-primary text-white"><i class="bi bi-arrow-right"></i> Tovább</button>
	<input type="hidden" name="stage" value="1">
	</form>
	<?php
}
if (isset($_POST["stage"]))
{
	if ($_POST["stage"] == 1)
	{
		$id = correct($_POST["user-id"]);
		if ($id == "N/A") {
			displaymessage("danger", "Nem választott ki felhasználót!");
			displaymessage("info", "Kérem, lépjen vissza a felhasználó kiválasztásához!");
			mysqli_close($mysql);
			exit;
		}
		$torles = correct($_POST["tartalomtorlese"]);
		$felfuggesztes = $_POST["felfuggesztes"];
		$sql = "SELECT `name` FROM `author` WHERE `id` = '".correct($id)."'";
		$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
		$name = "Ismeretlen";
		while ($row = mysqli_fetch_array($eredmeny))
		{
			$name = $row["name"];
		}
		?>
		<form name="delete2-user" action="#" method="post">
<div class="row my-3">
	<label class="col-sm"><?php if ($felfuggesztes == 1) { echo "Felfüggeszteni"; } else { echo "Törölni"; } ?> kívánt felhasználó:</label>
	<label class="col-sm"><?php echo $name; ?></label>
</div>
<?php if ($felfuggesztes == 0) { ?>
<div class="row my-3">
	<label class="col-sm">Törölje a rendszer a felhasználó által írt tartalmakat is?</label>
	<div class="col-sm">
		<div class="form-check form-check-inline">
			<input type="radio" class="form-check-input" name="tartalomtorlese" value="1" id="igen" disabled
			<?php
			if ($torles == 1)
			{
				echo "checked";
			}
			?>>
			<label for="igen" class="form-check-label">Igen</label>
		</div>
		<div class="form-check form-check-inline">
			<input type="radio" class="form-check-input" name="tartalomtorlese" value="0" id="nem" disabled
			<?php
			if ($torles == 0)
			{
				echo "checked";
			}
			?>>
			<label for="nem" class="form-check-label">Nem</label>
		</div>
	</div>
</div>
<div class="row my-3">
<?php
if ($torles == 1)
{
	$sql = "SELECT `id`, `title` FROM `blog` WHERE `authorId` = '".$id."'";
	$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
	$sql = "SELECT `ID`, `title` FROM `hirdetesek` WHERE `authorid` = '".$id."'";
	$eredmeny2 = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
	?>
	<p>Tartalmak amelyek törlésre kerülnek:</p>
	<ul>
	<li>Blogbejegyzések:
	<ul>
	<?php
	while ($row = mysqli_fetch_array($eredmeny))
	{
		$blogid = $row["id"];
		$blogtitle = $row["title"];
		?><li><a href="blog.php#<?php echo $blogid; ?>" target="_blank"><?php echo $blogtitle;?></a></li>
		<?php
	}
	?>
	</ul>
	</li>
	<li>Hirdetések
	<ul>
	<?php
	while ($row = mysqli_fetch_array($eredmeny2))
	{
		$hid = $row["ID"];
		$htitle = $row["title"];
		?>
		<li><a href="hirdetesek.php#<?php echo $hid; ?>" target="_blank"><?php echo $htitle; ?></a></li>
		<?php
	}
	?>
	</ul>
	</li>
	</ul>
<?php
} }
?>
</div>
<input type="hidden" name="id" value="<?php echo $id; ?>">
<input type="hidden" name="torles" value="<?php echo $torles; ?>">
<input type="hidden" name="felfuggesztes" value="<?php echo $felfuggesztes; ?>">
<?php if ($felfuggesztes == 0) { ?>
<button type="submit" class="btn btn-danger text-white"><i class="bi bi-person-x"></i> Törlés</button>
<?php } else { ?>
<button type="submit" class="btn btn-danger text-white"><i class="bi bi-person-dash"></i> Felfüggesztés</button>
<?php } ?>
<a role="button" class="btn btn-secondary text-white" href="delete.user.php"><i class="bi bi-arrow-left"></i> Vissza</a>
<input type="hidden" name="stage" value="2">
</form>
<?php
}
if ($_POST["stage"] == 2) {
	$id = correct($_POST["id"]);
$torles = correct($_POST["torles"]);
$felfuggesztes = $_POST["felfuggesztes"];
if ($felfuggesztes == 0) {
$sql = "UPDATE `author` SET `password`='törölt',`username`='törölt' WHERE `id` = '".$id."'";
$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
$sql = "DELETE FROM `userpermissions` WHERE `userId` = '$id'";
}
else if ($felfuggesztes == 1) {
	$sql = "SELECT `id` FROM `permissions` WHERE `shortname` = 'bejelentkezes'";
	$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
	$permissionid = 0;
	while ($row = mysqli_fetch_array($eredmeny)) {
		$permissionid = $row["id"];
	}
	$sql = "DELETE FROM `userpermissions` WHERE `userId` = '$id' AND `permissionId` = '$permissionid'";
}
$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
if ($torles == 1 && $felfuggesztes == 0)
{
	$sql = "DELETE FROM `blog` WHERE `authorId` = '".$id."'";
	$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
	$sql = "DELETE FROM `hirdetesek` WHERE `authorid` = '".$id."'";
	$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
	$sql = "DELETE FROM `author` WHERE `id` = '".$id."'";
	$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
	$sql = "DELETE FROM `userpermissions` WHERE `userId` = '$id'";
	$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
}
if ($eredmeny == true)
{
	displaymessage("success", "Sikeres művelet!");
} else {
	?>
	<p>Kérem, kattintson az alábbi gombra!</p>
	<form action="#" method="post">
	<input type="hidden" name="id" value="<?php echo $id;?>">
	<input type="hidden" name="torles" value="<?php echo $torles;?>">
	<input type="hidden" name="felfuggesztes" value="<?php echo $felfuggesztes; ?>">
	<input type="submit" value="Újrapróbálkozás">
	<input type="hidden" name="stage" value="2">
	</form>
	<?php
}
}
}
?>
</main>
<?php include("footer.php"); ?>
</body>
</html>