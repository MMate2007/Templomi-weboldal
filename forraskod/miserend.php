<?php ob_start(); ?>
<html>
<head>
<?php include("head.php"); ?>
<title>Liturgiák rendje - <?php echo $sitename; ?></title>
<meta name="title" content="Liturgiák rendje - <?php echo $sitename; ?>">
<meta name="description" content="Ezen az oldalon megtalálhatja, hogy mikor tartanak szentmiséket borszörcsöki Szent Anna és Szent Joachim templomban és a Jézus Szíve és Szűz Mária Szíve kápolnában.">
<meta name="language" content="hu-HU">
<meta name="keywords" content="borszörcsöki templom mise, mise, szentmise, borszörcsöki templom szentmise, Borszörcsök mise, borszörcsök mise, <?php echo $sitename; ?>, <?php echo $sitename; ?>, <?php echo $sitename; ?> mise, <?php echo $sitename; ?> szentmise">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
	header nav a[href="http://<?php echo $_SERVER['HTTP_HOST']; echo htmlspecialchars($_SERVER['PHP_SELF']);?>"], nav a[href="http://<?php echo $_SERVER['HTTP_HOST']; echo htmlspecialchars($_SERVER['PHP_SELF']);?>"] {font-weight: bold;}

div.fejlecparallax {
    background-image: url("<?php echo getsetting($mysql, 'picture.miserend'); ?>");
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
<h1><?php echo $sitename; ?> honlapja - Liturgiák rendje</h1>
</div>
</div>
</div>
<hr>
<nav>
<?php 
include("navbar.php");
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
</nav>
<hr>
</header>
<div class="content">
<div class="tartalom">
<div class="miserend">
<h2>Liturgiák rendje</h2>
<form name="szuro" action="miserend.php" method="post">
<p>Település: <select name="tel">
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
 vagy templom: <select name="temp">
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
 <input type="submit" value="Szűrés">
</p>
</form>
<table>
<tr>
<th>Időpont</th>
<th>Megnevezés</th>
<th>Hely</th>
<?php
$showCel = getsetting($mysql, "miserend.showCel");
$showKant = getsetting($mysql, "miserend.showKant");
$showSzandSz = getsetting($mysql, "miserend.showSzandekSzoveg");
$showSzM = getsetting($mysql, "miserend.showSzandekMeglet");
$showT = getsetting($mysql, "miserend.showTipus");
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
	if ($showT == 1 || $user == true) { ?> <th>Típus</th> <?php }
	if ($showCel == 1 || $user == true) { ?> <th>Pap</th> <?php }
	if ($showKant == 1 || $user == true) { ?> <th>Kántor</th> <?php }
	if ($showSzandSz == 1 || $showSzM == 1 || $user == true) { ?> <th>Szándék</th> <?php }
	?>
	<th>Megjegyzés</th>
	<?php
	if ($user == true)
	{
		?>
		<th>Privát megjegyzés</th>
		<th>Publikus</th>
		<th>Kezelés</th>
		<?php
	}
?>
</tr>
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
	$sql .= "`publikus`, `pubmegj` FROM `szertartasok` ORDER BY `date`";
	
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
	$regex = "/^[^\<\>\{\}\']*$/";
	if (!preg_match($regex, $style))
	{
	$style = null;
	}
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
	<tr id="<?php echo $id; ?>"<?php if ($style != null) { ?> style="<?php echo $style; ?>" <?php } ?>>
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
	if ($showT == 1 || $user == true) { ?> <td><?php if ($type != null) { echo $szertartasoktypeid[$type]; } else { ?> ? <?php }?></td> <?php }
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
		} else {
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
		} else if ($type != 0) { //FIXME ha csendes a mise, akkor ne jelenjen meg ?-jel a kántornál, ha a típus ismeretlen, akkor igen
			?>
			?
			<?php
		}
		?>
	</td> <?php }
	if ($showSzandSz == 1 || $showSzM == 1 || $user == true) { ?> <td>
		<?php
			if ($showSzM == 1 && $showSzandSz != 1 && $user != true)
			{
				/*if ($szandek == null || $szandek == "")
				{
					?>
					<input type="checkbox" disabled></input>
					<?php
				}*/

				if ($szandek == "1" || $szandek > 2)
				{
					?>
					<input type="checkbox" disabled checked></input>
					<?php
				}
				else if ($szandek == "0" || $szandek == "2")
				{
					?>
					<input type="checkbox" disabled></input>
					<?php
				} else {
					
					?>
					<label>?</label>
					<?php
				}
			}
			if ($showSzandSz == 1 || $user == true)
			{
				if ($szandek == null)
				{
					?>
					?
					<?php
				}
				else if ($szandek === "1")
				{
					echo "Van";
				} else if ($szandek === "0" || $szandek === "2")
				{
					echo "Nincs";
				}
				else {
					$sqla= "SELECT `szandek` FROM `szandekok` WHERE `id` = '".$szandek."'";
					$eredmenya = mysqli_query($mysql, $sqla) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
					while ($rowa = mysqli_fetch_array($eredmenya))
					{
						echo $rowa["szandek"];
					}
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
	//$mysql = mysqli_connect("localhost", "filia", "borszorcsokfilia8479", "filia") or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
	//mysqli_query($mysql, "SET NAMES utf8");
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
			<form action="form.edit.szertartas.php" method="post">
				<input type="hidden" name="id" value="<?php echo $id; ?>">
				<input type="submit" value="Módosítás">
			</form>
			<form action="delete.szertartas.php" method="post">
				<input type="hidden" name="id" value="<?php echo $id; ?>">
				<input type="hidden" name="stage" value="3">
				<input type="hidden" name="miserend" value="true">
				<input type="submit" value="Törlés">
			</form>
			
		</td>
		<?php
	}
	?>
	</tr>
	<?php
	}
}
?>
</table>
<p>? jelentése: nem adták meg.</p>
</div>
</div>
</div>
<div class="sidebar">
</div>
<?php include("footer.php"); ?>
</body>
</html>