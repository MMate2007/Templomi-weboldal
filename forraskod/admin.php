<html>
<head>
<title>Adminisztrációs felület - Példa plébánia</title>
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
</style>
</head>
<body>
<header>
<div class="head">
<!--<img class="head" src="fejlec.jpg" style="width: 100%;">-->
<!--<img class="head" src="fejlecvekony.jpg" style="width: 100%;">-->
<div class="fejlecparallax">
<div class="head-text">
<h1>Példa plébánia honlapja - Adminisztrációs oldal</h1>
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
<strong><a href="admin.php" class="right" id="right-elso">Adminisztráció</a></strong>
</nav>
<hr>
</header>
<div class="content">
<div class="tartalom">
<div class="welcome-admin">
<h2>Dicsértessék a Jézus Krisztus!</h2>
<h4>Üdvözlöm Önt, <?php echo $_SESSION["name"];?>, itt az adminisztrációs felületen!</h4>
<p>Ezen az oldalon szereksztheti a blog tartalmát.</p>
<div class="admin-nav">
<nav>
<ul>
<li><a href="admin.php">Adminisztráció</a></li>
<li><a href="form.create.post.php">Blogbejegyzés létrehozása</a></li>
<li><a href="form.create.szertartas.php">Liturgia hozzáadása</a></li>
<li><a href="form.delete.szertartas.php">Liturgia törlése</a></li>
<li><a href="form.create.hirdetes.php">Hirdetés létrehozása</a></li>
<li><a href="form.delete.hirdetes.php">Hirdetés törlése</a></li>
<li><a href="form.edit.content.php">Állandó tartalom módosítása</a></li>
<?php if ($_SESSION["admin"] == 1) {?>
<li><a href="form.create.user.php">Felhasználó létrehozása</a></li>
<li><a href="form.delete.user.php">Felhasználó törlése</a></li>
<?php }
if ($_SESSION["userId"] == 0)
{
	?>
	<li><a href="form.create.contentname.php">Tartalomazonosító létrehozása</a></li>
	<?php
}
?>
<li><a href="form.modify.password.php">Jelszó módosítása</a></li>
<li><a href="logout.php">Kijelentkezés</a></li>
</ul>
</nav>
</div>
</div>
</div>
</div>
<div class="sidebar">
</div>
<?php include("footer.php"); ?>
</body>
</html>
