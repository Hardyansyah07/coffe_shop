<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-image: url('https://png.pngtree.com/thumb_back/fw800/background/20231024/pngtree-aesthetic-blend-roasted-coffee-beans-atop-a-weathered-concrete-surface-image_13690854.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .login-container {
            display: flex;
            width: 800px;
            background: white;
            border-radius: 30px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .login-image {
            flex: 1;
            background-image: url('https://encrypted-tbn1.gstatic.com/images?q=tbn:ANd9GcTUGFDbiCutbj3OT0C4Nlqm-0nGuTP2AEaIFjvMJtm9U_7LRnYD'); /* Ganti dengan URL gambar Anda */
            background-size: cover;
            background-position: center;
        }

        .login-form {
            flex: 1;
            padding: 40px;
            background-color: #1d1d1d;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-form h2 {
            font-size: 24px;
            margin-bottom: 10px;
            text-align: center;
        }

        .login-form p {
            font-size: 14px;
            color: #aaaaaa;
            margin-bottom: 20px;
            text-align: center;
        }

        .login-form label {
            font-size: 14px;
            margin-bottom: 5px;
        }

        .login-form input {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: none;
            border-radius: 5px;
            background-color: #2d2d2d;
            color: white;
        }

        .login-form input:focus {
            outline: 2px solid #ffc107;
        }

        .login-form button {
            width: 100%;
            padding: 10px;
            background-color: #ffc107;
            color: black;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .login-form button:hover {
            background-color: #e0a800;
        }

        .social-login {
            margin-top: 20px;
            text-align: center;
        }

        .social-login button {
            width: 100%;
            padding: 10px;
            background-color: #e0e0e0;
            color: #333;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }

        .social-login button:hover {
            background-color: #d6d6d6;
        }

        .signup-link {
            margin-top: 20px;
            text-align: center;
            font-size: 14px;
        }

        .signup-link a {
            color: #ffc107;
            text-decoration: none;
        }

        .signup-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-image"></div>
        <div class="login-form">
            <h2>Welcome Back</h2>
            <p>Please login to your account</p>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" placeholder="you@example.com" required>
                @error('email')
                    <span style="color: red;">{{ $message }}</span>
                @enderror
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
                @error('password')
                    <span style="color: red;">{{ $message }}</span>
                @enderror
                <button type="submit">Sign In</button>
            </form>
            <div class="social-login">
            </div>
            <div class="signup-link">
                <p>Don't have an account? <a href="/register">Sign up</a></p>
            </div>
        </div>
    </div>
</body>
</html>