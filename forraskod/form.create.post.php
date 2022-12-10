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
?>
</nav>
<hr>
</header>
<div class="content">
<div class="tartalom">
<?php
if (!isset($_POST["stage"]))
{
	?>
	<!--<form name="create-post" action="form2.create.post.php" method="post">-->
	<form name="create-post" action="#" method="post">
	<table class="form">
	<tr>
	<td><label>Bejegyzés címe: </label></td>
	<td><input type="text" name="title" <?php if (isset($_POST["title"])): ?>value="<?php echo $_POST["title"]; ?>" <?php endif ?> required></td>
	</tr>
	<tr>
	<td><label>Bejegyzés tartalma: </label></td>
	<td><textarea name="content" required><?php if (isset($_POST["content"])): echo $_POST["content"]; endif ?></textarea></td>
	</tr>
	<tr>
		<td><label>Kép forrása: </label></td>
		<td><input type="text" name="imagesrc" <?php if (isset($_POST["imagesrc"])): ?>value="<?php echo $_POST["imagesrc"]; ?>"<?php endif ?>></td>
		<td><label>Ha nem szeretne a bejegyzés végére képet illeszteni hagyja üresen!</label></td>
	</tr>
	<?php
	//FIXME admin fióknál nem jelenik meg ez a lehetőség
	if ($_SESSION["admin"] == 1)
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
			<option value="<?php echo $uid;?>"<?php if (isset($_POST["userid"])) {if ($_POST["userid"] == $uid) {echo " selected";}} ?>><?php echo $name;?> - <?php echo $uname;?></option>
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
	<input type="hidden" name="stage" value="2">
	</form>
	<?php
} else if (isset($_POST["stage"]))
{
	if (correct($_POST["stage"]) == "2")
	{
		//TODO több admin támogatása: ne az userId-val ellenőrizze, hogy az illető admin-e
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
		<form name="create-post-2" class="inline" id="first" action="#" method="post">
		<input type="hidden" name="title" value="<?php echo $title;?>">
		<input type="hidden" name="content" value="<?php echo $content;?>">
		<input type="hidden" name="userid" value="<?php echo $uid;?>">
		<input type="hidden" name="imagesrc" value="<?php echo $image;?>">
		<input type="hidden" name="stage" value="3">
		<input type="submit" value="Közzététel">
		</form>
		<form name="create-post-2-back" class="inline" action="#" method="post">
		<input type="hidden" name="title" value="<?php echo $title;?>">
		<input type="hidden" name="content" value="<?php echo $content;?>">
		<input type="hidden" name="userid" value="<?php echo $uid;?>">
		<input type="hidden" name="imagesrc" value="<?php echo $image;?>">
		<input type="submit" value="Vissza">
		</form>
		<?php
	}
	if (correct($_POST["stage"]) == "3")
	{
		$title = $_POST["title"];
		$content = $_POST["content"];
		$authorid = $_POST["userid"];
		$image = $_POST["imagesrc"];
		$date = date("Y.m.d H:i");
		$sql = "SELECT `id` FROM `blog`";
		$id = 0;
		$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
		while ($row = mysqli_fetch_array($eredmeny))
		{
			$_id = $row['id'];
			$id = $_id + 1;
		}
		$sql = "INSERT INTO `blog`(`id`, `title`, `content`, `authorId`, `date`, `image`) VALUES ('".$id."','".$title."','".$content."','".$authorid."','".$date."','".$image."')";
		$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
		if ($eredmeny == true)
		{
			?>
			<p class="succes">Sikeres publikáció!</p>
			<?php
		}else{
			?>
			<p class="warning">Valami hiba történt!</p>
			<p>Kérem, kattintson az alábbi gombra!</p>
			<form action="#" method="post">
			<input type="hidden" name="title" value="<?php echo $title;?>">
			<input type="hidden" name="content" value="<?php echo $content;?>">
			<input type="hidden" name="userid" value="<?php echo $authorid;?>">
			<input type="hidden" name="imagesrc" value="<?php echo $image;?>">
			<input type="submit" value="Újrapróbálkozás">
			</form>
			<?php
		}
	}
}
?>
</div>
</div>
<div class="sidebar">
</div>
<?php include("footer.php"); ?>
</body>
</html>