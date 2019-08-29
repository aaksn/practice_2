-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:3306
-- Время создания: Авг 29 2019 г., 19:23
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
-- База данных: `db`
--

-- --------------------------------------------------------

--
-- Структура таблицы `attendance`
--

CREATE TABLE `attendance` (
  `ID_ATT` int(11) NOT NULL,
  `ID_SUBJECT` int(11) NOT NULL,
  `ID_STUDENT` int(11) NOT NULL,
  `DATE_POS` date NOT NULL,
  `MARK` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `courses`
--

CREATE TABLE `courses` (
  `ID_COURSE` int(11) NOT NULL,
  `COURSE_NAME` varchar(30) NOT NULL,
  `ID_GROUP` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `courses`
--

INSERT INTO `courses` (`ID_COURSE`, `COURSE_NAME`, `ID_GROUP`) VALUES
(1, '1 курс', NULL),
(2, '2 курс', NULL),
(3, '3 курс', NULL),
(4, '4 курс', NULL),
(5, '1 курс маг.', NULL),
(6, '2 курс маг.', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `groups`
--

CREATE TABLE `groups` (
  `ID_GROUP` int(11) NOT NULL,
  `GROUP_NAME` varchar(30) NOT NULL,
  `ID_COURSE` int(11) NOT NULL,
  `ID_SUBJECT` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `groups`
--

INSERT INTO `groups` (`ID_GROUP`, `GROUP_NAME`, `ID_COURSE`, `ID_SUBJECT`) VALUES
(1, '1 группа', 1, 2),
(1, '1 группа', 2, 1),
(1, '1 группа', 5, 4),
(2, '2 группа', 1, 2),
(2, '2 группа', 2, 0),
(3, '3 группа', 1, 2),
(4, '4 группа', 1, 2),
(4, '4 группа', 1, 4),
(5, '5 группа', 1, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `permissions`
--

CREATE TABLE `permissions` (
  `ID_PERMISSION` int(11) NOT NULL,
  `RANK` int(11) NOT NULL,
  `NAME_RANK` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `permissions`
--

INSERT INTO `permissions` (`ID_PERMISSION`, `RANK`, `NAME_RANK`) VALUES
(1, 777, 'root'),
(2, 111, 'user'),
(3, 222, 'teacher'),
(4, 666, 'moderator');

-- --------------------------------------------------------

--
-- Структура таблицы `students`
--

CREATE TABLE `students` (
  `ID_STUDENT` int(11) NOT NULL,
  `FIO` varchar(70) NOT NULL,
  `ID_GROUP` int(11) NOT NULL,
  `ID_COURSE` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `subjects`
--

CREATE TABLE `subjects` (
  `ID_SUBJECT` int(11) NOT NULL,
  `SUBJECT_NAME` varchar(40) NOT NULL,
  `ID_COURSE` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `subjects`
--

INSERT INTO `subjects` (`ID_SUBJECT`, `SUBJECT_NAME`, `ID_COURSE`) VALUES
(1, 'УрМат', 2),
(2, 'ТИПИС', 1),
(3, 'Метывычеты', 1),
(4, 'ФК', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `ID_USER` tinyint(2) UNSIGNED NOT NULL,
  `USERNAME` varchar(15) NOT NULL,
  `PASSWORD` varchar(32) NOT NULL,
  `RANK` int(11) NOT NULL,
  `HASH` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`ID_USER`, `USERNAME`, `PASSWORD`, `RANK`, `HASH`) VALUES
(2, 'root', 'root', 777, ''),
(3, 'teacher', 'teacher', 222, ''),
(4, 'moderator', 'moderator', 666, ''),
(5, 'user', 'user', 111, ''),
(6, 'first', '1fbf04ad51bd056831bad3b1f685aff7', 666, ''),
(7, 'rusik', '20b29fe263143860f94565d0092645d7', 666, ''),
(8, 'test', 'fb469d7ef430b0baf0cab6c436e70375', 666, '30ccd4fac47acd1e010d5bcb7a4806ec');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`ID_ATT`),
  ADD KEY `ID_SUBJECT` (`ID_SUBJECT`),
  ADD KEY `ID_STUDENT` (`ID_STUDENT`);

--
-- Индексы таблицы `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`ID_COURSE`);

--
-- Индексы таблицы `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`ID_GROUP`,`ID_COURSE`,`ID_SUBJECT`),
  ADD KEY `GROUPS_ibfk_1` (`ID_COURSE`),
  ADD KEY `ID_SUBJECT` (`ID_SUBJECT`);

--
-- Индексы таблицы `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`ID_PERMISSION`),
  ADD UNIQUE KEY `RANK` (`RANK`),
  ADD KEY `RANK_2` (`RANK`);

--
-- Индексы таблицы `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`ID_STUDENT`,`ID_GROUP`,`ID_COURSE`),
  ADD KEY `ID_COURSE` (`ID_COURSE`),
  ADD KEY `ID_GROUP` (`ID_GROUP`);

--
-- Индексы таблицы `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`ID_SUBJECT`),
  ADD KEY `ID_COURSE` (`ID_COURSE`),
  ADD KEY `ID_SUBJECT` (`ID_SUBJECT`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID_USER`),
  ADD UNIQUE KEY `username` (`USERNAME`),
  ADD KEY `RANK` (`RANK`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `attendance`
--
ALTER TABLE `attendance`
  MODIFY `ID_ATT` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `permissions`
--
ALTER TABLE `permissions`
  MODIFY `ID_PERMISSION` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `students`
--
ALTER TABLE `students`
  MODIFY `ID_STUDENT` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `subjects`
--
ALTER TABLE `subjects`
  MODIFY `ID_SUBJECT` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `ID_USER` tinyint(2) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `ATTENDANCE_ibfk_2` FOREIGN KEY (`ID_SUBJECT`) REFERENCES `subjects` (`ID_SUBJECT`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ATTENDANCE_ibfk_3` FOREIGN KEY (`ID_STUDENT`) REFERENCES `students` (`ID_STUDENT`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
