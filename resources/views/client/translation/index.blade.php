@extends('client.layouts.app')

@section('title', 'Translation')

@push('styles')
<style>
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body {
        -webkit-font-smoothing: antialiased;
    }

    .translation-page {
        background: #f8f9fa;
        min-height: 100vh;
    }

    /* Header */
    .translation-header {
        background: white;
        padding: 1rem;
        border-bottom: 1px solid #e0e0e0;
        position: sticky;
        top: 0;
        z-index: 100;
        text-align: center;
    }

    .header-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: #202124;
        margin: 0;
    }

    /* Main Content */
    .translation-content {
        background: white;
    }

    /* Language Selector Bar */
    .language-bar {
        display: flex;
        align-items: center;
        padding: 1rem;
        border-bottom: 1px solid #e0e0e0;
        background: white;
    }

    .lang-button {
        flex: 1;
        background: none;
        border: none;
        color: #1a73e8;
        font-size: 1rem;
        font-weight: 600;
        padding: 0.5rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.3rem;
        touch-action: manipulation;
        -webkit-tap-highlight-color: transparent;
    }

    .lang-button:active {
        background: #f1f3f4;
        border-radius: 8px;
    }

    .swap-icon {
        font-size: 1.3rem;
        color: #5f6368;
        padding: 0.5rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        touch-action: manipulation;
        -webkit-tap-highlight-color: transparent;
    }

    .swap-icon:active {
        background: #f1f3f4;
        border-radius: 50%;
    }

    /* Input Area */
    .input-area {
        padding: 1rem;
        border-bottom: 8px solid #f8f9fa;
    }

    .input-wrapper {
        position: relative;
    }

    .text-input {
        width: 100%;
        min-height: 120px;
        max-height: 300px;
        border: none;
        background: transparent;
        font-size: 16px;
        line-height: 1.6;
        color: #202124;
        resize: vertical;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    .text-input:focus {
        outline: none;
    }

    .text-input::placeholder {
        color: #9aa0a6;
    }

    .input-actions {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 0.5rem;
    }

    .char-counter {
        font-size: 0.8rem;
        color: #9aa0a6;
    }

    .clear-btn {
        background: none;
        border: none;
        color: #5f6368;
        font-size: 1.3rem;
        padding: 0.5rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        touch-action: manipulation;
        -webkit-tap-highlight-color: transparent;
    }

    .clear-btn:active {
        background: #f1f3f4;
        border-radius: 50%;
    }

    /* Loading State */
    .loading-indicator {
        display: none;
        text-align: center;
        color: #5f6368;
        padding: 1rem;
        font-size: 0.9rem;
    }

    .loading-indicator.active {
        display: block;
    }

    .spinner {
        border: 2px solid #f3f3f3;
        border-top: 2px solid #1a73e8;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        animation: spin 1s linear infinite;
        display: inline-block;
        margin-right: 0.5rem;
        vertical-align: middle;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Output Area */
    .output-area {
        padding: 1rem;
        background: #f1f3f4;
        min-height: 150px;
        display: none;
    }

    .output-area.active {
        display: block;
    }

    .output-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 0.75rem;
    }

    .output-lang {
        color: #5f6368;
        font-size: 0.85rem;
        font-weight: 500;
    }

    .text-output {
        width: 100%;
        min-height: 100px;
        max-height: 300px;
        border: none;
        background: transparent;
        font-size: 16px;
        line-height: 1.6;
        color: #202124;
        resize: vertical;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        font-weight: 500;
    }

    .text-output:focus {
        outline: none;
    }

    .output-actions {
        display: flex;
        gap: 0.5rem;
        margin-top: 1rem;
    }

    .icon-btn {
        background: white;
        border: 1px solid #dadce0;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 1.1rem;
        color: #5f6368;
        touch-action: manipulation;
        -webkit-tap-highlight-color: transparent;
        transition: all 0.2s;
    }

    .icon-btn:active {
        background: #e8eaed;
        transform: scale(0.95);
    }

    /* History Section */
    .history-section {
        background: white;
        margin-top: 0.5rem;
        padding: 1rem;
    }

    .history-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }

    .history-title {
        font-size: 1rem;
        font-weight: 600;
        color: #202124;
    }

    .clear-history-btn {
        background: none;
        border: none;
        color: #1a73e8;
        font-size: 0.85rem;
        font-weight: 500;
        padding: 0.5rem;
        cursor: pointer;
        touch-action: manipulation;
        -webkit-tap-highlight-color: transparent;
    }

    .clear-history-btn:active {
        background: #f1f3f4;
        border-radius: 8px;
    }

    .history-item {
        padding: 1rem;
        border-bottom: 1px solid #f1f3f4;
        cursor: pointer;
        touch-action: manipulation;
        -webkit-tap-highlight-color: transparent;
        transition: background 0.2s;
    }

    .history-item:active {
        background: #f8f9fa;
    }

    .history-meta {
        font-size: 0.75rem;
        color: #5f6368;
        margin-bottom: 0.5rem;
    }

    .history-original {
        color: #202124;
        font-size: 0.9rem;
        margin-bottom: 0.3rem;
    }

    .history-translated {
        color: #5f6368;
        font-size: 0.9rem;
    }

    .empty-state {
        text-align: center;
        padding: 2rem 1rem;
        color: #9aa0a6;
        font-size: 0.9rem;
    }

    /* Language Picker Modal */
    .lang-picker-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: white;
        z-index: 1000;
        overflow-y: auto;
    }

    .lang-picker-modal.active {
        display: block;
        animation: slideUp 0.3s ease-out;
    }

    @keyframes slideUp {
        from {
            transform: translateY(100%);
        }
        to {
            transform: translateY(0);
        }
    }

    .modal-header {
        display: flex;
        align-items: center;
        padding: 1rem;
        border-bottom: 1px solid #e0e0e0;
        position: sticky;
        top: 0;
        background: white;
        z-index: 10;
    }

    .back-btn {
        background: none;
        border: none;
        font-size: 1.5rem;
        color: #5f6368;
        padding: 0.5rem;
        cursor: pointer;
        margin-right: 1rem;
        touch-action: manipulation;
        -webkit-tap-highlight-color: transparent;
    }

    .back-btn:active {
        background: #f1f3f4;
        border-radius: 50%;
    }

    .modal-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #202124;
    }

    .lang-option {
        padding: 1rem;
        border-bottom: 1px solid #f1f3f4;
        display: flex;
        justify-content: space-between;
        align-items: center;
        cursor: pointer;
        touch-action: manipulation;
        -webkit-tap-highlight-color: transparent;
    }

    .lang-option:active {
        background: #f8f9fa;
    }

    .lang-option.selected {
        color: #1a73e8;
        font-weight: 600;
    }

    .lang-option.selected::after {
        content: '✓';
        font-size: 1.2rem;
    }

    /* Tablet & Desktop */
    @media (min-width: 768px) {
        .translation-page {
            padding: 2rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .translation-header,
        .translation-content,
        .history-section {
            max-width: 800px;
            margin: 0 auto;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .translation-header {
            border-radius: 12px 12px 0 0;
        }

        .history-section {
            margin-top: 1rem;
        }

        .text-input,
        .text-output {
            font-size: 1.05rem;
        }
    }

    @media (min-width: 1024px) {
        .text-input {
            min-height: 150px;
        }

        .text-output {
            min-height: 120px;
        }
    }
</style>
@endpush

@section('content')
<div class="translation-page">
    <!-- Header -->
    <div class="translation-header">
        <h1 class="header-title">🌐 Translation</h1>
    </div>

    <!-- Main Content -->
    <div class="translation-content">
        <!-- Language Selector -->
        <div class="language-bar">
            <button class="lang-button" id="sourceLangBtn">
                <span id="sourceLangText">English</span>
                <span>▼</span>
            </button>
            <div class="swap-icon" id="swapBtn">⇄</div>
            <button class="lang-button" id="targetLangBtn">
                <span id="targetLangText">Tiếng Việt</span>
                <span>▼</span>
            </button>
        </div>

        <!-- Input Area -->
        <div class="input-area">
            <div class="input-wrapper">
                <textarea 
                    class="text-input" 
                    id="sourceText" 
                    placeholder="Enter text"
                    maxlength="5000"
                ></textarea>
            </div>
            <div class="input-actions">
                <span class="char-counter" id="charCounter">0 / 5,000</span>
                <button class="clear-btn" id="clearBtn" style="display: none;">✕</button>
            </div>
        </div>

        <!-- Loading -->
        <div class="loading-indicator" id="loading">
            <span class="spinner"></span> Translating...
        </div>

        <!-- Output Area -->
        <div class="output-area" id="outputArea">
            <div class="output-header">
                <span class="output-lang" id="outputLang">Tiếng Việt</span>
            </div>
            <textarea 
                class="text-output" 
                id="targetText" 
                placeholder="Translation"
                readonly
            ></textarea>
            <div class="output-actions">
                <button class="icon-btn" id="copyBtn" title="Copy">
                    📋
                </button>
                <button class="icon-btn" id="speakBtn" title="Listen">
                    🔊
                </button>
            </div>
        </div>
    </div>

    <!-- History -->
    <div class="history-section">
        <div class="history-header">
            <span class="history-title">History</span>
            <button class="clear-history-btn" id="clearHistoryBtn">Clear all</button>
        </div>
        <div id="historyList">
            <div class="empty-state">No translation history</div>
        </div>
    </div>

    <!-- Language Picker Modal -->
    <div class="lang-picker-modal" id="langPickerModal">
        <div class="modal-header">
            <button class="back-btn" id="closeModalBtn">←</button>
            <span class="modal-title">Select language</span>
        </div>
        <div id="langOptions">
            <div class="lang-option" data-lang="auto">
                <span>Detect language</span>
            </div>
            <div class="lang-option" data-lang="en">
                <span>English</span>
            </div>
            <div class="lang-option" data-lang="vi">
                <span>Tiếng Việt</span>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Configuration
    const config = {
        maxLength: {{ config('translation.max_length', 5000) }},
        debounceDelay: 500,
        retryDelay: 1000,
        maxRetries: 3
    };

    // State management
    let state = {
        sourceLang: 'en',
        targetLang: 'vi',
        currentPicker: null,
        debounceTimer: null,
        isTranslating: false,
        requestInProgress: false,
        rateLimitedUntil: null,
        retryCount: 0
    };

    // DOM elements
    const elements = {
        sourceText: document.getElementById('sourceText'),
        targetText: document.getElementById('targetText'),
        sourceLangBtn: document.getElementById('sourceLangBtn'),
        targetLangBtn: document.getElementById('targetLangBtn'),
        sourceLangText: document.getElementById('sourceLangText'),
        targetLangText: document.getElementById('targetLangText'),
        outputLang: document.getElementById('outputLang'),
        swapBtn: document.getElementById('swapBtn'),
        clearBtn: document.getElementById('clearBtn'),
        copyBtn: document.getElementById('copyBtn'),
        speakBtn: document.getElementById('speakBtn'),
        loading: document.getElementById('loading'),
        outputArea: document.getElementById('outputArea'),
        charCounter: document.getElementById('charCounter'),
        historyList: document.getElementById('historyList'),
        langPickerModal: document.getElementById('langPickerModal'),
        closeModalBtn: document.getElementById('closeModalBtn'),
        clearHistoryBtn: document.getElementById('clearHistoryBtn')
    };

    const langNames = {
        'auto': 'Detect language',
        'en': 'English',
        'vi': 'Tiếng Việt',
        'fr': 'Français',
        'es': 'Español',
        'de': 'Deutsch',
        'ja': '日本語',
        'ko': '한국어',
        'zh-CN': '中文 (简体)',
        'zh-TW': '中文 (繁體)',
        'ru': 'Русский',
        'ar': 'العربية',
        'pt': 'Português',
        'it': 'Italiano',
        'th': 'ไทย',
        'id': 'Bahasa Indonesia'
    };

    // ============ Input Handling ============
    elements.sourceText.addEventListener('input', function() {
        const count = this.value.length;
        elements.charCounter.textContent = `${count.toLocaleString()} / ${config.maxLength.toLocaleString()}`;
        elements.clearBtn.style.display = count > 0 ? 'block' : 'none';
        
        if (count > config.maxLength) {
            showError(`Maximum ${config.maxLength} characters allowed`);
            this.value = this.value.substring(0, config.maxLength);
            return;
        }
        
        autoTranslate();
    });

    // ============ Auto Translate with Debounce ============
    function autoTranslate() {
        clearTimeout(state.debounceTimer);
        
        const text = elements.sourceText.value.trim();
        
        if (!text) {
            elements.outputArea.classList.remove('active');
            elements.loading.classList.remove('active');
            return;
        }

        elements.loading.classList.add('active');
        elements.outputArea.classList.remove('active');

        state.debounceTimer = setTimeout(translate, config.debounceDelay);
    }

    // ============ Main Translation Function ============
    async function translate() {
        const text = elements.sourceText.value.trim();
        
        if (!text || state.requestInProgress) return;

        // Check rate limit
        if (state.rateLimitedUntil && Date.now() < state.rateLimitedUntil) {
            const secondsLeft = Math.ceil((state.rateLimitedUntil - Date.now()) / 1000);
            showError(`Rate limited. Please wait ${secondsLeft} seconds.`);
            elements.loading.classList.remove('active');
            return;
        }

        state.requestInProgress = true;
        state.isTranslating = true;
        elements.loading.classList.add('active');

        try {
            const response = await fetch('{{ route("client.translation.translate") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    text: text,
                    source_lang: state.sourceLang,
                    target_lang: state.targetLang
                })
            });

            const data = await response.json();

            // Handle rate limiting
            if (response.status === 429) {
                state.rateLimitedUntil = Date.now() + (data.retry_after * 1000);
                showError(data.message);
                elements.loading.classList.remove('active');
                return;
            }

            // Handle success
            if (data.success) {
                elements.targetText.value = data.translated_text;
                elements.loading.classList.remove('active');
                elements.outputArea.classList.add('active');
                
                // Show cache indicator
                if (data.cached) {
                    showCacheIndicator();
                }
                
                // Reset retry count on success
                state.retryCount = 0;
                
                // Save to history
                saveHistory(data);
            } else {
                throw new Error(data.message || 'Translation failed');
            }

        } catch (error) {
            console.error('Translation error:', error);
            
            // Retry logic
            if (state.retryCount < config.maxRetries) {
                state.retryCount++;
                showInfo(`Retrying... (${state.retryCount}/${config.maxRetries})`);
                setTimeout(translate, config.retryDelay * state.retryCount);
            } else {
                showError('Translation failed. Please try again later.');
                elements.loading.classList.remove('active');
                state.retryCount = 0;
            }
        } finally {
            state.requestInProgress = false;
            state.isTranslating = false;
        }
    }

    // ============ Language Picker ============
    elements.sourceLangBtn.addEventListener('click', () => openLangPicker('source'));
    elements.targetLangBtn.addEventListener('click', () => openLangPicker('target'));

    function openLangPicker(type) {
        state.currentPicker = type;
        elements.langPickerModal.classList.add('active');
        document.body.style.overflow = 'hidden';
        
        const current = type === 'source' ? state.sourceLang : state.targetLang;
        document.querySelectorAll('.lang-option').forEach(opt => {
            opt.classList.toggle('selected', opt.dataset.lang === current);
        });
    }

    elements.closeModalBtn.addEventListener('click', closeLangPicker);

    function closeLangPicker() {
        elements.langPickerModal.classList.remove('active');
        document.body.style.overflow = '';
    }

    // Language selection
    document.querySelectorAll('.lang-option').forEach(option => {
        option.addEventListener('click', function() {
            const lang = this.dataset.lang;
            
            if (state.currentPicker === 'source') {
                state.sourceLang = lang;
                elements.sourceLangText.textContent = langNames[lang];
            } else {
                state.targetLang = lang;
                elements.targetLangText.textContent = langNames[lang];
                elements.outputLang.textContent = langNames[lang];
            }
            
            closeLangPicker();
            
            if (elements.sourceText.value.trim()) {
                autoTranslate();
            }
        });
    });

    // ============ Swap Languages ============
    elements.swapBtn.addEventListener('click', function() {
        if (state.sourceLang !== 'auto') {
            // Swap languages
            [state.sourceLang, state.targetLang] = [state.targetLang, state.sourceLang];
            [elements.sourceLangText.textContent, elements.targetLangText.textContent] = 
                [elements.targetLangText.textContent, elements.sourceLangText.textContent];
            
            // Swap text
            [elements.sourceText.value, elements.targetText.value] = 
                [elements.targetText.value, elements.sourceText.value];
            
            elements.outputLang.textContent = langNames[state.targetLang];
            
            // Update char counter
            const count = elements.sourceText.value.length;
            elements.charCounter.textContent = `${count.toLocaleString()} / ${config.maxLength.toLocaleString()}`;
            elements.clearBtn.style.display = count > 0 ? 'block' : 'none';
            
            if (elements.sourceText.value.trim()) {
                autoTranslate();
            }
        } else {
            showError('Cannot swap when source language is set to auto-detect');
        }
    });

    // ============ Clear Button ============
    elements.clearBtn.addEventListener('click', function() {
        elements.sourceText.value = '';
        elements.targetText.value = '';
        elements.clearBtn.style.display = 'none';
        elements.outputArea.classList.remove('active');
        elements.charCounter.textContent = `0 / ${config.maxLength.toLocaleString()}`;
        clearTimeout(state.debounceTimer);
        elements.loading.classList.remove('active');
    });

    // ============ Copy Button ============
    elements.copyBtn.addEventListener('click', async function() {
        try {
            await navigator.clipboard.writeText(elements.targetText.value);
            this.textContent = '✓';
            showSuccess('Copied to clipboard');
            setTimeout(() => this.textContent = '📋', 2000);
        } catch (error) {
            // Fallback for older browsers
            elements.targetText.select();
            document.execCommand('copy');
            this.textContent = '✓';
            setTimeout(() => this.textContent = '📋', 2000);
        }
    });

    // ============ Speak Button ============
    elements.speakBtn.addEventListener('click', function() {
        const text = elements.targetText.value;
        if (!text) return;
        
        if ('speechSynthesis' in window) {
            window.speechSynthesis.cancel();
            const utterance = new SpeechSynthesisUtterance(text);
            utterance.lang = state.targetLang;
            window.speechSynthesis.speak(utterance);
            
            this.textContent = '🔊';
            utterance.onend = () => {
                this.textContent = '🔊';
            };
        } else {
            showError('Text-to-speech not supported in your browser');
        }
    });

    // ============ History Functions ============
    async function saveHistory(data) {
        try {
            await fetch('{{ route("client.translation.save-history") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    original_text: data.original_text,
                    translated_text: data.translated_text,
                    source_lang: data.detected_lang || data.source_lang,
                    target_lang: data.target_lang
                })
            });
            loadHistory();
        } catch (error) {
            console.error('Save history failed:', error);
        }
    }

    async function loadHistory() {
        try {
            const response = await fetch('{{ route("client.translation.history") }}');
            const data = await response.json();

            if (data.success && data.history.length > 0) {
                elements.historyList.innerHTML = data.history.map(item => `
                    <div class="history-item" onclick="loadFromHistory(\`${escapeHtml(item.original)}\`, '${item.source}', \`${escapeHtml(item.translated)}\`, '${item.target}')">
                        <div class="history-meta">${langNames[item.source] || item.source} → ${langNames[item.target] || item.target} • ${item.time}</div>
                        <div class="history-original">${truncate(item.original, 100)}</div>
                        <div class="history-translated">${truncate(item.translated, 100)}</div>
                    </div>
                `).join('');
            } else {
                elements.historyList.innerHTML = '<div class="empty-state">No translation history</div>';
            }
        } catch (error) {
            console.error('Load history failed:', error);
            elements.historyList.innerHTML = '<div class="empty-state">Failed to load history</div>';
        }
    }

    function loadFromHistory(original, sourceLangCode, translated, targetLangCode) {
        elements.sourceText.value = original;
        elements.targetText.value = translated;
        state.sourceLang = sourceLangCode;
        state.targetLang = targetLangCode;
        elements.sourceLangText.textContent = langNames[sourceLangCode] || sourceLangCode;
        elements.targetLangText.textContent = langNames[targetLangCode] || targetLangCode;
        elements.outputLang.textContent = langNames[targetLangCode] || targetLangCode;
        elements.outputArea.classList.add('active');
        elements.clearBtn.style.display = 'block';
        elements.charCounter.textContent = `${original.length.toLocaleString()} / ${config.maxLength.toLocaleString()}`;
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    elements.clearHistoryBtn.addEventListener('click', async function() {
        if (!confirm('Clear all translation history?')) return;
        
        try {
            const response = await fetch('{{ route("client.translation.clear-history") }}', {
                method: 'DELETE',
                headers: { 
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            });
            
            const data = await response.json();
            if (data.success) {
                showSuccess('History cleared');
                loadHistory();
            }
        } catch (error) {
            console.error('Clear history failed:', error);
            showError('Failed to clear history');
        }
    });

    // ============ Utility Functions ============
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    function truncate(text, maxLength) {
        if (text.length <= maxLength) return text;
        return text.substring(0, maxLength) + '...';
    }

    function showError(message) {
        showToast(message, 'error');
    }

    function showSuccess(message) {
        showToast(message, 'success');
    }

    function showInfo(message) {
        showToast(message, 'info');
    }

    function showToast(message, type = 'info') {
        // Remove existing toasts
        document.querySelectorAll('.toast-notification').forEach(t => t.remove());
        
        const toast = document.createElement('div');
        toast.className = 'toast-notification';
        toast.textContent = message;
        
        const colors = {
            error: '#f44336',
            success: '#4caf50',
            info: '#2196f3'
        };
        
        toast.style.cssText = `
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: ${colors[type] || colors.info};
            color: white;
            padding: 1rem 2rem;
            border-radius: 8px;
            z-index: 9999;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
            animation: slideUp 0.3s ease-out;
            font-size: 0.95rem;
            max-width: 90%;
            text-align: center;
        `;
        
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.style.animation = 'slideDown 0.3s ease-out';
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }

    function showCacheIndicator() {
        const indicator = document.createElement('div');
        indicator.textContent = '⚡ From cache';
        indicator.style.cssText = `
            position: absolute;
            top: 10px;
            right: 10px;
            background: #4caf50;
            color: white;
            padding: 0.3rem 0.6rem;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 600;
            z-index: 10;
        `;
        elements.outputArea.style.position = 'relative';
        elements.outputArea.appendChild(indicator);
        
        setTimeout(() => {
            indicator.style.animation = 'fadeOut 0.3s ease-out';
            setTimeout(() => indicator.remove(), 300);
        }, 2000);
    }

    // ============ Animations ============
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideUp {
            from { transform: translate(-50%, 100%); opacity: 0; }
            to { transform: translate(-50%, 0); opacity: 1; }
        }
        @keyframes slideDown {
            from { transform: translate(-50%, 0); opacity: 1; }
            to { transform: translate(-50%, 100%); opacity: 0; }
        }
        @keyframes fadeOut {
            from { opacity: 1; }
            to { opacity: 0; }
        }
    `;
    document.head.appendChild(style);

    // ============ Initialization ============
    document.addEventListener('DOMContentLoaded', function() {
        loadHistory();
        console.log('Translation app initialized');
    });

    // ============ Keyboard Shortcuts ============
    document.addEventListener('keydown', function(e) {
        // Ctrl/Cmd + Enter: Translate
        if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
            e.preventDefault();
            if (elements.sourceText.value.trim()) {
                translate();
            }
        }
        
        // Escape: Close modal or clear
        if (e.key === 'Escape') {
            if (elements.langPickerModal.classList.contains('active')) {
                closeLangPicker();
            } else if (elements.sourceText.value) {
                elements.clearBtn.click();
            }
        }
    });

    // Prevent accidental page close
    window.addEventListener('beforeunload', function(e) {
        if (elements.sourceText.value.trim() && !elements.targetText.value) {
            e.preventDefault();
            e.returnValue = '';
        }
    });
</script>
@endpush
