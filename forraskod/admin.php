<?php ob_start(); ?>
<!DOCTYPE html>
<html>
<head>
<?php include("head.php"); ?>
<title>Adminisztrációs felület - <?php echo $sitename; ?></title>
<meta name="language" content="hu-HU">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php
//TODO sekrestyés beosztás kezelése
if (!isset($_SESSION["userId"]))
{
	header("Location: login.php?messagetype=note&message=A tartalom megtekintéséhez be kell jelentkezni!");
}
//FIXME csak bejelentkezés engedélynél nem jelenik meg semmi, nincs a bodyban semmi
?>
<style>
.templomcolor {
	aspect-ratio: 1 / 1;
	height: 0.7em;
	display: inline-block;
	border-radius: 1em;
	margin-right: 0.25em;
	margin-left: 0.5em;
	background-color: #e1b137;
}
</style>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.4/index.global.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.4/locales-all.global.min.js'></script>
<?php
// TODO lehessen váltani a hagyományos és a naptár nézet között
// TODO php-ból kiadni a szentmiséket a JS-nek
// TODO be lehessen állítani templomoknak színeket
?>
<script>
	<?php if ($_SESSION["egyhszint"] > 0) { ?>
	var calendar = null;
      document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('hetemcalendar');
        calendar = new FullCalendar.Calendar(calendarEl, {
		  nowIndicator: true,
          initialView: 'timeGridWeek',
		  themeSystem: 'bootstrap5',
		  locale: 'hu',
		  headerToolbar: {
			start: 'title',
			center: 'today prev,next',
			end: 'timeGridWeek,timeGridDay',
		  },
		  eventClick: function(info) {
			showmise(info.event.id);
		  }
        });
		<?php
		$sql = "SELECT `id`, `date`, `nameID`, `name`, `templomID` FROM `szertartasok` WHERE `";
		if ($_SESSION["egyhszint"] == 2) {
			$sql .= "celebransID";
		} else if ($_SESSION["egyhszint"] == 1) {
			$sql .= "kantorID";
		}
		$sql .= "` = '".$_SESSION["userId"]."' AND `elmarad` = 0";
		$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
		while ($row = mysqli_fetch_array($eredmeny)) {
			$asql = "SELECT `name` FROM `sznev` WHERE `id` = '".$row["nameID"]."'";
			$eredmenya = mysqli_query($mysql, $asql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
			$rowa = mysqli_fetch_array($eredmenya);
			$asql = "SELECT `color` FROM `templomok` WHERE `id` = '".$row["templomID"]."'";
			$eredmenya = mysqli_query($mysql, $asql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
			$rowb = mysqli_fetch_array($eredmenya);
			?>
			calendar.addEvent({
				id: '<?php echo $row["id"]; ?>',
      			title: '<?php echo $rowa["name"]; ?><?php if ($row["name"] != null) { echo " - "; echo $row["name"]; } ?>',
	  			color: '<?php if ($rowb["color"] != null) { echo $rowb["color"]; } else { echo "#e1b137"; } ?>',
	  			allDay: false,
      			start: '<?php echo $row["date"]; ?>'
    		});
			<?php
		}
		?>
        calendar.render();
      }); <?php } ?>
	  function showmise(id) {
		if (document.querySelector(".highlighted") != null) {
		document.querySelector(".highlighted").classList.remove("highlighted"); }
		document.getElementById(id).scrollIntoView();
		document.getElementById(id).classList.add("highlighted");
	  }
	//   function togglejelmagyarazat() {
	// 	if (document.querySelector('#jelmagyarazat').style.display == 'inline') {
	// 		document.querySelector('#jelmagyarazat').style.display = 'none';
	// 		document.querySelector('#jelmagyarazaticon').classList.remove("bi-caret-down-fill");
	// 		document.querySelector('#jelmagyarazaticon').classList.add("bi-caret-right-fill");
	// 	} else {
	// 		document.querySelector('#jelmagyarazat').style.display = 'inline';
	// 		document.querySelector('#jelmagyarazaticon').classList.remove("bi-caret-right-fill");
	// 		document.querySelector('#jelmagyarazaticon').classList.add("bi-caret-down-fill");
	// 	}
	//   }
    </script>
</head>
<body class="d-flex flex-column h-100">
<?php displayhead("Adminisztráció", null, null, "<h3 style='padding-top: 30px; font-variant: small-caps;'>Dicsértessék a Jézus Krisztus!</h3><h4>Üdvözlöm Önt, ".$_SESSION["name"].", itt az adminisztrációs felületen!</h4>");
include("headforadmin.php");
?>
<div id="messagesdiv">
	<?php
	Message::displayall();
	?>
</div>
<main class="content container">
<div class="tartalom">
<div class="welcome-admin">
<div class="admin-nav">
<nav>
<ul>
<li><a href="admin.php">Adminisztráció</a></li>
<?php if (checkpermission("addpost")) {echo "<li><a href='create.post.php'>Blogbejegyzés létrehozása</a></li>";} ?>
<?php if (checkpermission("addliturgia")) {echo '<li><a href="create.szertartas.php">Liturgia hozzáadása</a></li>';} ?>
<?php if (checkpermission("removeliturgia")) {echo '<li><a href="miserend.php">Liturgia törlése</a></li>'; } ?>
<?php if (checkpermission("addhirdetes")) {echo '<li><a href="create.hirdetes.php">Hirdetés létrehozása</a></li>'; } ?>
<?php if (checkpermission("removehirdetes")) {echo '<li><a href="delete.hirdetes.php">Hirdetés törlése</a></li>'; } ?>
<!--<li><a href="form.edit.content.php">Állandó tartalom módosítása</a></li>-->
<?php if (checkpermission("addsznev")) { echo '<li><a href="create.sznev.php">Liturgia típus létrehozása</a></li>'; } ?>
<?php if (checkpermission("addtelepules")) {echo'<li><a href="create.telepules.php">Település létrehozása</a></li>';}?>
<?php if (checkpermission("addtemplom")) {echo'<li><a href="create.templom.php">Templom létrehozása</a></li>';}?>
<?php if(checkpermission("adduser")) {echo'<li><a href="create.user.php">Felhasználó létrehozása</a></li>';}?>
<?php if(checkpermission("removeuser")){echo'<li><a href="delete.user.php">Felhasználó törlése</a></li>';}?>
<?php if(checkpermission("addpage")){echo'<li><a href="create.page.php">Oldal hozzáadása</a></li>';}?>
<?php if(checkpermission("editsettings")){echo'<li><a href="settings.php">Beállítások</a></li>';}?>
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
	<div class="row">
	<div id="hetem" class="col-sm-6">
		<h2>A hetem</h2>
		<div id="hetemcalendar"></div>
	</div>
	<div class="szertartasaim col-sm-6">
	<h2>Szertartásaim:</h2>
	<div class="table-responsive">
	<table class="table table-sm table-hover">
		<thead>
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
	</thead>
	<tbody style="cursor: pointer;">
	<?php
	$warning = getsetting("mise.warning");
	if ($warning == null) {
		$warning = 25;
	}
	$warning2 = getsetting("mise.warning2");
	if ($warning2 == null) {
		$warning2 = 4;
	}
	if ($_SESSION["egyhszint"] == 2)
	{
		$sql = "SELECT * FROM `szertartasok` WHERE `celebransID` = '".$_SESSION["userId"]."' ORDER BY `date`";
	} else if ($_SESSION["egyhszint"] == 1) {
		$sql = "SELECT * FROM `szertartasok` WHERE `kantorID` = '".$_SESSION["userId"]."' ORDER BY `date`";
	}
	$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
	while ($row = mysqli_fetch_array($eredmeny))
	{
		$date = date_create($row["date"]);
		$d = date_format($date, "Y. m. d. H:i");
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
			$elmarad = $row["elmarad"];
		$regex = "/^[^\<\>\{\}\']*$/";
		if ($style != null) {
		if (!preg_match($regex, $style))
		{
		$style = null;
		} }
		$id = $row["id"];
		$orak = abs($date->getTimestamp() - time()) / (60*60);
		?>
		<tr id="<?php echo $id; ?>" onclick="window.location.replace('miserend.php#<?php echo $id; ?>');"<?php if ($style != null && $elmarad != 1) { ?> style="<?php echo $style; ?>" <?php } if ($elmarad == 1) { ?>style="background-color: #ffebc5; color: #999; text-decoration: line-through;"<?php }?> <?php if ($orak < $warning2) { ?>class="table-danger"<?php } else if ($orak < $warning) { ?>class="table-warning"<?php } ?>>
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
		if ($elmarad == 1) {
			?>
			<tr>
				<td colspan="8" style="background-color: #ffebc5;"><i class="bi bi-exclamation-triangle" style="color: #ffa700;"></i> Figyelem! Ez a liturgia elmarad!</td>
			</tr>
			<?php
		}
		?>
		<?php
	}
	?>
	</tbody>
		</table>
	</div>
</div>
		<h2>Liturgiák, melyeknél még nincs <?php if ($_SESSION["egyhszint"] == 2) { ?>celebráns<?php } else if ($_SESSION["egyhszint"] == 1) { ?>kántor<?php } ?> megjelölve:</h2>
	<div class="table-responsive">
	<table class="table table-hover table-sm">
		<thead>
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
	<?php if (checkpermission("editliturgia")) { ?><th id="utolso">Kezelés*</th><?php } ?>
	</tr>
		</thead>
		<tbody style="cursor: pointer;">
	<?php
	if ($_SESSION["egyhszint"] == 2)
	{
		$sql = "SELECT * FROM `szertartasok` WHERE `celebransID` IS NULL AND `elmarad` = 0 ORDER BY `date`";
	} else if ($_SESSION["egyhszint"] == 1) {
		$sql = "SELECT * FROM `szertartasok` WHERE `kantorID` IS NULL AND `elmarad` = 0 ORDER BY `date`";
	}
	$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
	while ($row = mysqli_fetch_array($eredmeny))
	{
		$date = date_create($row["date"]);
		$d = date_format($date, "Y. m. d. H:i");
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
		if ($style != null) {
		if (!preg_match($regex, $style))
		{
		$style = null;
		} }
		$id = $row["id"];
		$id = $row["id"];
		$orak = abs($date->getTimestamp() - time()) / (60*60)
		?>
		<tr onclick="window.location.replace('miserend.php#<?php echo $id; ?>');"<?php if ($style != null) { ?> style="<?php echo $style; ?>" <?php } if ($orak < $warning2) { ?>class="table-danger"<?php } else if ($orak < $warning) { ?>class="table-warning"<?php } ?>>
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
			<?php if (checkpermission("editliturgia")) { ?>
			<td id="utolso">
				<form action="attachtome.php" method="post">
					<input type="hidden" name="miseid" value="<?php echo $id; ?>">
					<input type="hidden" name="userid" value="<?php echo $_SESSION["userId"]; ?>">
					<button class="btn btn-primary text-white" type="submit" title="Ezen gomb megnyomásával vállalom a liturgia <?php if ($_SESSION["egyhszint"] == 2) { echo "celebránsi"; } else if ($_SESSION["egyhszint"] == 1) { echo "kántori"; } ?> szolgálatát."><i class="bi bi-plus-lg"></i> Hozzámrendelés</button>
				</form>
			</td>
				<?php } ?>
			</tr>
		<?php
	}
	?>
		</tbody>
		</table>
	</div>
	</div>
	<p>*A "Hozzámrendelés" gomb megnyomásával vállalom a szertartás <?php if ($_SESSION["egyhszint"] == 2) { ?>celebránsi<?php } else if ($_SESSION["egyhszint"] == 1) { ?>kántori<?php } ?> szolgálatát.</p>
		<?php
}
?>
</div>
</main>
<?php include("footer.php"); ?>
</body>
</html>
