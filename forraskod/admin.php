<html>
<head>
<?php include("head.php"); ?>
<title>Adminisztrációs felület - <?php echo $sitename; ?></title>
<meta name="language" content="hu-HU">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<?php
if (!isset($_SESSION["userId"]))
{
	header("Location: login.php?messagetype=note&message=A tartalom megtekintéséhez be kell jelentkezni!");
}
?>
<style>
header nav a[href="http://<?php echo $_SERVER['HTTP_HOST']; echo htmlspecialchars($_SERVER['PHP_SELF']);?>"], nav a[href="http://<?php echo $_SERVER['HTTP_HOST']; echo htmlspecialchars($_SERVER['PHP_SELF']);?>"] {font-weight: bold;}
div.fejlecparallax {
	background-image: url("<?php getheadimage($mysql); ?>");
}
</style>
</head>
<body>
<header>
<div class="head">
<!--<img class="head" src="fejlec.jpg" style="width: 100%;">-->
<!--<img class="head" src="fejlecvekony.jpg" style="width: 100%;">-->
<div class="fejlecparallax">
<div class="head-text">
<h1><?php echo $sitename; ?> honlapja - Adminisztrációs oldal</h1>
</div>
</div>
<hr>
<nav>
<?php include("navbar.php");
include("headforadmin.php");
?>
</nav>
<hr>
</header>
<div class="content">
<div class="tartalom">
<div class="welcome-admin">
<h2>Dicsértessék a Jézus Krisztus!</h2>
<h4>Üdvözlöm Önt, <?php echo $_SESSION["name"];?>, itt az adminisztrációs felületen!</h4>
<p>Ezen az oldalon kezelheti a weboldal tartalmát.</p>
<div class="admin-nav">
<nav>
<ul>
<li><a href="admin.php">Adminisztráció</a></li>
<li><a href="form.create.post.php">Blogbejegyzés létrehozása</a></li>
<li><a href="form.create.szertartas.php">Liturgia hozzáadása</a></li>
<li><a href="miserend.php">Liturgia törlése</a></li>
<li><a href="create.hirdetes.php">Hirdetés létrehozása</a></li>
<li><a href="delete.hirdetes.php">Hirdetés törlése</a></li>
<!--<li><a href="form.edit.content.php">Állandó tartalom módosítása</a></li>-->
<li><a href="create.sznev.php">Liturgia típus létrehozása</a></li>
<li><a href="create.telepules.php">Település létrehozása</a></li>
<li><a href="create.templom.php">Templom létrehozása</a></li>
<?php if ($_SESSION["szint"] == 10) {?>
<li><a href="form.create.user.php">Felhasználó létrehozása</a></li>
<li><a href="form.delete.user.php">Felhasználó törlése</a></li>
<li><a href="form.settings.php">Beállítások</a></li>
<?php } ?>
<li><a href="modify.password.php">Jelszó módosítása</a></li>
<li><a href="logout.php">Kijelentkezés</a></li>
</ul>
</nav>
</div>
</div>
<?php
if ($_SESSION["egyhszint"] > 0)
{
	?>
	<div class="szertartasaim">
	<h4>Szertartásaim:</h4>
	<table>
	<tr>
	<th>Időpont</th>
	<th>Megnevezés</th>
	<th>Hely</th>
	<th>Típus</th>
	<?php if ($_SESSION["egyhszint"] != 2) { ?>
	<th>Pap</th> <?php }
	if ($_SESSION["egyhszint"] != 1) { ?>
	<th>Kántor</th> <?php } ?>
	<th>Szándék</th>
	<th>Megjegyzés</th>
	<th id="utolso">Privát megjegyzés</th>
	</tr>
	<?php
	if ($_SESSION["egyhszint"] == 2)
	{
		$sql = "SELECT * FROM `szertartasok` WHERE `celebransID` = '".$_SESSION["userId"]."' ORDER BY `date`";
	} else if ($_SESSION["egyhszint"] == 1) {
		$sql = "SELECT * FROM `szertartasok` WHERE `kantorID` = '".$_SESSION["userId"]."' ORDER BY `date`";
	}
	$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
	while ($row = mysqli_fetch_array($eredmeny))
	{
		$date = $row["date"];
		$da = substr($date, 0, 16);
		$d = str_replace("-", ". ", $da);
		$namea = $row["name"];
		$nameid = $row["nameID"];
		$nameida = null;
		$sqlz = "SELECT `name` FROM `sznev` WHERE `id` = '".$nameid."'";
			$eredmenyz = mysqli_query($mysql, $sqlz) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
			while ($rowz = mysqli_fetch_array($eredmenyz))
			{
				$nameida = $rowz["name"];
			}
		$name = $nameida;
		if ($namea != null)
		{
			$name .= " - ";
			$name .= $namea;
		}
		$telepules = $row["telepulesID"];
		$templom = $row["templomID"];
		$style = $row["style"];
		$place = $row["place"];
		$cel = $row["celebransID"];
		$kant = $row["kantorID"];
		$type = $row["tipus"];
		$szandek = $row["szandek"];
		$pub = $row["publikus"];
		$pubmegj = $row["pubmegj"];
			$megj = $row["megjegyzes"];
		$regex = "/^[^\<\>\{\}\']*$/";
		if (!preg_match($regex, $style))
		{
		$style = null;
		}
		$id = $row["id"];
		?>
		<tr onclick="window.location.replace('miserend.php#<?php echo $id; ?>');"<?php if ($style != null) { ?> style="<?php echo $style; ?>" <?php } ?>>
		<td><?php echo $d;?></td>
		<td><?php echo $name;?></td>
		<td>
			<?php
			$tname = null;
			$sqla = "SELECT `name` FROM `telepulesek` WHERE `id` = '".$telepules."'";
			$eredmenya = mysqli_query($mysql, $sqla) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
			while ($rowa = mysqli_fetch_array($eredmenya))
			{
				$tname = $rowa["name"];
			}
			if ($tname != null)
			{
				echo $tname;
			}
			if ($templom != null || $place != null) {
			?> - 
			<?php
			$tpname = null;
			$sqlb = "SELECT `name` FROM `templomok` WHERE `id` = '".$templom."'";
			$eredmenyb = mysqli_query($mysql, $sqlb) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
			while ($rowb = mysqli_fetch_array($eredmenyb))
			{
				$tpname = $rowb["name"];
			}
			if ($tpname != null && $templom != null)
			{
				echo $tpname;
			}
			if ($templom == null) {
				echo $place;
			} }
			?>
		</td>
		<td><?php if ($type != null) { echo $szertartasoktypeid[$type]; } ?></td>
		<?php
		if ($_SESSION["egyhszint"] != 2)
		{
			?>
			<td>
				<?php
				if ($cel != null) {
				$sqlc = "SELECT `name` FROM `author` WHERE `id` = '".$cel."'";
				$eredmenyc = mysqli_query($mysql, $sqlc) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
				while ($rowc = mysqli_fetch_array($eredmenyc))
				{
					$cname = $rowc["name"];
					if ($cname != null)
					{
						echo $cname;
					}
				} }
				?>
			</td>
		<?php
		}
		if ($_SESSION["egyhszint"] != 1)
		{
			?>
			<td>
			<?php
			if ($kant != null) {
			$sqld = "SELECT `name` FROM `author` WHERE `id` = '".$kant."'";
			$eredmenyd = mysqli_query($mysql, $sqld) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
			while ($rowd = mysqli_fetch_array($eredmenyd))
			{
				$kname = $rowd["name"];
				if ($kname != null)
				{
					echo $kname;
				}
			}
		}
			?>
			</td>
			<?php
		}
		?>
		<td>
		<?php
			if ($szandek == null)
			{
				?>
				<?php
			}
			 else if ($szandek == 0)
			{
				?>
				-
				<?php
			} else if ($szandek == 2)
			{
				?>
				Nem lesz
				<?php
			} else if ($szandek == 1)
			{
				?>
				Van
				<?php
			} else {
				$sqlsz = "SELECT `szandek`, `kikerte` FROM `szandekok` WHERE `id` = '".$szandek."'";
				$eredmenysz = mysqli_query($mysql, $sqlsz) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
				while ($rowsz = mysqli_fetch_array($eredmenysz))
				{
					$kname = $rowsz["szandek"];
					if ($kname != null)
					{
						echo $kname;
					}
					echo " - ";
					$szkikerte = $rowsz["kikerte"];
					if ($szkikerte != null)
					{
						echo $szkikerte;
					}
				}
			}
			?>
		</td>
		<td><?php echo $pubmegj; ?></td>
		<td id="utolso"><?php echo $megj; ?></td>
		</tr>
		<?php
	}
	?>
		</table>
		<h4>Liturgiák, melyeknél még nincs <?php if ($_SESSION["egyhszint"] == 2) { ?>celebráns<?php } else if ($_SESSION["egyhszint"] == 1) { ?>kántor<?php } ?> megjelölve:</h4>
	<table>
	<tr>
	<th>Időpont</th>
	<th>Megnevezés</th>
	<th>Hely</th>
	<th>Típus</th>
	<?php if ($_SESSION["egyhszint"] != 2) { ?>
	<th>Pap</th> <?php }
	if ($_SESSION["egyhszint"] != 1) { ?>
	<th>Kántor</th> <?php } ?>
	<th>Szándék</th>
	<th>Megjegyzés</th>
	<th>Privát megjegyzés</th>
	<th id="utolso">Kezelés*</th>
	</tr>
	<?php
	if ($_SESSION["egyhszint"] == 2)
	{
		$sql = "SELECT * FROM `szertartasok` WHERE `celebransID` IS NULL ORDER BY `date`";
	} else if ($_SESSION["egyhszint"] == 1) {
		$sql = "SELECT * FROM `szertartasok` WHERE `kantorID` IS NULL ORDER BY `date`";
	}
	$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
	while ($row = mysqli_fetch_array($eredmeny))
	{
		$date = $row["date"];
		$da = substr($date, 0, 16);
		$d = str_replace("-", ". ", $da);
		$namea = $row["name"];
		$nameid = $row["nameID"];
		$nameida = null;
		$sqlz = "SELECT `name` FROM `sznev` WHERE `id` = '".$nameid."'";
			$eredmenyz = mysqli_query($mysql, $sqlz) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
			while ($rowz = mysqli_fetch_array($eredmenyz))
			{
				$nameida = $rowz["name"];
			}
		$name = $nameida;
		if ($namea != null)
		{
			$name .= " - ";
			$name .= $namea;
		}
		$telepules = $row["telepulesID"];
		$templom = $row["templomID"];
		$style = $row["style"];
		$place = $row["place"];
		$cel = $row["celebransID"]; if (is_null($row["celebransID"])) {$cel = null;}
		$kant = $row["kantorID"]; if (is_null($row["kantorID"])) {$kant = null;}
		$type = $row["tipus"];
		$szandek = $row["szandek"];
		$pub = $row["publikus"];
		$pubmegj = $row["pubmegj"];
			$megj = $row["megjegyzes"];
		$regex = "/^[^\<\>\{\}\']*$/";
		if (!preg_match($regex, $style))
		{
		$style = null;
		}
		$id = $row["id"];
		?>
		<tr onclick="window.location.replace('miserend.php#<?php echo $id; ?>');"<?php if ($style != null) { ?> style="<?php echo $style; ?>" <?php } ?>>
		<td><?php echo $d;?></td>
		<td><?php echo $name;?></td>
		<td>
			<?php
			$tname = null;
			$sqla = "SELECT `name` FROM `telepulesek` WHERE `id` = '".$telepules."'";
			$eredmenya = mysqli_query($mysql, $sqla) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
			while ($rowa = mysqli_fetch_array($eredmenya))
			{
				$tname = $rowa["name"];
			}
			if ($tname != null)
			{
				echo $tname;
			}
			if ($templom != null || $place != null) {
			?> - 
			<?php
			$tpname = null;
			$sqlb = "SELECT `name` FROM `templomok` WHERE `id` = '".$templom."'";
			$eredmenyb = mysqli_query($mysql, $sqlb) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
			while ($rowb = mysqli_fetch_array($eredmenyb))
			{
				$tpname = $rowb["name"];
			}
			if ($tpname != null && $templom != null)
			{
				echo $tpname;
			}
			if ($templom == null) {
				echo $place;
			} }
			?>
		</td>
		<td><?php if ($type != null) { echo $szertartasoktypeid[$type]; } ?></td>
		<?php
		if ($_SESSION["egyhszint"] != 2)
		{
			?>
			<td>
				<?php
				if ($cel != null) {
				$sqlc = "SELECT `name` FROM `author` WHERE `id` = '".$cel."'";
				$eredmenyc = mysqli_query($mysql, $sqlc) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
				while ($rowc = mysqli_fetch_array($eredmenyc))
				{
					$cname = $rowc["name"];
					if ($cname != null)
					{
						echo $cname;
					}
				} }
				?>
			</td>
		<?php
		}
		if ($_SESSION["egyhszint"] != 1)
		{
			?>
			<td>
			<?php
			if ($kant != null) {
			$sqld = "SELECT `name` FROM `author` WHERE `id` = '".$kant."'";
			$eredmenyd = mysqli_query($mysql, $sqld) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
			while ($rowd = mysqli_fetch_array($eredmenyd))
			{
				$kname = $rowd["name"];
				if ($kname != null)
				{
					echo $kname;
				}
			} }
			?>
			</td>
			<?php
		}
		?>
		<td>
			<?php
			if ($szandek == null)
			{
				?>
				<?php
			}
			 else if ($szandek == 0)
			{
				?>
				-
				<?php
			} else if ($szandek == 2)
			{
				?>
				Nem lesz
				<?php
			} else if ($szandek == 1)
			{
				?>
				Van
				<?php
			} else {
				$sqlsz = "SELECT `szandek`, `kikerte` FROM `szandekok` WHERE `id` = '".$szandek."'";
				$eredmenysz = mysqli_query($mysql, $sqlsz) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
				while ($rowsz = mysqli_fetch_array($eredmenysz))
				{
					$kname = $rowsz["szandek"];
					if ($kname != null)
					{
						echo $kname;
					}
					echo " - ";
					$szkikerte = $rowsz["kikerte"];
					if ($szkikerte != null)
					{
						echo $szkikerte;
					}
				}
			}
			?>
		</td>
		<td><?php echo $pubmegj; ?></td>
		<td><?php echo $megj; ?></td>
		
			<td id="utolso">
				<form action="attachtome.php" method="post">
					<input type="hidden" name="miseid" value="<?php echo $id; ?>">
					<input type="hidden" name="userid" value="<?php echo $_SESSION["userId"]; ?>">
					<input type="submit" value="Hozzámrendelés">
				</form>
			</td>
			</tr>
		<?php
	}
	?>
		</table>
	</div>
	<p>*A "Hozzámrendelés" gomb megnyomásával vállalom a szertartás <?php if ($_SESSION["egyhszint"] == 2) { ?>celebránsi<?php } else if ($_SESSION["egyhszint"] == 1) { ?>kántori<?php } ?> szolgálatát.</p>
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