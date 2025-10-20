@extends('client.layouts.app')

@section('title', 'Import Lesson from Excel')

@push('styles')
<style>
    .import-page {
        background: #f8f9fa;
        min-height: 100vh;
        padding-bottom: 3rem;
    }

    /* Page Header */
    .page-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem 0;
        margin-bottom: 2rem;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .page-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        opacity: 0.3;
    }

    .page-header h1 {
        font-size: clamp(1.5rem, 5vw, 2.2rem);
        margin: 0 0 0.5rem 0;
        position: relative;
        z-index: 1;
    }

    .page-header p {
        font-size: clamp(0.9rem, 2vw, 1.1rem);
        opacity: 0.95;
        margin: 0;
        position: relative;
        z-index: 1;
    }

    /* Container */
    .import-container {
        max-width: 900px;
        margin: 0 auto;
        padding: 0 1rem;
    }

    /* Cards */
    .import-card {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        margin-bottom: 1.5rem;
        transition: all 0.3s;
    }

    .import-card:hover {
        box-shadow: 0 6px 25px rgba(102, 126, 234, 0.15);
    }

    /* Section Title */
    .section-title {
        font-size: clamp(1.2rem, 3vw, 1.5rem);
        font-weight: 700;
        margin-bottom: 1.25rem;
        color: #333;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 3px solid #667eea;
    }

    /* Alert Info */
    .alert-info {
        background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
        border-left: 4px solid #2196f3;
        padding: 1rem 1.25rem;
        border-radius: 10px;
        margin-bottom: 1.5rem;
    }

    .alert-info strong {
        color: #1976d2;
        font-size: 1rem;
    }

    /* Instruction List */
    .instruction-list {
        list-style: none;
        padding: 0;
        margin: 1rem 0;
    }

    .instruction-list li {
        padding: 0.75rem 0;
        padding-left: 2.5rem;
        position: relative;
        font-size: clamp(0.9rem, 2vw, 1rem);
        line-height: 1.6;
    }

    .instruction-list li:before {
        content: "✓";
        position: absolute;
        left: 0;
        color: #43e97b;
        font-weight: bold;
        font-size: 1.4rem;
        line-height: 1;
    }

    /* Download Template Button */
    .btn-download-template {
        background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        color: white;
        border: none;
        padding: 0.9rem 2rem;
        border-radius: 25px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        transition: all 0.3s;
        font-size: clamp(0.9rem, 2vw, 1rem);
        box-shadow: 0 4px 15px rgba(67, 233, 123, 0.3);
        min-height: 48px;
    }

    .btn-download-template:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 25px rgba(67, 233, 123, 0.5);
        color: white;
    }

    /* Upload Area */
    .upload-area {
        border: 3px dashed #667eea;
        border-radius: 15px;
        padding: 2.5rem 1.5rem;
        text-align: center;
        background: linear-gradient(135deg, #f8f9ff 0%, #e8ebff 100%);
        transition: all 0.3s;
        cursor: pointer;
        position: relative;
    }

    .upload-area:hover {
        background: linear-gradient(135deg, #f0f2ff 0%, #e0e4ff 100%);
        border-color: #764ba2;
        transform: scale(1.01);
    }

    .upload-area.dragover {
        background: linear-gradient(135deg, #e8ebff 0%, #d5daff 100%);
        border-color: #764ba2;
        transform: scale(1.02);
        box-shadow: 0 8px 30px rgba(102, 126, 234, 0.3);
    }

    .upload-icon {
        font-size: clamp(3rem, 8vw, 4.5rem);
        margin-bottom: 1rem;
        animation: float 3s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }

    .upload-area h4 {
        font-size: clamp(1.1rem, 2.5vw, 1.3rem);
        color: #333;
        margin-bottom: 0.5rem;
        font-weight: 600;
    }

    .upload-area p {
        color: #666;
        margin: 0.25rem 0;
        font-size: clamp(0.85rem, 2vw, 0.95rem);
    }

    .file-input {
        display: none;
    }

    /* Selected File Display */
    .selected-file {
        background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%);
        padding: 1rem 1.25rem;
        border-radius: 12px;
        margin-top: 1rem;
        display: none;
        border-left: 4px solid #43e97b;
        position: relative;
    }

    .selected-file strong {
        color: #2e7d32;
        font-size: 0.9rem;
        display: block;
        margin-bottom: 0.25rem;
    }

    .selected-file #fileName {
        color: #1b5e20;
        font-size: clamp(0.9rem, 2vw, 1rem);
        word-break: break-all;
    }

    .selected-file .btn-clear {
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        background: #dc3545;
        color: white;
        border: none;
        border-radius: 50%;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s;
    }

    .selected-file .btn-clear:hover {
        background: #c82333;
        transform: translateY(-50%) rotate(90deg);
    }

    /* Import Button */
    .btn-import {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 1.1rem 2.5rem;
        border-radius: 25px;
        font-weight: 600;
        font-size: clamp(1rem, 2.5vw, 1.2rem);
        width: 100%;
        transition: all 0.3s;
        cursor: pointer;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        min-height: 54px;
    }

    .btn-import:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 6px 25px rgba(102, 126, 234, 0.5);
    }

    .btn-import:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    /* Loading Overlay */
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.85);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 9999;
    }

    .loading-content {
        text-align: center;
        color: white;
        padding: 2rem;
    }

    .spinner {
        width: 60px;
        height: 60px;
        border: 5px solid rgba(255,255,255,0.3);
        border-top-color: white;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin: 0 auto 1.5rem;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    .loading-content h4 {
        font-size: clamp(1.2rem, 3vw, 1.5rem);
        margin-bottom: 0.5rem;
    }

    .loading-content p {
        font-size: clamp(0.9rem, 2vw, 1rem);
        opacity: 0.9;
    }

    /* Template Preview */
    .template-preview {
        background: #f8f9fa;
        padding: 1rem;
        border-radius: 10px;
        margin-top: 1rem;
    }

    .template-preview h5 {
        font-size: 0.95rem;
        font-weight: 600;
        color: #666;
        margin-bottom: 0.5rem;
    }

    .template-preview code {
        background: #e9ecef;
        padding: 0.2rem 0.5rem;
        border-radius: 4px;
        font-size: 0.85rem;
        color: #d63384;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .import-card {
            padding: 1.25rem;
        }

        .upload-area {
            padding: 2rem 1rem;
        }

        .selected-file {
            padding-right: 3.5rem;
        }
    }

    @media (min-width: 769px) {
        .import-card {
            padding: 2rem;
        }

        .upload-area {
            padding: 3rem 2rem;
        }
    }
</style>
@endpush

@section('content')
<div class="import-page">
    <!-- Page Header -->
    <div class="page-header">
        <div class="container">
            <h1>📊 Import Lesson from Excel</h1>
            <p>Quickly create comprehensive lessons by uploading Excel files</p>
        </div>
    </div>

    <div class="import-container">
        <!-- Instructions Card -->
        <div class="import-card">
            <h3 class="section-title">
                <span>📋</span>
                <span>How to Import</span>
            </h3>
            
            <div class="alert-info">
                <strong>📥 Important: Download Template First!</strong>
                <p style="margin: 0.5rem 0 0 0; font-size: 0.9rem;">Make sure to download and follow the Excel template format exactly.</p>
            </div>

            <ul class="instruction-list">
                <li>Download the Excel template using the button below</li>
                <li>Fill in <strong>Lesson Info</strong> in Sheet 1 (title, description, level, etc.)</li>
                <li>Add <strong>Vocabulary</strong> words in Sheet 2 (word, meaning, examples)</li>
                <li>Add <strong>Grammar</strong> lessons in Sheet 3 (title, content, structure)</li>
                <li>Add <strong>Quiz</strong> questions in Sheet 4 (optional)</li>
                <li>Save the file and upload it using the form below</li>
            </ul>

            <div class="template-preview">
                <h5>📄 Template Structure:</h5>
                <p style="margin: 0; font-size: 0.85rem; color: #666;">
                    4 sheets: <code>Lesson Info</code>, <code>Vocabulary</code>, <code>Grammar</code>, <code>Quiz</code>
                </p>
            </div>

            <div class="text-center mt-4">
                <a href="{{ route('client.lessons.template.download') }}" class="btn-download-template">
                    <i class="fas fa-download"></i>
                    <span>Download Excel Template</span>
                </a>
            </div>
        </div>

        <!-- Upload Card -->
        <div class="import-card">
            <h3 class="section-title">
                <span>📤</span>
                <span>Upload Excel File</span>
            </h3>

            <form id="importForm" enctype="multipart/form-data">
                @csrf

                <div class="upload-area" id="uploadArea" onclick="document.getElementById('fileInput').click()">
                    <div class="upload-icon">📁</div>
                    <h4>Click to Browse or Drag & Drop</h4>
                    <p>Upload your Excel file here</p>
                    <p class="text-muted small">Supported formats: .xlsx, .xls, .csv (Max: 5MB)</p>
                </div>

                <input type="file" 
                       id="fileInput" 
                       name="excel_file" 
                       class="file-input" 
                       accept=".xlsx,.xls,.csv"
                       required>

                <div class="selected-file" id="selectedFile">
                    <strong>📎 Selected File:</strong>
                    <span id="fileName"></span>
                    <button type="button" class="btn-clear" onclick="clearFile()" title="Remove file">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <button type="submit" class="btn-import mt-4" id="importBtn">
                    <i class="fas fa-cloud-upload-alt"></i>
                    <span>Import Lesson Now</span>
                </button>
            </form>
        </div>

        <!-- Help Text -->
        <div class="text-center text-muted" style="font-size: 0.9rem;">
            <p>Need help? Make sure your Excel file follows the template format exactly.</p>
            <p>Flashcards will be automatically generated from vocabulary and grammar.</p>
        </div>
    </div>
</div>

<!-- Loading Overlay -->
<div class="loading-overlay" id="loadingOverlay">
    <div class="loading-content">
        <div class="spinner"></div>
        <h4>Importing your lesson...</h4>
        <p>Please wait while we process your Excel file</p>
    </div>
</div>

<script>
// File selection handling
const fileInput = document.getElementById('fileInput');
const uploadArea = document.getElementById('uploadArea');
const selectedFile = document.getElementById('selectedFile');
const fileName = document.getElementById('fileName');

fileInput.addEventListener('change', function() {
    if (this.files.length > 0) {
        const file = this.files[0];
        fileName.textContent = file.name;
        selectedFile.style.display = 'block';
    }
});

// Drag & Drop functionality
uploadArea.addEventListener('dragover', function(e) {
    e.preventDefault();
    e.stopPropagation();
    this.classList.add('dragover');
});

uploadArea.addEventListener('dragleave', function(e) {
    e.preventDefault();
    e.stopPropagation();
    this.classList.remove('dragover');
});

uploadArea.addEventListener('drop', function(e) {
    e.preventDefault();
    e.stopPropagation();
    this.classList.remove('dragover');
    
    const files = e.dataTransfer.files;
    if (files.length > 0) {
        // Check file type
        const file = files[0];
        const validTypes = ['.xlsx', '.xls', '.csv'];
        const fileExt = '.' + file.name.split('.').pop().toLowerCase();
        
        if (validTypes.includes(fileExt)) {
            fileInput.files = files;
            fileName.textContent = file.name;
            selectedFile.style.display = 'block';
        } else {
            alert('⚠️ Please upload a valid Excel file (.xlsx, .xls, or .csv)');
        }
    }
});

// Clear file selection
function clearFile() {
    fileInput.value = '';
    selectedFile.style.display = 'none';
    fileName.textContent = '';
}

// Form submission
document.getElementById('importForm').addEventListener('submit', function(e) {
    e.preventDefault();

    if (!fileInput.files.length) {
        alert('⚠️ Please select a file to upload!');
        return;
    }

    const formData = new FormData(this);
    const importBtn = document.getElementById('importBtn');
    const loadingOverlay = document.getElementById('loadingOverlay');

    // Disable button and show loading
    importBtn.disabled = true;
    importBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Importing...';
    loadingOverlay.style.display = 'flex';

    fetch('{{ route("client.lessons.import") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        loadingOverlay.style.display = 'none';

        if (data.success) {
            // Success message
            const successMsg = document.createElement('div');
            successMsg.style.cssText = `
                position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%);
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white; padding: 2rem 3rem; border-radius: 15px;
                box-shadow: 0 10px 30px rgba(0,0,0,0.3); z-index: 10000;
                text-align: center; animation: bounceIn 0.5s;
            `;
            successMsg.innerHTML = `
                <i class="fas fa-check-circle" style="font-size: 3.5rem; margin-bottom: 1rem;"></i>
                <h3 style="margin: 0 0 0.5rem 0; font-size: 1.5rem;">Success!</h3>
                <p style="margin: 0; font-size: 1rem;">${data.message}</p>
            `;
            document.body.appendChild(successMsg);

            // Add animation
            const style = document.createElement('style');
            style.textContent = `
                @keyframes bounceIn {
                    0% { transform: translate(-50%, -50%) scale(0.3); opacity: 0; }
                    50% { transform: translate(-50%, -50%) scale(1.05); }
                    70% { transform: translate(-50%, -50%) scale(0.9); }
                    100% { transform: translate(-50%, -50%) scale(1); opacity: 1; }
                }
            `;
            document.head.appendChild(style);

            // Redirect after 1.5 seconds
            setTimeout(() => {
                window.location.href = '{{ route("client.lessons.index") }}';
            }, 1500);
        } else {
            alert('❌ ' + (data.message || 'An error occurred while importing!'));
            importBtn.disabled = false;
            importBtn.innerHTML = '<i class="fas fa-cloud-upload-alt"></i> <span>Import Lesson Now</span>';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        loadingOverlay.style.display = 'none';
        alert('❌ An error occurred while importing the file!');
        importBtn.disabled = false;
        importBtn.innerHTML = '<i class="fas fa-cloud-upload-alt"></i> <span>Import Lesson Now</span>';
    });
});
</script>
@endsection
