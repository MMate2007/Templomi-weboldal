# Templomi-weboldal
**A main ág a production-ready(tehát a "forgalomba helyezhető") kódot tartalmazza. Fejlesztéshez használjuk a dev ágat!**
---
Ezzel a rendszerrrel egyszerűen hozhatunk létre plébániai weboldalt.

Egy új verzió folyamatban van, szíves türelmét kérem!
## Telepítés
Ha számítógépünkön telepítve van a Docker, akkor érdemes azzal telepíteni.
### Telepítés Dockerrel
1. Klónozzuk ezt a repository-t!
2. Indítsuk el a Dockert!
3. Készítsünk másolatot a *default.config.php* fájlról, a másolat neve legyen *config.php*! Töltsük igényeink szerint a fájlban a változókat! **A `$mysqlhost` nevű változó értéke *mindig* `db` legyen!**
4. - Linux/MacOS esetén:
      1. A terminálban nyissuk meg ezen projektnek a mappáját!
      2. Futtassuk a következőt: `sh dockersetup.sh`. Ezzel létrehozzuk a szükséges mappákat, bemásolunk egy fájlt és elindítjuk a konténereket.
       3. Készen is vagyunk!
   - Windowson:
     1. Hozzunk létre ebben a mappában két mappát, nevük legyen *db* és *dbdump*!
     2. Másoljuk a *tabla.sql* fájlt a *dbdump* mappába!
     3. Nyissuk meg ezt a mappát a Parancssorban és futtassuk a következő parancsot: `docker-compose up`
     4. Készen is vagyunk!
5. Nyissuk meg böngészőben a localhostot! Máris működik a dolog! A PHPMyAdmin a localhost:8080 alatt érhető el; felhasználónév: root, jelszó: root. A PHP fájlokat a konténerek futása közben is módosíthatjuk, valós időben fogjuk látni a változásokat.
### Telepítés Docker használata nélkül
Rendszerkövetelmények:
- PHP 7.2+
- MySQL
Lépések:
1. Klónozzuk ezt a repository-t!
2. Készítsünk másolatot a *default.config.php* fájlról, a másolat neve legyen *config.php*! Töltsük igényeink szerint a fájlban a változókat!
3. A tabla.sql fájlt futtassuk a MySQL adatbázison (terminálból, vagy a PHPMyAdminon keresztül), egy már **előre** létrehozott adatbázison, **amelynek a nevét megadtuk a *config.php* fájlban**!