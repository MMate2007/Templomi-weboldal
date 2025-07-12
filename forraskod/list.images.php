<?php ob_start(); ?>
<!DOCTYPE html>
<html>
<head>
<?php include("head.php"); ?>
<title>Fényképek - <?php echo $sitename; ?></title>
<meta name="language" content="hu-HU">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
    img {
        max-width: 20%;
    }
</style>
</head>
<body class="d-flex flex-column h-100">
<?php
displayhead("Fényképek");
include("headforadmin.php");
?>
<div id="messagesdiv">
	<?php
	Message::displayall();
	if (!checkpermission("removefile")){
		displaymessage("danger", "Nincs jogosultsága fényképek listázásához és törléséhez!");
		exit;
	}
	?>
</div>
<main class="container">
<div class="table-responsive">
    <table>
        <thead>
            <th>Kép</th>
            <th>Leírás</th>
            <th>Méret</th>
            <th>Műveletek</th>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM `kepek`";
            $result = mysqli_query($mysql, $sql);
            while ($row = mysqli_fetch_array($result)) {
                $size = filesize($row["description"]);
                ?>
                <tr>
                    <td><img src="<?php echo $row["src"]; ?>"></td>
                    <td><?php echo $row["description"]; ?></td>
                    <td><?php echo $size; ?> B</td>
                    <td>
                        <form action="delete.image.php" method="post">
					        <input type="hidden" name="src" value="<?php echo $row["src"]; ?>">
					        <button type="submit" class="btn btn-danger"><i class="bi bi-trash3"></i> Törlés</button>
				        </form>
                    </td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
</div>
</main>
<?php include("footer.php"); ?>
</body>
</html>