<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f4f4;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .login-container {
            display: flex;
            width: 800px;
            height: 400px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            overflow: hidden;
            background-color: #fff;
        }

        .left-section {
            flex: 1;
            background-color: #dcdcdc;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .left-section img {
            width: 310px;
            height: auto;
        }

        .right-section {
            flex: 1.5;
            padding: 20px;
            background: linear-gradient(135deg, #004d40, #26a69a);
            color: #fff;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .right-section h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: none;
            outline: none;
        }

        .btn-login {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #004d40;
            color: #fff;
            font-weight: bold;
            cursor: pointer;
            margin-top: 10px;
        }

        .btn-login:hover {
            background-color: #26a69a;
        }

        .links {
            text-align: center;
            margin-top: 10px;
        }

        .links a {
            color: #cfd8dc;
            text-decoration: none;
        }

        .links a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <!-- Left Section (Profile Image) -->
        <div class="left-section">
            <img src="{{ asset('assets/img/donasilogin.jpg') }}" alt="Profile Image">
        </div>

        <!-- Right Section (Login Form) -->
        <div class="right-section">
            <h2>Login</h2>
            <form action="{{ route('login.authenticate') }}" method="POST">
                @csrf
                <div class="form-group">
                    <input type="email" name="email" placeholder="Email">
                </div>
                <div class="form-group">
                    <input type="password" name="password" placeholder="Password">
                </div>
                <button type="submit" class="btn-login">Login</button>
            </form>
            <div class="links">
                <a href="forgot-password.html">Forgot Password?</a><br>
                <a href="{{ route('register') }}">Don't have an account? Register now!</a>
            </div>
        </div>
    </div>
</body>

</html>
