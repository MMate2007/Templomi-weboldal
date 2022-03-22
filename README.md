# Templomi-weboldal
Ezen weboldal testreszabásával, minta szövegeinek kicserélésévek egy plébániai weboldal készíthető.
Az old mappában található a régebbi forrsákód, míg a foraskod mappában a most aktuális forráskód.
Hamarosan érkezik egy frissebb változat, ahol már nem kell olyan sok helyen átírni a szövegeket.

## Telepítés
Jelenleg még nem áll rendelkezésre a telepítő, így kézzel kell megcsinálni egyes dolgokat.
Hozzunk létre egy adatbázist a weboldalnak bármilyen néven!
Érdemes létrehozni egy külön MySQL fiókot a programnak.
Futtassuk a tabla.sql fájlt az adatbázisban. Ez létrehozza a szükséges táblákat és létrehoz egy admin felhasználót, mellyel majd be tudunk lépni a programba. Ennek a felhaszbnálónak felhasználóneve az admin, jelszava a root.
Másoljuk a forraskod mappa tartalmát a webszerverre!
Nyissuk meg a böngészőben a login.form.php fájlt és lépjünk be a fentebb leírt adatokkal!