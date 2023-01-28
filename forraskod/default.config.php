<?php
//Ez a konfigurációs fájl. Itt lehet módosítani a beállítások egy részét, illetve itt lehet megadni a weboldalon megjelenő szövegeket.

//---------------------------
// $rootdir = ""; ebhely URL címének az eleje. Ha például a főoldalt a http://mintaplebania.hu/index.php oldalon érjük el, akkor CSAK A "http://mintaplebania.hu/"-T ÍRJUK BE!
//---------------------------
$themecolor = null; // Ha szeretne megadni színt, akkor idézőjelek közé írja be a szín hexadecimális kódját (a null helyére)! Alapértelmezett érték: null idézőjelek nélkül.
// A következő beállítást állítsuk true-ra ha még a régi jelszó hash szerint vannak a jelszavaink (vagy ha többen nem tudnak belépni, pedig a jelszó helyes).
//Miután mindenki belépett ezt mindenképpen állítsuk vissza false-ra!
$hashtransition = false;

//Kérem az alábbiakat ne módosítsa (különleges igény esetén persze lehet)!
//--------------------------
$authoregyhazirend = array("Liturgiában nem létfontosságú résztvevő (ministráns, sekrestyés, irodai alkalmazott, egyéb)", "Kántor", "Pap/Püspök");
$authorszint = array("1. ", "Rendszeradminisztrátor");
$szertartasoktypeid = array("csendes", "orgonás", "ünnepi");
//--------------------------
?>