-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Ноя 25 2019 г., 23:52
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
(2, 2, 1, 1, 1),
(3, 2, 5, 1, 1),
(4, 2, 1, 2, 1),
(5, 2, 5, 2, 1),
(6, 2, 1, 3, 1),
(7, 2, 5, 3, 0),
(8, 2, 1, 4, 0),
(9, 2, 5, 4, 1),
(10, 2, 1, 5, 0),
(11, 2, 5, 5, 1),
(12, 2, 1, 6, 1),
(13, 2, 5, 6, 0),
(14, 2, 7, 1, 0),
(15, 2, 7, 2, 0),
(16, 2, 7, 3, 0),
(17, 2, 7, 4, 0),
(18, 2, 7, 5, 0),
(19, 2, 7, 6, 0),
(33, 2, 21, 5, 0),
(34, 2, 22, 1, 0),
(35, 2, 22, 2, 0),
(36, 2, 22, 3, 0),
(37, 2, 22, 4, 0),
(38, 2, 22, 5, 0),
(39, 2, 22, 6, 0),
(40, 2, 1, 31, 0),
(41, 2, 5, 31, 0),
(42, 2, 7, 31, 0),
(43, 2, 22, 31, 0),
(44, 2, 23, 5, 0);

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
(1, '10.10.18'),
(2, '23.01.19'),
(3, '01.10'),
(4, '12.05'),
(5, '01.01'),
(6, '01.01'),
(26, '01.01'),
(27, '01.01'),
(28, '01.01'),
(29, '01.01'),
(30, '01.01'),
(31, '01.01'),
(32, '01.01');

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
(1, '1 группа', 1, 3),
(1, '1 группа', 2, 1),
(1, '1 группа', 5, 4),
(2, '2 группа', 1, 2),
(3, '3 группа', 1, 2),
(3, '3 группа', 1, 3),
(4, '4 группа', 1, 2),
(4, '4 группа', 1, 3),
(4, '4 группа', 1, 4),
(5, '5 группа', 1, 2),
(6, '6 группа', 1, 2),
(7, '7 группа', 1, 2),
(8, '8 группа', 1, 2);

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
(1, 'Сидоров Иван Иванович аг', 1, 1),
(2, 'Сидоров Иван Иванович 2к', 1, 2),
(3, 'Сидоров Иван Иванович 3к', 1, 3),
(4, 'Сидоров Иван Иванович 4к', 1, 4),
(5, 'Иванов Иван Иванович', 1, 1),
(7, 'adfsgsfdgdfg', 1, 1),
(10, 'ФИО', 4, 1),
(15, 'ФИО', 6, 1),
(21, 'ФИО', 7, 1),
(22, 'Фио', 1, 1),
(23, 'ФИО', 8, 1);

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
(6, 'first', '1fbf04ad51bd056831bad3b1f685aff7', 1, ''),
(7, 'rusik', '20b29fe263143860f94565d0092645d7', 2, ''),
(8, 'test', 'fb469d7ef430b0baf0cab6c436e70375', 3, '73fca4c226c745b656ed339f28a091d2');

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
  MODIFY `ID_ATT` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT для таблицы `dates`
--
ALTER TABLE `dates`
  MODIFY `ID_DATE` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT для таблицы `permissions`
--
ALTER TABLE `permissions`
  MODIFY `ID_PERMISSION` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `students`
--
ALTER TABLE `students`
  MODIFY `ID_STUDENT` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

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
