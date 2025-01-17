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
-- Структура таблицы `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `review` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `username`, `review`, `created_at`) VALUES
(1, 10, 'arkadi123', 'Отличный зал. Есть всё необходимое. Дружелюбный персонал. Хожу с удовольствием.', '2025-01-16 17:23:49'),
(2, 11, 'ded_moroz', 'Очень хороший фитнес-клуб, много тренажеров , видно опытные тренера, а про персонал вообще молчу очень хороший, всегда помогут и не грубят , думаю стоит сходить.', '2025-01-16 17:25:33'),
(3, 12, 'makitra_petrovna', 'Не понравилось! 1 звезда', '2025-01-16 17:37:43'),
(4, 13, 'reptiloid0101', 'хороший, хожу уже 15 лет в этот фитнес клуб очень нравится особенно цены всем советую)))', '2025-01-16 17:40:40'),
(5, 14, 'sport_fun', 'записался ко всем тренерам!!! похожу к каждому по 1 разу и напишу отзыв ждите!!!', '2025-01-16 20:35:10'),
(6, 15, 'youga_master', 'Нравится йога с Марией Петровой) всем добра', '2025-01-16 20:38:28'),
(7, 16, 'cucumber2007', 'все понравилось, чисто, красиво аккуратно, тренера хорошие. но очень смущает эдуард соловьев.....', '2025-01-16 20:42:09');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
