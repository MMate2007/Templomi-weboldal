<?php ob_start(); ?>
<!DOCTYPE html>
<html>
<head>
<?php include("head.php");
$tel = null;
$temp = null;
if (isset($_POST["tel"])) 
{
	$tel = $_POST["tel"];
	if ($tel == "mind")
	{
		$tel = null;
	}
}
if (isset($_POST["temp"]))
{
	$temp = $_POST["temp"];
	if ($temp == "mind")
	{
		$temp = null;
	}
}
?>
<title>Liturgiák rendje - <?php echo $sitename; ?></title>
<meta name="title" content="Liturgiák rendje - <?php echo $sitename; ?>">
<meta name="description" content="Ezen az oldalon megtalálhatja, hogy mikor tartanak szentmiséket borszörcsöki Szent Anna és Szent Joachim templomban és a Jézus Szíve és Szűz Mária Szíve kápolnában.">
<meta name="language" content="hu-HU">
<meta name="keywords" content="borszörcsöki templom mise, mise, szentmise, borszörcsöki templom szentmise, Borszörcsök mise, borszörcsök mise, <?php echo $sitename; ?>, <?php echo $sitename; ?>, <?php echo $sitename; ?> mise, <?php echo $sitename; ?> szentmise">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
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
	var calendar = null;
      document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendarbox');
        calendar = new FullCalendar.Calendar(calendarEl, {
		  nowIndicator: true,
          initialView: 'dayGridMonth',
		  themeSystem: 'bootstrap5',
		  locale: 'hu',
		  headerToolbar: {
			start: 'title',
			center: 'today prev,next',
			end: 'multiMonthYear,dayGridMonth,timeGridWeek,timeGridDay',
		  },
		  eventClick: function(info) {
			showmise(info.event.id);
		  }
        });
		<?php
		$sql = "SELECT `id`, `date`, `nameID`, `name`, `templomID` FROM `szertartasok` WHERE `publikus` = '1' AND `elmarad` = '0'";
		if ($temp != null)
		{
			$sql .= "AND `templomID` = '".$temp."'";
		}
		else if ($tel != null)
		{
			$sql .= "AND `telepulesID` = '".$tel."'";
		}
		$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
		while ($row = mysqli_fetch_array($eredmeny)) {
			$asql = "SELECT `name` FROM `sznev` WHERE `id` = '".$row["nameID"]."'";
			$eredmenya = mysqli_query($mysql, $asql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
			$rowa = mysqli_fetch_array($eredmenya);
			$color = null;
			if ($row["templomID"] === null) {
				$color = null;
			} else {
			$asql = "SELECT `color` FROM `templomok` WHERE `id` = '".$row["templomID"]."'";
			$eredmenya = mysqli_query($mysql, $asql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
			$rowb = mysqli_fetch_array($eredmenya);
			$color = $rowb["color"]; }
			?>
			calendar.addEvent({
				id: '<?php echo $row["id"]; ?>',
      			title: '<?php echo $rowa["name"]; ?><?php if ($row["name"] != null) { echo " - "; echo $row["name"]; } ?>',
	  			color: '<?php if ($color != null) { echo $color; } else { echo "#e1b137"; } ?>',
	  			allDay: false,
      			start: '<?php echo $row["date"]; ?>'
    		});
			<?php
		}
		?>
        calendar.render();
      });
	  function showmise(id) {
		if (document.querySelector(".highlighted") != null) {
		document.querySelector(".highlighted").classList.remove("highlighted"); }
		if (document.querySelector('#list').style.display == 'none') {
			togglelist();
		}
		document.getElementById(id).scrollIntoView();
		document.getElementById(id).classList.add("highlighted");
	  }
	  function togglecalendar() {
		if (document.querySelector('#calendar').style.display != 'none') {
			document.querySelector('#calendar').style.display = "none";
			document.querySelector('#calendargomb').classList.remove('active');
			document.querySelector('#list').classList.remove('col-sm-6');
			calendar.updateSize();
		} else {
			document.querySelector('#calendar').style.display = "block";
			document.querySelector('#calendargomb').classList.add('active');
			document.querySelector('#list').classList.add('col-sm-6');
			calendar.updateSize();
		}
	  }
	  function togglelist() {
		if (document.querySelector('#list').style.display != 'none') {
			document.querySelector('#list').style.display = "none";
			document.querySelector('#listagomb').classList.remove('active');
			document.querySelector('#calendar').classList.remove('col');
			calendar.updateSize();
		} else {
			document.querySelector('#list').style.display = "block";
			document.querySelector('#listagomb').classList.add('active');
			document.querySelector('#calendar').classList.add('col');
			calendar.updateSize();
		}
	  }
	  function togglejelmagyarazat() {
		if (document.querySelector('#jelmagyarazat').style.display == 'inline') {
			document.querySelector('#jelmagyarazat').style.display = 'none';
			document.querySelector('#jelmagyarazaticon').classList.remove("bi-caret-down-fill");
			document.querySelector('#jelmagyarazaticon').classList.add("bi-caret-right-fill");
		} else {
			document.querySelector('#jelmagyarazat').style.display = 'inline';
			document.querySelector('#jelmagyarazaticon').classList.remove("bi-caret-right-fill");
			document.querySelector('#jelmagyarazaticon').classList.add("bi-caret-down-fill");
		}
	  }
	  function deleteliturgia(id) {
		var remove = confirm("Biztosan törölni szeretné ezt a liturgiát?");
		if (remove) {
			document.querySelector("#deleteliturgia"+id).submit();
		}
	  }
    </script>
</head>
<body>
<?php 
displayhead("Liturgiák rendje");
?>
<?php
if (isset($_SESSION["userId"])) {
	?>
	<div id="messagesdiv">
		<?php
		Message::displayall();
		?>
	</div>
	<?php
}
?>
<main class="content mx-auto text-center" style="padding: 30px 30px;">
<?php
$user = false;
if (!isset($_SESSION["userId"]))
{
	$user = false;
} else {
	$user = true;
	$sql = "SELECT `name` FROM `author` WHERE `id` = '".$_SESSION["userId"]."'";
	$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
	while ($row = mysqli_fetch_array($eredmeny))
	{
		$name = $row["name"];
		if ($name != $_SESSION["name"])
		{
			$user = false;
		}
	}
}
if ($user == true) {
	if (checkpermission("addliturgia")) {
		?>
		<div><a class="btn btn-primary text-white float-end" href="create.szertartas.php"><i class="bi bi-plus-lg"></i> Új liturgia létrehozása</a></div>
		<?php
	}
}
?>
<div class="btn-group" role="group">
	<button class="btn btn-primary text-white active" onclick="togglelist()" id="listagomb"><i class="bi bi-card-list"></i> Lista nézet</button>
		<button class="btn btn-primary text-white active" onclick="togglecalendar()" id="calendargomb"><i class="bi bi-calendar-week"></i> Naptár nézet</button>
</div>
<div class="row">
	<div class="miserend col-sm-6" id="list">
	<form name="szuro" action="miserend.php" method="post">
	<p>Település: <select name="tel" class="form-select">
		<option value="mind">Az összes</option>
		<?php
		$sql = "SELECT * FROM `telepulesek`";
		$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
		while ($row = mysqli_fetch_array($eredmeny))
		{
			?>
			<option value="<?php echo $row["id"]; ?>" <?php if ($row["id"] == $tel) { ?> selected <?php } ?>><?php echo $row["name"]; ?></option>
			<?php
		}
		?>
	</select>
	 vagy templom: <select name="temp" class="form-select">
		<option value="mind">Az összes</option>
		<?php
		$sql = "SELECT `id`, `telepulesID`, `name` FROM `templomok`";
		$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
		while ($row = mysqli_fetch_array($eredmeny))
		{
			$telname = null;
			$sqlegy = "SELECT `name` FROM `telepulesek` WHERE id = '".$row["telepulesID"]."'";
			$eredmenyegy = mysqli_query($mysql, $sqlegy) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
			while ($rowegy = mysqli_fetch_array($eredmenyegy))
			{
				$telname = $rowegy["name"];
			}
			?>
			<option value="<?php echo $row["id"]; ?>" <?php if ($row["id"] == $temp) { ?> selected <?php } ?>><?php echo $telname; ?> - <?php echo $row["name"]; ?></option>
			<?php
		}
		?>
	 </select>
	 <!-- TODO ha be van jelentkezve a felhasználó, akkor lehessen szűrni pap és kántor szerint is -->
	 <button type="submit" class="btn btn-primary text-white"><i class="bi bi-funnel"></i> Szűrés</button>
	</p>
	</form>
	<div class="table-responsive">
	<table class="table table-sm">
		<thead>
	<tr>
	<th>Időpont</th>
	<th>Megnevezés</th>
	<th>Hely</th>
	<?php
	// TODO sticky table head
	$thcounter = 3;
	$showCel = getsetting("miserend.showCel");
	$showKant = getsetting("miserend.showKant");
	$showSzandSz = getsetting("miserend.showSzandekSzoveg");
	$showSzM = getsetting("miserend.showSzandekMeglet");
	$showT = getsetting("miserend.showTipus");
		if ($showT == 1 || $user == true) { $thcounter++; ?> <th>Típus</th> <?php }
		if ($showCel == 1 || $user == true) { $thcounter++; ?> <th>Pap</th> <?php }
		if ($showKant == 1 || $user == true) { $thcounter++; ?> <th>Kántor</th> <?php }
		if ($showSzandSz == 1 || $showSzM == 1 || $user == true) { $thcounter++; ?> <th>Szándék</th> <?php }
		?>
		<th>Megjegyzés</th>
		<?php
		$thcounter++;
		if ($user == true)
		{
			?>
			<th>Privát megjegyzés</th>
			<th>Publikus</th>
			<th>Kezelés</th>
			<?php
			$thcounter += 3;
		}
	?>
	</tr>
		</thead>
		<tbody>
	<?php
	if ($user == true) {
		$sql = "SELECT * FROM `szertartasok` ";
		if ($temp != null)
		{
			$sql .= "WHERE `templomID` = '".$temp."'";
		}
		else if ($tel != null)
		{
			$sql .= "WHERE `telepulesID` = '".$tel."'";
		}
		$sql .= " ORDER BY `date`";
	}else{
		$sql = "SELECT `id`, `date`, `nameID`, `name`, `telepulesID`, `templomID`, `place`, `style`, ";
		if ($showCel == 1) { $sql .= "`celebransID`, "; }
		if ($showKant == 1) { $sql .= "`kantorID`, "; }
		if ($showT == 1) { $sql .= "`tipus`, "; }
		if ($showSzandSz == 1 || $showSzM == 1) { $sql .= "`szandek`, "; }
		$sql .= "`publikus`, `pubmegj`, `elmarad` FROM `szertartasok`";
		if ($temp != null)
		{
			$sql .= "WHERE `templomID` = '".$temp."'";
		}
		else if ($tel != null)
		{
			$sql .= "WHERE `telepulesID` = '".$tel."'";
		}
		$sql .= " ORDER BY `date`";
	
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
		$elmarad = $row["elmarad"];
		$place = $row["place"];
		if ($showCel == 1 || $user == true) { $cel = $row["celebransID"]; }
		if ($showKant == 1 || $user == true) { $kant = $row["kantorID"]; }
		if ($showT == 1 || $user == true) { $type = $row["tipus"]; }
		if ($showSzandSz == 1 || $showSzM == 1 || $user == true) { $szandek = $row["szandek"]; }
		$pub = $row["publikus"];
		$pubmegj = $row["pubmegj"];
		$megj = null;
		if ($user == true)
		{
			$megj = $row["megjegyzes"];
		}
		$regex = "/^[^\<\>\{}\']*$/";
		if ($style != null) {
		if (!preg_match($regex, $style))
		{
		$style = null;
		} }
		$id = $row["id"];
		$mehet = false;
		if ($pub == 1)
		{
			$mehet = true;
		}
		if ($user == true)
		{
			$mehet = true;
		}
		if ($mehet == true)
		{
		?>
		<tr id="<?php echo $id; ?>"<?php if ($style != null && $elmarad != 1) { ?> style="<?php echo $style; ?>" <?php } if ($elmarad == 1) { ?>style="background-color: #ffebc5; color: #999; text-decoration: line-through;"<?php }?>>
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
		<?php
		if ($showT == 1 || $user == true) { ?> <td><?php if ($type != null) { echo $szertartasoktypeid[$type]; } else if ($user == true) { ?> ? <?php }?></td> <?php }
		if ($showCel == 1 || $user == true) { ?> <td>
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
				}
			} else if ($user == true) {
				?>
				?
				<?php
			}
			?>
		</td> <?php }
		if ($showKant == 1 || $user == true) { ?> <td>
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
			} else if (($type === null || $type > 0) && $user == true) { echo "?"; } else if ($type == 0) { echo "-"; }
			?>
		</td> <?php }
		if ($showSzandSz == 1 || $showSzM == 1 || $user == true) { ?> <td>
			<?php
				if ($showSzM == 1 && $showSzandSz != 1 && $user != true)
				{	
					
					if ($szandek == "0" || $szandek === null)
					{
						?>
						<input type="checkbox" disabled></input>
						<?php
					} else
					{
						?>
						<input type="checkbox" disabled checked></input>
						<?php
					}
				}
				if ($showSzandSz == 1 || $user == true)
				{
					if ($szandek == null && $user == true)
					{
						?>
						?
						<?php
					}
					else if ($szandek === "1")
					{
						echo "Van";
					} else if ($szandek === "0")
					{
						echo "-";
					}
					else {
						echo $szandek;
					}
				}
			?>
		</td> <?php }
		?>
		<td><?php if ($pubmegj != null) { echo $pubmegj; } ?></td>
		<td><?php if ($megj != null) { echo $megj; } ?></td>
		<?php
		$user = true;
		if (!isset($_SESSION["userId"]))
		{
			$user = false;
		}else if (isset($_SESSION["userId"])) {
		$sql = "SELECT `name` FROM `author` WHERE `id` = '".$_SESSION["userId"]."'";
		$eredmenyegy = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
		while ($rowegy = mysqli_fetch_array($eredmenyegy))
		{
			$nameegy = $rowegy["name"];
			if ($nameegy != $_SESSION["name"])
			{
	
				$user = false;
			}
		}
		}
		if ($user == true)
		{
			?>
			<td><input type="checkbox" name="publikus" disabled <?php
			if ($pub == 1)
			{
				?>
				checked
				<?php
			}
			?>></td>
			<td>
				<?php
				if (checkpermission("editliturgia")) {
					?>
					<form action="edit.szertartas.php" method="post">
						<input type="hidden" name="id" value="<?php echo $id; ?>">
						<button type="submit" class="btn btn-primary text-white"><i class="bi bi-pencil"></i> Módosítás</button>
					</form>
					<form action="edit.szertartas.php" method="post" id="elmarad">
					<input type="hidden" name="id" value="<?php echo $id; ?>">
					<input type="hidden" name="stage" value="<?php if ($elmarad == 1) { echo "nem"; } ?>elmarad">
					<button type="submit" class="btn btn-secondary text-white">
						<?php if ($elmarad == 0) { ?>
						<i class="bi bi-calendar-x"></i> Elmarad
						<?php } else if ($elmarad == 1) { ?>
							<i class="bi bi-calendar-check"></i> Nem marad el
						<?php } ?>
					</button>
				</form>
				<?php }
				if (checkpermission("removeliturgia")) {
					?>
				<form action="delete.szertartas.php" method="post" id="deleteliturgia<?php echo $id; ?>">
					<input type="hidden" name="id" value="<?php echo $id; ?>">
					<input type="hidden" name="stage" value="3">
					<input type="hidden" name="miserend" value="true">
					<button type="button" class="btn btn-danger" onclick="deleteliturgia(<?php echo $id; ?>)"><i class="bi bi-trash3"></i> Törlés</button>
				</form>
				
				<?php
				}
				?>
			</td>
			<?php
		}
		?>
		</tr>
		<?php
		if ($elmarad == 1) {
			?>
			<tr>
				<td colspan="<?php echo $thcounter; ?>" style="background-color: #ffebc5;"><i class="bi bi-exclamation-triangle" style="color: #ffa700;"></i> Figyelem! Ez a liturgia elmarad!</td>
			</tr>
			<?php
		}
		?>
		<?php
		}
	}
	?>
		</tbody>
	</table>
	</div>
	</div>
	<div id="calendar" class="col">
		<p><span onclick="togglejelmagyarazat()" style="cursor: pointer;">Jelmagyarázat: <i class="bi bi-caret-down-fill" id="jelmagyarazaticon"></i></span><div style="display: inline;" id="jelmagyarazat">
		<?php
		$sql = "SELECT `telepulesID`, `name`, `color` FROM `templomok`";
		$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
		while ($row = mysqli_fetch_array($eredmeny))
		{
			$sqla = "SELECT `name` FROM `telepulesek` WHERE `id` = '".$row["telepulesID"]."'";
			$eredmenya = mysqli_query($mysql, $sqla) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
			$rowa = mysqli_fetch_array($eredmenya);
			?>
			<span class="templom" style="display: inline;"><div class="templomcolor" style="background-color: <?php echo $row["color"]; ?>;"></div><span style="color: <?php echo $row["color"]; ?>;"><?php echo $rowa["name"]; ?> - <?php echo $row["name"]; ?></span></span>
			<?php
		}
		?></div>
		</p>
		<div id="calendarbox"></div>
	</div>
</div>
</main>
<?php include("footer.php"); ?>
</body>
</html>