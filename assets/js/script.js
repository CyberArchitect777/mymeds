
document.addEventListener("submit", function(event) {
    event.preventDefault();
});

function registerFormCheck() {
    let passwordOne = document.getElementById("password");
    let passwordTwo = document.getElementById("confirm-password");
    let registerAlert = document.getElementById("register-alert");
    if (passwordOne.value !== passwordTwo.value) {
        registerAlert.style.display = "block";
        registerAlert.innerText = "Passwords don't match. Please try again";
        return false;
    } else {
        registerAlert.style.display = "none";
        return true;
    }
}