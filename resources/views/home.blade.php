<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZTF Foundation - Home</title>
    <link rel="stylesheet" href="{{ asset('app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .auth-link {
            background-color: #3498db;
            color: white !important;
            padding: 8px 15px;
            border-radius: 5px;
            transition: all 0.3s ease;
            margin: 0 5px;
            display: inline-block;
        }
        .auth-link:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
        }
        .auth-link i {
            margin-right: 5px;
        }
        .login-link {
            background-color: #2ecc71;
        }
        .login-link:hover {
            background-color: #27ae60;
        }
        .auth-buttons {
            display: flex;
            align-items: center;
            gap: 10px;
        }
    </style>
</head>
<body>
    
    <div class="top-bar">
        <div class="contact-info">
            <span style="border-right: 2px solid #fffdfd;"><i class="fas fa-phone-alt"></i> +237 683 067 844</span>
            <span style="margin-left: 5px;"><i class="fas fa-envelope"></i> info@ztffoundation.com</span>
        </div>
        <div class="social-icons">
            <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
            <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
            <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
            <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
        </div>
    </div>

    <nav class="navbar" id="mainNavbar">
        <a href="{{ route('home') }}" class="logo">
            <img src="{{ asset('images/CMFI Logo.png') }}" alt="Site Logo">
        </a>
        <div class="hamburger" id="hamburgerMenu">
            <i class="fas fa-bars"></i>
        </div>
        <ul class="nav-links" id="navLinks">
            <li><a href="{{ route('home') }}" class="active">Home</a></li>
            <li><a href="{{ route('about') }}" class="">About</a></li>
            <li><a href="{{ route('departments') }}">Departments</a></li>
            <li><a href="{{ route('contact') }}">Contact</a></li>
            <li><a href="{{ route('blog') }}">Blog</a></li>
            <li class="auth-buttons">
                <a href="{{ route('login') }}" class="auth-link login-link"><i class="fas fa-sign-in-alt"></i> Login</a>
                <a href="{{ route('identification.form') }}" class="auth-link"><i class="fas fa-user-plus"></i> Register</a>
            </li>
        </ul>
    </nav>

    <section class="home-section" id="home">
        <div class="content">
            <h2>Welcome to the <span>ZTF Foundation</span> <br>Staff Portal</h2>
            <p>Get information about all staff, resources, and management tools.</p>
            
        </div>
    </section>

    <h1>Key Features</h1>
    <div class="features-container">
        <div class="flip-card" tabindex="0">
            <div class="flip-card-inner">
                <div class="flip-card-front">
                    <span class="feature-icon">&#128100;</span> <h2 class="feature-title">Centralized Profiles</h2>
                </div>
                <div class="flip-card-back">
                    <h2>Centralized Profiles</h2>
                    <p>Securely store and access comprehensive staff profiles, including personal details, contact information, and employment history.</p>
                </div>
            </div>
        </div>
        <div class="flip-card" tabindex="0">
            <div class="flip-card-inner">
                <div class="flip-card-front">
                    <span class="feature-icon">&#128193;</span> <h2 class="feature-title">Document Management</h2>
                </div>
                <div class="flip-card-back">
                    <h2>Document Management</h2>
                    <p>Effortlessly upload, organize, and retrieve important documents like contracts, certifications, and performance reviews.</p>
                </div>
            </div>
        </div>
        <div class="flip-card" tabindex="0">
            <div class="flip-card-inner">
                <div class="flip-card-front">
                    <span class="feature-icon">&#128202;</span> <h2 class="feature-title">Performance Tracking</h2>
                </div>
                <div class="flip-card-back">
                    <h2>Performance Tracking</h2>
                    <p>Monitor staff performance with customizable metrics, set goals, and conduct regular appraisals to foster growth.</p>
                </div>
            </div>
        </div>
        <div class="flip-card" tabindex="0">
            <div class="flip-card-inner">
                <div class="flip-card-front">
                    <span class="feature-icon">&#128337;</span> <h2 class="feature-title">Leave & Attendance</h2>
                </div>
                <div class="flip-card-back">
                    <h2>Leave & Attendance</h2>
                    <p>Simplify leave requests, approvals, and attendance tracking with an intuitive interface and automated calculations.</p>
                </div>
            </div>
        </div>
        <div class="flip-card" tabindex="0">
            <div class="flip-card-inner">
                <div class="flip-card-front">
                    <span class="feature-icon">&#128200;</span> <h2 class="feature-title">Reporting & Analytics</h2>
                </div>
                <div class="flip-card-back">
                    <h2>Reporting & Analytics</h2>
                    <p>Generate insightful reports and analytics on staff data, aiding in strategic decision-making and operational efficiency.</p>
                </div>
            </div>
        </div>
        <div class="flip-card" tabindex="0">
            <div class="flip-card-inner">
                <div class="flip-card-front">
                    <span class="feature-icon">&#128274;</span> <h2 class="feature-title">Secure Access Control</h2>
                </div>
                <div class="flip-card-back">
                    <h2>Secure Access Control</h2>
                    <p>Control access to sensitive staff information with role-based permissions, ensuring data privacy and security.</p>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="footer-content">
            <h3>ZTF Foundation</h3>
            <p>Get information about all staff, resources, and management tools.</p>
            <ul class="footer-links">
                <li><a href="staff.php">Home</a></li>
                <li><a href="staff login.php">Staff</a></li>
                <li><a href="admin login.html">Departments</a></li>
                <li><a href="contact">Contact</a></li>
                <li><a href="#">Privacy Policy</a></li>
            </ul>
            <div class="social-icons">
                <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
            </div>
            <p class="copyright">&copy; 2025 ZTF Foundation. All rights reserved.</p>
        </div>
    </footer>

    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        // Script pour le menu hamburger
        document.getElementById('hamburgerMenu').addEventListener('click', function() {
            document.getElementById('navLinks').classList.toggle('active');
        });

        // Script pour la barre de navigation fixe
        window.onscroll = function() {
            var navbar = document.getElementById("mainNavbar");
            if (window.pageYOffset > 0) {
                navbar.classList.add("sticky");
            } else {
                navbar.classList.remove("sticky");
            }
        };
    </script>
</body>
</html>