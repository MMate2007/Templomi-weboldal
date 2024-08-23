<?php ob_start(); ?>
<!DOCTYPE html>
<html>
<head>
<?php include("head.php"); ?>
<title>Oldal törlése - <?php echo $sitename; ?></title>
</head>
<body class="d-flex flex-column h-100">
<?php
displayhead("Oldal törlése");
include("headforadmin.php");
?>
<div id="messagesdiv">
	<?php
	Message::displayall();
	if (!checkpermission("deletepage"))
	{
		displaymessage("danger", "Nincs jogosultsága oldal törléséhez!");
		exit;
	}
	?>
</div>
<main class="content container d-flex justify-content-center">
<div>
	<?php
if (isset($_POST["id"])) {
		$id = correct($_POST["id"]);
		$sql = "SELECT `url` FROM `oldalak` WHERE `id` = '$id'";
		$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
		$row = mysqli_fetch_array($eredmeny);
		$url = $row["url"];
		$sql = "SELECT `id` FROM `nav` WHERE `url` = 'page.php?page=$url'";
		$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
		$row = mysqli_fetch_array($eredmeny);
		if ($row != null) {
		$linkid = $row["id"];
		$sql = "DELETE FROM `nav` WHERE `id` = '$linkid'";
		$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>"); }
		$sql = "DELETE FROM `oldalak` WHERE `id` = '".$id."'";
		$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
		if ($eredmeny == true) {
			$_SESSION["messages"][] = new Message("Oldal törlése sikeres.", MessageType::success);
		} else if ($eredmeny == false) {
			$_SESSION["messages"][] = new Message("Valami hiba történt az oldal törlése során.", MessageType::danger);
		}
		redirectback();
}
?>
</div>
</main>
<?php include("footer.php"); ?>
</body>
</html>