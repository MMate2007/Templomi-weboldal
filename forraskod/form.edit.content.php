<?php ob_start(); ?>
<!DOCTYPE html>
<html>
<head>
<?php include ("head.php"); ?>
<title>Tartalom szerkesztése - <?php echo $sitename; ?></title>
<meta name="language" content="hu-HU">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta charset="utf-8">

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
<h1><?php echo $sitename; ?> honlapja - Tartalom szerkesztése</h1>
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
<form name="edit.content" method="post" action="form2.edit.content.php">
    <table>
        <tr>
            <td><label>Szerkesztendő tartalom: </label></td>
            <td>
                <select name="idname">
                    <?php
                    $mysql = mysqli_connect("localhost", "filia", "borszorcsokfilia8479", "filia") or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
                    mysqli_query($mysql, "SET NAMES utf8");
                    $sql = "SELECT `name` FROM `contents`";
                    $eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
                    while ($row = mysqli_fetch_array($eredmeny))
                    {
                        $name = $row["name"];
                        $sql = "SELECT `name` FROM `contentsname` WHERE `idname` = '".$name."'";
                        $eredmenyb = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
                        while ($rowb = mysqli_fetch_array($eredmenyb))
                        {
                            $nameb = $rowb["name"];
                            ?>
                            <option value="<?php echo $name; ?>"><?php echo $nameb; ?></option>
                            <?php
                        }
                    }
                    
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td><label></label></td>
            <td><input type="submit" value="Tovább"></td>
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