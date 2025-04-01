document.addEventListener("DOMContentLoaded", function () {
    const container = document.querySelector(".form-box");
    const showRegister = document.getElementById("show-register");
    const showLogin = document.getElementById("show-login");

    showRegister.addEventListener("click", function (event) {
        event.preventDefault();
        container.classList.add("active"); // Slide up
    });

    showLogin.addEventListener("click", function (event) {
        event.preventDefault();
        container.classList.remove("active"); // Slide down
    });
});

function switchForm(formId, headerText) {
    let loginForm = document.getElementById("loginForm");
    let registerForm = document.getElementById("registerForm");
    let container = document.querySelector(".login-container");
    let formHeader = document.getElementById("formHeader");

    if (formId === "registerForm") {
        loginForm.style.display = "none";
        registerForm.style.display = "block";
        container.style.height = "auto"; // Adjust height dynamically
        formHeader.innerHTML = `<span style="color: red;">📝</span> ${headerText} <span style="color: red;">📝</span>`;
    } else {
        loginForm.style.display = "block";
        registerForm.style.display = "none";
        container.style.height = "auto"; // Reset height dynamically
        formHeader.innerHTML = `<span style="color: red;">👤</span> ${headerText} <span style="color: red;">👤</span>`;
    }
}
