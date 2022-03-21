<html>
<head>
<title>Bejelentkezés folyamatban...</title>
<meta charset="utf-8">
</head>
<body>
<header>
<h1>Bejelentkezés folyamatban...</h1>
</header>
<?php
$username = $_POST["username"];
$pass = sha1(md5($_POST["pass"]));
$mysql = mysqli_connect("localhost", "mysqlfelhasznalo", "mysqljelszo", "adatbazisnev") or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
mysqli_query($mysql, "SET NAMES utf8");
$sql = "SELECT `id`, `name`, `password`, `admin` FROM `author` WHERE `username` = '".$username."'";
$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
while ($row = mysqli_fetch_array($eredmeny))
{
	$pass2 = $row["password"];
	$id = $row["id"];
	$name = $row["name"];
	$admin = $row["admin"];
	if ($admin == null)
	{
		?>
		<script>
		alert("Az Ön fiókját törölték, ezért nem léphet be. Ha ezt helytelennek, vagy véletlennek találja kérem vegye fel a kapcsolatot a rendszergazdával a weboldalon található űrlap segítségével!");
		window.location.replace("index.php");
		</script>
		<?php
	}else if ($pass == $pass2)
	{
		session_start();
		$_SESSION["userId"] = $id;
		$_SESSION["name"] = $name;
		$_SESSION["admin"] = $admin;
		mysqli_close($mysql);
		header("Location: admin.php");
	}else{
		header("Location: bad.login.form.php");
	}
}
mysqli_close($mysql);
?>
<p class="warning">Helytelen felhasználónév!</p>
<p>Kérem lépjen <a href="login.form.php">vissza</a>!</p>
</body>
</html>