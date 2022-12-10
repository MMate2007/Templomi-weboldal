<?php ob_start(); ?>
<html>
<head>
<?php include("head.php"); ?>
<title>Jelszó módosítása - <?php echo $sitename; ?></title>
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
<h1><?php echo $sitename; ?> honlapja - Jelszó módosítása</h1>
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
if (!isset($_POST["stage"])) {
	?>
	<!--<form name="modify-password" action="modify.password.php" method="post">-->
	<form name="modify-password" action="#" method="post">
	<p>Kérem írja be az új jelszavát!</p>
	<table>
	<tr>
	<td><label>Új jelszó: </label></td>
	<td><input type="password" name="pass1"></td>
	</tr>
	<tr>
	<td><label>Új jelszó ismét: </label></td>
	<td><input type="password" name="pass2"></td>
	</tr>
	<tr>
	<td><label></label></td>
	<td><input type="submit" value="Módosítás"></td>
	<input type="hidden" name="stage" value="2">
	</tr>
	</table>
	</form>
	<?php
} else if (isset($_POST["stage"]))
{
	if (correct($_POST["stage"]))
	{
		$pass1 = sha1(md5($_POST["pass1"]));
		$pass2 = sha1(md5($_POST["pass2"]));
		if ($pass1 != $pass2)
		{
			$eredmeny = false;
			?>
			<p class="warning">A két jelszó nem egyezik!</p>
			<form name="modify-password" action="#" method="post">
			<p>Kérem írja be az új jelszavát!</p>
			<table>
			<tr>
			<td><label>Új jelszó: </label></td>
			<td><input type="password" name="pass1" required autofocus></td>
			</tr>
			<tr>
			<td><label>Új jelszó ismét: </label></td>
			<td><input type="password" name="pass2" required></td>
			</tr>
			<tr>
			<td><label></label></td>
			<td><input type="submit" value="Módosítás"></td>
			<input type="hidden" name="stage" value="2">
			</tr>
			</table>
			</form>
			<?php
		}else{
			mysqli_query($mysql, "SET NAMES utf8");
			$sql = "UPDATE `author` SET `password`= '".$pass1."' WHERE `id` = '".$_SESSION["userId"]."'";
			$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
			if ($eredmeny == true)
			{
				?>
				<p class="succes">Sikeres jelszó módosítás!</p>
				<?php
			}else{
				?>
				<p class="warning">Valami hiba történt!</p>
				<p>Kérem, próbálja újra!</p>
				<form name="modify-password" action="#" method="post">
				<p>Kérem írja be az új jelszavát!</p>
				<table>
				<tr>
				<td><label>Új jelszó: </label></td>
				<td><input type="password" name="pass1"></td>
				</tr>
				<tr>
				<td><label>Új jelszó ismét: </label></td>
				<td><input type="password" name="pass2"></td>
				</tr>
				<tr>
				<td><label></label></td>
				<td><input type="submit" value="Módosítás"></td>
				<input type="hidden" name="stage" value="2">
				</tr>
				</table>
				</form>
				<?php
			}
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