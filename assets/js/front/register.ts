const togglePassword:HTMLElement = document.querySelector("#togglePassword");
const password:HTMLInputElement = document.querySelector('#registration_form_plainPassword');

togglePassword.addEventListener("click", function () {
    const type = password.getAttribute("type") === "password" ? "text" : "password";
    password.setAttribute("type", type);
    const icon = togglePassword.getAttribute("class") === "fa-solid fa-eye" ? "fa-solid fa-eye-slash" : "fa-solid fa-eye";
    togglePassword.setAttribute("class", icon);
});