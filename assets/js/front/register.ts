const togglePasswordRegister:HTMLElement = document.querySelector("#togglePassword");
const passwordRegister:HTMLInputElement = document.querySelector('#registration_form_plainPassword');

togglePasswordRegister.addEventListener("click", function () {
    const typeRegister = passwordRegister.getAttribute("type") === "password" ? "text" : "password";
    passwordRegister.setAttribute("type", typeRegister);
    const iconRegister = togglePasswordRegister.getAttribute("class") === "fa-solid fa-eye" ? "fa-solid fa-eye-slash" : "fa-solid fa-eye";
    togglePasswordRegister.setAttribute("class", iconRegister);
});