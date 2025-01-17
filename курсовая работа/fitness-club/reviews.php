<?php
session_start();
include('db.php'); 

$isLoggedIn = isset($_SESSION['user_id']);
$username = $isLoggedIn ? $_SESSION['username'] : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $isLoggedIn) {
    $review = trim($_POST['review']);
    $user_id = $_SESSION['user_id'];

    if (!empty($review)) {
        $sql = "INSERT INTO reviews (user_id, username, review) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die('Ошибка подготовки запроса: ' . $conn->error);
        }
        $stmt->bind_param("iss", $user_id, $username, $review);
        $stmt->execute();
        $stmt->close();
    }
}

$sql_reviews = "SELECT username, review FROM reviews ORDER BY id DESC";
$result_reviews = $conn->query($sql_reviews);
if ($result_reviews === false) {
    die('Ошибка выполнения запроса: ' . $conn->error);
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Отзывы</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
    <nav>
            <ul>
                <li><a href="index.php">Главная</a></li>
                <li><a href="schedule.php">Расписание</a></li>
                <li><a href="booking.php">Запись</a></li>
                <li><a href="contacts.php">Контакты</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="dashboard.php">Личный кабинет</a></li> 
                    <li><a href="logout.php">Выйти</a></li> 
                <?php else: ?>
                    <li><a href="register.php">Войти</a></li> 
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <div class="reviews-container">
        <h2>Отзывы о фитнес-клубе</h2>

        <div class="add-review">
            <h3>Оставьте свой отзыв</h3>
            <?php if ($isLoggedIn): ?>
                <form id="review-form" action="reviews.php" method="POST">
                    <textarea name="review" id="review" rows="4" placeholder="Напишите ваш отзыв..." required></textarea><br>
                    <button type="submit">Отправить отзыв</button>
                </form>
            <?php else: ?>
                <p id="review-message">Для добавления отзыва необходимо <a href="register.php">авторизоваться</a>.</p>
            <?php endif; ?>
        </div>

        <div class="existing-reviews">
            <h3>Отзывы наших клиентов:</h3>
            <ul id="reviews-list">
                <?php while ($row = $result_reviews->fetch_assoc()): ?>
                    <li><strong><?php echo htmlspecialchars($row['username']); ?></strong>: <?php echo htmlspecialchars($row['review']); ?></li>
                <?php endwhile; ?>
            </ul>
        </div>
    </div>
</body>
</html>
