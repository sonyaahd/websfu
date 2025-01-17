<?php
session_start();
include('db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: register.php");
    exit();
}

if ($_SESSION['is_admin'] == 1) {
    header("Location: admin.php");
    exit();
}

$id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_user'])) {
    $username = $_POST['username'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];

    $sql_check = "SELECT * FROM users WHERE username = ? AND id != ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("si", $username, $id);
    $stmt_check->execute();
    $check_result = $stmt_check->get_result();

    if ($check_result->num_rows > 0) {
        $error_message = "Этот логин уже занят, выберите другой.";
    } else {
        if (!empty($password)) {
            $sql_update = "UPDATE users SET username = ?, phone = ?, password = ? WHERE id = ?";
            $stmt_update = $conn->prepare($sql_update);
            $stmt_update->bind_param("sssi", $username, $phone, $password, $id);
        } else {
            $sql_update = "UPDATE users SET username = ?, phone = ? WHERE id = ?";
            $stmt_update = $conn->prepare($sql_update);
            $stmt_update->bind_param("ssi", $username, $phone, $id);
        }

        if ($stmt_update->execute()) {
            $_SESSION['username'] = $username;
            header("Location: dashboard.php");
            exit();
        } else {
            $error_message = "Ошибка при обновлении данных.";
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Личный кабинет</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 50%;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
        }
        .question {
            margin: 15px 0;
        }
        label {
            font-size: 16px;
            margin-right: 10px;
        }
        input[type="radio"], input[type="number"] {
            margin-right: 10px;
        }
        button {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            font-size: 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
        button:hover {
            background-color: #45a049;
        }
        .result {
            font-size: 18px;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<header>
    <nav>
        <ul>
            <li><a href="index.php">Главная</a></li>
            <li><a href="schedule.php">Расписание</a></li>
            <li><a href="booking.php">Запись</a></li>
            <li><a href="contacts.php">Контакты</a></li>
            <li><a href="reviews.php">Отзывы</a></li>
            <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="logout.php">Выйти</a></li>
                <?php else: ?>
                    <li><a href="register.php">Войти</a></li>
                <?php endif; ?>
            </ul>
        </nav>
</header>

<div class="container">
    <section id="fitness-test">
        <h3>Тест: Насколько ты в форме?</h3>
        <div class="question">
            <label>Как часто вы тренируетесь?</label>
            <input type="radio" name="training-frequency" value="1" id="freq-1"> Редко
            <input type="radio" name="training-frequency" value="2" id="freq-2"> 1-2 раза в неделю
            <input type="radio" name="training-frequency" value="3" id="freq-3"> 3-4 раза в неделю
            <input type="radio" name="training-frequency" value="4" id="freq-4"> 5 и более раз в неделю
        </div>

        <div class="question">
            <label>Как вы оцениваете свою выносливость?</label>
            <input type="radio" name="endurance" value="1" id="endurance-1"> Плохо
            <input type="radio" name="endurance" value="2" id="endurance-2"> Средне
            <input type="radio" name="endurance" value="3" id="endurance-3"> Хорошо
        </div>

        <div class="question">
            <label>Как часто вы чувствуете усталость?</label>
            <input type="radio" name="fatigue" value="1" id="fatigue-1"> Часто
            <input type="radio" name="fatigue" value="2" id="fatigue-2"> Иногда
            <input type="radio" name="fatigue" value="3" id="fatigue-3"> Редко
        </div>

        <button onclick="calculateFitness()">Пройти тест</button>

        <div id="fitness-result" class="result"></div>
    </section>

    <section id="bmi-calculation">
        <h3>Расчет Индекса Массы Тела (ИМТ)</h3>
        <div class="question">
            <label>Ваш рост (в см):</label>
            <input type="number" id="height" placeholder="Введите ваш рост" required>
        </div>
        <div class="question">
            <label>Ваш вес (в кг):</label>
            <input type="number" id="weight" placeholder="Введите ваш вес" required>
        </div>
        <button onclick="calculateBMI()">Рассчитать ИМТ</button>

        <div id="bmi-result" class="result"></div>
    </section>
</div>
<div class="profile-container">

    <?php if (isset($error_message)) { echo "<p class='error'>$error_message</p>"; } ?>

    <h3>Изменить данные:</h3>
    <form action="dashboard.php" method="POST">
        <label for="username">Новый логин:</label>
        <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required><br><br>
        
        <label for="phone">Новый номер телефона:</label>
        <input type="text" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required><br><br>
        
        <label for="password">Новый пароль (оставьте пустым, если не хотите менять):</label>
        <input type="password" name="password"><br><br>
        
        <button type="submit" name="update_user">Обновить</button>
    </form>
</div>
<script>
    function calculateFitness() {
        let freq = document.querySelector('input[name="training-frequency"]:checked');
        let endurance = document.querySelector('input[name="endurance"]:checked');
        let fatigue = document.querySelector('input[name="fatigue"]:checked');

        if (!freq || !endurance || !fatigue) {
            document.getElementById("fitness-result").innerText = "Пожалуйста, ответьте на все вопросы.";
            return;
        }

        let fitnessScore = parseInt(freq.value) + parseInt(endurance.value) + parseInt(fatigue.value);
        
        let resultText = '';
        if (fitnessScore <= 4) {
            resultText = "Ваша физическая форма ниже средней. Рекомендуем больше заниматься спортом!";
        } else if (fitnessScore <= 6) {
            resultText = "У вас средняя физическая форма. Продолжайте тренироваться!";
        } else {
            resultText = "Отличная физическая форма! Вы на высоте!";
        }

        document.getElementById("fitness-result").innerText = resultText;
    }

    function calculateBMI() {
        let height = parseFloat(document.getElementById("height").value);
        let weight = parseFloat(document.getElementById("weight").value);

        if (isNaN(height) || isNaN(weight) || height <= 0 || weight <= 0) {
            document.getElementById("bmi-result").innerText = "Пожалуйста, введите правильные данные для роста и веса.";
            return;
        }

        height = height / 100;

        let bmi = weight / (height * height);
        let bmiCategory = '';

        if (bmi < 18.5) {
            bmiCategory = "Недовес";
        } else if (bmi < 24.9) {
            bmiCategory = "Нормальный вес";
        } else if (bmi < 29.9) {
            bmiCategory = "Избыточный вес";
        } else {
            bmiCategory = "Ожирение";
        }

        document.getElementById("bmi-result").innerText = `Ваш ИМТ: ${bmi.toFixed(2)} (${bmiCategory})`;
    }
</script>

</body>
</html>
