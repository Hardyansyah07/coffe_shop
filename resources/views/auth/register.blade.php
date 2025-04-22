<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
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
            background-image: url('/images/bg_cafe.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .register-container {
            display: flex;
            width: 800px;
            background: white;
            border-radius: 30px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .register-image {
            flex: 1;
            background-image: url('https://encrypted-tbn1.gstatic.com/images?q=tbn:ANd9GcTUGFDbiCutbj3OT0C4Nlqm-0nGuTP2AEaIFjvMJtm9U_7LRnYD'); /* Ganti dengan URL gambar Anda */
            background-size: cover;
            background-position: center;
        }

        .register-form {
            flex: 1;
            padding: 40px;
            background-color: #1d1d1d;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .register-form h2 {
            font-size: 24px;
            margin-bottom: 10px;
            text-align: center;
        }

        .register-form p {
            font-size: 14px;
            color: #aaaaaa;
            margin-bottom: 20px;
            text-align: center;
        }

        .register-form label {
            font-size: 14px;
            margin-bottom: 5px;
        }

        .register-form input {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: none;
            border-radius: 5px;
            background-color: #2d2d2d;
            color: white;
        }

        .register-form input:focus {
            outline: 2px solid #ffc107;
        }

        .register-form button {
            width: 100%;
            padding: 10px;
            background-color: #ffc107;
            color: black;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .register-form button:hover {
            background-color: #e0a800;
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
    <div class="register-container">
        <div class="register-image"></div>
        <div class="register-form">
            <h2>Create an Account</h2>
            <p>Please fill in the details to register</p>
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <label for="name">Name</label>
                <input id="name" type="text" class="@error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                @error('name')
                    <span style="color: red;">{{ $message }}</span>
                @enderror

                <label for="email">Email Address</label>
                <input id="email" type="email" class="@error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                @error('email')
                    < span style="color: red;">{{ $message }}</span>
                @enderror

                <label for="password">Password</label>
                <input id="password" type="password" class="@error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                @error('password')
                    <span style="color: red;">{{ $message }}</span>
                @enderror

                <label for="password-confirm">Confirm Password</label>
                <input id="password-confirm" type="password" name="password_confirmation" required autocomplete="new-password">

                <!-- Hidden input for role -->
                <input type="hidden" name="role" value="user">

                <div class="form-group mb-0">
                    <button type="submit">Register</button>
                </div>
            </form>
            <div class="signup-link">
                <p>Already have an account? <a href="/login">Login here</a></p>
            </div>
        </div>
    </div>
</body>
</html>