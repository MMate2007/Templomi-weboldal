<html>
<head>
<title>Előnézet - Blogbejegyzés létrehozása - Példa plébánia</title>
<meta charset="utf-8">
<meta name="language" content="hu-HU">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="style.css">
<link rel="icon" type="image/pnp" href="icon.png">
<!--<meta name="theme-color" content="#ffea00">-->

<style>
	header nav a[href="http://<?php echo $_SERVER['HTTP_HOST']; echo $_SERVER['PHP_SELF'];?>"], nav a[href="http://<?php echo $_SERVER['HTTP_HOST']; echo $_SERVER['PHP_SELF'];?>"] {font-weight: bold;}
@media only screen and (max-width: 800px) {
div.head-text {
	position: absolute;
	top: 10px;
	left: 30px;
}
div.head-text h1 {font-size: 20pt;}
}
@media only screen and (min-width: 600px) {
div.head-text {
	position: absolute;
	top: 10px;
	left: 50px;
}
div.head-text h1 {font-size: 72pt;}
}
@media only screen and (min-width: 1349px) {
div.head-text {
	position: absolute;
	top: 25px;
	left: 100px;
}
}
div.bejegyzes img {max-width: 70%; margin-left: 15%;}
</style>
</head>
<body>
<header>
<div class="head">
<!--<img class="head" src="fejlec.jpg" style="width: 100%;">-->
<!--<img class="head" src="fejlecvekony.jpg" style="width: 100%;">-->
<div class="fejlecparallax">
<div class="head-text">
<h1>Példa plébánia honlapja - Blogbejegyzés létrehozása - Előnézet</h1>
</div>
</div>
</div>
<hr>
<nav>
<?php include("navbar.php"); ?>
<?php
session_start();
if (!isset($_SESSION["userId"]))
{
	header("Location: hozzaferes.php");
}
$mysql = mysqli_connect("localhost", "mysqlfelhasznalo", "mysqljelszo", "adatbazisnev") or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
mysqli_query($mysql, "SET NAMES utf8");
$sql = "SELECT `name` FROM `author` WHERE `id` = '".$_SESSION["userId"]."'";
$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
while ($row = mysqli_fetch_array($eredmeny))
{
	$name = $row["name"];
	if ($name != $_SESSION["name"])
	{
		mysqli_close($mysql);
		header("Location: hozzaferes.php");
	}
}
if ($_SESSION["userId"] == 0)
{
$uid = $_POST["user"];
}else{
	$uid = $_SESSION["userId"];
}
$title = $_POST["title"];
$content = $_POST["content"];
$image = $_POST["imagesrc"];
$name = "Ismeretlen";
$date = date("Y.m.d H:i");
$sql = "SELECT `name` FROM `author` WHERE `id` = '".$uid."'";
$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
	while ($row = mysqli_fetch_array($eredmeny))
	{
		$name_ = $row["name"];
		$name = $name_;
	}
mysqli_close($mysql);
?>
<a href="logout.php" class="right">Kijelentkezés</a>
<a href="form.create.hirdetes.php" class="right">Hirdetés létrehozása</a>
<a href="form.create.szertartas.php" class="right">Liturgia hozzáadása</a>
<a href="admin.php" class="right" id="right-elso">Adminisztráció</a>
</nav>
<hr>
</header>
<p>Íme a bejegyzés előnézete: </p>
<div class="bejegyzes">
		<h2><?php echo $title;?></h2>
		<p class="bejegyzes-meta">Szerző: <?php echo $name;?>, Publikálás dátuma: <?php echo $date;?></p>
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
		<br>
<form name="create-post-2" class="inline" id="first" action="create.post.php" method="post">
<input type="hidden" name="title" value="<?php echo $title;?>">
<input type="hidden" name="content" value="<?php echo $content;?>">
<input type="hidden" name="userid" value="<?php echo $uid;?>">
<input type="hidden" name="imagesrc" value="<?php echo $image;?>">
<input type="submit" value="Közzététel">
</form>
<form name="create-post-2-back" class="inline" action="form3.create.post.php" method="post">
<input type="hidden" name="title" value="<?php echo $title;?>">
<input type="hidden" name="content" value="<?php echo $content;?>">
<input type="hidden" name="userid" value="<?php echo $uid;?>">
<input type="hidden" name="imagesrc" value="<?php echo $image;?>">
<input type="submit" value="Vissza">
</form>
<?php include("footer.php"); ?>
</body>
</html>