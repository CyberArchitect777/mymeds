
function registerFormCheck() {
    let passwordOne = document.getElementById("password");
    let passwordTwo = document.getElementById("confirm-password");
    let registerAlert = document.getElementById("register-alert");
    if (passwordOne.value !== passwordTwo.value) {
        registerAlert.classlist.remove("hide");
        registerAlert.innerText = "Passwords don't match. Please try again";
        return false;
    } else {
        registerAlert.classlist.add("hide");
        return true;
    }
}