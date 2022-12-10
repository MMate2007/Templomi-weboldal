<?php ob_start(); ?>
<html>
<head>
<?php include("head.php"); ?>
<meta name="title" content="Kápolnánkról - <?php echo $sitename; ?>">
<title>Kápolnánkról - <?php echo $sitename; ?></title>
<meta name="description" content="Ismerje meg a Jézus Szíve és a Szűz Mária Szíve kápolnát!">
<meta name="language" content="hu-HU">
<meta name="keywords" content="<?php echo $sitename; ?> kápolna, borszörcsöki kápolna, borszörcsök kápolna, Borszörcsök kápolna, Borszörcsök fília kápolna, borszörcsök fília kápolna, <?php echo $sitename; ?> kápolna">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
header nav a[href="http://<?php echo $_SERVER['HTTP_HOST']; echo htmlspecialchars($_SERVER['PHP_SELF']);?>"], nav a[href="http://<?php echo $_SERVER['HTTP_HOST']; echo htmlspecialchars($_SERVER['PHP_SELF']);?>"] {font-weight: bold;}

</style>
</head>
<body>
<header>
<div class="head">
<!--<img class="head" src="fejlec.jpg" style="width: 100%;">-->
<img class="head" src="kapolna.jpg" style="width: 100%;">
<div class="head-text">
<h1><?php echo $sitename; ?> honlapja - Kápolnánkról</h1>
</div>
</div>
<hr>
<nav>
<?php include("navbar.php"); ?>
</nav>
<hr>
</header>
<div class="content">
<div class="tartalom">
<?php
//TODO oldalak megoldása úgy, hogy egy táblázatban tároljuk az adatokat, és .htaccessel meg átirányítjuk így: localhost/kapolnarol => localhost/page.php?codename=kapolnarol
/*
$sql = "SELECT `content` FROM `contents` WHERE `name` = 'kapolna.tartalom'";
$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
while ($row = mysqli_fetch_array($eredmeny))
{
	$content = $row["content"];
}
echo $content;
*/
?>
<h1>Kápolnánkról</h1>
<p>Feltöltés alatt! Szíves türelmét kérjük!</p>
<p>Köszönjük!</p>
</div>
</div>
<div class="sidebar">
</div>
<?php include("footer.php"); ?>
</body>
</html>