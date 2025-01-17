<?php
session_start();
include('db.php'); 

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password']; 
    $phone = $_POST['phone'];

    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Пользователь с таким логином уже существует!";
    } else {
        $sql = "INSERT INTO users (username, password, phone) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $username, $password, $phone);

        if ($stmt->execute()) {
            $_SESSION['registration_success'] = true;
            header("Location: register.php"); 
            exit();
        } else {
            echo "Ошибка: " . $stmt->error;
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();


        if ($user['password'] == $password) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['is_admin'] = $user['is_admin'];

            header("Location: dashboard.php"); 
            exit();
        } else {
            echo "Неверный пароль!";
        }
    } else {
        echo "Пользователь не найден!";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="profile-container">
        <h2>Личный кабинет</h2>
        <nav>
            <ul>
                <li><a href="index.php">Главная</a></li>
                <li><a href="schedule.php">Расписание</a></li>
                <li><a href="booking.php">Запись</a></li>
                <li><a href="contacts.php">Контакты</a></li>
                <li><a href="reviews.php">Отзывы</a></li>
            </ul>
        </nav>
        <div id="login-register">
            <div id="login-form">
                <h3>Авторизация</h3>
                <form id="login-form" method="POST">
                    <label for="login-username">Логин:</label>
                    <input type="text" id="login-username" name="username" required placeholder="Введите логин"><br>

                    <label for="login-password">Пароль:</label>
                    <input type="password" id="login-password" name="password" required placeholder="Введите пароль"><br>

                    <button type="submit" name="login">Войти</button>
                </form>
            </div>
            <div id="register-form">
                <h3>Регистрация</h3>
                <?php
                if (isset($_SESSION['registration_success']) && $_SESSION['registration_success'] === true) {
                    echo "<p style='color: green;'>Вы успешно зарегистрировались! Теперь можете войти.</p>";
                    unset($_SESSION['registration_success']); 
                }
                ?>
                <form id="registration-form" method="POST">
                    <label for="register-username">Логин:</label>
                    <input type="text" id="register-username" name="username" required placeholder="Введите логин"><br>

                    <label for="register-password">Пароль:</label>
                    <input type="password" id="register-password" name="password" required placeholder="Введите пароль"><br>

                    <label for="register-phone">Номер телефона:</label>
                    <input type="tel" id="register-phone" name="phone" required placeholder="Введите номер телефона"><br>

                    <button type="submit" name="register">Зарегистрироваться</button>
                </form>
            </div>
        </div>
        <div id="user-info" style="display: none;">
            <h3>Добро пожаловать, <span id="user-name"></span>!</h3>
            <p>Вы авторизованы. Здесь вы можете просматривать свои записи на занятия или изменить личные данные.</p>
            <button id="logout-button">Выйти</button>
        </div>
    </div>

    <script src="js/profile.js"></script>
</body>
</html>
