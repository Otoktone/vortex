const togglePasswordLogin:HTMLElement = document.querySelector("#togglePassword");
const passwordLogin:HTMLInputElement = document.querySelector('#inputPassword');

togglePasswordLogin.addEventListener("click", function () {
    const typeLogin = passwordLogin.getAttribute("type") === "password" ? "text" : "password";
    passwordLogin.setAttribute("type", typeLogin);
    const iconRegister = togglePasswordLogin.getAttribute("class") === "fa-solid fa-eye" ? "fa-solid fa-eye-slash" : "fa-solid fa-eye";
    togglePasswordLogin.setAttribute("class", iconRegister);
});
