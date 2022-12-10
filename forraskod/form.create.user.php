<html>
<head>
<?php include("head.php"); ?>
<title>Felhasználó létrehozása - <?php echo $sitename; ?></title>
<meta name="language" content="hu-HU">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
	header nav a[href="http://<?php echo $_SERVER['HTTP_HOST']; echo htmlspecialchars($_SERVER['PHP_SELF']);?>"], nav a[href="http://<?php echo $_SERVER['HTTP_HOST']; echo htmlspecialchars($_SERVER['PHP_SELF']);?>"] {font-weight: bold;}

</style>
</head>
<body>
<header>
<div class="head">
<!--<img class="head" src="fejlec.jpg" style="width: 100%;">-->
<!--<img class="head" src="fejlecvekony.jpg" style="width: 100%;">-->
<!--TODO új jogosultságtábla kezelése-->
<div class="fejlecparallax">
<div class="head-text">
<h1><?php echo $sitename; ?> honlapja - Felhasználó létrehozása</h1>
</div>
</div>
</div>
<hr>
<nav>
<?php include("navbar.php"); ?>
<?php

include("headforadmin.php");
if ($_SESSION["szint"] != 10)
{
	header("Location: admin.php");
}

?>

</nav>
<hr>
</header>
<div class="content">
<div class="tartalom">
<form name="create-user" action="create.user.php" method="post">
<table>
<tr>
<td><label>Felhasználónév:</label></td>
<td><input type="text" name="username" required></td>
<td><label>Rövid, könnyen megjegyezhető név. Pl.: gipszjakab7</label></td>
</tr>
<tr>
<td><label>Megjelenítendő név:</label></td>
<td><input type="text" name="name" required></td>
<td><label>Ez a név jelenik majd meg a blogbejegyzések mellett szerzőként. Pl.: Gipsz Jakab.</label></td>
</tr>
<tr>
<td><label>Jelszó:</label></td>
<td><input type="password" name="password" required></td>
<td><label>Nehezen kitalálható, viszont megjegyezhető jelszó. Jó, ha tartalmaz kis- és nagybetűket, számokat és írásjeleket. Ezt a jelszót jegyezzük fel, mert a rendszer <strong>nem visszafejthető</strong> formában tárolja! Pl.: JakabG19'.</label></td>
</tr>
<tr>
<td><label>Jelszó újra:</label></td>
<td><input type="password" name="password2" required></td>
<td><label></label></td>
</tr>
<tr>
	<!--TODO új jogosultsági szint rendszer kezelése-->
<td><label>Jogosultsági szint</label></td>
<td><input type="number" name="szint" value="0" max="10" min="0"></td>
<td><label><ol><li>Hozzáadhat szertartásokat, hirdetéseket és bejegyzéseket.</li></ol><br><b>10. Rendszeradminisztrátor</b></label></td>
</tr>
<tr>
	<td><label>Szerepe a plébánián: </label></td>
	<td><select name="egyhaziszint" required><option value="0">Sekrestyés, vagy egyéb plébániai személy</option><option value="1">Kántor</option><option value="2">Pap vagy püspök</option></select></td>
</tr>
<tr>
<td><label></label></td>
<td><input type="submit" value="Létrehozás"></td>
<td><label></label></td>
</table>
</form>
</div>
</div>
<div class="sidebar">
</div>
<?php include("footer.php"); ?>
</body>
</html>