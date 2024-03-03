<?php ob_start(); ?>
<!DOCTYPE html>
<html>
<head>
<?php include("head.php"); ?>
<title>Hirdetés törlése - <?php echo $sitename; ?></title>
</head>
<body>
<?php
displayhead("Hirdetés törlése");
include("headforadmin.php");
?>
<div id="messagesdiv">
	<?php
	Message::displayall();
	if (!checkpermission("removehirdetes"))
	{
		displaymessage("danger", "Nincs jogosultsága hirdetés törléséhez!");
		exit;
	}
	?>
</div>
<main class="content container d-flex justify-content-center">
<div>
	<form name="delete1-hirdetes" action="#" method="post">
	<div class="row my-3">
		<label for="hirdetes-id" class="col-sm-4">Törölni kívánt hirdetés címe:</label>
		<select class="col-sm form-select" name="hirdetes-id" id="hirdetes-id" required>
		<option value="N/A">--Kérem válasszon!--</option>
		<?php
		$sql = "SELECT `ID`, `title` FROM `hirdetesek`";
		$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
		while ($row = mysqli_fetch_array($eredmeny))
		{
			$id = $row["ID"];
			$title = $row["title"];
			?>
			<option value="<?php echo $id; ?>" <?php if (isset($_POST["hirdetes-id"])) { if ($_POST["hirdetes-id"] == $row["ID"]) { echo "selected"; } } ?>><?php echo $title; ?></option>
			<?php
		}
		?>
		</select>
		<label class="col form-text">Kérem válassza ki a törölni kívánt hirdetés címét a listából!</label>
	</div>
	<button type="submit" class="btn btn-primary text-white"><i class="bi bi-arrow-right"></i> Tovább</button>
	<input type="hidden" name="stage" value="2">
	</form>
	<?php
if (isset($_POST["stage"])) {
	if (correct($_POST["stage"]) == "2") {
		?>
		<form name="delete1-hirdetes" action="#" method="post">
		<?php
		$id = correct($_POST["hirdetes-id"]);
		if ($id == "N/A")
		{
			formvalidation("#hirdetes-id", false, "Nem lett kiválasztva hirdetés!");
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
			<td><button type="submit" class="btn btn-danger text-white">Törlés</button></td>
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
		if ($eredmeny == true) {
			$_SESSION["messages"][] = new Message("Hirdetés törlése sikeres.", MessageType::success);
		} else if ($eredmeny == false) {
			$_SESSION["messages"][] = new Message("Valami hiba történt a hirdetés törlése során.", MessageType::danger);
		}
		mysqli_close($mysql);
		redirectback();
	}
}
?>
</div>
</main>
<?php include("footer.php"); ?>
</body>
</html>