<?php ob_start(); ?>
<!DOCTYPE html>
<html>
<head>
<?php
include("head.php");
?>
<title>Blogbejegyzés törlése - <?php echo $sitename; ?></title>
</head>
<body class="d-flex flex-column h-100">
<?php
displayhead("Blogbejegyzés törlése");
include("headforadmin.php");
?>
<div id="messagesdiv">
    <?php
    Message::displayall();
    if (!checkpermission("removepost") && $_POST["id"] != $_SESSION["userId"]) {
        displaymessage("danger", "Nincs jogosultsága a blogbejegyzés törléséhez!");
        exit;
    }
    ?>
</div>
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
    $_SESSION["messages"][] = new Message("Bejegyzés törlése sikeres.", MessageType::success);
} else {
    $_SESSION["messages"][] = new Message("Valami hiba történt a bejegyzés törlése során.", MessageType::danger);
}
?>
</main>
<?php include("footer.php"); 
header("Location: blog.php");
?>
</body>
</html>