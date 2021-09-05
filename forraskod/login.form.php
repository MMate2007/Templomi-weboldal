<html>
<head>
<title>Bejelentkezés - Példa plébánia</title>
<meta charset="utf-8">
<meta name="title" content="Bejelentkezés - Példa plébánia">
<meta name="description" content="Bejelentkezés után szerkeszteni tudja az oldal bizonyos pontjait. Ha Ön is szeretne segíteni a weboldal jobbá tételében írjon a bszfilia@fabianistva.nhely.hu e-mail címre!">
<meta name="language" content="hu-HU">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="style.css">
<link rel="icon" type="image/pnp" href="icon.png">
<!--<meta name="keywords" content="">-->
<!--<meta name="theme-color" content="#ffea00">-->

<style>
header nav a[href="http://<?php echo $_SERVER['HTTP_HOST']; echo $_SERVER['PHP_SELF'];?>"], nav a[href="http://<?php echo $_SERVER['HTTP_HOST']; echo $_SERVER['PHP_SELF'];?>"] {font-weight: bold;}
@media only screen and (max-width: 600px) {
div.head-text {
	position: absolute;
	top: 15px;
	left: 40px;
}
div.head-text h1 {font-size: 23pt;}
}
@media only screen and (min-width: 600px) {
div.head-text {
	position: absolute;
	top: 20px;
	left: 90px;
}
div.head-text h1 {font-size: 72pt;}
}
@media only screen and (min-width: 1349px) {
div.head-text {
	position: absolute;
	top: 35px;
	left: 110px;
}
}
div.fejlecparallax {
    background-image: url("orgonateljes.jpg");
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
<h1>Példa plébánia honlapja - Bejelentkezés</h1>
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
<p>Ha szeretné szerkeszteni a weboldal tartalmát kérem jelentkezzen be az alábbi űrlap segítségével!</p>
<form name="login" action="login.php" method="post">
<table class="form">
<tr>
<td><label>Felhasználónév: </label></td>
<td><input type="text" name="username"></td>
</tr>
<tr>
<td><label>Jelszó: </label></td>
<td><input type="password" name="pass"></td>
</tr>
<tr>
<td><label></label></td>
<td><input type="submit" value="Bejelentkezés"></td>
</tr>
</table>
</form>
</div>
</div>
<?php
session_start();
if (isset($_SESSION["userId"]))
{
	header("Location: admin.php");
}
?>
<div class="sidebar">
</div>
<?php include("footer.php"); ?>
</body>
</html>