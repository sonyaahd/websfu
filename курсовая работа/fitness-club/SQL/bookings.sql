-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Янв 17 2025 г., 17:11
-- Версия сервера: 10.4.32-MariaDB
-- Версия PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `fitness-club`
--

-- --------------------------------------------------------

--
-- Структура таблицы `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `training_date` date DEFAULT NULL,
  `training_time` time DEFAULT NULL,
  `trainer_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `training_date`, `training_time`, `trainer_name`) VALUES
(12, 14, '2025-01-01', '12:00:00', 'Мария Петрова'),
(13, 14, '2025-01-02', '15:30:00', 'Алексей Смирнов'),
(14, 14, '2025-01-05', '18:30:00', 'Ксения Зайцева'),
(15, 14, '2025-01-02', '12:30:00', 'Мария Петрова'),
(16, 14, '2025-01-07', '12:30:00', 'Эдуард Соловьев'),
(17, 15, '2025-01-07', '09:30:00', 'Мария Петрова'),
(18, 15, '2025-01-01', '12:00:00', 'Мария Петрова'),
(19, 15, '2025-01-02', '12:30:00', 'Мария Петрова'),
(20, 15, '2025-01-03', '16:00:00', 'Мария Петрова'),
(21, 15, '2025-01-04', '17:30:00', 'Мария Петрова'),
(22, 15, '2025-01-05', '15:30:00', 'Мария Петрова'),
(23, 15, '2025-01-06', '18:00:00', 'Максим Кружков'),
(24, 16, '2025-01-02', '17:00:00', 'Максим Кружков'),
(25, 16, '2025-01-07', '12:30:00', 'Эдуард Соловьев'),
(26, 5, '2025-01-07', '18:00:00', 'Ксения Зайцева');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
