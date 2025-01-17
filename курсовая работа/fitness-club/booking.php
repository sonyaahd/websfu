<?php
session_start();
include('db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: register.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    list($trainer_name, $session_date, $session_time) = explode("|", $_POST['session']);

    $sql = "INSERT INTO bookings (user_id, training_date, training_time, trainer_name) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isss", $user_id, $session_date, $session_time, $trainer_name);

    if ($stmt->execute()) {
        $success_message = "Вы успешно записались на занятие!";
    } else {
        $error_message = "Ошибка при записи.";
    }

    $stmt->close();
}

$sql = "SELECT DISTINCT trainer_name, training_date, training_time FROM schedule";
$result = $conn->query($sql);

if (!$result) {
    die("Ошибка: " . $conn->error);
}

$available_dates = [];
while ($row = $result->fetch_assoc()) {
    $available_dates[] = $row;
}

$sql_bookings = "SELECT * FROM bookings WHERE user_id = ?";
$stmt_bookings = $conn->prepare($sql_bookings);
$stmt_bookings->bind_param("i", $user_id);
$stmt_bookings->execute();
$bookings_result = $stmt_bookings->get_result();

if ($bookings_result->num_rows > 0) {
    $bookings = $bookings_result->fetch_all(MYSQLI_ASSOC);
} else {
    $bookings = [];
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Запись на занятие</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
    <nav>
            <ul>
                <li><a href="index.php">Главная</a></li>
                <li><a href="schedule.php">Расписание</a></li>
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

    <div class="booking-container">
        <h2>Запись на занятие</h2>

        <?php if (isset($success_message)) { echo "<p class='success'>$success_message</p>"; } ?>
        <?php if (isset($error_message)) { echo "<p class='error'>$error_message</p>"; } ?>

        <p>Выберите занятие для записи:</p>
        <form action="booking.php" method="POST">
            <div id="available-dates">
                <h3>Доступные занятия:</h3>
                <div class="date-group">
                    <?php foreach ($available_dates as $date): ?>
                        <div class="date-entry">
                            <p>Тренер: <?php echo htmlspecialchars($date['trainer_name']); ?></p>
                            <p>Дата: <?php echo htmlspecialchars($date['training_date']); ?></p>
                            <p>Время: <?php echo htmlspecialchars($date['training_time']); ?></p>
                            <input type="radio" name="session" value="<?php echo htmlspecialchars($date['trainer_name']); ?>|<?php echo htmlspecialchars($date['training_date']); ?>|<?php echo htmlspecialchars($date['training_time']); ?>" required>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <button type="submit" id="book-button">Записаться</button>
        </form>

        <h3>Ваши записи на занятия:</h3>
        <?php if (!empty($bookings)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Дата занятия</th>
                        <th>Время занятия</th>
                        <th>Тренер</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($bookings as $booking): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($booking['training_date']); ?></td>
                            <td><?php echo htmlspecialchars($booking['training_time']); ?></td>
                            <td><?php echo htmlspecialchars($booking['trainer_name']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Вы не записаны на занятия.</p>
        <?php endif; ?>
    </div>

    <script src="js/booking.js"></script>
</body>
</html>

