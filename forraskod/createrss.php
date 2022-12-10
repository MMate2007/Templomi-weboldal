<?php
/*$rssall = fopen("rss.xml", "w");
$rsstext = '<?xml version="1.0" encoding="UTF-8" ?>';
fwrite($rssall, $rsstext);
$rsstext = '<rss version="2.0">';
fwrite($rssall, $rsstext);
$rsstext = '<channel>';
fwrite($rssall, $rsstext);

fwrite($rssall, "<title><?php echo $sitename; ?></title>");
fwrite($rssall, "<link>http://fabianistva.nhely.hu/</link>");
fwrite($rssall, "<description>Minden ami a fíliáról szól.</description>");
fwrite($rssall, "<lastBuildDate>".date("D, d M Y")."</lastBuildDate>");
$sql = "SELECT `date`, `nameID`, `telepulesID`, `templomID`, `place` FROM `szertartasok` WHERE `publikus` = '1' ORDER BY `date`";
$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
while ($row = mysqli_fetch_array($eredmeny))
{
	$d = $row["date"];
    $da = substr($d, 0, 16);
	$date = str_replace("-", ". ", $da);
    $nameid = $row["nameID"];
    $sqlz = "SELECT `name` FROM `sznev` WHERE `id` = '".$nameid."'";
		$eredmenyz = mysqli_query($mysql, $sqlz) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
		while ($rowz = mysqli_fetch_array($eredmenyz))
		{
			$nameid = $rowz["name"];
		}
    $telepulesid = $row["telepulesID"];
    $templom = $row["templomID"];
    $place = $row["place"];
    $tname = null;
	$sqla = "SELECT `name` FROM `telepulesek` WHERE `id` = '".$telepulesid."'";
	$eredmenya = mysqli_query($mysql, $sqla) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
	while ($rowa = mysqli_fetch_array($eredmenya))
	{
		$tname = $rowa["name"];
	}
    $tpname = null;
	$sqlb = "SELECT `name` FROM `templomok` WHERE `id` = '".$templom."'";
	$eredmenyb = mysqli_query($mysql, $sqlb) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
	while ($rowb = mysqli_fetch_array($eredmenyb))
	{
		$tpname = $rowb["name"];
	}
    $hely = null;
	if ($tpname != null && $templom != null)
	{
		$hely = $tpname;
	}
	if ($templom == null) {
		$hely = $place;
	}
    fwrite($rssall, "<item><title>".$nameid." lesz ".$date."-kor ".$tname." településen</title><link>http://fabianistva.nhely.hu/miserend.php</link><description>Dátum: ".$date."; Típus: ".$nameid."; Hely: ".$tname." - ".$hely."</description></item>");
}
$sql = "SELECT `ID`, `title`, `content`, `starttime` FROM `hirdetesek` WHERE `starttime` < '".date("Y-m-d H:i:s")."'";
$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
while ($row = mysqli_fetch_array($eredmeny))
{
	$id = $row["ID"];
	$content = $row["content"];
	$title = $row["title"];
	$st = $row["starttime"];
    fwrite($rssall, "<item><title>".$title."</title><link>http://fabianistva.nhely.hu/index.php#".$id."</link><description>".$content."</description><pubDate>".$st."</pubDate></item>");
}
$sql = "SELECT `id`, `title`, `content`, `date` FROM `blog`'";
$eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
while ($row = mysqli_fetch_array($eredmeny))
{
	$id = $row["id"];
	$content = $row["content"];
	$title = $row["title"];
	$st = $row["date"];
    fwrite($rssall, "<item><title>".$title."</title><link>http://fabianistva.nhely.hu/blog.php#".$id."</link><description>".$content."</description><pubDate>".$st."</pubDate></item>");
}

$rsstext = '</channel>';
fwrite($rssall, $rsstext);
$rsstext = '</rss>';
fwrite($rssall, $rsstext);
fclose($rssall);
*/
?>