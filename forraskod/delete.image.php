<?php ob_start(); ?>
<!DOCTYPE html>
<html>
<head>
<?php
include("head.php");
?>
<title>Fénykép törlése - <?php echo $sitename; ?></title>
</head>
<body class="d-flex flex-column h-100">
<?php
displayhead("Fénykép törlése");
include("headforadmin.php");
?>
<div id="messagesdiv">
    <?php
    Message::displayall();
    if (!checkpermission("removefile")) {
        displaymessage("danger", "Nincs jogosultsága a fénykép törléséhez!");
        exit;
    }
    ?>
</div>
<main class="container">
<?php
$src = correct($_POST["src"]);
$src = mysqli_real_escape_string($mysql, $src);
$sql = "SELECT `description` FROM `kepek` WHERE `src` = '".$src."'";
$res = mysqli_query($mysql, $sql);
while ($row = mysqli_fetch_array($res)) {
    unlink($row["description"]);
}
$sql = "DELETE FROM `kepek` WHERE src = '$src'";
$eredmeny = mysqli_query($mysql, $sql);
if ($eredmeny) {
    $_SESSION["messages"][] = new Message("Fénykép törlése sikeres.", MessageType::success);
} else {
    $_SESSION["messages"][] = new Message("Valami hiba történt a fénykép törlése során.", MessageType::danger);
}
?>
</main>
<?php include("footer.php"); 
header("Location: list.images.php");
?>
</body>
</html>