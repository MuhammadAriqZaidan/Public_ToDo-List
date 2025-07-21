<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" type="image/x-icon" href="{{ asset('ikon_todos.ico') }}">
    <title>Login - ToDo App</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>

<script>
    function togglePassword() {
        const passwordInput = document.getElementById("password");
        const toggle = document.querySelector(".toggle-password");
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            toggle.textContent = "🙈"; // Ganti ikon
        } else {
            passwordInput.type = "password";
            toggle.textContent = "👁️";
        }
    }
</script>


<body>
    <div class="login-container">
        <h2>🔐 Login</h2>

        @if ($errors->any())
            <div class="error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="/login">
            @csrf
            <div class="textfield-wrapper"><input type="email" name="email" placeholder="Email" class="input-field"
                    required></div>
            <div class="textfield-wrapper">
                <input type="password" name="password" id="password" placeholder="Password" class="input-field"
                    required>
                <span class="toggle-password" onclick="togglePassword()">👁️</span>
            </div>
            <button type="submit">Login</button>
        </form>

        <div class="register-link">
            Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a>
        </div>
    </div>
</body>

</html>
