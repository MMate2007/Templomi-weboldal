<?php ob_start(); ?>
<!DOCTYPE html>
<html>
<head>
<?php include("head.php"); ?>
<title>Litrugia hozzáadása - <?php echo $sitename; ?></title>
<meta name="language" content="hu-HU">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script>
	function toggleregular() {
		const button = document.querySelector("#regulartoggler");
		const datetime = document.querySelector("#datetime");
		const date = document.querySelector("#dateintervall");
		const time = document.querySelector("#time");
		const regular = document.querySelector("#regular");
		if (button.textContent == "Váltás több szertartás megadására") {
			button.textContent = "Váltás egyszeri szertartás megadására";
			datetime.setAttribute("style", "display: none;");
			date.removeAttribute("style");
			time.removeAttribute("style");
			regular.value = "1";
		} else if (button.textContent == "Váltás egyszeri szertartás megadására") {
			button.textContent = "Váltás több szertartás megadására";
			datetime.removeAttribute("style");
			date.setAttribute("style", "display: none;");
			time.setAttribute("style", "display: none;");
			regular.value = "0";
		}
	}
</script>
</head>
<body class="d-flex flex-column h-100">
<?php
displayhead("Liturgia hozzáadása");
include("headforadmin.php");
?>
<div id="messagesdiv">
	<?php
	Message::displayall();
	if (!checkpermission("addliturgia"))
	{
		displaymessage("danger", "Nincs jogosultsága liturgia hozzáadásához!");
		exit;
	}
	?>
</div>
<main class="container">
	<form name="create-szertartas" action="#" method="post">
		<p><span style="color: red;">* kötelezően kitöltendő mező.</span></p>
		<button class="btn btn-outline-primary" onclick="toggleregular()" id="regulartoggler" type="button">Váltás több szertartás megadására</button>
		<input type="hidden" name="regular" value="0" id="regular">
	<div class="row my-3" id="datetime">
		<label for="date" class="col-sm-2 required">Időpontja:</label>
		<input type="datetime-local" class="col-sm form-control" name="date" id="date" <?php autofill("date"); ?>>
	</div>
	<div id="dateintervall" style="display:none;">
		<div class="row my-3">
			<label for="start" class="required col-sm-2">Intervallum kezdete:</label>
			<input type="date" name="start" id="start" class="form-control col-sm" <?php autofill("start"); ?>>
		</div>
		<div class="row my-3">
			<label for="end" class="required col-sm-2">Intervallum vége:</label>
			<input type="date" name="end" id="end" class="form-control col-sm" <?php autofill("end"); ?>>
		</div>
		<div class="row my-3">
			<label class="required col-sm-2" for="checkdiv">Napok:</label>
			<div id="checkdiv" class="col-sm" style="display: inline;">
				<div class="form-check form-check-inline">
					<input type="checkbox" name="days[]" id="monday" value="1" class="form-check-input" <?php autofillcheck("days", "1"); ?>>
					<label for="monday" class="form-check-label">Hétfő</label>
				</div>
				<div class="form-check form-check-inline">
					<input type="checkbox" name="days[]" id="tuesday" value="2" class="form-check-input" <?php autofillcheck("days", "2"); ?>>
					<label for="tuesday" class="form-check-label">Kedd</label>
				</div>
				<div class="form-check form-check-inline">
					<input type="checkbox" name="days[]" id="wednesday" value="3" class="form-check-input" <?php autofillcheck("days", "3"); ?>>
					<label for="wednesday" class="form-check-label">Szerda</label>
				</div>
				<div class="form-check form-check-inline">
					<input type="checkbox" name="days[]" id="thursday" value="4" class="form-check-input" <?php autofillcheck("days", "4"); ?>>
					<label for="thursday" class="form-check-label">Csütörtök</label>
				</div>
				<div class="form-check form-check-inline">
					<input type="checkbox" name="days[]" id="friday" value="5" class="form-check-input" <?php autofillcheck("days", "5"); ?>>
					<label for="friday" class="form-check-label">Péntek</label>
				</div>
				<div class="form-check form-check-inline">
					<input type="checkbox" name="days[]" id="saturday" value="6" class="form-check-input" <?php autofillcheck("days", "6"); ?>>
					<label for="saturday" class="form-check-label">Szombat</label>
				</div>
				<div class="form-check form-check-inline">
					<input type="checkbox" name="days[]" id="sunday" value="0" class="form-check-input" <?php autofillcheck("days", "0"); ?>>
					<label for="sunday" class="form-check-label">Vasárnap</label>
				</div>
			</div>
		</div>
	</div>
	<div class="row my-3" id="time" style="display:none;">
		<label for="timeinput" class="col-sm-2 required">Idő:</label>
		<input type="time" name="time" id="timeinput" class="form-control col-sm" <?php autofill("time"); ?>>
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
						<option value="<?php echo $szid; ?>" <?php autofillselect("sztipus", $szid); ?>><?php echo $szname; ?></option>
						<?php
					}
					?>
				</select>
			<label class="col-sm form-text">Ha nem találja az adott liturgikus formát (pl.: szentmise vagy szentségimádás; ajánlatos megkülönböztetni a szentmisét és a gyászmisét) akkor kérem, kattintson <a href="create.sznev.php">ide</a>.</label>
		</div>
	<div class="row my-3">
		<label for="name" class="col-sm-2">Megnevezés:</label>
		<input type="text" name="name" id="name" class="col-sm form-control" <?php autofill("name"); ?>>
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
					<option value="<?php echo $tlid; ?>" <?php autofillselect("telepules", $tlid); ?>><?php echo $tlname; ?></option>
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
					<option value="<?php echo $tlid; ?>" <?php autofillselect("templom", $tlid); ?>><?php echo $tname; ?> - <?php echo $tlname; ?></option>
					<?php
				}
				?>
				<option value="egyeb" onclick="document.getElementsByName('egyebtemplom').style.display = 'inline';" <?php autofillselect("templom", "egyeb"); ?>>egyéb: </option>
			</select>
			<input type="text" class="col-sm form-control" name="egyebtemplom" <?php autofill("egyebtemplom"); ?> id="egyebtemplom">
		<label class="col-sm form-text">Ha nem találja a keresett települést, hozza létre <a href="create.telepules.php">itt</a>. A templom létrehozásához kérem kattintson <a href="create.templom.php">ide</a>.</label>
	</div>
		<div class="row my-3">
			<label for="celebrans" class="col-sm-2">Főcelebráns vagy a liturgia "házigazdája", akihez a szertartást rendeljük:</label>
				<select name="celebrans" class="col-sm form-select" id="celebrans">
					<option value="">--Kérem válasszon--</option>
					<option value="null" <?php autofillselect("celebrans", "null"); ?>>--Nem tudom--</option>
					<option value="semmi"<?php autofillselect("celebrans", "semmi"); ?>>--Nem adom meg--</option>
					<?php
					$sql = "SELECT `id`, `name` FROM `author` WHERE `egyhaziszint` = '2'";
					$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
					while ($row = mysqli_fetch_array($eredmeny))
					{
						$cid = $row["id"];
						$cname = $row["name"];
						?>
						<option value="<?php echo $cid; ?>" <?php autofillselect("celebrans", $cid); ?>><?php echo $cname; ?></option>
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
						<option value="<?php echo $kid; ?>" <?php autofillselect("kantor", $kid); ?>><?php echo $kname; ?></option>
						<?php
					}
					?>
				</select>
		</div>
		<div class="row my-3">
			<label class="col-sm-2">Típus: </label>
			<div class="col-sm">
				<div class="form-check form-check-inline">
					<input type="radio" name="type" value="0" id="type0" class="form-check-input" <?php autofillcheck("type", "0"); ?>>
					<label for="type0" class="form-check-label">Csendes</label>
				</div>
				<div class="form-check form-check-inline">
					<input type="radio" name="type" value="1" class="form-check-input" id="type1" <?php autofillcheck("type", "1"); ?>>
					<label for="type1" class="form-check-label">Orgonás</label>
				</div>
				<div class="form-check form-check-inline">
					<input type="radio" name="type" value="2" class="form-check-input" id="type2" <?php autofillcheck("type", "2"); ?>>
					<label for="type2" class="form-check-label">Ünnepi</label>
				</div>
			</div>
		</div>
		<div class="row my-3">
			<label class="col-sm-2">Szándék:</label>
			<div class="col-sm-8">
				<div class="form-check form-check-inline">
					<input type="radio" name="szandekvan" class="form-check-input" value="0" onclick="document.getElementsByName('szandek').disabled = false;" id="szandekvan0" <?php autofillcheck("szandekvan", "0"); ?>>
					<label for="szandekvan0" class="form-check-label">Nincs</label>
				</div>
				<div class="form-check form-check-inline">
					<input type="radio" name="szandekvan" class="form-check-input" value="1" onclick="document.getElementsByName('szandek').disabled = false;" id="szandekvan1" <?php autofillcheck("szandekvan", "1"); ?>>
					<label for="szandekvan1" class="form-check-label">Van:</label>
				</div>
				<input type="text" class="form-control" name="szandek" <?php autofill("szandek"); ?> style="display: inline-block; max-width:fit-content;">
			</div>
		</div>
		<div class="row my-3">
			<label class="col-sm-2 required">Publikus:</label>
			<div class="col-sm-1">
				<div class="form-check form-check-inline">
					<input type="radio" name="pub" value="0" id="pub0" class="form-check-input" <?php autofillcheck("pub", "0"); ?>>
					<label for="pub0" class="form-check-label">Nem</label>
				</div>
				<div class="form-check form-check-inline">
					<input type="radio" name="pub" value="1" id="pub1" class="form-check-input" <?php if (isset($_POST["pub"])) { if ($_POST["pub"] != 0) { echo "checked"; } } else { echo "checked"; } ?>>
					<label for="pub1" class="form-check-label">Igen</label>
				</div>
			</div>
			<label class="col-sm form-text">Ezt akkor kellhet átváltani "Nem"-re, ha például egy gyászmise van, vagy egy olyan szertartás mely "zárt körű", tehát az egyházközség nincs rá "meghívva". A "Nem" opció választásával a weboldalon csak azoknak jelenik meg a szertartás, akik bejelentkeztek.</label>
		</div>
		<div class="row my-3">
			<label for="megjegyzes" class="col-sm-2">Megjegyzés azoknak, akik be tudnak jelentkezni: </label>
			<textarea name="megjegyzes" id="megjegyzes" class="form-control col-sm"><?php if (isset($_POST["megjegyzes"])) { echo(correct($_POST["megjegyzes"])); } ?></textarea>
			<label class="col-sm form-text">Ez a megjegyzés csak a bejelentkezett felhasználóknak fog megjelenni.</label>
		</div>
		<div class="row my-3">
			<label for="pubmegj" class="col-sm-2">Publikus megjegyzés, melyet mindenki lát, aki megnézi a weboldalt: </label>
			<textarea name="pubmegj" id="pubmegj" class="form-control col-sm"><?php if (isset($_POST["pubmegj"])) { echo(correct($_POST["pubmegj"])); } ?></textarea>
			<label class="col-sm form-text">Ezt a megjegyzést mindenki látni fogja.</label>
		</div>
	<div class="row my-3">
		<label class="col-sm-2">Stílus:</label>
		<div class="col-sm">
			<input type="color" name="color" <?php autofill("color"); ?> class="form-control" style="display: inline; max-width: 23%;">
			<div style="display: inline;">
				<div class="form-check form-check-inline">
					<input type="checkbox" name="bold" value="font-weight: bold;" id="bold" class="form-check-input" <?php autofillcheck("bold", "font-weight: bold;"); ?>>
					<label class="form-check-label" for="bold"><b>Félkövér</b></label>
				</div>
				<div class="form-check form-check-inline">
					<input type="checkbox" name="italic" value="font-style: italic;" id="italic" class="form-check-input" <?php autofillcheck("italic", "font-style: italic;"); ?>>
					<label class="form-check-label" for="italic"><i>Dőlt</i></label>
				</div>
				<div class="form-check form-check-inline">
					<input type="checkbox" name="underline" value="text-decoration: underline;" id="underline" class="form-check-input" <?php autofillcheck("underline", "text-decoration: underline;"); ?>>
					<label class="form-check-label" for="underline"><span style="text-decoration: underline;">Aláhúzás</span></label>
				</div>
			</div>
		</div>
		<label class="col-sm form-text">Nem kötelező, de meg lehet itt adni, hogyan nézzen ki, hogyan jelenjen meg a weboldalon ez a szertartás. Nagy ünnepeket érdemes pirossal jelölni például.</label>
	</div>
	<input type="hidden" name="stage" value="2">
	<button type="submit" class="btn btn-primary text-white"><i class="bi bi-plus-lg"></i> Hozzáadás</button>
	</form>
	<script>
		<?php
		if (isset($_POST["regular"])) {
		if ($_POST["regular"] == 1) {
			?>
			toggleregular();
			<?php
		} }
		?>
	</script>
	<?php
	if (isset($_POST["stage"])) {
		if ($_POST["stage"] == 2) {
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
			$mehet = true;

			$sztipus = correct($_POST["sztipus"]);
			$telepules = correct($_POST["telepules"]);
			$templom = correct($_POST["templom"]); if ($templom == "egyeb") { $templom = null;}
			$celebrans = correct($_POST["celebrans"]); if ($celebrans == "null") { $celebrans = null; } if ($celebrans == "semmi") { $celebrans = null;}
			$kantor = correct($_POST["kantor"]); if ($kantor == "null") { $kantor = null; } if ($kantor == "semmi") { $kantor = null;}
			if (isset($_POST["type"])) { $type = correct($_POST["type"]); }
			if (isset($_POST["szandekvan"])) { $szandekvan = correct($_POST["szandekvan"]); }
			$szandek = correct($_POST["szandek"]);
			$pub = correct($_POST["pub"]);
			$megj = correct($_POST["megjegyzes"]);
			$pubmegj = correct($_POST["pubmegj"]);
			if ($_POST["regular"] == "0") {
			if ($_POST["date"] == null) {
				formvalidation("#date", false, "A mező üres!");
				$mehet = false;
			}
			$date = date_create($_POST["date"]);
			if ($date < date_create()) {
				formvalidation("#date", false, "A megadott időpont a múltban van!");
				$mehet = false;
			} } else {
			$start = date_create($_POST["start"]);
			$end = date_create($_POST["end"]);
			if ($_POST["start"] == null) {
				$message = new Message("Az intervallum kezdete mező üres!", MessageType::danger);
				$message->insertontop();
				formvalidation("#start", false, "Az intervallum vége mező üres!");
				$mehet = false;
			} else {
				if ($start < date_create()) {
					$message = new Message("Az intervallum kezdete a múltban van!", MessageType::danger);
					$message->insertontop();
					formvalidation("#start", false, "Az intervallum kezdete a múltban van!");
					$mehet = false;
				}
			}
			if ($_POST["end"] == null) {
				$message = new Message("Az intervallum vége mező üres!", MessageType::danger);
				$message->insertontop();
				formvalidation("#end", false, "Az intervallum vége mező üres!");
				$mehet = false;
			} else {
				if ($end < date_create()) {
					$message = new Message("Az intervallum vége a múltban van!", MessageType::danger);
					$message->insertontop();
					formvalidation("#end", false, "Az intervallum vége a múltban van!");
					$mehet = false;
				}
			}
			if ($_POST["time"] == null) {
				$message = new Message("Az idő mező üres!", MessageType::danger);
				$message->insertontop();
				formvalidation("#timeinput", false, "Az idő mező üres!");
				$mehet = false;
			}
			if (!isset($_POST["days"])) {
				$message = new Message("Nem lett kiválasztva egy nap sem!", MessageType::danger);
				$message->insertontop();
				$mehet = false;
			}
			if ($mehet == true) {
			if ($end < $start) {
				$message = new Message("Az intervallum vége korábbra van állítva, mint a kezdete!", MessageType::danger);
				$message->insertontop();
				formvalidation("#end", false, "Az intervallum vége korábbra van állítva, mint a kezdete!");
				$mehet = false;
			} }
			$time = correct($_POST["time"]);
			}
			$name = correct($_POST["name"]);
			$place = correct($_POST["egyebtemplom"]);
			$postcolor = $_POST["color"];
			if (!check($postcolor, "colorhex"))
			{
				$postcolor = "#000000";
			}
			$color = "color: " . $postcolor . "; ";
			if (isset($_POST["bold"])) {
			$bold = $_POST["bold"] . " ";
			if (!check($bold, "styleexpression")) {
				$bold = null;
			} }
			if (isset($_POST["italic"])) {
			$italic = $_POST["italic"] . " ";
			if (!check($italic, "styleexpression")) {
				$italic = null;
			} }
			if (isset($_POST["underline"])) {
			$underline = $_POST["underline"];
			if (!check($underline, "styleexpression")) {
				$underline = null;
			} }
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
			if ($szandekvan == 1 && $szandek == null) {
				$szandek = $szandekvan;
			} else if ($szandekvan == 0) {
				$szandek = 0;
			}
			if ($szandekvan === null) {
				$szandek = null;
			}
			$sql = "SELECT * FROM `szertartasok`";
			$id = 0;
			$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
			while ($row = mysqli_fetch_array($eredmeny))
			{
				if (!isset($start)) {
				if ($row["date"] == date_format($date, "Y-m-d H:i:s") && $row["templomID"] == $templom)
				{
					$message = new Message("Ebben az időpontban már van egy másik liturgia a megadott templomban.", MessageType::danger, false);
					$message->insertontop();
					formvalidation("#date", false, "<span class='text-warning'>Ebben az időpontban már van egy másik liturgia a megadott templomban.</span>");
					$mehet = false;
					break;
				} }
				$_id = $row['id'];
				$id = $_id + 1;
			}
			if ($templom != null) {
			$sql = "SELECT `telepulesID` FROM `templomok` WHERE `id` = '".$templom."'";
			$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
			while ($row = mysqli_fetch_array($eredmeny))
			{
				$ttel = $row["telepulesID"];
				if ($ttel != $telepules)
				{
					formvalidation("#telepules", false);
					formvalidation("#templom", false, "A kiválasztott templom nem a megadott településen van!");
					$mehet = false;
				}
			} }
			if ($templom == null) {
				if ($place == null) {
					$mehet = false;
					formvalidation("#egyebtemplom", false, "Nem lett kitöltve a mező!");
					formvalidation("#templom", true);
					formvalidation("#telepules", true);
				}
			}
			if (!isset($_POST["ignorecelandkant"])) {
				$perc = getsetting("warning.idomisekkozott.perc");
				if ($celebrans != null) {
				$sql = "SELECT `date` FROM `szertartasok` WHERE `celebransID` = '$celebrans'";
				$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
				while ($row = mysqli_fetch_array($eredmeny)) {
					if (abs(strtotime($row["date"]) - $date->getTimestamp()) / 60 < $perc) {
						$message = new Message($perc." percen belül van máshol is a megadott celebránsnak liturgiája! A probléma figyelmen kívül hagyásához kattintson újra a hozzáadásra!", MessageType::warning, false);
						$message->insertontop();
						formvalidation("#celebrans", false, $perc." percen belül van máshol is a megadott celebránsnak liturgiája! A probléma figyelmen kívül hagyásához kattintson újra a hozzáadásra!<input type='hidden' name='ignorecelandkant' value='1'>");
						$mehet = false;
					}
				} }
				if ($kantor != null) {
				$sql = "SELECT `date` FROM `szertartasok` WHERE `kantorID` = '$kantor'";
				$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
				while ($row = mysqli_fetch_array($eredmeny)) {
					if (abs(strtotime($row["date"]) - $date->getTimestamp()) / 60 < $perc) {
						$message = new Message($perc." percen belül van máshol is a megadott kántornak liturgiája! A probléma figyelmen kívül hagyásához kattintson újra a hozzáadásra!", MessageType::warning, false);
						$message->insertontop();
						formvalidation("#kantor", false, $perc." percen belül van máshol is a megadott kántornak liturgiája! A probléma figyelmen kívül hagyásához kattintson újra a hozzáadásra!<input type='hidden' name='ignorecelandkant' value='1'>");
						$mehet = false;
					}
				} }
			}
			if ($mehet != false) {
				if (!isset($start)) {
				$sql = "INSERT INTO `szertartasok`(`id`, `date`, `nameID`, `name`, `telepulesID`, `templomID`, `place`, `style`, `celebransID`, `kantorID`, `tipus`, `szandek`, `publikus`, `megjegyzes`, `pubmegj`) VALUES ('".$id."','".date_format($date, "Y-m-d H:i:s")."','".$sztipus."','".$name."','".$telepules."',";
				if ($templom != null) { $sql .= "'".$templom."',"; } else { $sql .= "NULL,";}
				if ($place != null) { $sql .= "'".$place."',"; } else { $sql .= "NULL,";}
				if ($style != null && $style != "") { $sql .= "'".$style."',"; } else { $sql .= "NULL,";}
				if ($celebrans != null) { $sql .= "'".$celebrans."',"; } else { $sql .= "NULL,";}
				if ($kantor != null) { $sql .= "'".$kantor."',"; } else { $sql .= "NULL,";}
				if ($type != null) { $sql .= "'".$type."',"; } else { $sql .= "NULL,";}
				if ($szandek !== null) { $sql .= "'".$szandek."',"; } else { $sql .= "NULL,";}
				$sql .= "'".$pub."',";
				if ($megj != null) { $sql .= "'".$megj."',"; } else { $sql .= "NULL,";}
				if ($pubmegj != null) { $sql .= "'".$pubmegj."'"; } else { $sql .= "NULL";}
				$sql .= ")";
				$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>"); }
				else {
					$sql = "SELECT * FROM `szertartasok`";
					$szertartasok = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
					$rows = mysqli_fetch_all($szertartasok, MYSQLI_ASSOC);
					for ($date = $start; $date <= $end; $date->modify("+1 day")) {
						if (in_array($date->format("w"), $_POST["days"])) {
							foreach ($rows as $row)
							{
								if ($row["date"] == date_format($date, "Y-m-d ").$time.":00" && $row["templomID"] == $templom)
								{
									if (!isset($ismetlodes)) {
										$ismetlodes = new Message("Néhány szertartás nem került hozzáadásra, hiszen a megadott templomban, a megadott időben már van szertartás bejegyezve!", MessageType::warning);
										$ismetlodes->insertontop();
									}
									continue 2;
								}
							}
							$sql = "INSERT INTO `szertartasok`(`date`, `nameID`, `name`, `telepulesID`, `templomID`, `place`, `style`, `celebransID`, `kantorID`, `tipus`, `szandek`, `publikus`, `megjegyzes`, `pubmegj`) VALUES ('".date_format($date, "Y-m-d")." $time','".$sztipus."','".$name."','".$telepules."',";
							if ($templom != null) { $sql .= "'".$templom."',"; } else { $sql .= "NULL,";}
							if ($place != null) { $sql .= "'".$place."',"; } else { $sql .= "NULL,";}
							if ($style != null && $style != "") { $sql .= "'".$style."',"; } else { $sql .= "NULL,";}
							if ($celebrans != null) { $sql .= "'".$celebrans."',"; } else { $sql .= "NULL,";}
							if ($kantor != null) { $sql .= "'".$kantor."',"; } else { $sql .= "NULL,";}
							if ($type != null) { $sql .= "'".$type."',"; } else { $sql .= "NULL,";}
							if ($szandek !== null) { $sql .= "'".$szandek."',"; } else { $sql .= "NULL,";}
							$sql .= "'".$pub."',";
							if ($megj != null) { $sql .= "'".$megj."',"; } else { $sql .= "NULL,";}
							if ($pubmegj != null) { $sql .= "'".$pubmegj."'"; } else { $sql .= "NULL";}
							$sql .= ")";
							$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
						}
					}
				}
			}
			else {
				$message = new Message("A liturgia hozzáadása nem sikerült! Kérem javítsa ki a jelzett hibákat, s próbálja újra!", MessageType::danger, false);
				$message->insertontop();
			}
			if ($eredmeny == true && $mehet == true)
			{
				$message = new Message("Liturgia létrehozása sikeres.", MessageType::success);
				$message->insertontop();
			}else if ($eredmeny == false && $mehet == true) {
				$message = new Message("Valami hiba történt! Kérem nézze meg, hogy sikerült-e rögzíteni a liturgiát, s próbálja újra.", MessageType::danger);
				$message->insertontop();
			}
		}
	}
	?>
</main>
<?php include("footer.php"); ?>
</body>
</html>