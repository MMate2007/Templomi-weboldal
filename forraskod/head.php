<?php
//TODO funkció hozzáadása: PDF generálása a szertartásokból (ld. ajkai plébániai hirdetések)
//TODO weboldal tesztelése Bootstrappel
include("config.php"); 
if (isset($_COOKIE['enablecookie'])) { session_start(); }
?>
<meta charset="utf-8">
<meta name="language" content="hu-HU">
<!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>-->
<link rel="stylesheet" href="style.css">
<link rel="icon" type="image/pnp" href="icon.png">
<?php 
if ($themecolor != null)
{
    ?>
    <meta name="theme-color" content="<?php echo $themecolor; ?>">
    <?php
}
$mysql = mysqli_connect($mysqlhost, $mysqlu, $mysqlp, $mysqld) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
mysqli_query($mysql, "SET NAMES utf8");
//Webhelyadatok betöltése
$sitename = getsetting($mysql, "main.name");

function getsetting ($mysqlconn, $settingname) {
    global $mysql;
    $greturn = null;
    $gsql = "SELECT `value` FROM `settings` WHERE `name` = '".$settingname."'";
    $geredmeny = mysqli_query($mysql, $gsql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysqlconn)."</p>");
	while ($grow = mysqli_fetch_array($geredmeny))
	{
		$greturn = $grow["value"];
	}
    return $greturn;
}
function displaymessage() {
    if (isset($_GET["messagetype"]) && isset($_GET["message"])) {
        ?>
        <p class="<?php echo $_GET["messagetype"]; ?>"><?php echo $_GET["message"]; ?></p>
        <?php
    }
}
function getheadimage() {
    global $mysql;
    $picture = basename(htmlspecialchars($_SERVER['PHP_SELF']));
    $image = getsetting($mysql, 'picture.'.$picture.'');
	if ($image == null)
	{
		echo "defaultparallax.jpg";
	} else {
		echo $image;
	}
}
function correct($txt) {
    return htmlspecialchars(stripslashes(trim($txt)));
}
$htmlregexlist = ["name" => "^[a-zA-Z .-]+$", "dateinput" => "^[0-9 T:-]{11,}$", "dateoutput" => "^[0-9 \.:-]{12,}$", "colorhex" => "^#[0-9A-F]{3,6}$", "styleexpression" => "^[a-z :;-]*$", "email" => "^[a-z0-9._+-]+[@][a-z.]+$"];
//TODO check függvény befejezése, ennek azt kell csinálnia, hogy a $txt az ellenőrizendő szöveg, a $tipus pedig, hogy milyen szöveg (pl. név, email) és a switch-csel a megfelelő preg_match() vagy filter_var() függvényt hajtja végre és annak alapján visszatér egy igaz/hamis értékkel
function check($txt, $tipus) {
    $regexkelle = false;
    $filterkelle = false;
    $filterid = 0;
    $regex = null;
    $valid = false;
    global $regexlist;
    switch($tipus) {
        case 'name':
            $regexkelle = true;
            $regex = "/^[a-z .-]+$/i";
            //$regex = $regexlist["name"];
            break;
        case "email":
            $filterkelle = true;
            $filterid = FILTER_VALIDATE_EMAIL;
            break;
        case "dateinput":
            $regexkelle = true;
            $regex = "/^[0-9 T:-]{11,}$/i";
            //$regex = $regexlist["dateinput"];
            break;
        case "dateoutput":
            $regexkelle = true;
            $regex = "/^[0-9 \.:-]{12,}$/i";
            //$regex = $regexlist["dateoutput"];
            break;
        case "colorhex":
            $regexkelle = true;
            $regex = "/^#[0-9A-F]{3,6}$/i";
            //$regex = $regexlist["colorhex"];
            break;
        case "styleexpression":
            $regexkelle = true;
            $regex = "/^[a-z :;-]*$/i";
            //$regex = $regexlist["styleexpression"];
            break;
    }
    if ($regexkelle == true)
    {
        if (preg_match($regex, $txt))
        {
            $valid = true;
        }
    }
    if ($filterkelle == true)
    {
        if (filter_var($txt, $filterid))
        {
            $valid = true;
        }
    }
    return $valid;
}
?>