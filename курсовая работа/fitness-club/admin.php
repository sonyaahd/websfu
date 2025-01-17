<?php
session_start();
include('db.php');

if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] != 1) {
    header("Location: login.html");
    exit();
}

$action = isset($_GET['action']) ? $_GET['action'] : '';
$user_id_to_delete = isset($_GET['delete_user_id']) ? $_GET['delete_user_id'] : '';
$success_message = $error_message = '';

if ($user_id_to_delete) {
    $sql_delete_bookings = "DELETE FROM bookings WHERE user_id = ?";
    $stmt_delete_bookings = $conn->prepare($sql_delete_bookings);
    $stmt_delete_bookings->bind_param("i", $user_id_to_delete);
    $stmt_delete_bookings->execute();

    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id_to_delete);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $success_message = "Пользователь и его записи успешно удалены!";
    } else {
        $error_message = "Ошибка при удалении пользователя.";
    }

    $stmt_delete_bookings->close();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_schedule'])) {
    $trainer_name = $_POST['trainer_name'];
    $training_date = $_POST['training_date'];
    $training_time = $_POST['training_time'];

    if (!empty($trainer_name) && !empty($training_date) && !empty($training_time)) {
        $sql_insert_schedule = "INSERT INTO schedule (trainer_name, training_date, training_time) VALUES (?, ?, ?)";
        $stmt_insert_schedule = $conn->prepare($sql_insert_schedule);
        $stmt_insert_schedule->bind_param("sss", $trainer_name, $training_date, $training_time);

        if ($stmt_insert_schedule->execute()) {
            $success_message = "Занятие успешно добавлено в расписание!";
        } else {
            $error_message = "Ошибка при добавлении занятия.";
        }
        
        $stmt_insert_schedule->close();
    } else {
        $error_message = "Пожалуйста, заполните все поля.";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Панель администратора - Фитнес-клуб</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>

    <div class="admin-container">
        <h2>Панель администратора</h2>

        <div class="admin-options">
            <h3>Управление пользователями</h3>
            <a href="admin.php?action=view_users">Просмотр пользователей</a><br>

            <h3>Управление записями</h3>
            <a href="admin.php?action=view_bookings">Просмотр записей на занятия</a><br>

            <h3>Добавление расписания</h3>
            <a href="admin.php?action=add_schedule">Добавить занятие в расписание</a><br>
            
            <a href="logout.php">Выйти</a><br>
        </div>

        <?php
        if ($success_message) {
            echo "<p class='success'>$success_message</p>";
        }
        if ($error_message) {
            echo "<p class='error'>$error_message</p>";
        }

        if ($action == 'view_users') {
            $sql = "SELECT * FROM users";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<h3>Список пользователей:</h3><ul>";
                while ($row = $result->fetch_assoc()) {
                    echo "<li>" . htmlspecialchars($row['username']) . " - Телефон: " . htmlspecialchars($row['phone']) . " 
                    <a href='admin.php?delete_user_id=" . $row['id'] . "' onclick='return confirm(\"Вы уверены, что хотите удалить этого пользователя?\")'>Удалить</a>
                    </li>";
                }
                echo "</ul>";
            } else {
                echo "Нет пользователей.";
            }
        }
        
        elseif ($action == 'view_bookings') {
            $sql = "SELECT * FROM bookings";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<h3>Записи на занятия:</h3><ul>";
                while ($row = $result->fetch_assoc()) {
                    echo "<li>Пользователь ID: " . $row['user_id'] . ", Дата: " . $row['training_date'] . ", Время: " . $row['training_time'] . ", Тренер: " . $row['trainer_name'] . "</li>";
                }
                echo "</ul>";
            } else {
                echo "Нет записей.";
            }
        }
        
        elseif ($action == 'add_schedule') {
            echo '<h3>Добавить новое занятие в расписание:</h3>';
            echo '<form action="admin.php?action=add_schedule" method="POST">
                <label for="trainer_name">Имя тренера:</label><br>
                <input type="text" id="trainer_name" name="trainer_name" required><br><br>
                
                <label for="training_date">Дата занятия:</label><br>
                <input type="date" id="training_date" name="training_date" required><br><br>
                
                <label for="training_time">Время занятия:</label><br>
                <input type="time" id="training_time" name="training_time" required><br><br>
                
                <button type="submit" name="add_schedule">Добавить занятие</button>
            </form>';
        }
        
        else {
            echo "<p>Выберите действие из меню для администрирования.</p>";
        }
        ?>

    </div>

</body>
</html>

<?php
$conn->close();
?>
