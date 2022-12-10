<?php ob_start(); ?>
<html>
<head>
<?php include("head.php"); ?>
<title>Kijelentkezés...</title>

</head>
<body>
<?php
session_destroy();
header("Location: login.php");
?>
</body>
</html>