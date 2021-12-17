-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Värd: 127.0.0.1
-- Tid vid skapande: 28 aug 2021 kl 12:13
-- Serverversion: 10.4.20-MariaDB
-- PHP-version: 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databas: `gesällprov_roen8744`
--

-- --------------------------------------------------------

--
-- Tabellstruktur `account`
--

CREATE TABLE `account` (
  `id` int(11) NOT NULL,
  `firstname` varchar(64) COLLATE utf8_bin NOT NULL,
  `lastname` varchar(64) COLLATE utf8_bin NOT NULL,
  `email` varchar(128) COLLATE utf8_bin NOT NULL,
  `password` varchar(256) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumpning av Data i tabell `account`
--

INSERT INTO `account` (`id`, `firstname`, `lastname`, `email`, `password`) VALUES
(1, 'Robert', 'Englund', 'roen8744@student.su.se', '$2y$10$aZqK.MovOGsf.gsDq4r4Ge7dZE5P/GQG3g0N0EjDRo5b6nrEI9MDu'),
(2, 'Test', 'Test', 'test@test.test', '$2y$10$HRsJ3VwPIrADW.ekJJC5YuJR/Y0eRqtaJs/pmeczLDR2CzEKA82C2'),
(3, 'ASJDoad', 'joaisdj', 'joasidjasoidjoa@asdoasdkp.com', '$2y$10$v.s5q3pbuWH/yaE3RJGDj.Q7pBPfko2qj15V065KaIMtTPkVFWYai'),
(4, 'Maria', 'TEST', 'maria@maria.maria', '$2y$10$yqkIbxhmGiE3vG3RZNEZI.ZUCo3jX6lg66y.yVNXohmPk2ouxDwLS'),
(5, 'Erik', 'TEST', 'erik@erik.erik', '$2y$10$itQH3bpnWkYVyAg2sMOSQ.s8ThUKjqk6N9CmV3cgU1g2HGDCro8Ve'),
(6, 'Anna', 'TEST', 'anna@anna.anna', '$2y$10$LJzsahsQq5pefk8AwPER2.LLykoZEYT0/Otjg0AF5Ae5QmuL/Y6cK'),
(7, 'Lars', 'TEST', 'lars@lars.lars', '$2y$10$oDEFJjXJCiu.IGY7bgAAJObeDNpYGIBalfTNw2S1ciYS7Sx9qXHoO'),
(8, 'Margareta', 'TEST', 'margareta@margareta.margareta', '$2y$10$gk5sVqKuG7.YuuuDA6KnVeCpsDcPe.mw5eQAsYxhgvIrf9I3kARKG'),
(9, 'Karl', 'TEST', 'karl@karl.karl', '$2y$10$wI49yZzlyY3Uk1s0WTq24.p7RYowrqJJHuEOec/tzBvlWzlQ7yYZO'),
(10, 'Eva', 'TEST', 'eva@eva.eva', '$2y$10$/EAXS/LyKiKlqaOAWKFRKumVIVaCPpu94E4IThEver2IGhXEZcuGq'),
(11, 'John', 'TEST', 'john@john.john', '$2y$10$k8xuiDzT0HB5rm46Gp/mOe.mikAvbNfOlpYmpFVhMjTnBFktGdToW');

-- --------------------------------------------------------

--
-- Tabellstruktur `admin`
--

CREATE TABLE `admin` (
  `account_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumpning av Data i tabell `admin`
--

INSERT INTO `admin` (`account_id`) VALUES
(1);

-- --------------------------------------------------------

--
-- Tabellstruktur `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `firstname` varchar(128) COLLATE utf8_bin NOT NULL,
  `lastname` varchar(128) COLLATE utf8_bin NOT NULL,
  `message` varchar(1024) COLLATE utf8_bin NOT NULL,
  `awaiting_respond` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumpning av Data i tabell `contact`
--

INSERT INTO `contact` (`id`, `firstname`, `lastname`, `message`, `awaiting_respond`) VALUES
(1, 'Robert', 'Englund', 'Jag tycker denna hemsida är fantastisk.', 0),
(5, 'Robert', 'Englund', 'Jag tycker ni borde införa ett kundsystem för era att tjäna bonusar. Jag vill har rabbater!', 0),
(6, 'Robert', 'Englund', 'Jag har fått en digital biljett av er men den är väldigt konstig. Är detta verkligen en korrekt biljett? Ser inte ut som en QR-kod, bara massa slumpade prickar.', 1),
(7, 'asdasd', 'asdasd', 'askjdopiasdkpoaisd', 0),
(8, 'ASdASD', 'ASDasdasd', 'asjduiadhjas\ndajsd\nsad', 1),
(9, 'ASdasd', 'SAdasdsdasd', 'asdasdsadsdad', 1),
(10, 'asdasd', 'asdasd', 'asdasdasdasd', 0),
(11, 'asdasd', 'asdasd', 'asdasdasdasdasd', 0),
(12, 'Aasdasd', 'Aasdasd', 'asdasdasdasdasd', 0),
(13, 'asdasd', 'asdasd', 'asdasdasd', 0),
(14, 'sdasdasd', 'sdada', 'aasda', 0),
(15, 'Asadas', 'ASasdasd', 'asdasdasdasdasdasd', 0),
(16, 'Aasdkpoasdkaspd', 'kpokOPkapsodkaposd', 'asdasdjioajda\nsdhjaso\ndjaso\ndjsad', 1),
(17, 'Aasdasd', 'Aasdasd', 'asdasdad09asd9 0asdu\nsadk\nåsfasåf', 1),
(18, 'asdASDasd', 'AASDasdasdASD', 'asljksokadasoddkas\nd\nkasdkaskd\nkåasd', 1),
(19, 'Aasdas', 'asasdasd', 'asnjidjasndiuoashdoauf\'a', 1),
(20, 'Robert', 'Englund', 'asjdoiasjdasjdoasjda\nsdjaispdjas\ndjasdj\nasd', 1);

-- --------------------------------------------------------

--
-- Tabellstruktur `location`
--

CREATE TABLE `location` (
  `id` int(11) NOT NULL,
  `name` varchar(64) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumpning av Data i tabell `location`
--

INSERT INTO `location` (`id`, `name`) VALUES
(2, 'göteborg'),
(3, 'malmö'),
(1, 'stockholm'),
(4, 'uppsala');

-- --------------------------------------------------------

--
-- Tabellstruktur `occupation`
--

CREATE TABLE `occupation` (
  `id` int(11) NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `train_id` int(11) NOT NULL,
  `seat_id` int(11) NOT NULL,
  `trip_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumpning av Data i tabell `occupation`
--

INSERT INTO `occupation` (`id`, `ticket_id`, `train_id`, `seat_id`, `trip_id`) VALUES
(7, 6, 1, 1, 4),
(8, 6, 1, 3, 4),
(9, 6, 1, 50, 4),
(10, 7, 1, 4, 4),
(11, 7, 1, 11, 4),
(12, 7, 1, 18, 4),
(13, 7, 1, 22, 4),
(14, 7, 1, 29, 4),
(15, 7, 1, 36, 4),
(16, 8, 1, 13, 4),
(17, 8, 1, 14, 4),
(18, 8, 1, 15, 4),
(19, 9, 1, 37, 4),
(20, 9, 1, 38, 4),
(21, 9, 1, 39, 4),
(22, 9, 1, 40, 4),
(23, 9, 1, 41, 4),
(24, 9, 1, 42, 4),
(25, 10, 1, 2, 7),
(26, 10, 1, 3, 7),
(27, 11, 1, 7, 8),
(28, 11, 1, 8, 8),
(29, 11, 1, 9, 8),
(30, 11, 1, 10, 8),
(31, 11, 1, 11, 8),
(32, 11, 1, 12, 8),
(33, 12, 1, 34, 7),
(34, 12, 1, 33, 7),
(35, 13, 1, 25, 4),
(36, 13, 1, 26, 4),
(37, 13, 1, 27, 4);

-- --------------------------------------------------------

--
-- Tabellstruktur `payment`
--

CREATE TABLE `payment` (
  `id` int(11) NOT NULL,
  `card_number` varchar(16) COLLATE utf8_bin NOT NULL,
  `card_holder` varchar(128) COLLATE utf8_bin NOT NULL,
  `card_expire` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumpning av Data i tabell `payment`
--

INSERT INTO `payment` (`id`, `card_number`, `card_holder`, `card_expire`) VALUES
(7, '1111222233334444', 'Robert Englund', '2029-09-01'),
(8, '1111222233334444', 'Robert Englund', '2022-04-01'),
(9, '1111222233334445', 'Test Test', '2022-04-01');

-- --------------------------------------------------------

--
-- Tabellstruktur `profile_picture`
--

CREATE TABLE `profile_picture` (
  `account_id` int(11) NOT NULL,
  `file` varchar(256) COLLATE utf8_bin NOT NULL,
  `extension` varchar(10) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumpning av Data i tabell `profile_picture`
--

INSERT INTO `profile_picture` (`account_id`, `file`, `extension`) VALUES
(1, 'user-1.png', 'png');

-- --------------------------------------------------------

--
-- Tabellstruktur `remember`
--

CREATE TABLE `remember` (
  `id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `authentication` varchar(1024) COLLATE utf8_bin NOT NULL,
  `created_date` date NOT NULL,
  `expire_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumpning av Data i tabell `remember`
--

INSERT INTO `remember` (`id`, `account_id`, `authentication`, `created_date`, `expire_date`) VALUES
(5, 1, 'WkGsFoQsPyKsZrYvZlTnZhZhMgViWnBlZiCuRoXlNfIaYrOoIdVqPjUhBpWxMtCcFmXoLmAgSkHpBaMiZwEtLzLdCiXvOnRdShCw1UxNaWtHsJxYqKxGkKoFfOkLlJzSbRxOfDjYqGqBbPlDvNjPaPvPkHrQyKeNrStIkFoCqVvCnDzCgVvDkVeKkKrSsAhJmAuCkObRv', '2021-08-03', '2021-11-01'),
(6, 3, 'EwMrTaZpGqGlYtQqLkKjAfAgTdXaUoOnGbXgQhVbKfWuUwFtOqEvAhJtBwJqRcTxVjGyYlJgEuHbRqMeYmQwAhZpKhMfXeKuKkSi3CgKwGsWoFmZmExRpJnWdOqDqYpOmVhGoIsCjAeQxSkXcNnGgAxQrQcIeCyHzGlFpJkYxQoKgLaKiJzIjEcBiJfCdCbLdGvKkNuXb', '2021-08-03', '2021-11-01'),
(7, 2, 'QtYgExTgViQhEfArMuGrDfYzXwVcPkXjRpFaGqKwVvTbNhFfDbLvMnPeMfSeMgJkLeMhXvVeFgKvXpQkOhXvSuYmRnOgBlFgIgVo2ZhSbAkGiFjAmPxJaEuZtEiQkFiDtIkVeHzZjIfAeKgMdXwFvDbHpBpBtGjFnLfKpKgSeOkAlYyGmJfEaBlKzSmCbIvRnDqHiRfUw', '2021-08-03', '2021-11-01'),
(9, 1, 'JjMdZnLsIxWoZwLeTfDuKcFrXsPcVtSlQfWwAtCyFfVaKjVzDmQxPjXoGgZcEoRmHyHcHtFkKzSfBqBsBvVeOgKwDlFaIkHrKiAo1DjOwSzRsWiTvVqNuDjHiIrKfRfVjDqFpEtQmDuFxTpOcGuXaPiEfTjCsJeQaRoUvFqFkXlQdOgShAcXhGcExQyIhKkZdWsKbTqAg', '2021-08-12', '2021-11-10'),
(10, 1, 'JaXsRkPlNxOzMyXdRgBkWvQqFyQiGhIbDhXsRlMxMqVjJlBxGfJnCpCxAdEbYeAiWkHfTnYcJwZsYsWiDpTkFbMhMtJdMtDrJgUi1YxXuSiNrTaUvUuZpStLjWpGhRfRcXiLxDfWkZyBkNwFgWgXqRmVpCaJvQcKpWnJuPaNqPnPaMdEkIfOhJtJvQeWxCbRqGqFnWvUo', '2021-08-13', '2021-11-11'),
(11, 2, 'BrStTdVcDbFkEwJwRdGeXqEfYuMhQcXnEaBzSeJyKbWuYuBkOdFwZmOnHzDdWdNmGwXsXyFrFcXhRpLnTmWrGwBhAhCjXvNuGbSi2YwTtGiUgXzCbDwKxHwTnPtQsQlMoWcNgTmRdNnUjRxXxQxYgRzBsDjQdHjMhViZvNrLbAlQsJcNcWdIgWsZrZoEiEaPaZzOzLePb', '2021-08-17', '2021-11-15'),
(12, 1, 'CdYtZoBbCwBxLrHaTuIwNzQnChTrIoDfKeYpYrWjSpHtSyJwPeWvJfBqGkOaOnTsRdDyYbIvWzQoGqMhMtMvSmBnDhXtDtNtJhMj1MkNyOiEwWiToDbPvUvZkMtReKzEgCxJdLnQgWlMyZuSfFzIaZvKaEeDzWoFnUsNbEsYbHdExQbMfVyLeUsBzUdCsMjSqQhJkWrXr', '2021-08-21', '2021-11-19'),
(23, 1, 'SqMqCjXwGdPiUvFxMaNpGdHwJwGwLuBeXaAvToYwSmNvIpNeUuMyJeGqRmYnDcSxVkBwKmYuMaNlSlIhPoPlPdVgTaKuZfFiGdUg1HtAbSxUvMjPtJtYwToZqRsStIxCaHoYsDzHoGwUbVwVtUrRuUmLzAiBpEiXxYkCwEcLlOuEaPgXqEvSjThMyWlItUtVkJmHrVvWb', '2021-08-28', '2021-11-26');

-- --------------------------------------------------------

--
-- Tabellstruktur `respond_email`
--

CREATE TABLE `respond_email` (
  `contact_id` int(11) NOT NULL,
  `email` varchar(256) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumpning av Data i tabell `respond_email`
--

INSERT INTO `respond_email` (`contact_id`, `email`) VALUES
(19, 'asdasdasdj98asd@asjoidasd.com'),
(20, 'kastanjen3@gmail.com');

-- --------------------------------------------------------

--
-- Tabellstruktur `respond_letter`
--

CREATE TABLE `respond_letter` (
  `contact_id` int(11) NOT NULL,
  `adress` varchar(128) COLLATE utf8_bin NOT NULL,
  `zip` varchar(5) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumpning av Data i tabell `respond_letter`
--

INSERT INTO `respond_letter` (`contact_id`, `adress`, `zip`) VALUES
(17, 'asdaasdasd', '21384');

-- --------------------------------------------------------

--
-- Tabellstruktur `respond_phone`
--

CREATE TABLE `respond_phone` (
  `contact_id` int(11) NOT NULL,
  `phone` varchar(12) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumpning av Data i tabell `respond_phone`
--

INSERT INTO `respond_phone` (`contact_id`, `phone`) VALUES
(18, '8756435476');

-- --------------------------------------------------------

--
-- Tabellstruktur `review`
--

CREATE TABLE `review` (
  `id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `content` varchar(1024) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumpning av Data i tabell `review`
--

INSERT INTO `review` (`id`, `account_id`, `content`) VALUES
(1, 1, 'Jag gillar denna hemsida :)'),
(3, 4, 'Vår tågresa med TuffeTuffeTåg var den bästa tågresan vi haft. Det var lugnt, bra service och deras tysta hytter gjorde det möjligt att sitta och kolla ut, lugnt och sansat.'),
(4, 5, 'Det var ett nöje att åka med TuffeTuffeTåg. Allt som man förväntar sig att ett modernt tåg ska ha hade de.'),
(5, 6, 'När vi insåg att vi hade bokat en resa på fel datum fick vi hjälp att boka om. Det var helt avgörande för att semestern inte skulle bli förstörd. Deras kundtjänst äger!'),
(6, 7, 'Alltid gott med gratis kafé!'),
(7, 8, 'TuffeTuffeTågs WiFi är nog det bästa som ett tåg någonsin har erbjudit. Det var väldigt lätt att vara produktiv och vi lite arbete gjort medans man åkte med dem.'),
(8, 9, 'Det var väldigt enkelt att boka och ifall det behövdes, vilket det gjorde för oss, boka om utan problem. Dem bryr sig verkligen om deras resenärer!'),
(9, 10, 'TuffeTuffeTågs tåg är jätte fräsha, morderna. Ifall man åker tåg så är TuffeTuffeTågs tåg dem bästa att åka med. Alla måste åka minst en gång. Sedan blir måste man försöka hålla sig från att åka igen.'),
(10, 11, 'Resorna är väldigt prisvärda. Jag trodde aldrig att en tågresa för detta pris skulle vara såhär bra. Rekommenderar starkt!');

-- --------------------------------------------------------

--
-- Tabellstruktur `seat`
--

CREATE TABLE `seat` (
  `train_id` int(11) NOT NULL,
  `seat_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumpning av Data i tabell `seat`
--

INSERT INTO `seat` (`train_id`, `seat_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 8),
(1, 9),
(1, 10),
(1, 11),
(1, 12),
(1, 13),
(1, 14),
(1, 15),
(1, 16),
(1, 17),
(1, 18),
(1, 19),
(1, 20),
(1, 21),
(1, 22),
(1, 23),
(1, 24),
(1, 25),
(1, 26),
(1, 27),
(1, 28),
(1, 29),
(1, 30),
(1, 31),
(1, 32),
(1, 33),
(1, 34),
(1, 35),
(1, 36),
(1, 37),
(1, 38),
(1, 39),
(1, 40),
(1, 41),
(1, 42),
(1, 43),
(1, 44),
(1, 45),
(1, 46),
(1, 47),
(1, 48),
(1, 49),
(1, 50),
(2, 1),
(2, 2),
(2, 3),
(2, 4),
(2, 5),
(2, 6),
(2, 7),
(2, 8),
(2, 9),
(3, 1),
(4, 1);

-- --------------------------------------------------------

--
-- Tabellstruktur `setting`
--

CREATE TABLE `setting` (
  `account_id` int(11) NOT NULL,
  `notification_upcoming` tinyint(1) NOT NULL,
  `notification_recommended` tinyint(1) NOT NULL,
  `payment_save` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumpning av Data i tabell `setting`
--

INSERT INTO `setting` (`account_id`, `notification_upcoming`, `notification_recommended`, `payment_save`) VALUES
(1, 0, 1, 1),
(2, 1, 0, 0),
(3, 0, 0, 0),
(4, 0, 0, 0),
(5, 0, 0, 0),
(6, 0, 0, 0),
(7, 0, 0, 0),
(8, 0, 0, 0),
(9, 0, 0, 0),
(10, 0, 0, 0),
(11, 0, 0, 0);

-- --------------------------------------------------------

--
-- Tabellstruktur `subscriber`
--

CREATE TABLE `subscriber` (
  `email` varchar(1024) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumpning av Data i tabell `subscriber`
--

INSERT INTO `subscriber` (`email`) VALUES
('asd@asd.com'),
('kastanjen3@gmail.com');

-- --------------------------------------------------------

--
-- Tabellstruktur `ticket`
--

CREATE TABLE `ticket` (
  `id` int(11) NOT NULL,
  `adult` int(11) NOT NULL,
  `kid` int(11) NOT NULL,
  `payment_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `trip_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumpning av Data i tabell `ticket`
--

INSERT INTO `ticket` (`id`, `adult`, `kid`, `payment_id`, `account_id`, `trip_id`) VALUES
(6, 1, 2, 7, 1, 4),
(7, 3, 3, 8, 1, 4),
(8, 1, 2, 8, 1, 4),
(9, 3, 3, 9, 2, 4),
(10, 1, 1, 8, 1, 7),
(11, 3, 3, 8, 1, 8),
(12, 1, 1, 8, 1, 7),
(13, 1, 2, 8, 1, 4);

-- --------------------------------------------------------

--
-- Tabellstruktur `train`
--

CREATE TABLE `train` (
  `id` int(11) NOT NULL,
  `model` varchar(64) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumpning av Data i tabell `train`
--

INSERT INTO `train` (`id`, `model`) VALUES
(1, 'AX100'),
(2, 'UF7000'),
(3, 'HJ303'),
(4, 'LU908');

-- --------------------------------------------------------

--
-- Tabellstruktur `trip`
--

CREATE TABLE `trip` (
  `id` int(11) NOT NULL,
  `location_from` int(11) NOT NULL,
  `location_to` int(11) NOT NULL,
  `departure` datetime NOT NULL,
  `track` int(11) NOT NULL,
  `train_id` int(11) NOT NULL,
  `arrival` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumpning av Data i tabell `trip`
--

INSERT INTO `trip` (`id`, `location_from`, `location_to`, `departure`, `track`, `train_id`, `arrival`) VALUES
(1, 1, 2, '2021-08-04 11:50:00', 17, 1, '2021-08-05 11:50:00'),
(2, 2, 1, '2021-08-05 11:51:00', 17, 1, '2021-08-06 11:50:00'),
(3, 1, 2, '2021-08-04 11:50:00', 18, 3, '2021-08-06 11:50:00'),
(4, 1, 2, '2022-08-10 13:48:00', 2, 1, '2022-08-10 16:55:00'),
(5, 1, 2, '2022-08-10 13:48:00', 3, 2, '2022-08-10 16:55:00'),
(6, 1, 2, '2022-08-10 13:48:00', 4, 3, '2022-08-10 16:55:00'),
(7, 2, 1, '2022-08-10 17:54:00', 67, 1, '2022-08-10 22:03:00'),
(8, 1, 3, '2021-07-01 10:33:00', 45, 1, '2021-07-02 10:33:00'),
(9, 1, 4, '2024-01-01 00:00:00', 12, 4, '2024-01-02 00:00:00'),
(10, 1, 4, '2024-01-01 00:00:00', 13, 1, '2024-01-02 00:00:00');

--
-- Index för dumpade tabeller
--

--
-- Index för tabell `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email_2` (`email`),
  ADD KEY `email` (`email`);

--
-- Index för tabell `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`account_id`);

--
-- Index för tabell `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Index för tabell `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `name_2` (`name`);

--
-- Index för tabell `occupation`
--
ALTER TABLE `occupation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_id` (`ticket_id`),
  ADD KEY `train_id` (`train_id`,`seat_id`),
  ADD KEY `trip_id` (`trip_id`);

--
-- Index för tabell `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`);

--
-- Index för tabell `profile_picture`
--
ALTER TABLE `profile_picture`
  ADD PRIMARY KEY (`account_id`);

--
-- Index för tabell `remember`
--
ALTER TABLE `remember`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account_id` (`account_id`);

--
-- Index för tabell `respond_email`
--
ALTER TABLE `respond_email`
  ADD PRIMARY KEY (`contact_id`);

--
-- Index för tabell `respond_letter`
--
ALTER TABLE `respond_letter`
  ADD PRIMARY KEY (`contact_id`);

--
-- Index för tabell `respond_phone`
--
ALTER TABLE `respond_phone`
  ADD PRIMARY KEY (`contact_id`);

--
-- Index för tabell `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account_id` (`account_id`);

--
-- Index för tabell `seat`
--
ALTER TABLE `seat`
  ADD PRIMARY KEY (`train_id`,`seat_id`);

--
-- Index för tabell `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`account_id`);

--
-- Index för tabell `subscriber`
--
ALTER TABLE `subscriber`
  ADD PRIMARY KEY (`email`);

--
-- Index för tabell `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payment_id` (`payment_id`),
  ADD KEY `account_id` (`account_id`),
  ADD KEY `trip_id` (`trip_id`);

--
-- Index för tabell `train`
--
ALTER TABLE `train`
  ADD PRIMARY KEY (`id`);

--
-- Index för tabell `trip`
--
ALTER TABLE `trip`
  ADD PRIMARY KEY (`id`),
  ADD KEY `location_from` (`location_from`),
  ADD KEY `location_to` (`location_to`),
  ADD KEY `train_id` (`train_id`),
  ADD KEY `departure` (`departure`),
  ADD KEY `arrival` (`arrival`),
  ADD KEY `track` (`track`);

--
-- AUTO_INCREMENT för dumpade tabeller
--

--
-- AUTO_INCREMENT för tabell `account`
--
ALTER TABLE `account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT för tabell `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT för tabell `location`
--
ALTER TABLE `location`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT för tabell `occupation`
--
ALTER TABLE `occupation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT för tabell `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT för tabell `remember`
--
ALTER TABLE `remember`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT för tabell `review`
--
ALTER TABLE `review`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT för tabell `ticket`
--
ALTER TABLE `ticket`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT för tabell `train`
--
ALTER TABLE `train`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT för tabell `trip`
--
ALTER TABLE `trip`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restriktioner för dumpade tabeller
--

--
-- Restriktioner för tabell `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restriktioner för tabell `occupation`
--
ALTER TABLE `occupation`
  ADD CONSTRAINT `occupation_ibfk_1` FOREIGN KEY (`ticket_id`) REFERENCES `ticket` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `occupation_ibfk_2` FOREIGN KEY (`train_id`,`seat_id`) REFERENCES `seat` (`train_id`, `seat_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `occupation_ibfk_3` FOREIGN KEY (`trip_id`) REFERENCES `trip` (`id`) ON UPDATE CASCADE;

--
-- Restriktioner för tabell `profile_picture`
--
ALTER TABLE `profile_picture`
  ADD CONSTRAINT `profile_picture_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restriktioner för tabell `remember`
--
ALTER TABLE `remember`
  ADD CONSTRAINT `remember_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restriktioner för tabell `respond_email`
--
ALTER TABLE `respond_email`
  ADD CONSTRAINT `respond_email_ibfk_1` FOREIGN KEY (`contact_id`) REFERENCES `contact` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restriktioner för tabell `respond_letter`
--
ALTER TABLE `respond_letter`
  ADD CONSTRAINT `respond_letter_ibfk_1` FOREIGN KEY (`contact_id`) REFERENCES `contact` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restriktioner för tabell `respond_phone`
--
ALTER TABLE `respond_phone`
  ADD CONSTRAINT `respond_phone_ibfk_1` FOREIGN KEY (`contact_id`) REFERENCES `contact` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restriktioner för tabell `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restriktioner för tabell `seat`
--
ALTER TABLE `seat`
  ADD CONSTRAINT `seat_ibfk_1` FOREIGN KEY (`train_id`) REFERENCES `train` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restriktioner för tabell `setting`
--
ALTER TABLE `setting`
  ADD CONSTRAINT `setting_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restriktioner för tabell `ticket`
--
ALTER TABLE `ticket`
  ADD CONSTRAINT `ticket_ibfk_1` FOREIGN KEY (`payment_id`) REFERENCES `payment` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `ticket_ibfk_2` FOREIGN KEY (`account_id`) REFERENCES `account` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `ticket_ibfk_3` FOREIGN KEY (`trip_id`) REFERENCES `trip` (`id`) ON UPDATE CASCADE;

--
-- Restriktioner för tabell `trip`
--
ALTER TABLE `trip`
  ADD CONSTRAINT `trip_ibfk_1` FOREIGN KEY (`location_from`) REFERENCES `location` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `trip_ibfk_2` FOREIGN KEY (`location_to`) REFERENCES `location` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `trip_ibfk_3` FOREIGN KEY (`train_id`) REFERENCES `train` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
