<?php
session_start();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Контакты</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<header>
<nav>
            <ul>
                <li><a href="index.php">Главная</a></li>
                <li><a href="schedule.php">Расписание</a></li>
                <li><a href="booking.php">Запись</a></li>
                <li><a href="reviews.php">Отзывы</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="dashboard.php">Личный кабинет</a></li>
                    <li><a href="logout.php">Выйти</a></li>
                <?php else: ?>
                    <li><a href="register.php">Войти</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <div class="contacts-container">
        <h2>Контакты</h2>

        <div class="contact-info">
            <h3>Наши контакты:</h3>
            <p><strong>Адрес:</strong> г. Красноярск, улица 9 Мая, 77</p>
            <p><strong>Телефон:</strong> 8 800 555 35-35</p>
            <p><strong>Email:</strong> sparta@fitnessclub.ru</p>
        </div>

        <div class="club-photo">
            <img src="images/fitness-club.jpg" alt="Фитнес-клуб" style="width: 100%; max-height: 400px; object-fit: cover; margin-top: 20px;">
        </div>

        <div class="maps-links">
            <h3>Как добраться:</h3>
            <p>Мы находимся по адресу: <strong>г. Красноярск, улица 9 Мая, 77</strong></p>
            <p>Вы можете воспользоваться следующими картами для прокладывания маршрута:</p>
            <ul>
                <li><a href="https://www.google.com/maps/place/Красноярск,+ул.+9 +мая,+д.+77" target="_blank">Google Maps</a></li>
                <li><a href="https://yandex.ru/maps/62/krasnoyarsk/?ll=92.907370%2C56.049625&z=15" target="_blank">Яндекс.Карты</a></li>
            </ul>
        </div>
    </div>
</body>
</html>
