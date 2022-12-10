<html>
<head>
<?php include("head.php"); ?>
<title>Mentés...</title>
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
<h1><?php echo $sitename; ?> honlapja - Beállítások mentése...</h1>
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
<?php
//FIXME settings hibajavítás
$settingnumber = -1;
$settingname;
$setting["main.name"] = null;
$sql = "SELECT `name` FROM `settings`";
$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
while ($row = mysqli_fetch_array($eredmeny))
{
	$setting[$row["name"]] = $_POST[$row["name"]];
    $settingnumber++;
    $settingname[$settingnumber] = $row[["name"]];
}
while ($settingnumber > -1)
{
    if ($setting[$settingname[$settingnumber]] != "null")
    {
        $sql = "UPDATE `settings` SET `value`='".$setting[$settingname[$settingnumber]]."' WHERE `name` = '".$settingname[$settingnumber]."'";
    } else {
        $sql = "UPDATE `settings` SET `value`=NULL WHERE `name` = '".$settingname[$settingnumber]."'";
    }
$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
$settingnumber--;
}

?>
<div class="content">
<div class="tartalom">
<?php
if ($eredmeny == true)
{
	?>
	<p class="succes">Sikeres mentés!</p>
	<?php
}else{
	?>
	<p class="warning">Valami hiba történt!</p>
	<?php
}
?>
</div>
</div>
<div class="sidebar">
</div>
<?php include("footer.php"); ?>
</body>
</html>