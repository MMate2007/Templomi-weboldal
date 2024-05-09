<?php ob_start(); ?>
<!DOCTYPE html>
<html>
<head>
<?php include("head.php"); ?>
<title>Kijelentkezés...</title>
</head>
<body>
<?php
$session = new Session();
$session->destroy();
unset($session);
session_destroy();
header("Location: login.php");
?>
</body>
</html>