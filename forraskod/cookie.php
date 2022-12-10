<?php
setcookie('enablecookie', 'yes', time() + (86400 * 60));
//header("Set-Cookie: enablecookie=yes");
header("Location: index.php");
?>