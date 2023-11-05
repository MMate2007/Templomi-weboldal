<?php ob_start(); ?>
<!DOCTYPE html>
<html>
<head>
<?php
include("head.php"); 
if (isset($_SESSION["userId"])) {
    include("headforadmin.php");
}
?>
<?php
$url = correct($_GET["page"]);
$sql = "SELECT `title`, `content`, `lastupdated`, `coverimgpath`";
if (isset($_SESSION["userId"])) {
    $sql .= ", `id`";
}
$sql .= " FROM `oldalak` WHERE `url` = '$url'";
$eredmeny = mysqli_query($mysql, $sql);
$row = mysqli_fetch_array($eredmeny);
?>
<title><?php echo correct($row["title"]); ?> - <?php echo $sitename; ?></title>
<meta name="title" content="<?php echo correct($row["title"]); ?> - <?php echo $sitename; ?>">
<meta name="language" content="hu-HU">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script>
	function deletepage() {
		var remove = confirm("Biztosan törölni szeretné ezt az oldalt?");
		if (remove) {
			document.querySelector("#deletepage").submit();
		}
	}
</script>

</head>
<body>
<?php
if ($row["coverimgpath"] == null) {
    $img = null;
} else {
$img = correct($row["coverimgpath"]); }
displayhead(correct($row["title"]), $img);
?>
<main class="container" style="padding: 30px 0px;">
<?php
if (isset($_SESSION["userId"])) {
if (checkpermission("editpage")) {
		?>
		<div>
            <form action="edit.page.php" method="post">
                <input type="hidden" name="id" value="<?php echo $row["id"]; ?>">
            <button class="btn btn-primary text-white float-end" type="submit"><i class="bi bi-pencil"></i> Szerkesztés</button>
            </form>
        </div>
		<?php
	}
if (checkpermission("editpage")) {
		?>
		<div>
            <form action="delete.page.php" method="post" id="deletepage">
                <input type="hidden" name="id" value="<?php echo $row["id"]; ?>">
            <button class="btn btn-danger text-white float-end" onclick="deletepage()" type="button"><i class="bi bi-trash3"></i> Törlés</button>
            </form>
        </div>
		<?php
	} 
}
?>
    <?php
    echo $row["content"];
    ?>
    <div id="lastupdated">
        <p style="font-style: italic;">Utoljára frissítve: <?php
        $date = correct($row["lastupdated"]);
        if (check($date, "dateoutput")) {
            echo $date;
        }
        ?></p>
    </div>
</main>
<?php include("footer.php"); ?>
</body>
</html>