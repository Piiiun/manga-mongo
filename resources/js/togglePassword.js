export function togglePassword(inputId, button) {
    const input = document.getElementById(inputId);
    const eyeOpen = button.querySelector('.eye-open');
    const eyeClosed = button.querySelector('.eye-closed');

    const isPassword = input.type === "password";

    input.type = isPassword ? "text" : "password";
    eyeOpen.classList.toggle("hidden", isPassword);
    eyeClosed.classList.toggle("hidden", !isPassword);
}
