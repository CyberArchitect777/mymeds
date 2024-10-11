
document.addEventListener("submit", function(event) {
    event.preventDefault();
});

function registerFormCheck() {
    let passwordOne = document.getElementById("password");
    let passwordTwo = document.getElementById("confirm-password");
    let registerAlert = document.getElementById("register-alert");
    if (passwordOne !== passwordTwo) {
        registerAlert.style.display = "block";
        registerAlert.innerText = "Password don't match. Please try again";
        return false;
    } else {
        return true;
    }
}