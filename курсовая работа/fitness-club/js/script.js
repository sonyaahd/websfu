const trainers = [
    { name: "Иван Иванов", qualification: "Персональный тренер, 5 лет опыта", photo: "trainer1.jpg" },
    { name: "Мария Смирнова", qualification: "Инструктор по йоге, 3 года опыта", photo: "trainer2.jpg" },
    { name: "Петр Петров", qualification: "Кардио тренер, 7 лет опыта", photo: "trainer3.jpg" },
];

function showTrainerInfo(trainer) {
    const trainerInfo = document.getElementById("trainer-info");
    trainerInfo.innerHTML = `
        <img src="${trainer.photo}" alt="${trainer.name}" style="width: 200px;">
        <p><strong>Квалификация:</strong> ${trainer.qualification}</p>
    `;
    trainerInfo.style.display = 'block';
}

const trainerList = document.getElementById("trainer-list");
trainers.forEach(trainer => {
    const listItem = document.createElement("li");
    listItem.textContent = trainer.name;
    listItem.onclick = () => showTrainerInfo(trainer);
    trainerList.appendChild(listItem);
});
