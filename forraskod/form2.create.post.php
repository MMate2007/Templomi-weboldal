<html>
<head>
<?php include("head.php"); ?>
<title>Előnézet - Blogbejegyzés létrehozása - <?php echo $sitename; ?></title>
<meta name="language" content="hu-HU">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
	header nav a[href="http://<?php echo $_SERVER['HTTP_HOST']; echo htmlspecialchars($_SERVER['PHP_SELF']);?>"], nav a[href="http://<?php echo $_SERVER['HTTP_HOST']; echo htmlspecialchars($_SERVER['PHP_SELF']);?>"] {font-weight: bold;}

div.bejegyzes img {max-width: 70%; margin-left: 15%;}
</style>
</head>
<body>
<header>
<div class="head">
<!--<img class="head" src="fejlec.jpg" style="width: 100%;">-->
<!--<img class="head" src="fejlecvekony.jpg" style="width: 100%;">-->
<div class="fejlecparallax">
<div class="head-text">
<h1><?php echo $sitename; ?> honlapja - Blogbejegyzés létrehozása - Előnézet</h1>
</div>
</div>
</div>
<hr>
<nav>
<?php include("navbar.php"); ?>
<?php

include("headforadmin.php");
if ($_SESSION["userId"] == 0)
{
$uid = $_POST["user"];
}else{
	$uid = $_SESSION["userId"];
}
$title = $_POST["title"];
$content = $_POST["content"];
$image = $_POST["imagesrc"];
$name = "Ismeretlen";
$date = date("Y.m.d H:i");
$sql = "SELECT `name` FROM `author` WHERE `id` = '".$uid."'";
$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
while ($row = mysqli_fetch_array($eredmeny))
{
	$name_ = $row["name"];
	$name = $name_;
}
?>
</nav>
<hr>
</header>
<p>Íme a bejegyzés előnézete: </p>
<div class="bejegyzes">
		<h2><?php echo $title;?></h2>
		<p class="bejegyzes-meta">Szerző: <?php echo $name;?>, Publikálás dátuma: <?php echo $date;?></p>
		<div class="bejegyzes-content">
		<?php echo $content;?>
		<?php
		if ($image != null && $image != "")
		{
			?>
			<br>
			<img src="<?php echo $image;?>">
			<?php
		}
		?>
		</div>
		</div>
		<br>
<form name="create-post-2" class="inline" id="first" action="create.post.php" method="post">
<input type="hidden" name="title" value="<?php echo $title;?>">
<input type="hidden" name="content" value="<?php echo $content;?>">
<input type="hidden" name="userid" value="<?php echo $uid;?>">
<input type="hidden" name="imagesrc" value="<?php echo $image;?>">
<input type="submit" value="Közzététel">
</form>
<form name="create-post-2-back" class="inline" action="form3.create.post.php" method="post">
<input type="hidden" name="title" value="<?php echo $title;?>">
<input type="hidden" name="content" value="<?php echo $content;?>">
<input type="hidden" name="userid" value="<?php echo $uid;?>">
<input type="hidden" name="imagesrc" value="<?php echo $image;?>">
<input type="submit" value="Vissza">
</form>
<?php include("footer.php"); ?>
</body>
</html>