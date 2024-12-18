<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Календарь на месяц</title>
    <style>
        table {
            width: 50%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            text-align: center;
            border: 1px solid #000;
        }
        .weekend {
            background-color: #f4cccc;
        }
        .holiday {
            background-color: #ffcccb;
        }
        form {
            text-align: center;
            margin-bottom: 20px;
        }
        input[type="number"] {
            padding: 5px;
            margin: 5px;
        }
        .month-year {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<h1 style="text-align: center;">Календарь</h1>

<form method="get">
    <label for="month">Месяц (1-12):</label>
    <input type="number" name="month" id="month" min="1" max="12" value="<?php echo isset($_GET['month']) ? $_GET['month'] : date('m'); ?>" required>
    <label for="year">Год:</label>
    <input type="number" name="year" id="year" value="<?php echo isset($_GET['year']) ? $_GET['year'] : date('Y'); ?>" required>
    <input type="submit" value="Показать календарь">
</form>

<?php
function generateCalendar($month = null, $year = null) {
    if (!$month) $month = date('m');
    if (!$year) $year = date('Y');

    $holidays = [
        '01-01' => 'Новый год',
        '07-01' => 'Рождество',
        '08-03' => 'Международный женский день',
        '01-05' => 'Праздник труда',
        '09-05' => 'День Победы',
        '12-06' => 'День России',
        '04-11' => 'День народного единства',
    ];

    $daysInMonth = date('t', strtotime("$year-$month-01"));
    
    $firstDayOfMonth = (date('w', strtotime("$year-$month-01")) + 6) % 7;

    $monthName = date('F', strtotime("$year-$month-01"));
    $monthYear = ucfirst($monthName) . " $year";

    echo "<div class='month-year'>$monthYear</div>";
    echo "<table>";
    echo "<tr><th>Пн</th><th>Вт</th><th>Ср</th><th>Чт</th><th>Пт</th><th>Сб</th><th>Вс</th></tr>";

    $currentDay = 1;
    for ($i = 0; $i < 6; $i++) {
        echo "<tr>";
        for ($j = 0; $j < 7; $j++) {
            if ($i == 0 && $j < $firstDayOfMonth) {
                echo "<td></td>";
            } else {
                if ($currentDay <= $daysInMonth) {
                    $date = sprintf("%02d-%02d", $currentDay, $month);
                    $class = "";

                    if ($j == 5 || $j == 6) {
                        $class = "weekend";
                    }

                    $formattedDate = sprintf("%02d-%02d", $currentDay, $month);
                    if (array_key_exists($formattedDate, $holidays)) {
                        $class = "holiday";
                    }

                    echo "<td class='$class'>$currentDay</td>";
                    $currentDay++;
                } else {
                    echo "<td></td>";
                }
            }
        }
        echo "</tr>";
        if ($currentDay > $daysInMonth) break;
    }
    echo "</table>";
}

if (isset($_GET['month']) && isset($_GET['year'])) {
    $month = $_GET['month'];
    $year = $_GET['year'];
    generateCalendar($month, $year);
} else {
    generateCalendar(date('m'), date('Y'));
}
?>

</body>
</html>
