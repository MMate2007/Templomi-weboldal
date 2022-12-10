<html>
<head>
<?php include("head.php"); ?>
<title>Hirdetés törlése - <?php echo $sitename; ?></title>
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
<h1><?php echo $sitename; ?> honlapja - Hirdetés törlése</h1>
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
<div class="content">
<div class="tartalom">
<?php
if (!isset($_POST["stage"]))
{
	?>
	<!--<form name="delete1-hirdetes" action="form2.delete.hirdetes.php" method="post">-->
	<form name="delete1-hirdetes" action="#" method="post">
	<table class="form">
	<tr>
	<td><label>Törölni kívánt hirdetés címe: </label></td>
	<td>
	<select name="hirdetes-id" required>
	<option value="N/A">---Kérem válasszon!---</option>
	<?php
	$sql = "SELECT `ID`, `title` FROM `hirdetesek`";
	$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
	while ($row = mysqli_fetch_array($eredmeny))
	{
		$id = $row["ID"];
		$title = $row["title"];
		?>
		<option value="<?php echo $id; ?>"><?php echo $title; ?></option>
		<?php
	}
	?>
	</select>
	</td>
	<td><label>Kérem válassza ki a törölni kívánt hirdetés címét a listából!</label></td>
	</tr>
	<tr>
	<td><label></label></td>
	<td><input type="submit" value="Tovább"></td>
	<input type="hidden" name="stage" value="2">
	<td><label></label></td>
	</tr>
	</table>
	</form>
	<?php
} else if (isset($_POST["stage"])) {
	if (correct($_POST["stage"]) == "2") {
		?>
		<form name="delete1-hirdetes" action="#" method="post">
		<?php
		$id = correct($_POST["hirdetes-id"]);
		if ($id == "N/A")
		{
			?>
			<p class="warning">Nem lett kiválasztva hirdetés!</p>
			<form name="delete1-hirdetes" action="#" method="post">
			<table class="form">
			<tr>
			<td><label>Törölni kívánt hirdetés címe: </label></td>
			<td>
			<select name="hirdetes-id" required>
			<option value="N/A">---Kérem válasszon!---</option>
			<?php
			$sql = "SELECT `ID`, `title` FROM `hirdetesek`";
			$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
			while ($row = mysqli_fetch_array($eredmeny))
			{
				$id = $row["ID"];
				$title = $row["title"];
				?>
				<option value="<?php echo $id; ?>"><?php echo $title; ?></option>
				<?php
			}
			?>
			</select>
			</td>
			<td><label>Kérem válassza ki a törölni kívánt hirdetés címét a listából!</label></td>
			</tr>
			<tr>
			<td><label></label></td>
			<td><input type="submit" value="Tovább"></td>
			<input type="hidden" name="stage" value="2">
			<td><label></label></td>
			</tr>
			</table>
			</form>
			<?php
		} else {
			$sql = "SELECT `title`, `content` FROM `hirdetesek` WHERE `ID` = '".correct($id)."'";
			$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
			$title = "Ismeretlen";
			$content = "";
			while ($row = mysqli_fetch_array($eredmeny))
			{
				$title = $row["title"];
				$content = $row["content"];
			}
			?>
			<p>Biztosan szeretné törölni ezt a hirdetést?</p>
			<table class="form">
			<tr>
			<td><label>A kiválasztott hirdetés címe: </label></td>
			<td><label><?php echo $title; ?></label></td>
			</tr>
			<tr>
			<td><label>A kiválasztott hirdetés leírása: </label></td>
			<td><label><?php echo $content; ?></label></td>
			</tr>
			<input type="hidden" name="id" value="<?php echo $id; ?>">
			<input type="hidden" name="stage" value="3">
			<tr>
			<td><label></label></td>
			<td><input type="submit" value="Törlés"><input type="button" value="Vissza" onclick="window.location.replace('form.delete.hirdetes.php');"><input type="button" value="Mégsem" onclick="window.location.replace('admin.php');"></td>
			<td><label></label></td>
			</tr>
			</table>
			<?php
		}
		?>
		</form>
		<?php
	} else if (correct($_POST["stage"]) == "3")
	{
		$id = correct($_POST["id"]);
		$sql = "DELETE FROM `hirdetesek` WHERE `ID` = '".$id."'";
		$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
		?>
		<div class="content">
		<div class="tartalom">
		<?php
		if ($eredmeny == true)
		{
			?>
			<p class="succes">Sikeres törlés!</p>
			<?php
		}else{
			?>
			<p class="warning">Valami hiba történt!</p>
			<form name="delete1-hirdetes" action="#" method="post">
			<table class="form">
			<tr>
			<td><label>Törölni kívánt hirdetés címe: </label></td>
			<td>
			<select name="hirdetes-id" required>
			<option value="N/A">---Kérem válasszon!---</option>
			<?php
			$sql = "SELECT `ID`, `title` FROM `hirdetesek`";
			$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
			while ($row = mysqli_fetch_array($eredmeny))
			{
				$id = $row["ID"];
				$title = $row["title"];
				?>
				<option value="<?php echo $id; ?>"><?php echo $title; ?></option>
				<?php
			}
			?>
			</select>
			</td>
			<td><label>Kérem válassza ki a törölni kívánt hirdetés címét a listából!</label></td>
			</tr>
			<tr>
			<td><label></label></td>
			<td><input type="submit" value="Tovább"></td>
			<input type="hidden" name="stage" value="2">
			<td><label></label></td>
			</tr>
			</table>
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