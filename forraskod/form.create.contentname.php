<?php ob_start(); ?>
<html>
<head>
<meta charset="utf-8">
<title>Tartalomazonosító létrehozása - Példa plébánia</title>
<meta name="language" content="hu-HU">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="style.css">
<link rel="icon" type="image/pnp" href="icon.png">
<!--<meta name="theme-color" content="#ffea00">-->

<style>
header nav a[href="http://<?php echo $_SERVER['HTTP_HOST']; echo htmlspecialchars($_SERVER['PHP_SELF']);?>"], nav a[href="http://<?php echo $_SERVER['HTTP_HOST']; echo htmlspecialchars($_SERVER['PHP_SELF']);?>"] {font-weight: bold;}
</style>
</head>
<body class="d-flex flex-column h-100">
<header>
<div class="head">
<!--<img class="head" src="fejlec.jpg" style="width: 100%;">-->
<!--<img class="head" src="fejlecvekony.jpg" style="width: 100%;">-->
<div class="fejlecparallax">
<div class="head-text">
<h1>Példa plébánia honlapja - Tartalomazonosító létrehozása</h1>
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
<form name="create.contentname" method="post" action="create.contentname.php">
    <table>
        <tr>
            <td><label>Tartalomazonosító rendszerbeli (azonosító) neve: </label></td>
            <td><input type="text" name="idname"></td>
        </tr>
        <tr>
            <td><label>Tartalomazonosító (emberileg értelmezhető) neve: </td>
            <td><input type="text" name="name"></td>
        </tr>
        <tr>
            <td><label></label></td>
            <td><input type="submit" value="Létrehozás"></td>
        </tr>
    </table>
</form>
</div>
</div>
<div class="sidebar">
</div>
<?php include("footer.php"); ?>
</body>
</html>