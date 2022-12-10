<?php ob_start(); ?>
<html>
<head>
<meta charset="utf-8">
<title>Létrehozás...</title>
<meta name="language" content="hu-HU">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="style.css">
<link rel="icon" type="image/pnp" href="icon.png">
<!--<meta name="theme-color" content="#ffea00">-->

<style>
header nav a[href="http://<?php echo $_SERVER['HTTP_HOST']; echo htmlspecialchars($_SERVER['PHP_SELF']);?>"], nav a[href="http://<?php echo $_SERVER['HTTP_HOST']; echo htmlspecialchars($_SERVER['PHP_SELF']);?>"] {font-weight: bold;}

</style>
</head>
<body>
<header>
<div class="head">
<!--<img class="head" src="fejlec.jpg" style="width: 100%;">-->
<!--<img class="head" src="fejlecvekony.jpg" style="width: 100%;">-->
<div class="fejlecparallax">
<div class="head-text">
<h1>Példa plébánia honlapja - Tartalomazonosító létrehozása...</h1>
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
	header("Location: login.php?messagetype=warning&message=Hozzáférés megtagadva! A tartalom megtekintéséhez be kell jelentkezni.");
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
		header("Location: login.php?messagetype=warning&message=Hozzáférés megtagadva! A tartalom megtekintéséhez be kell jelentkezni.");
	}
}
if ($_SESSION["userId"] != "0")
{
    ?>
    <script>
    alert("Ön nem jogosult a lap megtekintéséhez! Kérem, forduljon a weboldal kezelőjéhez!");
	window.location.replace("admin.php");
    </script>
    <?php
}
mysqli_close($mysql);
?>
<a href="logout.php" class="right">Kijelentkezés</a>
<a href="create.hirdetes.php" class="right">Hirdetés létrehozása</a>
<a href="form.create.szertartas.php" class="right">Liturgia hozzáadása</a>
<a href="admin.php" class="right" id="right-elso">Adminisztráció</a>
</nav>
<hr>
</header>
<div class="content">
<div class="tartalom">
<div id="lathato">
    <p class="warning">Valami hiba történt!</p>
</div>
<?php
$idname = correct($_POST["idname"]);
$name = correct($_POST["name"]);
$mysql = mysqli_connect("localhost", "mysqlfelhasznalo", "mysqljelszo", "adatbazisnev") or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
mysqli_query($mysql, "SET NAMES utf8");
$elsolepes = true;
$masodiklepes = true;
$sql = "SELECT `id` FROM `contents` WHERE `name` = '".$idname."'";
$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
while ($row = mysqli_fetch_array($eredmeny))
{
	$id = $row["id"];
	if ($id != null)
	{
		$masodiklepes = false;
	}
}
$sql = "SELECT `id` FROM `contentsname` WHERE `idname` = '".$idname."'";
$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
while ($row = mysqli_fetch_array($eredmeny))
{
	$id = $row["id"];
	if ($id != null)
	{
		$elsolepes = false;
	}
}
$sql = "SELECT `id` FROM `contentsname`";
$id = 0;
$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
while ($row = mysqli_fetch_array($eredmeny))
{
	$_id = $row['id'];
	$id = $_id + 1;
}
$sql = "INSERT INTO `contentsname`(`id`, `idname`, `name`) VALUES ('".$id."','".$idname."','".$name."')";
if ($elsolepes == true) { $eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>"); }
$sql = "SELECT `id` FROM `contents`";
$id = 0;
$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
while ($row = mysqli_fetch_array($eredmeny))
{
	$_id = $row['id'];
	$id = $_id + 1;
}
$sql = "INSERT INTO `contents`(`id`, `name`) VALUES ('".$id."','".$idname."')";
if ($masodiklepes == true) { $eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>"); }
mysqli_close($mysql);
if ($eredmeny == true)
{
	?>
	<p class="succes">Sikeres létrehozás!</p>
	<script>
	document.getElementById("lathato").style.display = "none";
	</script>
	<?php
}else{
	?>
	<script>
	document.getElementById("lathato").style.display = "block";
	</script>
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