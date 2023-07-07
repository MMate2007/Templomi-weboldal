<?php
ob_start();
setcookie('enablecookie', 'yes', time() + (86400 * 60));
if (isset($_GET["conventionalcookies"])) {
if ($_GET["conventionalcookies"] == "1") {
setcookie('enableconventionalcookie', 'yes', time() + (86400 * 60)); } }
//header("Set-Cookie: enablecookie=yes");
header("Location: index.php");
?>