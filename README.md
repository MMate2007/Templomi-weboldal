# Templomi-weboldal
**A main ág a production-ready(tehát a "forgalomba helyezhető") kódot tartalmazza. Fejlesztéshez használjuk a dev ágat!**
---
Ezzel a rendszerrrel egyszerűen hozhatunk létre plébániai weboldalt.

## Telepítés élő használatra
Jelenleg még nincs telepíthető változat, ha majd lesz, akkor azt a *Release* oldalról tudja majd letölteni.

Egy új verzió folyamatban van, szíves türelmét kérem!
## Telepítés fejlesztéshez
Ha számítógépünkön telepítve van a Docker, akkor érdemes azzal telepíteni.
### Telepítés fejlesztéshez Dockerrel
1. Klónozzuk ezt a repository-t!
2. Indítsuk el a Docker Desktopot!
3. - Linux/MacOS esetén:
      1. A terminálban nyissuk meg ezen projektnek a mappáját!
      2. Futtassuk a következőt: `sh dockersetup.sh`. Ezzel létrehozzuk a szükséges mappákat, bemásolunk egy fájlt.
      3. Ez után a konténerek indításához futtassuk a `docker-compose up` parancsot a projekt mappájában!
      4. Készen is vagyunk!
   - Windowson:
     1. Nyissuk meg ezt a mappát a Parancssorban és futtassuk a következő parancsot: `docker-compose up`
     2. Készen is vagyunk!
4. Nyissuk meg böngészőben a localhost/installer.php-t és kövessük a telepítő utasításait. **A MySQL adatbázis helye mezőt állítsuk *db*-re!** (A Docker-konténerek egymásra a docker-compose.yml fájlban használt megnevezéssel hivatkozhatnak, ezért db.)
5. Nyissuk meg böngészőben a localhostot! Máris működik a dolog! A PHPMyAdmin a localhost:8080 alatt érhető el; felhasználónév: root, jelszó: root. A PHP fájlokat a konténerek futása közben is módosíthatjuk, valós időben fogjuk látni a változásokat.
### Telepítés fejlesztéshez Docker használata nélkül
Rendszerkövetelmények:
- PHP 7.2+
- MySQL
- PHP mysqli extension
Lépések:
1. Klónozzuk ezt a repository-t!
2. Indítsuk el a PHP-t és a MySQL-t és nyissuk meg böngészőben az installer.php fájlt; kövessük a telepítő utasításait.