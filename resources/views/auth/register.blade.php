<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="theme-color" content="#667eea">
    <title>Đăng ký - English Learning</title>
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

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 20% 80%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 255, 255, 0.1) 0%, transparent 50%);
            animation: bgMove 15s ease-in-out infinite;
            pointer-events: none;
        }

        @keyframes bgMove {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(20px, 20px); }
        }

        .register-wrapper {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            z-index: 1;
        }

        .register-container {
            background: white;
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 440px;
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
            margin-bottom: 28px;
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
            font-size: 44px;
            margin-bottom: 10px;
            animation: bounce 2s ease-in-out infinite;
            display: inline-block;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        .logo h1 {
            color: #667eea;
            font-size: 24px;
            margin-bottom: 6px;
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .logo p {
            color: #666;
            font-size: 14px;
            font-weight: 500;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            color: #333;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 14px;
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

        /* Level Selection */
        .level-label-text {
            display: block;
            color: #333;
            font-weight: 600;
            margin-bottom: 10px;
            font-size: 14px;
        }

        .level-options {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
        }

        .level-option {
            position: relative;
        }

        .level-option input[type="radio"] {
            position: absolute;
            opacity: 0;
            cursor: pointer;
        }

        .level-label {
            display: block;
            padding: 12px 8px;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            text-align: center;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background: #f8f9fa;
            font-weight: 600;
            touch-action: manipulation;
        }

        .level-option input[type="radio"]:checked + .level-label {
            border-color: #667eea;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .level-label:active {
            transform: scale(0.95);
        }

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
            margin-top: 8px;
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

        .divider {
            text-align: center;
            margin: 24px 0;
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

        .login-link {
            text-align: center;
            margin-top: 20px;
        }

        .login-link p {
            color: #666;
            font-size: 15px;
            font-weight: 500;
        }

        .login-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 700;
            transition: all 0.3s;
        }

        .login-link a:active {
            transform: scale(0.95);
            display: inline-block;
        }

        @media (min-width: 481px) {
            .register-wrapper {
                padding: 40px 20px 20px;
            }

            .register-container {
                padding: 40px 32px;
            }

            .logo-link:hover {
                background: #f8f9fa;
            }

            .level-label:hover {
                border-color: #667eea;
                transform: translateY(-2px);
            }

            .btn-primary:hover {
                transform: translateY(-2px);
                box-shadow: 0 12px 30px rgba(102, 126, 234, 0.5);
            }

            .login-link a:hover {
                color: #764ba2;
            }
        }

        @media (max-width: 360px) {
            .register-container {
                padding: 28px 20px;
            }

            .logo h1 {
                font-size: 22px;
            }

            .form-control {
                font-size: 15px;
                padding: 12px 14px;
            }

            .level-options {
                grid-template-columns: 1fr;
            }

            .btn {
                padding: 14px;
                font-size: 15px;
            }
        }

        @supports (padding: env(safe-area-inset-top)) {
            body {
                padding-top: env(safe-area-inset-top);
                padding-bottom: env(safe-area-inset-bottom);
            }
        }
    </style>
</head>
<body>
    <div class="register-wrapper">
        <div class="register-container">
            <!-- Logo clickable để quay về trang chủ -->
            <a href="{{ route('client.home') }}" class="logo-link" aria-label="Quay về trang chủ">
                <div class="logo">
                    <div class="logo-icon">🎓</div>
                    <h1>English Learning</h1>
                    <p>Tạo tài khoản mới</p>
                </div>
            </a>

            <form action="{{ route('register') }}" method="POST" id="registerForm">
                @csrf
                
                <div class="form-group">
                    <label for="name">Họ và tên</label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        class="form-control @error('name') error @enderror" 
                        placeholder="Nguyễn Văn A"
                        value="{{ old('name') }}"
                        autocomplete="name"
                        required
                    >
                    @error('name')
                        <span class="error-message">
                            <span>⚠️</span>
                            <span>{{ $message }}</span>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
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
                            placeholder="Ít nhất 6 ký tự"
                            autocomplete="new-password"
                            required
                        >
                        <button type="button" class="password-toggle" onclick="togglePassword('password')" aria-label="Hiện/ẩn mật khẩu">
                            <span id="toggleIcon1">👁️</span>
                        </button>
                    </div>
                    @error('password')
                        <span class="error-message">
                            <span>⚠️</span>
                            <span>{{ $message }}</span>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Xác nhận mật khẩu</label>
                    <div class="input-wrapper">
                        <input 
                            type="password" 
                            id="password_confirmation" 
                            name="password_confirmation" 
                            class="form-control" 
                            placeholder="Nhập lại mật khẩu"
                            autocomplete="new-password"
                            required
                        >
                        <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation')" aria-label="Hiện/ẩn mật khẩu">
                            <span id="toggleIcon2">👁️</span>
                        </button>
                    </div>
                </div>

                <div class="form-group">
                    <span class="level-label-text">Trình độ tiếng Anh</span>
                    <div class="level-options">
                        <div class="level-option">
                            <input type="radio" id="beginner" name="level" value="beginner" {{ old('level') == 'beginner' ? 'checked' : '' }} required>
                            <label for="beginner" class="level-label">Sơ cấp</label>
                        </div>
                        <div class="level-option">
                            <input type="radio" id="intermediate" name="level" value="intermediate" {{ old('level') == 'intermediate' ? 'checked' : '' }}>
                            <label for="intermediate" class="level-label">Trung cấp</label>
                        </div>
                        <div class="level-option">
                            <input type="radio" id="advanced" name="level" value="advanced" {{ old('level') == 'advanced' ? 'checked' : '' }}>
                            <label for="advanced" class="level-label">Nâng cao</label>
                        </div>
                    </div>
                    @error('level')
                        <span class="error-message">
                            <span>⚠️</span>
                            <span>{{ $message }}</span>
                        </span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary" id="submitBtn">
                    Đăng ký
                </button>
            </form>

            <div class="divider">
                <span>hoặc</span>
            </div>

            <div class="login-link">
                <p>Đã có tài khoản? <a href="{{ route('login') }}">Đăng nhập ngay</a></p>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const iconId = inputId === 'password' ? 'toggleIcon1' : 'toggleIcon2';
            const icon = document.getElementById(iconId);
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.textContent = '🙈';
            } else {
                input.type = 'password';
                icon.textContent = '👁️';
            }
        }

        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const btn = document.getElementById('submitBtn');
            btn.classList.add('loading');
            btn.textContent = 'Đang xử lý...';
        });

        window.addEventListener('load', function() {
            document.getElementById('name').focus();
        });

        document.querySelectorAll('input').forEach(input => {
            input.addEventListener('focus', function() {
                this.style.fontSize = '16px';
            });
        });
    </script>
</body>
</html>
