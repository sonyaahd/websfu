<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <style>
        form {
            width: 50%;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #000;
            border-radius: 5px;
        }
        input[type="text"], input[type="password"], input[type="date"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            border: none;
            background-color: #4CAF50;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<h1 style="text-align: center;">Регистрация пользователя</h1>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $fullName = trim($_POST['fullName']);
    $login = trim($_POST['login']);
    $password = trim($_POST['password']);
    $dob = $_POST['dob'];


    if (empty($fullName) || empty($login) || empty($password) || empty($dob)) {
        echo "<p style='color: red; text-align: center;'>Все поля обязательны для заполнения!</p>";
    } else {

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        echo "<h2 style='text-align: center;'>Вы успешно зарегистрированы!</h2>";
        echo "<p style='text-align: center;'>ФИО: $fullName</p>";
        echo "<p style='text-align: center;'>Логин: $login</p>";
        echo "<p style='text-align: center;'>Дата рождения: $dob</p>";
    }
}
?>

<form method="post" action="">
    <label for="fullName">ФИО:</label>
    <input type="text" id="fullName" name="fullName" required>

    <label for="login">Логин:</label>
    <input type="text" id="login" name="login" required>

    <label for="password">Пароль:</label>
    <input type="password" id="password" name="password" required>

    <label for="dob">Дата рождения:</label>
    <input type="date" id="dob" name="dob" required>

    <input type="submit" value="Зарегистрироваться">
</form>

</body>
</html>
