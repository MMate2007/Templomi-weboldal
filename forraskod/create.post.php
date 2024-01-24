<?php ob_start(); ?>
<!DOCTYPE html>
<html>
<head>
<?php include("head.php"); ?>
<title>Blogbejegyzés létrehozása - <?php echo $sitename; ?></title>
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
<body>
<?php
displayhead("Blogbejegyzés létrehozása");
include("headforadmin.php");
if (!checkpermission("addpost")) {
	displaymessage("danger", "Nincs jogosultsága bejegyzés létrehozásához!");
	exit;
}
?>
<main class="container">
<?php
if (!isset($_POST["stage"]))
{
	?>
	<form name="create-post" action="#" method="post">
	<div class="row my-3">
		<label class="form-label col-sm-2" for="title">Bejegyzés címe: </label>
		<input type="text" name="title" <?php autofill("title"); ?> required class="form-control col-sm" id="title">
	</div>
	<div class="row my-3">
		<label class="form-label col-sm-2" for="content">Bejegyzés tartalma: </label>
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
		$uid = $_SESSION["userId"];
		$title = $_POST["title"];
		$content = $_POST["content"];
		$image = null;
		$name = "Ismeretlen";
		$sql = "SELECT `name` FROM `author` WHERE `id` = '".$uid."'";
		$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
		while ($row = mysqli_fetch_array($eredmeny))
		{
			$name_ = $row["name"];
			$name = $name_;
		}
		?>
		<p>Íme a bejegyzés előnézete: </p>
		<div class="bejegyzes">
		<h2><?php echo $title;?></h2>
		<p class="bejegyzes-meta">Szerző: <?php echo $name;?>, Publikálás dátuma: <?php echo date("Y. m. d. H:i");?></p>
		<div class="bejegyzes-content">
		<?php echo $content;?>
		</div>
		</div>
		<br>
		<form name="create-post-2" class="inline" id="first" action="#" method="post" style="display: inline;">
		<input type="hidden" name="title" value="<?php echo $title;?>">
		<input type="hidden" name="content" value='<?php echo $content;?>'>
		<input type="hidden" name="userid" value="<?php echo $uid;?>">
		<input type="hidden" name="stage" value="3">
		<button type="submit" class="btn btn-primary text-white"><i class="bi bi-arrow-bar-up"></i> Közzététel</button>
		</form>
		<form name="create-post-2-back" class="inline" action="#" method="post" style="display: inline;">
		<input type="hidden" name="title" value="<?php echo $title;?>">
		<input type="hidden" name="content" value='<?php echo $content;?>'>
		<input type="hidden" name="userid" value="<?php echo $uid;?>">
		<button type="submit" class="btn btn-secondary text-white" style="display: inline;"><i class="bi bi-arrow-left"></i> Vissza</button>
		</form>
		<?php
	}
	if (correct($_POST["stage"]) == "3")
	{
		$title = $_POST["title"];
		$content = $_POST["content"];
		$authorid = $_POST["userid"];
		$date = date("Y-m-d H:i:s");
		$sql = "SELECT `id` FROM `blog`";
		$id = 0;
		$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
		while ($row = mysqli_fetch_array($eredmeny))
		{
			$_id = $row['id'];
			$id = $_id + 1;
		}
		$sql = "INSERT INTO `blog`(`id`, `title`, `content`, `authorId`, `date`) VALUES ('".$id."','".$title."','".$content."','".$authorid."','".$date."')";
		$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
		if ($eredmeny == true)
		{
			displaymessage("success", "Sikeres publikáció!");
		}else{
			displaymessage("danger", "Valami hiba történt.");
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