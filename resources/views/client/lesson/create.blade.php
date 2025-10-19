@extends('client.layouts.app')

@section('title', 'Create New Lesson - Learn English')

@push('styles')
<style>
    .create-lesson-page {
        background: #f8f9fa;
        min-height: 100vh;
        padding-bottom: 3rem;
    }

    .page-header {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
        padding: 2rem 0;
        margin-bottom: 2rem;
        text-align: center;
    }

    .page-header h1 {
        margin: 0;
        font-size: 1.8rem;
    }

    .page-header p {
        margin: 0.5rem 0 0 0;
        opacity: 0.95;
    }

    .form-section {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        transition: all 0.3s;
    }

    .form-section:hover {
        box-shadow: 0 4px 15px rgba(79, 172, 254, 0.2);
    }

    .section-header {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
        padding: 0.8rem 1.2rem;
        border-radius: 10px;
        margin-bottom: 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .section-header.vocabulary {
        background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
    }

    .section-header.grammar {
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
    }

    .section-header.quiz {
        background: linear-gradient(135deg, #30cfd0 0%, #330867 100%);
    }

    .section-header h5 {
        margin: 0;
        font-size: 1.1rem;
        font-weight: 600;
    }

    .form-label {
        font-weight: 600;
        color: #333;
        margin-bottom: 0.5rem;
        font-size: 0.95rem;
    }

    .form-label.required:after {
        content: " *";
        color: #dc3545;
    }

    .form-control, .form-select {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 0.6rem 1rem;
        font-size: 0.95rem;
        transition: all 0.3s;
    }

    .form-control:focus, .form-select:focus {
        border-color: #4facfe;
        box-shadow: 0 0 0 0.2rem rgba(79, 172, 254, 0.15);
    }

    textarea.form-control {
        resize: vertical;
        min-height: 80px;
    }

    .item-card {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        border-radius: 12px;
        padding: 1.2rem;
        margin-bottom: 1rem;
        position: relative;
        animation: slideIn 0.3s ease-out;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .item-card.vocabulary {
        background: linear-gradient(135deg, #e0f7fa 0%, #b2ebf2 100%);
    }

    .item-card.grammar {
        background: linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%);
    }

    .item-card.question {
        background: linear-gradient(135deg, #f3e5f5 0%, #e1bee7 100%);
    }

    .item-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid rgba(255,255,255,0.5);
    }

    .item-number {
        font-weight: 700;
        font-size: 1.1rem;
        color: #333;
    }

    .remove-btn {
        background: #dc3545;
        color: white;
        border: none;
        border-radius: 50%;
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s;
        font-size: 1.2rem;
    }

    .remove-btn:hover {
        background: #c82333;
        transform: rotate(90deg);
    }

    .add-item-btn {
        width: 100%;
        padding: 0.8rem;
        border: 2px dashed #ccc;
        border-radius: 10px;
        background: white;
        color: #666;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }

    .add-item-btn:hover {
        border-color: #4facfe;
        background: #f0f9ff;
        color: #4facfe;
        transform: translateY(-2px);
    }

    .add-item-btn.vocabulary:hover {
        border-color: #43e97b;
        background: #f0fff4;
        color: #43e97b;
    }

    .add-item-btn.grammar:hover {
        border-color: #fa709a;
        background: #fff5f7;
        color: #fa709a;
    }

    .add-item-btn.question:hover {
        border-color: #30cfd0;
        background: #f0f9ff;
        color: #30cfd0;
    }

    .submit-section {
        position: sticky;
        bottom: 0;
        background: white;
        padding: 1rem;
        border-radius: 15px 15px 0 0;
        box-shadow: 0 -5px 20px rgba(0,0,0,0.1);
        z-index: 100;
    }

    .btn-submit {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        border: none;
        color: white;
        padding: 1rem 2rem;
        font-size: 1.1rem;
        font-weight: 600;
        border-radius: 12px;
        transition: all 0.3s;
        width: 100%;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(79, 172, 254, 0.4);
    }

    .btn-submit:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    .empty-state {
        text-align: center;
        padding: 2rem;
        color: #999;
        font-style: italic;
    }

    .quiz-toggle {
        background: white;
        border-radius: 12px;
        padding: 1.2rem;
        cursor: pointer;
        transition: all 0.3s;
    }

    .quiz-toggle:hover {
        background: #f8f9fa;
    }

    .form-switch .form-check-input {
        width: 3rem;
        height: 1.5rem;
        cursor: pointer;
    }

    .form-switch .form-check-input:checked {
        background-color: #4facfe;
        border-color: #4facfe;
    }

    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.8);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 9999;
    }

    .loading-content {
        text-align: center;
        color: white;
    }

    .spinner {
        width: 60px;
        height: 60px;
        border: 5px solid rgba(255,255,255,0.3);
        border-top-color: white;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin: 0 auto 1rem;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    @media (max-width: 768px) {
        .page-header h1 {
            font-size: 1.5rem;
        }

        .form-section {
            padding: 1rem;
        }

        .section-header {
            padding: 0.6rem 1rem;
        }

        .item-card {
            padding: 1rem;
        }
    }
</style>
@endpush

@section('content')
<div class="create-lesson-page">
    <div class="page-header">
        <div class="container">
            <h1>✨ Create New Lesson</h1>
            <p>Build comprehensive learning materials for your students</p>
        </div>
    </div>

    <div class="container">
        <form id="lessonForm">
            @csrf

            <!-- Basic Information -->
            <div class="form-section">
                <div class="section-header">
                    <h5>📋 Basic Information</h5>
                </div>

                <div class="mb-3">
                    <label class="form-label required">Lesson Title</label>
                    <input type="text" class="form-control" name="title" 
                           placeholder="Enter lesson title..." required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea class="form-control" name="description" rows="3"
                              placeholder="Brief description of the lesson..."></textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Category</label>
                        <select class="form-select" name="category_id">
                            <option value="">-- Select Category --</option>
                            <optgroup label="📚 Vocabulary">
                                @foreach($vocabularyCategories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </optgroup>
                            <optgroup label="📖 Grammar">
                                @foreach($grammarCategories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </optgroup>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label required">Level</label>
                        <select class="form-select" name="level" required>
                            <option value="beginner">🌱 Beginner</option>
                            <option value="intermediate" selected>🌿 Intermediate</option>
                            <option value="advanced">🌳 Advanced</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Image URL</label>
                    <input type="url" class="form-control" name="image_url" 
                           placeholder="https://example.com/image.jpg">
                </div>
            </div>

            <!-- Vocabulary Section -->
            <div class="form-section">
                <div class="section-header vocabulary">
                    <h5>📚 Vocabulary (Optional)</h5>
                </div>

                <div id="vocabularyContainer">
                    <button type="button" class="add-item-btn vocabulary" onclick="addVocabulary()">
                        <i class="fas fa-plus-circle"></i>
                        <span>Add Word</span>
                    </button>
                </div>
            </div>

            <!-- Grammar Section -->
            <div class="form-section">
                <div class="section-header grammar">
                    <h5>📖 Grammar (Optional)</h5>
                </div>

                <div id="grammarContainer">
                    <button type="button" class="add-item-btn grammar" onclick="addGrammar()">
                        <i class="fas fa-plus-circle"></i>
                        <span>Add Grammar</span>
                    </button>
                </div>
            </div>

            <!-- Quiz Section -->
            <div class="form-section">
                <div class="quiz-toggle" onclick="toggleQuiz()">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="enableQuiz">
                        <label class="form-check-label" for="enableQuiz" style="font-weight: 600; font-size: 1.1rem;">
                            ✅ Add Quiz (Optional)
                        </label>
                    </div>
                </div>

                <div id="quizContainer" style="display: none; margin-top: 1rem;">
                    <div class="section-header quiz">
                        <h5>❓ Quiz Setup</h5>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Quiz Title</label>
                        <input type="text" class="form-control" name="quiz_title" 
                               placeholder="Enter quiz title...">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Quiz Description</label>
                        <textarea class="form-control" name="quiz_description" rows="2"
                                  placeholder="Brief description of the quiz..."></textarea>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label class="form-label">Quiz Type</label>
                            <select class="form-select" name="quiz_type">
                                <option value="vocabulary">📚 Vocabulary Only</option>
                                <option value="grammar">📖 Grammar Only</option>
                                <option value="mixed" selected>🔀 Mixed</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Time Limit (minutes)</label>
                            <input type="number" class="form-control" name="time_limit" 
                                   value="0" min="0" placeholder="0 = No limit">
                        </div>
                    </div>

                    <hr style="margin: 1.5rem 0;">

                    <div class="mb-3">
                        <strong style="font-size: 1.1rem;">Questions</strong>
                    </div>

                    <div id="quizQuestionsContainer">
                        <button type="button" class="add-item-btn question" onclick="addQuizQuestion()">
                            <i class="fas fa-plus-circle"></i>
                            <span>Add Question</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Submit Section -->
            <div class="submit-section">
                <button type="submit" class="btn-submit" id="submitBtn">
                    <i class="fas fa-check-circle"></i> Create Lesson
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Loading Overlay -->
<div class="loading-overlay" id="loadingOverlay">
    <div class="loading-content">
        <div class="spinner"></div>
        <h4>Creating your lesson...</h4>
        <p>Please wait while we process your request</p>
    </div>
</div>

<script>
let vocabIndex = 0;
let grammarIndex = 0;
let questionIndex = 0;

// Add Vocabulary
function addVocabulary() {
    const container = document.getElementById('vocabularyContainer');
    const addBtn = container.querySelector('.add-item-btn');
    
    const itemId = `vocab-${vocabIndex}`;
    const html = `
        <div class="item-card vocabulary" id="${itemId}">
            <div class="item-header">
                <div class="item-number">📚 Word #${vocabIndex + 1}</div>
                <button type="button" class="remove-btn" onclick="removeItem('${itemId}', 'vocabulary')">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label required">Word</label>
                    <input type="text" class="form-control" name="vocabularies[${vocabIndex}][word]" 
                           placeholder="hello" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Pronunciation</label>
                    <input type="text" class="form-control" name="vocabularies[${vocabIndex}][pronunciation]" 
                           placeholder="/həˈloʊ/">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Part of Speech</label>
                    <select class="form-select" name="vocabularies[${vocabIndex}][part_of_speech]">
                        <option value="">-- Select --</option>
                        <option value="noun">Noun (Danh từ)</option>
                        <option value="verb">Verb (Động từ)</option>
                        <option value="adjective">Adjective (Tính từ)</option>
                        <option value="adverb">Adverb (Trạng từ)</option>
                        <option value="preposition">Preposition (Giới từ)</option>
                        <option value="conjunction">Conjunction (Liên từ)</option>
                        <option value="pronoun">Pronoun (Đại từ)</option>
                        <option value="interjection">Interjection (Thán từ)</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label required">Meaning</label>
                    <input type="text" class="form-control" name="vocabularies[${vocabIndex}][meaning]" 
                           placeholder="xin chào" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Example Sentence</label>
                <textarea class="form-control" name="vocabularies[${vocabIndex}][example_sentence]" rows="2"
                          placeholder="Hello, how are you?"></textarea>
            </div>
        </div>
    `;

    // Insert before the add button
    addBtn.insertAdjacentHTML('beforebegin', html);
    vocabIndex++;
    
    // Scroll to the newly added item
    scrollToElement(itemId);
}

// Add Grammar
function addGrammar() {
    const container = document.getElementById('grammarContainer');
    const addBtn = container.querySelector('.add-item-btn');
    
    const itemId = `grammar-${grammarIndex}`;
    const html = `
        <div class="item-card grammar" id="${itemId}">
            <div class="item-header">
                <div class="item-number">📖 Grammar #${grammarIndex + 1}</div>
                <button type="button" class="remove-btn" onclick="removeItem('${itemId}', 'grammar')">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="mb-3">
                <label class="form-label required">Title</label>
                <input type="text" class="form-control" name="grammars[${grammarIndex}][title]" 
                       placeholder="Present Simple Tense" required>
            </div>

            <div class="mb-3">
                <label class="form-label required">Content</label>
                <textarea class="form-control" name="grammars[${grammarIndex}][content]" rows="3"
                          placeholder="Explain the grammar point..." required></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Structure</label>
                <input type="text" class="form-control" name="grammars[${grammarIndex}][structure]" 
                       placeholder="S + V + O">
            </div>

            <div class="mb-3">
                <label class="form-label">Usage</label>
                <textarea class="form-control" name="grammars[${grammarIndex}][usage]" rows="2"
                          placeholder="When and how to use this grammar..."></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Examples</label>
                <textarea class="form-control" name="grammars[${grammarIndex}][examples]" rows="2"
                          placeholder="Example sentences..."></textarea>
            </div>
        </div>
    `;

    // Insert before the add button
    addBtn.insertAdjacentHTML('beforebegin', html);
    grammarIndex++;
    
    // Scroll to the newly added item
    scrollToElement(itemId);
}

// Add Quiz Question
function addQuizQuestion() {
    const container = document.getElementById('quizQuestionsContainer');
    const addBtn = container.querySelector('.add-item-btn');
    
    const itemId = `question-${questionIndex}`;
    const html = `
        <div class="item-card question" id="${itemId}">
            <div class="item-header">
                <div class="item-number">❓ Question #${questionIndex + 1}</div>
                <button type="button" class="remove-btn" onclick="removeItem('${itemId}', 'question')">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="mb-3">
                <label class="form-label required">Question</label>
                <textarea class="form-control" name="quiz_questions[${questionIndex}][question]" rows="2"
                          placeholder="Enter your question here..." required></textarea>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label required">Option A</label>
                    <input type="text" class="form-control" name="quiz_questions[${questionIndex}][option_a]" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label required">Option B</label>
                    <input type="text" class="form-control" name="quiz_questions[${questionIndex}][option_b]" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Option C</label>
                    <input type="text" class="form-control" name="quiz_questions[${questionIndex}][option_c]">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Option D</label>
                    <input type="text" class="form-control" name="quiz_questions[${questionIndex}][option_d]">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label required">Correct Answer</label>
                    <select class="form-select" name="quiz_questions[${questionIndex}][correct_answer]" required>
                        <option value="a">A</option>
                        <option value="b">B</option>
                        <option value="c">C</option>
                        <option value="d">D</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Explanation</label>
                    <textarea class="form-control" name="quiz_questions[${questionIndex}][explanation]" rows="1"
                              placeholder="Why is this the correct answer?"></textarea>
                </div>
            </div>
        </div>
    `;

    // Insert before the add button
    addBtn.insertAdjacentHTML('beforebegin', html);
    questionIndex++;
    
    // Scroll to the newly added item
    scrollToElement(itemId);
}

// Remove Item
function removeItem(id, type) {
    const item = document.getElementById(id);
    if (item) {
        item.style.animation = 'slideOut 0.3s ease-out';
        setTimeout(() => {
            item.remove();
        }, 300);
    }
}

// Toggle Quiz
function toggleQuiz() {
    const checkbox = document.getElementById('enableQuiz');
    checkbox.checked = !checkbox.checked;
    const quizContainer = document.getElementById('quizContainer');
    quizContainer.style.display = checkbox.checked ? 'block' : 'none';
}

// Scroll to newly added element
function scrollToElement(elementId) {
    setTimeout(() => {
        const element = document.getElementById(elementId);
        if (element) {
            const elementPosition = element.getBoundingClientRect().top + window.pageYOffset;
            const offsetPosition = elementPosition - 100;
            
            window.scrollTo({
                top: offsetPosition,
                behavior: 'smooth'
            });
            
            // Focus on first input of the new item
            const firstInput = element.querySelector('input, textarea, select');
            if (firstInput) {
                setTimeout(() => firstInput.focus(), 500);
            }
        }
    }, 100);
}

// Submit Form
document.getElementById('lessonForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    const submitBtn = document.getElementById('submitBtn');
    const loadingOverlay = document.getElementById('loadingOverlay');

    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Processing...';
    loadingOverlay.style.display = 'flex';

    fetch('{{ route("lesson.store") }}', {
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
            // Success message with animation
            const successMsg = document.createElement('div');
            successMsg.style.cssText = `
                position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%);
                background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
                color: white; padding: 2rem 3rem; border-radius: 15px;
                box-shadow: 0 10px 30px rgba(0,0,0,0.3); z-index: 10000;
                text-align: center; animation: bounceIn 0.5s;
            `;
            successMsg.innerHTML = `
                <i class="fas fa-check-circle" style="font-size: 3rem; margin-bottom: 1rem;"></i>
                <h3>Success!</h3>
                <p>${data.message}</p>
            `;
            document.body.appendChild(successMsg);

            setTimeout(() => {
                window.location.href = '{{ route("client.lessons.index") }}';
            }, 1500);
        } else {
            alert('❌ ' + (data.message || 'An error occurred!'));
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-check-circle"></i> Create Lesson';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        loadingOverlay.style.display = 'none';
        alert('❌ An error occurred while creating the lesson!');
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<i class="fas fa-check-circle"></i> Create Lesson';
    });
});

// Add animations
const style = document.createElement('style');
style.textContent = `
    @keyframes slideOut {
        to {
            opacity: 0;
            transform: translateX(-20px);
        }
    }
    @keyframes bounceIn {
        0% { transform: translate(-50%, -50%) scale(0.3); opacity: 0; }
        50% { transform: translate(-50%, -50%) scale(1.05); }
        70% { transform: translate(-50%, -50%) scale(0.9); }
        100% { transform: translate(-50%, -50%) scale(1); opacity: 1; }
    }
`;
document.head.appendChild(style);
</script>
@endsection
