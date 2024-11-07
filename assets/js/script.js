
function registerFormCheck() {
    let passwordOne = document.getElementById("password");
    let passwordTwo = document.getElementById("confirm-password");
    // Select paragraph element for user alerts
    let pageAlert = document.getElementById("page-alert");
    if (passwordOne.value !== passwordTwo.value) {
        // Show user alerts element
        pageAlert.classList.remove("hide");
        pageAlert.innerText = "Passwords don't match. Please try again";
        return false;
    } else {
        // Hide user alerts element
        pageAlert.classList.add("hide");
        return true;
    }
}

function addMedFormCheck() {
    let frequencyNumber = document.getElementById("frequency-number");
    let pageAlert = document.getElementById("page-alert");
    if (frequencyNumber.value < 1) {
        pageAlert.classList.remove("hide");
        pageAlert.innerText = "The frequency for taking medication must be set to at least 1. Please try again";
        return false;
    } else {
        pageAlert.classList.add("hide");
        return true;
    }
}
