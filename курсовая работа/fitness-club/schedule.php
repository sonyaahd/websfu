<?php
session_start();
include('db.php'); 

$selected_date = isset($_GET['date']) ? $_GET['date'] : null;
$schedule = [];

if ($selected_date) {
    $sql = "SELECT trainer_name, training_date, training_time FROM schedule WHERE training_date = ? ORDER BY training_time";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $selected_date);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $schedule[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Расписание тренировок</title>
    <link rel="stylesheet" href="css/styles.css">
    <script src="js/schedule.js" defer></script>
</head>
<body>
    <header>
    <nav>
            <ul>
                <li><a href="index.php">Главная</a></li>
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
        <section id="calendar">
            <h2>Выберите дату</h2>
            <input type="date" id="date-selector">
            
            <div id="trainings">
                <h3>Доступные тренировки</h3>
                <?php if ($selected_date && count($schedule) > 0): ?>
                    <ul>
                        <?php foreach ($schedule as $session): ?>
                            <li>
                                <strong>Тренер:</strong> <?php echo htmlspecialchars($session['trainer_name']); ?> <br>
                                <strong>Дата:</strong> <?php echo htmlspecialchars($session['training_date']); ?> <br>
                                <strong>Время:</strong> <?php echo htmlspecialchars($session['training_time']); ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php elseif ($selected_date): ?>
                    <p>Нет доступных тренировок на эту дату.</p>
                <?php else: ?>
                    <p>Выберите дату, чтобы увидеть тренировки.</p>
                <?php endif; ?>
            </div>
        </section>
    </main>

    <script>
        document.getElementById('date-selector').addEventListener('change', function() {
            var selectedDate = this.value;
            if (selectedDate) {
                window.location.href = '?date=' + selectedDate; 
            }
        });
    </script>
</body>
</html>
