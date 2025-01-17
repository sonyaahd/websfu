document.addEventListener("DOMContentLoaded", function () {
    const calendarContainer = document.getElementById("calendar-container");
    const trainingsContainer = document.getElementById("trainings");
    const monthSelector = document.getElementById("month-selector");
    const warningMessage = document.getElementById("warning-message");
    
    const trainers = [
        { id: 1, name: "Тренер 1" },
        { id: 2, name: "Тренер 2" },
        { id: 3, name: "Тренер 3" },
        { id: 4, name: "Тренер 4" },
        { id: 5, name: "Тренер 5" }
    ];
    
    const scheduleData = {
        "2025-01-01": [
            { time: "09:00", trainer: "Тренер 1" },
            { time: "16:00", trainer: "Тренер 2" }
        ],
        "2025-01-02": [
            { time: "10:00", trainer: "Тренер 3" },
            { time: "14:00", trainer: "Тренер 4" }
        ],
        "2025-01-03": [
            { time: "09:00", trainer: "Тренер 2" },
            { time: "12:00", trainer: "Тренер 5" }
        ],
        "2025-01-05": [
            { time: "10:00", trainer: "Тренер 1" },
            { time: "18:00", trainer: "Тренер 3" }
        ],
        "2025-01-06": [
            { time: "09:00", trainer: "Тренер 4" },
            { time: "16:00", trainer: "Тренер 5" }
        ],
        "2025-01-07": [
            { time: "11:00", trainer: "Тренер 2" },
            { time: "15:00", trainer: "Тренер 1" }
        ],
        "2025-01-09": [
            { time: "09:00", trainer: "Тренер 3" },
            { time: "14:00", trainer: "Тренер 4" }
        ],
        "2025-01-10": [
            { time: "10:00", trainer: "Тренер 5" },
            { time: "18:00", trainer: "Тренер 2" }
        ],
        "2025-01-12": [
            { time: "09:00", trainer: "Тренер 1" },
            { time: "13:00", trainer: "Тренер 4" }
        ],
        "2025-01-15": [
            { time: "10:00", trainer: "Тренер 3" },
            { time: "14:00", trainer: "Тренер 2" }
        ],
        "2025-01-16": [
            { time: "09:00", trainer: "Тренер 4" },
            { time: "16:00", trainer: "Тренер 5" }
        ],
        // Февраль
        "2025-02-01": [
            { time: "09:00", trainer: "Тренер 1" },
            { time: "16:00", trainer: "Тренер 2" }
        ]
    };

    warningMessage.innerHTML = "Расписание обновляется каждый месяц. Следите за обновлениями.";

    function renderCalendar(year, month) {
        const firstDay = new Date(year, month, 1);
        const lastDay = new Date(year, month + 1, 0);
        const totalDays = lastDay.getDate();
        
        let calendarHTML = "<table>";
        calendarHTML += "<thead><tr><th>Пн</th><th>Вт</th><th>Ср</th><th>Чт</th><th>Пт</th><th>Сб</th><th>Вс</th></tr></thead>";
        calendarHTML += "<tbody><tr>";

        for (let i = 0; i < firstDay.getDay(); i++) {
            calendarHTML += "<td></td>";
        }

        for (let day = 1; day <= totalDays; day++) {
            const currentDate = `${year}-${(month + 1).toString().padStart(2, '0')}-${day.toString().padStart(2, '0')}`;
            calendarHTML += `<td class="calendar-day" onclick="showTrainings('${currentDate}')">${day}</td>`;

            if ((firstDay.getDay() + day) % 7 === 0) {
                calendarHTML += "</tr><tr>";
            }
        }

        calendarHTML += "</tr></tbody></table>";
        calendarContainer.innerHTML = calendarHTML;
    }

    window.showTrainings = function(date) {
        const trainings = scheduleData[date];
        if (trainings) {
            let trainingHTML = "<ul>";
            trainings.forEach(training => {
                trainingHTML += `<li>${training.time} — ${training.trainer}</li>`;
            });
            trainingHTML += "</ul>";
            trainingsContainer.innerHTML = `<h3>Тренировки на ${date}</h3>` + trainingHTML;
        } else {
            trainingsContainer.innerHTML = "<p>Нет доступных тренировок на эту дату.</p>";
        }
    };

    monthSelector.addEventListener('change', function() {
        const selectedMonth = parseInt(this.value);
        renderCalendar(new Date().getFullYear(), selectedMonth);
    });

    renderCalendar(new Date().getFullYear(), new Date().getMonth());
});
