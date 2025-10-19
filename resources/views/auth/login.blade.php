<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="theme-color" content="#667eea">
    <title>Đăng nhập - English Learning</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            -webkit-tap-highlight-color: transparent;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            padding: 0;
            position: relative;
            overflow-x: hidden;
        }

        /* Animated Background */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 20% 80%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(255, 255, 255, 0.05) 0%, transparent 50%);
            animation: bgMove 15s ease-in-out infinite;
            pointer-events: none;
        }

        @keyframes bgMove {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(20px, 20px); }
        }

        /* Container */
        .login-wrapper {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            z-index: 1;
        }

        .login-container {
            background: white;
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 400px;
            padding: 32px 24px;
            animation: slideUp 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Logo Section - Clickable */
        .logo-link {
            text-decoration: none;
            display: block;
            text-align: center;
            margin-bottom: 32px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 16px;
            padding: 12px;
            position: relative;
        }

        .logo-link::after {
            content: '← Trang chủ';
            position: absolute;
            bottom: -8px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 11px;
            color: #999;
            opacity: 0;
            transition: all 0.3s;
            font-weight: 600;
            white-space: nowrap;
        }

        .logo-link:active {
            transform: scale(0.95);
            background: #f8f9fa;
        }

        .logo-link:hover::after {
            opacity: 1;
            bottom: -20px;
        }

        .logo {
            pointer-events: none;
        }

        .logo-icon {
            font-size: 48px;
            margin-bottom: 12px;
            animation: bounce 2s ease-in-out infinite;
            display: inline-block;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        .logo h1 {
            color: #667eea;
            font-size: 26px;
            margin-bottom: 8px;
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .logo p {
            color: #666;
            font-size: 14px;
            font-weight: 500;
        }

        /* Alert Messages */
        .alert {
            padding: 14px 16px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 14px;
            line-height: 1.5;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: slideInDown 0.4s ease;
        }

        @keyframes slideInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-success {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            color: #155724;
            border-left: 4px solid #28a745;
        }

        .alert-error {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
            color: #721c24;
            border-left: 4px solid #dc3545;
        }

        .alert-icon {
            font-size: 20px;
            flex-shrink: 0;
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .form-group label {
            display: block;
            color: #333;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 14px;
            transition: color 0.3s;
        }

        .input-wrapper {
            position: relative;
        }

        .form-control {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            font-size: 16px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            outline: none;
            background: #f8f9fa;
            font-family: inherit;
            touch-action: manipulation;
        }

        .form-control:focus {
            border-color: #667eea;
            background: white;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
            transform: translateY(-2px);
        }

        .form-control.error {
            border-color: #dc3545;
            background: #fff5f5;
        }

        .form-control::placeholder {
            color: #999;
        }

        .error-message {
            color: #dc3545;
            font-size: 13px;
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 4px;
            animation: shake 0.4s ease;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            75% { transform: translateX(10px); }
        }

        /* Password Toggle */
        .password-toggle {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #666;
            font-size: 20px;
            cursor: pointer;
            padding: 8px;
            transition: all 0.3s;
            touch-action: manipulation;
        }

        .password-toggle:active {
            transform: translateY(-50%) scale(0.9);
        }

        /* Form Options */
        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            gap: 12px;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .remember-me input[type="checkbox"] {
            width: 20px;
            height: 20px;
            cursor: pointer;
            accent-color: #667eea;
        }

        .remember-me label {
            font-size: 14px;
            color: #666;
            cursor: pointer;
            margin: 0;
            user-select: none;
            font-weight: 500;
        }

        .forgot-password {
            font-size: 14px;
            color: #667eea;
            text-decoration: none;
            transition: all 0.3s;
            font-weight: 600;
            white-space: nowrap;
        }

        .forgot-password:active {
            transform: scale(0.95);
        }

        /* Submit Button */
        .btn {
            width: 100%;
            padding: 16px;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-transform: uppercase;
            letter-spacing: 1px;
            font-family: inherit;
            touch-action: manipulation;
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn:active::before {
            width: 300px;
            height: 300px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
        }

        .btn-primary:active {
            transform: translateY(2px);
            box-shadow: 0 4px 10px rgba(102, 126, 234, 0.3);
        }

        .btn-primary.loading {
            pointer-events: none;
            opacity: 0.8;
        }

        .btn-primary.loading::after {
            content: '';
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            border: 3px solid white;
            border-top-color: transparent;
            border-radius: 50%;
            animation: spin 0.6s linear infinite;
        }

        @keyframes spin {
            to { transform: translateY(-50%) rotate(360deg); }
        }

        /* Divider */
        .divider {
            text-align: center;
            margin: 28px 0;
            position: relative;
        }

        .divider::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            width: 100%;
            height: 1px;
            background: linear-gradient(90deg, transparent, #e0e0e0, transparent);
        }

        .divider span {
            background: white;
            padding: 0 16px;
            color: #999;
            font-size: 13px;
            position: relative;
            z-index: 1;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Register Link */
        .register-link {
            text-align: center;
            margin-top: 24px;
        }

        .register-link p {
            color: #666;
            font-size: 15px;
            font-weight: 500;
        }

        .register-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 700;
            transition: all 0.3s;
        }

        .register-link a:active {
            transform: scale(0.95);
            display: inline-block;
        }

        /* Desktop Styles */
        @media (min-width: 481px) {
            .login-wrapper {
                padding: 40px 20px 20px;
            }

            .login-container {
                padding: 40px 32px;
            }

            .logo-link:hover {
                background: #f8f9fa;
            }

            .forgot-password:hover {
                color: #764ba2;
            }

            .btn-primary:hover {
                transform: translateY(-2px);
                box-shadow: 0 12px 30px rgba(102, 126, 234, 0.5);
            }

            .register-link a:hover {
                color: #764ba2;
            }
        }

        /* Extra Small Devices */
        @media (max-width: 360px) {
            .login-container {
                padding: 28px 20px;
            }

            .logo h1 {
                font-size: 22px;
            }

            .form-control {
                font-size: 15px;
                padding: 12px 14px;
            }

            .btn {
                padding: 14px;
                font-size: 15px;
            }
        }

        /* Safe Area Support */
        @supports (padding: env(safe-area-inset-top)) {
            body {
                padding-top: env(safe-area-inset-top);
                padding-bottom: env(safe-area-inset-bottom);
            }
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="login-container">
            <!-- Logo clickable để quay về trang chủ -->
            <a href="{{ route('client.home') }}" class="logo-link" aria-label="Quay về trang chủ">
                <div class="logo">
                    <div class="logo-icon">🎓</div>
                    <h1>English Learning</h1>
                    <p>Đăng nhập để tiếp tục</p>
                </div>
            </a>

            @if(session('success'))
                <div class="alert alert-success">
                    <span class="alert-icon">✅</span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if($errors->has('email') && !$errors->has('password'))
                <div class="alert alert-error">
                    <span class="alert-icon">❌</span>
                    <span>{{ $errors->first('email') }}</span>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" id="loginForm">
                @csrf
                
                <div class="form-group">
                    <label for="email">Email</label>
                    <div class="input-wrapper">
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            class="form-control @error('email') error @enderror" 
                            placeholder="example@email.com"
                            value="{{ old('email') }}"
                            autocomplete="email"
                            inputmode="email"
                            required
                        >
                    </div>
                    @error('email')
                        <span class="error-message">
                            <span>⚠️</span>
                            <span>{{ $message }}</span>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Mật khẩu</label>
                    <div class="input-wrapper">
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            class="form-control @error('password') error @enderror" 
                            placeholder="Nhập mật khẩu"
                            autocomplete="current-password"
                            required
                        >
                        <button type="button" class="password-toggle" onclick="togglePassword()" aria-label="Hiện/ẩn mật khẩu">
                            <span id="toggleIcon">👁️</span>
                        </button>
                    </div>
                    @error('password')
                        <span class="error-message">
                            <span>⚠️</span>
                            <span>{{ $message }}</span>
                        </span>
                    @enderror
                </div>

                <div class="form-options">
                    <div class="remember-me">
                        <input type="checkbox" id="remember" name="remember">
                        <label for="remember">Ghi nhớ</label>
                    </div>
                    <a href="#" class="forgot-password">Quên mật khẩu?</a>
                </div>

                <button type="submit" class="btn btn-primary" id="submitBtn">
                    Đăng nhập
                </button>
            </form>

            <div class="divider">
                <span>hoặc</span>
            </div>

            <div class="register-link">
                <p>Chưa có tài khoản? <a href="{{ route('register') }}">Đăng ký ngay</a></p>
            </div>
        </div>
    </div>

    <script>
        // Toggle password visibility
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.textContent = '🙈';
            } else {
                passwordInput.type = 'password';
                toggleIcon.textContent = '👁️';
            }
        }

        // Form submission
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const btn = document.getElementById('submitBtn');
            btn.classList.add('loading');
            btn.textContent = 'Đang xử lý...';
        });

        // Auto focus on page load
        window.addEventListener('load', function() {
            document.getElementById('email').focus();
        });

        // Prevent zoom on input focus (iOS)
        document.querySelectorAll('input').forEach(input => {
            input.addEventListener('focus', function() {
                this.style.fontSize = '16px';
            });
        });
    </script>
</body>
</html>
