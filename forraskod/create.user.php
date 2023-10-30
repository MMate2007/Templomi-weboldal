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
			<?php
			$sql = "SELECT `id`, `name` FROM `permissions`";
			$eredmeny = mysqli_query($mysql, $sql);
			while ($row = mysqli_fetch_array($eredmeny)) {
				if ($row["name"] != "bejelentkezes") {
				?>
				<tr>
					<th><?php echo $row["name"]; ?></th>
					<td>
					<div class="form-check form-check-inline">
						<input type="radio" name="<?php echo $row["id"]; ?>" value="0" required id="<?php echo $row["id"]; ?>a" class="form-check-input" <?php autofillcheck($row["id"], 0);?>>
						<label for="<?php echo $row["id"]; ?>a" class="form-check-label">Nem</label>
					</div>
					<div class="form-check form-check-inline">
						<input type="radio" name="<?php echo $row["id"]; ?>" value="1" id="<?php echo $row["id"]; ?>b" class="form-check-input" <?php autofillcheck($row["id"], 1);?>>
						<label for="<?php echo $row["id"]; ?>b" class="form-check-label">Igen</label>
					</div>
				</td>
				</tr>
				<?php }
			}
			?>
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
			$sql = "SELECT `id` FROM `permissions` WHERE `shortname` = 'bejelentkezes'";
			$eredmeny = mysqli_query($mysql, $sql);
			$bejelentkezesid = 0;
			while ($row = mysqli_fetch_array($eredmeny)) {
				$bejelentkezesid = $row["id"];
			}
			$sql = "INSERT INTO `userpermissions`(`userId`, `permissionId`) VALUES ('$id','$bejelentkezesid')";
			mysqli_query($mysql, $sql);
			foreach ($_POST as $key=>$value) {
				if (check($key, "number")) {
					if ($value == 1) {
						$sql = "INSERT INTO `userpermissions`(`userId`, `permissionId`) VALUES ('$id','$key')";
						mysqli_query($mysql, $sql);
					}
				}
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