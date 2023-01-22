<?php
header("Content-Type: application/json");
function send() {
    global $respond;
    global $mysql;
    $json = json_encode($respond);
    echo $json;
    mysqli_close($mysql);
}
include("config.php");
include("functions.php");
$mysql = mysqli_connect($mysqlhost, $mysqlu, $mysqlp, $mysqld);
mysqli_query($mysql, "SET NAMES utf8");
deletepastszertartas();

$respond = new stdClass();

if (isset($_GET["q"])) {
    $q = $_GET["q"];
} else {
    $respond->errorcode = 0;
    $respond->error = "Nincs megadva a q! (Ebbe kell megadni, hogy mit szeretnénk kezdeni az API-jal.)";
    send();
    exit;
}
$sql = "SELECT `value` FROM `settings` WHERE `name` = 'api.enabled'";
$eredmeny = mysqli_query($mysql, $sql);
$row = mysqli_fetch_array($eredmeny);
if ($row == null or $row["value"] == "0") {
    $respond->errorcode = 1;
    $respond->error = "Az API funkció le van tiltva!";
    send();
    exit;
} else if ($row["value"] == "1") {
if (isset($_GET["apiversion"])) {
$apiversion = $_GET["apiversion"]; } else { $apiversion = 1; }
if ($apiversion == 1) {
if (!isset($_GET["apikey"])) {
    $respond->errorcode = 10;
    $respond->error = "Nem található API kulcs!";
    send();
    exit;
} else {
    if (!preg_match("/^[a-z0-9]{1,255}$/", $_GET["apikey"])) {
        $respond->errorcode = 11;
        $respond->error = "Az API kulcs nem felel meg a követelményeknek! Csak számokat és kisbetűket tartalmazhat szóköz nélkül, maximum 255 karakterig.";
        send();
        exit;
    } else {
        $apikey = $_GET["apikey"];
        $sql = "SELECT `templomid`, `active` FROM `api` WHERE `apikey` = '$apikey'";
        $eredmeny = mysqli_query($mysql, $sql);
        $row = mysqli_fetch_array($eredmeny);
        if ($row == null) {
            $respond->errorcode = 2;
            $respond->error = "Nem található ilyen API kulcs!";
            send();
            exit;
        } else {
        if ($row["active"] == 0) {
            $respond->errorcode = 3;
            $respond->error = "Ez az API kulcs le van tiltva, tehát nem használható. A használathoz kérem engedélyezze!";
            send();
            exit;
        } else if ($row["active"] == 1) {
            $templom = $row["templomid"];
        } }
    }
}
if ($q == "getdates") {
if (!isset($_GET["type"])) { $respond->errorcode = 20; $respond->error = "Nem található a type attribútum!"; send(); exit; } else {
$tipusnev = $_GET["type"]; }
if (!isset($_GET["public"])) {
    $public = 1;
} else {
    switch($_GET["public"]) {
        case 1:
            $public = 1;
            break;
        case 0:
            $public = 0;
            break;
    }
}

$sql = "SELECT * FROM `sznev`";
$eredmeny = mysqli_query($mysql, $sql);
while ($row = mysqli_fetch_array($eredmeny)) {
    if ($row["name"] == $tipusnev) {
        $typecode = $row["id"];
    }
}
$dateformat = "Y-m-d H:i";
if (isset($_GET["dateformat"])) {
    $dateformat = $_GET["dateformat"];
}
$respond->dates = [];
$sql = "SELECT `date` FROM `szertartasok` WHERE `nameID` = '$typecode' AND `publikus` = '$public' AND `templomID` = '$templom' ORDER BY `date`";
$eredmeny = mysqli_query($mysql, $sql);
while ($row = mysqli_fetch_array($eredmeny)) {
    $respond->dates[] = date_format(date_create($row["date"]), $dateformat);
}
} } }

if ($q == "getnextliturgia") {
    $tipusnev = 0;
    if (isset($_GET["type"])) {
        $tipusnev = $_GET["type"];
    }
    if ($tipusnev != 0) {
        $sql = "SELECT * FROM `sznev`";
        $eredmeny = mysqli_query($mysql, $sql);
        while ($row = mysqli_fetch_array($eredmeny)) {
            if ($row["name"] == $tipusnev) {
                $typecode = $row["id"];
            }
        }
    }
    if (!isset($_GET["public"])) {
        $public = 1;
    } else {
        switch($_GET["public"]) {
            case 1:
                $public = 1;
                break;
            case 0:
                $public = 0;
                break;
        }
    }
    $dateformat = "Y-m-d H:i";
    if (isset($_GET["dateformat"])) {
        $dateformat = $_GET["dateformat"];
    }
    $respond->date = null;
    if ($tipusnev != 0) {
    $sql = "SELECT `date` FROM `szertartasok` WHERE `nameID` = '$typecode' AND `publikus` = '$public' AND `templomID` = '$templom' ORDER BY `date` LIMIT 1"; } else { $sql = "SELECT `date`, `nameID` FROM `szertartasok` WHERE `publikus` = '$public' AND `templomID` = '$templom' ORDER BY `date` LIMIT 1"; }
    $eredmeny = mysqli_query($mysql, $sql);
    while ($row = mysqli_fetch_array($eredmeny)) {
        $respond->date = date_format(date_create($row["date"]), $dateformat);
        if ($tipusnev == 0) {
            $sql = "SELECT `name` FROM `sznev` WHERE `id` = '".$row["nameID"]."'";
            $eredmenyc = mysqli_query($mysql, $sql);
            $rowc = mysqli_fetch_array($eredmenyc);
            $respond->type = $rowc["name"];
        }
    }
}
$json = json_encode($respond);
echo $json;
mysqli_close($mysql);
?>