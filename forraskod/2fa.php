<?php ob_start(); ?>
<!DOCTYPE html>
<html>
<head>
<?php include("head.php");
require __DIR__ . '/vendor/autoload.php';
use PragmaRX\Google2FA\Google2FA;
$fa = new Google2FA();
?>
<title>Bejelentkezés - <?php echo $sitename; ?></title>
<meta name="title" content="Bejelentkezés - <?php echo $sitename; ?>">
<meta name="description" content="Bejelentkezés után szerkeszteni tudja az oldal bizonyos pontjait. Ha Ön is szeretne segíteni a weboldal jobbá tételében írjon a <?php echo getsetting('main.email'); ?> e-mail címre!">
<meta name="language" content="hu-HU">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
html, body {
    height: 100%;
    min-height: 100%;
    margin: 0;
    padding: 0;
    background-image: url("<?php echo getheadimage(); ?>");
    background-position: center;
    background-size: cover;
    background-repeat: no-repeat;
}
div.container {
    background-color: rgba(255, 255, 255, 0);
}
</style>
</head>
<body>
    <?php
            $height = "35%";
            $bgimg = getheadimage();
        ?>
        <header style="height: <?php echo $height; ?>;" class="mask">
        <div class="head h-100">
        <div class="fejlecparallax text-center bg-image h-100">
        <?php
        include("navbar.php");
        ?>
        </div>
        </div>
        </div>
        </header>
    <!-- <main class="content"> -->
    <div class="mask" style="height: 65%;">
        <div class="container glass" style="width: max-content; padding: 2.5%;">
            <h1 class="text-white text-center">Bejelentkezés</h1>
            <p class="text-white">Mivel bekapcsolta a kétlépcsős azonosítást, kérem adja meg a 6 jegyű számot.</p>
        <!-- <p class="text-center">Ha szeretné szerkeszteni a weboldal tartalmát kérem jelentkezzen be az alábbi űrlap segítségével!</p> -->
        <form name="login2fa" action="#" method="post" id="login2fa">
            <div class="row justify-content-center">
                <div class="col">
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-123"></i></span>
                        <input type="text" name="2fa" id="twofa" class="form-control" required placeholder="123456">
                    </div>
                    <div class="input-group justify-content-center"><button type="submit" class="btn btn-primary text-white btn-block"><i class="bi bi-box-arrow-in-right"></i> Tovább</button></div>
                </div>
            </div>
            <input type="hidden" name="stage" value="1">
        </form>
        </div>
        <!-- </main> -->
        <?php
        if (isset($_POST["stage"]))
        {
            if ($_POST["stage"] == 1) {
            //TODO check() függvén beépítése a bemenet ellenőrzésére
            if (isset($_POST["message"])) {
                displaymessage("danger", $_POST["message"]);
            }
            echo "stage1";
            $sql = "SELECT * FROM `author` WHERE `id` = '".$_SESSION["uid"]."'";
            $eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
            while ($row = mysqli_fetch_array($eredmeny))
            {
                $twofa = $row["2fasecret"];
                $name = $row["name"];
                $egyhsz = $row["egyhaziszint"];
                echo "2fasecret";
                if ($fa->verifyKey($twofa, $_POST["2fa"])) {
                    echo "Sikerült!";
                    $sqla = "SELECT `bejelentkezes` FROM `engedelyek` WHERE `userId` = '".$_SESSION["uid"]."'";
                    $eredmenya = mysqli_query($mysql, $sqla) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
                    while ($row = mysqli_fetch_array($eredmenya))
                    {
                        echo "While";
                        if ($row["bejelentkezes"] == 1)
                        { echo "bejelentkezes1";
                            $_SESSION["userId"] = $_SESSION["uid"];
                            $_SESSION["name"] = $name;
                            $_SESSION["egyhszint"] = $egyhsz;
                            header("Location: admin.php");
                            exit();
                        } else {
                            displaymessage("warning", "Ön nem jelentkezhet be, mert fiókját ideiglenesen letiltották!");
                        }
                    } 
                } else {
                    echo "Nem jó";
                    formvalidation("#twofa", false, "Helytelen kód.");
                }
            }
            }
        }
        if (isset($_SESSION["userId"]))
        {
            header("Location: admin.php");
        }
        ?>
    </div>
<!-- <?php //include("footer.php"); ?> -->
</body>
</html>