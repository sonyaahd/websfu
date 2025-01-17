
function checkAuthorization() {
    if (localStorage.getItem("userLoggedIn") === "true") {
        // Показываем форму для отзыва
        document.getElementById("review-form").style.display = "block";
        document.getElementById("review-message").style.display = "none";
    } else {
        document.getElementById("review-form").style.display = "none";
        document.getElementById("review-message").style.display = "block";
    }
}

window.onload = function() {
    checkAuthorization();
};
