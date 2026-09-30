<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>World Team Dormitory - Admin Login</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --navy: #031b4e;
            --navy2: #062966;
            --blue: #1688ff;
            --blue2: #35a5ff;
            --light: #dcecff;
            --white: #ffffff;
        }

        body {
            min-height: 100vh;
            font-family: "Inter", sans-serif;
            background:
                radial-gradient(circle at 10% 10%, rgba(27,137,255,.22), transparent 28%),
                radial-gradient(circle at 90% 90%, rgba(0,112,255,.15), transparent 30%),
                linear-gradient(135deg, #02153e, #062965 55%, #031b4e);
            color: white;
            overflow-x: hidden;
        }

        body::before {
            content: "";
            position: fixed;
            width: 450px;
            height: 450px;
            top: -220px;
            left: -180px;
            border-radius: 50%;
            background: rgba(32,130,255,.15);
            filter: blur(5px);
        }

        body::after {
            content: "";
            position: fixed;
            width: 500px;
            height: 500px;
            right: -250px;
            bottom: -250px;
            border-radius: 50%;
            background: rgba(0,105,255,.12);
        }

        .container {
            width: 100%;
            min-height: 100vh;
            padding: 35px 55px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            z-index: 2;
        }

        .wrapper {
            width: 1100px;
            max-width: 100%;
            min-height: 620px;
            display: grid;
            grid-template-columns: 48% 52%;
            border-radius: 28px;
            overflow: hidden;
            background: rgba(255,255,255,.035);
            border: 1px solid rgba(255,255,255,.1);
            box-shadow:
                0 35px 90px rgba(0,0,0,.35),
                inset 0 1px 0 rgba(255,255,255,.08);
        }

        /* LEFT SIDE */
        .left {
            position: relative;
            padding: 55px 50px 40px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            background: linear-gradient(180deg, rgba(4,32,84,.95), rgba(2,21,59,.98));
        }

        .left::before {
            content: "";
            position: absolute;
            width: 500px;
            height: 300px;
            left: -160px;
            top: -120px;
            background: #0a438e;
            border-radius: 50%;
            opacity: .25;
        }

        /* ==================== កែសម្រួល LOGO សម្រាប់រូបភាព ==================== */
        .logo {
            width: 110px;
            height: 110px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.95);
            display: flex;
            align-items: center;
            justify-content: center;
            border: 5px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.35);
            position: relative;
            z-index: 2;
            overflow: hidden; /* ការពារកុំឱ្យរូបភាពហៀរចេញក្រៅរង្វង់ */
            padding: 8px;     /* បន្ថយឬដកចេញបើចង់ឱ្យរូបពេញគែម */
        }

        .logo img {
           width: 120%;
            height: 120%;
            object-fit: contain; /* ធានារូបភាពមិនខូចទ្រង់ទ្រាយ */
            display: block;
        }
        /* ================================================================= */

        .brand-name {
            text-align: center;
            margin-top: 20px;
            position: relative;
            z-index: 2;
        }

        .brand-name h1 {
            font-size: 38px;
            font-weight: 800;
            line-height: 1.1;
            letter-spacing: -1px;
        }

        .brand-name h1 span {
            display: block;
            color: #249cff;
        }

        .line {
            width: 250px;
            height: 2px;
            margin: 20px auto;
            background: linear-gradient(90deg, transparent, #229aff, transparent);
        }

        .welcome {
            text-align: center;
            position: relative;
            z-index: 2;
        }

        .welcome h2 {
            font-size: 23px;
            line-height: 1.4;
            font-weight: 700;
        }

        .welcome p {
            margin-top: 12px;
            color: #9dbbe3;
            font-size: 13.5px;
            letter-spacing: .5px;
        }

        /* RIGHT SIDE */
        .right {
            background: rgba(3,25,67,.9);
            padding: 50px 65px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .form-card {
            width: 100%;
            max-width: 440px;
        }

        .form-heading {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 25px;
        }

        .form-icon {
            width: 58px;
            height: 58px;
            border-radius: 50%;
            background: linear-gradient(135deg, #167eff, #32a8ff);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            box-shadow: 0 10px 25px rgba(18,126,255,.25);
            flex-shrink: 0;
        }

        .form-heading h2 {
            font-size: 28px;
            font-weight: 700;
        }

        .form-heading p {
            color: #8eabd2;
            font-size: 13px;
            margin-top: 4px;
        }

        /* Flash Messages */
        .alert-success {
            background: rgba(34, 197, 94, 0.15);
            border: 1px solid rgba(34, 197, 94, 0.4);
            border-radius: 10px;
            padding: 12px 16px;
            margin-bottom: 20px;
            color: #86efac;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .alert-danger {
            background: rgba(239, 68, 68, 0.15);
            border: 1px solid rgba(239, 68, 68, 0.4);
            border-radius: 10px;
            padding: 12px 16px;
            margin-bottom: 20px;
            color: #fca5a5;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 13px;
            font-weight: 600;
            color: #eef5ff;
        }

        .input-box {
            height: 52px;
            display: flex;
            align-items: center;
            border-radius: 12px;
            border: 1px solid rgba(91,157,225,.45);
            background: rgba(7,42,91,.7);
            transition: .25s;
        }

        .input-box:focus-within {
            border-color: #239cff;
            box-shadow: 0 0 0 3px rgba(35,156,255,.15), 0 7px 20px rgba(0,0,0,.15);
        }

        .input-icon {
            width: 52px;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #c8ddf8;
            background: rgba(55,128,212,.2);
            border-radius: 11px 0 0 11px;
        }

        .input-box input {
            flex: 1;
            height: 100%;
            border: none;
            outline: none;
            background: transparent;
            color: white;
            padding: 0 16px;
            font-size: 14px;
        }

        .input-box input::placeholder {
            color: #7998c0;
        }

        .password-toggle {
            width: 48px;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #89a7cb;
            cursor: pointer;
            transition: color .2s;
        }

        .password-toggle:hover {
            color: #ffffff;
        }

        /* Remember Me */
        .form-check {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 12px;
        }

        .form-check input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: #1688ff;
            cursor: pointer;
        }

        .form-check label {
            color: #b8cee9;
            font-size: 13.5px;
            cursor: pointer;
            user-select: none;
        }

        .login-btn {
            width: 100%;
            height: 52px;
            margin-top: 10px;
            border: none;
            border-radius: 12px;
            color: white;
            background: linear-gradient(90deg, #1687ff, #30a5ff);
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            box-shadow: 0 12px 28px rgba(21,134,255,.28);
            transition: .25s;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 17px 35px rgba(21,134,255,.38);
        }

        .login-btn:active {
            transform: translateY(0);
        }

        .register-text {
            text-align: center;
            margin-top: 25px;
            color: #8da8cb;
            font-size: 13.5px;
        }

        .register-text a {
            color: #2aa1ff;
            font-weight: 700;
            text-decoration: none;
        }

        .register-text a:hover {
            text-decoration: underline;
        }

        @media (max-width: 900px) {
            .container { padding: 20px; }
            .wrapper { grid-template-columns: 1fr; min-height: auto; }
            .left { padding: 45px 30px; }
            .right { padding: 45px 30px; }
        }
    </style>
</head>

<body>

<div class="container">
    <div class="wrapper">

        <!-- LEFT BRAND SECTION -->
        <section class="left">
            <!-- ================= LOGO IMAGE ================= -->
            <div class="logo">
                {{-- ដាក់ File រូបភាពក្នុង public/images/logo.png ហើយហៅតាមបែប Laravel asset() --}}
                <img src="{{ asset('images/Logo WT.png') }}" alt="World Team Logo">
            </div>
            <!-- ============================================== -->

            <div class="brand-name">
                <h1>World Team <span>Dormitory</span></h1>
                <div class="line"></div>
            </div>

            <div class="welcome">
                <h2>Welcome Back</h2>
                <p>Sign in to access your dashboard and records</p>
            </div>
        </section>

        <!-- RIGHT LOGIN FORM -->
        <section class="right">
            <div class="form-card">

                <div class="form-heading">
                    <div class="form-icon">
                        <i class="fa-solid fa-arrow-right-to-bracket"></i>
                    </div>
                    <div>
                        <h2>Admin Login</h2>
                        <p>Enter your credentials to continue</p>
                    </div>
                </div>

                {{-- Success Flash Message --}}
                @if (session('success'))
                    <div class="alert-success">
                        <i class="fa-solid fa-circle-check"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                {{-- Error Message Display --}}
                @if ($errors->any())
                    <div class="alert-danger">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                {{-- Form Submission --}}
                <form action="{{ route('admin.login') }}" method="POST">
                    @csrf

                    <!-- Username -->
                    <div class="form-group">
                        <label for="username">Username</label>
                        <div class="input-box">
                            <div class="input-icon">
                                <i class="fa-solid fa-user"></i>
                            </div>
                            <input 
                                type="text" 
                                id="username" 
                                name="username" 
                                value="{{ old('username') }}" 
                                placeholder="Enter username" 
                                autocomplete="username"
                                required 
                                autofocus
                            >
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="input-box">
                            <div class="input-icon">
                                <i class="fa-solid fa-lock"></i>
                            </div>
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                placeholder="Enter your password" 
                                autocomplete="current-password"
                                required
                            >
                            <div class="password-toggle" id="passwordToggle">
                                <i class="fa-regular fa-eye"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Remember Me -->
                    <div class="form-check">
                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label for="remember">Remember Me</label>
                    </div>

                    <!-- Login Button -->
                    <button type="submit" class="login-btn">
                        <span>Log In</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </form>

                <div class="register-text">
                    Don't have an account? 
                    <a href="{{ route('admin.register') }}">Register</a>
                </div>

            </div>
        </section>

    </div>
</div>

<script>
    const passwordInput = document.getElementById("password");
    const passwordToggle = document.getElementById("passwordToggle");

    if (passwordToggle && passwordInput) {
        passwordToggle.addEventListener("click", function () {
            const isPassword = passwordInput.type === "password";
            passwordInput.type = isPassword ? "text" : "password";
            this.innerHTML = isPassword 
                ? '<i class="fa-regular fa-eye-slash"></i>' 
                : '<i class="fa-regular fa-eye"></i>';
        });
    }
</script>

</body>
</html>