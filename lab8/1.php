<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Таблица умножения</title>
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
    </style>
</head>
<body>

<h1 style="text-align: center;">Таблица умножения от 0 до 10</h1>

<?php
echo "<table>";
echo "<tr><th>?</th>";
for ($i = 0; $i <= 10; $i++) {
    echo "<th>$i</th>";
}
echo "</tr>";

for ($i = 0; $i <= 10; $i++) {
    echo "<tr><th>$i</th>";  
    for ($j = 0; $j <= 10; $j++) {
        echo "<td>" . ($i * $j) . "</td>"; 
    }
    echo "</tr>";
}
echo "</table>";
?>

</body>
</html>
