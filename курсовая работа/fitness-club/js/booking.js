document.addEventListener("DOMContentLoaded", function () {
    const authWarning = document.getElementById("auth-warning");
    const bookButton = document.getElementById("book-button");
    const dateGroup = document.querySelector(".date-group");

    const userLoggedIn = false;

    if (!userLoggedIn) {
        authWarning.style.display = "block";
    } else {
        authWarning.style.display = "none";
    }

    const schedule = [
        { date: "2025-01-01", time: "10:00", trainer: "Анна Петрова" },
        { date: "2025-01-01", time: "14:00", trainer: "Иван Иванов" },
        { date: "2025-01-02", time: "09:00", trainer: "Елена Смирнова" },
        { date: "2025-01-02", time: "16:00", trainer: "Дмитрий Павлов" },
        { date: "2025-01-03", time: "11:00", trainer: "Анна Петрова" },
        { date: "2025-01-03", time: "18:00", trainer: "Елена Смирнова" },
        { date: "2025-01-04", time: "08:00", trainer: "Иван Иванов" },
        { date: "2025-01-05", time: "15:00", trainer: "Дмитрий Павлов" },
        { date: "2025-01-06", time: "10:00", trainer: "Анна Петрова" },
        { date: "2025-01-07", time: "14:00", trainer: "Иван Иванов" },
    ];

    function displaySchedule() {
        schedule.forEach(session => {
            const sessionElement = document.createElement("div");
            sessionElement.classList.add("session");

            sessionElement.innerHTML = `
                <p><strong>${session.date}</strong> | ${session.time} - Тренер: ${session.trainer}</p>
                <button class="book-session">Записаться</button>
            `;

            dateGroup.appendChild(sessionElement);

            const bookButton = sessionElement.querySelector(".book-session");
            bookButton.addEventListener("click", function () {
                if (userLoggedIn) {
                    alert(`Вы записались на занятие ${session.date} в ${session.time} с тренером ${session.trainer}`);
                } else {
                    alert("Пожалуйста, авторизуйтесь для записи.");
                }
            });
        });
    }

    displaySchedule();
});
