<?php ob_start(); ?>
<!DOCTYPE html>
<html>
<head>
<?php include("head.php"); ?>
<title>Oldal szerkesztése - <?php echo $sitename; ?></title>
<meta name="language" content="hu-HU">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="/vendor/tinymce/tinymce/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: "#content",
        language: "hu_HU",
        plugins: "image, link",
    });
</script>
</head>
<body class="d-flex flex-column h-100">
<?php
displayhead("Oldal módosítása");
include("headforadmin.php");
?>
<div id="messagesdiv">
<?php
Message::displayall();
if (!checkpermission("editpage")) {
    displaymessage("danger", "Nincs jogosultsága oldal módosításához!");
    exit;
}
?>
</div>
<main class="container">
<div>
    <?php
    if (!isset($_POST["stage"])) {
        $id = correct($_POST["id"]);
    if (check($id, "number") || $id == 0) {
    $sql = "SELECT `title`, `content`, `coverimgpath`, `url` FROM `oldalak` WHERE `id` = '$id'";
    $eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
    $oldal = mysqli_fetch_array($eredmeny);
    }
if (isset($_POST["title"])) {
    $oldal["title"] = correct($_POST["title"]);
    $oldal["content"] = $_POST["content"];
    $oldal["url"] = correct($_POST["url"]);
    if (!check($oldal["url"], "path")) {
        displaymessage("danger", "Az URL cím helytelen értékeket tartalmaz!");
        mysqli_close($mysql);
        exit;
    }
    $oldal["coverimgpath"] = $_POST["coverimgpath"];
    if ($oldal["coverimgpath"] == null || !check($oldal["coverimgpath"], "path")) {
        $oldal["coverimgpath"] = null;
    }
}
    ?>
    <form name="edit-oldal" action="#" method="post">
	<div class="row my-3">
		<label class="form-label col-sm-2" for="title">Oldal címe: </label>
		<input type="text" name="title" value="<?php echo $oldal["title"]; ?>" required class="form-control col-sm" id="title">
	</div>
    <div class="row my-3">
		<label class="form-label col-sm-2" for="url">Oldal URL címe: </label>
		<div class="input-group col-sm">
            <span class="input-group-text">page.php?page=</span>
            <input type="text" name="url" value="<?php echo $oldal["url"]; ?>" disabled required class="form-control" id="url" aria-describedby="basic-addon3">
        </div>
	</div>
    <div class="row my-3">
		<label class="form-label col-sm-2" for="coverimgpath">Oldal fejlécképe: </label>
		<input type="text" name="coverimgpath" value="<?php echo $oldal["coverimgpath"]; ?>" class="form-control col-sm" id="coverimgpath">
        <label class="form-text col-sm">A képnek az elérhetősége, ami majd az oldal tetején, a cím mögött jelenik meg. A kép lehet ezen a szerveren, vagy bárhol az interneten.</label>
	</div>
	<div class="row my-3">
		<label class="form-label col-sm-2" for="content">Oldal tartalma: </label>
		<textarea name="content" class="form-control col-sm" id="content"><?php echo $oldal["content"]; ?></textarea>
	</div>
	<button type="submit" class="btn btn-primary text-white"><i class="bi bi-arrow-right"></i> Tovább</button>
	<input type="hidden" name="stage" value="2">
    <input type="hidden" name="url" value="<?php echo $oldal["url"]; ?>">
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    </form>
    <?php
    } else if (isset($_POST["stage"]))
    {
        if (correct($_POST["stage"]) == 2)
        {
            $title = correct($_POST["title"]);
            $content = $_POST["content"];
            $htmlcontent = $content;
            $url = correct($_POST["url"]);
            if (!check($url, "path")) {
                displaymessage("danger", "Az URL cím helytelen értékeket tartalmaz!");
                mysqli_close($mysql);
                exit;
            }
            $image = $_POST["coverimgpath"];
            if ($image == null || !check($image, "path")) {
                $image = null;
            }    
            ?>
            <p>Előnézet:</p>
            <div class="oldal">
            <p class="oldal"><?php echo $htmlcontent; ?></p>
            </div>
            <form name="edit-oldal-elonezet" action="#" method="post">
            <table class="form">
            <input type="hidden" name="title" value="<?php echo $title; ?>">
            <input type="hidden" name="id" value="<?php echo correct($_POST["id"]); ?>">
            <input type="hidden" name="content" value='<?php echo $htmlcontent; ?>'>
            <input type="hidden" name="url" value="<?php echo $url;?>">
            <?php
            if ($image != null) {
            ?>
            <input type="hidden" name="coverimgpath" value="<?php echo $image; ?>">
            <?php
            }
            ?>
            <input type="hidden" name="stage" value="3">
            <tr>
            <td><label></label></td>
            <td>
            <button type="submit" class="btn btn-primary text-white"><i class="bi bi-arrow-bar-up"></i> Közzététel</button>
            </form>
            <form action="#" method="post">
            <input type="hidden" name="title" value="<?php echo $title; ?>">
            <input type="hidden" name="id" value="<?php echo correct($_POST["id"]); ?>">
            <input type="hidden" name="content" value='<?php echo $htmlcontent; ?>'>
            <input type="hidden" name="url" value="<?php echo $url;?>">
            <?php
            if ($image != null) {
            ?>
            <input type="hidden" name="coverimgpath" value="<?php echo $image; ?>">
            <?php
            }
            ?>
                <button type="submit" class="btn btn-info text-white"><i class="bi bi-arrow-left"></i> Vissza</button></form></td>
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
            $htmlcontent = $content;
            $url = correct($_POST["url"]);
            if (!check($url, "path")) {
                displaymessage("danger", "Az URL cím helytelen értékeket tartalmaz!");
                mysqli_close($mysql);
                exit;
            }
            if (isset($_POST["coverimgpath"])) {
            $image = $_POST["coverimgpath"]; } else { $image = null; }
            if ($image == null || !check($image, "path")) {
                $image = null;
            }
            $id = correct($_POST["id"]);
            $sql = "UPDATE `oldalak` SET `title`='$title',`content`='$content',`coverimgpath`=";
            if ($image == null) {
                $sql .= "NULL";
            } else {
                $sql .= "'$image'";
            }
            $sql .= ",`lastupdated`='".date("Y-m-d H:i:s")."' WHERE `id` = '$id'";
            $eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
            if ($eredmeny == true)
            {
               $_SESSION["messages"][] = new Message("Sikeres publikálás!", MessageType::success, true);
               mysqli_close($mysql);
               header("Location: page.php?page=".$url);
            }else{
                ?>
                <p class="warning">Valami hiba történt!</p>
                <p>Kérem, próbálja újra!</p>
                <?php
            } }
        }
    ?>
</div>
</main>
<?php include("footer.php"); ?>
</body>
</html>