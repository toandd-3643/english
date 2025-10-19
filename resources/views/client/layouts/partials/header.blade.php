<header class="header">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 9999;
        }
        
        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 1rem 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
        }
        
        .logo {
            font-size: 1.5rem;
            font-weight: bold;
            text-decoration: none;
            color: white;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            flex-shrink: 0;
        }
        
        .nav-menu {
            display: flex;
            list-style: none;
            gap: 1.5rem;
            align-items: center;
        }
        
        .nav-menu a {
            color: white;
            text-decoration: none;
            transition: opacity 0.3s;
            font-weight: 500;
            font-size: 0.95rem;
            white-space: nowrap;
        }
        
        .nav-menu a:hover,
        .nav-menu a.active {
            opacity: 0.8;
            text-decoration: underline;
        }
        
        /* User Menu Styles */
        .user-menu {
            position: relative;
            display: flex;
            align-items: center;
            gap: 1rem;
            flex-shrink: 0;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            cursor: pointer;
            padding: 0.5rem 1rem;
            border-radius: 25px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            transition: all 0.3s;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .user-info:hover {
            background: rgba(255, 255, 255, 0.25);
        }
        
        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: #667eea;
            font-size: 1rem;
            flex-shrink: 0;
        }
        
        .user-details {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }
        
        .user-name {
            font-weight: 600;
            font-size: 0.9rem;
            line-height: 1.2;
        }
        
        .user-level {
            font-size: 0.75rem;
            opacity: 0.9;
            line-height: 1.2;
        }
        
        .dropdown-arrow {
            font-size: 0.8rem;
            transition: transform 0.3s;
        }
        
        .user-info.active .dropdown-arrow {
            transform: rotate(180deg);
        }
        
        /* Dropdown Menu */
        .user-dropdown {
            position: absolute;
            top: 100%;
            right: 0;
            margin-top: 0.75rem;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.25);
            min-width: 260px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
            z-index: 10001;
            overflow: hidden;
        }
        
        .user-dropdown.active {
            opacity: 1 !important;
            visibility: visible !important;
            transform: translateY(0) !important;
            display: block !important;
        }
        
        .dropdown-header {
            padding: 1.25rem 1.25rem;
            background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
            border-bottom: 2px solid #e9ecef;
        }
        
        .dropdown-header-name {
            font-weight: 700;
            color: #333;
            font-size: 1rem;
            margin-bottom: 0.4rem;
        }
        
        .dropdown-header-email {
            font-size: 0.85rem;
            color: #666;
            word-break: break-all;
        }
        
        .user-menu-list {
            list-style: none !important;
            padding: 0.75rem 0 !important;
            margin: 0 !important;
            display: block !important;
        }
        
        .user-menu-list li {
            width: 100%;
            display: block !important;
        }
        
        .user-menu-list li a,
        .user-menu-list li form {
            width: 100%;
            display: block !important;
        }
        
        .user-menu-list li a,
        .user-menu-list li button {
            display: flex !important;
            align-items: center;
            gap: 0.75rem;
            padding: 0.9rem 1.25rem;
            color: #333;
            text-decoration: none;
            transition: all 0.2s;
            font-size: 0.95rem;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
            cursor: pointer;
            font-family: inherit;
            font-weight: 500;
        }
        
        .user-menu-list li a span,
        .user-menu-list li button span {
            font-size: 1.2rem;
        }
        
        .user-menu-list li a:hover,
        .user-menu-list li button:hover {
            background: linear-gradient(90deg, #f8f9fa 0%, #e9ecef 100%);
            color: #667eea;
        }
        
        .user-menu-list li.logout {
            border-top: 2px solid #e9ecef;
            padding-top: 0.5rem;
            margin-top: 0.5rem;
        }
        
        .user-menu-list li.logout a,
        .user-menu-list li.logout button {
            color: #dc3545;
            font-weight: 600;
        }
        
        .user-menu-list li.logout a:hover,
        .user-menu-list li.logout button:hover {
            background: linear-gradient(90deg, #fff5f5 0%, #ffe5e5 100%);
            color: #c82333;
        }
        
        /* Auth Buttons */
        .auth-buttons {
            display: flex;
            gap: 0.75rem;
            align-items: center;
        }
        
        .auth-btn {
            padding: 0.5rem 1.25rem;
            border-radius: 20px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            font-size: 0.9rem;
            white-space: nowrap;
            display: inline-block;
        }
        
        .btn-login {
            color: white;
            border: 2px solid white;
            background: transparent;
        }
        
        .btn-login:hover {
            background: white;
            color: #667eea;
        }
        
        .btn-register {
            background: white;
            color: #667eea;
            border: 2px solid white;
        }
        
        .btn-register:hover {
            background: rgba(255, 255, 255, 0.9);
            transform: translateY(-1px);
        }
        
        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            padding: 0.5rem;
            flex-shrink: 0;
        }
        
        /* Overlay */
        .dropdown-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.3);
            z-index: 9998;
            backdrop-filter: blur(2px);
        }
        
        .dropdown-overlay.active {
            display: block;
        }
        
        /* Mobile Styles */
        @media (max-width: 992px) {
            .nav-menu {
                gap: 1rem;
            }
            
            .nav-menu a {
                font-size: 0.9rem;
            }
            
            .logo {
                font-size: 1.3rem;
            }
            
            .user-details {
                display: none;
            }
            
            .user-avatar {
                width: 32px;
                height: 32px;
                font-size: 0.9rem;
            }
            
            .auth-btn {
                padding: 0.4rem 1rem;
                font-size: 0.85rem;
            }
        }
        
        @media (max-width: 768px) {
            .nav-container {
                padding: 0.75rem 15px;
                flex-wrap: wrap;
            }
            
            .logo {
                font-size: 1.2rem;
            }
            
            .nav-menu {
                display: none;
                flex-direction: column;
                position: fixed;
                top: 60px;
                left: 0;
                right: 0;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                padding: 1rem;
                gap: 0;
                box-shadow: 0 4px 10px rgba(0,0,0,0.2);
                max-height: calc(100vh - 60px);
                overflow-y: auto;
                z-index: 9997;
            }
            
            .nav-menu.active {
                display: flex;
            }
            
            .nav-menu li {
                width: 100%;
                border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            }
            
            .nav-menu li:last-child {
                border-bottom: none;
            }
            
            .nav-menu a {
                display: block;
                padding: 1rem;
                font-size: 1rem;
            }
            
            .mobile-menu-btn {
                display: block;
                order: 2;
            }
            
            .user-menu {
                order: 1;
            }
            
            .user-info {
                padding: 0.4rem 0.75rem;
                gap: 0.5rem;
            }
            
            .user-dropdown {
                position: fixed;
                top: 70px;
                right: 15px;
                left: 15px;
                width: auto;
                min-width: unset;
            }
            
            .auth-buttons {
                gap: 0.5rem;
            }
            
            .auth-btn {
                padding: 0.4rem 0.9rem;
                font-size: 0.8rem;
            }
            
            /* Ẩn button đăng ký trên mobile, chỉ giữ button đăng nhập */
            .btn-register {
                display: none;
            }
        }
        
        @media (max-width: 480px) {
            .nav-container {
                padding: 0.6rem 10px;
            }
            
            .logo {
                font-size: 1.1rem;
                gap: 0.3rem;
            }
            
            .user-avatar {
                width: 28px;
                height: 28px;
                font-size: 0.8rem;
            }
            
            .auth-btn {
                padding: 0.35rem 0.75rem;
                font-size: 0.75rem;
            }
        }
    </style>
    
    <div class="nav-container">
        <a href="{{ route('client.home') }}" class="logo">
            🎓 English Learning
        </a>
        
        <nav>
            <ul class="nav-menu" id="navMenu">
                <li><a href="{{ route('client.home') }}" class="{{ Request::routeIs('client.home') ? 'active' : '' }}">Trang chủ</a></li>
                <li><a href="{{ route('client.lessons.index') }}" class="{{ Request::routeIs('client.lessons.*') ? 'active' : '' }}">Bài học</a></li>
                <li><a href="{{ route('client.vocabulary.index') }}" class="{{ Request::routeIs('client.vocabulary.*') ? 'active' : '' }}">Từ vựng</a></li>
                <li><a href="{{ route('client.grammar.index') }}" class="{{ Request::routeIs('client.grammar.*') ? 'active' : '' }}">Ngữ pháp</a></li>
                <li><a href="{{ route('client.flashcards.index') }}" class="{{ Request::routeIs('client.flashcards.*') ? 'active' : '' }}">Flashcards</a></li>
                <li><a href="{{ route('client.quizzes.select-mode') }}" class="{{ Request::routeIs('client.quizzes.*') ? 'active' : '' }}">Quiz</a></li>
                <li><a href="{{ route('client.translation.index') }}" class="{{ Request::routeIs('client.translate.*') ? 'active' : '' }}">Dịch</a></li>
            </ul>
        </nav>
        
        <div class="user-menu">
            @auth
                <div class="user-info" id="userInfoBtn">
                    <div class="user-avatar">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="user-details">
                        <div class="user-name">{{ Str::limit(Auth::user()->name, 15) }}</div>
                        <div class="user-level">
                            @php
                                $levels = [
                                    'beginner' => 'Sơ cấp',
                                    'intermediate' => 'Trung cấp',
                                    'advanced' => 'Nâng cao'
                                ];
                            @endphp
                            {{ $levels[Auth::user()->level] ?? 'Sơ cấp' }}
                        </div>
                    </div>
                    <span class="dropdown-arrow">▼</span>
                </div>
                
                <div class="user-dropdown" id="userDropdown">
                    <div class="dropdown-header">
                        <div class="dropdown-header-name">{{ Auth::user()->name }}</div>
                        <div class="dropdown-header-email">{{ Auth::user()->email }}</div>
                    </div>
                    <ul class="user-menu-list">
                        <li>
                            <a href="{{ route('client.profile') }}">
                                <span>👤</span>
                                <span>Trang cá nhân</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('client.lessons.create') }}">
                                <span>👨‍🏫</span>
                                <span>Thêm Lesson</span>
                            </a>
                        </li>
                        <li class="logout">
                            <form action="{{ route('logout') }}" method="POST" id="logoutForm" style="margin: 0;">
                                @csrf
                                <button type="submit">
                                    <span>🚪</span>
                                    <span>Đăng xuất</span>
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            @else
                <div class="auth-buttons">
                    <a href="{{ route('login') }}" class="auth-btn btn-login">Đăng nhập</a>
                    <a href="{{ route('register') }}" class="auth-btn btn-register">Đăng ký</a>
                </div>
            @endauth
        </div>
        
        <button class="mobile-menu-btn" id="mobileMenuBtn" aria-label="Toggle menu">
            ☰
        </button>
    </div>
    
    <div class="dropdown-overlay" id="dropdownOverlay"></div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuBtn = document.getElementById('mobileMenuBtn');
            const navMenu = document.getElementById('navMenu');
            const userInfoBtn = document.getElementById('userInfoBtn');
            const userDropdown = document.getElementById('userDropdown');
            const dropdownOverlay = document.getElementById('dropdownOverlay');
            
            if (mobileMenuBtn) {
                mobileMenuBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    navMenu.classList.toggle('active');
                    closeUserDropdown();
                });
            }
            
            if (userInfoBtn) {
                userInfoBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    const isActive = userDropdown.classList.contains('active');
                    
                    if (isActive) {
                        closeUserDropdown();
                    } else {
                        openUserDropdown();
                    }
                    
                    if (navMenu && navMenu.classList.contains('active')) {
                        navMenu.classList.remove('active');
                    }
                });
            }
            
            function openUserDropdown() {
                if (userDropdown) userDropdown.classList.add('active');
                if (dropdownOverlay) dropdownOverlay.classList.add('active');
                if (userInfoBtn) userInfoBtn.classList.add('active');
            }
            
            function closeUserDropdown() {
                if (userDropdown) userDropdown.classList.remove('active');
                if (dropdownOverlay) dropdownOverlay.classList.remove('active');
                if (userInfoBtn) userInfoBtn.classList.remove('active');
            }
            
            if (dropdownOverlay) {
                dropdownOverlay.addEventListener('click', function(e) {
                    e.stopPropagation();
                    closeUserDropdown();
                });
            }
            
            document.addEventListener('click', function(event) {
                const userMenu = document.querySelector('.user-menu');
                if (userMenu && !userMenu.contains(event.target)) {
                    closeUserDropdown();
                }
            });
            
            if (userDropdown) {
                userDropdown.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
            }
            
            const menuLinks = document.querySelectorAll('.nav-menu a');
            menuLinks.forEach(function(link) {
                link.addEventListener('click', function() {
                    if (navMenu && navMenu.classList.contains('active')) {
                        navMenu.classList.remove('active');
                    }
                });
            });
            
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeUserDropdown();
                    if (navMenu && navMenu.classList.contains('active')) {
                        navMenu.classList.remove('active');
                    }
                }
            });
        });
    </script>
</header>
