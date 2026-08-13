<?php
// include("config.php"); 
// include("functions.php");
require __DIR__ . '/vendor/autoload.php';
function generatesitemap() {
// $mysql = mysqli_connect($mysqlhost, $mysqlu, $mysqlp, $mysqld) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
// mysqli_query($mysql, "SET NAMES utf8");
global $mysql;
$sitemap = new Rumenx\Sitemap\Sitemap();
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? "https://" : "http://";
$baseurl = $protocol . $_SERVER["HTTP_HOST"];
$sql = "SELECT DATE_FORMAT(`lastupdated`, '%Y-%m-%dT%TZ') AS `date` FROM `oldalak` WHERE `url` = 'index'";
$eredmeny = mysqli_query($mysql, $sql);
while ($row = mysqli_fetch_array($eredmeny)) {
    $sitemap->add($baseurl."/", $row["date"], "1.0", "weekly");
}
$sql = "SELECT DATE_FORMAT(`lastupdated`, '%Y-%m-%dT%TZ') AS `date`, `url` FROM `oldalak` WHERE `url` != 'index'";
$eredmeny = mysqli_query($mysql, $sql);
while ($row = mysqli_fetch_array($eredmeny)) {
    $sitemap->add($baseurl."/page.php?page=".$row["url"], $row["date"], "0.8", "monthly");
}
$sitemap->add($baseurl."/miserend.php", null, "0.9", "daily");
$sitemap->add($baseurl."/hirdetesek.php", null, "0.9", "weekly");
$sql = "SELECT DATE_FORMAT(MAX(`date`), '%Y-%m-%dT%TZ') AS `date` FROM `blog`";
$eredmeny = mysqli_query($mysql, $sql);
$date = date("c");
while ($row = mysqli_fetch_array($eredmeny)) {
    $date = $row["date"];
}
$sitemap->add($baseurl."/blog.php", $date, "0.9", "monthly");
// mysqli_close($mysql);
$xml = $sitemap->renderXml();
file_put_contents('sitemap.xml', $xml);
}
?>