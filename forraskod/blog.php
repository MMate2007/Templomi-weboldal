<html>
<head>
<title>Blog - Példa plébánia</title>
<meta charset="utf-8">
<meta name="title" content="Blog - Példa plébánia">
<meta name="language" content="hu-HU">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="style.css">
<link rel="icon" type="image/pnp" href="icon.png">
<!--<meta name="keywords" content="">-->
<!--<meta name="theme-color" content="#ffea00">-->
<style>
header nav a[href="http://<?php echo $_SERVER['HTTP_HOST']; echo $_SERVER['PHP_SELF'];?>"], nav a[href="http://<?php echo $_SERVER['HTTP_HOST']; echo $_SERVER['PHP_SELF'];?>"] {font-weight: bold;}
@media only screen and (max-width: 600px) {
div.head-text {
	position: absolute;
	top: 5px;
	left: 0px;
}
div.head-text h1 {font-size: 20pt;}
}
@media only screen and (min-width: 600px) {
div.head-text {
	position: absolute;
	top: 0px;
	left: 10px;
}
div.head-text h1 {font-size: 49pt;}
}
@media only screen and (min-width: 1349px) {
div.head-text {
	position: absolute;
	top: 20px;
	left: 100px;
}
}
div.content div.tartalom div.blog img {max-width: 70%; margin-left: 15%;}
div.fejlecparallax {
    background-image: url("DSC_0080.JPG");
}
</style>
</head>
<body>
<header>
<div class="head">
<!--<img class="head" src="fejlec.jpg" style="width: 100%;">-->
<!--<img class="head" src="fejlecvekony.jpg" style="width: 100%;">-->
<div class="fejlecparallax">
<div class="head-text">
<h1>Példa plébánia honlapja - Blog</h1>
</div>
</div>
</div>
<hr>
<nav>
<?php include("navbar.php"); ?>
</nav>
</header>
<div class="content">
<div class="tartalom">
<div class="blog">
<?php
	$mysql = mysqli_connect("localhost", "mysqlfelhasznalo", "mysqljelszo", "adatbazisnev") or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
	mysqli_query($mysql, "SET NAMES utf8");
	$sql = "SELECT * FROM `blog` ORDER BY id DESC;";
	$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
	while ($row = mysqli_fetch_array($eredmeny))
	{
		$id = $row['id'];
		$title = $row['title'];
		$content = $row['content'];
		$authorid = $row['authorId'];
		$image = $row['image'];
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
		<?php
		if ($image != null && $image != "")
		{
			?>
			<br>
			<img src="<?php echo $image;?>">
			<?php
		}
		?>
		</div>
		</div>
		<?php
	}
	mysqli_close($mysql);
	?>
</div>
</div>
</div>
<div class="sidebar">
</div>
<?php include("footer.php"); ?>
</body>
</html>
