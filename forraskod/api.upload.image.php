<?php
include("config.php"); 
include("functions.php");
session_start();
$mysql = mysqli_connect($mysqlhost, $mysqlu, $mysqlp, $mysqld);
mysqli_query($mysql, "SET NAMES utf8");
if (!checkpermission("uploadfile")) {
    header("HTTP/1.1 500 Server Error");
    exit;
}
if (!empty($_FILES) && file_exists($_FILES["file"]["tmp_name"]) && is_uploaded_file($_FILES["file"]["tmp_name"])) {
            $dir = getsetting("uploaddirectory");
            $fname = $dir.basename($_FILES["file"]["name"]);
            $isimg = getimagesize($_FILES["file"]["tmp_name"]);
            if (!$isimg) {
                header("HTTP/1.1 500 Server Error");
                exit;
            }
            $imageFileType = strtolower(pathinfo($fname,PATHINFO_EXTENSION));
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $fname)) {
                $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? "https://" : "http://";
                $baseurl = $protocol . $_SERVER["HTTP_HOST"] . rtrim(dirname($_SERVER['REQUEST_URI']), "/") . "/";
                $sql = "INSERT INTO `kepek`(`src`, `description`) VALUES ('".mysqli_real_escape_string($mysql, $baseurl . $fname)."','".mysqli_real_escape_string($mysql, $fname)."')";
                $res = mysqli_query($mysql, $sql);
                $res = true;
                if ($res) {
                echo json_encode(array('location' => $baseurl . $fname));
                } else {
                    header("HTTP/1.1 500 Server Error");
                }
            } else {
                header("HTTP/1.1 500 Server Error");
            }
}
?>