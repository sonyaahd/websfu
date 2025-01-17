<?php
session_start(); 
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Фитнес-клуб</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
        <div class="logo">
            <h1>Фитнес-клуб «Sparta»</h1>
        </div>
        <nav>
            <ul>
                <li><a href="index.php">Главная</a></li>
                <li><a href="schedule.php">Расписание</a></li>
                <li><a href="booking.php">Запись</a></li>
                <li><a href="contacts.php">Контакты</a></li>
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

    <main>
        <section id="gallery">
            <h3>Галерея</h3>
            <div class="gallery">
                <img src="images/photo1.jpg" alt="Фото 1">
                <img src="images/photo2.jpg" alt="Фото 2">
                <img src="images/photo3.jpg" alt="Фото 3">
                <img src="images/photo4.jpg" alt="Фото 4">
            </div>
        </section>

        <section id="news">
            <h3>Новости клуба</h3>
            <div class="news-item">
                <h4>Новое расписание занятий</h4>
                <p>Мы обновили расписание! Смотрите актуальные часы работы и тренировки.</p>
            </div>
            <div class="news-item">
                <h4>Скидки на абонементы</h4>
                <p>Поспешите! Скидка 20% на годовые абонементы до конца месяца.</p>
            </div>
            <div class="news-item">
                <h4>Тренажеры</h4>
                <p>Новое оборудование в тренажерном зале! Мы обновили наш тренажерный парк, добавив новые эллиптические тренажеры и скамьи для свободных весов. Приходите и опробуйте!</p>
            </div>
            <div class="news-item">
                <h4>Фитнес класс</h4>
                <p>Запуск нового фитнес-класса: 'Танцевальная аэробика'. Если вы любите танцевать и хотите улучшить физическую форму, присоединяйтесь к нашему новому классу, который начнется с понедельника!</p>
            </div>
        </section>

        <section id="club-info">
            <h2>Наши тренеры</h2>
            <div class="trainers">
                <div class="trainer" onclick="goToSchedule('trainer1')">
                    <img src="images/trainer1.jpg" alt="Тренер 1">
                    <h4>Алексей Смирнов</h4>
                    <p>Квалификация: Персональный тренер</p>
                </div>
                <div class="trainer" onclick="goToSchedule('trainer2')">
                    <img src="images/trainer2.jpg" alt="Тренер 2">
                    <h4>Мария Петрова</h4>
                    <p>Квалификация: Специалист по йоге</p>
                </div>
                <div class="trainer" onclick="goToSchedule('trainer3')">
                    <img src="images/trainer3.jpg" alt="Тренер 3">
                    <h4>Ксения Зайцева</h4>
                    <p>Квалификация: Специалист по фитнесу</p>
                </div>
                <div class="trainer" onclick="goToSchedule('trainer4')">
                    <img src="images/trainer4.jpg" alt="Тренер 4">
                    <h4>Эдуард Соловьев</h4>
                    <p>Квалификация: Тренер по кардионагрузкам</p>
                </div>
                <div class="trainer" onclick="goToSchedule('trainer5')">
                    <img src="images/trainer5.jpg" alt="Тренер 5">
                    <h4>Максим Кружков</h4>
                    <p>Квалификация: Специалист по восстановлению после травм</p>
                </div>
            </div>
        </section>
    </main>

    <script>
        function goToSchedule(trainer) {
            window.location.href = `schedule.php?trainer=${trainer}`;
        }
    </script>
</body>
</html>
