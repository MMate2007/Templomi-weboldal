# Templomi-weboldal
---
Ezzel a rendszerrrel egyszerűen hozhatunk létre plébániai weboldalt.

## Telepítés élő használatra
Jelenleg még nincs telepíthető változat, ha majd lesz, akkor azt a *Release* oldalról tudja majd letölteni.

Egy új verzió folyamatban van, szíves türelmét kérem!
## Telepítés fejlesztéshez
Ha számítógépünkön telepítve van a Docker, akkor érdemes azzal telepíteni.
*Megjegyzés: a projekt Bootstrap 5-öt használ, de nem CDN-ről, ezért a /forraskod/css/ mappában található a customise.min.css fájlt használja. Ha testre szeretnénk szabni a Bootstrap-et, akkor telepítsük, s a scss fájlokat a /forraskod/css mappába fordítsuk! A fő fájl neve customise.min.css legyen, ezt fogja majd behúzni az egész program a fejlécbe! A JavaScript részét CDN-ről húzzuk! **Ahhoz, hogy működjön a rendszer nem kell npm-mel letölteni a Bootstrap-et, elég a customise.min.css és a customise.min.css.map fájl a forraskod/css mappában!***
### Telepítés fejlesztéshez Dockerrel
1. Klónozzuk ezt a repository-t!
2. Indítsuk el a Docker Desktopot!
1. A terminálban nyissuk meg ezen projektnek a mappáját!
2. Ez után a konténerek indításához futtassuk a `docker-compose up` parancsot a projekt mappájában!
3. Ellenőrizzük a forraskod/vendor és a forraskod/css mappák tartalmát! Ha a vendor mappa üres, akkor lépjünk be a konténerbe a `docker exec -it templomi-php-apache bash` parancssal és futtassuk a `composer install` parancsot!
4. Készen is vagyunk!
4. Nyissuk meg böngészőben a localhost/installer.php-t és kövessük a telepítő utasításait. **A MySQL adatbázis helye mezőt állítsuk *db*-re!** (A Docker-konténerek egymásra a docker-compose.yml fájlban használt megnevezéssel hivatkozhatnak, ezért db.) Ha jogosultsággal kapcsolatos problémákra hivatkozik a program (ez Linuxon előfordulhat), akkor állítsuk a Templomi-weboldal mappát és minden mappát és fájlt, ami benne van, mindenki által módosíthatóvá.
5. Nyissuk meg böngészőben a localhostot! Máris működik a dolog! A PHPMyAdmin a localhost:8080 alatt érhető el; felhasználónév: root, jelszó: root. A PHP fájlokat a konténerek futása közben is módosíthatjuk, valós időben fogjuk látni a változásokat.
### Telepítés fejlesztéshez Docker használata nélkül
Rendszerkövetelmények:
- PHP 7.2+
- MySQL
- PHP mysqli extension
Lépések:
1. Klónozzuk ezt a repository-t!
2. Indítsuk el a PHP-t és a MySQL-t és nyissuk meg böngészőben az installer.php fájlt; kövessük a telepítő utasításait.
