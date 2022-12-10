<html>
<head>
<?php include("head.php"); ?>
<title>Közzététel...</title>
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
<h1><?php echo $sitename; ?> honlapja - Litrugia hozzáadása...</h1>
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
$sztipus = null;
$telepules = null;
$templom = null;
$celebrans = null;
$kantor = null;
$type = null;
$szandekvan = null;
$szandek = null;
$pub = null;
$megj = null;
$pubmegj = null;
$datum = null;
$name = null;
$place = null;
$color = null;
$bold = null;
$italic = null;
$underline = null;
$style = null;

$sztipus = correct($_POST["sztipus"]); if ($sztipus == "semmi") { $sztipus = null;}
$telepules = correct($_POST["telepules"]); if ($telepules == "semmi") { $telepules = null;}
$templom = correct($_POST["templom"]); if ($templom == "semmi" || $templom == "egyeb") { $templom = null;}
//TODO külön érték megadása a nem adom megnek, celebráns és kántor számára és MySQL foreign key ügy megoldása ekapcsán
$celebrans = correct($_POST["celebrans"]); if ($celebrans == "null") { $celebrans = null; } if ($celebrans == "semmi") { $celebrans = null;}
$kantor = correct($_POST["kantor"]); if ($kantor == "null") { $kantor = null; } if ($kantor == "semmi") { $kantor = null;}
$type = correct($_POST["type"]);
$szandekvan = correct($_POST["szandekvan"]);
$szandekbevitt = correct($_POST["szandekbevitt"]);
$szandek = correct($_POST["szandek"]);
if ($szandek == "") { $szandek = null; }
if ($szandekvan == 0) {$szandek = "0";}
if ($szandekvan == 1 && $szandek == null) { $szandek = 1; }
if ($szandekvan == null) { $szandek = null; }
if ($szandekvan == 2) {$szandek = 2; }

$pub = correct($_POST["pub"]);
$megj = $_POST["megjegyzes"]; if ($megj == "") {$megj = null;}

$pubmegj = $_POST["pubmegj"]; if ($pubmegj == "") {$pubmegj = null;}

$datum = $_POST["date"].":00";

$date = str_replace("T", " ", $datum);
if (!check($date, "dateinput")) {
	$date = null;
}
$name = correct($_POST["name"]); if ($name = "") {$name = null;}
$place = correct($_POST["egyebtemplom"]); if ($place == "") { $place = null;}
$postcolor = $_POST["color"];
if (!check($postcolor, "colorhex"))
{
	$postcolor = "#000000";
}
$color = "color: " . $postcolor . "; ";
$bold = $_POST["bold"] . " ";
if (!check($bold, "styleexpression")) {
	$bold = null;
}
$italic = $_POST["italic"] . " ";
if (!check($italic, "styleexpression")) {
	$italic = null;
}
$underline = $_POST["underline"];
if (!check($underline, "styleexpression")) {
	$underline = null;
}
$style = "";
if ($color != "color: #000000;")
{
	$style = $color;
}
if ($bold == "font-weight: bold; ")
{
	$style .= $bold;
}
if ($italic == "font-style: italic; ")
{
	$style .= $italic;
}
if ($underline == "text-decoration: underline;")
{
	$style .= $underline;
}
$regex = "/^[^\<\>\{\}\']*$/";
if (!preg_match($regex, $style))
{
$style = null;
}

$szandekid = $szandekvan;
if ($szandekbevitt != 0 && $szandekbevitt != 1) {
	$szandekid = $szandekbevitt;
}
if ($szandekbevitt == 1 && $szandekvan == 1)
{
	$sql = "SELECT `id` FROM `szandekok`";
	$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
	while ($row = mysqli_fetch_array($eredmeny))
	{
		$_id = $row['id'];
		$szandekid = $_id + 1;
	}
	if ($szandekid < 3)
	{
		$sql = "DELETE FROM `szandekok` WHERE  `id` < 3";
		$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
		$sql = "INSERT INTO `szandekok`(`id`, `szandek`) VALUES ('0','0')";
		$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
		$sql = "INSERT INTO `szandekok`(`id`, `szandek`) VALUES ('1','1')";
		$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
		$sql = "INSERT INTO `szandekok`(`id`, `szandek`) VALUES ('2','2')";
		$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
		$szandekid = 3;
	}
	$sql = "INSERT INTO `szandekok`(`id`, `szandek`, `kikerte`) VALUES ('".$szandekid."','".$szandek."','!automata')";
	$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
}
$sql = "SELECT * FROM `szertartasok`";
$id = 0;
$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
while ($row = mysqli_fetch_array($eredmeny))
{
	if ($row["date"] == $date && $row["templomID"] == $templom)
	{
		
		?>
		<script>
		alert("Ez a liturgia már be van jegyezve!");
		window.location.replace("admin.php");
		</script>
		<?php
		$date = null;
		$name = null;
		$place = null;
		break;
	}
	$_id = $row['id'];
	$id = $_id + 1;
}
$sql = "SELECT `telepulesID` FROM `templomok` WHERE `id` = '".$templom."'";
$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
while ($row = mysqli_fetch_array($eredmeny))
{
	$ttel = $row["telepulesID"];
	if ($ttel != $telepules)
	{
		?>
		<script>
			alert("A választott templom nem a megadott településen van!");
			window.location.replace("form.create.szertartas.php");
		</script>
		<?php
	}
}
if ($date != null) {
	//$sql = "INSERT INTO `szertartasok`(`id`, `date`, `nameID`, `name`, `telepulesID`, `templomID`, `place`, `celebransID`, `kantorID`, `tipus`, `szandek`, `publikus`, `megjegyzes`, `pubmegj`) VALUES ('".$id."','".$date."','".$sztipus."','".$name."','".$telepules."','".$templom."','".$place."','".$celebrans."','".$kantor."','".$type."','".$szandek."','".$pub."','".$megj."','".$pubmegj."')";
	$sql = "INSERT INTO `szertartasok`(`id`, `date`, `nameID`, `name`, `telepulesID`, `templomID`, `place`, `style`, `celebransID`, `kantorID`, `tipus`, `szandek`, `publikus`, `megjegyzes`, `pubmegj`) VALUES ('".$id."','".$date."','".$sztipus."','".$name."','".$telepules."',";
	if ($templom != null) { $sql .= "'".$templom."',"; } else { $sql .= "NULL,";}
	if ($place != null) { $sql .= "'".$place."',"; } else { $sql .= "NULL,";}
	if ($style != null && $style != "") { $sql .= "'".$style."',"; } else { $sql .= "NULL,";}
	if ($celebrans != null) { $sql .= "'".$celebrans."',"; } else { $sql .= "NULL,";}
	if ($kantor != null) { $sql .= "'".$kantor."',"; } else { $sql .= "NULL,";}
	if ($type != null) { $sql .= "'".$type."',"; } else { $sql .= "NULL,";}
	if ($szandek != null) { $sql .= "'".$szandekid."',"; } else { $sql .= "NULL,";}
	$sql .= "'".$pub."',";
	if ($megj != null) { $sql .= "'".$megj."',"; } else { $sql .= "NULL,";}
	if ($pubmegj != null) { $sql .= "'".$pubmegj."'"; } else { $sql .= "NULL";}
	$sql .= ")";
/*if ($style != null && $style != "")
{
	$sql = "INSERT INTO `szertartasok`(`id`, `date`, `nameID`, `name`, `telepulesID`, `templomID`, `place`, `style`, `celebransID`, `kantorID`, `tipus`, `szandek`, `publikus`, `megjegyzes`, `pubmegj`) VALUES ('".$id."','".$date."','".$sztipus."','".$name."','".$telepules."',";
	if ($templom != null) { $sql .= "'".$templom."',"; } else { $sql .= "NULL,";}
	if ($place != null) { $sql .= "'".$place."',"; } else { $sql .= "NULL,";}
	if ($style != null && $style != "") { $sql .= "'".$style."',"; } else { $sql .= "NULL,";}
	if ($celebrans != null) { $sql .= "'".$celebrans."',"; } else { $sql .= "NULL,";}
	if ($kantor != null) { $sql .= "'".$kantor."',"; } else { $sql .= "NULL,";}
	if ($type != null) { $sql .= "'".$type."',"; } else { $sql .= "NULL,";}
	if ($szandek != null) { $sql .= "'".$szandek."',"; } else { $sql .= "NULL,";}
	$sql .= "'".$pub."',";
	if ($megj != null) { $sql .= "'".$megj."',"; } else { $sql .= "NULL,";}
	if ($pubmegj != null) { $sql .= "'".$pubmegj."'"; } else { $sql .= "NULL,";}
	$sql .= ")";
}*/
$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>"); }
else {
	?>
	<script>
	alert("Valami hiba történt! Kérem, próbálja újra!");
	var x = 1;
	</script>
	<?php
}

?>
<div class="content">
<div class="tartalom">
<?php
if ($eredmeny == true)
{
	?>
	<p class="succes">Sikeres hozzáadás!</p>
	<script>
		if (x != 0) {
	alert("Sikeres hozzáadás!");
	var result = confirm("Meg szeretné nézni a változtatást?");
	if (result == true)
	{
		window.location.replace("miserend.php");
	}else{
		window.location.replace("admin.php");
	} }
	</script>
	<?php
}else{
	?>
	<p class="warning">Valami hiba történt!</p>
	<p>Kérem, próbálja újra!</p>
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