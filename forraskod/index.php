<html>
<head>
<meta charset="utf-8">
<meta name="title" content="Főoldal - Példa plébánia">
<title>Példa plébánia</title>
<meta name="description" content="Ezen az oldalon többet tudhat meg a borszörcsöki fíliáról. Ez a fília a somlóvásárhelyi plébániához tartozik. Plébánosa: Németh József atya.">
<meta name="language" content="hu-HU">
<meta name="keywords" content="Borszörcsök, Példa plébánia, borszörcsök, Példa plébánia, Borszörcsök templom, templom, borszörcsök templom, borszörcsök kápolna, kápolna, Borszörcsök kápolna, Borszörcsöki kápolna, borszörcsöki kápolna, borszörcsöki templom, Borszörcsöki templom">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="style.css">
<link rel="icon" type="image/pnp" href="icon.png">
<!--<meta name="theme-color" content="#ffea00">-->

<style>
header nav a[href="http://<?php echo $_SERVER['HTTP_HOST']; echo $_SERVER['PHP_SELF'];?>"], nav a[href="http://<?php echo $_SERVER['HTTP_HOST']; echo $_SERVER['PHP_SELF'];?>"] {font-weight: bold;}
@media only screen and (max-width: 800px) {
div.head-text {
	position: absolute;
	top: 27px;
	left: 25px;
}
div.head-text h1 {font-size: 20pt;}
}
@media only screen and (min-width: 700px) {
div.head-text {
	position: absolute;
	top: 0px;
	left: 20px;
}
div.head-text h1 {font-size: 50pt;}
}
@media only screen and (min-width: 1349px) {
div.head-text {
	position: absolute;
	top: 80px;
	left: 140px;
}
}
div.fejlecparallax {
	height: 93%;
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
<h1>Példa plébánia honlapja</h1>
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
/*$mysql = mysqli_connect("localhost", "mysqlfelhasznalo", "mysqljelszo", "adatbazisnev") or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
mysqli_query($mysql, "SET NAMES utf8");
$sql = "SELECT `content` FROM `contents` WHERE `name` = 'index.welcome'";
$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
while ($row = mysqli_fetch_array($eredmeny))
{
	$content = $row["content"];
}
echo $content;*/
?>
<h1>Dicsértessék a Jézus Krisztus!</h1>
<h2>Üdvözlöm a Példa plébánia honlapján!</h2>
<p>Ezen az oldalon megtalálhatja, hogy <a href="miserend.php">mikor tartanak szentmisét</a>, megismerheti <a href="history.php">templomunkat</a> és sok más hasznos információt találhat <a href="usefull.php">itt</a>.</p>
<p>Ha bármilyen kérdése, kérése van, kérem írjon e-mailt az <a href="mailto:bszfilia@fabianistva.nhely.hu">bszfilia@fabianistva.nhely.hu</a> e-mail címre. Észrevételeit, ötleteit, véleményét is szívesen várjuk!</p>
</div>
<div id="szentmise">
<?php
/*mysqli_query($mysql, "SET NAMES utf8");
$sql = "SELECT `content` FROM `contents` WHERE `name` = 'index.szentmise'";
$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
while ($row = mysqli_fetch_array($eredmeny))
{
	$content = $row["content"];
}
echo $content;*/
?>
<h2>Rendszeres szentmisék</h2>
<p>Rendszeresen vannak szentmisék a Szent Anna és Szent Joachim templomban <b>vasárnap reggel 8 órakor</b>, valamint <b>csütörtök este 6 órakor</b>.</p>
<p>Az aktuális listát a szertartásokról <a href="miserend.php">itt</a> érheti el.</p>
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
$mysql = mysqli_connect("localhost", "mysqlfelhasznalo", "mysqljelszo", "adatbazisnev") or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
mysqli_query($mysql, "SET NAMES utf8");
$sql = "SELECT * FROM `hirdetesek`";
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
mysqli_close($mysql);*/
?>
<div id="plebania" class="info">
		<h3>Plébánia adatai</h3>
		<table>
			<tbody><tr>
				<th>Levélcím</th>
				<td>8481 Somlóvásárhely, Táncsics u. 1.</td>
			</tr>
		</tbody></table>
	</div>
</div>
</div>
</div>
<?php include("footer.php"); ?>
</body>
</html>