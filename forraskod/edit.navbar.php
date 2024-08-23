<?php ob_start(); ?>
<!DOCTYPE html>
<html>
<head>
<?php include("head.php"); ?>
<title>Menüsáv szerkesztése - <?php echo $sitename; ?></title>
</head>
<body class="d-flex flex-column h-100">
<?php
displayhead("Menüsáv szerkesztése");
include("headforadmin.php");
if (!checkpermission("editnavbar")) {
    displaymessage("danger", "Nincs jogosultsága oldal módosításához!");
    exit;
}
?>
<main class="container" style="padding: 10px;">
<p><span style="color: red;">* kötelezően kitöltendő mező.</span></p>

    <?php
    if (!isset($_POST["navid"])) {
        ?>
        <form action="#" method="post" id="selectnav">
            <div class="row">
                <label for="navbarselect" class="col-sm-2">Menüsáv:</label>
                <select name="navid" id="navbarselect" class="col-sm form-select required" required>
                    <option value="">--Kérem adja meg!--</option>
                    <?php
                    foreach ($navbars as $short=>$full) {
                        ?>
                        <option value="<?php echo $short; ?>"><?php echo $full; ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <button class="btn btn-primary text-white" type="submit"><i class="bi bi-arrow-right"></i> Tovább</button>
        </form>
        <?php
    } else {
        if (!isset($_POST["query"])) {
            $navid = correct($_POST["navid"]);
            $sql = "SELECT MAX(`sorszam`) FROM `nav` WHERE `navid` = '$navid'";
            $eredmeny = mysqli_query($mysql, $sql);
            $row = mysqli_fetch_array($eredmeny);
            $sorszam = correct($row["MAX(`sorszam`)"]) + 1;
            if (!check($sorszam, "number")) {
                mysqli_close($mysql);
                exit;
            }
            ?>
            <form action="#" method="post" id="addnew" style="padding-bottom: 10px;">
                <div class="row my-3">
                    <label for="name" class="col-sm-2 required">Megjelenített név:</label>
                    <input type="text" name="name" id="name" class="col-sm form-control" required placeholder="Valami" pattern="<?php echo $htmlregexlist["name"]; ?>">
                </div>
                <div class="row my-3">
                    <label for="url" class="col-sm-2 required">URL:</label>
                    <input type="text" name="url" id="url" class="col-sm form-control" required placeholder="valami.php">
                </div>
                <div class="row my-3">
                    <label for="tooltip" class="col-sm-2">Segítő szöveg:</label>
                    <input type="text" name="tooltip" id="tooltip" class="col-sm form-control" pattern="<?php echo $htmlregexlist["name"]; ?>">
                    <label class="form-text col-sm">Ha a link fölé visszük az egeret, ez a szöveg jelenik meg. Itt röviden le lehet írni, hogy mit takar az adott link.</label>
                </div>
                <div class="row my-3">
                    <label for="sorszam" class="col-sm-2 required">Pozíció:</label>
                    <input type="number" name="sorszam" id="sorszam" min="0" class="col-sm form-control" required value="<?php echo $sorszam; ?>">
                    <label class="form-text col-sm">Hányadikként jelenjen meg? Az elsőként való megjelenítéshez 0-t kell beírni, a másodikhoz 1-t, stb. Ha a menü végére szeretnénk ezt tenni, akkor hagyjuk a beírt értéket.</label>
                </div>
                <div class="row my-3">
                    <label class="col-sm-2 required">Megnyitás új lapon:</label>
                    <div class="form-check form-check-inline">
					<input type="radio" name="newtab" value="0" id="newtab0" class="form-check-input" checked>
					<label for="newtab0" class="form-check-label">Nem</label>
				</div>
				<div class="form-check form-check-inline">
					<input type="radio" name="newtab" value="1" id="newtab1" class="form-check-input">
					<label for="newtab1" class="form-check-label">Igen</label>
				</div>

                    <label class="form-text col-sm">A linkre kattintva a böngésző azt egy új lapon nyitja meg. Ez külső, más weboldalakra mutató linkeknél hasznos.</label>
                </div>
                <input type="hidden" name="query" value="newitem">
                <input type="hidden" name="navid" value="<?php echo $navid; ?>">
                <button class="btn btn-primary text-white" type="submit"><i class="bi bi-plus-lg"></i> Hozzáadás</button>
            </form>
            <table style="width: 100%;">
                    <tr>
                        <th>Név</th>
                        <th>URL</th>
                        <th>Segítő szöveg</th>
                        <th>Pozíció</th>
                        <th>Új lapon nyílik meg</th>
                        <th>Műveletek</th>
                    </tr>
            <?php
            $sql = "SELECT `id`, `sorszam`, `parentid`, `url`, `name`, `tooltip`, `newtab` FROM `nav` WHERE `navid` = '$navid' ORDER BY `sorszam`";
            $eredmeny = mysqli_query($mysql, $sql);
            while ($row = mysqli_fetch_array($eredmeny)) {
                ?>
                    <tr>
                        <td>
                            <?php echo correct($row["name"]); ?>
                        </td>
                        <td>
                            <?php echo correct($row["url"]); ?>
                        </td>
                        <td>
                            <?php echo correct($row["tooltip"]); ?>
                        </td>
                        <td>
                            <?php echo correct($row["sorszam"]); ?>
                        </td>
                        <td>
                            <?php if ($row["newtab"]) {
                                echo "igen";
                            } else {
                                echo "nem";
                            }
                            ?>
                        </td>
                        <td>
                            <form action="#" method="post" id="edit<?php echo correct($row["id"]); ?>" style="display: inline;">
                            <input type="hidden" name="query" value="edit">
                            <input type="hidden" name="id" value="<?php echo correct($row["id"]); ?>">
                            <input type="hidden" name="navid" value="<?php echo $navid; ?>">
                            <input type="hidden" name="">
                            <button type="submit" class="btn btn-primary text-white" disabled style="display: inline;"><i class="bi bi-floppy"></i> Mentés</button>
                            </form>
                            <form action="#" method="post" id="delete<?php echo correct($row["id"]); ?>" style="display: inline;">
                            <input type="hidden" name="query" value="delete">
                            <input type="hidden" name="id" value="<?php echo correct($row["id"]); ?>">
                            <input type="hidden" name="navid" value="<?php echo $navid; ?>">
                            <button type="submit" class="btn btn-danger text-white" style="display: inline;"><i class="bi bi-trash3"></i> Törlés</button>
                            </form>
                        </td>
                    </tr>
                
                <?php
            }
            ?>
            </table>
            <form action="#" method="post" id="edit">
                <input type="hidden" name="query" value="newitem">
                <input type="hidden" name="navid" value="<?php echo $navid; ?>">
            </form>
            <?php
        } else if (isset($_POST["query"])) {
            if ($_POST["query"] == "newitem") {
                $name = correct($_POST["name"]);
                if (!check($name, "name")) {
                    mysqli_close($mysql);
                    exit;
                }
                $url = $_POST["url"];
                if (!check($url, "url")) {
                    mysqli_close($mysql);
                    exit;
                }
                $tooltip = correct($_POST["tooltip"]);
                $sorszam = correct($_POST["sorszam"]);
                $navid = correct($_POST["navid"]);
                if (!check($sorszam, "number")) {
                    mysqli_close($mysql);
                    exit;
                }
                $newtab = correct($_POST["newtab"]);
                if (!check($newtab, "number")) {
                    mysqli_close($mysql);
                    exit;
                }
                $sql = "SELECT MAX(`id`),  MAX(`sorszam`) FROM `nav` WHERE `navid` = '$navid'";
                $eredmeny = mysqli_query($mysql, $sql);
                $row = mysqli_fetch_array($eredmeny);
                $id = $row["MAX(`id`)"] + 1;
                $sorszammax = $row["MAX(`sorszam`)"];
                if ($sorszammax + 1 == $sorszam) {
                    $sql = "INSERT INTO `nav`(`id`, `navid`, `sorszam`, `parentid`, `url`, `name`, `newtab`, `tooltip`) VALUES ('$id','$navid','$sorszam',NULL,'$url','$name','$newtab',";
                    if ($tooltip == null) {
                        $sql .= "NULL)";
                    } else {
                        $sql .= "'$tooltip')";
                    }
                    $eredmeny = mysqli_query($mysql, $sql);
                    if ($eredmeny) {
                        displaymessage("success", "Sikeres hozzáadás!");
                    } else {
                        displaymessage("danger", "Valami nem sikerült.");
                    }
                }
            }
            if ($_POST["query"] == "delete") {
                $id = correct($_POST["id"]);
                if (!check($id, "number")) {
                    mysqli_close($mysql);
                    exit;
                }
                $sql = "DELETE FROM `nav` WHERE `id` = '$id'";
                $eredmeny = mysqli_query($mysql, $sql);
                if ($eredmeny) {
                    displaymessage("success", "Sikeres törlés!");
                } else {
                    displaymessage("danger", "Valami nem sikerült.");
                }

            }
        }
    }
    ?>
</main>
<?php include("footer.php"); ?>
</body>
</html>