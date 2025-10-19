@extends('client.layouts.app')

@section('title', 'Chỉnh sửa hồ sơ - English Learning')

@push('styles')
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        -webkit-tap-highlight-color: transparent;
    }

    body {
        background: #f5f7fa;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
    }

    .edit-profile-wrapper {
        min-height: 100vh;
        padding: 20px;
        padding-bottom: 80px;
    }

    .edit-profile-container {
        max-width: 600px;
        margin: 0 auto;
    }

    /* Page Header */
    .page-header {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 24px;
    }

    .back-btn {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        font-size: 20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        transition: all 0.3s;
        flex-shrink: 0;
    }

    .back-btn:active {
        transform: scale(0.95);
        background: #f8f9fa;
    }

    .page-title {
        font-size: 24px;
        font-weight: 700;
        color: #333;
    }

    /* Form Card */
    .form-card {
        background: white;
        border-radius: 20px;
        padding: 24px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        margin-bottom: 20px;
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

    .alert-error {
        background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
        color: #721c24;
        border-left: 4px solid #dc3545;
    }

    /* Avatar Upload */
    .avatar-section {
        text-align: center;
        margin-bottom: 32px;
        padding-bottom: 32px;
        border-bottom: 2px solid #f0f0f0;
    }

    .avatar-preview {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 42px;
        font-weight: 700;
        color: white;
        margin: 0 auto 16px;
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
    }

    .avatar-upload-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        background: #f8f9fa;
        color: #667eea;
        border: 2px solid #e0e0e0;
        border-radius: 20px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s;
    }

    .avatar-upload-btn:active {
        transform: scale(0.95);
        background: #e9ecef;
    }

    /* Form Fields */
    .form-group {
        margin-bottom: 24px;
    }

    .form-label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: #333;
        margin-bottom: 8px;
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
    }

    /* Level Radio Buttons */
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
    }

    .level-label {
        display: block;
        padding: 14px 12px;
        border: 2px solid #e0e0e0;
        border-radius: 12px;
        text-align: center;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background: #f8f9fa;
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

    /* Submit Button */
    .submit-btn {
        width: 100%;
        padding: 16px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 12px;
        font-size: 16px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        text-transform: uppercase;
        letter-spacing: 1px;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        position: relative;
        overflow: hidden;
    }

    .submit-btn::before {
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

    .submit-btn:active::before {
        width: 300px;
        height: 300px;
    }

    .submit-btn:active {
        transform: translateY(2px);
        box-shadow: 0 2px 6px rgba(102, 126, 234, 0.3);
    }

    .submit-btn.loading {
        pointer-events: none;
        opacity: 0.8;
    }

    .submit-btn.loading::after {
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

    /* Desktop */
    @media (min-width: 481px) {
        .edit-profile-wrapper {
            padding: 40px 20px;
        }

        .back-btn:hover {
            background: #f8f9fa;
        }

        .avatar-upload-btn:hover {
            background: #e9ecef;
        }

        .level-label:hover {
            border-color: #667eea;
            transform: translateY(-2px);
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
        }

        .level-options {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 360px) {
        .level-options {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
<div class="edit-profile-wrapper">
    <div class="edit-profile-container">
        <!-- Header -->
        <div class="page-header">
            <a href="{{ route('client.profile') }}" class="back-btn">←</a>
            <h1 class="page-title">Chỉnh sửa hồ sơ</h1>
        </div>

        @if($errors->any())
            <div class="alert alert-error">
                <span>⚠️</span>
                <span>Vui lòng kiểm tra lại thông tin</span>
            </div>
        @endif

        <!-- Form -->
        <form action="{{ route('client.profile.update') }}" method="POST" id="editForm" class="form-card">
            @csrf
            @method('PUT')

            <!-- Avatar Section -->
            <div class="avatar-section">
                <div class="avatar-preview">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <button type="button" class="avatar-upload-btn">
                    <span>📷</span>
                    <span>Thay đổi ảnh đại diện</span>
                </button>
            </div>

            <!-- Name -->
            <div class="form-group">
                <label for="name" class="form-label">Họ và tên</label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    class="form-control @error('name') error @enderror"
                    value="{{ old('name', Auth::user()->name) }}"
                    required
                    autocomplete="name"
                >
                @error('name')
                    <span class="error-message">
                        <span>⚠️</span>
                        <span>{{ $message }}</span>
                    </span>
                @enderror
            </div>

            <!-- Email -->
            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    class="form-control"
                    value="{{ Auth::user()->email}}"
                    required
                    autocomplete="email"
                    inputmode="email"
                    disabled
                >
            </div>

            <!-- Level -->
            <div class="form-group">
                <label class="form-label">Trình độ tiếng Anh</label>
                <div class="level-options">
                    <div class="level-option">
                        <input type="radio" id="beginner" name="level" value="beginner" 
                            {{ old('level', Auth::user()->level) == 'beginner' ? 'checked' : '' }}>
                        <label for="beginner" class="level-label">Sơ cấp</label>
                    </div>
                    <div class="level-option">
                        <input type="radio" id="intermediate" name="level" value="intermediate"
                            {{ old('level', Auth::user()->level) == 'intermediate' ? 'checked' : '' }}>
                        <label for="intermediate" class="level-label">Trung cấp</label>
                    </div>
                    <div class="level-option">
                        <input type="radio" id="advanced" name="level" value="advanced"
                            {{ old('level', Auth::user()->level) == 'advanced' ? 'checked' : '' }}>
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

            <!-- Submit -->
            <button type="submit" class="submit-btn" id="submitBtn">
                Lưu thay đổi
            </button>
        </form>
    </div>
</div>

<script>
    document.getElementById('editForm').addEventListener('submit', function() {
        const btn = document.getElementById('submitBtn');
        btn.classList.add('loading');
        btn.textContent = 'Đang lưu...';
    });
</script>
@endsection
