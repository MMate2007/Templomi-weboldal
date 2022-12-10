<?php
//Ez a konfigurációs fájl. Itt lehet módosítani a beállítások egy részét, illetve itt lehet megadni a weboldalon megjelenő szövegeket.

//MySQL bejelentkezési adatok
//Kérem, töltse ki az alábbi adatokat!
//---------------------------
$mysqlhost = "localhost"; //MySQL szerver elérhetősége. Általában localhost
$mysqlu = "root"; //MySQL felhasználónév
$mysqlp = ""; //MySQL jelszó
$mysqld = "db"; //MySQL adatbázis neve. Ennek az adatbázisnak léteznie kell már!
//---------------------------

//Webhelyjel kapcsolatos fontos beállítások
//Kérem, töltse ki az alábbi adatokat!
//---------------------------
$rootdir = ""; //Webhely URL címének az eleje. Ha például a főoldalt a http://mintaplebania.hu/index.php oldalon érjük el, akkor CSAK A "http://mintaplebania.hu/"-T ÍRJUK BE!
//---------------------------
$themecolor = null; // Ha szeretne megadni színt, akkor idézőjelek közé írja be a szín hexadecimális kódját (a null helyére)! Alapértelmezett érték: null idézőjelek nélkül.

//Kérem az alábbiakat ne módosítsa (különleges igény esetén persze lehet)!
//--------------------------
$authoregyhazirend = array("Liturgiában nem létfontosságú résztvevő (ministráns, sekrestyés, irodai alkalmazott, egyéb)", "Kántor", "Pap/Püspök");
$authorszint = array("1. ", "Rendszeradminisztrátor");
$szertartasoktypeid = array("csendes", "orgonás", "ünnepi");
//--------------------------
?>