<html>
<head>
<?php include("head.php"); ?>
<meta name="title" content="Főoldal - <?php echo $sitename; ?>">
<title><?php echo $sitename; ?></title>
<meta name="description" content="A szentmise vasárnap általában rggel 8 órakor van. Ez a fília a somlóvásárhelyi plébániához tartozik. Plébánosa: Németh József atya.">
<meta name="language" content="hu-HU">
<!--TODO meta:keywords, meta:description mezők frissítése-->
<meta name="keywords" content="Borszörcsök, <?php echo $sitename; ?>, borszörcsök, <?php echo $sitename; ?>, Borszörcsök templom, templom, borszörcsök templom, borszörcsök kápolna, kápolna, Borszörcsök kápolna, Borszörcsöki kápolna, borszörcsöki kápolna, borszörcsöki templom, Borszörcsöki templom, borszörcsök mise, borszörcsök, borszörcsök templom miserend">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
header nav a[href="http://<?php echo $_SERVER['HTTP_HOST']; echo htmlspecialchars(htmlspecialchars($_SERVER['PHP_SELF']));?>"], nav a[href="http://<?php echo $_SERVER['HTTP_HOST']; echo htmlspecialchars($_SERVER['PHP_SELF']);?>"] {font-weight: bold;}
div.fejlecparallax {
	height: 93%;
	background-image: url("<?php getheadimage(); ?>");
	/*TODO getheadimage() function beépítése a többi oldalra*/
}
@media only screen and (max-width: 800px) {
    div.fejlecparallax#oltar, div.fejlecparallax#ministransarany {
        display: none;
    }
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
<h1><?php echo $sitename; ?> honlapja</h1>
</div>
</div>
</div>
<hr>
<nav>
<?php include("navbar.php"); ?>
</nav>
<hr>
</header>
<div class="content">
<div id="welcome">
<?php
//TODO html frissítése: readonly, required, pattern, placeholder, autofocus attribútumok használata
/*
$sql = "SELECT `content` FROM `contents` WHERE `name` = 'index.welcome'";
$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
while ($row = mysqli_fetch_array($eredmeny))
{
	$content = $row["content"];
}
echo $content;*/
?>
<h1>Dicsértessék a Jézus Krisztus!</h1>
<h2>Üdvözlöm a <?php echo $sitename; ?> honlapján!</h2>
<p>Ezen az oldalon megtalálhatja, hogy <a href="miserend.php">mikor tartanak szentmisét</a>, megismerheti <a href="history.php">templomunkat</a> és sok más hasznos információt találhat <a href="usefull.php">itt</a>.</p>
<p>Ha bármilyen kérdése, kérése van, kérem írjon e-mailt az <a href="mailto:<?php echo getsetting($mysql, 'main.email'); ?>"><?php echo getsetting($mysql, 'main.email'); ?></a> e-mail címre. Észrevételeit, ötleteit, véleményét is szívesen várjuk!</p>
</div>
<div id="szentmise">
	<h2>Legközelebbi liturgiák</h2>
	<p>Részletekért kattintson az adott sorra!</p>
	<table>
		<tr>
			<th>Időpont</th>
			<th>Megnevezés</th>
			<th>Hely</th>
		</tr>
		<?php
			$counter = 0;
			$sql = "SELECT `id`, `szandek` FROM `szertartasok` WHERE `date` < '".date("Y-m-d H:i:s")."'";
			$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
			while ($row = mysqli_fetch_array($eredmeny))
			{
				$sql = "DELETE FROM `szandekok` WHERE `id` = '".$row["szandek"]."'";
				$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
				$sql = "DELETE FROM `szertartasok` WHERE `ID` = '".$row["id"]."'";
				$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
			}
			$sql = "SELECT `id`, `date`, `nameID`, `telepulesID`, `style`, `publikus` FROM `szertartasok` ORDER BY `date`";
			$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
			while ($row = mysqli_fetch_array($eredmeny))
			{
				$id = $row["id"];
				$date = $row["date"];
				$da = substr($date, 0, 16);
				$d = str_replace("-", ". ", $da);
				$sznevid = $row["nameID"];
				$sznev = null;
				$sqla = "SELECT `name` FROM `sznev` WHERE `id` = '".$sznevid."'";
				$eredmenya = mysqli_query($mysql, $sqla) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
				while ($rowa = mysqli_fetch_array($eredmenya))
				{
					$sznev = $rowa["name"];
				}
				$telid = $row["telepulesID"];
				$tel = null;
				$sqla = "SELECT `name` FROM `telepulesek` WHERE `id` = '".$telid."'";
				$eredmenya = mysqli_query($mysql, $sqla) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
				while ($rowa = mysqli_fetch_array($eredmenya))
				{
					$tel = $rowa["name"];
				}
				$pub = $row["publikus"];
				$style = $row["style"];
				$regex = "/^[^\<\>\{\}\']*$/";
				if (!preg_match($regex, $style))
				{
				$style = null;
				}
				if ($pub == 1) {
				$counter++;
				if ($counter > 3)
				{
					break;
				}
				?>
				<tr onclick="window.location.replace('miserend.php#<?php echo $id; ?>');"<?php if ($counter == 3) { ?>id="last"<?php } ?><?php if ($style != null) { ?> style="<?php echo $style; ?>" <?php } ?>>
				<td><?php echo $d;?></td>
				<td><?php echo $sznev;?></td>
				<td><?php echo $tel;?></td>
				</tr>
				<?php
				}
			}
			include("createrss.php");
		?>
	</table>
<?php
/*
$sql = "SELECT `content` FROM `contents` WHERE `name` = 'index.szentmise'";
$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
while ($row = mysqli_fetch_array($eredmeny))
{
	$content = $row["content"];
}
echo $content;*/
?>
<!--<h2>Rendszeres szentmisék</h2>
<p>Rendszeresen vannak szentmisék a Szent Anna és Szent Joachim templomban <b>vasárnap reggel 8 órakor</b>, valamint <b>csütörtökön 16:30-kor</b>.</p>
<p>Az aktuális listát a szertartásokról <a href="miserend.php">itt</a> érheti el.</p>-->
</div>
<div id="gyonas">
<?php /*
mysqli_query($mysql, "SET NAMES utf8");
$sql = "SELECT `content` FROM `contents` WHERE `name` = 'index.gyonas'";
$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
while ($row = mysqli_fetch_array($eredmeny))
{
	$content = $row["content"];
}
echo $content;*/
?>
<h2>Gyónási lehetőség</h2>
<p>Gyónni bármikor lehet a sekrestyében amikor a miséző pap ráér. Érdemes szentmise előtt 15 perccel a sekrestyében, a sekrestye bejáratánál várakozni. A gyónás a sekrestyében történik!</p>
</div>
<!--<div class="fejlecparallax" id="oltar"></div>-->
<div class="tartalom">
<hr>
<div class="hirdetotabla">
<h2>Hirdetőtábla</h2>
<marquee>
<?php
/*mysqli_query($mysql, "SET NAMES utf8");
$sql = "SELECT `content` FROM `contents` WHERE `name` = 'index.hirdetotabla.leiras'";
$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
while ($row = mysqli_fetch_array($eredmeny))
{
	$content = $row["content"];
}
echo $content;*/
?>
Itt, a hirdetőtáblán a közelgő eseményekről, esedékes információkról olvashat.
</marquee>
<?php
$hrvan = false;

//$sql = "DELETE FROM `szertartasok` WHERE `stoptime` < '".date("Y-m-d H:i:s")."'";
//$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
$sql = "SELECT `ID`, `title`, `content` FROM `hirdetesek` WHERE `starttime` < '".date("Y-m-d H:i:s")."'";
$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
while ($row = mysqli_fetch_array($eredmeny))
{
	$id = $row["ID"];
	$title = $row["title"];
	$content = $row["content"];
	if ($hrvan == true)
	{
	?>
	<hr class="hirdetotabla">
	<?php
	}
	?>
	<div class="hirdetotabla" id = "<?php echo $id; ?>">
	<h3 class="hirdetotabla"><?php echo $title; ?></h3>
	<p class="hirdetotabla"><?php echo $content; ?></p>
	</div>
	<?php
	if ($hrvan == false)
	{
		$hrvan = true;
	}
}
?>
</div>
<hr>
<div id="legkozelebbi">
<h2>
<?php /*
mysqli_query($mysql, "SET NAMES utf8");
$sql = "SELECT `content` FROM `contents` WHERE `name` = 'index.legkozelebbi.title'";
$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
while ($row = mysqli_fetch_array($eredmeny))
{
	$content = $row["content"];
}
echo $content;*/
?>
Legközelebbi szertartás
</h2>
<?php
mysqli_query($mysql, "SET NAMES utf8");
$sql = "DELETE FROM `szertartasok` WHERE `date` < '".date("Y-m-d H:i:s")."'";
$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
$sql = "SELECT `date`, `name`, `place` FROM `szertartasok` ORDER BY `date`";
$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
while ($row = mysqli_fetch_array($eredmeny))
{
	$date = $row["date"];
	$d = substr($date, 0, 16);
	$name = $row["name"];
	$place = $row["place"];
	?>
	<table>
	<tr>
	<td><label>Időpont: </label></td>
	<td><?php echo $d;?></td>
	</tr>
	<tr>
	<td><label>Megnevezés: </label></td>
	<td><?php echo $name;?></td>
	</tr>
	<tr>
	<td><label>Hely: </label></td>
	<td><?php echo $place;?></td>
	</tr>
	</table>
	<?php
	break;
}
?>
</div>
<!--<div class="fejlecparallax" id="ministransarany"></div>-->
<hr>
<div id="info" class="info">
	<h2>Közérdekű információk</h2>
	<?php
/*mysqli_query($mysql, "SET NAMES utf8");
$sql = "SELECT `content` FROM `contents` WHERE `name` = 'index.kozerdekuinfok'";
$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
while ($row = mysqli_fetch_array($eredmeny))
{
	$content = $row["content"];
}
echo $content;
*/
?>
<div id="plebania" class="info">
		<h3>Plébánia adatai</h3>
		<table>
			<tbody><tr>
				<th>Levélcím</th>
				<td></td>
			</tr>
		</tbody></table>
	</div>
</div>
</div>
</div>
<?php include("footer.php"); ?>
</body>
</html>