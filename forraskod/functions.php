<?php
// TODO deletehirdetesek funkció elkészítése a már nem érvényes hirdetések törlésére
class Session {
    private $sessionid;
    private $userid;
    function __construct($sessid = 0, int|null $primaryid = null)
    {
        // TODO prímariid alapú kezelés is
        global $mysql;
        $users = 0;
        if ($sessid === 0) {
            $this->sessionid = session_id();
            if (isset($_SESSION["userId"])) {
                $this->userid = $_SESSION["userId"];
            } else if (isset($_SESSION["uid"])) {
                $this->userid = $_SESSION["uid"];
            }
            else {
                throw new Exception("Nincs megadva userId.");
            }
        } else {
            $this->sessionid = $this->sessionid;
            $sql = "SELECT `userid` FROM `sessions` WHERE `id` = '$this->sessionid'";
            $eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
            while ($row = mysqli_fetch_array($eredmeny)) {
                $this->userid = $row["userid"];
                $users++;
            }
        }
        // if (!$this->exists()) {
        //     $sql = "INSERT INTO `sessions`(`id`, `userid`) VALUES ('$this->sessionid','$this->userid')";
        //     $eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
        // }
        if ($users > 1) {
            throw new sessionException("Ugyanazon munkamenet-azonosítóhoz több felhasználó is tartozik.", 102);
        }
    }
    function __destruct()
    {
        $this->sessionid = null;
        $this->userid = null;
    }
    function login() {
        global $mysql;
        $sql = "INSERT INTO `sessions`(`id`, `userid`) VALUES ('$this->sessionid','$this->userid')";
        $eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
    }
    function getsessionid() {
        return $this->sessionid;
    }
    function getuserid() {
        return $this->userid;
    }
    function destroy() {
        global $mysql;
        $sql = "DELETE FROM `sessions` WHERE `id` = '$this->sessionid'";
        $eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
    }
    function log_activity() {
        global $mysql;
        $sql = "UPDATE `sessions` SET `lastactivity`='".time()."' WHERE `id` = '$this->sessionid'";
        $eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
    }
    function regenerate() {
        global $mysql;
        $sql = "SELECT `started` FROM `sessions` WHERE `id` = '$this->sessionid'";
        $eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
        $row = mysqli_fetch_row($eredmeny);
        $sql = "DELETE FROM `sessions` WHERE `id` = '$this->sessionid'";
        $eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");        
        $this->sessionid = session_id();
        $sql = "INSERT INTO `sessions`(`id`, `userid`, `started`) VALUES ('$this->sessionid','$this->userid','".$row["started"]."')";
        $eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");        
    }
    function exists(): bool {
        global $mysql;
        $sql = "SELECT `userid` FROM `sessions` WHERE `id` = '$this->sessionid'";
        $eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");        
        if (mysqli_num_rows($eredmeny) == 1) {
            return true;
        } else if (mysqli_num_rows($eredmeny) == 0) {
            return false;
        } else if (mysqli_num_rows($eredmeny) > 1) {
            throw new sessionException("Egynél több munkamenet létezik ugyanazzal az azonosítóval.", 102);
        }
    }
    function checkcreatetime(): bool {
        global $mysql;
        if (getsetting("session.lifelenght") === null) {
            return true;
        }
        $sql = "SELECT `created` FROM `sessions` WHERE `id` = '$this->sessionid'";
        $eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");        
        $row = mysqli_fetch_array($eredmeny);
        if (time() - $row["created"] >= getsetting("session.lifelenght")) {
            return false;
        } else if (time() - $row["created"] < getsetting("session.lifelenght")) {
            return true;
        }
    }
    function checkstarttime(): bool {
        global $mysql;
        if (getsetting("session.logintime") === null) {
            return true;
        }
        $sql = "SELECT `started` FROM `sessions` WHERE `id` = '$this->sessionid'";
        $eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
        $row = mysqli_fetch_array($eredmeny);
        if (time() - $row["started"] >= getsetting("session.logintime")) {
            return false;
        } else if (time() - $row["started"] < getsetting("session.logintime")) {
            return true;
        }
    }
    function checklastactivity(): bool {
        global $mysql;
        if (getsetting("session.lastactivitylimit") === null) {
            return true;
        }
        $sql = "SELECT `lastactivity` FROM `sessions` WHERE `id` = '$this->sessionid'";
        $eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");        
        $row = mysqli_fetch_array($eredmeny);
        if (time() - $row["lastactivity"] >= getsetting("session.lastactivitylimit")) {
            return false;
        } else if (time() - $row["lastactivity"] < getsetting("session.lastactivitylimit")) {
            return true;
        }
    }
    function validonlogin(): bool {
        global $mysql;
        try {
        if ($this->exists()) {
            return false;
        } }
        catch (sessionException $e) {
            Session::logoutuser($this->userid);
            return false;
        }
        if (!getsetting("session.multiplelogins")) {
            $sessions = Session::getusersessions($this->userid);
            if (count($sessions) > 0) {
            if (getsetting(("session.multiplelogins.logout"))) {
                Session::logoutuser($this->userid);
            } else {
                $this->destroy();
                return false;
            } }
        }
        return true;
    }
    function checksession() {
        // FIXME valamiért mindig hamis, ha minden session. beállítás 0
        global $mysql;
        try {
        if (!$this->exists()) {
            return false;
        } }
        catch (sessionException $e) {
            Session::logoutuser($this->userid);
            return false;
        }
        if (!getsetting("session.multiplelogins")) {
            $sessions = Session::getusersessions($this->userid);
            if (count($sessions) > 1) {
                if (getsetting("session.multiplelogins.logout")) {
                    Session::logoutuser($this->userid);
                    $sql = "INSERT INTO `sessions`(`id`, `userid`) VALUES ('$this->sessionid','".$this->userid."')";
                    $eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
                } else {
                    return false;
                }
            }
        }
        if (!$this->checkcreatetime()) {
            if (!getsetting("session.deleteifoutdated")) {
                throw new sessionException("A munkamenet azonosítóját újra kell generálni", 101);
            } else {
            return false;
            }
        }
        if (!$this->checklastactivity()) {
            return false;
        }
        if (!$this->checkstarttime()) {
            return false;
        }
        return true;
    }
    static function getusersessions(int $userid): array {
        global $mysql;
        $sql = "SELECT `id` FROM `sessions` WHERE `userid` = '$userid' ORDER BY `created`";
        $eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");        
        $sessionids = array();
        while ($row = mysqli_fetch_array($eredmeny)) {
            array_push($sessionids, $row["id"]);
        }
        return $sessionids;
    }
    static function logoutuser(int $userid) {
        global $mysql;
        $sql = "DELETE FROM `sessions` WHERE `userid` = '$userid'";
        $eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
    }
}
class loginException extends Exception {
    public function showError() {
        displaymessage("error", "Nem sikerült a bejelentkezés a következő miatt: ".$this->getMessage());
    }
    // Hibakódok:
    // 1: már létezik ez a munkamenet
    // 2: több munkamenet létezik azonos azonosítóval
    // 3: már be van jelentkezve másutt
    // 40: lejárt a munkamenet
    // 41: tétlenség miatt lejárt munkamenet
}
class sessionException extends Exception {
    public function showError() {
        displaymessage("error", "Munkamenet hiba: ".$this->getMessage());
    }
    // Hibaüzenetek:
    // 101: újra kell generálni a munkamenet azonosítót
    // 102: duplikált munkamenet azonosító
}
class StatsDB extends SQLite3 {
    public function __construct()
    {
        $this->open("stats.db");
        $eredmeny = $this->query("SELECT name FROM sqlite_master WHERE type='table' AND name='visits';");
        if ($eredmeny->fetchArray() === false) {
            $sql =<<<EOF
            CREATE TABLE visits
            (ID INTEGER PRIMARY KEY AUTOINCREMENT,
            URL TINYTEXT NOT NULL,
            time TIMESTAMP NOT NULL);
        EOF;
            $this->exec($sql);
        }
    }
    public function __destruct()
    {
        $this->close();
    }
}

function newvisit(string $url): void {
    $db = new StatsDB();
    $db->exec("INSERT INTO visits (URL, time) VALUES ('$url', ".time().")");
    unset($db);
}

enum MessageType: string {
    case success = "success";
    case danger = "danger";
    case warning = "warning";
    case info = "info";
    case primary = "primary";
    case secondary = "secondary";
}

class Message {
    private $content;
    private $type;
    private $dismissible;

    public function __construct(string $content, MessageType $type, bool $dismissible = true) {
        $this->content = $content;
        $this->type = $type;
        $this->dismissible = $dismissible;
    }

    public function displaymessage() {
        echo "<div class='alert alert-", $this->type->value, " fade show";
        if ($this->dismissible) {
            echo " alert-dismissible";
        }
        echo "' role='alert'>", $this->content;
        if ($this->dismissible) {
            echo "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Bezárás'></button>";
        }
        echo "</div>";
    }

    public static function displayall() {
        if (isset($_SESSION["messages"])) {
        foreach($_SESSION["messages"] as $key => $message) {
            $message->displaymessage();
            unset($_SESSION["messages"][$key]);
        } }
    }

    public function insertontop() {
        ?>
        <script>
        var message = document.createElement("div");
        message.innerHTML="<?php $this->displaymessage(); ?>";
        document.querySelector("#messagesdiv").appendChild(message);
        </script>
        <?php
    }

    public static function flush() {
        if (isset($_SESSION["messages"])) {
        foreach($_SESSION["messages"] as $key => $message) {
            $message->insertontop();
            unset($_SESSION["messages"][$key]);
        } }
    }
}

function redirectback() {
    global $_POST;
    if (isset($_POST["urlfrom"])) {
    header("Location: ".$_POST["urlfrom"]); }
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
    if (isset($_POST[$post])) {
        if (!is_array($_POST[$post])) {
            if ($_POST[$post] == $value) { echo "checked"; }
        } else {
            if (in_array($value, $_POST[$post])) {
                echo "checked";
            }
        }
    }
}
/**
 * Visszadja, hogy a **bejelentkezett** felhasználónak van-e jogosultsága a $premission-ban leírt jogra
 *
 * @param string $premission Jogosultság neve
 * @return void
 */
function checkpermission(string $permission, $userid = null) {
    global $mysql;
    if ($userid === null) {
        $userid = $_SESSION["userId"];
    }
    $sqlp = "SELECT `id` FROM `permissions` WHERE `shortname` = '$permission'";
    $eredmenyp = mysqli_query($mysql, $sqlp) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
    $rowp = mysqli_fetch_array($eredmenyp);
    $sqlp = "SELECT `permissionId` FROM `userpermissions` WHERE `userId` = '$userid' AND `permissionId` = '".$rowp["id"]."'";
    $eredmenyp = mysqli_query($mysql, $sqlp) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
    if (mysqli_num_rows($eredmenyp) == 1) {
        return true;
    } else {
        return false;
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
    echo "<div class='alert alert-$type'>$msg</div>";
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
    <header style="height: <?php echo $height; ?>;" class="flex-shrink-0">
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
    }
}
function correct($txt) {
    // TODO a strip_tags funkció hozzáadása, ha HTML formázást szeretnénk alkamazni
    if ($txt === null) {
        return null;
    }
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
        case "path":
            $regexkelle = true;
            $regex = "/^[a-z0-9 _\-\.:\/]*$/i";
            break;
        case "url":
            $regexkelle = false;
            $filterkelle = true;
            $filterid = FILTER_VALIDATE_URL;
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