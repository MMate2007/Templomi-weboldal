<?php
//Ez a konfigurációs fájl. Itt lehet módosítani a beállítások egy részét.
// A következő beállítást állítsuk true-ra ha még a régi jelszó hash szerint vannak a jelszavaink (vagy ha többen nem tudnak belépni, pedig a jelszó helyes).
$hashtransition = false;

// TODO themecolor bevétele a beállításokba
$themecolor = "#e1b137"; // Ha szeretne megadni színt, akkor idézőjelek közé írja be a szín hexadecimális kódját (a null helyére)! Alapértelmezett érték: null idézőjelek nélkül.

//Kérem az alábbiakat ne módosítsa (különleges igény esetén persze lehet)!
//--------------------------
$authoregyhazirend = array("Liturgiában nem létfontosságú résztvevő (ministráns, sekrestyés, irodai alkalmazott, egyéb)", "Kántor", "Pap/Püspök");
$authorszint = array("1. ", "Rendszeradminisztrátor");
$szertartasoktypeid = array("csendes", "orgonás", "ünnepi");
$settingstype = array("bool", "int", "string");
$navbars = array(
    "desktop" => "Fő menüsáv",
    "quickadmin" => "Adminisztrációs gyorsmenü"
);
$pwdhashalgo = PASSWORD_DEFAULT;
//--------------------------
?>