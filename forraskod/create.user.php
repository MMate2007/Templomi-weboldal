<?php ob_start(); ?>
<!DOCTYPE html>
<html>
<head>
<?php include("head.php"); ?>
<title>Felhasználó létrehozása - <?php echo $sitename; ?></title>
<meta name="language" content="hu-HU">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<?php
displayhead("Felhasználó létrehozása");
include("headforadmin.php");
if (!checkpermission("adduser")) {
	displaymessage("danger", "Nincs jogosultsága felhasználó létrehozásához!");
	exit;
}
//TODO regex
?>
<main class="container">
	<form name="create-user" action="#" method="post">
	<div class="row my-3">
		<label for="username" class="col-sm-2 required">Felhasználónév:</label>
		<input type="text" name="username" required id="username" class="col-sm form-control" <?php autofill("username"); ?>>
		<label class="form-text col-sm">Rövid, könnyen megjegyezhető név. Pl.: gipszjakab7</label>
	</div>
	<div class="row my-3">
		<label for="name" class="col-sm-2 required">Megjelenítendő név:</label>
		<input type="text" name="name" required id="name" class="form-control col-sm" <?php autofill("name"); ?>>
		<label class="col-sm form-text">Ez a név jelenik majd meg a blogbejegyzések mellett szerzőként. Pl.: Gipsz Jakab.</label>
	</div>
	<div class="row my-3">
		<label for="password" class="col-sm-2 required">Jelszó:</label>
		<input type="password" name="password" required id="password" class="col-sm form-control">
		<label class="form-text col-sm">Nehezen kitalálható, viszont megjegyezhető jelszó. Jó, ha tartalmaz kis- és nagybetűket, számokat és írásjeleket. Ezt a jelszót jegyezzük fel, mert a rendszer <strong>nem visszafejthető</strong> formában tárolja! Pl.: JakabG19'.</label>
	</div>
	<div class="row my-3">
		<label for="password2" class="col-sm-2 required">Jelszó újra:</label>
		<input type="password" name="password2" required id="password2" class="form-control col-sm">
	</div>
	<div class="row my-3">
		<table>
			<caption>Jogosultságok</caption>
			<tr>
				<th>Liturgia hozzáadása: </th>
				<td>
					<div class="form-check form-check-inline">
						<input type="radio" name="addliturgia" value="0" required class="form-check-input" id="addliturgia0" <?php autofillcheck("addliturgia", 0); ?>>
						<label for="addliturgia0" class="form-check-label">Nem</label>
					</div>
					<div class="form-check form-check-inline">
						<input type="radio" name="addliturgia" value="1" class="form-check-input" id="addliturgia1" <?php autofillcheck("addliturgia", 1); ?>>
						<label for="addliturgia1" class="form-check-label">Igen</label>
					</div>
				</td>
			</tr>
			<tr>
				<th>Liturgia törlése: </th>
				<td>
					<div class="form-check form-check-inline">
						<input type="radio" name="removeliturgia" value="0" required id="removeliturgia0" class="form-check-input" <?php autofillcheck("removeliturgia", 0); ?>>
						<label for="removeliturgia0" class="form-check-label">Nem</label>
					</div>
					<div class="form-check form-check-inline">
						<input type="radio" name="removeliturgia" value="1" id="removeliturgia1" class="form-check-input" <?php autofillcheck("removeliturgia", 1); ?>>
						<label for="removeliturgia1" class="form-check-label">Igen</label>
					</div>
				</td>
			</tr>
			<tr>
				<th>Liturgia szerkesztése: </th>
				<td>
					<div class="form-check form-check-inline">
						<input type="radio" name="editliturgia" value="0" required class="form-check-input" id="editliturgia0" <?php autofillcheck("editliturgia", 0); ?>>
						<label for="editliturgia0" class="form-check-label">Nem</label>
					</div>
					<div class="form-check form-check-inline">
						<input type="radio" name="editliturgia" value="1" class="form-check-input" id="editliturgia1" <?php autofillcheck("editliturgia", 1); ?>>
						<label for="editliturgia1" class="form-check-label">Igen</label>
					</div>
				</td>
			</tr>
			<tr>
				<th>Szándék hozzáadása: </th>
				<td>
					<div class="form-check form-check-inline">
						<input type="radio" name="addszandek" value="0" required class="form-check-input" id="addszandek0" <?php autofillcheck("addszandek", 0); ?>>
						<label for="addszandek0" class="form-check-label">Nem</label>
					</div>
					<div class="form-check form-check-inline">
						<input type="radio" name="addszandek" value="1" class="form-check-input" id="addszandek1" <?php autofillcheck("addszandek", 1); ?>>
						<label for="addszandek1" class="form-check-label">Igen</label>
					</div>
				</td>
			</tr>
			<tr>
				<th>Szándék törlése: </th>
				<td>
					<div class="form-check form-check-inline">
						<input type="radio" name="removeszandek" value="0" required id="removeszandek0" class="form-check-input" <?php autofillcheck("removeszandek", 0); ?>>
						<label for="removeszandek0" class="form-check-label">Nem</label>
					</div>
					<div class="form-check form-check-inline">
						<input type="radio" name="removeszandek" value="1" id="removeszandek1" class="form-check-input" <?php autofillcheck("removeszandek", 1); ?>>
						<label for="removeszandek1" class="form-check-label">Igen</label>
					</div>
				</td>
			</tr>
			<tr>
				<th>Szándék szerkesztése: </th>
				<td>
					<div class="form-check form-check-inline">
						<input type="radio" name="editszandek" value="0" required id="editszandek0" class="form-check-input" <?php autofillcheck("editszandek", 0); ?>>
						<label for="editszandek0" class="form-check-label">Nem</label>
					</div>
					<div class="form-check form-check-inline">
						<input type="radio" name="editszandek" value="1" id="editszandek1" class="form-check-input" <?php autofillcheck("editszandek", 1); ?>>
						<label for="editszandek1" class="form-check-label">Igen</label>
					</div>
				</td>
			</tr>
			<tr>
				<th>Bejegyzés hozzáadása: </th>
				<td>
					<div class="form-check form-check-inline">
						<input type="radio" name="addpost" value="0" required id="addpost0" class="form-check-input" <?php autofillcheck("addpost", 0); ?>>
						<label for="addpost0" class="form-check-label">Nem</label>
					</div>
					<div class="form-check form-check-inline">
						<input type="radio" name="addpost" value="1" id="addpost1" class="form-check-input" <?php autofillcheck("addpost", 1);?>>
						<label for="addpost1" class="form-check-label">Igen</label>
					</div>
				</td>
			</tr>
			<tr>
				<th>Bejegyzés hozzáadása más nevében: </th>
				<td>
					<div class="form-check form-check-inline">
						<input type="radio" name="addpostwithothername" value="0" required id="addpostwithothername0" class="form-check-input" <?php autofillcheck("addpostwithothername", 0); ?>>
						<label for="addpostwithothername0" class="form-check-label">Nem</label>
					</div>
					<div class="form-check form-check-inline">
						<input type="radio" name="addpostwithothername" value="1" id="addpostwithothername1" class="form-check-input" <?php autofillcheck("addpostwithothername", 1); ?>>
						<label for="addpostwithothername1" class="form-check-label">Igen</label>
					</div>
				</td>
			</tr>
			<tr>
				<th>Bejegyzés törlése: </th>
				<td>
					<div class="form-check form-check-inline">
						<input type="radio" name="removepost" value="0" required id="removepost0" class="form-check-input" <?php autofillcheck("removepost", 0);?>>
						<label for="removepost0" class="form-check-label">Nem</label>
					</div>
					<div class="form-check form-check-inline">
						<input type="radio" name="removepost" value="1" id="removepost1" class="form-check-input" <?php autofillcheck("removepost", 1);?>>
						<label for="removepost1" class="form-check-label">Igen</label>
					</div>
				</td>
			</tr>
			<tr>
				<th>Bejegyzés szerkesztése: </th>
				<td>
					<div class="form-check form-check-inline">
						<input type="radio" name="editpost" value="0" required id="editpost0" class="form-check-input" <?php autofillcheck("editpost", 0);?>>
						<label for="editpost0" class="form-check-label">Nem</label>
					</div>
					<div class="form-check form-check-inline">
						<input type="radio" name="editpost" value="1" id="editpost1" class="form-check-input" <?php autofillcheck("editpost", 1);?>>
						<label for="editpost1" class="form-check-label">Igen</label>
					</div>
				</td>
			</tr>
			<tr>
				<th>Hirdetés hozzáadása: </th>
				<td>
					<div class="form-check form-check-inline">
						<input type="radio" name="addhirdetes" value="0" required id="addhirdetes0" class="form-check-input" <?php autofillcheck("addhirdetes", 0);?>>
						<label for="addhirdetes0" class="form-check-label">Nem</label>
					</div>
					<div class="form-check form-check-inline">
						<input type="radio" name="addhirdetes" value="1" id="addhirdetes1" class="form-check-input" <?php autofillcheck("addhirdetes", 1);?>>
						<label for="addhirdetes1" class="form-check-label">Igen</label>
					</div>
				</td>
			</tr>
			<tr>
				<th>Hirdetés törlése: </th>
				<td>
					<div class="form-check form-check-inline">
						<input type="radio" name="removehirdetes" value="0" required id="removehirdetes0" class="form-check-input" <?php autofillcheck("removehirdetes", 0);?>>
						<label for="removehirdetes0" class="form-check-label">Nem</label>
					</div>
					<div class="form-check form-check-inline">
						<input type="radio" name="removehirdetes" value="1" id="removehirdetes1" class="form-check-input" <?php autofillcheck("removehirdetes", 1);?>>
						<label for="removehirdetes1" class="form-check-label">Igen</label>
					</div>
				</td>
			</tr>
			<tr>
				<th>Hirdetés szerkesztése: </th>
				<td>
					<div class="form-check form-check-inline">
						<input type="radio" name="edithirdetes" value="0" required id="edithirdetes0" class="form-check-input" <?php autofillcheck("edithirdetes", 0);?>>
						<label for="edithirdetes0" class="form-check-label">Nem</label>
					</div>
					<div class="form-check form-check-inline">
						<input type="radio" name="edithirdetes" value="1" id="edithirdetes1" class="form-check-input" <?php autofillcheck("edithirdetes", 1);?>>
						<label for="edithirdetes1" class="form-check-label">Igen</label>
					</div>
				</td>
			</tr>
			<tr>
				<th>Oldal hozzáadása: </th>
				<td>
					<div class="form-check form-check-inline">
						<input type="radio" name="addpage" value="0" required id="addpage0" class="form-check-input" <?php autofillcheck("addpage", 0);?>>
						<label for="addpage0" class="form-check-label">Nem</label>
					</div>
					<div class="form-check form-check-inline">
						<input type="radio" name="addpage" value="1" id="addpage1" class="form-check-input" <?php autofillcheck("addpage", 1);?>>
						<label for="addpage1" class="form-check-label">Igen</label>
					</div>
				</td>
			</tr>
			<tr>
				<th>Oldal törlése: </th>
				<td>
					<div class="form-check form-check-inline">
						<input type="radio" name="removepage" value="0" required id="removepage0" class="form-check-input" <?php autofillcheck("removepage", 0);?>>
						<label for="removepage0" class="form-form-check-label">Nem</label>
					</div>
					<div class="form-check form-check-inline">
						<input type="radio" name="removepage" value="1" id="removepage1" class="form-check-input" <?php autofillcheck("removepage", 1);?>>
						<label for="removepage1" class="form-form-check-label">Igen</label>
					</div>
				</td>
			</tr>
			<tr>
				<th>Oldal szerkesztése: </th>
				<td>
					<div class="form-check form-check-inline">
						<input type="radio" name="editpage" value="0" required id="editpage0" class="form-check-input" <?php autofillcheck("editpage", 0); ?>>
						<label for="editpage0" class="form-check-label">Nem</label>
					</div>
					<div class="form-check form-check-inline">
						<input type="radio" name="editpage" value="1" id="editpage1" class="form-check-input" <?php autofillcheck("editpage", 1);?>>
						<label for="editpage1" class="form-check-label">Igen</label>
					</div>
				</td>
			</tr>
			<tr>
				<th>Felhasználó hozzáadása: </th>
				<td>
					<div class="form-check form-check-inline">
						<input type="radio" name="adduser" value="0" required id="adduser0" class="form-check-input" <?php autofillcheck("adduser", 0);?>>
						<label for="adduser0" class="form-check-label">Nem</label>
					</div>
					<div class="form-check form-check-inline">
						<input type="radio" name="adduser" value="1" id="adduser1" class="form-check-input" <?php autofillcheck("adduser", 1);?>>
						<label for="adduser1" class="form-check-label">Igen</label>
					</div>
				</td>
			</tr>
			<tr>
				<th>Felhasználó törlése: </th>
				<td>
					<div class="form-check form-check-inline">
						<input type="radio" name="removeuser" value="0" required id="removeuser0" class="form-check-input" <?php autofillcheck("removeuser", 0);?>>
						<label for="removeuser0" class="form-check-label">Nem</label>
					</div>
					<div class="form-check form-check-inline">
						<input type="radio" name="removeuser" value="1" id="removeuser1" class="form-check-input" <?php autofillcheck("removeuser", 1);?>>
						<label for="removeuser1" class="form-check-label">Igen</label>
					</div>
				</td>
			</tr>
			<tr>
				<th>Felhasználó adatainak szerkesztése: </th>
				<td>
					<div class="form-check form-check-inline">
						<input type="radio" name="editjogosultsagok" value="0" required id="editjogosultsagok0" class="form-check-input" <?php autofillcheck("editjogosultsagok", 0);?>>
						<label for="editjogosultsagok0" class="form-check-label">Nem</label>
					</div>
					<div class="form-check form-check-inline">
						<input type="radio" name="editjogosultsagok" value="1" id="editjogosultsagok1" class="form-check-input" <?php autofillcheck("editjogosultsagok", 1);?>>
						<label for="editjogosultsagok1" class="form-check-label">Igen</label>
					</div>
				</td>
			</tr>
			<tr>
				<th>Templom hozzáadása: </th>
				<td>
					<div class="form-check form-check-inline">
						<input type="radio" name="addtemplom" value="0" required id="addtemplom0" class="form-check-input" <?php autofillcheck("addtemplom", 0);?>>
						<label for="addtemplom0" class="form-check-label">Nem</label>
					</div>
					<div class="form-check form-check-inline">
						<input type="radio" name="addtemplom" value="1" id="addtemplom1" class="form-check-input" <?php autofillcheck("addtemplom", 1);?>>
						<label for="addtemplom1" class="form-check-label">Igen</label>
					</div>
				</td>
			</tr>
			<tr>
				<th>Templom törlése: </th>
				<td>
					<div class="form-check form-check-inline">
						<input type="radio" name="removetemplom" value="0" required id="removetemplom0" class="form-check-input" <?php autofillcheck("removetemplom", 0);?>>
						<label for="removetemplom0" class="form-check-label">Nem</label>
					</div>
					<div class="form-check form-check-inline">
						<input type="radio" name="removetemplom" value="1" id="removetemplom1" class="form-check-input" <?php autofillcheck("removetemplom", 1);?>>
						<label for="removetemplom1" class="form-check-label">Igen</label>
					</div>
				</td>
			</tr>
			<tr>
				<th>Település hozzáadása: </th>
				<td>
					<div class="form-check form-check-inline">
						<input type="radio" name="addtelepules" value="0" required id="addtelepules0" class="form-check-input" <?php autofillcheck("addtelepules", 0);?>>
						<label for="addtelepules0" class="form-check-label">Nem</label>
					</div>
					<div class="form-check form-check-inline">
						<input type="radio" name="addtelepules" value="1" id="addtelepules1" class="form-check-input" <?php autofillcheck("addtelepules", 1);?>>
						<label for="addtelepules1" class="form-check-label">Igen</label>
					</div>
				</td>
			</tr>
			<tr>
				<th>Település törlése: </th>
				<td>
					<div class="form-check form-check-inline">
						<input type="radio" name="removetelepules" value="0" required id="removetelepules0" class="form-check-input" <?php autofillcheck("removetelepules", 0);?>>
						<label for="removetelepules0" class="form-check-label">Nem</label>
					</div>
					<div class="form-check form-check-inline">
						<input type="radio" name="removetelepules" value="1" id="removetelepules1" class="form-check-input" <?php autofillcheck("removetelepules", 1);?>>
						<label for="removetelepules1" class="form-check-label">Igen</label>
					</div>
				</td>
			</tr>
			<tr>
				<th>Menük szerkesztése: </th>
				<td>
					<div class="form-check form-check-inline">
						<input type="radio" name="editnavbar" value="0" required id="editnavbar0" class="form-check-input" <?php autofillcheck("editnavbar", 0);?>>
						<label for="editnavbar0" class="form-check-label">Nem</label>
					</div>
					<div class="form-check form-check-inline">
						<input type="radio" name="editnavbar" value="1" id="editnavbar1" class="form-check-input" <?php autofillcheck("editnavbar", 1);?>>
						<label for="editnavbar1" class="form-check-label">Igen</label>
					</div>
				</td>
			</tr>
			<!--TODO két új oszlop hozzáadása-->
		</table>
	</div>
	<div class="row my-3">
		<label class="col-sm-2 required" for="egyhaziszint">Szerepe a plébánián: </label>
		<select name="egyhaziszint" id="egyhaziszint" required class="form-select col-sm">
			<option value="0" <?php autofillselect("egyhaziszint", 0);?>>Egyéb, a plébánián dolgozó személy</option>
			<option value="1" <?php autofillselect("egyhaziszint", 1);?>>Kántor</option>
			<option value="2" <?php autofillselect("egyhaziszint", 2);?>>Pap</option>
		</select>
	</div>
	<input type="hidden" name="stage" value="1">
	<button type="submit" class="btn btn-primary text-white"><i class="bi bi-person-add"></i> Létrehozás</button>
	</form>
<?php
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
		$sql = "INSERT INTO `author`(`id`, `name`, `password`, `username`, `egyhaziszint`) VALUES ('".$id."','".correct($_POST["name"])."','".password_hash($_POST["password"], $pwdhashalgo)."','".correct($_POST["username"])."','".correct($_POST["egyhaziszint"])."')";
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
			//TODO 2 új oszlop hozzáadása
			$sqla = "INSERT INTO `engedelyek`(`userId`, `bejelentkezes`, `addliturgia`, `removeliturgia`, `editliturgia`, `addszandek`, `removeszandek`, `editszandek`, `addpost`, `addpostwithothername`, `removepost`, `editpost`, `addhirdetes`, `removehirdetes`, `edithirdetes`, `adduser`, `removeuser`, `addtemplom`, `removetemplom`, `addtelepules`, `removetelepules`, `addpage`, `editpage`, `deletepage`, `editjogosultsagok`, `editnavbar`) VALUES ('".$id."','1','".$engedelyek["addliturgia"]."','".$engedelyek["removeliturgia"]."','".$engedelyek["editliturgia"]."','".$engedelyek["addszandek"]."','".$engedelyek["removeszandek"]."','".$engedelyek["editszandek"]."','".$engedelyek["addpost"]."','".$engedelyek["addpostwithothername"]."','".$engedelyek["removepost"]."','".$engedelyek["editpost"]."','".$engedelyek["addhirdetes"]."','".$engedelyek["removehirdetes"]."','".$engedelyek["edithirdetes"]."','".$engedelyek["adduser"]."','".$engedelyek["removeuser"]."','".$engedelyek["addtemplom"]."','".$engedelyek["removetemplom"]."','".$engedelyek["addtelepules"]."','".$engedelyek["removetelepules"]."','".$engedelyek["addpage"]."','".$engedelyek["editpage"]."','".$engedelyek["removepage"]."','".$engedelyek["editjogosultsagok"]."','".$engedelyek["editnavbar"]."')";
			$eredmenya = mysqli_query($mysql, $sqla) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
			if ($eredmenya == true)
			{
				displaymessage("success", "Sikeres létrehozás!");
			} else {
				displaymessage("danger", "Valami nem jött össze. Kérem próbálja újra!");
			}
		}
		} else {
			$eredmeny = false;
			formvalidation("#password2", false, "A két jelszó nem egyezeik!");
			formvalidation("#password", false, "A két jelszó nem egyezik!");
		}
	}
}
?>
</main>
<?php include("footer.php"); ?>
</body>
</html>