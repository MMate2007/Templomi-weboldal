<?php
if (!isset($_SESSION["userId"]))
{
	header("Location: login.php?messagetype=warning&message=Hozzáférés megtagadva! A tartalom megtekintéséhez be kell jelentkezni.");
}

$sql = "SELECT `name` FROM `author` WHERE `id` = '".$_SESSION["userId"]."'";
$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
while ($row = mysqli_fetch_array($eredmeny))
{
	$name = $row["name"];
	if ($name != $_SESSION["name"])
	{
		header("Location: login.php?messagetype=warning&message=Hozzáférés megtagadva! A tartalom megtekintéséhez be kell jelentkezni.");
	}
}
if (!checkpermission("bejelentkezes")) {
	$_SESSION["userId"] = null;
	header("Location: login.php?messagetype=warning&message=Hozzáférés megtagadva! Az Ön fiókját ideiglenesen letiltották.");
}
$session = new Session();
try {
	if (!$session->checksession()) {
		$session->destroy();
		session_destroy();
		unset($session);
		header("Location: login.php");
		exit();
	}
}
catch (sessionException $e) {
	if ($e->getCode() == 101) {
		session_regenerate_id();
		$session->regenerate();
	}
}
?>