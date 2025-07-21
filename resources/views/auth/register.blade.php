<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" type="image/x-icon" href="{{ asset('ikon_todos.ico') }}">
    <title>Register - ToDo App</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .register-container {
            background-color: #fff;
            border: 1px solid #ddd;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        h2 {
            text-align: center;
            margin-bottom: 1.5rem;
            color: #444;
        }

        .input-field {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ccc;
            border-radius: 8px;
        }

        .textfield-wrapper {
            position: relative;
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }

        .textfield-wrapper input {
            width: 100%;
            padding-right: 3rem;
        }

        .toggle-password {
            position: absolute;
            right: 1rem;
            cursor: pointer;
            user-select: none;
            font-size: 1.1rem;
            color: #888;
        }

        button {
            width: 100%;
            padding: 0.75rem;
            background-color: #f5e663;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #e4d94e;
        }

        .error {
            background-color: #ffe6e6;
            border: 1px solid #ff5c5c;
            color: #cc0000;
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 8px;
        }

        .login-link {
            margin-top: 1rem;
            text-align: center;
            font-size: 0.9rem;
        }

        .login-link a {
            color: #b89b00;
            text-decoration: none;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        @media (max-width: 480px) {
            body {
                padding: 1rem;
            }

            .register-container {
                padding: 1.5rem 1rem;
            }
        }
    </style>
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
