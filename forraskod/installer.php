<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Telepítés</title>
</head>
<body>
    <h1>Telepítés</h1>
    <!-- TODO meg kell adni a maximum értéket! -->
    <progress value="<?php if (isset($_POST["stage"])) { echo $_POST["stage"]; } else { echo "0"; } ?>" max="10"></progress>
    <?php
    if (!isset($_POST["stage"]))
    {
        $regex = ["mysql" => "^[a-zA-Z0-9 .\-]+$"];
        ?>
        <!-- TODO regex -->
        <h2>Adatbázis adatok megadása</h2>
        <p>A következőkben a MySQL adatbázisról láthat kérdéseket. Kezdésnek kérem hozzon létre egy üres adatbázist! Ajánlott, azonban nem kötelező létrehozni egy külön MySQL felhasználót ehhez az oldalhoz. Ez a felhasználó futtashasson minden parancsot a létrehozott adatbázisban.</p>
        <form name="database" action="#" method="POST">
        <table>
            <tr>
                <td><label>MySQL adatbázis helye: </label></td>
                <td><input type="text" name="mysqlhost" value="localhost" required autofocus pattern="<?php echo $regex["mysql"]; ?>"></td>
                <td>Ez általában localhost, ritkábban más.</td>
            </tr>
            <tr>
                <td><label>MySQL felhasználó: </label></td>
                <td><input type="text" name="mysqlusername" required pattern="<?php echo $regex["mysql"]; ?>"></td>
                <td></td>
            </tr>
            <tr>
                <td><label>MySQL jelszó: </label></td>
                <td><input type="password" name="mysqlpassword" required></td>
                <td></td>
            </tr>
            <tr>
                <td><label>MySQL adatbázis neve: </label></td>
                <td><input type="text" name="mysqldb" required pattern="<?php echo $regex["mysql"]; ?>"></td>
                <td>Ennek az adatbázisnak már léteznie kell!</td>
            </tr>
        </table>
        <input type="hidden" name="stage" value="1">
        <input type="submit" value="Tovább">
        </form>
        <?php
    }
    if (isset($_POST["stage"]))
    {
        if ($_POST["stage"] == "1")
        {
            //TODO regex
            $host = $_POST["mysqlhost"];
            $uname = $_POST["mysqlusername"];
            $pwd = $_POST["mysqlpassword"];
            $db = $_POST["mysqldb"];
            $mysqlconn = mysqli_connect($host, $uname, $pwd, $db);
            if ($mysqlconn == true)
            {
                ?>
                <p class="succes">Sikeres kapcsolódás az adatbázishoz!</p>
                <?php
                $configfile = fopen("config.php", "w");
                $towrite = "<?php\n\$mysqlhost = '";
                $towrite .= $host;
                $towrite .= "';\n\$mysqlu = '";
                $towrite .= $uname;
                $towrite .= "';\n\$mysqlp = '";
                $towrite .= $pwd;
                $towrite .= "';\n\$mysqld = '";
                $towrite .= $db;
                $towrite .= "';\n?>";
                fwrite($configfile, $towrite);
                $defconf = file_get_contents("default.config.php");
                fwrite($configfile, $defconf);
                fclose($configfile);
            } else {
                ?>
                <p class="warning">Sikertelen kapcsolódás az adatbázishoz!</p>
                <form action="#" method="post">
                    <input type="submit" value="Újrapróbálás">
                </form>
                <?php
            }
        }
    }
    ?>
</body>
</html>