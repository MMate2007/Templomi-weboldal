<html>
<head>
<title>Kijelentkezés...</title>
<meta charset="utf-8">
</head>
<body>
<?php
session_start();
session_destroy();
header("Location: login.form.php");
?>
</body>
</html>