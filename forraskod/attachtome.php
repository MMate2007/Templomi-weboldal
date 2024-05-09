<?php ob_start(); ?>
<!DOCTYPE html>
<html>
<head>
<?php include("head.php"); ?>
<title>Módosítás...</title>
<meta name="language" content="hu-HU">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
	header nav a[href="http://<?php echo $_SERVER['HTTP_HOST']; echo htmlspecialchars($_SERVER['PHP_SELF']);?>"], nav a[href="http://<?php echo $_SERVER['HTTP_HOST']; echo htmlspecialchars($_SERVER['PHP_SELF']);?>"] {font-weight: bold;}
</style>
</head>
<body>
<?php
displayhead("Liturgia hozzámrendelése");
include("headforadmin.php");
?>
<div id="messagesdiv">
<?php
Message::displayall();
if (!checkpermission("editliturgia"))
{
	displaymessage("danger", "Nincs joga szerkeszteni a bejegyzett litrugiákat!");
	exit;
}
?>
</div>
<?php
if ($_POST["userid"] == $_SESSION["userId"])
{
    $id = $_SESSION["userId"];
} else {
	$id = null;
}
if ($id != null) {
	if ($_SESSION["egyhszint"] == 2) {
$sql = "UPDATE `szertartasok` SET `celebransID`='".$id."' WHERE `id` = '".$_POST["miseid"]."'"; } else if ($_SESSION["egyhszint"] == 1) {
$sql = "UPDATE `szertartasok` SET `kantorID`='".$id."' WHERE `id` = '".$_POST["miseid"]."'"; }
$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
}
?>
<div class="content">
<div class="tartalom">
<?php
if ($eredmeny == true)
{
	$_SESSION["messages"][] = new Message("Sikeres hozzáadás.", MessageType::success);
	?>
	<p class="succes">Sikeres módosítás!</p>
	<script>
		window.location.replace("admin.php");
	</script>
	<?php
}else{
	?>
	<p class="warning">Valami hiba történt!</p>
	<p>Kérem, próbálja újra!</p>
	<?php
}
?>
</div>
</div>
<div class="sidebar">
</div>
<?php include("footer.php"); ?>
</body>
</html>