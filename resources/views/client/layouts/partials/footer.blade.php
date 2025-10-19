<footer class="footer">
    <style>
        .footer {
            background: #2d3748;
            color: white;
            padding: 40px 20px 20px;
            margin-top: 60px;
        }
        
        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }
        
        .footer-section h3 {
            margin-bottom: 1rem;
            color: #667eea;
        }
        
        .footer-section ul {
            list-style: none;
        }
        
        .footer-section ul li {
            margin-bottom: 0.5rem;
        }
        
        .footer-section a {
            color: #cbd5e0;
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .footer-section a:hover {
            color: white;
        }
        
        .footer-bottom {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #4a5568;
            color: #cbd5e0;
        }
        
        .social-links {
            display: flex;
            gap: 1rem;
            font-size: 1.5rem;
        }
        
        .social-links a {
            color: white;
            transition: transform 0.3s;
        }
        
        .social-links a:hover {
            transform: translateY(-3px);
        }
    </style>
    
    <div class="footer-container">
        <div class="footer-section">
            <h3>🎓 English Learning</h3>
            <p>Nền tảng học tiếng Anh trực tuyến miễn phí dành riêng cho Mai Anh Cute với hàng ngàn bài học chất lượng cao.</p>
            <div class="social-links">
                <a href="#" title="Facebook">📘</a>
                <a href="#" title="YouTube">📺</a>
                <a href="#" title="Instagram">📷</a>
            </div>
        </div>
        
        <div class="footer-section">
            <h3>Học tập</h3>
            <ul>
                <li><a href="">Từ vựng</a></li>
                <li><a href="">Ngữ pháp</a></li>
                <li><a href="">Flashcards</a></li>
                <li><a href="">Quiz & Bài tập</a></li>
            </ul>
        </div>
        
        <div class="footer-section">
            <h3>Công cụ</h3>
            <ul>
                <li><a href="">Dịch thuật</a></li>
                <li><a href="#">Phát âm</a></li>
                <li><a href="#">Từ điển</a></li>
                <li><a href="#">Học theo chủ đề</a></li>
            </ul>
        </div>
        
        <div class="footer-section">
            <h3>Thông tin</h3>
            <ul>
                <li><a href="#">Về chúng tôi</a></li>
                <li><a href="#">Liên hệ</a></li>
                <li><a href="#">Điều khoản sử dụng</a></li>
                <li><a href="#">Chính sách bảo mật</a></li>
            </ul>
        </div>
    </div>
    
    <div class="footer-bottom">
        <p>&copy; {{ date('Y') }} English Learning Platform. All rights reserved.</p>
    </div>
</footer>
