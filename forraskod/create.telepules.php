<?php ob_start(); ?>
<!DOCTYPE html>
<html>
<head>
<?php include("head.php"); ?>
<title>Település hozzáadása - <?php echo $sitename; ?></title>
<meta name="language" content="hu-HU">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
header nav a[href="http://<?php echo $_SERVER['HTTP_HOST']; echo htmlspecialchars($_SERVER['PHP_SELF']);?>"], nav a[href="http://<?php echo $_SERVER['HTTP_HOST']; echo htmlspecialchars($_SERVER['PHP_SELF']);?>"] {font-weight: bold;}
</style>
</head>
<body class="d-flex flex-column h-100">
<?php
displayhead("Település hozzáadása");
include("headforadmin.php");
?>
<div id="messagesdiv">
    <?php
    Message::displayall();
    if (!checkpermission("addtelepules")) {
        displaymessage("danger", "Nincs jogosultsága település hozzáadásához!");
        exit;
    }
    ?>
</div>
<main class="container d-flex justify-content-center">
    <form name="create-telepules" action="create.telepules.php" method="post">
    <p><span style="color: red;">* kötelezően kitöltendő mező.</span></p>
    <div class="row my-3">
        <label for="name" class="col required">Település neve: </label>
        <input type="text" name="name" id="name" class="col form-control" required autofocus pattern="<?php echo $htmlregexlist["name"]; ?>" <?php autofill("name"); ?>>
    </div>
    <input type="hidden" name="stage" value="2">
    <button type="submit" class="btn btn-primary text-white mb-3"><i class="bi bi-plus-lg"></i> Hozzáadás</button>
    </form>
    <?php
if (isset($_POST["stage"]))
{
    if (correct($_POST["stage"]) == "2")
    {
        $name = correct($_POST["name"]);
        if (!check($name, "name")) {
            formvalidation("#name", false, "Ez a mező csak kis- és nagybetűket, pontot, kötőjelet és szóközt tartalmazhat!");
        } else {
        $sql = "SELECT * FROM `telepulesek`";
        // TODO AUTO_INCREMENT beállítása a MySQL táblában
        $id = 0;
        $eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
        $letezik = false;
        while ($row = mysqli_fetch_array($eredmeny))
        {
            $_id = $row['id'];
            $id = $_id + 1;
            $n = $row["name"];
            if ($n == $name) {
                $message = new Message("Ez a település már létezik!", MessageType::warning, true);
                $message->insertontop();
                $letezik = true;
                break;
            }
        }
        if (!$letezik) {
        $sql = "INSERT INTO `telepulesek`(`id`, `name`) VALUES ('".$id."','".$name."')";
        $eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
        if ($eredmeny == true)
        {
            $message = new Message("Sikeres hozzáadás!", MessageType::success, true);
            $message->insertontop();
        }else{
            $message = new Message("Valami nem sikerült.", MessageType::danger, true);
            $message->insertontop();
        } } }
    }
}
?>
</main>
<?php include("footer.php"); ?>
</body>
</html>