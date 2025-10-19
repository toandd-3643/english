@extends('client.layouts.app')

@section('title', 'Trang cá nhân - English Learning')

@push('styles')
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        background: #f5f7fa;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
    }

    /* Profile Container */
    .profile-wrapper {
        min-height: 100vh;
        padding: 20px;
        padding-bottom: 80px;
    }

    .profile-container {
        max-width: 600px;
        margin: 0 auto;
    }

    /* Profile Header Card */
    .profile-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 24px;
        padding: 32px 24px;
        margin-bottom: 20px;
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
        position: relative;
        overflow: hidden;
    }

    .profile-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: float 10s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translate(0, 0) rotate(0deg); }
        50% { transform: translate(-20px, -20px) rotate(5deg); }
    }

    .profile-header-content {
        position: relative;
        z-index: 1;
        text-align: center;
    }

    .profile-avatar-wrapper {
        position: relative;
        display: inline-block;
        margin-bottom: 20px;
    }

    .profile-avatar {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 42px;
        font-weight: 700;
        color: #667eea;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        border: 4px solid rgba(255, 255, 255, 0.3);
        margin: 0 auto;
    }

    .profile-avatar-edit {
        position: absolute;
        bottom: 0;
        right: 0;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        cursor: pointer;
        transition: all 0.3s;
        border: 3px solid #667eea;
    }

    .profile-avatar-edit:active {
        transform: scale(0.9);
    }

    .profile-name {
        color: white;
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 8px;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .profile-email {
        color: rgba(255, 255, 255, 0.9);
        font-size: 14px;
        margin-bottom: 16px;
        opacity: 0.95;
    }

    .profile-level-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        padding: 8px 20px;
        border-radius: 20px;
        color: white;
        font-size: 14px;
        font-weight: 600;
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    /* Info Cards */
    .info-section {
        margin-bottom: 20px;
    }

    .section-title {
        font-size: 18px;
        font-weight: 700;
        color: #333;
        margin-bottom: 12px;
        padding-left: 4px;
    }

    .info-card {
        background: white;
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        margin-bottom: 12px;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 14px 0;
        border-bottom: 1px solid #f0f0f0;
    }

    .info-row:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .info-row:first-child {
        padding-top: 0;
    }

    .info-label {
        font-size: 14px;
        color: #666;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .info-label-icon {
        font-size: 18px;
    }

    .info-value {
        font-size: 15px;
        color: #333;
        font-weight: 600;
        text-align: right;
    }

    /* Action Buttons */
    .action-buttons {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        margin-bottom: 20px;
    }

    .action-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 16px;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        touch-action: manipulation;
        border: none;
        cursor: pointer;
        font-family: inherit;
    }

    .action-btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }

    .action-btn-primary:active {
        transform: translateY(2px);
        box-shadow: 0 2px 6px rgba(102, 126, 234, 0.3);
    }

    .action-btn-secondary {
        background: white;
        color: #667eea;
        border: 2px solid #667eea;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .action-btn-secondary:active {
        transform: translateY(2px);
        background: #f8f9fa;
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
        margin-bottom: 20px;
    }

    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 20px;
        text-align: center;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        transition: all 0.3s;
    }

    .stat-card:active {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.15);
    }

    .stat-icon {
        font-size: 32px;
        margin-bottom: 8px;
    }

    .stat-value {
        font-size: 24px;
        font-weight: 700;
        color: #667eea;
        margin-bottom: 4px;
    }

    .stat-label {
        font-size: 13px;
        color: #666;
        font-weight: 500;
    }

    /* Logout Button */
    .logout-section {
        margin-top: 20px;
    }

    .logout-btn {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 16px;
        background: white;
        color: #dc3545;
        border: 2px solid #dc3545;
        border-radius: 12px;
        font-weight: 600;
        font-size: 15px;
        cursor: pointer;
        transition: all 0.3s;
        touch-action: manipulation;
    }

    .logout-btn:active {
        transform: translateY(2px);
        background: #fff5f5;
    }

    /* Desktop Styles */
    @media (min-width: 481px) {
        .profile-wrapper {
            padding: 40px 20px;
        }

        .profile-avatar {
            width: 120px;
            height: 120px;
            font-size: 48px;
        }

        .action-btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
        }

        .action-btn-secondary:hover {
            background: #f8f9fa;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.15);
        }

        .logout-btn:hover {
            background: #fff5f5;
        }

        .stats-grid {
            grid-template-columns: repeat(4, 1fr);
        }
    }

    /* Tablet */
    @media (min-width: 768px) {
        .profile-container {
            max-width: 700px;
        }

        .action-buttons {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    /* Alert */
    .alert {
        padding: 14px 16px;
        border-radius: 12px;
        margin-bottom: 20px;
        font-size: 14px;
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
</style>
@endpush

@section('content')
<div class="profile-wrapper">
    <div class="profile-container">
        @if(session('success'))
            <div class="alert alert-success">
                <span>✅</span>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Profile Header -->
        <div class="profile-header">
            <div class="profile-header-content">
                <div class="profile-avatar-wrapper">
                    <div class="profile-avatar">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <a href="{{ route('client.profile.edit') }}" class="profile-avatar-edit">
                        ✏️
                    </a>
                </div>
                <h1 class="profile-name">{{ Auth::user()->name }}</h1>
                <p class="profile-email">{{ Auth::user()->email }}</p>
                <div class="profile-level-badge">
                    <span>🎯</span>
                    <span>
                        @php
                            $levels = [
                                'beginner' => 'Sơ cấp',
                                'intermediate' => 'Trung cấp',
                                'advanced' => 'Nâng cao'
                            ];
                        @endphp
                        {{ $levels[Auth::user()->level] ?? 'Sơ cấp' }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">📚</div>
                <div class="stat-value">{{ $stats['learned_vocabularies'] ?? 0 }}</div>
                <div class="stat-label">Từ đã học</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">📝</div>
                <div class="stat-value">{{ $stats['completed_quizzes'] ?? 0 }}</div>
                <div class="stat-label">Quiz hoàn thành</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">⭐</div>
                <div class="stat-value">{{ number_format($stats['average_score'] ?? 0, 0) }}</div>
                <div class="stat-label">Điểm TB</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">🔥</div>
                <div class="stat-value">{{ $stats['streak_days'] ?? 0 }}</div>
                <div class="stat-label">Ngày liên tiếp</div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <a href="{{ route('client.profile.edit') }}" class="action-btn action-btn-primary">
                <span>✏️</span>
                <span>Chỉnh sửa</span>
            </a>
        </div>

        <!-- Account Info -->
        <div class="info-section">
            <h2 class="section-title">Thông tin tài khoản</h2>
            <div class="info-card">
                <div class="info-row">
                    <div class="info-label">
                        <span class="info-label-icon">👤</span>
                        <span>Họ và tên</span>
                    </div>
                    <div class="info-value">{{ Auth::user()->name }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">
                        <span class="info-label-icon">📧</span>
                        <span>Email</span>
                    </div>
                    <div class="info-value">{{ Auth::user()->email }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">
                        <span class="info-label-icon">🎯</span>
                        <span>Trình độ</span>
                    </div>
                    <div class="info-value">
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
                <div class="info-row">
                    <div class="info-label">
                        <span class="info-label-icon">📅</span>
                        <span>Tham gia</span>
                    </div>
                    <div class="info-value">{{ Auth::user()->created_at->format('d/m/Y') }}</div>
                </div>
            </div>
        </div>

        <!-- Logout -->
        <div class="logout-section">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn" onclick="return confirm('Bạn có chắc muốn đăng xuất?')">
                    <span>🚪</span>
                    <span>Đăng xuất</span>
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
