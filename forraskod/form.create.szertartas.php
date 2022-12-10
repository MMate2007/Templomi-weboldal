<html>
<head>
<?php include("head.php"); ?>
<title>Litrugia hozzáadása - <?php echo $sitename; ?></title>
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
<h1><?php echo $sitename; ?> honlapja - Liturgia hozzáadása</h1>
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
	<p><a href="#rendszeresmise">Rendszeres liturgia hozzáadása</a>    A rendszeres liturgia opcióval hozzáadhatunk egyszerre több lituriát is ütemezetten (pl. a hónap minden vasárnapjára írunk be szentmisét).</p>
<form name="create-szertartas" action="create.szertartas.php" method="post">
<table class="form">
<tr>
<td><label>Időpontja: </label></td>
<td><input type="datetime-local" name="date"></td>
<td><label><!--Kérem ilyen formátumban adja meg az időpontot: 2020-04-04 08:00:00! Fontos a másodperc megadása is (lehet 00), mert különben nem működik a program! Pl.: 2021-04-12 08:00:00--></label></td>
</tr>
<tr>
	<td><label>Szertartás típusa: </label></td>
	<td>
		<select name="sztipus" required>
			<option value="semmi">--Kérem adja meg!--</option>
			<?php
			$sql = "SELECT * FROM `sznev`";
			$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
			while ($row = mysqli_fetch_array($eredmeny))
			{
				$szid = $row["id"];
				$szname = $row["name"];
				?>
				<option value="<?php echo $szid; ?>"><?php echo $szname; ?></option>
				<?php
			}
			?>
		</select>
	</td>
	<td>Ha nem találja az adott liturgikus formát (pl.: szentmise vagy szentségimádás; ajánlatos megkülönböztetni a szentmisét és a gyászmisét) akkor kérem, kattintson <a href="create.sznev.php">ide</a>.</td>
</tr>
<tr>
<td><label>Megnevezés: </label></td>
<td><input type="text" name="name"></td>
<td><label>Pl.: Évközi 3. vasárnap</label></td>
</tr>
<tr>
<td><label>Hely: </label></td>
<td>
	<!--TODO elég legyen a templomot kiválasztani-->
	<select name="telepules" required>
		<option value="semmi">--Válasszon települést!--</option>
		<?php
		$sql = "SELECT * FROM `telepulesek`";
		$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
		while ($row = mysqli_fetch_array($eredmeny))
		{
			$tlid = $row["id"];
			$tlname = $row["name"];
			?>
			<option value="<?php echo $tlid; ?>"><?php echo $tlname; ?></option>
			<?php
		}
		?>
	</select>
	<select name="templom" required>
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
			<option value="<?php echo $tlid; ?>"><?php echo $tname; ?> - <?php echo $tlname; ?></option>
			<?php
		}
		?>
		<option value="egyeb" onclick="document.getElementsByName('egyebtemplom').style.display = 'inline';">egyéb: </option>
	</select>
	<input type="text" name="egyebtemplom">
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
				<option value="<?php echo $cid; ?>"><?php echo $cname; ?></option>
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
				<option value="<?php echo $kid; ?>"><?php echo $kname; ?></option>
				<?php
			}
			?>
		</select>
	</td>
</tr>
<tr>
	<td><label>Típus: </label></td>
	<td><input type="radio" name="type" value="0">Csendes</input><input type="radio" name="type" value="1">Orgonás</input><input type="radio" name="type" value="2">Ünnepi</input></td>
</tr>
<tr>
	<td>
		<label>Szándék: </label>
	</td>
	<td><input type="radio" name="szandekvan" value="2">Erre a liturgiára ne lehessen szándékot választani</input><input type="radio" name="szandekvan" value="0" onclick="document.getElementsByName('szandek').disabled = false;">Nincs</input><input type="radio" name="szandekvan" value="1" onclick="document.getElementsByName('szandek').disabled = false;">Van: </input>
	<select name="szandekbevitt">
		<option value="0">--Kérem válasszon!--</option>
		<option value="1">újat adok meg:</option>
		<?php
			$sql = "SELECT `id`, `szandek`, `kikerte`, `mikorra` FROM `szandekok` WHERE `id` > 2";
			$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
			while ($row = mysqli_fetch_array($eredmeny))
			{
				$szandekid = $row["id"];
				$szandekname = $row["szandek"];
				$szandekwho = $row["kikerte"];
				$szandekmikorra = $row["mikorra"];
				?>
				<option value="<?php echo $szandekid; ?>"><?php echo $szandekname; ?> - <?php echo $szandekwho; ?> <?php if ($szandekmikorra != null) { ?>- <?php } echo $szandekmikorra; ?></option>
				<?php
			}
		?>
	</select>
	<input type="text" name="szandek" ></td>
</tr>
<tr>
	<td><label>Publikus: </label></td>
	<td><input type="radio" name="pub" value="0">Nem</input><input type="radio" name="pub" value="1" checked>Igen</input></td>
	<td>Ezt akkor kellhet átváltani "Nem"-re, ha például egy gyászmise van, vagy egy olyan szertartás mely "zárt körű", tehát az egyházközség nincs rá "meghívva". A "Nem" opció választásával a weboldalon csak azoknak jelenik meg a szertartás, akik bejelentkeztek.</td>
</tr>
<tr>
	<td><label>Megjegyzés azoknak, akik be tudnak jelentkezni: </label></td>
	<td><textarea name="megjegyzes"></textarea></td>
</tr>
<tr>
	<td><label>Publikus megjegyzés, melyet mindenki lát, aki megnézi a weboldalt: </label></td>
	<td><textarea name="pubmegj"></textarea></td>
</tr>
<tr>
<td><label>Stílus: </label></td>
<td><input type="color" name="color" value="#000000"><input type="checkbox" name="bold" value="font-weight: bold;"><b>Félkövér</b></input><input type="checkbox" name="italic" value="font-style: italic;"><i>Dőlt</i></input><input type="checkbox" name="underline" value="text-decoration: underline;"><span style="text-decoration: underline;">Aláhúzás</span></input></td>
<td><label>Nem kötelező, de meg lehet itt adni, hogyan nézzen ki, hogyan jelenjen meg a weboldalon ez a szertartás. Nagy ünnepeket érdemes pirossal jelölni például.</label></td>
</tr>
<tr>
<td><label></label></td>
<td><input type="submit" value="Hozzáadás"></td>
<td><label></label></td>
</tr>
</table>
</form>
<h2 id="rendszeresmise">Rendszeres liturgia hozzáadása</h2>
<p>Az alábbi adatokat csak akkor adjuk meg, ha vonatkozik az összes liturgiára (kivéve dátum és publikálás)!</p>
<form name="create-rendszeres-szertartas" action="create.rendszeres.szertartas.php" method="post">
<table class="form">
<tr>
<td><label>Kezdő időpont: </label></td>
<td><input type="datetime-local" name="startdate"></td>
<td><label>Az első liturgia időpontja. Pl. ha minden vasárnap reggel szeretnénk egy szentmisét a hónapban, akkor 2022.06.05. 08:00 legyen!</label></td>
</tr>
<tr>
	<td><label>Mikor: </label></td>
	<td>
		<input type="number" name="gyak" value=0>
		   vagy   
		<select name="nap">
			<option value="0" selected>A gyakoriságot adom meg (számválasztó)!</option>
			<option value="Mon">Hétfő</option>
			<option value="Tue">Kedd</option>
			<option value="Wed">Szerda</option>
			<option value="Thu">Csütörtök</option>
			<option value="Fri">Péntek</option>
			<option value="Sat">Szombat</option>
			<option value="Sun">Vasárnap</option>
		</select>
	</td>
	<td>Ha a napot (legördülő menü) adjuk meg és nem a gyakoriságot(szám), akkor a számválasztó legyen 0!</td>
</tr>
<tr>
<td><label>Záró időpont: </label></td>
<td><input type="datetime-local" name="enddate"></td>
<td><label>Az utolsó liturgia időpontja. Pl. ha minden vasárnap reggel szeretnénk egy szentmisét a hónapban, akkor 2022.06.26. 08:00 legyen!</label></td>
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
				<option value="<?php echo $szid; ?>"><?php echo $szname; ?></option>
				<?php
			}
			?>
		</select>
	</td>
	<td>Ha nem találja az adott liturgikus formát (pl.: szentmise vagy szentségimádás; ajánlatos megkülönböztetni a szentmisét és a gyászmisét) akkor kérem, kattintson <a href="create.sznev.php">ide</a>.</td>
</tr>
<tr>
<td><label>Megnevezés: </label></td>
<td><input type="text" name="name"></td>
<td><label></label></td>
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
			<option value="<?php echo $tlid; ?>"><?php echo $tlname; ?></option>
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
			<option value="<?php echo $tlid; ?>"><?php echo $tname; ?> - <?php echo $tlname; ?></option>
			<?php
		}
		?>
		<option value="egyeb" onclick="document.getElementsByName('egyebtemplom').style.display = 'inline';">egyéb: </option>
	</select>
	<input type="text" name="egyebtemplom">
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
				<option value="<?php echo $cid; ?>"><?php echo $cname; ?></option>
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
				<option value="<?php echo $kid; ?>"><?php echo $kname; ?></option>
				<?php
			}
			?>
		</select>
	</td>
</tr>
<tr>
	<td><label>Típus: </label></td>
	<td><input type="radio" name="type" value="0">Csendes</input><input type="radio" name="type" value="1">Orgonás</input><input type="radio" name="type" value="2">Ünnepi</input></td>
</tr>
<tr>
	<td>
		<label>Szándék: </label>
	</td>
	<td><input type="radio" name="szandekvan" value="0" onclick="document.getElementsByName('szandek').disabled = false;">Nincs</input><input type="radio" name="szandekvan" value="1" onclick="document.getElementsByName('szandek').disabled = false;">Van: </input><input type="text" name="szandek" ></td>
</tr>
<tr>
	<td><label>Publikus: </label></td>
	<td><input type="radio" name="pub" value="0">Nem</input><input type="radio" name="pub" value="1" checked>Igen</input></td>
	<td>Ezt akkor kellhet átváltani "Nem"-re, ha például egy gyászmise van, vagy egy olyan szertartás mely "zárt körű", tehát az egyházközség nincs rá "meghívva". A "Nem" opció választásával a weboldalon csak azoknak jelenik meg a szertartás, akik bejelentkeztek.</td>
</tr>
<tr>
	<td><label>Megjegyzés azoknak, akik be tudnak jelentkezni: </label></td>
	<td><textarea name="megjegyzes"></textarea></td>
</tr>
<tr>
	<td><label>Publikus megjegyzés, melyet mindenki lát, aki megnézi a weboldalt: </label></td>
	<td><textarea name="pubmegj"></textarea></td>
</tr>
<tr>
<td><label>Stílus: </label></td>
<td><input type="color" name="color" value="#000000"><input type="checkbox" name="bold" value="font-weight: bold;"><b>Félkövér</b></input><input type="checkbox" name="italic" value="font-style: italic;"><i>Dőlt</i></input><input type="checkbox" name="underline" value="text-decoration: underline;"><span style="text-decoration: underline;">Aláhúzás</span></input></td>
<td><label>Nem kötelező, de meg lehet itt adni, hogyan nézzen ki, hogyan jelenjen meg a weboldalon ez a szertartás. Nagy ünnepeket érdemes pirossal jelölni például.</label></td>
</tr>
<tr>
<td><label></label></td>
<td><input type="submit" value="Hozzáadás"></td>
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