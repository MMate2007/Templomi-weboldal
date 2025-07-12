<?php ob_start(); ?>
<!DOCTYPE html>
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
<?php
displayhead("Jelszó módosítása");
include("headforadmin.php");
?>
<div id="messagesdiv">
	<?php
	Message::displayall();
	?>
</div>
<main class="container d-flex justify-content-center">
	<form name="modify-password form-horizontal" action="#" method="post">
	<p class="text-center">Kérem írja be az új jelszavát!</p>
	<div class="row mb-1">
		<label for="pass1" class="col-form-label col">Új jelszó:</label>
		<div class="col"><input type="password" class="form-control" name="pass1" id="pass1"></div>
	</div>
	<div class="row mb-1">
		<label for="pass2" class="col-form-label col">Új jelszó ismét:</label>
		<div class="col"><input type="password" class="form-control" id="pass2" name="pass2"></div>
	</div>
	<div class="text-center mt-2 mb-2"><input type="submit" class="btn btn-primary text-white" value="Módosítás"></div>
	<input type="hidden" name="stage" value="2">
	</form>
	<?php
if (isset($_POST["stage"]))
{
	if (correct($_POST["stage"]))
	{
		$pass1 = $_POST["pass1"];
		$pass2 = $_POST["pass2"];
		if ($pass1 != $pass2)
		{
			$eredmeny = false;
			formvalidation("#pass2", false, "A két jelszó nem egyezik meg!");
		}else{
			$sql = "SELECT `password` FROM `author` WHERE `id` = '".$_SESSION["userId"]."'";
			$eredmeny = mysqli_query($mysql, $sql);
			$row = mysqli_fetch_array($eredmeny);
			$eredmeny = false;
			if (!password_verify($pass2, $row["password"])) {
			$sql = "UPDATE `author` SET `password`= '".password_hash($pass1, $pwdhashalgo)."' WHERE `id` = '".$_SESSION["userId"]."'";
			$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
			} else {
				$message = new Message("A jelenlegi jelszó megegyezik a megadottal!", MessageType::warning);
				$message->insertontop();
			}
			if ($eredmeny == true)
			{
				$_SESSION["messages"][] = new Message("Sikeres módosítás.", MessageType::success);
				mysqli_close($mysql);
				header("Location: admin.php");
			}
		}
	}
}
?>
</main>
<div class="sidebar">
</div>
<?php include("footer.php"); ?>
</body>
</html>