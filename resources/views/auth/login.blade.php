<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            width: 100%;
        }
        .login-container {
            display: flex;
            min-height: 100vh;
            width: 100%;
        }
        .login-form {
            width: 50%;
            background-color: white;
            padding: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-banner {
            width: 50%;
            background: linear-gradient(135deg, #4338ca 0%, #5b21b6 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .circle {
            position: absolute;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }
        .circle-1 {
            width: 200px;
            height: 200px;
            top: -50px;
            right: -50px;
        }
        .circle-2 {
            width: 300px;
            height: 300px;
            bottom: -100px;
            left: -100px;
        }
        .form-container {
            width: 100%;
            max-width: 400px;
        }
        .form-input {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
        }
        .form-button {
            width: 100%;
            padding: 12px;
            background-color: #4f46e5;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
        }
        .form-button:hover {
            background-color: #4338ca;
        }
        .form-link {
            color: #4f46e5;
            text-decoration: none;
        }
        .form-link:hover {
            text-decoration: underline;
        }
        
        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
            }
            .login-form, .login-banner {
                width: 100%;
            }
            .login-banner {
                min-height: 200px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-form">
            <div class="form-container">
                <h2 style="text-align: center; font-size: 24px; font-weight: bold; margin-bottom: 30px;">Log in</h2>
                
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <div style="margin-bottom: 15px;">
                        <label for="email" style="display: block; margin-bottom: 5px;">Email</label>
                        <input id="email" class="form-input" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="user name">
                        @error('email')
                            <span style="color: red; font-size: 14px;">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div style="margin-bottom: 15px;">
                        <label for="password" style="display: block; margin-bottom: 5px;">Password</label>
                        <input id="password" class="form-input" type="password" name="password" required autocomplete="current-password" placeholder="password">
                        @error('password')
                            <span style="color: red; font-size: 14px;">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div style="text-align: right; margin-bottom: 15px;">
                        @if (Route::has('password.request'))
                            <a class="form-link" href="{{ route('password.request') }}">Forgot your password?</a>
                        @endif
                    </div>
                    
                    <div style="margin-bottom: 20px;">
                        <label style="display: flex; align-items: center;">
                            <input type="checkbox" name="remember" style="margin-right: 10px;">
                            <span>Remember me</span>
                        </label>
                    </div>
                    
                    <div style="margin-bottom: 20px;">
                        <button type="submit" class="form-button">Log in</button>
                    </div>
                    
                    <div style="text-align: center;">
                        <span>Don't have any account? </span>
                        <a class="form-link" href="{{ route('register') }}">Sign Up</a>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="login-banner">
            <div class="circle circle-1"></div>
            <div class="circle circle-2"></div>
            <div>
                <h1 style="font-size: 36px; font-weight: bold; margin-bottom: 10px;">WELCOME !</h1>
                <p style="font-size: 18px;">Log in to continue</p>
            </div>
        </div>
    </div>
</body>
</html>
