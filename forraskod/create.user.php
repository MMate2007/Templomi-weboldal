<?php ob_start(); ?>
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
//TODO szint kiiktatása, új rendszer feldolgozása
if ($_SESSION["szint"] != 10)
{
	header("Location: admin.php");
}
//TODO regex
?>
</nav>
<hr>
</header>
<div class="content">
<div class="tartalom">
<?php
if (!isset($_POST["stage"])) {
	?>
	<form name="create-user" action="#" method="post">
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
	<table>
		<caption>Jogosultságok</caption>
		<tr>
			<th>Liturgia hozzáadása: </th>
			<td><input type="radio" name="addliturgia" value="0" required>Nem</input></td>
			<td><input type="radio" name="addliturgia" value="1">Igen</input></td>
		</tr>
		<tr>
			<th>Liturgia törlése: </th>
			<td><input type="radio" name="removeliturgia" value="0" required>Nem</input></td>
			<td><input type="radio" name="removeliturgia" value="1">Igen</input></td>
		</tr>
		<tr>
			<th>Liturgia szerkesztése: </th>
			<td><input type="radio" name="editliturgia" value="0" required>Nem</input></td>
			<td><input type="radio" name="editliturgia" value="1">Igen</input></td>
		</tr>
		<tr>
			<th>Szándék hozzáadása: </th>
			<td><input type="radio" name="addszandek" value="0" required>Nem</input></td>
			<td><input type="radio" name="addszandek" value="1">Igen</input></td>
		</tr>
		<tr>
			<th>Szándék törlése: </th>
			<td><input type="radio" name="removeszandek" value="0" required>Nem</input></td>
			<td><input type="radio" name="removeszandek" value="1">Igen</input></td>
		</tr>
		<tr>
			<th>Szándék szerkesztése: </th>
			<td><input type="radio" name="editszandek" value="0" required>Nem</input></td>
			<td><input type="radio" name="editszandek" value="1">Igen</input></td>
		</tr>
		<tr>
			<th>Bejegyzés hozzáadása: </th>
			<td><input type="radio" name="addpost" value="0" required>Nem</input></td>
			<td><input type="radio" name="addpost" value="1">Igen</input></td>
		</tr>
		<tr>
			<th>Bejegyzés hozzáadása más nevében: </th>
			<td><input type="radio" name="addpostwithothername" value="0" required>Nem</input></td>
			<td><input type="radio" name="addpostwithothername" value="1">Igen</input></td>
		</tr>
		<tr>
			<th>Bejegyzés törlése: </th>
			<td><input type="radio" name="removepost" value="0" required>Nem</input></td>
			<td><input type="radio" name="removepost" value="1">Igen</input></td>
		</tr>
		<tr>
			<th>Bejegyzés szerkesztése: </th>
			<td><input type="radio" name="editpost" value="0" required>Nem</input></td>
			<td><input type="radio" name="editpost" value="1">Igen</input></td>
		</tr>
		<tr>
			<th>Hirdetés hozzáadása: </th>
			<td><input type="radio" name="addhirdetes" value="0" required>Nem</input></td>
			<td><input type="radio" name="addhirdetes" value="1">Igen</input></td>
		</tr>
		<tr>
			<th>Hirdetés törlése: </th>
			<td><input type="radio" name="removehirdetes" value="0" required>Nem</input></td>
			<td><input type="radio" name="removehirdetes" value="1">Igen</input></td>
		</tr>
		<tr>
			<th>Hirdetés szerkesztése: </th>
			<td><input type="radio" name="edithirdetes" value="0" required>Nem</input></td>
			<td><input type="radio" name="edithirdetes" value="1">Igen</input></td>
		</tr>
		<tr>
			<th>Oldal hozzáadása: </th>
			<td><input type="radio" name="addpage" value="0" required>Nem</input></td>
			<td><input type="radio" name="addpage" value="1">Igen</input></td>
		</tr>
		<tr>
			<th>Oldal törlése: </th>
			<td><input type="radio" name="removepage" value="0" required>Nem</input></td>
			<td><input type="radio" name="removepage" value="1">Igen</input></td>
		</tr>
		<tr>
			<th>Oldal szerkesztése: </th>
			<td><input type="radio" name="editpage" value="0" required>Nem</input></td>
			<td><input type="radio" name="editpage" value="1">Igen</input></td>
		</tr>
		<tr>
			<th>Felhasználó hozzáadása: </th>
			<td><input type="radio" name="adduser" value="0" required>Nem</input></td>
			<td><input type="radio" name="adduser" value="1">Igen</input></td>
		</tr>
		<tr>
			<th>Felhasználó törlése: </th>
			<td><input type="radio" name="removeuser" value="0" required>Nem</input></td>
			<td><input type="radio" name="removeuser" value="1">Igen</input></td>
		</tr>
		<tr>
			<th>Felhasználó adatainak szerkesztése: </th>
			<td><input type="radio" name="editjogosultsagok" value="0" required>Nem</input></td>
			<td><input type="radio" name="editjogosultsagok" value="1">Igen</input></td>
		</tr>
		<tr>
			<th>Templom hozzáadása: </th>
			<td><input type="radio" name="addtemplom" value="0" required>Nem</input></td>
			<td><input type="radio" name="addtemplom" value="1">Igen</input></td>
		</tr>
		<tr>
			<th>Templom törlése: </th>
			<td><input type="radio" name="removetemplom" value="0" required>Nem</input></td>
			<td><input type="radio" name="removetemplom" value="1">Igen</input></td>
		</tr>
		<tr>
			<th>Település hozzáadása: </th>
			<td><input type="radio" name="addtelepules" value="0" required>Nem</input></td>
			<td><input type="radio" name="addtelepules" value="1">Igen</input></td>
		</tr>
		<tr>
			<th>Település törlése: </th>
			<td><input type="radio" name="removetelepules" value="0" required>Nem</input></td>
			<td><input type="radio" name="removetelepules" value="1">Igen</input></td>
		</tr>
		<tr>
			<th>Menük szerkesztése: </th>
			<td><input type="radio" name="editnavbar" value="0" required>Nem</input></td>
			<td><input type="radio" name="editnavbar" value="1">Igen</input></td>
		</tr>
	</table>
	</tr>
	<tr>
		<td><label>Szerepe a plébánián: </label></td>
		<td><select name="egyhaziszint" required><option value="0">Sekrestyés, vagy egyéb plébániai személy</option><option value="1">Kántor</option><option value="2">Pap vagy püspök</option></select></td>
	</tr>
	<tr>
	<td><label></label></td>
	<input type="hidden" name="stage" value="1">
	<td><input type="submit" value="Létrehozás"></td>
	<td><label></label></td>
	</table>
	</form>
	<?php
}
if (isset($_POST["stage"])) {
	if ($_POST["stage"] == 1)
	{
		$sql = "SELECT `id` FROM `author`";
		$id = 0;
		$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
		while ($row = mysqli_fetch_array($eredmeny))
		{
			$_id = $row['id'];
			$id = $_id + 1;
		}
		if ($_POST["password"] == $_POST["password2"])
		{
			//TODO űrlapon feltüntetni, hogy a felhasználónév milyen karakterekből állhat
			//TODO username, name, egyhaziszint ellenőrzése regexszel
		$sql = "INSERT INTO `author`(`id`, `name`, `password`, `username`, `egyhaziszint`) VALUES ('".$id."','".correct($_POST["name"])."','".sha1(md5($_POST["password"]))."','".correct($_POST["username"])."','".correct($_POST["egyhaziszint"])."')";
		$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
		if ($eredmeny == true)
		{
			$engedelyek = $_POST;
			foreach ($engedelyek as $key => $value)
			{
				if ($value != "1")
				{
					$engedelyek[$key] = 0;
				}
			}
			$sqla = "INSERT INTO `engedelyek`(`userId`, `bejelentkezes`, `addliturgia`, `removeliturgia`, `editliturgia`, `addszandek`, `removeszandek`, `editszandek`, `addpost`, `addpostwithothername`, `removepost`, `editpost`, `addhirdetes`, `removehirdetes`, `edithirdetes`, `adduser`, `removeuser`, `addtemplom`, `removetemplom`, `addtelepules`, `removetelepules`, `addpage`, `editpage`, `deletepage`, `editjogosultsagok`, `editnavbar`) VALUES ('".$id."','1','".$engedelyek["addliturgia"]."','".$engedelyek["removeliturgia"]."','".$engedelyek["editliturgia"]."','".$engedelyek["addszandek"]."','".$engedelyek["removeszandek"]."','".$engedelyek["editszandek"]."','".$engedelyek["addpost"]."','".$engedelyek["addpostwithothername"]."','".$engedelyek["removepost"]."','".$engedelyek["editpost"]."','".$engedelyek["addhirdetes"]."','".$engedelyek["removehirdetes"]."','".$engedelyek["edithirdetes"]."','".$engedelyek["adduser"]."','".$engedelyek["removeuser"]."','".$engedelyek["addtemplom"]."','".$engedelyek["removetemplom"]."','".$engedelyek["addtelepules"]."','".$engedelyek["removetelepules"]."','".$engedelyek["addpage"]."','".$engedelyek["editpage"]."','".$engedelyek["removepage"]."','".$engedelyek["editjogosultsagok"]."','".$engedelyek["editnavbar"]."')";
			$eredmenya = mysqli_query($mysql, $sqla) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
			if ($eredmenya == true)
			{
				?>
				<p class="success">Sikeres létrehozás!</p>
				<?php
			} else {
				?>
				<p class="warning">Valami nem sikerült!</p>
				<?php
			}
		}
		} else {
			$eredmeny = false;
			?>
			<p>A két jelszó nem egyezik!</p>
			<form name="create-user" action="#" method="post">
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
	<table>
		<caption>Jogosultságok</caption>
		<tr>
			<th>Liturgia hozzáadása: </th>
			<td><input type="radio" name="addliturgia" value="0" required>Nem</input></td>
			<td><input type="radio" name="addliturgia" value="1">Igen</input></td>
		</tr>
		<tr>
			<th>Liturgia törlése: </th>
			<td><input type="radio" name="removeliturgia" value="0" required>Nem</input></td>
			<td><input type="radio" name="removeliturgia" value="1">Igen</input></td>
		</tr>
		<tr>
			<th>Liturgia szerkesztése: </th>
			<td><input type="radio" name="editliturgia" value="0" required>Nem</input></td>
			<td><input type="radio" name="editliturgia" value="1">Igen</input></td>
		</tr>
		<tr>
			<th>Szándék hozzáadása: </th>
			<td><input type="radio" name="addszandek" value="0" required>Nem</input></td>
			<td><input type="radio" name="addszandek" value="1">Igen</input></td>
		</tr>
		<tr>
			<th>Szándék törlése: </th>
			<td><input type="radio" name="removeszandek" value="0" required>Nem</input></td>
			<td><input type="radio" name="removeszandek" value="1">Igen</input></td>
		</tr>
		<tr>
			<th>Szándék szerkesztése: </th>
			<td><input type="radio" name="editszandek" value="0" required>Nem</input></td>
			<td><input type="radio" name="editszandek" value="1">Igen</input></td>
		</tr>
		<tr>
			<th>Bejegyzés hozzáadása: </th>
			<td><input type="radio" name="addpost" value="0" required>Nem</input></td>
			<td><input type="radio" name="addpost" value="1">Igen</input></td>
		</tr>
		<tr>
			<th>Bejegyzés hozzáadása más nevében: </th>
			<td><input type="radio" name="addpostwithothername" value="0" required>Nem</input></td>
			<td><input type="radio" name="addpostwithothername" value="1">Igen</input></td>
		</tr>
		<tr>
			<th>Bejegyzés törlése: </th>
			<td><input type="radio" name="removepost" value="0" required>Nem</input></td>
			<td><input type="radio" name="removepost" value="1">Igen</input></td>
		</tr>
		<tr>
			<th>Bejegyzés szerkesztése: </th>
			<td><input type="radio" name="editpost" value="0" required>Nem</input></td>
			<td><input type="radio" name="editpost" value="1">Igen</input></td>
		</tr>
		<tr>
			<th>Hirdetés hozzáadása: </th>
			<td><input type="radio" name="addhirdetes" value="0" required>Nem</input></td>
			<td><input type="radio" name="addhirdetes" value="1">Igen</input></td>
		</tr>
		<tr>
			<th>Hirdetés törlése: </th>
			<td><input type="radio" name="removehirdetes" value="0" required>Nem</input></td>
			<td><input type="radio" name="removehirdetes" value="1">Igen</input></td>
		</tr>
		<tr>
			<th>Hirdetés szerkesztése: </th>
			<td><input type="radio" name="edithirdetes" value="0" required>Nem</input></td>
			<td><input type="radio" name="edithirdetes" value="1">Igen</input></td>
		</tr>
		<tr>
			<th>Oldal hozzáadása: </th>
			<td><input type="radio" name="addpage" value="0" required>Nem</input></td>
			<td><input type="radio" name="addpage" value="1">Igen</input></td>
		</tr>
		<tr>
			<th>Oldal törlése: </th>
			<td><input type="radio" name="removepage" value="0" required>Nem</input></td>
			<td><input type="radio" name="removepage" value="1">Igen</input></td>
		</tr>
		<tr>
			<th>Oldal szerkesztése: </th>
			<td><input type="radio" name="editpage" value="0" required>Nem</input></td>
			<td><input type="radio" name="editpage" value="1">Igen</input></td>
		</tr>
		<tr>
			<th>Felhasználó hozzáadása: </th>
			<td><input type="radio" name="adduser" value="0" required>Nem</input></td>
			<td><input type="radio" name="adduser" value="1">Igen</input></td>
		</tr>
		<tr>
			<th>Felhasználó törlése: </th>
			<td><input type="radio" name="removeuser" value="0" required>Nem</input></td>
			<td><input type="radio" name="removeuser" value="1">Igen</input></td>
		</tr>
		<tr>
			<th>Felhasználó adatainak szerkesztése: </th>
			<td><input type="radio" name="editjogosultsagok" value="0" required>Nem</input></td>
			<td><input type="radio" name="editjogosultsagok" value="1">Igen</input></td>
		</tr>
		<tr>
			<th>Templom hozzáadása: </th>
			<td><input type="radio" name="addtemplom" value="0" required>Nem</input></td>
			<td><input type="radio" name="addtemplom" value="1">Igen</input></td>
		</tr>
		<tr>
			<th>Templom törlése: </th>
			<td><input type="radio" name="removetemplom" value="0" required>Nem</input></td>
			<td><input type="radio" name="removetemplom" value="1">Igen</input></td>
		</tr>
		<tr>
			<th>Település hozzáadása: </th>
			<td><input type="radio" name="addtelepules" value="0" required>Nem</input></td>
			<td><input type="radio" name="addtelepules" value="1">Igen</input></td>
		</tr>
		<tr>
			<th>Település törlése: </th>
			<td><input type="radio" name="removetelepules" value="0" required>Nem</input></td>
			<td><input type="radio" name="removetelepules" value="1">Igen</input></td>
		</tr>
		<tr>
			<th>Menük szerkesztése: </th>
			<td><input type="radio" name="editnavbar" value="0" required>Nem</input></td>
			<td><input type="radio" name="editnavbar" value="1">Igen</input></td>
		</tr>
	</table>
	</tr>
	<tr>
		<td><label>Szerepe a plébánián: </label></td>
		<td><select name="egyhaziszint" required><option value="0">Sekrestyés, vagy egyéb plébániai személy</option><option value="1">Kántor</option><option value="2">Pap vagy püspök</option></select></td>
	</tr>
	<tr>
	<td><label></label></td>
	<input type="hidden" name="stage" value="1">
	<td><input type="submit" value="Létrehozás"></td>
	<td><label></label></td>
	</table>
	</form>
			<?php
		}
	}
}
?>
</div>
</div>
<div class="sidebar">
</div>
<?php include("footer.php"); ?>
</body>
</html>