<html>
<head>
<?php include("head.php"); ?>
<title>Módosítás...</title>
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
<h1><?php echo $sitename; ?> honlapja - Litrugia szerkesztése...</h1>
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
$celebrans = correct($_POST["celebrans"]); if ($celebrans == "null") { $celebrans = null; } if ($celebrans == "semmi") { $celebrans = null;}
$kantor = correct($_POST["kantor"]); if ($kantor == "null") { $kantor = null; } if ($kantor == "semmi") { $kantor = null;}
$type = correct($_POST["type"]);
//TODO új szándék rendszer feldolgozása
$szandekvan = correct($_POST["szandekvan"]); 
$szandek = correct($_POST["szandek"]); if ($szandek == "") { $szandek = null; } if ($szandekvan == 0) {$szandek = "0";} if ($szandekvan == 1 && $szandek == null) { $szandek = 1; } if ($szandekvan == null) { $szandek = null; }
$pub = correct($_POST["pub"]);
$megj = $_POST["megjegyzes"]; if ($megj == "") {$megj = null;}
$pubmegj = $_POST["pubmegj"]; if ($pubmegj == "") {$pubmegj = null;}
$datum = $_POST["date"].":00";

$date = str_replace("T", " ", $datum);
$name = correct($_POST["name"]); if ($name = "") {$name = null;}
$place = correct($_POST["egyebtemplom"]); if ($place == "") { $place = null;}
$color = "color: " . $_POST["color"] . "; ";
$bold = $_POST["bold"] . " ";
$italic = $_POST["italic"] . " ";
$underline = $_POST["underline"];
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
			window.location.replace("form.edit.szertartas.php");
		</script>
		<?php
	}
}
if ($date != null) {
	//$sql = "UPDATE `szertartasok` SET `date`='".$date."',`nameID`='".$sztipus."',`name`='".$name."',`telepulesID`='".$telepules."',`templomID`='".$templom."',`place`='".$place."',`style`='".$style."',`celebransID`='".$celebrans."',`kantorID`='".$kantor."',`tipus`='".$type."',`szandek`='".$szandek."',`publikus`='".$pub."',`megjegyzes`='".$megj."',`pubmegj`='".$pubmegj."' WHERE `id` = '".$_POST["id"]."'";
	$sql = "UPDATE `szertartasok` SET `date`='".$date."',`nameID`='".$sztipus."',`name`='".$name."',`telepulesID`='".$telepules."',";
	if ($templom != null) { $sql .= "`templomID`='".$templom."',"; } else { $sql .= "`templomID`=NULL,";}
	if ($place != null) { $sql .= "`place`='".$place."',"; } else { $sql .= "`place`=NULL,";}
	if ($style != null && $style != "") { $sql .= "`style`='".$style."',"; } else { $sql .= "`style`=NULL,";}
	if ($celebrans != null) { $sql .= "`celebransID`='".$celebrans."',"; } else { $sql .= "`celebransID`=NULL,";}
	if ($kantor != null) { $sql .= "`kantorID`='".$kantor."',"; } else { $sql .= "`kantorID`=NULL,";}
	if ($type != null) { $sql .= "`tipus`='".$type."',"; } else { $sql .= "`tipus`=NULL,";}
	if ($szandek != null) { $sql .= "`szandek`='".$szandek."',"; } else { $sql .= "`szandek`=NULL,";}
	$sql .= "`publikus`='".$pub."',";
	if ($megj != null) { $sql .= "`megjegyzes`='".$megj."',"; } else { $sql .= "`megjegyzes`=NULL,";}
	if ($pubmegj != null) { $sql .= "`pubmegj`='".$pubmegj."'"; } else { $sql .= "`pubmegj`=NULL";}
	$sql .= " WHERE `id` = '".$_POST["id"]."'";

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