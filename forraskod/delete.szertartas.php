<?php ob_start(); ?>
<!DOCTYPE html>
<html>
<head>
<title>Szertartás törlése - <?php echo $sitename; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="style.css">
<link rel="icon" type="image/pnp" href="icon.png">
<?php
//FIXME nem minden oldalon írjuk ki a $sitename változót, s ez baj
//FIXME head átnézése, mert még a régi rendszer szerint van
//FIXME MySQL hiba kijavítása
include("config.php");
include("head.php");
?>
</head>
<body class="d-flex flex-column h-100">
<?php
displayhead("Szertartás törlése");
include("headforadmin.php");
?>
<div id="messagesdiv">
	<?php
	Message::displayall();
	if (!checkpermission("removeliturgia")) {
		displaymessage("danger", "Nincs jogosultsága liturgia törléséhez!");
		exit;
	}
	?>
</div>
<div class="content">
<div class="tartalom">
<?php
//FIXME új szertartás rendszer feldolgozása
if (!isset($_POST["stage"])) {
	?>
	<!--<form name="delete1-user" action="form2.delete.szertartas.php" method="post">-->
	<form name="delete1-user" action="#" method="post">
	<table class="form">
	<tr>
	<td><label>Törölni kívánt szertartás ideje és megnevezése: </label></td>
	<td>
	<select name="szertartas-id" required>
	<option value="N/A">---Kérem válasszon!---</option>
	<?php
	$sql = "SELECT `id`, `date`, `name` FROM `szertartasok`";
	$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
	while ($row = mysqli_fetch_array($eredmeny))
	{
		$id = $row["id"];
		$name = $row["name"];
		$date = $row["date"];
		?>
		<option value="<?php echo $id; ?>"><?php echo $date; ?> - <?php echo $name; ?></option>
		<?php
	}
	mysqli_close($mysql);
	?>
	</select>
	</td>
	<td><label>Kérem válassza ki a törölni kívánt szertartást a listából!</label></td>
	</tr>
	<tr>
	<td><label></label></td>
	<input type="hidden" name="stage" value="2">
	<td><input type="submit" value="Tovább"></td>
	<td><label></label></td>
	</tr>
	</table>
	</form>
	<?php
} else if (isset($_POST["stage"])) {
	if (correct($_POST["stage"]) == "2")
	{
		?>
		<p>Biztosan törölni szeretné az alábbi szertartást?</p>
		<form name="delete2-szertartas" action="#" method="post">
		<table class="form">
		<tr>
		<td rowspan="3"><label>Törölni kívánt szertartás</label></td>
		<td><label>ideje: </label></td>
		<td><label><?php echo $date; ?></td>
		</tr>
		<tr>
		<td><label>megnevezése: </label></td>
		<td><label><?php echo $name; ?></td>
		</tr>
		<tr>
		<td><label>helye: </label></td>
		<td><label><?php echo $place; ?></td>
		</tr>
		<input type="hidden" name="id" value="<?php echo $id; ?>">
		<tr>
		<td><label></label></td>
		<td><input type="submit" value="Törlés"><input type="button" value="Vissza" onclick="window.location.replace('form.delete.szertartas.php');"></td>
		<td><label></label></td>
		</tr>
		<input type="hidden" name="stage" value="3">
		</table>
		</form>
		<?php
	} else if (correct($_POST["stage"]) == "3")
	{
		$id = correct($_POST["id"]);
		$sql = "DELETE FROM `szertartasok` WHERE `ID` = '".$id."'";
		$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
		if (isset($_POST["miserend"]))
		{
			if (correct($_POST["miserend"]) == "true")
			{
				if ($eredmeny == true) {
					$_SESSION["messages"][] = new Message("Liturgia törlése sikerült.", MessageType::success);
					mysqli_close($mysql);
					header("Location: miserend.php");
				}
			}
		} else {
			if ($eredmeny == true)
			{
				$_SESSION["messages"][] = new Message("Liturgia törlése sikerült.", MessageType::success);
				mysqli_close($mysql);
				header("Location: miserend.php");
			} else if ($eredmeny == false) {
				?>
				<p class="warning">Valami hiba történt.</p>
				<form name="delete1-user" action="#" method="post">
				<table class="form">
				<tr>
				<td><label>Törölni kívánt szertartás ideje és megnevezése: </label></td>
				<td>
				<select name="szertartas-id">
				<option value="N/A">---Kérem válasszon!---</option>
				<?php
				$sql = "SELECT `id`, `date`, `name` FROM `szertartasok`";
				$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
				while ($row = mysqli_fetch_array($eredmeny))
				{
					$id = $row["id"];
					$name = $row["name"];
					$date = $row["date"];
					?>
					<option value="<?php echo $id; ?>"><?php echo $date; ?> - <?php echo $name; ?></option>
					<?php
				}
				mysqli_close($mysql);
				?>
				</select>
				</td>
				<td><label>Kérem válassza ki a törölni kívánt szertartást a listából!</label></td>
				</tr>
				<tr>
				<td><label></label></td>
				<input type="hidden" name="stage" value="2">
				<td><input type="submit" value="Tovább"></td>
				<td><label></label></td>
				</tr>
				</table>
				</form>
				<?php
			}
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