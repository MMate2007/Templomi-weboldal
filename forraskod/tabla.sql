CREATE TABLE `author` (
  `id` int NOT NULL,
  `name` tinytext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `password` text NOT NULL,
  `username` tinytext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `egyhaziszint` tinyint NOT NULL,
  `2fasecret` tinytext
);
CREATE TABLE `blog` (
  `id` int NOT NULL,
  `title` tinytext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `content` text NOT NULL,
  `authorId` smallint NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE `content` (
  `name` tinytext NOT NULL,
  `value` text NOT NULL
);
CREATE TABLE `hirdetesek` (
  `ID` int NOT NULL,
  `title` tinytext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `content` text,
  `authorid` smallint NOT NULL,
  `starttime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `endtime` datetime DEFAULT NULL,
  `templomID` tinyint DEFAULT NULL
);
CREATE TABLE `kepek` (
  `src` tinytext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `description` tinytext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci
);
CREATE TABLE `nav` (
  `id` tinyint NOT NULL,
  `navid` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_hungarian_ci NOT NULL COMMENT 'Itt lehet megadni, hogy melyik menüben jelenjen meg az adott link.',
  `sorszam` tinyint NOT NULL,
  `parentid` tinyint DEFAULT NULL,
  `url` tinytext CHARACTER SET utf8mb3 COLLATE utf8mb3_hungarian_ci NOT NULL,
  `name` tinytext CHARACTER SET utf8mb3 COLLATE utf8mb3_hungarian_ci NOT NULL,
  `tooltip` tinytext CHARACTER SET utf8mb3 COLLATE utf8mb3_hungarian_ci,
  `newtab` tinyint(1) NOT NULL DEFAULT '0'
);
INSERT INTO `nav` (`id`, `navid`, `sorszam`, `parentid`, `url`, `name`, `tooltip`, `newtab`) VALUES
(0, 'desktop', 0, NULL, 'index.php', 'Főoldal', NULL, 0),
(1, 'desktop', 1, NULL, 'miserend.php', 'Liturgiák rendje', 'Miserend', 0),
(2, 'desktop', 2, NULL, 'hirdetesek.php', 'Hirdetések', NULL, 0),
(3, 'desktop', 3, NULL, 'blog.php', 'Hírek', 'Itt megtekintheti a plébánia híreit.', 0);
CREATE TABLE `oldalak` (
  `id` tinyint NOT NULL,
  `title` tinytext CHARACTER SET utf8mb3 COLLATE utf8mb3_hungarian_ci NOT NULL,
  `url` tinytext CHARACTER SET utf8mb3 COLLATE utf8mb3_hungarian_ci NOT NULL,
  `content` mediumtext CHARACTER SET utf8mb3 COLLATE utf8mb3_hungarian_ci NOT NULL,
  `coverimgpath` tinytext CHARACTER SET utf8mb3 COLLATE utf8mb3_hungarian_ci,
  `lastupdated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE `permissions` (
  `id` tinyint NOT NULL,
  `shortname` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL
);
INSERT INTO `permissions` (`id`, `shortname`, `name`) VALUES
(1, 'addhirdetes', 'Hirdetés hozzáadása'),
(2, 'addliturgia', 'Liturgia hozzáadása'),
(3, 'addpage', 'Oldal hozzáadása'),
(4, 'addpost', 'Bejegyzés hozzáadása'),
(5, 'addpostwithothername', 'Bejegyzés hozzáadása más nevében'),
(6, 'addszandek', 'Szándék hozzáadása'),
(7, 'addsznev', 'Liturgia típus hozzáadása'),
(8, 'addtelepules', 'Település hozzáadása'),
(9, 'addtemplom', 'Templom hozzáadása'),
(10, 'adduser', 'Felhasználó létrehozása'),
(11, 'bejelentkezes', 'Bejelentkezés'),
(12, 'deletepage', 'Oldal törlése'),
(13, 'edithirdetes', 'Hirdetések szerkesztése'),
(14, 'editjogosultsagok', 'Jogosultságok szerkesztése'),
(15, 'editliturgia', 'Liturgia szerkesztése'),
(16, 'editnavbar', 'Menük szerkesztése'),
(17, 'editpage', 'Oldal módosítása'),
(18, 'editpost', 'Bejegyzés létrehozása'),
(19, 'editsettings', 'Beállítások módosítása'),
(20, 'editszandek', 'Szándék módosítása'),
(21, 'removehirdetes', 'Hirdetések törlése'),
(22, 'removeliturgia', 'Liturgia törlése'),
(23, 'removepost', 'Bejegyzések törlése'),
(24, 'removeszandek', 'Szándék törlése'),
(25, 'removesznev', 'Liturgia típus törlése'),
(26, 'removetelepules', 'Település törlése'),
(27, 'removetemplom', 'Templom törlése'),
(28, 'removeuser', 'Felhasználó törlése');
CREATE TABLE `sessions` (
  `primaryid` int NOT NULL,
  `id` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `userid` int NOT NULL,
  `started` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lastactivity` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE `settings` (
  `name` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_hungarian_ci NOT NULL,
  `value` tinytext CHARACTER SET utf8mb3 COLLATE utf8mb3_hungarian_ci,
  `type` int NOT NULL,
  `friendlyname` tinytext COLLATE utf8mb3_hungarian_ci NOT NULL,
  `description` tinytext COLLATE utf8mb3_hungarian_ci
);
INSERT INTO `settings` (`name`, `value`, `type`, `friendlyname`, `description`) VALUES
('miserend.showCel', '1', 0, 'Celebráns megjelenítése', 'A szertartás celebránsának megjelenítése a nyilvánosságnak.'),
('miserend.showKant', '1', 0, 'Kántor megjelenítése', 'A szertartás kántorának megjelenítése a nyilvánosságnak.'),
('miserend.showSzandekSzoveg', '0', 0, 'Szándék mutatása', 'A szertartás szándékának megjelenítése a nyilvánosságnak.'),
('miserend.showSzandekMeglet', '1', 0, 'Szándék meglétének mutatása', 'Mutassa, hogy az adott szertartásra van-e szándék, de a szándékot nem mutatja meg.'),
('miserend.showTipus', '1', 0, 'Szertartás típusának mutatása', 'Mutassa a szertartás típusát (például szentmise, vagy szentségimádás).'),
('main.name', 'Példa Plébánia oldala', 2, 'Az oldal neve', NULL),
('meta.name', NULL, 2, 'Metaadat - oldal neve', 'Internetes keresők számára megjelenített név'),
('meta.keywords', NULL, 2, 'Metaadat - kulcsszavak', 'Internetes keresők számára írt kulcsszavak, amelyek alapján megtalálható az oldalunk.'),
('main.email', 'example@mailto.com', 2, 'Ímél cím', 'Láblécben megjelenített kapcsolattartási ímél cím.'),
('picture.default', 'img/defaultparallax.jpg', 2, 'Alap fejléc kép', NULL),
('facebook.username', 'bszfilia', 2, 'Facebook felhasználónév', 'Ha van az egyházközségnek Facebook oldala, akkor annak felhasználónevét @ nélkül adjuk meg.'),
('picture.miserend.php', 'img/icon.png', 2, '', NULL),
('mise.warning', NULL, 1, '', 'Ennyi órával a szertartás előtt a rendszer sárga színnel jelöli.'),
('mise.warning2', NULL, 1, '', 'Ennyi órával a szertartás előtt a rendszer piros színnel jelöli.'),
('api.enabled', '1', 0, 'API engedélyezése', NULL),
('warning.idomisekkozott.perc', '10', 1, 'Szertartások közti minimális idő (perc)', 'Ha két szertartásnak ugyanaz a celebránsa, és a köztük lévő idő kisebb az itt megadottnál, akkor a rendszer figyelmeztet, hogy esetleg nem érhet időben a helyszínre a celebráns.'),
('mise.autodelete', '0', 0, 'Szertartások automatikus törlése', 'A már megtörtént szertartások törlése.'),
('session.lifelenght', NULL, 1, 'Munkamenet maximális ideje', NULL),
('session.lastactivitylimit', NULL, 1, 'Munkamenet kifutási idő', NULL),
('session.multiplelogins', '1', 0, 'Több eszközön aktív munkamenet', NULL),
('session.multiplelogins.logout', '0', 0, 'Több eszközön aktív munkamenet esetén kijelentkeztetés', NULL),
('session.deleteifoutdated', '0', 0, 'Munkamenet törlése ha lejárt', NULL),
('session.logintime', NULL, 1, 'Bejelentkezés kifutási ideje', NULL),
('logvisits', '0', 0, 'Oldallátogatások naplózása', 'Statisztika készítése az oldallátogatásokról.'),
('favicon', NULL, 2, 'Kis kép (favicon)', 'A böngészőlapon megjelenő kis kép.');
CREATE TABLE `szertartasok` (
  `id` int NOT NULL,
  `date` datetime NOT NULL,
  `nameID` int NOT NULL,
  `name` tinytext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `telepulesID` int NOT NULL,
  `templomID` int DEFAULT NULL,
  `place` tinytext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `style` varchar(100) DEFAULT NULL,
  `celebransID` int DEFAULT NULL,
  `kantorID` int DEFAULT NULL,
  `tipus` tinyint DEFAULT NULL,
  `elmarad` tinyint(1) DEFAULT '0',
  `szandek` tinytext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `publikus` tinyint(1) NOT NULL DEFAULT '1',
  `megjegyzes` text,
  `pubmegj` text
);
CREATE TABLE `sznev` (
  `id` int NOT NULL,
  `name` tinytext CHARACTER SET utf8mb3 COLLATE utf8mb3_hungarian_ci NOT NULL
);
INSERT INTO `sznev` (`id`, `name`) VALUES
(0, 'Szentmise'),
(1, 'Szentségimádás'),
(2, 'Rózsafüzér'),
(3, 'Litánia');
CREATE TABLE `telepulesek` (
  `id` int NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_hungarian_ci NOT NULL
);
CREATE TABLE `templomok` (
  `id` int NOT NULL,
  `telepulesID` int DEFAULT NULL,
  `name` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_hungarian_ci NOT NULL,
  `vedoszent` tinytext CHARACTER SET utf8mb3 COLLATE utf8mb3_hungarian_ci,
  `color` tinytext CHARACTER SET utf8mb3 COLLATE utf8mb3_hungarian_ci
);
CREATE TABLE `userpermissions` (
  `userId` int NOT NULL,
  `permissionId` tinyint NOT NULL
);
ALTER TABLE `author`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `blog`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `hirdetesek`
  ADD PRIMARY KEY (`ID`);
ALTER TABLE `oldalak`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`primaryid`),
  ADD UNIQUE KEY `id` (`id`);
ALTER TABLE `szertartasok`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nameid` (`nameID`),
  ADD KEY `telepules` (`telepulesID`),
  ADD KEY `templom` (`templomID`),
  ADD KEY `celebrans` (`celebransID`),
  ADD KEY `kantor` (`kantorID`);
ALTER TABLE `sznev`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `telepulesek`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `templomok`
  ADD PRIMARY KEY (`id`),
  ADD KEY `telepulesID` (`telepulesID`);
ALTER TABLE `blog`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
ALTER TABLE `hirdetesek`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
ALTER TABLE `oldalak`
  MODIFY `id` tinyint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
ALTER TABLE `sessions`
  MODIFY `primaryid` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=126;
ALTER TABLE `szertartasok`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=126;
ALTER TABLE `szertartasok`
  ADD CONSTRAINT `celebrans` FOREIGN KEY (`celebransID`) REFERENCES `author` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `kantor` FOREIGN KEY (`kantorID`) REFERENCES `author` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `nameid` FOREIGN KEY (`nameID`) REFERENCES `sznev` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `telepules` FOREIGN KEY (`telepulesID`) REFERENCES `telepulesek` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `templom` FOREIGN KEY (`templomID`) REFERENCES `templomok` (`id`) ON UPDATE CASCADE;
ALTER TABLE `templomok`
  ADD CONSTRAINT `templomok_ibfk_1` FOREIGN KEY (`telepulesID`) REFERENCES `telepulesek` (`id`) ON UPDATE CASCADE;
COMMIT;
