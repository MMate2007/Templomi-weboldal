<?php ob_start(); ?>
<!DOCTYPE html>
<html>
<head>
<?php include("head.php"); ?>
<title>Beállítások - <?php echo $sitename; ?></title>
<meta name="language" content="hu-HU">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<?php
displayhead("Beállítások");
include("headforadmin.php");
?>
<div id="messagesdiv">
<?php
if (!checkpermission("editsettings")) {
    displaymessage("danger", "Nincs jogosultsága beállítások módosításához!");
    Message::displayall();
    exit;
}
?>
</div>
<main class="container d-flex justify-content-center">
    <form action="#" method="post">
        <?php
        $sql = "SELECT * FROM `settings`";
        $eredmeny = mysqli_query($mysql, $sql);
        while ($row = mysqli_fetch_array($eredmeny)) {
            if ($row["friendlyname"] == null) {
                $row["friendlyname"] = $row["name"];
            }
            ?>
            <div class="row my-3">
                <label class="col-sm"><?php echo $row["friendlyname"]; ?></label>
                <?php
                switch ($row["type"]) {
                    case 0:
                        ?>
                        <div class="col-sm">
                            <div class="form-check">
                                <label for="setting-input-<?php echo $row["name"]; ?>-igen" class="form-check-label">be</label>
                                <input type="radio" class="form-check-input" name="setting-input-<?php echo $row["name"]; ?>" id="setting-input-<?php echo $row["name"]; ?>-igen" <?php if ($row["value"] == 1) { echo "checked"; } ?> value="1">
                            </div>
                            <div class="form-check">
                                <label for="setting-input-<?php echo $row["name"]; ?>-nem" class="form-check-label">ki</label>
                                <input type="radio" class="form-check-input" name="setting-input-<?php echo $row["name"]; ?>" id="setting-input-<?php echo $row["name"]; ?>-nem" <?php if ($row["value"] == 0) { echo "checked"; } ?> value="0">
                            </div>
                        </div>
                        <?php
                        break;
                    case 1:
                        ?>
                        <div class="col-sm">
                            <input type="number" class="form-control" name="setting-input-<?php echo $row["name"]; ?>" id="setting-input-<?php echo $row["name"]; ?>" value="<?php echo $row["value"]; ?>">
                        </div>
                        <?php
                        break;
                    case 2:
                        ?>
                        <div class="col-sm">
                            <input type="text" class="form-control" name="setting-input-<?php echo $row["name"]; ?>" id="setting-input-<?php echo $row["name"]; ?>" value="<?php echo $row["value"]; ?>">
                        </div>
                        <?php
                        break;
                }
                ?>
                <label class="col-sm form-text"><?php echo $row["description"]; ?></label>
            </div>
            <?php
        }
        ?>
        <input type="hidden" name="stage" value="1">
        <button class="btn btn-primary text-white" type="submit"><i class="bi bi-floppy"></i> Mentés</button>
    </form>
    <?php
        if (isset($_POST["stage"]))
        {
            $post = $_POST;
            foreach ($post as $key=>$value) {
                $kulcs = str_replace("setting-input-", "", $key, $count);
                if ($count == 0) {
                    continue;
                }
                $kulcs = str_replace("_", ".", $kulcs);
                if ($value === "") {
                    $value = null;
                }
                $sql = "UPDATE `settings` SET `value`= ";
                if ($value === null) {
                    $sql .= "NULL";
                } else {
                    $sql .= "'$value'";
                }
                $sql .= " WHERE `name` = '$kulcs'";
                mysqli_query($mysql, $sql);
            }
            $message = new Message("Sikeres mentés!", MessageType::success);
            $message->insertontop();
        }
    ?>
</main>
<?php include("footer.php"); ?>
</body>
</html>