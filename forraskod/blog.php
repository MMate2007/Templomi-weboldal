<html>
<head>
<?php include("head.php"); ?>
<title>Blog - <?php echo $sitename; ?></title>
<meta name="title" content="Blog - <?php echo $sitename; ?>">
<meta name="description" content="A <?php echo $sitename; ?> blogján követheti, hogy mi történik a fília életében.">
<meta name="language" content="hu-HU">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
header nav a[href="http://<?php echo $_SERVER['HTTP_HOST']; echo htmlspecialchars($_SERVER['PHP_SELF']);?>"], nav a[href="http://<?php echo $_SERVER['HTTP_HOST']; echo htmlspecialchars($_SERVER['PHP_SELF']);?>"] {font-weight: bold;}
div.content div.tartalom div.blog img {max-width: 70%; margin-left: 15%;}
div.fejlecparallax {
    background-image: url("DSC_0080.JPG");
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
<h1><?php echo $sitename; ?> honlapja - Blog</h1>
</div>
</div>
</div>
<hr>
<nav>
<?php include("navbar.php"); ?>
</nav>
</header>
<div class="content">
<div class="tartalom">
<div class="blog">
<?php
	//FIXME mysql hiba
	$mysql = mysqli_connect("localhost", "filia", "borszorcsokfilia8479", "filia") or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
	mysqli_query($mysql, "SET NAMES utf8");
	$sql = "SELECT * FROM `blog` ORDER BY id DESC;";
	$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
	while ($row = mysqli_fetch_array($eredmeny))
	{
		$id = $row['id'];
		$title = $row['title'];
		$content = $row['content'];
		$authorid = $row['authorId'];
		$image = $row['image'];
		$name = "Ismeretlen";
		$date = $row['date'];
		?>
		<hr>
		<div class="bejegyzes" id="<?php echo $id;?>">
		<h2><?php echo $title;?></h2>
		<p class="bejegyzes-meta">Szerző: 
		<?php
		$sql = "SELECT `name` FROM `author` WHERE `id` = '".$authorid."'";
	$eredmeny2 = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
	while ($sor = mysqli_fetch_array($eredmeny2))
	{
		$name_ = $sor["name"];
		$name = $name_;
	}
	echo $name;
		?>, Publikálás dátuma: <?php echo $date;?></p>
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
		<?php
	}
	
	?>
</div>
</div>
</div>
<div class="sidebar">
</div>
<?php include("footer.php"); ?>
</body>
</html>