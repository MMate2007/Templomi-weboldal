<html>
<head>
<?php include("head.php"); ?>
<title>Hirdetés létrehozása - <?php echo $sitename; ?></title>
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
<h1><?php echo $sitename; ?> honlapja - Hirdetés létrehozása</h1>
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
if (!isset($_POST["stage"])) {
?>
<!--<form name="create-hirdetes" action="form2.create.hirdetes.php" method="post">-->
<form name="create-hirdetes" action="#" method="post">
<table class="form">
<tr>
<td><label>Cím: </label></td>
<td><input type="text" name="title" <?php if (isset($_POST["title"])): ?>value="<?php echo $_POST["title"]; ?>"<?php endif ?> required autofocus></td>
<td><label>Pl.: Megváltozik a csütörtöki szentmisék időpontja!</label></td>
</tr>
<tr>
<td><label>Tartalom: </label></td>
<td><textarea name="content" required>
    <?php
    if (isset($_POST["content"]))
    {
        echo $_POST["content"];
    }
    ?>
</textarea></td>
<td><label>Hosszú vagy rövid leírás, felhívás.</label></td>
</tr>
<tr>
<td><label>Megjelenés időpontja: </label></td>
<td><input type="datetime-local" name="starttime" value="<?php if (isset($_POST["starttime"])) {echo $_POST["starttime"];} else {echo date("Y-m-d H:i");}?>"></td>
<td><label>Az az időpont, mikortól a hirdetés láthatóvá válik.</label></td>
</tr>
<tr>
<td><label></label></td>
<td><input type="submit" value="Tovább"></td>
<td><label></label></td>
</tr>
</table>
<input type="hidden" name="stage" value="2">
</form>
<?php
} else if (isset($_POST["stage"]))
{
    if (correct($_POST["stage"]) == 2)
    {
        $title = $_POST["title"];
        $content = $_POST["content"];
        $s = $_POST["starttime"].":00";
        $starttime = str_replace("T", " ", $s);
        ?>
        <p>Megjelenés időpontja: <?php echo $starttime; ?>
        <p>Előnézet:</p>
        <div class="hirdetotabla">
        <h3 class="hirdetotabla"><?php echo $title; ?></h3>
        <p class="hirdetotabla"><?php echo $content; ?></p>
        </div>
        <!--<form name="create-hirdetes-elonezet" action="create.hirdetes.php" method="post">-->
        <form name="create-hirdetes-elonezet" action="#" method="post">
        <table class="form">
        <input type="hidden" name="title" value="<?php echo $title; ?>">
        <input type="hidden" name="content" value="<?php echo $content; ?>">
        <input type="hidden" name="starttime" value="<?php echo $starttime; ?>">
        <input type="hidden" name="stage" value="3">
        <tr>
        <td><label></label></td>
        <td><input type="submit" value="Közzététel"></form><form action="#" method="post"><input type="hidden" name="title" value="<?php echo $title; ?>">
        <input type="hidden" name="content" value="<?php echo $content; ?>"><input type="hidden" name="starttime" value="<?php echo str_replace(" ", "T", $starttime); ?>"><input type="submit" value="Vissza"></form></td>
        <td><label></label></td>
        </tr>
        </table>
        </form>
        <?php
    }
    if (correct($_POST["stage"]) == 3)
    {
        $title = $_POST["title"];
        $content = $_POST["content"];
        $starttime = $_POST["starttime"];
        $sql = "SELECT `ID` FROM `hirdetesek`";
        $id = 0;
        $eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
        while ($row = mysqli_fetch_array($eredmeny))
        {
            $_id = $row['ID'];
            $id = $_id + 1;
        }
        $sql = "INSERT INTO `hirdetesek`(`ID`, `title`, `content`, `authorid`, `starttime`) VALUES ('".$id."','".$title."','".$content."','".$_SESSION["userId"]."', '".$starttime."')";
        $eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
        ?>
        <?php
        if ($eredmeny == true)
        {
            ?>
            <p class="succes">Sikeres publikáció!</p>
            <form name="create-hirdetes" action="#" method="post">
            <table class="form">
            <tr>
            <td><label>Cím: </label></td>
            <td><input type="text" name="title"></td>
            <td><label>Pl.: Megváltozik a csütörtöki szentmisék időpontja!</label></td>
            </tr>
            <tr>
            <td><label>Tartalom: </label></td>
            <td><textarea name="content"></textarea></td>
            <td><label>Hosszú vagy rövid leírás, felhívás.</label></td>
            </tr>
            <tr>
            <td><label>Megjelenés időpontja: </label></td>
            <td><input type="datetime-local" name="starttime"></td>
            <td><label>Az az időpont, mikortól a hirdetés láthatóvá válik.</label></td>
            </tr>
            <tr>
            <td><label></label></td>
            <td><input type="submit" value="Tovább"></td>
            <td><label></label></td>
            </tr>
            </table>
            <input type="hidden" name="stage" value="2">
            </form>
            <?php
        }else{
            ?>
            <p class="warning">Valami hiba történt!</p>
            <p>Kérem, próbálja újra!</p>
            <form action="#" method="post">
            <input type="hidden" name="stage" value="3">
            <input type="hidden" name="title" value="<?php echo $title; ?>">
            <input type="hidden" name="content" value="<?php echo $content; ?>">
            <input type="hidden" name="starttime" value="<?php echo $starttime; ?>">
            <input type="submit" value="Újrapróbálkozás">
            </form>
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