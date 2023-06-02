<?php ob_start(); ?>
<!DOCTYPE html>
<html>
<head>
<?php include("head.php"); ?>
<meta name="title" content="Hasznosságok - <?php echo $sitename; ?>">
<title>Hasznosságok - <?php echo $sitename; ?></title>
<meta name="description" content="Ezen az oldalon más egyéb hasznos dolgokat, linkeket találhat meg.">
<meta name="language" content="hu-HU">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="keywords" content="linkek, katolikus linkek, katolikus, keresztény linkek, katolikus oldalak, katolikus weboldalak, borszörcsök, <?php echo $sitename; ?>, borszörcsök fília, borszörcsöki templom, borszörcsök templom">
<style>
header nav a[href="http://<?php echo $_SERVER['HTTP_HOST']; echo htmlspecialchars($_SERVER['PHP_SELF']);?>"], nav a[href="http://<?php echo $_SERVER['HTTP_HOST']; echo htmlspecialchars($_SERVER['PHP_SELF']);?>"] {font-weight: bold;}
</style>
</head>
<body>
<?php
displayhead("Hasznosságok");
?>
<div class="content">
<div class="tartalom">
<?php
/*
$sql = "SELECT `content` FROM `contents` WHERE `name` = 'useful.tartalom'";
$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
while ($row = mysqli_fetch_array($eredmeny))
{
	$content = $row["content"];
}
echo $content;
*/
?>
<h2>Linkek, weboldalak</h2>
<p><a target="_blank" href="https://www.mariaradio.hu/"><img src="https://www.mariaradio.hu/dokumentum/2905/logo_fekvobanner.jpg"></a></p>
<p><a target="_blank" href="https://www.veszpremiersekseg.hu/">Veszprémi Érsekség weboldala</a></p>
<p><a target="_blank" href="https://plebaniaajka.wordpress.com/">Ajkai plébánia weboldala</a></p>
<p><a target="_blank" href="https://katolikus.hu/">katolikus.hu</a></p>
<p><a target="_blank" href="https://igenaptar.katolikus.hu/">Igenaptár</a></p>
<p><a target="_blank" href="https://katolikus.hu/igenaptar">Napi evangélium</a></p>
<p><a target="_blank" href="https://www.katolikusradio.hu/">Magyar Katolikus Rádió</a></p>
<p><a target="_blank" href="http://lexikon.katolikus.hu/">Katolikus lexikon</a></p>
<p><a target="_blank" href="https://www.evangelium365.hu/">Evangélium365</a></p>
<p><a target="_blank" href="https://miserend.hu/">Miserend</a></p>
<p><a target="_blank" href="http://www.medjugorje.hr/hu/">Medjugorje</a></p>
<p><a target="_blank" href="https://plebania.net/">Virtuális plébánia</a></p>
<p><a target="_blank" href="https://www.magyarkurir.hu/">Magyar Kurír - katolikus hírportál</a></p>
<p><a target="_blank" href="https://szentiras.hu/">Online szentírás</a></p>
<p><a target="_blank" href="https://sites.google.com/site/tamasvaday/liturgikusnaptar">Katolikus naptár</a></p>
<h2>Rádiófrekvenciák</h2>
<p>Ajkai Mária Rádió: FM 93.2 MHz.</p>
<p>Magyar Katolikus Rádió Tapolca: FM 101.8 MHz.</p>
</div>
</div>
<div class="sidebar">
</div>
<?php include("footer.php"); ?>
</body>
</html>