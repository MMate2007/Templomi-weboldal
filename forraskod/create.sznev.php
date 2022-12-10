<?php ob_start(); ?>
<html>
<head>
<?php include("head.php"); ?>
<title>Litrugia típus hozzáadása - <?php echo $sitename; ?></title>
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
<h1><?php echo $sitename; ?> honlapja - Liturgia típus hozzáadása</h1>
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
<div class="content">
<div class="tartalom">
<?php
if (!isset($_POST["stage"]))
{
    ?>
    <!--<form name="create-sznev" action="create.sznev.php" method="post">-->
    <form name="create-sznev" action="#" method="post">
    <table class="form">
        <tr>
            <td><label>Szertartás típusának megnevezése: </label></td>
            <td><input type="text" name="name" required autofocus pattern="<?php echo $htmlregexlist["name"]; ?>"></td>
            <td>Példák: szentmise, litánia, szentségimádás.</td>
        </tr>
    <tr>
    <td><label></label></td>
    <td><input type="submit" value="Hozzáadás"></td>
    <td><label></label></td>
    </tr>
    </table>
    <input type="hidden" name="stage" value="2">
    </form>
    <?php
} else if (isset($_POST["stage"]))
{
    if (correct($_POST["stage"]) == "2")
    {
        $name = correct($_POST["name"]);
        $sql = "SELECT `id` FROM `sznev`";
        $id = 0;
        $eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
        while ($row = mysqli_fetch_array($eredmeny))
        {
            $_id = $row['id'];
            $id = $_id + 1;
        }
        $sql = "INSERT INTO `sznev`(`id`, `name`) VALUES ('".$id."','".$name."')";
        $eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
        if ($eredmeny == true)
        {
            ?>
            <p class="succes">Sikeres létrehozás!</p>
            <?php
        }else{
            ?>
            <p class="warning">Valami hiba történt!</p>
            <?php
        }
    }
}
?>
</div>
</div>
<div class="sidebar">
</div>
<?php include("footer.php"); ?>
</body>
</html>