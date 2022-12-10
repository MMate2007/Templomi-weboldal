<?php ob_start(); ?>
<html>
<head>
<?php include("head.php"); ?>
<title>Beállítások módosítása - <?php echo $sitename; ?></title>
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
<h1><?php echo $sitename; ?> honlapja - Beállítások módosítása</h1>
</div>
</div>
</div>
<hr>
<nav>
<?php include("navbar.php"); ?>
<?php

include("headforadmin.php");
if ($_SESSION["szint"] != 10)
{
	header("Location: admin.php");
}

?>

</nav>
<hr>
</header>
<div class="content">
<div class="tartalom">
<form name="settings" action="settings.php" method="post">
	<p>Kérem, hogy a zárójelben lévőnek megfelelő értéket írja be!</p>
<table>
	<!--TODO settings UI javítása-->
<?php
$sql = "SELECT * FROM `settings`";
$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
		while ($row = mysqli_fetch_array($eredmeny))
		{
			$name = $row["name"];
			$id = $row["name"];
			switch ($name)
			{
				case "miserend.showCel":
					$name = "Litrugia celebránsának mutatása a weboldalon látogatóknak (0/1)";
					break;
				case "miserend.showKant":
					$name = "Litrugia kántorának mutatása a weboldalon látogatóknak (0/1)";
					break;
				case "miserend.showSzandekMeglet":
					$name = "Jelzés a látogatóknak, hogy az adott liturgára már van szándék (egy pipa jelenik meg, ha van, a szándék nem lesz kiírva!) (0/1)";
					break;
				case "miserend.showSzandekSzoveg":
					$name = "Kiírja-e a látogatóknak az adott liturgiára kért szándékot (0/1)";
					break;
				case "miserend.showTipus":
					$name = "Kiírja-e a liturgia (különösen a szentmise) típusát (csendes, orgonás, ünnepi)? (0/1)";
					break;
				case "main.name":
					$name = "Weboldal neve (pl. XY plébánia honlapja, a honlaja szavat nem kell beírni!) (szöveg)";
					break;
			}
			$value = $row["value"];
            if ($value == null) {$value = "null";}
			?>
			<tr>
                <td><label><?php echo $name; ?> </label></td>
                <td><input type="text" name="<?php echo $id; ?>" value="<?php echo $value; ?>"></td>
                <td>A null jelenti azt, hogy nincs megadva az érték!</td>
            </tr>
			<?php
		}
?>
<tr>
<td><label></label></td>
<td><input type="submit" value="Mentés"></td>
<td><label></label></td>
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