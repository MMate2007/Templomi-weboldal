<?php ob_start(); ?>
<!DOCTYPE html>
<html>
<head>
<?php include("head.php"); ?>
<script src="/vendor/tinymce/tinymce/tinymce.min.js" referrerpolicy="origin"></script>
<title>Hirdetés létrehozása - <?php echo $sitename; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script>
    tinymce.init({
        selector: "#content",
        language: "hu_HU",
        plugins: "image",
        images_upload_url: 'api.upload.image.php',
        images_reuse_filename: true
    });
</script>
</head>
<body class="d-flex flex-column h-100">
<?php
displayhead("Hirdetés létrehozása");
include("headforadmin.php");
?>
<div id="messagesdiv">
    <?php
    Message::displayall();
    if (!checkpermission("addhirdetes")) {
        displaymessage("danger", "Nincs jogosultsága hirdetés létrehozásához!");
        exit;
    }
    ?>
</div>
<main class="content container d-flex justify-content-center">
<div>
    <?php
    if (!isset($_POST["stage"])) {
    ?>
    <form name="create-hirdetes" action="#" method="post">
    <p><span style="color: red;">* kötelezően kitöltendő mező.</span></p>
        <div class="row my-3">
        <label for="templom" class="col-sm-2 required">Templom:</label>
        <select class="col-sm form-select" name="templom" id="templom" required>
            <option value="">--Kérem válasszon!--</option>
            <option value="null" <?php if (isset($_POST["templom"])) { if ($_POST["templom"] == "null") { echo "selected"; } } ?>>Minden templom</option>
            <?php
            $sql = "SELECT `id`, `telepulesID`, `name` FROM `templomok`";
            $eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
            while ($row = mysqli_fetch_array($eredmeny)) {
                $sqla = "SELECT `name` FROM `telepulesek` WHERE `id` = '".$row["telepulesID"]."'";;
                $eredmenya = mysqli_query($mysql, $sqla) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
                $rowa = mysqli_fetch_array($eredmenya);
                ?>
                <option value="<?php echo $row["id"]; ?>" <?php if (isset($_POST["templom"])) { if ($_POST["templom"] == $row["id"]) { echo "selected"; } } ?>><?php echo $rowa["name"]; ?> - <?php echo $row["name"]; ?></option>
                <?php
            }
            ?>
        </select>
        <label class="col-sm form-text">Adjuk meg, hogy mely templomra vonatkozik a hirdetés! Ha a hirdetés minden templomra vonatkozik, válasszuk a "Minden templom" lehetőséget!</label>
        </div>
    <div class="row my-3">
        <label for="title" class="col-sm-2 required">Cím:</label>
        <input type="text" class="col-sm form-control" name="title" id="title" <?php autofill("title"); ?> required autofocus>
        <label class="col-sm form-text">Pl.: Megváltozik a csütörtöki szentmisék időpontja!</label>
    </div>
    <div class="row my-3">
        <label for="content" class="col-sm-2">Tartalom: </label>
        <textarea class="col-sm form-control" name="content" id="content"><?php
            if (isset($_POST["content"])) {
                echo $_POST["content"];
            }
            ?></textarea>
        <label class="col-sm form-text">Hosszú vagy rövid leírás, felhívás.</label>
    </div>
    <div class="row my-3">
        <label for="starttime" class="col-sm-2">Megjelenés időpontja:</label>
        <input type="datetime-local" id="starttime" class="col-sm form-control" name="starttime" value="<?php if (isset($_POST["starttime"])) {echo $_POST["starttime"];} else {echo date("Y-m-d H:i");}?>">
        <label class="col-sm form-text">Az az időpont, mikortól a hirdetés láthatóvá válik.</label>
    </div>
    <div class="row my-3">
        <label for="endtime" class="col-sm-2">Eltűnés időpontja:</label>
        <?php
        ?>
        <input type="datetime-local" id="endtime" class="col-sm form-control" name="endtime" <?php autofill("endtime"); ?>>
        <label class="col-sm form-text">Az az időpont, mikortól a hirdetés "eltűnik", láthatatlanná válik.</label>
    </div>
    <button type="submit" class="btn btn-primary text-white"><i class="bi bi-arrow-right"></i> Tovább</button>
    <input type="hidden" name="stage" value="2">
    </form>
    <?php
    } else if (isset($_POST["stage"]))
    {
        if (correct($_POST["stage"]) == 2)
        {
            $mehet = true;
            $title = correct($_POST["title"]);
            $content = $_POST["content"];
            // $mdparser = new Parsedown();
            // $htmlcontent = $mdparser->text($content);
            $htmlcontent = $content;
            $s = date_create($_POST["starttime"]);
            if ($_POST["endtime"] != null) {
            $e = date_create($_POST["endtime"]); } else {
                $e = null;
            }
            ?>
            <p>Megjelenés időpontja: <?php echo date_format($s, "Y. m. d. H:i"); ?>; eltűnés időpontja: <?php if ($e != null) { echo date_format($e, "Y. m. d. H:i"); } else { echo "nem tűnik el"; } ?></p>
            <p>Templom: 
                <?php
                $templom = $_POST["templom"];
                if ($templom == null) {
                    $mehet = false;
                    $message = new Message("Nem választott ki templomot!", MessageType::danger, false);
                    $message->insertontop();
                } else {
                $templom = correct($_POST["templom"]);
                if ($templom == "null") {
                    echo "minden templom";
                } else {
                    $sql = "SELECT `telepulesID`, `name` FROM `templomok` WHERE `id` = '$templom'";
                    $eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
                    while ($row = mysqli_fetch_array($eredmeny)) {
                        $sqla = "SELECT `name` FROM `telepulesek` WHERE `id` = '".$row["telepulesID"]."'";;
                        $eredmenya = mysqli_query($mysql, $sqla) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
                        $rowa = mysqli_fetch_array($eredmenya);
                        echo $rowa["name"];
                        echo " - ";
                        echo $row["name"];
                    }
                } }
                ?>
            </p>
            <p>Előnézet:</p>
            <div class="hirdetotabla">
            <h3 class="hirdetotabla"><?php echo $title; ?></h3>
            <p class="hirdetotabla"><?php echo $htmlcontent; ?></p>
            </div>
            <form name="create-hirdetes-elonezet" action="#" method="post">
            <table class="form">
            <input type="hidden" name="title" value="<?php echo $title; ?>">
            <input type="hidden" name="content" value='<?php echo $content; ?>'>
            <input type="hidden" name="starttime" value="<?php echo date_format($s, "Y-m-d H:i:s"); ?>">
            <input type="hidden" name="endtime" value="<?php if ($e != null) { echo date_format($e, "Y-m-d H:i:s"); } ?>">
            <input type="hidden" name="templom" value="<?php echo $templom; ?>">
            <input type="hidden" name="stage" value="3">
            <tr>
            <td><label></label></td>
            <td>
            <?php
            if ($s < date_create()) {
                $message = new Message("A megadott kezdőidőpont a múltban van.", MessageType::warning, false);
                $message->insertontop();

            }
            if ($e <= date_create() && $e != null) {
                $message = new Message("Az eltűnés időpontja a múltban van. Kérem, orvosolja a problémát.", MessageType::danger, false);
                $message->insertontop();
                $mehet = false;
            } 
            if ($mehet == true) {
                ?>
            <button type="submit" class="btn btn-primary text-white" style="display: inline;"><i class="bi bi-arrow-bar-up"></i> Közzététel</button>
                <?php
            }
            ?>
            </form><form action="#" method="post"><input type="hidden" name="templom" value="<?php echo $templom; ?>"><input type="hidden" name="title" value="<?php echo $title; ?>">
            <input type="hidden" name="content" value='<?php echo $content; ?>'><input type="hidden" name="starttime" value="<?php echo date_format($s, "Y-m-d H:i"); ?>"><input type="hidden" name="endtime" value="<?php if ($e != null) { echo date_format($e, "Y-m-d H:i"); } ?>"><button type="submit" class="btn btn-info text-white" style="display: inline;"><i class="bi bi-arrow-left"></i> Vissza</button></form></td>
            <td><label></label></td>
            </tr>
            </table>
            </form>
            <?php
        }
        if (correct($_POST["stage"]) == 3)
        {
            $title = correct($_POST["title"]);
            $content = $_POST["content"];
            $starttime = $_POST["starttime"];
            $endtime = $_POST["endtime"];
            $templom = $_POST["templom"];
            if ($templom == "null") {
                $templom = null;
            }
            $sql = "SELECT `ID` FROM `hirdetesek`";
            $id = 0;
            $eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
            while ($row = mysqli_fetch_array($eredmeny))
            {
                $_id = $row['ID'];
                $id = $_id + 1;
            }
            $sql = "INSERT INTO `hirdetesek`(`ID`, `title`, `content`, `authorid`, `starttime`, `endtime`, `templomID`) VALUES ('$id','$title','$content','".$_SESSION["userId"]."','$starttime',";
            if ($endtime == null) {
                $sql .= "NULL,";
            } else {
                $sql .= "'$endtime',";
            }
            if ($templom == null) {
                $sql .= "NULL)";
            } else {
                $sql .= "'$templom')";
            }
            $eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
            ?>
            <?php
            if ($eredmeny == true)
            {
                $_SESSION["messages"][] = new Message("Hirdetés sikeresen létrehozva.", MessageType::success);
                mysqli_close($mysql);
                header("Location: hirdetesek.php");
            }else{
                ?>
                <p class="warning">Valami hiba történt!</p>
                <p>Kérem, próbálja újra!</p>
                <form action="#" method="post">
                <input type="hidden" name="stage" value="3">
                <input type="hidden" name="title" value="<?php echo $title; ?>">
                <input type="hidden" name="content" value="<?php echo $content; ?>">
                <input type="hidden" name="starttime" value="<?php echo $starttime; ?>">
                <input type="submit" value="Újrapróbálkozás">
                </form>
                <?php
            }
        }
    }
    ?>
</div>
</main>
<?php include("footer.php"); ?>
</body>
</html>