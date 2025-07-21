<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" type="image/x-icon" href="{{ asset('ikon_todos.ico') }}">
    <title>Register - ToDo App</title>
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
</head>

<body>
    <div class="register-container">
        <h2>📝 Register</h2>

        @if ($errors->any())
            <div class="error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="/register">
            @csrf
            <div class="textfield-wrapper">
                <input type="text" name="name" placeholder="Nama Lengkap" class="input-field" required>
            </div>
            <div class="textfield-wrapper">
                <input type="email" name="email" placeholder="Email" class="input-field" required>
            </div>
            <div class="textfield-wrapper">
                <input type="password" name="password" id="password" placeholder="Password" class="input-field"
                    required>
                <span class="toggle-password" onclick="togglePassword()">👁️</span>
            </div>
            <div class="textfield-wrapper">
                <input type="password" name="password_confirmation" id="password_confirmation"
                    placeholder="Konfirmasi Password" class="input-field" required>
                <span class="toggle-password" onclick="togglePasswordConfirm()">👁️</span>
            </div>

            <button type="submit">Daftar</button>
        </form>

        <div class="login-link">
            Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById("password");
            const toggle = document.querySelector(".toggle-password");
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                toggle.textContent = "🙈";
            } else {
                passwordInput.type = "password";
                toggle.textContent = "👁️";
            }
        }

        function togglePasswordConfirm() {
            const confirmInput = document.getElementById("password_confirmation");
            const toggle = confirmInput.nextElementSibling;
            if (confirmInput.type === "password") {
                confirmInput.type = "text";
                toggle.textContent = "🙈";
            } else {
                confirmInput.type = "password";
                toggle.textContent = "👁️";
            }
        }
    </script>

</body>

</html>
