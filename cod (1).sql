-- phpMyAdmin SQL Dump
-- version 4.7.1
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Дек 21 2018 г., 16:56
-- Версия сервера: 5.7.18
-- Версия PHP: 7.1.5

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

--
-- Дамп данных таблицы `category`
--

INSERT INTO `category` (`id_category`, `name`) VALUES
(1, 'Легко');

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

--
-- Дамп данных таблицы `lang`
--

INSERT INTO `lang` (`id_lang`, `name`) VALUES
(1, 'с'),
(2, 'sharp');

-- --------------------------------------------------------

--
-- Структура таблицы `lessons`
--

CREATE TABLE `lessons` (
  `id_lesson` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `lessons`
--

INSERT INTO `lessons` (`id_lesson`, `name`, `description`) VALUES
(1, 'arrays', 'Массивы'),
(2, 'test', 'Тест');

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

--
-- Дамп данных таблицы `task`
--

INSERT INTO `task` (`id_task`, `name`, `text`, `id_category`, `tex_min`, `id_lesson`) VALUES
(1, 'cyclic_rotation', '<p>\r\n Задан массив A, состоящий из N целых чисел. Вращение массива означает, что каждый элемент смещается вправо на один индекс, а последний элемент массива перемещается на первое место. Например, поворот массива A = [3, 8, 9, 7, 6] равен [6, 3, 8, 9, 7] (элементы смещены вправо на один индекс, а 6 - на первое место).\r\n</p>\r\n<p>\r\nЦель состоит в том, чтобы вращать массив A K раз; то есть каждый элемент A будет сдвинут вправо K раз.\r\n</p>\r\n<p>\r\nНапишите функцию:\r\n</p>\r\n<p style = \"font-family: consolas;\"> class Solution {public int [] solution (int [] A, int K); } </p>\r\n<p>\r\nчто, учитывая массив A, состоящий из N целых чисел и целого числа K, возвращает массив A, повернутый K раз.\r\n</p>\r\n<p>\r\nНапример, учитывая\r\n</p>\r\n<p>\r\n    A = [3, 8, 9, 7, 6] <br>\r\n    К = 3\r\n</p>\r\n<p>\r\nфункция должна вернуть [9, 7, 6, 3, 8]. Три поворота были сделаны:\r\n</p>\r\n<p>\r\n    [3, 8, 9, 7, 6] -> [6, 3, 8, 9, 7] <br>\r\n    [6, 3, 8, 9, 7] -> [7, 6, 3, 8, 9] <br>\r\n    [7, 6, 3, 8, 9] -> [9, 7, 6, 3, 8] <br>\r\n</p>\r\n<p>\r\nДля другого примера, приведенного\r\n</p>\r\n<p>\r\n    A = [0, 0, 0] <br>\r\n    К = 1\r\n</p>\r\n<p>\r\nфункция должна вернуть [0, 0, 0]\r\n</p>\r\nДано\r\n<p>\r\n    A = [1, 2, 3, 4] <br>\r\n    К = 4\r\n</p>\r\n<p>\r\nфункция должна вернуть [1, 2, 3, 4]\r\n</p>\r\n<p>\r\nПредположим, что:\r\n</p>\r\n<p>\r\nN и K - целые числа в диапазоне [0..100];\r\nкаждый элемент массива A является целым числом в диапазоне [−1,000..1,000].\r\nВ вашем решении сосредоточьтесь на правильности. Эффективность вашего решения не будет в центре внимания оценки.\r\n</p>', 1, 'Циклическое вращение', 1),
(2, 'Test_task', 'just for test', 1, 'test...', 2);

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
-- Дамп данных таблицы `task_lang`
--

INSERT INTO `task_lang` (`id_task_lang`, `id_task`, `id_lang`, `template_link_folder_code`) VALUES
(1, 1, 1, 'data/code_templates/cyclic_rotation/c/'),
(2, 1, 2, 'data/code_templates/cyclic_rotation/sharp/');

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
  ADD PRIMARY KEY (`id_task`),
  ADD KEY `id_category` (`id_category`),
  ADD KEY `id_lesson` (`id_lesson`);

--
-- Индексы таблицы `task_lang`
--
ALTER TABLE `task_lang`
  ADD PRIMARY KEY (`id_task_lang`),
  ADD KEY `id_task` (`id_task`),
  ADD KEY `id_lang` (`id_lang`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `category`
--
ALTER TABLE `category`
  MODIFY `id_category` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT для таблицы `done_task`
--
ALTER TABLE `done_task`
  MODIFY `id_done_task` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `lang`
--
ALTER TABLE `lang`
  MODIFY `id_lang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `lessons`
--
ALTER TABLE `lessons`
  MODIFY `id_lesson` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
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
  MODIFY `id_task` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `task_lang`
--
ALTER TABLE `task_lang`
  MODIFY `id_task_lang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `task`
--
ALTER TABLE `task`
  ADD CONSTRAINT `task_ibfk_1` FOREIGN KEY (`id_lesson`) REFERENCES `lessons` (`id_lesson`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `task_ibfk_2` FOREIGN KEY (`id_category`) REFERENCES `category` (`id_category`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `task_lang`
--
ALTER TABLE `task_lang`
  ADD CONSTRAINT `task_lang_ibfk_1` FOREIGN KEY (`id_task`) REFERENCES `task` (`id_task`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `task_lang_ibfk_2` FOREIGN KEY (`id_lang`) REFERENCES `lang` (`id_lang`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;