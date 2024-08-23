<?php ob_start(); ?>
<!DOCTYPE html>
<html>
<head>
<?php include("head.php"); ?>
<title>Litrugiatípus hozzáadása - <?php echo $sitename; ?></title>
<meta name="language" content="hu-HU">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body class="d-flex flex-column h-100">
<?php
displayhead("Liturgiatípus hozzáadása");
include("headforadmin.php");
?>
<div id="messagesdiv">
    <?php
    Message::displayall();
    if (!checkpermission("addsznev")) {
        displaymessage("danger", "Nincs jogosultsága új liturgiatípus hozzáadására!");
        exit;
    }
    ?>
</div>
<main class="container d-flex justify-content-center">
    <div>
        <form name="create-sznev" action="#" method="post">
        <p><span style="color: red;">* kötelezően kitöltendő mező.</span></p>

                <div class="row my-3">
                    <label for="name" class="col-sm required">Szertartás típusának megnevezése:</label>
                    <input type="text" class="col-sm form-control" name="name" id="name" required autofocus pattern="<?php echo $htmlregexlist["name"]; ?>" <?php autofill("name"); ?>>
                    <div class="col-sm form-text">Példák: szentmise, litánia, szentségimádás.</div>
                </div>
        <button type="submit" class="btn btn-primary text-white"><i class="bi bi-plus-lg"></i> Hozzáadás</button>
        <input type="hidden" name="stage" value="2">
        </form>
        <?php
        if (isset($_POST["stage"]))
        {
        if (correct($_POST["stage"]) == "2")
        {
            $name = correct($_POST["name"]);
            if (!check($name, "name")) {
                formvalidation("#name", false, "Ez a mező csak kis- és nagybetűket, pontot, szóközt és kötőjelet tartalmazhat.");
            } else {
            $sql = "SELECT `id` FROM `sznev`";
            $id = 0;
            $eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
            while ($row = mysqli_fetch_array($eredmeny))
            {
                $_id = $row['id'];
                $id = $_id + 1;
            }
            $sql = "INSERT INTO `sznev`(`id`, `name`) VALUES ('".$id."','".$name."')";
            $eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
            if ($eredmeny == true)
            {
                $message = new Message("Liturgiatípus hozzáadása sikeres.", MessageType::success);
                $message->insertontop();
            }else{
                $message = new Message("Liturgiatípus hozzáadása sikertelen.", MessageType::danger);
                $message->insertontop();
            } }
        }
        }
        ?>
    </div>
</main>
<?php include("footer.php"); ?>
</body>
</html>