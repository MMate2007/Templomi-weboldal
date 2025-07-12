<?php ob_start(); ?>
<!DOCTYPE html>
<html>
<head>
<?php include("head.php"); ?>
<title>Oldal létrehozása - <?php echo $sitename; ?></title>
<meta name="language" content="hu-HU">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="/vendor/tinymce/tinymce/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: "#content",
        language: "hu_HU",
        plugins: "image, link",
		images_upload_url: 'api.upload.image.php',
        images_reuse_filename: true
    });
</script>
</head>
<body>
<?php
displayhead("Oldal létrehozása");
include("headforadmin.php");
?>
<div id="messagesdiv">
	<?php
	Message::displayall();
	if (!checkpermission("addpage")) {
		displaymessage("danger", "Nincs jogosultsága oldal létrehozásához!");
		exit;
	}
	?>
</div>
<main class="container">
<?php
if (!isset($_POST["stage"]))
{
	?>
	<form name="create-post" action="#" method="post">
	<div class="row my-3">
		<label class="form-label col-sm-2" for="title">Oldal címe: </label>
		<input type="text" name="title" <?php autofill("title"); ?> required class="form-control col-sm" id="title">
	</div>
	<div class="row my-3">
		<label class="form-label col-sm-2">Hozzáadás a menühöz: </label>
		<div class="form-check form-check-inline">
			<input type="radio" name="addtonav" value="0" id="addtonav0" class="form-check-input" <?php autofillcheck("addtonav", "0"); ?>>
			<label for="addtonav0" class="form-check-label">Nem</label>
		</div>
		<div class="form-check form-check-inline">
			<input type="radio" name="addtonav" value="1" id="addtonav1" class="form-check-input" <?php if (isset($_POST["addtonav"])) { if ($_POST["addtonav"] != 0) { echo "checked"; } } else { echo "checked"; } ?>>
			<label for="addtonav1" class="form-check-label">Igen</label>
		</div>
	</div>
    <div class="row my-3">
		<label class="form-label col-sm-2" for="url">Oldal URL címe: </label>
		<div class="input-group col-sm">
            <span class="input-group-text">page.php?page=</span>
            <input type="text" name="url" <?php autofill("url"); ?> required class="form-control" id="url" aria-describedby="basic-addon3">
        </div>
	</div>
    <div class="row my-3">
		<label class="form-label col-sm-2" for="coverimgpath">Oldal fejlécképe: </label>
		<input type="text" name="coverimgpath" <?php autofill("coverimgpath"); ?> class="form-control col-sm" id="coverimgpath">
        <label class="form-text col-sm">A képnek az elérhetősége, ami majd az oldal tetején, a cím mögött jelenik meg. A kép lehet ezen a szerveren, vagy bárhol az interneten.</label>
	</div>
	<div class="row my-3">
		<label class="form-label col-sm-2" for="content">Oldal tartalma: </label>
		<textarea name="content" class="form-control col-sm" id="content"><?php if (isset($_POST["content"])): echo $_POST["content"]; endif ?></textarea>
	</div>
	<button type="submit" class="btn btn-primary text-white"><i class="bi bi-arrow-right"></i> Tovább</button>
	<input type="hidden" name="stage" value="2">
	</form>
	<?php
} else if (isset($_POST["stage"]))
{
	if (correct($_POST["stage"]) == "2")
	{
		$title = $_POST["title"];
		$content = $_POST["content"];
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
		$addtonav = correct($_POST["addtonav"]);
		if ($addtonav == null) {
			$addtonav = 0;
		}
		?>
		<p>Íme az oldal tartalmának előnézete: </p>
		<div class="oldal">
		<?php echo $content;?>
		</div>
		<br>
		<form name="create-post-2" class="inline" id="first" action="#" method="post" style="display: inline;">
		<input type="hidden" name="title" value="<?php echo $title;?>">
		<input type="hidden" name="content" value='<?php echo $content;?>'>
		<input type="hidden" name="addtonav" value="<?php echo $addtonav;?>">
		<input type="hidden" name="url" value="<?php echo $url;?>">
        <?php
        if ($image != null) {
            ?>
            <input type="hidden" name="coverimgpath" value="<?php echo $image; ?>">
            <?php
        }
        ?>
		<input type="hidden" name="stage" value="3">
		<button type="submit" class="btn btn-primary text-white"><i class="bi bi-arrow-bar-up"></i> Közzététel</button>
		</form>
		<form name="create-post-2-back" class="inline" action="#" method="post" style="display: inline;">
		<input type="hidden" name="title" value="<?php echo $title;?>">
		<input type="hidden" name="content" value='<?php echo $content;?>'>
		<input type="hidden" name="url" value="<?php echo $url;?>">
		<input type="hidden" name="addtonav" value="<?php echo $addtonav;?>">
        <?php
        if ($image != null) {
            ?>
            <input type="hidden" name="coverimgpath" value="<?php echo $image; ?>">
            <?php
        }
        ?>
		<button type="submit" class="btn btn-secondary text-white" style="display: inline;"><i class="bi bi-arrow-left"></i> Vissza</button>
		</form>
		<?php
	}
	if (correct($_POST["stage"]) == "3")
	{
		$title = $_POST["title"];
		$content = $_POST["content"];
        $url = correct($_POST["url"]);
        if (!check($url, "path")) {
            displaymessage("danger", "Az URL cím helytelen értékeket tartalmaz!");
            mysqli_close($mysql);
            exit;
        }
		if (isset($_POST["coverimgpath"])) {
		$image = $_POST["coverimgpath"]; } else { $image=null; }
        if ($image == null || !check($image, "path")) {
            $image = null;
        }
		$addtonav = correct($_POST["addtonav"]);
		if ($addtonav == null) {
			$addtonav = 0;
		}
		$sql = "INSERT INTO `oldalak`(`title`, `url`, `content`, `coverimgpath`) VALUES ('$title','$url','$content',";
        if ($image == null) {
            $sql .= "NULL)";
        } else {
            $sql .= "'$image')";
        }
		$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
		if ($eredmeny == true)
		{
			if ($addtonav) {
				$sql = "SELECT MAX(`id`), MAX(`sorszam`) FROM `nav` WHERE `navid` = 'desktop'";
				$eredmeny = mysqli_query($mysql, $sql);
                $row = mysqli_fetch_array($eredmeny);
                $id = $row["MAX(`id`)"] + 1;
				$sorszam = $row["MAX(`sorszam`)"] + 1;
				$sql = "INSERT INTO `nav`(`id`, `navid`, `sorszam`, `parentid`, `url`, `name`, `newtab`, `tooltip`) VALUES ('$id','desktop','$sorszam',NULL,'page.php?page=$url','$title','0',NULL)";
				$eredmeny = mysqli_query($mysql, $sql);
				if ($eredmeny) {
					$_SESSION["messages"][] = new Message("Oldal hozzáadva a  menühöz.", MessageType::success);
				}
			}
			$_SESSION["messages"][] = new Message("Oldal sikeresen publikálva.", MessageType::success);
			mysqli_close($mysql);
			header("Location: page.php?page=".$url);
		}else{
			$message = new Message("Valami hiba történt.", MessageType::danger, false);
			$message->insertontop();
			?>
			<p>Kérem, kattintson az alábbi gombra!</p>
			<form action="#" method="post">
			<input type="hidden" name="title" value="<?php echo $title;?>">
			<input type="hidden" name="content" value='<?php echo $content;?>'>
			<input type="hidden" name="userid" value="<?php echo $authorid;?>">
			<input type="submit" value="Újrapróbálkozás">
			</form>
			<?php
		}
	}
}
?>
</main>
<?php include("footer.php"); ?>
</body>
</html>