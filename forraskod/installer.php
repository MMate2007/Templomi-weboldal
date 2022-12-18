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
    $regex = ["mysql" => "^[a-zA-Z0-9 .\-]+$", "name" => "^[a-zA-Z .-]+$"];
    if (!isset($_POST["stage"]))
    {
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
            $host = htmlspecialchars(stripslashes(trim($_POST["mysqlhost"])));
            $uname = htmlspecialchars(stripslashes(trim($_POST["mysqlusername"])));
            $pwd = $_POST["mysqlpassword"];
            $db = htmlspecialchars(stripslashes(trim($_POST["mysqldb"])));
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
                $sql = file_get_contents("tabla.sql");
                $eredmeny = mysqli_multi_query($mysqlconn, $sql);
                if ($eredmeny == true)
                {
                    ?>
                    <p class="success">Táblák sikeresen létrehozva.</p>
                    <form action="#" method="post">
                        <input type="hidden" name="stage" value="2">
                        <input type="submit" value="Tovább a következő lépésre">
                    </form>
                    <?php
                } else {
                    echo mysqli_error($mysqlconn);
                    ?>
                    <p class="warning">Nem sikerült létrehozni a táblákat! Kérem, hogy a tabla.sql-t futtassa a PHPMyAdminban, vagy a terminálban!</p>
                    <?php
                }
            } else {
                ?>
                <p class="warning">Sikertelen kapcsolódás az adatbázishoz!</p>
                <form action="#" method="post">
                    <input type="submit" value="Újrapróbálás">
                </form>
                <?php
            }
            mysqli_close($mysqlconn);
        }
        if ($_POST["stage"] == 2) {
            ?>
            <h2>Admin felhasználó létrehozása</h2>
            <p>A következőkben, kérem, válaszoljon az adminisztrátori felhasználói fiókra vonatkozó kérdésekre!</p>
            <form action="#" method="POST">
                <table>
                    <tr>
                        <td><label>Felhasználónév: </label></td>
                        <td><input type="text" name="username" required auto-focus pattern="<?php echo $regex["mysql"]; ?>"></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><label>Jelszó: </label></td>
                        <td><input type="password" name="password" required></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><label>Jelszó újra: </label></td>
                        <td><input type="password" name="password2" required></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><label>Teljes/megjelenítendő név: </label></td>
                        <td><input type="text" name="name" required pattern="<?php echo $regex["name"]; ?>"></td>
                        <td>Ez a név fog megjelenni pl. bejegyzéseknél.</td>
                    </tr>
                    <tr>
                        <td><label>Egyházi titulus: </label></td>
                        <td><select name="egyhazi" required><option value="0">Egyéb egyházi személy</option><option value="1">Kántor</option><option value="2">Pap</option></select></td>
                        <td>Ez azért kell, hogy releváns tartalom jelenhessen meg a bejelentkezési oldalon, pl. a pap magához rendelheti a misét, vagy a kántornak a hozzá rendelt miséknél nem írja ki a kántort (hiszen az maga), hanem a celebránst.</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" value="Felhasználó létrehozása"></td>
                        <td></td>
                    </tr>
                    <input type="hidden" name="stage" value="3">
                </table>
            </form>
            <?php
        }
        if ($_POST["stage"] == 3)
        {
            //TODO regex ellenőrzés!
            $uname = $_POST["username"];
            $pass = $_POST["password"];
            $pass2 = $_POST["password2"];
            $fullname = $_POST["name"];
            $egyhazi = $_POST["egyhazi"];
            if ($pass == $pass2) {
                include("config.php");
                $mysql = mysqli_connect($mysqlhost, $mysqlu, $mysqlp, $mysqld) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
                mysqli_query($mysql, "SET NAMES utf8");
                //TODO új enegdélyrendszer kezelése
                //! FIXME új jelszó titkosítási módszer kitalálása
                $sql = "INSERT INTO `author`(`id`, `name`, `password`, `username`, `egyhaziszint`) VALUES ('0','$fullname','".sha1(md5($pass))."','$uname','$egyhazi')";
                if (mysqli_query($mysql, $sql))
                {
                    ?>
                    <p class="success">Admin felhasználó sikeresen létrehozva.</p>
                    <form action="#" method="POST">
                        <input type="submit" value="Tovább a következő lépésre">
                        <input type="hidden" name="stage" value="4">
                    </form>
                    <?php
                }
            } else {
                ?>
                <h2>Admin felhasználó létrehozása</h2>
                <p>A következőkben, kérem, válaszoljon az adminisztrátori felhasználói fiókra vonatkozó kérdésekre!</p>
                <form action="#" method="POST">
                    <table>
                        <tr>
                            <td><label>Felhasználónév: </label></td>
                            <td><input type="text" name="username" value="<?php echo $_POST["username"]; ?>" required auto-focus pattern="<?php echo $regex["mysql"]; ?>"></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><label>Jelszó: </label></td>
                            <td><input type="password" name="password" required></td>
                            <td><span style="color:red;">A két jelszó nem egyezik!</span></td>
                        </tr>
                        <tr>
                            <td><label>Jelszó újra: </label></td>
                            <td><input type="password" name="password2" required></td>
                            <td><span style="color:red;">A két jelszó nem egyezik!</span></td>
                        </tr>
                        <tr>
                            <td><label>Teljes/megjelenítendő név: </label></td>
                            <td><input type="text" name="name" value="<?php echo $_POST["name"]; ?>" required pattern="<?php echo $regex["name"]; ?>"></td>
                            <td>Ez a név fog megjelenni pl. bejegyzéseknél.</td>
                        </tr>
                        <tr>
                            <td><label>Egyházi titulus: </label></td>
                            <td><select name="egyhazi" required><option value="0">Egyéb egyházi személy</option><option value="1">Kántor</option><option value="2">Pap</option></select></td>
                            <td>Ez azért kell, hogy releváns tartalom jelenhessen meg a bejelentkezési oldalon, pl. a pap magához rendelheti a misét, vagy a kántornak a hozzá rendelt miséknél nem írja ki a kántort (hiszen az maga), hanem a celebránst.</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><input type="submit" value="Felhasználó létrehozása"></td>
                            <td></td>
                        </tr>
                        <input type="hidden" name="stage" value="3">
                    </table>
                </form>
                <?php
            }
        }
    }
    ?>
</body>
</html>