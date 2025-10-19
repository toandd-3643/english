@extends('client.layouts.app')

@section('title', 'Trang chủ - Học Tiếng Anh Trực Tuyến')

@push('styles')
<style>
    /* Hero Section */
    .hero {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 3rem 1rem;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        opacity: 0.3;
    }

    .hero-content {
        position: relative;
        z-index: 1;
        max-width: 800px;
        margin: 0 auto;
    }
    
    /* Welcome Message */
    .welcome-message {
        display: inline-block;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        padding: 0.75rem 1.5rem;
        border-radius: 25px;
        margin-bottom: 1.5rem;
        border: 1px solid rgba(255, 255, 255, 0.3);
        animation: fadeInDown 0.6s ease;
    }
    
    .welcome-message span {
        font-size: 1.1rem;
        font-weight: 600;
    }
    
    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .hero h1 {
        font-size: clamp(2rem, 6vw, 3rem);
        margin-bottom: 1rem;
        font-weight: bold;
        line-height: 1.2;
        text-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }
    
    .hero p {
        font-size: clamp(1rem, 2.5vw, 1.3rem);
        margin-bottom: 2rem;
        opacity: 0.95;
        line-height: 1.6;
    }

    .hero-buttons {
        display: flex;
        gap: 1rem;
        justify-content: center;
        flex-wrap: wrap;
    }
    
    .btn {
        padding: 0.9rem 2rem;
        border-radius: 25px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: clamp(0.95rem, 2vw, 1.1rem);
        min-height: 48px;
        min-width: 160px;
        flex: 1 1 auto;
        max-width: 250px;
    }
    
    .btn-primary {
        background: white;
        color: #667eea;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }
    
    .btn-primary:hover,
    .btn-primary:active {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.3);
        color: #667eea;
    }
    
    .btn-secondary {
        background: rgba(255,255,255,0.2);
        color: white;
        border: 2px solid white;
        backdrop-filter: blur(10px);
    }

    .btn-secondary:hover,
    .btn-secondary:active {
        background: white;
        color: #667eea;
        transform: translateY(-2px);
    }
    
    /* Stats Section */
    .stats {
        background: white;
        padding: 3rem 1rem;
    }

    .stats-container {
        max-width: 1200px;
        margin: 0 auto;
    }

    .stats-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .stats-header h2 {
        font-size: clamp(1.8rem, 4vw, 2.5rem);
        color: #333;
        margin-bottom: 0.5rem;
        font-weight: bold;
    }

    .stats-header p {
        font-size: clamp(1rem, 2vw, 1.1rem);
        color: #666;
    }
    
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }
    
    .stat-card {
        text-align: center;
        padding: 2rem 1rem;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 15px;
        transition: all 0.3s;
        border: 2px solid transparent;
    }

    .stat-card:hover,
    .stat-card:active {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.15);
        border-color: #667eea;
    }
    
    .stat-number {
        font-size: clamp(2rem, 5vw, 2.5rem);
        color: #667eea;
        font-weight: bold;
        display: block;
        margin-bottom: 0.5rem;
        line-height: 1;
    }

    .stat-label {
        font-size: clamp(0.9rem, 2vw, 1rem);
        color: #666;
        font-weight: 500;
    }

    .stat-icon {
        font-size: clamp(2rem, 5vw, 2.5rem);
        margin-bottom: 0.75rem;
        display: block;
    }

    /* User Progress Section - Chỉ hiển thị khi đăng nhập */
    .user-progress {
        background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        padding: 3rem 1rem;
        border-top: 1px solid #e9ecef;
    }
    
    .progress-container {
        max-width: 1200px;
        margin: 0 auto;
    }
    
    .progress-header {
        text-align: center;
        margin-bottom: 2rem;
    }
    
    .progress-header h2 {
        font-size: clamp(1.8rem, 4vw, 2.5rem);
        color: #333;
        margin-bottom: 0.5rem;
        font-weight: bold;
    }
    
    .progress-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(min(100%, 280px), 1fr));
        gap: 1.5rem;
    }
    
    .progress-card {
        background: white;
        padding: 2rem;
        border-radius: 15px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        transition: all 0.3s;
    }
    
    .progress-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.15);
    }
    
    .progress-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1rem;
    }
    
    .progress-card-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #333;
    }
    
    .progress-card-icon {
        font-size: 1.5rem;
    }
    
    .progress-bar-container {
        background: #f0f0f0;
        height: 10px;
        border-radius: 5px;
        overflow: hidden;
        margin-bottom: 0.5rem;
    }
    
    .progress-bar {
        height: 100%;
        background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
        border-radius: 5px;
        transition: width 0.5s ease;
    }
    
    .progress-text {
        font-size: 0.9rem;
        color: #666;
        text-align: right;
    }

    /* Features Section */
    .features {
        background: #f8f9fa;
        padding: 3rem 1rem;
    }

    .features-container {
        max-width: 1200px;
        margin: 0 auto;
    }

    .features-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .features-header h2 {
        font-size: clamp(1.8rem, 4vw, 2.5rem);
        color: #333;
        margin-bottom: 0.5rem;
        font-weight: bold;
    }

    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(min(100%, 280px), 1fr));
        gap: 1.5rem;
    }

    .feature-card {
        background: white;
        padding: 2rem 1.5rem;
        border-radius: 15px;
        text-align: center;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        transition: all 0.3s;
    }

    .feature-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.15);
    }

    .feature-icon {
        font-size: clamp(2.5rem, 6vw, 3rem);
        margin-bottom: 1rem;
        display: block;
    }

    .feature-title {
        font-size: clamp(1.1rem, 2.5vw, 1.3rem);
        color: #333;
        font-weight: bold;
        margin-bottom: 0.75rem;
    }

    .feature-description {
        font-size: clamp(0.9rem, 2vw, 1rem);
        color: #666;
        line-height: 1.6;
    }

    /* Tablet breakpoint */
    @media (min-width: 600px) {
        .hero {
            padding: 4rem 2rem;
        }

        .stats {
            padding: 4rem 2rem;
        }

        .stats-grid {
            grid-template-columns: repeat(4, 1fr);
            gap: 1.25rem;
        }

        .stat-card {
            padding: 2.5rem 1.5rem;
        }

        .features {
            padding: 4rem 2rem;
        }

        .user-progress {
            padding: 4rem 2rem;
        }

        .features-grid {
            gap: 2rem;
        }

        .hero-buttons {
            gap: 1.5rem;
        }

        .btn {
            flex: 0 1 auto;
            min-width: 180px;
        }
    }

    /* Desktop breakpoint */
    @media (min-width: 992px) {
        .hero {
            padding: 5rem 2rem;
        }

        .stats {
            padding: 5rem 2rem;
        }

        .stats-grid {
            gap: 1.5rem;
        }

        .features {
            padding: 5rem 2rem;
        }
        
        .user-progress {
            padding: 5rem 2rem;
        }
    }

    /* Accessibility */
    @media (prefers-reduced-motion: reduce) {
        * {
            animation-duration: 0.01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: 0.01ms !important;
        }
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="hero">
    <div class="hero-content">
        @auth
            <div class="welcome-message">
                <span>👋 Xin chào, {{ Auth::user()->name }}!</span>
            </div>
        @endauth
        
        <h1>{{ Auth::check() ? 'Tiếp tục hành trình học tập' : 'Học Tiếng Anh Miễn Phí' }}</h1>
        <p>{{ Auth::check() ? 'Hôm nay bạn muốn học gì?' : 'Nâng cao trình độ tiếng Anh của bạn với hàng ngàn bài học, quiz và flashcards' }}</p>
        <div class="hero-buttons">
            <a href="{{ route('client.lessons.index') }}" class="btn btn-primary" aria-label="Bắt đầu học">
                📚 {{ Auth::check() ? 'Tiếp tục học' : 'Bắt đầu học' }}
            </a>
            <a href="{{ route('client.quizzes.select-mode') }}" class="btn btn-secondary" aria-label="Làm bài quiz">
                📝 Làm bài Quiz
            </a>
        </div>
    </div>
</section>


<!-- Stats Section -->
<section class="stats">
    <div class="stats-container">
        <div class="stats-header">
            <h2>Tài Nguyên Học Tập</h2>
            <p>Khám phá hàng nghìn tài liệu học tập miễn phí</p>
        </div>
        <div class="stats-grid">
            <div class="stat-card">
                <span class="stat-icon">📚</span>
                <div class="stat-number">{{ number_format($stats['total_vocabularies']) }}</div>
                <div class="stat-label">Từ vựng</div>
            </div>
            <div class="stat-card">
                <span class="stat-icon">📖</span>
                <div class="stat-number">{{ number_format($stats['total_grammar_lessons']) }}</div>
                <div class="stat-label">Ngữ pháp</div>
            </div>
            <div class="stat-card">
                <span class="stat-icon">📝</span>
                <div class="stat-number">{{ number_format($stats['total_quizzes']) }}</div>
                <div class="stat-label">Bài Quiz</div>
            </div>
            <div class="stat-card">
                <span class="stat-icon">🎴</span>
                <div class="stat-number">{{ number_format($stats['total_flashcards']) }}</div>
                <div class="stat-label">Flashcards</div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="features">
    <div class="features-container">
        <div class="features-header">
            <h2>Tính Năng Nổi Bật</h2>
        </div>
        <div class="features-grid">
            <div class="feature-card">
                <span class="feature-icon">🎯</span>
                <h3 class="feature-title">Học theo cấp độ</h3>
                <p class="feature-description">Bài học được phân loại theo cấp độ từ cơ bản đến nâng cao</p>
            </div>
            <div class="feature-card">
                <span class="feature-icon">⚡</span>
                <h3 class="feature-title">Luyện tập tương tác</h3>
                <p class="feature-description">Quiz và flashcards giúp bạn luyện tập hiệu quả</p>
            </div>
            <div class="feature-card">
                <span class="feature-icon">📊</span>
                <h3 class="feature-title">Theo dõi tiến độ</h3>
                <p class="feature-description">Xem kết quả và theo dõi quá trình học tập của bạn</p>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    console.log('Home page loaded');
    
    // Smooth scroll for internal links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // Animate progress bars on scroll
    const observerOptions = {
        threshold: 0.5,
        rootMargin: '0px 0px -100px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const progressBars = entry.target.querySelectorAll('.progress-bar');
                progressBars.forEach(bar => {
                    const width = bar.style.width;
                    bar.style.width = '0%';
                    setTimeout(() => {
                        bar.style.width = width;
                    }, 100);
                });
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);
    
    const progressSection = document.querySelector('.user-progress');
    if (progressSection) {
        observer.observe(progressSection);
    }
</script>
@endpush
