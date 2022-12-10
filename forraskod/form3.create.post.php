<?php ob_start(); ?>
<html>
<head>
<?php include("head.php"); ?>
<title>Blogbejegyzés létrehozása - <?php echo $sitename; ?></title>

<meta name="language" content="hu-HU">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
	header nav a[href="http://<?php echo $_SERVER['HTTP_HOST']; echo htmlspecialchars($_SERVER['PHP_SELF']);?>"], nav a[href="http://<?php echo $_SERVER['HTTP_HOST']; echo htmlspecialchars($_SERVER['PHP_SELF']);?>"] {font-weight: bold;}

</style>
</head>
<body>
<header>
<div class="head">
<!--<img class="head" src="fejlec.jpg" style="width: 100%;">-->
<!--<img class="head" src="fejlecvekony.jpg" style="width: 100%;">-->
<div class="fejlecparallax">
<div class="head-text">
<h1><?php echo $sitename; ?> honlapja - Blogbejegyzés létrehozása</h1>
</div>
</div>
</div>
<hr>
<nav>
<?php include("navbar.php"); ?>
<?php

include("headforadmin.php");

$title = $_POST["title"];
$content = $_POST["content"];
$userid = $_POST["userid"];
$image = $_POST["imagesrc"];
?>

</nav>
<hr>
</header>
<div class="content">
<div class="tartalom">
<form name="create-post" action="form2.create.post.php" method="post">
<table class="form">
<tr>
<td><label>Bejegyzés címe: </label></td>
<td><input type="text" name="title" value="<?php echo $title;?>"></td>
</tr>
<tr>
<td><label>Bejegyzés tartalma: </label></td>
<td><textarea name="content"><?php echo $content;?></textarea></td>
</tr>
<tr>
	<td><label>Kép forrása: </label></td>
	<td><input type="text" name="imagesrc" value="<?php echo $image;?>"></td>
	<td><label>Ha nem szeretne a bejegyzés végére képet illeszteni hagyja üresen!</label></td>
</tr>
<?php
if ($_SESSION["userId"] == 0)
{
	?>
	<tr>
	<td><label>Szerző: </label></td>
	<td>
	<select name="user">
	<?php
	$mysql = mysqli_connect("localhost", "filia", "borszorcsokfilia8479", "filia") or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
	mysqli_query($mysql, "SET NAMES utf8");
	$sql = "SELECT `id`, `name`, `username` FROM `author`";
	$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
	while ($row = mysqli_fetch_array($eredmeny))
	{
		$uid = $row["id"];
		$name = $row["name"];
		$uname = $row["username"];
		?>
		<option value="<?php echo $uid;?>" <?php if ($userid == $uid) { ?> selected <?php } ?>><?php echo $name;?> - <?php echo $uname;?></option>
		<?php
	}
	
	?>
	</select>
	</td>
	</tr>
	<?php
}
?>
<tr>
<td><label></label></td>
<td><input type="submit" value="Tovább"></td>
</tr>
</table>
</form>
</div>
</div>
<div class="sidebar">
</div>
<?php include("footer.php"); ?>
</body>
</html>