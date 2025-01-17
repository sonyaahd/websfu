function checkAdminRights() {
    const isAdmin = localStorage.getItem("isAdmin") === "true";

    if (isAdmin) {
        document.getElementById("admin-info").style.display = "block";
        document.getElementById("admin-error").style.display = "none";
        loadUserData();
        loadBookingsData();
    } else {
        document.getElementById("admin-info").style.display = "none";
        document.getElementById("admin-error").style.display = "block";
    }
}

function loadUserData() {
    const users = JSON.parse(localStorage.getItem("users")) || [];

    const usersTable = document.getElementById("users-table").getElementsByTagName("tbody")[0];
    usersTable.innerHTML = "";

    users.forEach((user, index) => {
        const row = usersTable.insertRow();
        row.insertCell(0).textContent = user.username;
        row.insertCell(1).textContent = user.phone;
        
        const deleteCell = row.insertCell(2);
        const deleteButton = document.createElement("button");
        deleteButton.textContent = "Удалить";
        deleteButton.onclick = () => deleteUser(index);
        deleteCell.appendChild(deleteButton);
    });
}

function deleteUser(index) {
    let users = JSON.parse(localStorage.getItem("users")) || [];
    users.splice(index, 1);
    localStorage.setItem("users", JSON.stringify(users));
    loadUserData();
}

function loadBookingsData() {
    const bookings = JSON.parse(localStorage.getItem("bookings")) || [];

    const bookingsTable = document.getElementById("bookings-table").getElementsByTagName("tbody")[0];
    bookingsTable.innerHTML = "";

    bookings.forEach(booking => {
        const row = bookingsTable.insertRow();
        row.insertCell(0).textContent = booking.date;
        row.insertCell(1).textContent = booking.trainer;
        row.insertCell(2).textContent = booking.username;
    });
}

window.onload = checkAdminRights;
