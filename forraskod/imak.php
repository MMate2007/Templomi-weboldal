<?php ob_start(); ?>
<html>
<head>
<?php include("head.php"); ?>
<meta name="title" content="Imádságok - <?php echo $sitename; ?>">
<title>Imádságok - <?php echo $sitename; ?></title>
<meta name="description" content="Ezen az oldalon imádságokat találhat meg.">
<meta name="language" content="hu-HU">
<meta name="keywords" content="imádságok, Imádságok, katolikus imádságok, imák, katolikus imák, borszörcsök imádságok, borszörcsök templom, Borszrcsök templom, Borszörcsök fília, borszörcsök fília, borszörcsök fílía imák, imák">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
header nav a[href="http://<?php echo $_SERVER['HTTP_HOST']; echo htmlspecialchars($_SERVER['PHP_SELF']);?>"], nav a[href="http://<?php echo $_SERVER['HTTP_HOST']; echo htmlspecialchars($_SERVER['PHP_SELF']);?>"] {font-weight: bold;}

div.fejlecparallax {
    background-image: url("misekonyv.jpg");
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
<h1><?php echo $sitename; ?> honlapja - Imádságok</h1>
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
<div class="tartalom">
<?php
/*
$sql = "SELECT `content` FROM `contents` WHERE `name` = 'imak.tartalom'";
$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
while ($row = mysqli_fetch_array($eredmeny))
{
	$content = $row["content"];
}
echo $content;
*/
?>
<h2>Feltöltés alatt!</h2>
<p>Ez az oldal feltöltés alatt áll! Szíves türelmét kérjük!</p>
<p>Köszönjük!</p>
<h2>Egetnyitó fohász</h2>
<p>Jézus Szíve, te tudsz mindent.</p>
<p>Jézus Szíve, te megtehetsz mindent.</p>
<p>Jézus Szíve, te látsz mindent.</p>
<p>Jézus Szíve, te gondot viselsz reánk.</p>
<p>Jézus Szíve, te meghallgatod imánkat. Ámen.</p>
</div>
</div>
<div class="sidebar">
</div>
<?php include("footer.php"); ?>
</body>
</html>