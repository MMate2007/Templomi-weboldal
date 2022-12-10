<html>
<head>
<title>Szertartás törlése - Példa plébánia</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="style.css">
<link rel="icon" type="image/pnp" href="icon.png">
<?php
//FIXME head átnézése, mert még a régi rendszer szerint van
//FIXME MySQL hiba kijavítása
include("condig.php");
include("head.php");
?>
<style>
header nav a[href="http://<?php echo $_SERVER['HTTP_HOST']; echo htmlspecialchars($_SERVER['PHP_SELF']);?>"], nav a[href="http://<?php echo $_SERVER['HTTP_HOST']; echo htmlspecialchars($_SERVER['PHP_SELF']);?>"] {font-weight: bold;}
</style>
</head>
<body>
<header>
<div class="head">
<div class="fejlecparallax">
<div class="head-text">
<h1>Példa plébánia honlapja - Szertartás törlése</h1>
</div>
</div>
</div>
<hr>
<nav>
<?php include("navbar.php");
include("headforadmin.php");
?>
<!--TODO headforadmin.php beillesztése-->
</nav>
<hr>
</header>
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
	//FIXME új szertartás rendszer feldolgozása
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
		$sql = "SELECT `szandek` FROM `szertartasok` WHERE `ID` = '".$id."'";
		$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
		$szandekid = null;
		while ($row = mysqli_fetch_array($eredmeny))
		{
			$szandekid = $row['szandek'];
		}
		$sql = "DELETE FROM `szandekok` WHERE `id` = '".$szandekid."'";
		$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
		$sql = "DELETE FROM `szertartasok` WHERE `ID` = '".$id."'";
		$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
		if (isset($_POST["miserend"]))
		{
			if (correct($_POST["miserend"]) == "true")
			{
				if ($eredmeny == true) {
					header("Location: miserend.php");
				}
			}
		} else {
			if ($eredmeny == true)
			{
				?>
				<p class="succes">Sikeres törlés!</p>
				<?php
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