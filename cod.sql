-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:3306
-- Время создания: Мар 05 2019 г., 09:23
-- Версия сервера: 5.7.25-0ubuntu0.18.04.2
-- Версия PHP: 7.2.15-0ubuntu0.18.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
(1, 'Легко'),
(2, 'Средне'),
(3, 'Сложно');

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
(5, 'TimeComplexity', 'Ограничение по времени');

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
(1, 'admin', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 0);

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

--
-- Дамп данных таблицы `statistic`
--

INSERT INTO `statistic` (`id_statistic`, `id_polzov`, `id_task`, `percent`, `id_lang`) VALUES
(1, 1, 1, 100, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `task`
--

CREATE TABLE `task` (
  `id_task` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `rus_name` varchar(255) DEFAULT NULL,
  `text` text NOT NULL,
  `id_category` int(11) NOT NULL,
  `tex_min` varchar(255) NOT NULL,
  `id_lesson` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='задачи';

--
-- Дамп данных таблицы `task`
--

INSERT INTO `task` (`id_task`, `name`, `rus_name`, `text`, `id_category`, `tex_min`, `id_lesson`) VALUES
(1, 'cyclic_rotation', 'Циклическое вращение', '<p>&nbsp;Задан массив A, состоящий из N целых чисел. Вращение массива означает, что каждый элемент смещается вправо на один индекс, а последний элемент массива перемещается на первое место. Например, поворот массива A = [3, 8, 9, 7, 6] равен [6, 3, 8, 9, 7] (элементы смещены вправо на один индекс, а 6 - на первое место).</p>\r\n\r\n<p>Цель состоит в том, чтобы вращать массив A K раз; то есть каждый элемент A будет сдвинут вправо K раз.</p>\r\n\r\n<p>Напишите функцию:</p>\r\n\r\n<p>class Solution {public int [] solution (int [] A, int K); }</p>\r\n\r\n<p>что, учитывая массив A, состоящий из N целых чисел и целого числа K, возвращает массив A, повернутый K раз.</p>\r\n\r\n<p>Например, учитывая</p>\r\n\r\n<p>&nbsp;&nbsp;&nbsp;&nbsp;A = [3, 8, 9, 7, 6]<br />\r\n&nbsp;&nbsp;&nbsp;&nbsp;К = 3</p>\r\n\r\n<p>функция должна вернуть [9, 7, 6, 3, 8]. Три поворота были сделаны:</p>\r\n\r\n<p>&nbsp;&nbsp;&nbsp;&nbsp;[3, 8, 9, 7, 6] -&gt; [6, 3, 8, 9, 7]<br />\r\n&nbsp;&nbsp;&nbsp;&nbsp;[6, 3, 8, 9, 7] -&gt; [7, 6, 3, 8, 9]<br />\r\n&nbsp;&nbsp;&nbsp;&nbsp;[7, 6, 3, 8, 9] -&gt; [9, 7, 6, 3, 8]</p>\r\n\r\n<p>Для другого примера, приведенного</p>\r\n\r\n<p>&nbsp;&nbsp;&nbsp;&nbsp;A = [0, 0, 0]<br />\r\n&nbsp;&nbsp;&nbsp;&nbsp;К = 1</p>\r\n\r\n<p>функция должна вернуть [0, 0, 0]</p>\r\n\r\n<p>Дано</p>\r\n\r\n<p>&nbsp;&nbsp;&nbsp;&nbsp;A = [1, 2, 3, 4]<br />\r\n&nbsp;&nbsp;&nbsp;&nbsp;К = 4</p>\r\n\r\n<p>функция должна вернуть [1, 2, 3, 4]</p>\r\n\r\n<p>Предположим, что:</p>\r\n\r\n<p>N и K - целые числа в диапазоне [0..100]; каждый элемент массива A является целым числом в диапазоне [&minus;1,000..1,000]. В вашем решении сосредоточьтесь на правильности. Эффективность вашего решения не будет в центре внимания оценки.</p>\r\n', 1, 'Поверните массив вправо на указанное количество шагов.', 1),
(19, 'PermMissingElem', 'Найти пропущенный элемент', '<p>Задан массив A, состоящий из N различных целых чисел. Массив содержит целые числа в диапазоне [1 .. (N + 1)], что означает, что отсутствует только один элемент.</p>\r\n\r\n<p>Ваша цель - найти этот недостающий элемент.</p>\r\n\r\n<p>Напишите функцию:</p>\r\n\r\n<p>которая, учитывая массив A, возвращает значение отсутствующего элемента.</p>\r\n\r\n<p>Например, заданный массив A такой, что:</p>\r\n\r\n<p>&nbsp;&nbsp;&nbsp;A [0] = 2<br />\r\n&nbsp;&nbsp;&nbsp;A [1] = 3<br />\r\n&nbsp;&nbsp;&nbsp;A [2] = 1<br />\r\n&nbsp;&nbsp;&nbsp;A [3] = 5<br />\r\nфункция должна вернуть 4, так как это отсутствующий элемент.</p>\r\n\r\n<p>Напишите эффективный алгоритм для следующих предположений:</p>\r\n\r\n<p>N является целым числом в диапазоне [0, 100 000];<br />\r\nвсе элементы А различны;<br />\r\nкаждый элемент массива A является целым числом в диапазоне [1 .. (N + 1)].</p>\r\n', 1, 'Найдите недостающий элемент в данной перестановке.', 5);

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
(16, 1, 1, 'data/code_templates/cyclic_rotation/c/'),
(17, 1, 2, 'data/code_templates/cyclic_rotation/sharp/'),
(24, 19, 1, 'data/code_templates/PermMissingElem/c/'),
(25, 19, 2, 'data/code_templates/PermMissingElem/sharp/');

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
  MODIFY `id_category` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
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
  MODIFY `id_lesson` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT для таблицы `polzov`
--
ALTER TABLE `polzov`
  MODIFY `id_polzov` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT для таблицы `statistic`
--
ALTER TABLE `statistic`
  MODIFY `id_statistic` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT для таблицы `task`
--
ALTER TABLE `task`
  MODIFY `id_task` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT для таблицы `task_lang`
--
ALTER TABLE `task_lang`
  MODIFY `id_task_lang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
