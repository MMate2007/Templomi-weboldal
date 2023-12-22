<?php ob_start(); ?>
<!DOCTYPE html>
<html>
<head>
<?php include("head.php"); ?>
<title>Hírek - <?php echo $sitename; ?></title>
<meta name="title" content="Blog - <?php echo $sitename; ?>">
<meta name="description" content="A <?php echo $sitename; ?> blogján követheti, hogy mi történik a fília életében.">
<meta name="language" content="hu-HU">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
div.content div.tartalom div.blog img {max-width: 70%; margin-left: 15%;}
hr:first-child {
	display: none;
}
</style>
</head>
<body>
<?php displayhead("Hírek"); ?>
<main class="container mx-auto" style="padding-top: 10px;">
<?php
if (isset($_SESSION["userId"])) {
	include("headforadmin.php");
if (checkpermission("addpost")) {
	?>
	<div>
		<a href="create.post.php" role="button" class="btn btn-primary text-white float-end"><i class="bi bi-plus-lg"></i> Új bejegyzés hozzáadása</a>
	</div>
	<?php
}
}
?>
<div class="blog">
<?php
	$sql = "SELECT * FROM `blog` ORDER BY id DESC;";
	$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
	while ($row = mysqli_fetch_array($eredmeny))
	{
		$id = $row['id'];
		$title = $row['title'];
		$content = $row['content'];
		$authorid = $row['authorId'];
		$name = "Ismeretlen";
		$date = $row['date'];
		?>
		<hr>
		<div class="bejegyzes" id="<?php echo $id;?>">
		<h2><?php echo $title;?></h2>
		<p class="bejegyzes-meta">Szerző: 
		<?php
		$sql = "SELECT `name` FROM `author` WHERE `id` = '".$authorid."'";
	$eredmeny2 = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
	while ($sor = mysqli_fetch_array($eredmeny2))
	{
		$name_ = $sor["name"];
		$name = $name_;
	}
	echo $name;
		?>, Publikálás dátuma: <?php echo $date;?></p>
		<div class="bejegyzes-content">
		<?php echo $content;?>
		</div>
		<?php
		if (isset($_SESSION["userId"])) {
		if ($_SESSION["userId"] == $authorid || checkpermission("removepost")) {
		?>
		<form action="delete.post.php" method="post">
			<input type="hidden" name="id" value="<?php echo $id; ?>">
			<button class="btn btn-danger text-white" type="submit"><i class="bi bi-trash3"></i> Törlés</button>
		</form>
		<?php
		} }
		?>
		</div>
		<?php
	}
	?>
</div>
</main>
<?php include("footer.php"); ?>
</body>
</html>