<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>World Team Dormitory - Register</title>

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
            width: 1250px;
            max-width: 100%;
            min-height: 760px;
            display: grid;
            grid-template-columns: 46% 54%;
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
            padding: 55px 45px 40px;
            display: flex;
            flex-direction: column;
            align-items: center;
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
            width: 105px;
            height: 105px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.95);
            display: flex;
            align-items: center;
            justify-content: center;
            border: 5px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.35);
            position: relative;
            z-index: 2;
            overflow: hidden; /* កាត់គែមរូបភាពកុំឱ្យហៀរចេញក្រៅរង្វង់ */
            padding: 8px;     /* បន្ថយ ឬដក padding នេះចេញបើចង់ឱ្យរូបភាពពេញគែម */
        }

        .logo img {
            width: 120%;
            height: 120%;
            object-fit: contain; /* ធានាថារូបភាពមិនខូចទំហំសមាមាត្រ */
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
            font-size: 36px;
            font-weight: 800;
            line-height: 1.1;
            letter-spacing: -1.2px;
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
            font-size: 22px;
            line-height: 1.35;
            font-weight: 700;
        }

        .welcome p {
            margin-top: 12px;
            color: #9dbbe3;
            font-size: 13px;
            letter-spacing: .5px;
        }

        .building {
            width: 100%;
            height: 220px;
            margin-top: 25px;
            border-radius: 20px;
            overflow: hidden;
            position: relative;
            background:
                linear-gradient(180deg, rgba(5,32,75,.1), rgba(3,20,51,.8)),
                url("https://images.unsplash.com/photo-1562774053-701939374585?auto=format&fit=crop&w=1000&q=85");
            background-size: cover;
            background-position: center;
            border: 1px solid rgba(255,255,255,.12);
            box-shadow: 0 20px 40px rgba(0,0,0,.3);
        }

        .features {
            width: 100%;
            display: flex;
            justify-content: space-around;
            margin-top: 25px;
            position: relative;
            z-index: 4;
        }

        .feature {
            text-align: center;
            width: 33%;
        }

        .feature + .feature {
            border-left: 1px solid rgba(255,255,255,.18);
        }

        .feature i {
            font-size: 22px;
            color: #2aa1ff;
            margin-bottom: 8px;
        }

        .feature span {
            display: block;
            color: #b8cee9;
            font-size: 11px;
            line-height: 1.4;
        }

        /* RIGHT SIDE */
        .right {
            background: rgba(3,25,67,.9);
            padding: 40px 50px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .form-card {
            width: 100%;
            max-width: 540px;
        }

        .form-heading {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 22px;
        }

        .form-icon {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            background: linear-gradient(135deg, #167eff, #32a8ff);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            box-shadow: 0 10px 25px rgba(18,126,255,.25);
            flex-shrink: 0;
        }

        .form-heading h2 {
            font-size: 26px;
            font-weight: 700;
        }

        .form-heading p {
            color: #8eabd2;
            font-size: 13px;
            margin-top: 3px;
        }

        /* Alert errors */
        .error-alert {
            background: rgba(239, 68, 68, 0.15);
            border: 1px solid rgba(239, 68, 68, 0.4);
            border-radius: 10px;
            padding: 12px 16px;
            margin-bottom: 20px;
            color: #fca5a5;
            font-size: 13px;
        }

        .error-alert ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .error-alert li {
            margin-bottom: 4px;
        }

        /* Fields */
        .form-group {
            margin-bottom: 14px;
        }

        .form-group label {
            display: block;
            margin-bottom: 6px;
            font-size: 12.5px;
            font-weight: 600;
            color: #eef5ff;
        }

        .input-box {
            min-height: 46px;
            display: flex;
            align-items: stretch;
            border-radius: 10px;
            border: 1px solid rgba(91,157,225,.45);
            background: rgba(7,42,91,.7);
            transition: .25s;
            overflow: hidden;
        }

        .input-box:focus-within {
            border-color: #239cff;
            box-shadow: 0 0 0 3px rgba(35,156,255,.15);
        }

        .input-icon {
            width: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #c8ddf8;
            background: rgba(55,128,212,.2);
            flex-shrink: 0;
        }

        .input-box input,
        .input-box select,
        .input-box textarea {
            flex: 1;
            border: none;
            outline: none;
            background: transparent;
            color: white;
            padding: 10px 14px;
            font-size: 13px;
            font-family: inherit;
        }

        .input-box textarea {
            resize: vertical;
            min-height: 46px;
        }

        .input-box input::placeholder,
        .input-box textarea::placeholder {
            color: #7998c0;
        }

        .input-box select {
            cursor: pointer;
        }

        .input-box select option {
            background: #06285c;
            color: white;
        }

        .password-toggle {
            width: 45px;
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

        .row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .register-btn {
            width: 100%;
            height: 52px;
            margin-top: 10px;
            border: none;
            border-radius: 11px;
            color: white;
            background: linear-gradient(90deg, #1687ff, #30a5ff);
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            box-shadow: 0 12px 28px rgba(21,134,255,.25);
            transition: .25s;
        }

        .register-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 17px 35px rgba(21,134,255,.35);
        }

        .register-btn:active {
            transform: translateY(0);
        }

        .login-text {
            text-align: center;
            margin-top: 18px;
            color: #8da8cb;
            font-size: 13px;
        }

        .login-text a {
            color: #2aa1ff;
            font-weight: 700;
            text-decoration: none;
        }

        .login-text a:hover {
            text-decoration: underline;
        }

        @media (max-width: 1050px) {
            .container { padding: 20px; }
            .wrapper { grid-template-columns: 1fr; }
            .left { padding: 40px; }
            .right { padding: 40px 30px; }
        }

        @media (max-width: 600px) {
            .container { padding: 0; }
            .wrapper { border-radius: 0; min-height: 100vh; }
            .left { padding: 30px 20px; }
            .brand-name h1 { font-size: 28px; }
            .welcome h2 { font-size: 20px; }
            .building { height: 180px; }
            .right { padding: 30px 20px; }
            .row { grid-template-columns: 1fr; gap: 0; }
        }
    </style>
</head>

<body>

<div class="container">
    <div class="wrapper">

        <!-- LEFT SIDE -->
        <section class="left">
            <!-- ================= LOGO IMAGE ================= -->
            <div class="logo">
                {{-- ដាក់ File រូបភាពក្នុង folder public/images/logo.png --}}
                <img src="{{ asset('images/Logo WT.png') }}" alt="World Team Logo">
            </div>
            <!-- ============================================== -->

            <div class="brand-name">
                <h1>World Team <span>Dormitory</span></h1>
                <div class="line"></div>
            </div>

            <div class="welcome">
                <h2>Welcome to<br>World Team Dormitory</h2>
                <p>A safe place &nbsp; • &nbsp; A better life &nbsp; • &nbsp; Together</p>
            </div>

            <div class="building"></div>

            <div class="features">
                <div class="feature">
                    <i class="fa-solid fa-shield-halved"></i>
                    <span>Safe<br>Environment</span>
                </div>
                <div class="feature">
                    <i class="fa-solid fa-users"></i>
                    <span>Friendly<br>Community</span>
                </div>
                <div class="feature">
                    <i class="fa-solid fa-graduation-cap"></i>
                    <span>Bright<br>Future</span>
                </div>
            </div>
        </section>

        <!-- RIGHT SIDE -->
        <section class="right">
            <div class="form-card">

                <div class="form-heading">
                    <div class="form-icon">
                        <i class="fa-solid fa-user-plus"></i>
                    </div>
                    <div>
                        <h2>Admin Registration</h2>
                        <p>Create your account to join World Team Dormitory</p>
                    </div>
                </div>

                {{-- Validation Errors Display --}}
                @if ($errors->any())
                    <div class="error-alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li><i class="fa-solid fa-circle-exclamation"></i> {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Form Submission to Laravel Route --}}
                <form action="{{ route('admin.register') }}" method="POST">
                    @csrf

                    <!-- Full Name -->
                    <div class="form-group">
                        <label for="fullName">Full Name</label>
                        <div class="input-box">
                            <div class="input-icon"><i class="fa-solid fa-user"></i></div>
                            <input 
                                type="text" 
                                id="fullName" 
                                name="full_name" 
                                value="{{ old('full_name') }}" 
                                placeholder="Enter your full name" 
                                required
                            >
                        </div>
                    </div>

                    <!-- Username -->
                    <div class="form-group">
                        <label for="username">Username</label>
                        <div class="input-box">
                            <div class="input-icon"><i class="fa-solid fa-user-tag"></i></div>
                            <input 
                                type="text" 
                                id="username" 
                                name="username" 
                                value="{{ old('username') }}" 
                                placeholder="Choose a username" 
                                required
                            >
                        </div>
                    </div>

                    <!-- Gender & DOB -->
                    <div class="row">
                        <div class="form-group">
                            <label for="gender">Gender</label>
                            <div class="input-box">
                                <div class="input-icon"><i class="fa-solid fa-venus-mars"></i></div>
                                <select id="gender" name="gender" required>
                                    <option value="">Select Gender</option>
                                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                    <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="dob">DOB</label>
                            <div class="input-box">
                                <div class="input-icon"><i class="fa-regular fa-calendar"></i></div>
                                <input 
                                    type="date" 
                                    id="dob" 
                                    name="dob" 
                                    value="{{ old('dob') }}" 
                                    required
                                >
                            </div>
                        </div>
                    </div>

                    <!-- Phone -->
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <div class="input-box">
                            <div class="input-icon"><i class="fa-solid fa-phone"></i></div>
                            <input 
                                type="tel" 
                                id="phone" 
                                name="phone" 
                                value="{{ old('phone') }}" 
                                placeholder="Enter your phone number" 
                                required
                            >
                        </div>
                    </div>

                    <!-- Address -->
                    <div class="form-group">
                        <label for="address">Address</label>
                        <div class="input-box">
                            <div class="input-icon"><i class="fa-solid fa-location-dot"></i></div>
                            <textarea 
                                id="address" 
                                name="address" 
                                rows="2" 
                                placeholder="Enter your address"
                            >{{ old('address') }}</textarea>
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="input-box">
                            <div class="input-icon"><i class="fa-solid fa-lock"></i></div>
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                placeholder="Enter password" 
                                required
                            >
                            <div class="password-toggle" id="passwordToggle">
                                <i class="fa-regular fa-eye"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Confirm Password -->
                    <div class="form-group">
                        <label for="password_confirmation">Confirm Password</label>
                        <div class="input-box">
                            <div class="input-icon"><i class="fa-solid fa-shield-halved"></i></div>
                            <input 
                                type="password" 
                                id="password_confirmation" 
                                name="password_confirmation" 
                                placeholder="Re-enter password" 
                                required
                            >
                            <div class="password-toggle" id="confirmPasswordToggle">
                                <i class="fa-regular fa-eye"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="register-btn">
                        <i class="fa-solid fa-user-plus"></i>
                        <span>Register</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </form>

                <div class="login-text">
                    Already have an account?
                    <a href="{{ route('admin.login') }}">Login here</a>
                </div>

            </div>
        </section>

    </div>
</div>

<script>
    function setupPasswordToggle(toggleId, inputId) {
        const toggleBtn = document.getElementById(toggleId);
        const inputField = document.getElementById(inputId);

        if (toggleBtn && inputField) {
            toggleBtn.addEventListener('click', function () {
                const isPassword = inputField.type === 'password';
                inputField.type = isPassword ? 'text' : 'password';
                this.innerHTML = isPassword 
                    ? '<i class="fa-regular fa-eye-slash"></i>' 
                    : '<i class="fa-regular fa-eye"></i>';
            });
        }
    }

    setupPasswordToggle('passwordToggle', 'password');
    setupPasswordToggle('confirmPasswordToggle', 'password_confirmation');
</script>

</body>
</html>