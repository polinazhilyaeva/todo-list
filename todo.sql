-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Авг 14 2017 г., 18:51
-- Версия сервера: 10.1.22-MariaDB
-- Версия PHP: 7.0.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `todo`
--

-- --------------------------------------------------------

--
-- Структура таблицы `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `projects`
--

INSERT INTO `projects` (`id`, `name`, `user_id`) VALUES
(63, 'Самые важные в мире дела, вот', 12),
(64, 'просто важные дела на сегодня', 12),
(76, 'Bugs to Fix', 10),
(95, 'Пожелания', 10);

-- --------------------------------------------------------

--
-- Структура таблицы `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `deadline` date NOT NULL,
  `checked` tinyint(1) NOT NULL,
  `priority` int(11) NOT NULL,
  `project_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `tasks`
--

INSERT INTO `tasks` (`id`, `name`, `deadline`, `checked`, `priority`, `project_id`) VALUES
(259, 'поцеловать котика', '2017-08-15', 0, 0, 63),
(260, 'попить чайку', '2017-08-11', 1, 3, 63),
(261, 'помурлыкать под звездами', '2017-08-11', 1, 2, 63),
(262, 'скушать что-то вкусненькое', '2017-08-14', 0, 0, 64),
(313, 'Высота li при добавлении таска и при выгрузке из БД разная', '2017-08-14', 0, 2, 76),
(329, 'При \'Sign up instead\' и \'Log in instead\' перебрасывать на страницу, передавая email в GET-параметре', '2017-08-14', 0, 1, 95),
(332, 'почесать нос', '2017-08-16', 1, 1, 63),
(333, 'поесть снова', '2017-08-14', 0, 1, 64),
(337, 'Border вокруг иконки редактирования проекта после нажатия при наведении', '2017-08-14', 0, 0, 76);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `name` text NOT NULL,
  `last_name` text NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`name`, `last_name`, `email`, `password`, `id`) VALUES
('Polina', 'Zhilyaeva', 'zhilyaeva.polina@gmail.com', 'b42ec5738596d6e3cbec231f202df539', 10),
('New', 'User', 'new.user@test.ua', '0fc3b0a83b7f574450fd9af6546b6899', 11),
('Galina', 'Pronozyuk', 'g.pronozyuk@gmail.com', '553a1c17bc6e68139c0b32ac02a4b5d0', 12);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;
--
-- AUTO_INCREMENT для таблицы `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=339;
--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
