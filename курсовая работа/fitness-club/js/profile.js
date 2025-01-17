
function checkAuthorization() {
    const isLoggedIn = localStorage.getItem("userLoggedIn") === "true";
    const userName = localStorage.getItem("userName");

    if (isLoggedIn) {
        document.getElementById("login-register").style.display = "none";
        document.getElementById("user-info").style.display = "block";
        document.getElementById("user-name").textContent = userName;
    } else {
        document.getElementById("login-register").style.display = "block";
        document.getElementById("user-info").style.display = "none";
    }
}

document.getElementById("logout-button")?.addEventListener("click", function() {
    localStorage.removeItem("userLoggedIn");
    localStorage.removeItem("userName");
    checkAuthorization();
});

window.onload = checkAuthorization;
