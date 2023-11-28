import { login } from "@/src/auth.src";

document.addEventListener("DOMContentLoaded", async () => {
    const formLogin = document.querySelector("#formLogin");
    if (formLogin) {
        formLogin.addEventListener("submit", async (e) => {
            e.preventDefault();
            formLogin.classList.add("was-validated");

            if (formLogin.checkValidity()) {
                const data = await login({
                    email: formLogin.email.value,
                    password: formLogin.password.value,
                    remember: formLogin.remember.checked,
                });

                if (data.status) {
                    localStorage.setItem("access_token", data.access_token);

                    window.location.reload();
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: data.message,
                    });
                }
            }
        });
    }
});
