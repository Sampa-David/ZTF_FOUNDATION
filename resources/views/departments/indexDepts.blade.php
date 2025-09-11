<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Departments - ZTF Foundation</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{asset('staff.css')}}">

    <style>
        /* General Body & Typography */
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }

        .container {
            max-width: 1000px; /* */
            margin: 0 auto;
            padding: 20px;
        }

        /* Header */
        header {
            background-color: #2c3e50;
            color: #ffffff;
            padding: 40px 0;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        header p {
            font-size: 1.1em;
            max-width: 800px;
            margin: 0 auto;
        }

        /* --- Department Grid Layout --- */
        .departments-grid {
            margin-top: 30px;
            display: grid; 
            grid-template-columns: 1fr; /* Default to one column for mobile */
            gap: 25px; 
        }

        /* Adjust breakpoint and columns for larger screens */
        @media (min-width: 769px) { /* Keep 2 columns for medium-sized tablets */
            .departments-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (min-width: 1024px) { /* Apply 3 columns on larger desktops/laptops */
            .departments-grid {
                grid-template-columns: 1fr 1fr 1fr; /*3 columns, equal width */
            }
            .container { /* Optionally increase container width for 3 columns to breathe */
                max-width: 1200px;
            }
        }


        /* Department Cards */
        .department-card {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden; 
            display: flex;
            flex-direction: column; 
        }

        .department-header {
            display: flex;
            align-items: center;
            padding: 20px 25px;
            background-color: #34495e;
            color: #ffffff;
            cursor: pointer;
            transition: background-color 0.3s ease;
            user-select: none; /* Prevent text selection */
            flex-shrink: 0; /* Prevents header from shrinking */
        }

        .department-header:hover {
            background-color: #4a647e;
        }

        .department-icon {
            font-size: 1.8em;
            margin-right: 15px;
            color: #ecf0f1;
        }

        .department-header h2 {
            margin: 0;
            font-size: 1.6em;
            flex-grow: 1; /* Allows the title to take available space */
        }

        .toggle-icon {
            font-size: 1.2em;
            transition: transform 0.3s ease;
        }

        /* JavaScript Class for Active Header */
        .department-card.active .department-header {
            background-color: #1abc9c; /* color when active */
        }

        .department-card.active .toggle-icon {
            transform: rotate(180deg);
        }

        .department-content {
            padding: 0 25px;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.5s ease-out, padding 0.5s ease-out;
            background-color: #fcfcfc;
            flex-grow: 1; /* Allows content to take remaining height in flex container */
            display: flex; 
            flex-direction: column; /* Stack its children */
            justify-content: space-between; /* Pushes the "View More" button to the bottom */
        }

        /* JavaScript Class for Active Content */
        .department-card.active .department-content {
            max-height: 1000px; 
            padding: 25px;
        }

        .department-content p {
            margin-bottom: 15px;
            font-size: 1.05em;
        }

        .department-content h3 {
            color: #2c3e50;
            margin-top: 20px;
            margin-bottom: 10px;
            font-size: 1.3em;
        }

        .department-content ul {
            list-style-type: disc;
            margin-left: 25px;
            margin-bottom: 20px;
            padding: 0;
        }

        .department-content ul li {
            margin-bottom: 8px;
        }

        .department-image {
            text-align: center;
            margin-top: 25px;
            margin-bottom: 15px;
        }

        .department-image img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        /* --- View More Button Styling --- */
        .view-more-button {
            display: inline-block; /* Makes it behave like a block but respects content width */
            background-color: #1abc9c; 
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none; 
            font-weight: bold;
            text-align: center;
            margin-top: 20px; 
            margin-bottom: 0; 
            transition: background-color 0.3s ease, transform 0.2s ease;
            align-self: flex-end; /* Pushes the button to the bottom right within its flex container */
        }

        .view-more-button:hover {
            background-color: #16a085; 
            transform: translateY(-2px);
        }
        
        .msg-altern{
            color:#007bff;
            background-color: #ffffff;
            text-align: center;
            font-family:'';
            font-size: 160%;
            border:2px solid color:#bedbf9;
            border-radius: 10px;
        }

        /* Footer */
        footer {
            background-color: #2c3e50;
            color: #ffffff;
            text-align: center;
            padding: 20px 0;
            margin-top: 40px;
        }

        footer p {
            margin: 0;
            font-size: 0.9em;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            header h1 {
                font-size: 2em;
            }

            .department-header {
                flex-direction: column;
                align-items: flex-start;
                padding: 15px 20px;
            }

            .department-header h2 {
                font-size: 1.4em;
                margin-top: 10px;
            }

            .department-icon {
                margin-right: 0;
                margin-bottom: 10px;
            }

            .toggle-icon {
                position: absolute;
                right: 20px;
                top: 20px;
            }

            .department-content {
                padding: 0 20px;
            }

            .department-card.active .department-content {
                padding: 20px;
            }
        }

        @media (max-width: 480px) {
            header h1 {
                font-size: 1.8em;
            }
            header p {
                font-size: 1em;
            }
            .department-header h2 {
                font-size: 1.2em;
            }
            .department-icon {
                font-size: 1.5em;
            }
            .toggle-icon {
                font-size: 1em;
                top: 15px;
                right: 15px;
            }
            .department-content {
                font-size: 0.95em;
            }
            .department-content h3 {
                font-size: 1.1em;
            }
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
        <a href="#home" class="logo">
            <img src="images/CMFI Logo.png" alt="CMFI Logo">
        </a>
        <div class="hamburger" id="hamburgerMenu">
            <i class="fas fa-bars"></i> </div>
        <ul class="nav-links" id="navLinks">
            <li><a href="{{route('home')}}" class="active">Home</a></li>
            <li><a href="{{route('about')}}" class="">About</a></li>
            <li><a href="{{route('blog')}}">Blog</a></li>
            <li><a href="{{route('contact')}}">Contact</a></li>
            <li><a href="{{route('identification.form')}}"><i class="fas fa-user"></i></a></li>

        </ul>
    </nav>
    <header>
        <div class="container">
            <h1 style="margin-top: 0;
            font-size: 2.8em;
            margin-bottom: 15px;color:#ecf0f1">Our Departments</h1>
            <p>Welcome to our "Departments" page, your gateway to understanding the diverse teams that power ZTF Foundation's success. Explore each section to learn more about the vital functions performed by our dedicated professionals.</p>
        </div>
    </header>

    <main class="container">
        <section class="departments-grid">
            @forelse ($allDepts as $dept)
            <div class="department-card">
                <div class="department-header">
                    <i class="fas fa-hands-praying department-icon"></i>
                    <h2>{{$dept->name}}</h2>
                    <span class="toggle-icon fas fa-chevron-down"></span>
                </div>
                <div class="department-content">
                    <div>
                        <p><strong>Overview:</strong> {{$dept->description}}</p>
                    </div>
                </div>
            </div>
            @empty
                <center><div class="div-msg-altern"><p class="msg-altern">Aucun Departement pour le moment</p> </div> </center>           
            @endforelse
        </section>
        <i class="fas fa-comments" style="
            position: fixed;
            bottom: 33px; /* Adjusted to be slightly higher */
            right: 30px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            font-size: 2em;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            transition: background-color 0.3s ease, transform 0.3s ease;
            z-index: 10000; /* Ensure it's above everything else */"></i>

    
    </main>
    
    <footer>
        <div class="container">
            <p>&copy; 2025 ZTF Foundation. All rights reserved.</p>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const departmentHeaders = document.querySelectorAll('.department-header');

            departmentHeaders.forEach(header => {
                header.addEventListener('click', function() {
                    const departmentCard = this.closest('.department-card');
                    const departmentContent = departmentCard.querySelector('.department-content');

                    // Toggle the 'active' class on the department-card
                    departmentCard.classList.toggle('active');

                    // Set the max-height for smooth transition
                    if (departmentCard.classList.contains('active')) {
                        // When active, set max-height to scrollHeight to allow content to show
                        departmentContent.style.maxHeight = departmentContent.scrollHeight + 'px';
                    } else {
                        // When deactivating, set max-height back to 0
                        departmentContent.style.maxHeight = '0';
                    }

                    // Optional: Close other open accordions
                    departmentHeaders.forEach(otherHeader => {
                        const otherCard = otherHeader.closest('.department-card');
                        if (otherCard !== departmentCard && otherCard.classList.contains('active')) {
                            otherCard.classList.remove('active');
                            otherCard.querySelector('.department-content').style.maxHeight = '0';
                        }
                    });
                });
            });
        });
    </script>
</body>
</html>