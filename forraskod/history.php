<?php ob_start(); ?>
<!DOCTYPE html>
<html>
<head>
<?php include("head.php"); ?>
<meta name="title" content="Templomunkról - <?php echo $sitename; ?>">
<title>Templomunkról - <?php echo $sitename; ?></title>
<meta name="description" content="A Szent Anna és Szent Joachim tiszteletére felszentelt templomról olvashat itt.">
<meta name="language" content="hu-HU">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
header nav a[href="http://<?php echo $_SERVER['HTTP_HOST']; echo htmlspecialchars($_SERVER['PHP_SELF']);?>"], nav a[href="http://<?php echo $_SERVER['HTTP_HOST']; echo htmlspecialchars($_SERVER['PHP_SELF']);?>"] {font-weight: bold;}

</style>
</head>
<body>
<?php displayhead("Templomunkról"); ?>
<div class="content">
<div class="tartalom">
<?php
/*
$sql = "SELECT `content` FROM `contents` WHERE `name` = 'history.tartalom'";
$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
while ($row = mysqli_fetch_array($eredmeny))
{
	$content = $row["content"];
}
echo $content;
*/
?>
<h1>A templomunkról</h1>
<p>Feltöltés alatt áll. Szíves türelmét kérjük!</p>
<p>Köszönjük!</p>
</div>
<div class="infok">
<h2>Néhány adat</h2>
<?php
/*
$sql = "SELECT `content` FROM `contents` WHERE `name` = 'history.adatok'";
$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
while ($row = mysqli_fetch_array($eredmeny))
{
	$content = $row["content"];
}
echo $content;
*/
?>
<table class="infok">
<tbody><tr>
<th>Plébános:</th>
<td>Németh József atya</td>
</tr>
<tr>
<th>Védőszent:</th>
<td>Szent Anna és Szent Joachim</td>
</tr>
<tr>
<th>Búcsú:</th>
<td>július 26. utáni vasárnap</td>
</tr>
</tbody></table>
</div>
<div class="sidebar">
</div>
<?php include("footer.php"); ?>
</body>
</html>