<?php ob_start(); ?>
<!DOCTYPE html>
<html>
<head>
<?php include("head.php"); ?>
<title>Liturgia szerkesztése - <?php echo $sitename; ?></title>
<meta name="language" content="hu-HU">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<?php
displayhead("Liturgia szerkesztése");
include("headforadmin.php");
?>
<div id="messagesdiv">
<?php
Message::displayall();
if (!checkpermission("editliturgia")) {
	displaymessage("danger", "Nincs jogosultsága liturgia szerkesztéséhez!");
	exit;
}
?>
</div>
<main class="container">
    <?php
	if (!isset($_POST["stage"])) {
	$date = null;
	$nameid = null;
	$name = null;
	$telepulesid = null;
	$templomid = null;
	$place = null;
	$style = null;
	$celid = null;
	$kantid = null;
	$type = null;
	$szandek = null;
	$pub = null;
	$megj = null;
	$pubmegj = null;
    $id = $_POST["id"];
	$sql = "SELECT * FROM `szertartasok` WHERE `id` = '".$id."'";
	$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
	while ($row = mysqli_fetch_array($eredmeny))
	{
		$date = $row["date"];
		$nameid = $row["nameID"];
		$name = $row["name"];
		$telepulesid = $row["telepulesID"];
		$templomid = $row["templomID"];
		$place = $row["place"];
		$style = $row["style"];
		$celid = $row["celebransID"];
		$kantid = $row["kantorID"];
		$type = $row["tipus"]; if ($row["tipus"] === NULL) {$type = null;}
		$szandek = $row["szandek"];
		$pub = $row['publikus'];
		$megj = $row["megjegyzes"];
		$pubmegj = $row["pubmegj"];
	}
	?>
<form name="edit-szertartas" action="#" method="post">
		<p><span style="color: red;">* kötelezően kitöltendő mező.</span></p>
	<div class="row my-3">
		<label for="date" class="col-sm-2 required">Időpontja:</label>
		<input type="datetime-local" class="col-sm form-control" name="date" id="date" required autofocus value="<?php echo $date;?>">
	</div>
		<div class="row my-3">
			<label for="sztipus" class="col-sm-2 required">Szertartás típusa:</label>
				<select name="sztipus" class="col-sm form-select" id="sztipus" required>
					<option value="">--Kérem adja meg!--</option>
					<?php
					$sql = "SELECT * FROM `sznev`";
					$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
					while ($row = mysqli_fetch_array($eredmeny))
					{
						$szid = $row["id"];
						$szname = $row["name"];
						?>
						<option value="<?php echo $szid; ?>" <?php if ($nameid == $szid) { ?> selected <?php } ?>><?php echo $szname; ?></option>
						<?php
					}
					?>
				</select>
			<label class="col-sm form-text">Ha nem találja az adott liturgikus formát (pl.: szentmise vagy szentségimádás; ajánlatos megkülönböztetni a szentmisét és a gyászmisét) akkor kérem, kattintson <a href="create.sznev.php">ide</a>.</label>
		</div>
	<div class="row my-3">
		<label for="name" class="col-sm-2">Megnevezés:</label>
		<input type="text" name="name" id="name" class="col-sm form-control" value="<?php echo $name; ?>">
		<label class="col-sm form-text">Pl.: Évközi 3. vasárnap</label>
	</div>
	<div class="row my-3">
		<label class="col-sm-2 required">Hely:</label>
			<!--TODO elég legyen a templomot kiválasztani-->
			<select name="telepules" class="col-sm form-select" required id="telepules">
				<option value="">--Válasszon települést!--</option>
				<?php
				$sql = "SELECT * FROM `telepulesek`";
				$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
				while ($row = mysqli_fetch_array($eredmeny))
				{
					$tlid = $row["id"];
					$tlname = $row["name"];
					?>
					<option value="<?php echo $tlid; ?>"  <?php if ($telepulesid == $tlid) { ?> selected <?php } ?>><?php echo $tlname; ?></option>
					<?php
				}
				?>
			</select>
			<select name="templom" class="col-sm form-select" required id="templom">
				<option value="">--Válasszon templomot--</option>
				<?php
				$sql = "SELECT `id`, `telepulesID`, `name` FROM `templomok`";
				$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
				while ($row = mysqli_fetch_array($eredmeny))
				{
					$tlid = $row["id"];
					$telid = $row["telepulesID"];
					$tname = null;
					$sqla = "SELECT `name` FROM `telepulesek` WHERE `id` = '".$telid."'";
					$eredmenya = mysqli_query($mysql, $sqla) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
					while ($rowa = mysqli_fetch_array($eredmenya))
					{
						$tname = $rowa["name"];
					}
					$tlname = $row["name"];
					?>
					<option value="<?php echo $tlid; ?>"  <?php if ($templomid == $tlid) { ?> selected <?php } ?>><?php echo $tname; ?> - <?php echo $tlname; ?></option>
					<?php
				}
				?>
				<option value="egyeb" onclick="document.getElementsByName('egyebtemplom').style.display = 'inline';" <?php if ($place != null && $place != "") { ?> selected <?php } ?>>egyéb: </option>
			</select>
			<input type="text" class="col-sm form-control" name="egyebtemplom" value="<?php echo $place; ?>" id="egyebtemplom">
		<label class="col-sm form-text">Ha nem találja a keresett települést, hozza létre <a href="create.telepules.php">itt</a>. A templom létrehozásához kérem kattintson <a href="create.templom.php">ide</a>.</label>
	</div>
		<div class="row my-3">
			<label for="celebrans" class="col-sm-2">Főcelebráns vagy a liturgia "házigazdája", akihez a szertartást rendeljük:</label>
				<select name="celebrans" class="col-sm form-select" id="celebrans">
					<option value="">--Kérem válasszon--</option>
					<option value="null">--Nem tudom--</option>
					<option value="semmi">--Nem adom meg--</option>
					<?php
					$sql = "SELECT `id`, `name` FROM `author` WHERE `egyhaziszint` = '2'";
					$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
					while ($row = mysqli_fetch_array($eredmeny))
					{
						$cid = $row["id"];
						$cname = $row["name"];
						?>
						<option value="<?php echo $cid; ?>" <?php if ($celid == $cid) { ?> selected <?php } ?>><?php echo $cname; ?></option>
						<?php
					}
					?>
				</select>
		</div>
		<div class="row my-3">
			<label for="kantor" class="col-sm-2">Kántor:</label>
				<select name="kantor" id="kantor" class="col-sm form-select">
					<option value="">--Kérem válasszon--</option>
					<option value="null" <?php autofillselect("kantor", "null"); ?>>--Nem tudom--</option>
				<option value="semmi" <?php autofillselect("kantor", "semmi"); ?>>--Nem adom meg--</option>
					<?php
					$sql = "SELECT `id`, `name` FROM `author` WHERE `egyhaziszint` = '1'";
					$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
					while ($row = mysqli_fetch_array($eredmeny))
					{
						$kid = $row["id"];
						$kname = $row["name"];
						?>
						<option value="<?php echo $kid; ?>" <?php if ($kantid == $kid) { ?> selected <?php } ?>><?php echo $kname; ?></option>
						<?php
					}
					?>
				</select>
		</div>
		<div class="row my-3">
			<label class="col-sm-2">Típus: </label>
			<div class="col-sm">
				<div class="form-check form-check-inline">
					<input type="radio" name="type" value="0" id="type0" class="form-check-input"  <?php if ($type == 0 && $type != null) { ?>checked <?php }?>>
					<label for="type0" class="form-check-label">Csendes</label>
				</div>
				<div class="form-check form-check-inline">
					<input type="radio" name="type" value="1" class="form-check-input" id="type1"  <?php if ($type == 1) { ?>checked <?php }?>>
					<label for="type1" class="form-check-label">Orgonás</label>
				</div>
				<div class="form-check form-check-inline">
					<input type="radio" name="type" value="2" class="form-check-input" id="type2"  <?php if ($type == 2) { ?>checked <?php }?>>
					<label for="type2" class="form-check-label">Ünnepi</label>
				</div>
			</div>
		</div>
		<div class="row my-3">
			<label class="col-sm-2">Szándék:</label>
			<div class="col-sm-8">
				<div class="form-check form-check-inline">
					<input type="radio" name="szandekvan" class="form-check-input" value="0" onclick="document.getElementsByName('szandek').disabled = false;" id="szandekvan0" <?php if ($szandek === "0") { ?>checked <?php } ?>>
					<label for="szandekvan0" class="form-check-label">Nincs</label>
				</div>
				<div class="form-check form-check-inline">
					<input type="radio" name="szandekvan" class="form-check-input" value="1" onclick="document.getElementsByName('szandek').disabled = false;" id="szandekvan1" <?php if ($szandek !== "0" && $szandek !== null) { ?>checked <?php } ?>>
					<label for="szandekvan1" class="form-check-label">Van:</label>
				</div>
				<input type="text" class="form-control" name="szandek" value="<?php if ($szandek != "0" && $szandek != "1" && $szandek != null) { echo $szandek; } ?>" style="display: inline-block; max-width:fit-content;">
			</div>
		</div>
		<div class="row my-3">
			<label class="col-sm-2 required">Publikus:</label>
			<div class="col-sm-1">
				<div class="form-check form-check-inline">
					<input type="radio" name="pub" value="0" id="pub0" class="form-check-input" <?php if ($pub == 0) { ?>checked <?php }?>>
					<label for="pub0" class="form-check-label">Nem</label>
				</div>
				<div class="form-check form-check-inline">
					<input type="radio" name="pub" value="1" id="pub1" class="form-check-input" <?php if ($pub == 1) { ?>checked <?php }?>>
					<label for="pub1" class="form-check-label">Igen</label>
				</div>
			</div>
			<label class="col-sm form-text">Ezt akkor kellhet átváltani "Nem"-re, ha például egy gyászmise van, vagy egy olyan szertartás mely "zárt körű", tehát az egyházközség nincs rá "meghívva". A "Nem" opció választásával a weboldalon csak azoknak jelenik meg a szertartás, akik bejelentkeztek.</label>
		</div>
		<div class="row my-3">
			<label for="megjegyzes" class="col-sm-2">Megjegyzés azoknak, akik be tudnak jelentkezni: </label>
			<textarea name="megjegyzes" id="megjegyzes" class="form-control col-sm"><?php echo $megj; ?></textarea>
			<label class="col-sm form-text">Ez a megjegyzés csak a bejelentkezett felhasználóknak fog megjelenni.</label>
		</div>
		<div class="row my-3">
			<label for="pubmegj" class="col-sm-2">Publikus megjegyzés, melyet mindenki lát, aki megnézi a weboldalt: </label>
			<textarea name="pubmegj" id="pubmegj" class="form-control col-sm"><?php echo $pubmegj; ?></textarea>
			<label class="col-sm form-text">Ezt a megjegyzést mindenki látni fogja.</label>
		</div>
	<div class="row my-3">
		<label class="col-sm-2">Stílus:</label>
		<div class="col-sm">
			<input type="color" name="color" value="<?php if (str_contains($style, "color: #")) { echo substr($style, 7, 7); } ?>" class="form-control" style="display: inline; max-width: 25%;">
			<div style="display: inline;">
				<div class="form-check form-check-inline">
					<input type="checkbox" name="bold" value="font-weight: bold;" id="bold" class="form-check-input" <?php if (str_contains($style, "font-weight: bold;")) { ?>checked <?php } ?>>
					<label class="form-check-label" for="bold"><b>Félkövér</b></label>
				</div>
				<div class="form-check form-check-inline">
					<input type="checkbox" name="italic" value="font-style: italic;" id="italic" class="form-check-input" <?php if (str_contains($style, "font-style: italic;")) { ?>checked <?php } ?>>
					<label class="form-check-label" for="italic"><i>Dőlt</i></label>
				</div>
				<div class="form-check form-check-inline">
					<input type="checkbox" name="underline" value="text-decoration: underline;" id="underline" class="form-check-input" <?php if (str_contains($style, "text-decoration: underline;")) { ?>checked <?php } ?>>
					<label class="form-check-label" for="underline"><span style="text-decoration: underline;">Aláhúzás</span></label>
				</div>
			</div>
		</div>
		<label class="col-sm form-text">Nem kötelező, de meg lehet itt adni, hogyan nézzen ki, hogyan jelenjen meg a weboldalon ez a szertartás. Nagy ünnepeket érdemes pirossal jelölni például.</label>
	</div>
	<input type="hidden" name="stage" value="2">
	<input type="hidden" name="id" value="<?php echo $_POST["id"]; ?>">
	<button type="submit" class="btn btn-primary text-white"><i class="bi bi-pencil-square"></i> Mentés</button>
	</form>
	<?php }
	if (isset($_POST["stage"])) {
		if ($_POST["stage"] == "elmarad") {
			$sql = "UPDATE `szertartasok` SET `elmarad`='1' WHERE `id` = '".$_POST["id"]."'";
			$eredmeny = mysqli_query($mysql, $sql);
			if ($eredmeny == true) {
				$_SESSION["messages"][] = new Message("Liturgia sikeresen átállítva elmaradtra!", MessageType::success, true);
				mysqli_close($mysql);
				header("Location: miserend.php");
			} else {
				$_SESSION["messages"][] = new Message("Liturgia elmaradtra állítása nem sikerült! Kérem, próbálja újra.", MessageType::danger, true);
				mysqli_close($mysql);
				header("Location: miserend.php");
			}
		}
		if ($_POST["stage"] == "nemelmarad") {
			$sql = "UPDATE `szertartasok` SET `elmarad`='0' WHERE `id` = '".$_POST["id"]."'";
			$eredmeny = mysqli_query($mysql, $sql);
			if ($eredmeny == true) {
				$_SESSION["messages"][] = new Message("Liturgia sikeresen átállítva megtartottra!", MessageType::success, true);
				mysqli_close($mysql);
				header("Location: miserend.php");
			} else {
				$_SESSION["messages"][] = new Message("Liturgia átállítása megtartottra nem sikerült.", MessageType::danger, true);
				mysqli_close($mysql);
				header("Location: miserend.php");
			}
		}
		if ($_POST["stage"] == 2) {
			// FIXME megnevezés módosítása nem működik
$sztipus = null;
$telepules = null;
$templom = null;
$celebrans = null;
$kantor = null;
$type = null;
$szandekvan = null;
$szandek = null;
$pub = null;
$megj = null;
$pubmegj = null;
$datum = null;
$name = null;
$place = null;
$color = null;
$bold = null;
$italic = null;
$underline = null;
$style = null;

$sztipus = correct($_POST["sztipus"]); if ($sztipus == "semmi") { $sztipus = null;}
$telepules = correct($_POST["telepules"]); if ($telepules == "semmi") { $telepules = null;}
$templom = correct($_POST["templom"]); if ($templom == "semmi" || $templom == "egyeb") { $templom = null;}
$celebrans = correct($_POST["celebrans"]); if ($celebrans == "null") { $celebrans = null; } if ($celebrans == "semmi") { $celebrans = null;}
$kantor = correct($_POST["kantor"]); if ($kantor == "null") { $kantor = null; } if ($kantor == "semmi") { $kantor = null;}
if (isset($_POST["type"])) { $type = correct($_POST["type"]); } else { $type = null; }
//TODO új szándék rendszer feldolgozása
if (isset($_POST["szandekvan"])) { $szandekvan = correct($_POST["szandekvan"]); } else { $szandekvan = null; }
$szandek = correct($_POST["szandek"]); if ($szandek == "") { $szandek = null; } if ($szandekvan == 0) {$szandek = 0;} if ($szandekvan == null) { $szandek = null; } if ($szandekvan == 1 && $szandek === null) { $szandek = 1; }
$pub = correct($_POST["pub"]);
$megj = $_POST["megjegyzes"]; if ($megj == "") {$megj = null;}
$pubmegj = $_POST["pubmegj"]; if ($pubmegj == "") {$pubmegj = null;}
// TODO más dátum kezelés ld. create.szertartas.php
$datum = $_POST["date"].":00";
$date = str_replace("T", " ", $datum);
$name = correct($_POST["name"]); if ($name == "") {$name = null;}
$place = correct($_POST["egyebtemplom"]); if ($place == "") { $place = null;}
// TODO regex
$color = "color: " . $_POST["color"] . "; ";
if (isset($_POST["bold"])) { $bold = $_POST["bold"] . " "; }
if (isset($_POST["italic"])) { $italic = $_POST["italic"] . " "; }
if (isset($_POST["underline"])) { $underline = $_POST["underline"]; }
$style = "";
if ($color != "color: #000000;")
{
	$style = $color;
}
if ($bold == "font-weight: bold; ")
{
	$style .= $bold;
}
if ($italic == "font-style: italic; ")
{
	$style .= $italic;
}
if ($underline == "text-decoration: underline;")
{
	$style .= $underline;
}
$regex = "/^[^\<\>\{\}\']*$/";
if (!preg_match($regex, $style))
{
$style = null;
}
$id = correct($_POST["id"]);
$sql = "SELECT `telepulesID` FROM `templomok` WHERE `id` = '".$templom."'";
$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
while ($row = mysqli_fetch_array($eredmeny))
{
	$ttel = $row["telepulesID"];
	// TODO ne így jelenítsük meg, hanem a form validationnal!
	if ($ttel != $telepules)
	{
		$_SESSION["messages"][] = new Message("A választott templom nem a megadott településen van!", MessageType::danger, false);
		mysqli_close($mysql);
		header("Location: edit.szertartas.php");
	}
}
if ($date != null) {
	$sql = "UPDATE `szertartasok` SET `date`='".$date."',`nameID`='".$sztipus."',`name`='".$name."',`telepulesID`='".$telepules."',";
	if ($templom != null) { $sql .= "`templomID`='".$templom."',"; } else { $sql .= "`templomID`=NULL,";}
	if ($place != null) { $sql .= "`place`='".$place."',"; } else { $sql .= "`place`=NULL,";}
	if ($style != null && $style != "") { $sql .= "`style`='".$style."',"; } else { $sql .= "`style`=NULL,";}
	if ($celebrans != null) { $sql .= "`celebransID`='".$celebrans."',"; } else { $sql .= "`celebransID`=NULL,";}
	if ($kantor != null) { $sql .= "`kantorID`='".$kantor."',"; } else { $sql .= "`kantorID`=NULL,";}
	if ($type != null) { $sql .= "`tipus`='".$type."',"; } else { $sql .= "`tipus`=NULL,";}
	if ($szandek !== null) { $sql .= "`szandek`='".$szandek."',"; } else { $sql .= "`szandek`=NULL,";}
	$sql .= "`publikus`='".$pub."',";
	if ($megj != null) { $sql .= "`megjegyzes`='".$megj."',"; } else { $sql .= "`megjegyzes`=NULL,";}
	if ($pubmegj != null) { $sql .= "`pubmegj`='".$pubmegj."'"; } else { $sql .= "`pubmegj`=NULL";}
	$sql .= " WHERE `id` = '$id'";

$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
if ($eredmeny) {
	$_SESSION["messages"][] = new Message("Liturgia sikeresen módosítva!", MessageType::success, true);
	mysqli_close($mysql);
	header("Location: miserend.php");
} else {
	$_SESSION["messages"][] = new Message("Valami nem sikerült.", MessageType::danger, true);
	mysqli_close($mysql);
	header("Location: miserend.php");
} }
else {
	$_SESSION["messages"][] = new Message("Valami nem sikerült.", MessageType::danger, true);
	mysqli_close($mysql);
	header("Location: miserend.php");

} } }
?>
</main>
<?php include("footer.php"); ?>
</body>
</html>