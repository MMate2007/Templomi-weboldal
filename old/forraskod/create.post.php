<html>
<head>
<meta charset="utf-8">
<title>Közzététel...</title>
<meta name="language" content="hu-HU">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="style.css">
<link rel="icon" type="image/pnp" href="icon.png">
<style>
	header nav a[href="http://<?php echo $_SERVER['HTTP_HOST']; echo $_SERVER['PHP_SELF'];?>"], nav a[href="http://<?php echo $_SERVER['HTTP_HOST']; echo $_SERVER['PHP_SELF'];?>"] {font-weight: bold;}
</style>
<!--<meta name="theme-color" content="#ffea00">-->
<!---->
</head>
<body>
<header>
<div class="head">
<!--<img class="head" src="fejlec.jpg" style="width: 100%;">-->
<!--<img class="head" src="fejlecvekony.jpg" style="width: 100%;">-->
<div class="fejlecparallax">
<div class="head-text">
<h1>Példa plébánia honlapja - Blogbejegyzés közzététele...</h1>
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
mysqli_close($mysql);
?>
<a href="logout.php" class="right">Kijelentkezés</a>
<a href="form.create.hirdetes.php" class="right">Hirdetés létrehozása</a>
<a href="form.create.szertartas.php" class="right">Liturgia hozzáadása</a>
<a href="admin.php" class="right" id="right-elso">Adminisztráció</a>
</nav>
<hr>
</header>
<?php
$title = $_POST["title"];
$content = $_POST["content"];
$authorid = $_POST["userid"];
$image = $_POST["imagesrc"];
$date = date("Y.m.d H:i");
$mysql = mysqli_connect("localhost", "mysqlfelhasznalo", "mysqljelszo", "adatbazisnev") or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
mysqli_query($mysql, "SET NAMES utf8");
$sql = "SELECT `id` FROM `blog`";
$id = 0;
$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
while ($row = mysqli_fetch_array($eredmeny))
{
	$_id = $row['id'];
	$id = $_id + 1;
}
$sql = "INSERT INTO `blog`(`id`, `title`, `content`, `authorId`, `date`, `image`) VALUES ('".$id."','".$title."','".$content."','".$authorid."','".$date."','".$image."')";
$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
mysqli_close($mysql);
?>
<div class="content">
<div class="tartalom">
<?php
if ($eredmeny == true)
{
	?>
	<p class="succes">Sikeres publikáció!</p>
	<script>
	alert("Sikeres publikáció! Köszönjük, hogy tartalmával támogatta a weboldal működését! Isten fizesse meg!");
	var result = confirm("Meg szeretné nézni a blogot?");
	if (result == true)
	{
		window.location.replace("blog.php");
	}else{
		window.location.replace("admin.php");
	}
	</script>
	<?php
}else{
	?>
	<p class="warning">Valami hiba történt!</p>
	<p>Kérem, kattintson az alábbi gombra!</p>
	<form action="form3.create.post.php" method="post">
	<input type="hidden" name="title" value="<?php echo $title;?>">
	<input type="hidden" name="content" value="<?php echo $content;?>">
	<input type="hidden" name="userid" value="<?php echo $authorid;?>">
	<input type="hidden" name="imagesrc" value="<?php echo $image;?>">
	<input type="submit" value="Újrapróbálkozás">
	</form>
	<?php
}
?>
</div>
</div>
<div class="sidebar">
</div>
<?php include("footer.php"); ?>
</body>
</html>