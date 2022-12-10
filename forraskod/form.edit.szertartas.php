<?php ob_start(); ?>
<html>
<head>
<?php include("head.php"); ?>
<title>Litrugia szerkesztése - <?php echo $sitename; ?></title>
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
<div class="fejlecparallax">
<div class="head-text">
<h1><?php echo $sitename; ?> honlapja - Liturgia szerkesztése</h1>
</div>
</div>
</div>
<hr>
<nav>
<?php include("navbar.php"); ?>
<?php

include("headforadmin.php");
?>
</nav>
<hr>
</header>
<div class="content">
<div class="tartalom">
<form name="edit-szertartas" action="edit.szertartas.php" method="post">
    <?php
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
<table class="form">
<tr>
<td><label>Időpontja: </label></td>
<td><input type="datetime-local" name="date" value="<?php echo $date;?>"></td>
<td><label><!--Kérem ilyen formátumban adja meg az időpontot: 2020-04-04 08:00:00! Fontos a másodperc megadása is (lehet 00), mert különben nem működik a program! Pl.: 2021-04-12 08:00:00--></label></td>
</tr>
<tr>
	<td><label>Szertartás típusa: </label></td>
	<td>
		<select name="sztipus">
			<option value="semmi">--Kérem adja meg!--</option>
			<?php
			$sql = "SELECT * FROM `sznev`";
			$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
			while ($row = mysqli_fetch_array($eredmeny))
			{
				$szid = $row["id"];
				$szname = $row["name"];
				?>
				<option value="<?php echo $szid; ?>"<?php if ($nameid == $szid) { ?> selected <?php } ?>><?php echo $szname; ?></option>
				<?php
			}
			?>
		</select>
	</td>
	<td>Ha nem találja az adott liturgikus formát (pl.: szentmise vagy szentségimádás; ajánlatos megkülönböztetni a szentmisét és a gyászmisét) akkor kérem, kattintson <a href="create.sznev.php">ide</a>.</td>
</tr>
<tr>
<td><label>Megnevezés: </label></td>
<td><input type="text" name="name" value="<?php echo $name; ?>"></td>
<td><label>Pl.: Évközi 3. vasárnap</label></td>
</tr>
<tr>
<td><label>Hely: </label></td>
<td>
	<select name="telepules">
		<option value="semmi">--Válasszon települést!--</option>
		<?php
		$sql = "SELECT * FROM `telepulesek`";
		$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
		while ($row = mysqli_fetch_array($eredmeny))
		{
			$tlid = $row["id"];
			$tlname = $row["name"];
			?>
			<option value="<?php echo $tlid; ?>" <?php if ($telepulesid == $tlid) { ?> selected <?php } ?>><?php echo $tlname; ?></option>
			<?php
		}
		?>
	</select>
	<select name="templom">
		<option value="semmi">--Válasszon templomot--</option>
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
			<option value="<?php echo $tlid; ?>" <?php if ($templomid == $tlid) { ?> selected <?php } ?>><?php echo $tname; ?> - <?php echo $tlname; ?></option>
			<?php
		}
		?>
		<option value="egyeb" onclick="document.getElementsByName('egyebtemplom').style.display = 'inline';" <?php if ($place != null && $place != "") { ?> selected <?php } ?>>egyéb: </option>
	</select>
	<input type="text" name="egyebtemplom" value="<?php echo $place; ?>">
</td>
<td>Ha nem találja a keresett települést, hozza létre <a href="create.telepules.php">itt</a>. A templom létrehozásához kérem kattintson <a href="create.templom.php">ide</a>.</td>
</tr>
<tr>
	<td><label>Főcelebráns vagy a liturgia "házigazdája", akihez a szertartást rendeljük: </td>
	<td>
		<select name="celebrans">
			<option value="null">--Kérem válasszon--</option>
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
				<option value="<?php echo $cid; ?>"<?php if ($celid == $cid) { ?> selected <?php } ?>><?php echo $cname; ?></option>
				<?php
			}
			?>
		</select>
	</td>
</tr>
<tr>
	<td><label>Kántor: </td>
	<td>
		<select name="kantor">
			<option value="null">--Kérem válasszon--</option>
			<option value="null">--Nem tudom--</option>
		<option value="semmi">--Nem adom meg--</option>
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
	</td>
</tr>
<tr>
	<td><label>Típus: </label></td>
	<td><input type="radio" name="type" value="0" <?php if ($type == 0 && $type != null) { ?>checked <?php }?>>Csendes</input><input type="radio" name="type" value="1" <?php if ($type == 1) { ?>checked <?php }?>>Orgonás</input><input type="radio" name="type" value="2" <?php if ($type == 2) { ?>checked <?php }?>>Ünnepi</input></td>
</tr>
<tr>
	<td>
		<label>Szándék (ha van): </label>
	</td>
	<?php
	$szandekname = null;
	$szandekwho = null;
	$sql = "SELECT `szandek`, `kikerte` FROM `szandekok` WHERE `id` = '".$szandek."'";
	$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
	while ($row = mysqli_fetch_array($eredmeny))
	{
		$szandekname = $row["szandek"];
		$szandekwho = $row["kikerte"];
	}
	?>
	<td><input type="radio" name="szandekvan" value="2" <?php if ($szandek == "2") { ?>checked <?php } ?>>Erre a liturgiára ne lehessen szándékot választani</input><input type="radio" name="szandekvan" value="0" onclick="document.getElementsByName('szandek').disabled = false;" <?php if ($szandek == "0") { ?>checked <?php } ?>>Nincs</input><input type="radio" name="szandekvan" value="1" onclick="document.getElementsByName('szandek').disabled = false;"  <?php if ($szandek == 1 || $szandek > 2) { ?>checked <?php } ?>>Van</input>
	<select name="szandekbevitt">
		<option value="0">--Kérem válasszon!--</option>
		<option value="1" <?php if ($szandekwho == "!automata") { ?> selected <?php }?>>újat adok meg:</option>
		<?php
			$sql = "SELECT `id`, `szandek`, `kikerte`, `mikorra` FROM `szandekok` WHERE `id` > 2 && `kikerte` != '!automata'";
			$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
			while ($row = mysqli_fetch_array($eredmeny))
			{
				$szandekid = $row["id"];
				$szandekname = $row["szandek"];
				$szandekwho = $row["kikerte"];
				$szandekmikorra = $row["mikorra"];
				?>
				<option value="<?php echo $szandekid; ?>" <?php if ($szandek == $szandekid) { ?>selected <?php } ?>><?php echo $szandekname; ?> - <?php echo $szandekwho; ?> <?php if ($szandekmikorra != null) { ?>- <?php } echo $szandekmikorra; ?></option>
				<?php
			}
			//TODO automata szándék kijelzése úgy, mint a kért szándékot és lehetőség biztosítása a szándékok módosítására
		?>
	</select>
	<input type="text" name="szandek" value="<?php if ($szandekwho == "!automata") { echo $szandekname; } ?>">
	</td>
</tr>
<tr>
	<td><label>Publikus: </label></td>
	<td><input type="radio" name="pub" value="0" <?php if ($pub == 0) { ?>checked <?php }?>>Nem</input><input type="radio" name="pub" value="1" <?php if ($pub == 1) { ?>checked <?php }?>>Igen</input></td>
	<td>Ezt akkor kellhet átváltani "Nem"-re, ha például egy gyászmise van, vagy egy olyan szertartás mely "zárt körű", tehát az egyházközség nincs rá "meghívva". A "Nem" opció választásával a weboldalon csak azoknak jelenik meg a szertartás, akik bejelentkeztek.</td>
</tr>
<tr>
	<td><label>Megjegyzés azoknak, akik be tudnak jelentkezni: </label></td>
	<td><textarea name="megjegyzes"><?php echo $megj; ?></textarea></td>
</tr>
<tr>
	<td><label>Publikus megjegyzés, melyet mindenki lát, aki megnézi a weboldalt: </label></td>
	<td><textarea name="pubmegj"><?php echo $pubmegj; ?></textarea></td>
</tr>
<tr>
<td><label>Stílus: </label></td>
<td><input type="color" name="color" value="<?php if (str_contains($style, "color: #")) { echo substr($style, 7, 7); } ?>"><input type="checkbox" name="bold" value="font-weight: bold;" <?php if (str_contains($style, "font-weight: bold;")) { ?>checked <?php } ?>><b>Félkövér</b></input><input type="checkbox" name="italic" value="font-style: italic;" <?php if (str_contains($style, "font-style: italic;")) { ?>checked <?php } ?>><i>Dőlt</i></input><input type="checkbox" name="underline" value="text-decoration: underline;" <?php if (str_contains($style, "text-decoration: underline;")) { ?>checked <?php } ?>><span style="text-decoration: underline;">Aláhúzás</span></input></td>
<td><label>Nem kötelező, de meg lehet itt adni, hogyan nézzen ki, hogyan jelenjen meg a weboldalon ez a szertartás. Nagy ünnepeket érdemes pirossal jelölni például.</label></td>
</tr>
<tr>
<td><label></label></td>
<td>
	<input type="hidden" name="id" value="<?php echo $_POST["id"]; ?>">
	<input type="submit" value="Hozzáadás">
</td>
<td><label></label></td>
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