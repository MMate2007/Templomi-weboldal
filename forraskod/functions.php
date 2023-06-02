<?php
// TODO deletehirdetesek funkció elkészítése a már nem érvényes hirdetések törlésére
function redirectback() {
    global $_POST;
    if (isset($_POST["urlfrom"])) {
    header("Location: ".$_POST["urlfrom"]); }
}
$penzugyidb = null;
function connectpenzugyidb() {
    global $penzugyidb;
    global $penzugyidbhost;
    global $penzugyidbu;
    global $penzugyidbp;
    global $penzugyidbd;

    if (isset($penzugyidbhost) && isset($penzugyidbu) && isset($penzugyidbp) && isset($penzugyidbd)) {
        $penzugyidb = mysqli_connect($penzugyidbhost, $penzugyidbu, $penzugyidbp, $penzugyidbd) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($penzugyidb)."</p>");
        mysqli_query($penzugyidb, "SET NAMES utf8");
    }
}
/**
 * Kitölti az szövegbeviteli mezőket a $POST-ból
 *
 * Kiírja a value argumentumot és megtölti értékkel
 * @param string $name A kitöltendő HTML elem name értéke
 * @return void
 */
function autofill(string $name) {
    if (isset($_POST[$name])) {
        echo "value='".correct($_POST[$name])."'";
    }
}
/**
 * Kitölti a HTML legördülő lista típusú űrlapelemeket a $POST-ból
 *
 * Ha az adott POST érték megegyezik a $value változó tartalmával, akkor kiírja, hogy selected
 * @param string $post HTML elem name értéke
 * @param mixed $value Az érték, amit ha felvesz a HTML elem, akkor kiírjuk, hogy selected
 * @return void
 */
function autofillselect(string $post, $value) {
    if (isset($_POST[$post])) { if ($_POST[$post] == $value) { echo "selected"; } }
}
/**
 * Kitölti a HTML checkbox típusú űrlapelemeket a $POST-ból
 *
 * Ha az adott POST érték megegyezik a $value változó tartalmával, akkor kiírja, hogy checked
 * @param string $post HTML elem name értéke
 * @param mixed $value Az érték, amit ha felvesz a HTML elem, akkor kiírjuk, hogy checked
 * @return void
 */
function autofillcheck(string $post, $value) {
    if (isset($_POST[$post])) { if ($_POST[$post] == $value) { echo "checked"; } }
}
/**
 * Visszadja, hogy a **bejelentkezett** felhasználónak van-e jogosultsága a $premission-ban leírt jogra
 *
 * @param string $premission Jogosultság neve
 * @return void
 */
function checkpermission(string $premission) {
    global $mysql;
    $sqlp = "SELECT `$premission` FROM `engedelyek` WHERE `userId` = '".$_SESSION["userId"]."'";
    $eredmenyp = mysqli_query($mysql, $sqlp) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
    while ($rowp = mysqli_fetch_array($eredmenyp)) {
        return $rowp[$premission];
    }
}
function getsetting (string $settingname) {
    global $mysql;
    $greturn = null;
    $gsql = "SELECT `value` FROM `settings` WHERE `name` = '".$settingname."'";
    $geredmeny = mysqli_query($mysql, $gsql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
	while ($grow = mysqli_fetch_array($geredmeny))
	{
		$greturn = $grow["value"];
	}
    return $greturn;
}
function getcontent (string $contentname) {
    global $mysql;
    $greturn = null;
    $gsql = "SELECT `value` FROM `content` WHERE `name` = '".$contentname."'";
    $geredmeny = mysqli_query($mysql, $gsql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
	while ($grow = mysqli_fetch_array($geredmeny))
	{
		$greturn = $grow["value"];
	}
    return $greturn;
}
function displaymessage(string $type, string $msg) {
    echo "<div class='container'><p class='alert alert-$type'>$msg</p></div>";
}
function getheadimage() {
    global $mysql;
    $picture = basename(htmlspecialchars($_SERVER['PHP_SELF']));
    $image = getsetting('picture.'.$picture.'');
	if ($image == null or $image == "")
	{
		$image = getsetting("picture.default");
        if ($image == null or $image == "") {
            return "img/defaultparallax.jpg";
        } else {
            return $image;
        }
	} else {
		return $image;
	}
}
function formvalidation(string $formelement, bool $valid, $msg = null) {
    ?>
    <script defer>
       document.querySelector('<?php echo $formelement; ?>').classList.add('<?php echo ($valid == true) ? "is-valid" : "is-invalid"; ?>');
       <?php
       if ($msg != null) {
        ?>
        msgdivek.push(document.createElement("div"));
        <?php if ($valid == false) { ?>
        msgdivek[msgdivek.length-1].classList.add("invalid-feedback");
        msgdivek[msgdivek.length-1].classList.add("col-sm");
        <?php } else { ?>msgdivek[msgdivek.length-1].classList.add("valid-feedback"); msgdivek[msgdivek.length-1].classList.add("col-sm");<?php } ?>
        msgdivek[msgdivek.length-1].innerHTML = "<?php echo $msg; ?>";
        document.querySelector("<?php echo $formelement; ?>").parentNode.insertBefore(msgdivek[msgdivek.length-1], document.querySelector("<?php echo $formelement; ?>").nextSibling);
        <?php
       }
       ?>
    </script>
    <?php
}
function displayhead($title = null, $bgimg = null, $height = '35%', $tartalom = null) {
    global $sitename;
    global $rootdir;
    global $mysql;
    if ($height == null) {
        $height = "35%";
    }
    if ($bgimg == null) {
        $bgimg = getheadimage();
    }
    ?>
    <header style="height: <?php echo $height; ?>;">
    <div class="head h-100">
    <div class="fejlecparallax text-center bg-image h-100" style="background-image: url('<?php echo $bgimg; ?>');">
    <?php
    include("navbar.php");
    ?>
    <div class="head-text d-flex justify-content-center align-items-center h-100 mask">
    <div>
        <h1 class="text-center text-white"><?php echo $title; ?></h1>
        <div class="text-white">
            <?php echo $tartalom; ?>
        </div>
    </div>
    </div>
    </div>
    </div>
    </header>
    <?php
}
function deletepastszertartas() {
    global $mysql;
    $ido = getsetting("mise.autodelete");
    if ($ido > 0) {
        $ido += 30;
    $datetorlendo = date("Y-m-d H:i:s", strtotime("+".$ido." minutes"));
    $sql = "DELETE FROM `szertartasok` WHERE `date` < '$datetorlendo'";
    $eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
    // TODO szándékok megőrzésének lehetővé tétele
    $sql = "SELECT `id` FROM `szandekok`";
    $eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
    while($row = mysqli_fetch_array($eredmeny)) {
        $sql = "SELECT `id` FROM `szertartasok` WHERE `szandek` = '".$row["id"]."'";
        $eredmenya = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
        if (mysqli_num_rows($eredmenya) == 0) {
            $sql = "DELETE FROM `szandekok` WHERE `id` = '".$row["id"]."'";
            $eredmenyb = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
        }
    } }
}
function correct($txt) {
    // TODO a strip_tags funkció hozzáadása, ha HTML formázást szeretnénk alkamazni
    return htmlspecialchars(stripslashes(trim($txt)));
}
$htmlregexlist = ["name" => "^([a-zA-Z .-]|[öüóőúéáűí]|[ÖÜÓŐÚÉÁŰÍ])+$", "dateinput" => "^[0-9 T:-]{11,}$", "dateoutput" => "^[0-9 \.:-]{12,}$", "colorhex" => "^#[0-9A-F]{3,6}$", "styleexpression" => "^[a-z :;-]*$", "email" => "^[a-z0-9._+-]+[@][a-z.]+$"];
//TODO check függvény befejezése, ennek azt kell csinálnia, hogy a $txt az ellenőrizendő szöveg, a $tipus pedig, hogy milyen szöveg (pl. név, email) és a switch-csel a megfelelő preg_match() vagy filter_var() függvényt hajtja végre és annak alapján visszatér egy igaz/hamis értékkel
function check($txt, string $tipus) {
    $regexkelle = false;
    $filterkelle = false;
    $filterid = 0;
    $regex = null;
    $valid = false;
    global $regexlist;
    switch($tipus) {
        case 'name':
            $regexkelle = true;
            $regex = "/^([a-z .-]|[öüóőúéáűí]|[ÖÜÓŐÚÉÁŰÍ])+$/i";
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
        case "number":
            $filterkelle = true;
            $filterid = FILTER_VALIDATE_INT;
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