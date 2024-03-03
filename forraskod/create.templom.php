<?php ob_start(); ?>
<!DOCTYPE html>
<html>
<head>
<?php include("head.php"); ?>
<title>Templom hozzáadása - <?php echo $sitename; ?></title>
<meta name="language" content="hu-HU">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<?php
displayhead("Templom hozzáadása");
include("headforadmin.php");
?>
<div id="messagesdiv">
    <?php
    Message::displayall();
    if (!checkpermission("addtemplom")) {
        displaymessage("danger", "Nincs jogosultsága templom hozzáadásához!");
        exit;
    }
    // TODO regex html és php-ben
    ?>
</div>
<main class="container d-flex justify-content-center">
    <form name="create-templom" action="#" method="post">
    <p><span style="color: red;">* kötelezően kitöltendő mező.</span></p>
            <div class="row my-3">
                <label for="name" class="col required">Templom/kápolna neve: </label>
                <input type="text" name="name" id="name" class="col form-control" <?php autofill("name"); ?> required autofocus pattern="<?php echo $htmlregexlist['name']; ?>">
            </div>
            <div class="row mb-3">
                <label for="telepules" class="col required">Település ahová tartozik:</label>
                    <select name="telepules" class="col form-select" id="telepules" required>
                        <option value="semmi">--Kérem válasszon--</option>
                        <?php
                        $sql = "SELECT * FROM `telepulesek`";
                        $eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
                        while ($row = mysqli_fetch_array($eredmeny))
                        {
                            $id = $row["id"];
                            $name = $row["name"];
                            ?>
                            <option value="<?php echo $id; ?>"><?php echo $name; ?></option>
                            <?php
                        }
                        ?>
                    </select>
            </div>
            <div class="row my-3">
                <label for="szent" class="col">Védőszent: </label>
                <input type="text" id="szent" class="col form-control" name="szent" <?php autofill("szent"); ?> pattern="<?php echo $htmlregexlist['name']; ?>">
            </div>
            <div class="row my-3">
                <label for="color" class="col">Szín: </label>
                <input type="color" id="color" class="col form-control" name="color" <?php autofill("color"); ?>>
                <label class="col form-text">A <a href="miserend.php">Miserend</a> oldalon a naptár nézetben az olyan litrugiáknak, melyeknél ez a templom van megjelölve, ilyen lesz a színe.</label>
            </div>
    <button type="submit" class="btn btn-primary text-white mb-3"><i class="bi bi-plus-lg"></i> Hozzáadás</button>
    <input type="hidden" name="stage" value="2">
    </form>
    <?php
if (isset($_POST["stage"]))
{
    if (correct($_POST["stage"]) == "2")
    {
        $name = correct($_POST["name"]);
        $tel = correct($_POST["telepules"]);
        $szent = correct($_POST["szent"]);
        $color = correct($_POST["color"]);
        $validinput = true;
        if ($tel == "semmi")
        {
            formvalidation("#telepules", false, "Nem lett kiválasztva a település!");
            $validinput = false;
        }
        if (!check($tel, "number") && $tel != 0) {
            $validinput = false;
            formvalidation("#telepules", false, "Ennek a mezőnek az értéke csak szám lehet!");
        }
        if (!check($name, "name")) {
            $validinput = false;
            formvalidation("#name", false, "Ez a mező csak kis- és nagybetűket, szóközt, pontot és kötőjelet tartalmazhat!");
        }
        if (!check($szent, "name") && $szent != null) {
            $validinput = false;
            formvalidation("#szent", false, "Ez a mező csak kis- és nagybetűket, szóközt, pontot és kötőjelet tartalmazhat!");
        }
        if ($validinput == true) {
            if ($szent == "") {$szent = null;}
            $sql = "SELECT * FROM `templomok`";
            $id = 0;
            $n = null;
            $t = null;
            $sz = null;
            $eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
            while ($row = mysqli_fetch_array($eredmeny))
            {
                $_id = $row['id'];
                $id = $_id + 1;
                $n = $row["name"];
                $t = $row["telepulesID"];
                $sz = $row["vedoszent"];
            }
            if ($name == $n && $tel == $t && $szent == $sz) {
                $message = new Message("Ez a templom már létezik!", MessageType::danger, false);
                $message->insertontop();
            } else {
            $sql = "INSERT INTO `templomok`(`id`, `telepulesID`, `name`, `vedoszent`, `color`) VALUES ('".$id."','".$tel."','".$name."','".$szent."',";
            if ($color == null) {
                $sql .= "NULL";
            } else {
                $sql .= "'$color'";
            }
            $sql .= ")";
            $eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
            // TODO a visszajelzések megjelenését javítani kell
            if ($eredmeny == true)
            {
                $message = new Message("Templom hozzáadása sikerült.", MessageType::success);
                $message->insertontop();
            }else{
                $message = new Message("Templom hozzáadása sikertelen.", MessageType::danger, false);
                $message->insertontop();

            } 
        } }
    }
}
?>
</main>
<?php include("footer.php"); ?>
</body>
</html>