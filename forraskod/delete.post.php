<?php ob_start(); ?>
<!DOCTYPE html>
<html>
<head>
<title>Blogbejegyzés törlése - <?php echo $sitename; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="style.css">
<link rel="icon" type="image/pnp" href="icon.png">
<?php
include("head.php");
?>
</head>
<body>
<?php
displayhead("Blogbejegyzés törlése");
include("headforadmin.php");
if (!checkpermission("removepost") && $_POST["id"] != $_SESSION["userId"]) {
	displaymessage("danger", "Nincs jogosultsága a blogbejegyzés törléséhez!");
	exit;
}
?>
<main class="container">
<?php
$id = correct($_POST["id"]);
if (!check($id, "number")) {
    mysqli_close($mysql);
    exit;
}
$sql = "DELETE FROM `blog` WHERE id = '$id'";
$eredmeny = mysqli_query($mysql, $sql);
if ($eredmeny) {
    displaymessage("success", "Sikeres törlés!");
} else {
    displaymessage("danger", "Valami nem sikerült.");
}
?>
</main>
<?php include("footer.php"); ?>
</body>
</html>