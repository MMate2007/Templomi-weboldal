# Templomi-weboldal
**A main ág a production-ready(tehát a "forgalomba helyezhető") kódot tartalmazza. Fejlesztéshez használjuk a dev ágat!**
---
Ezzel a rendszerrrel egyszerűen hozhatunk létre plébániai weboldalt.

Egy új verzió folyamatban van, szíves türelmét kérem!
## Telepítés
Rendszerkövetelmények:
- PHP 7.2+
- MySQL
Lépések:
1. Klónozzuk ezt a repository-t!
2. Készítsünk másolatot a *default.config.php* fájlról, a másolat neve legyen *config.php*! Töltsük igényeink szerint a fájlban a változókat!
3. A tabla.sql fájlt futtassuk a MySQL adatbázison (terminálból, vagy a PHPMyAdminon keresztül), egy már **előre** létrehozott adatbázison, **amelynek a nevét megadtuk a *config.php* fájlban**!