-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Дек 12 2018 г., 06:56
-- Версия сервера: 10.2.15-MariaDB
-- Версия PHP: 7.2.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `cod`
--

-- --------------------------------------------------------

--
-- Структура таблицы `category`
--

CREATE TABLE `category` (
  `id_category` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='категории';

-- --------------------------------------------------------

--
-- Структура таблицы `done_task`
--

CREATE TABLE `done_task` (
  `id_done_task` int(11) NOT NULL,
  `id_polzov` int(11) NOT NULL,
  `id_task` int(11) NOT NULL,
  `id_lang` int(11) NOT NULL,
  `task_score_percent` int(11) NOT NULL,
  `task_correctness` int(11) NOT NULL,
  `task_perfomance` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `lang`
--

CREATE TABLE `lang` (
  `id_lang` int(11) NOT NULL,
  `name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `lessons`
--

CREATE TABLE `lessons` (
  `id_lesson` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `polzov`
--

CREATE TABLE `polzov` (
  `id_polzov` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `pas` varchar(255) NOT NULL,
  `role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Пользователи';

--
-- Дамп данных таблицы `polzov`
--

INSERT INTO `polzov` (`id_polzov`, `name`, `pas`, `role`) VALUES
(1, 'admin', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 0),
(3, 'stas', '123', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `statistic`
--

CREATE TABLE `statistic` (
  `id_statistic` int(11) NOT NULL,
  `id_polzov` int(11) NOT NULL,
  `id_task` int(11) NOT NULL,
  `percent` int(11) NOT NULL,
  `id_lang` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `task`
--

CREATE TABLE `task` (
  `id_task` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `id_category` int(11) NOT NULL,
  `tex_min` varchar(255) NOT NULL,
  `id_lesson` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='задачи';

-- --------------------------------------------------------

--
-- Структура таблицы `task_lang`
--

CREATE TABLE `task_lang` (
  `id_task_lang` int(11) NOT NULL,
  `id_task` int(11) NOT NULL,
  `id_lang` int(11) NOT NULL,
  `template_link_folder_code` varchar(512) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id_category`);

--
-- Индексы таблицы `done_task`
--
ALTER TABLE `done_task`
  ADD PRIMARY KEY (`id_done_task`),
  ADD KEY `id_polzov` (`id_polzov`);

--
-- Индексы таблицы `lang`
--
ALTER TABLE `lang`
  ADD PRIMARY KEY (`id_lang`);

--
-- Индексы таблицы `lessons`
--
ALTER TABLE `lessons`
  ADD PRIMARY KEY (`id_lesson`);

--
-- Индексы таблицы `polzov`
--
ALTER TABLE `polzov`
  ADD PRIMARY KEY (`id_polzov`);

--
-- Индексы таблицы `statistic`
--
ALTER TABLE `statistic`
  ADD PRIMARY KEY (`id_statistic`);

--
-- Индексы таблицы `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`id_task`);

--
-- Индексы таблицы `task_lang`
--
ALTER TABLE `task_lang`
  ADD PRIMARY KEY (`id_task_lang`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `category`
--
ALTER TABLE `category`
  MODIFY `id_category` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `done_task`
--
ALTER TABLE `done_task`
  MODIFY `id_done_task` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `lang`
--
ALTER TABLE `lang`
  MODIFY `id_lang` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `lessons`
--
ALTER TABLE `lessons`
  MODIFY `id_lesson` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `polzov`
--
ALTER TABLE `polzov`
  MODIFY `id_polzov` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `statistic`
--
ALTER TABLE `statistic`
  MODIFY `id_statistic` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `task`
--
ALTER TABLE `task`
  MODIFY `id_task` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `task_lang`
--
ALTER TABLE `task_lang`
  MODIFY `id_task_lang` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
