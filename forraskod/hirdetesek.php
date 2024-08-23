<?php ob_start(); ?>
<!DOCTYPE html>
<html>
<head>
<?php include("head.php"); ?>
<title>Hirdetések - <?php echo $sitename; ?></title>
<meta name="title" content="Hirdetések - <?php echo $sitename; ?>">
<meta name="language" content="hu-HU">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script>
	function deletehirdetes(id) {
		var remove = confirm("Biztosan törölni szeretné ezt a hirdetést?");
		if (remove) {
			document.querySelector("#deletehirdetes"+id).submit();
		}
	}
</script>
</head>
<body class="flex-column d-flex h-100">
<?php 
displayhead("Hirdetések");
?>
<?php
if (isset($_SESSION["userId"])) { ?>
<div id="messagesdiv">
	<?php
		Message::displayall();
	?>
	<?php } ?>
</div>
<main class="content mx-auto text-center flex-shrink-0" style="padding: 30px 30px;">
<?php
$user = false;
if (!isset($_SESSION["userId"]))
{
	$user = false;
} else {
	$user = true;
	$sql = "SELECT `name` FROM `author` WHERE `id` = '".$_SESSION["userId"]."'";
	$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
	while ($row = mysqli_fetch_array($eredmeny))
	{
		$name = $row["name"];
		if ($name != $_SESSION["name"])
		{
			
			$user = false;
		}
	}
}
$temp = null;
    if (isset($_POST["temp"]))
    {
	$temp = $_POST["temp"];
	if ($temp == "mind")
	{
		$temp = null;
	}
    }
if ($user == true) {
	if (checkpermission("addhirdetes")) {
		?>
		<div><a class="btn btn-primary text-white float-end" href="create.hirdetes.php"><i class="bi bi-plus-lg"></i> Új hirdetés hozzáadása</a></div>
		<?php
	}
    $rm = false;
    $edit = false;
    if (checkpermission("removehirdetes")) {
        $rm = true;
    }
    if (checkpermission("edithirdetes")) {
        $edit = true;
    }
}
?>
<div class="hirdetesek">
    <form action="#" method="post" name="filter">
    Templom: <select name="temp" class="form-select">
	<option value="mind">Az összes</option>
	<?php
	$sql = "SELECT `id`, `telepulesID`, `name` FROM `templomok`";
	$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
	while ($row = mysqli_fetch_array($eredmeny))
	{
		$telname = null;
		$sqlegy = "SELECT `name` FROM `telepulesek` WHERE id = '".$row["telepulesID"]."'";
		$eredmenyegy = mysqli_query($mysql, $sqlegy) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
		while ($rowegy = mysqli_fetch_array($eredmenyegy))
		{
			$telname = $rowegy["name"];
		}
		?>
		<option value="<?php echo $row["id"]; ?>" <?php if ($row["id"] == $temp) { ?> selected <?php } ?>><?php echo $telname; ?> - <?php echo $row["name"]; ?></option>
		<?php
	}
	?>
 </select>
 <button type="submit" class="btn btn-primary text-white"><i class="bi bi-funnel"></i> Szűrés</button>
    </form>
    <?php
	if ($user == true) {
		?>
		<p>A szürkített szövegek azt jelzik, hogy az adott hirdetés nem látható jelenleg a nem bejelentkezett látogatók számára!</p>
		<?php
	}
    // TODO kimenetnél ellenőrizni, hogy tartalmaz-e veszélyes dolgokat (pl. script taget)
	$sql = "SELECT `ID`, `title`, `content`, `templomID`";
	if ($user == true) {
		$sql .= ", `starttime`, `endtime`";
	}
	$sql .= " FROM `hirdetesek`";
	if ($user == false) {
	$sql .= " WHERE ('".date_format(date_create(), "Y-m-d H:i:s")."' BETWEEN `starttime` AND `endtime`) OR (`starttime` < '".date_format(date_create(), "Y-m-d H:i:s")."' AND `endtime` IS NULL)"; }
    if ($temp != null && $user == false) {
		$sql .= " AND (`templomID` = '$temp' OR `templomID` IS NULL)";
    } else if ($temp != null && $user == true) {
		$sql .= " WHERE `templomID` = '$temp' OR `templomID` IS NULL";
	}
    $eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
    $first = true;
    while ($row = mysqli_fetch_array($eredmeny)) {
		if ($user == true) {
		$megjelenik = false;
		if (date_create($row["starttime"]) <=  date_create())
		{
			if ($row["endtime"] == null || date_create() <= date_create($row["endtime"])) {
				$megjelenik = true; } } }
        if ($first == true) {
            $first = false;
        } else {
            echo "<hr>";
        }
		global $rm;
		global $edit;
		$html = $row["content"];
        ?>
        <div class="hirdetes" id="<?php echo $row["ID"]; ?>">
            <h2 <?php if ($user == true && $megjelenik == false) { ?>style="opacity: 0.5;"<?php } ?>><?php echo $row["title"]; ?></h2>
            <div <?php if ($user == true && $megjelenik == false) { ?>style="opacity: 0.5;"<?php } ?>><?php echo $html; ?></div>
			<div style="margin-top: 30px;">
			<?php
			if ($user == true) {
				?>
					<p style="margin-bottom: 2px; <?php if ($user == true && $megjelenik == false) { ?>opacity: 0.5;<?php } ?>"><i>Megjelenés dátuma: <?php echo date_format(date_create($row["starttime"]), "Y. m. d. H:i"); ?>; Eltűnés dátuma: <?php if ($row["endtime"] == null) { echo "-"; } else { echo date_format(date_create($row["endtime"]), "Y. m. d. H:i"); } ?></i></p>
				<?php
			}
			?>
			<p <?php if ($user == true && $megjelenik == false) { ?>style="opacity: 0.5;"<?php } ?>><i>Templom, amelyre a hirdetés vonatkozik: <?php if ($row["templomID"] == null) { echo "mind"; } else { 
				$sqlc = "SELECT `telepulesID`, `name` FROM `templomok` WHERE `id` = '".$row["templomID"]."'";
				$eredmenyc = mysqli_query($mysql, $sqlc) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
				while ($rowc = mysqli_fetch_array($eredmenyc))
				{
					$telname = null;
					$sqlegy = "SELECT `name` FROM `telepulesek` WHERE id = '".$rowc["telepulesID"]."'";
					$eredmenyegy = mysqli_query($mysql, $sqlegy) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
					while ($rowegy = mysqli_fetch_array($eredmenyegy))
					{
						$telname = $rowegy["name"];
					}
					echo $telname;
					echo " - ";
					echo $rowc["name"];
				}
			 } ?>.</i></p></div>
			<div><?php if ($edit == true) { ?>
				<form action="edit.hirdetes.php" method="post" style="display: inline-block;">
					<input type="hidden" name="id" value="<?php echo $row["ID"]; ?>">
					<button type="submit" class="btn btn-primary text-white"><i class="bi bi-pencil"></i> Szerkesztés</button>
				</form>
			<?php } if ($rm == true) { ?>
				<form action="delete.hirdetes.php" method="post" style="display: inline-block;" id="deletehirdetes<?php echo $row['ID']; ?>">
					<input type="hidden" name="id" value="<?php echo $row["ID"]; ?>">
					<input type="hidden" name="stage" value="3">
					<input type="hidden" name="urlfrom" value="hirdetesek.php">
					<button type="button" class="btn btn-danger text-white" onclick="deletehirdetes(<?php echo $row['ID']; ?>)"><i class="bi bi-trash3"></i> Törlés</button>
				</form>
			<?php } ?></div>
        </div>
        <?php
    }
    ?>
</div>
</main>
<?php include("footer.php"); ?>
</body>
</html>