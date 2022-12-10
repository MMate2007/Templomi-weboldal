<html>
<head>
<?php include("head.php"); ?>
<title>Templom hozzáadása - <?php echo $sitename; ?></title>
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
<h1><?php echo $sitename; ?> honlapja - Templom hozzáadása</h1>
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
    <!--<form name="create-templom" action="create.templom.php" method="post">-->
    <form name="create-templom" action="#" method="post">
    <table class="form">
        <tr>
            <td><label>Templom/kápolna neve: </label></td>
            <td><input type="text" name="name" required autofocus></td>
        </tr>
        <tr>
            <td>Település ahová tartozik: </td>
            <td>
                <select name="telepules" required>
                    <option value="semmi">--Kérem válasszon--</option>
                    <?php
                    $sql = "SELECT * FROM `telepulesek`";
                    $eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
                    while ($row = mysqli_fetch_array($eredmeny))
                    {
                        $id = $row["id"];
                        $name = $row["name"];
                        ?>
                        <option value="<?php echo $id; ?>"><?php echo $name; ?></option>
                        <?php
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td><label>Védőszent: </label></td>
            <td><input type="text" name="szent"></td>
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
} else if (isset($_POST))
{
    if (correct($_POST["stage"]) == "2")
    {
        $name = correct($_POST["name"]);
        $tel = correct($_POST["telepules"]);
        $szent = correct($_POST["szent"]);
        if ($tel == "semmi")
        {
            ?>
            <p class="warning">Nem lett kiválasztva a település!</p>
            <form name="create-templom" action="#" method="post">
            <table class="form">
                <tr>
                    <td><label>Templom/kápolna neve: </label></td>
                    <td><input type="text" name="name" value="<?php echo $name; ?>"></td>
                </tr>
                <tr>
                    <td>Település ahová tartozik: </td>
                    <td>
                        <select name="telepules">
                            <option value="semmi">--Kérem válasszon--</option>
                            <?php
                            $sql = "SELECT * FROM `telepulesek`";
                            $eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
                            while ($row = mysqli_fetch_array($eredmeny))
                            {
                                $id = $row["id"];
                                $name = $row["name"];
                                ?>
                                <option value="<?php echo $id; ?>"><?php echo $name; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><label>Védőszent: </label></td>
                    <td><input type="text" name="szent" value="<?php echo $szent; ?>"></td>
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
        } else {
            if ($szent == "") {$szent = null;}
            $sql = "SELECT `id` FROM `templomok`";
            $id = 0;
            $eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
            while ($row = mysqli_fetch_array($eredmeny))
            {
                $_id = $row['id'];
                $id = $_id + 1;
            }
            $sql = "INSERT INTO `templomok`(`id`, `telepulesID`, `name`, `vedoszent`) VALUES ('".$id."','".$tel."','".$name."','".$szent."')";
            $eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
            if ($eredmeny == true)
            {
                ?>
                <p class="succes">Sikeres létrehozás!</p>
                <?php
            }else{
                ?>
                <p class="warning">Valami hiba történt!</p>
                <form name="create-templom" action="#" method="post">
                <table class="form">
                    <tr>
                        <td><label>Templom/kápolna neve: </label></td>
                        <td><input type="text" name="name"></td>
                    </tr>
                    <tr>
                        <td>Település ahová tartozik: </td>
                        <td>
                            <select name="telepules">
                                <option value="semmi">--Kérem válasszon--</option>
                                <?php
                                $sql = "SELECT * FROM `telepulesek`";
                                $eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
                                while ($row = mysqli_fetch_array($eredmeny))
                                {
                                    $id = $row["id"];
                                    $name = $row["name"];
                                    ?>
                                    <option value="<?php echo $id; ?>"><?php echo $name; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label>Védőszent: </label></td>
                        <td><input type="text" name="szent"></td>
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
            }
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