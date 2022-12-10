-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2022. Ápr 18. 09:34
-- Kiszolgáló verziója: 10.4.22-MariaDB
-- PHP verzió: 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `templomigithub`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `author`
--

CREATE TABLE `author` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `password` text NOT NULL,
  `username` text NOT NULL,
  `szint` int(11) NOT NULL,
  `egyhaziszint` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- A tábla adatainak kiíratása `author`
--

INSERT INTO `author` (`id`, `name`, `password`, `username`, `szint`, `egyhaziszint`) VALUES
(0, 'admin', '83353d597cbad458989f2b1a5c1fa1f9f665c858', 'admin', 1, 2);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `blog`
--

CREATE TABLE `blog` (
  `id` int(11) NOT NULL,
  `title` text NOT NULL,
  `content` text NOT NULL,
  `authorId` int(11) NOT NULL,
  `date` text NOT NULL,
  `image` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- A tábla adatainak kiíratása `blog`
--


-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `hirdetesek`
--

CREATE TABLE `hirdetesek` (
  `ID` int(11) NOT NULL,
  `title` text NOT NULL,
  `content` text DEFAULT NULL,
  `authorid` int(11) NOT NULL,
  `starttime` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `kepek`
--

CREATE TABLE `kepek` (
  `src` text NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- A tábla adatainak kiíratása `kepek`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `settings`
--

CREATE TABLE `settings` (
  `name` varchar(100) COLLATE utf8_hungarian_ci NOT NULL,
  `value` varchar(500) COLLATE utf8_hungarian_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `szertartasok`
--

CREATE TABLE `szertartasok` (
  `id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `nameID` int(11) NOT NULL,
  `name` text DEFAULT NULL,
  `telepulesID` int(11) NOT NULL,
  `templomID` int(11) DEFAULT NULL,
  `place` text DEFAULT NULL,
  `style` varchar(100) DEFAULT NULL,
  `celebransID` int(11) DEFAULT NULL,
  `kantorID` int(11) DEFAULT NULL,
  `tipus` int(11) DEFAULT NULL,
  `szandek` text DEFAULT NULL,
  `publikus` int(11) NOT NULL DEFAULT 1,
  `megjegyzes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `sznev`
--

CREATE TABLE `sznev` (
  `id` int(11) NOT NULL,
  `name` text COLLATE utf8_hungarian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `telepulesek`
--

CREATE TABLE `telepulesek` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_hungarian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `templomok`
--

CREATE TABLE `templomok` (
  `id` int(11) NOT NULL,
  `telepulesID` int(11) DEFAULT NULL,
  `name` varchar(200) COLLATE utf8_hungarian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `author`
--
ALTER TABLE `author`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`id`),
  ADD KEY `authorid` (`authorId`);

--
-- A tábla indexei `hirdetesek`
--
ALTER TABLE `hirdetesek`
  ADD PRIMARY KEY (`ID`);

--
-- A tábla indexei `szertartasok`
--
ALTER TABLE `szertartasok`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nameid` (`nameID`),
  ADD KEY `telepules` (`telepulesID`),
  ADD KEY `templom` (`templomID`),
  ADD KEY `celebrans` (`celebransID`),
  ADD KEY `kantor` (`kantorID`);

--
-- A tábla indexei `sznev`
--
ALTER TABLE `sznev`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `telepulesek`
--
ALTER TABLE `telepulesek`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `templomok`
--
ALTER TABLE `templomok`
  ADD PRIMARY KEY (`id`),
  ADD KEY `telepulesID` (`telepulesID`);

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `szertartasok`
--
ALTER TABLE `szertartasok`
  ADD CONSTRAINT `celebrans` FOREIGN KEY (`celebransID`) REFERENCES `author` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `kantor` FOREIGN KEY (`kantorID`) REFERENCES `author` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `nameid` FOREIGN KEY (`nameID`) REFERENCES `sznev` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `telepules` FOREIGN KEY (`telepulesID`) REFERENCES `telepulesek` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `templom` FOREIGN KEY (`templomID`) REFERENCES `templomok` (`id`) ON UPDATE CASCADE;

--
-- Megkötések a táblához `templomok`
--
ALTER TABLE `templomok`
  ADD CONSTRAINT `templomok_ibfk_1` FOREIGN KEY (`telepulesID`) REFERENCES `telepulesek` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
