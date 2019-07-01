-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:3306
-- Время создания: Июл 01 2019 г., 08:27
-- Версия сервера: 5.7.24-0ubuntu0.18.04.1
-- Версия PHP: 7.2.12-1+ubuntu18.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `courses`
--

-- --------------------------------------------------------

--
-- Структура таблицы `c1`
--

CREATE TABLE `c1` (
  `groupid` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `c1`
--

INSERT INTO `c1` (`groupid`, `name`) VALUES
(1, '1 группа'),
(2, '1 группа');

-- --------------------------------------------------------

--
-- Структура таблицы `c2`
--

CREATE TABLE `c2` (
  `groupid` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `c2`
--

INSERT INTO `c2` (`groupid`, `name`) VALUES
(1, '2 группа');

-- --------------------------------------------------------

--
-- Структура таблицы `с3`
--

CREATE TABLE `с3` (
  `groupid` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Структура таблицы `с4`
--

CREATE TABLE `с4` (
  `groupid` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Структура таблицы `с5`
--

CREATE TABLE `с5` (
  `groupid` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `c1`
--
ALTER TABLE `c1`
  ADD PRIMARY KEY (`groupid`);

--
-- Индексы таблицы `c2`
--
ALTER TABLE `c2`
  ADD PRIMARY KEY (`groupid`);

--
-- Индексы таблицы `с3`
--
ALTER TABLE `с3`
  ADD PRIMARY KEY (`groupid`);

--
-- Индексы таблицы `с4`
--
ALTER TABLE `с4`
  ADD PRIMARY KEY (`groupid`);

--
-- Индексы таблицы `с5`
--
ALTER TABLE `с5`
  ADD PRIMARY KEY (`groupid`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `c1`
--
ALTER TABLE `c1`
  MODIFY `groupid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `c2`
--
ALTER TABLE `c2`
  MODIFY `groupid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `с3`
--
ALTER TABLE `с3`
  MODIFY `groupid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `с4`
--
ALTER TABLE `с4`
  MODIFY `groupid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `с5`
--
ALTER TABLE `с5`
  MODIFY `groupid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
