-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Ноя 26 2019 г., 13:42
-- Версия сервера: 10.3.13-MariaDB
-- Версия PHP: 7.1.22

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
  `ID_DATE` int(11) NOT NULL,
  `MARK` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `attendance`
--

INSERT INTO `attendance` (`ID_ATT`, `ID_SUBJECT`, `ID_STUDENT`, `ID_DATE`, `MARK`) VALUES
(47, 2, 26, 3, 1),
(48, 2, 27, 3, 0),
(49, 2, 26, 34, 0),
(50, 2, 27, 34, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `courses`
--

CREATE TABLE `courses` (
  `ID_COURSE` int(11) NOT NULL,
  `COURSE_NAME` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `courses`
--

INSERT INTO `courses` (`ID_COURSE`, `COURSE_NAME`) VALUES
(1, '1 курс'),
(2, '2 курс'),
(3, '3 курс'),
(4, '4 курс'),
(5, '1 курс маг.'),
(6, '2 курс маг.');

-- --------------------------------------------------------

--
-- Структура таблицы `dates`
--

CREATE TABLE `dates` (
  `ID_DATE` int(11) NOT NULL,
  `DATE` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `dates`
--

INSERT INTO `dates` (`ID_DATE`, `DATE`) VALUES
(3, '01.12'),
(34, '12.12');

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
(1, '1 группа', 1, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `permissions`
--

CREATE TABLE `permissions` (
  `ID_PERMISSION` int(11) NOT NULL,
  `RANK` varchar(3) NOT NULL,
  `NAME_RANK` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `permissions`
--

INSERT INTO `permissions` (`ID_PERMISSION`, `RANK`, `NAME_RANK`) VALUES
(1, '001', 'user'),
(2, '011', 'teacher'),
(3, '111', 'dekan');

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

--
-- Дамп данных таблицы `students`
--

INSERT INTO `students` (`ID_STUDENT`, `FIO`, `ID_GROUP`, `ID_COURSE`) VALUES
(26, 'Аксенов Антон', 1, 1),
(27, 'Погорелов Руслан', 1, 1);

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
  `ID_PERMISSION` int(11) NOT NULL DEFAULT 1,
  `HASH` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`ID_USER`, `USERNAME`, `PASSWORD`, `ID_PERMISSION`, `HASH`) VALUES
(8, 'test', 'fb469d7ef430b0baf0cab6c436e70375', 3, 'b4c8c0be62ae318c84ae78a56d7024ce'),
(11, 'lol3', 'f23ba2b197c4495f2fd10ed813d7a9be', 1, 'ebcc32f84b1f9853e50915ddc691d91d');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`ID_ATT`),
  ADD KEY `ID_SUBJECT` (`ID_SUBJECT`),
  ADD KEY `ID_STUDENT` (`ID_STUDENT`),
  ADD KEY `ID_DATE` (`ID_DATE`);

--
-- Индексы таблицы `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`ID_COURSE`);

--
-- Индексы таблицы `dates`
--
ALTER TABLE `dates`
  ADD PRIMARY KEY (`ID_DATE`);

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
  ADD KEY `RANK` (`ID_PERMISSION`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `attendance`
--
ALTER TABLE `attendance`
  MODIFY `ID_ATT` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT для таблицы `dates`
--
ALTER TABLE `dates`
  MODIFY `ID_DATE` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT для таблицы `permissions`
--
ALTER TABLE `permissions`
  MODIFY `ID_PERMISSION` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `students`
--
ALTER TABLE `students`
  MODIFY `ID_STUDENT` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT для таблицы `subjects`
--
ALTER TABLE `subjects`
  MODIFY `ID_SUBJECT` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `ID_USER` tinyint(2) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `ATTENDANCE_ibfk_3` FOREIGN KEY (`ID_STUDENT`) REFERENCES `students` (`ID_STUDENT`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ATTENDANCE_ibfk_4` FOREIGN KEY (`ID_DATE`) REFERENCES `dates` (`ID_DATE`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`ID_SUBJECT`) REFERENCES `subjects` (`ID_SUBJECT`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `groups`
--
ALTER TABLE `groups`
  ADD CONSTRAINT `groups_ibfk_1` FOREIGN KEY (`ID_SUBJECT`) REFERENCES `subjects` (`ID_SUBJECT`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `groups_ibfk_2` FOREIGN KEY (`ID_COURSE`) REFERENCES `courses` (`ID_COURSE`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`ID_COURSE`) REFERENCES `courses` (`ID_COURSE`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `students_ibfk_2` FOREIGN KEY (`ID_GROUP`) REFERENCES `groups` (`ID_GROUP`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `subjects`
--
ALTER TABLE `subjects`
  ADD CONSTRAINT `subjects_ibfk_1` FOREIGN KEY (`ID_COURSE`) REFERENCES `courses` (`ID_COURSE`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`ID_PERMISSION`) REFERENCES `permissions` (`ID_PERMISSION`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
