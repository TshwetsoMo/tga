<?php
// index.php
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>TechGeniusAcademy</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@700&family=Roboto&display=swap" rel="stylesheet">


    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <style>
        /* Updated CSS for Landing Page */

/* Root Variables */
:root {
    --primary: #0069d9; /* Blue */
    --secondary: #ffc107; /* Gold */
    --light: #f2f2f2; /* Light Gray */
    --dark: #181d38; /* Dark Blue */
}

/* General Styles */
body, html {
    height: 100%;
    margin: 0;
    padding: 0;
    font-family: 'Roboto', sans-serif;
    /* Background Image */
    background-image: url('https://static.vecteezy.com/system/resources/thumbnails/048/046/583/original/fluid-anime-school-background-with-cherry-blossom-trees-in-the-style-of-cartoon-pastel-colors-high-resolution-high-detail-high-quality-video.jpg');
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
    background-repeat: no-repeat;
    /* Overlay for Readability */
    background-color: rgba(255, 255, 255, 0.6);
    background-blend-mode: lighten;
}

h1, h2, h3, h4, h5, h6, .display-3, .section-title, .navbar-brand h2 {
    font-family: 'Orbitron', sans-serif !important;
}

/* Spinner */
#spinner {
    opacity: 0;
    visibility: hidden;
    transition: opacity .5s ease-out, visibility 0s linear .5s;
    z-index: 99999;
}

#spinner.show {
    transition: opacity .5s ease-out, visibility 0s linear 0s;
    visibility: visible;
    opacity: 1;
}

/* Buttons */
.btn {
    font-family: 'Roboto', sans-serif;
    font-weight: 600;
    transition: .5s;
    border-radius: 5px;
}

.btn-primary {
    background-color: var(--secondary);
    border: none;
    color: #000;
}

.btn-primary:hover {
    background-color: #e0a800;
    color: #000;
}

.btn-outline-light {
    color: #fff;
    border-color: #fff;
}

.btn-outline-light:hover {
    background-color: var(--secondary);
    border-color: var(--secondary);
    color: #000;
}

.btn-square, .btn-sm-square, .btn-lg-square {
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: normal;
    border-radius: 0px;
}

/* Sidebar Styles */
.sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 220px;
            background-color: rgba(0, 105, 217, 0.95);
            padding: 20px;
            border-right: 3px solid rgba(255, 193, 7, 0.8);
            overflow-y: auto;
            z-index: 1000;
        }
        .sidebar .school-logo {
            margin-bottom: 20px;
            text-align: center;
        }
        .sidebar .school-logo img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 2px solid #fafafa;
        }
        .sidebar .nav {
            flex-direction: column;
        }
        .sidebar .nav-item {
            margin-bottom: 10px;
        }
        .sidebar .nav-link {
            color: #fff;
            font-weight: 500;
            padding: 10px;
            border-radius: 5px;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background-color: rgba(255, 193, 7, 0.8);
            color: #fff;
        }
        .sidebar .nav-link i {
            margin-right: 10px;
        }
        .logout-button {
            position: absolute;
            bottom: 20px;
            left: 20px;
        }
        .logout-button a {
            color: #fff;
            text-decoration: none;
            transition: color 0.2s ease;
        }
        .logout-button a:hover {
            color: rgba(255, 193, 7, 0.8);
        }

/* Main Content */
.main-content {
    margin-left: 220px;
    padding: 0;
}

@media (max-width: 991.98px) {
    .sidebar {
        position: relative;
        width: 100%;
        height: auto;
        border-right: none;
    }

    .main-content {
        margin-left: 0;
    }
}

/* Carousel */
.header-carousel .owl-nav .owl-prev,
.header-carousel .owl-nav .owl-next {
    color: #fff;
    background: transparent;
    border: 1px solid #fff;
}

.header-carousel .owl-nav .owl-prev:hover,
.header-carousel .owl-nav .owl-next:hover {
    background: var(--secondary);
    border-color: var(--secondary);
    color: #000;
}

.header-carousel .text-primary {
    color: var(--secondary) !important;
}

.header-carousel .btn-primary {
    background-color: var(--secondary);
    border: none;
    color: #000;
}

.header-carousel .btn-primary:hover {
    background-color: #e0a800;
    color: #000;
}

.header-carousel .btn-light {
    background-color: #fff;
    color: #000;
}

.header-carousel .btn-light:hover {
    background-color: var(--secondary);
    color: #000;
}

/* Section Titles */
.section-title {
    position: relative;
    display: inline-block;
    text-transform: uppercase;
    color: var(--primary);
}

.section-title::before,
.section-title::after {
    background: var(--secondary);
}

/* Services */
.service-item {
    background: var(--light);
    transition: .5s;
    border-radius: 10px;
}

.service-item:hover {
    margin-top: -10px;
    background: var(--secondary);
    color: #fff;
}

.service-item i {
    color: var(--primary);
}

.service-item:hover i {
    color: #fff;
}

/* About Section */
.bg-white.text-start.text-primary.pe-3 {
    background: transparent !important;
    color: var(--primary) !important;
}

.about .btn-primary {
    background-color: var(--secondary);
    border: none;
    color: #000;
}

.about .btn-primary:hover {
    background-color: #e0a800;
    color: #000;
}

/* Courses */
.course-item {
    border-radius: 10px;
    overflow: hidden;
}

.course-item .btn-primary {
    background-color: var(--secondary);
    border: none;
    color: #000;
}

.course-item .btn-primary:hover {
    background-color: #e0a800;
    color: #000;
}

/* Team */
.team-item {
    border-radius: 10px;
    overflow: hidden;
}

.team-item .btn-primary {
    background-color: var(--secondary);
    border: none;
    color: #000;
}

.team-item .btn-primary:hover {
    background-color: #e0a800;
    color: #000;
}

/* Testimonial */
.testimonial-item .bg-light {
    background-color: var(--light) !important;
}

.testimonial-item .text-primary {
    color: var(--primary) !important;
}

/* Footer */
.footer {
    background-color: rgba(0, 105, 217, 0.95);
    color: #fff;
}

.footer a {
    color: #ffc107;
}

.footer a:hover {
    color: #e0a800;
}

.footer .btn-outline-light {
    border-color: #fff;
}

.footer .btn-outline-light:hover {
    background-color: var(--secondary);
    border-color: var(--secondary);
    color: #000;
}

.footer .btn.btn-link {
    color: #fff;
}

.footer .btn.btn-link:hover {
    color: var(--secondary);
}

.footer .copyright {
    border-top: 1px solid rgba(256, 256, 256, .1);
}

/* Back to Top Button */
.back-to-top {
    background-color: var(--primary);
    color: #fff;
}

.back-to-top:hover {
    background-color: var(--secondary);
    color: #000;
}

/* Miscellaneous */
.btn-square, .btn-sm-square, .btn-lg-square {
    border-radius: 50%;
}

.owl-carousel .owl-nav .owl-prev,
.owl-carousel .owl-nav .owl-next {
    background-color: var(--primary);
    color: #fff;
}

.owl-carousel .owl-nav .owl-prev:hover,
.owl-carousel .owl-nav .owl-next:hover {
    background-color: var(--secondary);
    color: #000;
}

.bg-light {
    background-color: var(--light) !important;
}

.text-primary {
    color: var(--primary) !important;
}

.bg-primary {
    background-color: var(--primary) !important;
}

.text-secondary {
    color: var(--secondary) !important;
}

.bg-secondary {
    background-color: var(--secondary) !important;
}

.border-primary {
    border-color: var(--primary) !important;
}

.border-secondary {
    border-color: var(--secondary) !important;
}

    </style>
</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->


    <!-- Sidebar Navbar Start -->
    <nav class="sidebar">
        <div class="school-logo">
            <img src="logo.png" alt="School Logo" class="img-fluid rounded-circle">
        </div>
        <ul class="navbar-nav">
            <li class="nav-item">
                <a href="index.php" class="nav-link active">Home</a>
            </li>
            <li class="nav-item">
                <a href="about.php" class="nav-link">About</a>
            </li>
            <li class="nav-item">
                <a href="courses.php" class="nav-link">Courses</a>
            </li>
            <li class="nav-item">
                <a href="contact.php" class="nav-link">Contact</a>
            </li>
        </ul>
        <div class="logout-button">
            <a href="login.php"><i class="fas fa-sign-in-alt"></i> Login</a>
        </div>
    </nav>
    <!-- Sidebar Navbar End -->

     <div class="main-content">
         <!-- Carousel Start -->
         <div class="container-fluid p-0 mb-5">
             <div class="owl-carousel header-carousel position-relative">
                 <!-- Carousel Item 1 -->
                <div class="owl-carousel-item position-relative">
                <img class="img-fluid" src="https://t4.ftcdn.net/jpg/02/00/14/63/360_F_200146338_NTWg7HF65p5z6IUIXzxJbkJ5zlEt3gnG.jpg" alt="TechGenius Academy">
                    <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center" style="background: rgba(24, 29, 56, .7);">
                        <div class="container">
                            <div class="row justify-content-start">
                                <div class="col-sm-10 col-lg-8">
                                    <h5 class="text-primary text-uppercase mb-3 animated slideInDown">Unlock the World of Technology</h5>
                                    <h1 class="display-3 text-white animated slideInDown">Your Journey to IT Mastery Begins Here</h1>
                                    <p class="fs-5 text-white mb-4 pb-2">Dive into our comprehensive IT courses designed to equip you with the skills needed in today's digital landscape. From coding to cybersecurity, we offer hands-on learning with expert instructors.</p>
                                    <a href="courses.php" class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft">Read More</a>
                                    <a href="login.php" class="btn btn-light py-md-3 px-md-5 animated slideInRight">LOGIN</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                 <div class="owl-carousel-item position-relative">
                     <img class="img-fluid" style="height: 614px" src="https://media.istockphoto.com/id/1406888053/photo/a-group-of-cheerful-people-at-graduation-holding-diplomas-or-certificates-up-together-and.jpg?s=612x612&w=0&k=20&c=8LRkx77cpb1clqj2tHqOY--uO8Mj6DB8Qd1Y3RdDRyQ=" alt="">
                     <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center" style="background: rgba(24, 29, 56, .7);">
                         <div class="container">
                             <div class="row justify-content-start">
                                 <div class="col-sm-10 col-lg-8">
                                     <h5 class="text-primary text-uppercase mb-3 animated slideInDown">Scholarships Available Now</h5>
                                     <h1 class="display-3 text-white animated slideInDown">Invest in Your Future Without Breaking the Bank</h1>
                                     <p class="fs-5 text-white mb-4 pb-2">We offer a range of scholarships and financial aid options to make quality education accessible. Apply today and take the first step towards a brighter future.</p>
                                     <a href="" class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft">Read More</a>
                                     <a href="login.php" class="btn btn-light py-md-3 px-md-5 animated slideInRight">LOGIN</a>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
         <!-- Carousel End -->
     
     
         <!-- Service Start -->
         <div class="container-xxl py-5">
             <div class="container">
                 <div class="row g-4">
                     <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">
                         <div class="service-item text-center pt-3">
                             <div class="p-4">
                                 <i class="fa fa-3x fa-graduation-cap text-primary mb-4"></i>
                                 <h5 class="mb-3">Skilled Instructors</h5>
                                 <p><p>Our instructors are seasoned professionals committed to delivering the highest quality education and mentorship.</p></p>
                             </div>
                         </div>
                     </div>
                     <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.3s">
                         <div class="service-item text-center pt-3">
                             <div class="p-4">
                                 <i class="fa fa-3x fa-globe text-primary mb-4"></i>
                                 <h5 class="mb-3">Online Classes</h5>
                                 <p>Access our courses anytime, anywhere with flexible online classes designed to fit your schedule.</p>
                             </div>
                         </div>
                     </div>
                     <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.5s">
                         <div class="service-item text-center pt-3">
                             <div class="p-4">
                                 <i class="fa fa-3x fa-home text-primary mb-4"></i>
                                 <h5 class="mb-3">Home Projects</h5>
                                 <p>Engage in hands-on projects from home to apply your learning and build a strong portfolio.</p>
                             </div>
                         </div>
                     </div>
                     <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.7s">
                         <div class="service-item text-center pt-3">
                             <div class="p-4">
                                 <i class="fa fa-3x fa-book-open text-primary mb-4"></i>
                                 <h5 class="mb-3">Book Library</h5>
                                 <p>Gain access to our extensive digital library filled with resources to supplement your learning.</p>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
         <!-- Service End -->
     
     
             <!-- About Start -->
             <div class="container-xxl py-5">
            <div class="container">
                <div class="row g-5">
                    <!-- Image Section -->
                    <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s" style="min-height: 400px;">
                        <div class="position-relative h-100">
                            <img class="img-fluid position-absolute w-100 h-100" src="img/about.jpg" alt="About TechGenius Academy" style="object-fit: cover;">
                        </div>
                    </div>
                    <!-- Content Section -->
                    <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                        <h6 class="section-title bg-white text-start text-primary pe-3">About Us</h6>
                        <h1 class="mb-4">Welcome to TechGenius Academy</h1>
                        <p class="mb-4">
                            At TechGenius Academy, we are dedicated to empowering the next generation of tech innovators. Founded in [Year], our institution has become a leading provider of cutting-edge IT education. We offer a diverse range of courses designed to equip students with the skills needed in today's rapidly evolving technological landscape.
                        </p>
                        <p class="mb-4">
                            Our mission is to make high-quality education accessible to everyone, fostering a community where learning is collaborative, engaging, and geared towards real-world applications. With a blend of theoretical knowledge and practical experience, our programs prepare students to excel in various IT fields, from software development to cybersecurity.
                        </p>
                        <div class="row gy-2 gx-4 mb-4">
                            <div class="col-sm-6">
                                <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Expert Instructors</p>
                            </div>
                            <div class="col-sm-6">
                                <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Flexible Online Learning</p>
                            </div>
                            <div class="col-sm-6">
                                <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Industry-Relevant Curriculum</p>
                            </div>
                            <div class="col-sm-6">
                                <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Global Certifications</p>
                            </div>
                            <div class="col-sm-6">
                                <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Career Development Support</p>
                            </div>
                            <div class="col-sm-6">
                                <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Innovative Learning Environment</p>
                            </div>
                        </div>
                        <a class="btn btn-primary py-3 px-5 mt-2" href="about.php">Read More</a>
                    </div>
                </div>
            </div>
        </div>

         <!-- About End -->
     
     
         <!-- Categories Start -->
         <div class="container-xxl py-5 category">
             <div class="container">
                 <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                     <h6 class="section-title bg-white text-center text-primary px-3">Categories</h6>
                     <h1 class="mb-5">Courses Categories</h1>
                 </div>
                 <div class="row g-3">
                     <div class="col-lg-7 col-md-6">
                         <div class="row g-3">
                             <div class="col-lg-12 col-md-12 wow zoomIn" data-wow-delay="0.1s">
                                 <a class="position-relative d-block overflow-hidden" href="">
                                     <img class="img-fluid" src="img/cat-1.jpg" alt="">
                                     <div class="bg-white text-center position-absolute bottom-0 end-0 py-2 px-3" style="margin: 1px;">
                                         <h5 class="m-0">Web Design</h5>
                                         <small class="text-primary">49 Courses</small>
                                     </div>
                                 </a>
                             </div>
                             <div class="col-lg-6 col-md-12 wow zoomIn" data-wow-delay="0.3s">
                                 <a class="position-relative d-block overflow-hidden" href="">
                                     <img class="img-fluid" src="img/cat-2.jpg" alt="">
                                     <div class="bg-white text-center position-absolute bottom-0 end-0 py-2 px-3" style="margin: 1px;">
                                         <h5 class="m-0">Graphic Design</h5>
                                         <small class="text-primary">49 Courses</small>
                                     </div>
                                 </a>
                             </div>
                             <div class="col-lg-6 col-md-12 wow zoomIn" data-wow-delay="0.5s">
                                 <a class="position-relative d-block overflow-hidden" href="">
                                     <img class="img-fluid" src="img/cat-3.jpg" alt="">
                                     <div class="bg-white text-center position-absolute bottom-0 end-0 py-2 px-3" style="margin: 1px;">
                                         <h5 class="m-0">Software Development</h5>
                                         <small class="text-primary">49 Courses</small>
                                     </div>
                                 </a>
                             </div>
                         </div>
                     </div>
                     <div class="col-lg-5 col-md-6 wow zoomIn" data-wow-delay="0.7s" style="min-height: 350px;">
                         <a class="position-relative d-block h-100 overflow-hidden" href="">
                             <img class="img-fluid position-absolute w-100 h-100" src="img/cat-4.jpg" alt="" style="object-fit: cover;">
                             <div class="bg-white text-center position-absolute bottom-0 end-0 py-2 px-3" style="margin:  1px;">
                                 <h5 class="m-0">Cyber Security</h5>
                                 <small class="text-primary">49 Courses</small>
                             </div>
                         </a>
                     </div>
                 </div>
             </div>
         </div>
         <!-- Categories Start -->
     
     
         <!-- Courses Start -->
         <div class="container-xxl py-5">
             <div class="container">
                 <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                     <h6 class="section-title bg-white text-center text-primary px-3">Courses</h6>
                     <h1 class="mb-5">Popular Courses</h1>
                 </div>
                 <div class="row g-4 justify-content-center">
                     <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                         <div class="course-item bg-light">
                             <div class="position-relative overflow-hidden">
                                 <img class="img-fluid" src="https://media.istockphoto.com/id/1299122459/photo/designer-team-drawing-website-ux-app-development-application-for-mobile-phone.jpg?s=612x612&w=0&k=20&c=VsvaujAvgiTa853zJQR3KDEr0X9KDKMSbgguQpOWn7o=" alt="">
                                 <div class="w-100 d-flex justify-content-center position-absolute bottom-0 start-0 mb-4">
                                     <a href="#" class="flex-shrink-0 btn btn-sm btn-primary px-3 border-end" style="border-radius: 30px 0 0 30px;">Read More</a>
                                     <a href="#" class="flex-shrink-0 btn btn-sm btn-primary px-3" style="border-radius: 0 30px 30px 0;">Join Now</a>
                                 </div>
                             </div>
                             <div class="text-center p-4 pb-0">
                                 <h3 class="mb-0">$149.00</h3>
                                 <div class="mb-3">
                                     <small class="fa fa-star text-primary"></small>
                                     <small class="fa fa-star text-primary"></small>
                                     <small class="fa fa-star text-primary"></small>
                                     <small class="fa fa-star text-primary"></small>
                                     <small class="fa fa-star text-primary"></small>
                                     <small>(123)</small>
                                 </div>
                                 <h5 class="mb-4">Web Design & Development Course for Beginners</h5>
                             </div>
                             <div class="d-flex border-top">
                                 <small class="flex-fill text-center border-end py-2"><i class="fa fa-user-tie text-primary me-2"></i>John Doe</small>
                                 <small class="flex-fill text-center border-end py-2"><i class="fa fa-clock text-primary me-2"></i>1.49 Hrs</small>
                                 <small class="flex-fill text-center py-2"><i class="fa fa-user text-primary me-2"></i>30 Students</small>
                             </div>
                         </div>
                     </div>
                     <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                         <div class="course-item bg-light">
                             <div class="position-relative overflow-hidden">
                                 <img class="img-fluid" src="https://media.istockphoto.com/id/1322517295/photo/cyber-security-it-engineer-working-on-protecting-network-against-cyberattack-from-hackers-on.jpg?s=612x612&w=0&k=20&c=htR0b1KO2UFS_R1FWiJOsPfIwf3xBtKXd7FXb4KS0Ls=" alt="">
                                 <div class="w-100 d-flex justify-content-center position-absolute bottom-0 start-0 mb-4">
                                     <a href="#" class="flex-shrink-0 btn btn-sm btn-primary px-3 border-end" style="border-radius: 30px 0 0 30px;">Read More</a>
                                     <a href="#" class="flex-shrink-0 btn btn-sm btn-primary px-3" style="border-radius: 0 30 px 30px 0;">Join Now</a>
                                 </div>
                             </div>
                             <div class="text-center p-4 pb-0">
                                 <h3 class="mb-0">$149.00</h3>
                                 <div class="mb-3">
                                     <small class="fa fa-star text-primary"></small>
                                     <small class="fa fa-star text-primary"></small>
                                     <small class="fa fa-star text-primary"></small>
                                     <small class="fa fa-star text-primary"></small>
                                     <small class="fa fa-star text-primary"></small>
                                     <small>(123)</small>
                                 </div>
                                 <h5 class="mb-4">Cyber Security Course for Beginners</h5>
                             </div>
                             <div class="d-flex border-top">
                                 <small class="flex-fill text-center border-end py-2"><i class="fa fa-user-tie text-primary me-2"></i>John Doe</small>
                                 <small class="flex-fill text-center border-end py-2"><i class="fa fa-clock text-primary me-2"></i>1.49 Hrs</small>
                                 <small class="flex-fill text-center py-2"><i class="fa fa-user text-primary me-2"></i>30 Students</small>
                             </div>
                         </div>
                     </div>
                     <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                         <div class="course-item bg-light">
                             <div class="position-relative overflow-hidden">
                                 <img class="img-fluid" src="https://www.shutterstock.com/image-photo/knowledgeable-teacher-giving-lecture-about-600nw-2326351731.jpg" alt="">
                                 <div class="w-100 d-flex justify-content-center position-absolute bottom-0 start-0 mb-4">
                                     <a href="#" class="flex-shrink-0 btn btn-sm btn-primary px-3 border-end" style="border-radius: 30px 0 0 30px;">Read More</a>
                                     <a href="#" class="flex-shrink-0 btn btn-sm btn-primary px-3" style="border-radius: 0 30px 30px 0;">Join Now</a>
                                 </div>
                             </div>
                             <div class="text-center p-4 pb-0">
                                 <h3 class="mb-0">$149.00</h3>
                                 <div class="mb-3">
                                     <small class="fa fa-star text-primary"></small>
                                     <small class="fa fa-star text-primary"></small>
                                     <small class="fa fa-star text-primary"></small>
                                     <small class="fa fa-star text-primary"></small>
                                     <small class="fa fa-star text-primary"></small>
                                     <small>(123)</small>
                                 </div>
                                 <h5 class="mb-4">Computer Science Course</h5>
                             </div>
                             <div class="d-flex border-top">
                                 <small class="flex-fill text-center border-end py-2"><i class="fa fa-user-tie text-primary me-2"></i>John Doe</small>
                                 <small class="flex-fill text-center border-end py-2"><i class="fa fa-clock text-primary me-2"></i>1.49 Hrs</small>
                                 <small class="flex-fill text-center py-2"><i class="fa fa-user text-primary me-2"></i>30 Students</small>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
         <!-- Courses End -->
     
     
         <!-- Team Start -->
         <div class="container-xxl py-5">
             <div class="container">
                 <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                     <h6 class="section-title bg-white text-center text-primary px-3">Instructors</h6>
                     <h1 class="mb-5">Expert Instructors</h1>
                 </div>
                 <div class="row g-4">
                     <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                         <div class="team-item bg-light">
                             <div class="overflow-hidden">
                                 <img class="img-fluid" src="img/team-1.jpg" alt="">
                             </div>
                             <div class="position-relative d-flex justify-content-center" style="margin-top: -23px;">
                                 <div class="bg-light d-flex justify-content-center pt-2 px-1">
                                     <a class="btn btn-sm-square btn-primary mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                                     <a class="btn btn-sm-square btn-primary mx-1" href=""><i class="fab fa-twitter"></i></a>
                                     <a class="btn btn-sm-square btn-primary mx-1" href=""><i class="fab fa-instagram"></i></a>
                                 </div>
                             </div>
                             <div class="text-center p-4">
                                 <h5 class="mb-0">Instructor Name</h5>
                                 <small>Designation</small>
                             </div>
                         </div>
                     </div>
                     <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                         <div class="team-item bg-light">
                             <div class="overflow-hidden">
                                 <img class="img-fluid" src="img/team-2.jpg" alt="">
                             </div>
                             <div class="position-relative d-flex justify-content-center" style="margin-top: -23px;">
                                 <div class="bg-light d-flex justify-content-center pt-2 px-1">
                                     <a class="btn btn-sm-square btn-primary mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                                     <a class="btn btn-sm-square btn-primary mx-1" href=""><i class="fab fa-twitter"></i></a>
                                     <a class="btn btn-sm-square btn-primary mx-1" href=""><i class="fab fa-instagram"></i></a>
                                 </div>
                             </div>
                             <div class="text-center p-4">
                                 <h5 class="mb-0">Instructor Name</h5>
                                 <small>Designation</small>
                             </div>
                         </div>
                     </div>
                     <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                         <div class="team-item bg-light">
                             <div class="overflow-hidden">
                                 <img class="img-fluid" src="img/team-3.jpg" alt="">
                             </div>
                             <div class="position-relative d-flex justify-content-center" style="margin-top: -23px;">
                                 <div class="bg-light d-flex justify-content-center pt-2 px-1">
                                     <a class="btn btn-sm-square btn-primary mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                                     <a class="btn btn-sm-square btn-primary mx-1" href=""><i class="fab fa-twitter"></i></a>
                                     <a class="btn btn-sm-square btn-primary mx-1" href=""><i class="fab fa-instagram"></i></a>
                                 </div>
                             </div>
                             <div class="text-center p-4">
                                 <h5 class="mb-0">Instructor Name</h5>
                                 <small>Designation</small>
                             </div>
                         </div>
                     </div>
                     <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.7s">
                         <div class="team-item bg-light">
                             <div class="overflow-hidden">
                                 <img class="img-fluid" src="img/team-4.jpg" alt="">
                             </div>
                             <div class="position-relative d-flex justify-content-center" style="margin-top: -23px;">
                                 <div class="bg-light d-flex justify-content-center pt-2 px-1">
                                     <a class="btn btn-sm-square btn-primary mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                                     <a class="btn btn-sm-square btn-primary mx-1" href=""><i class="fab fa-twitter"></i></a>
                                     <a class="btn btn-sm-square btn-primary mx-1" href=""><i class="fab fa-instagram"></i></a>
                                 </div>
                             </div>
                             <div class="text-center p-4">
                                 <h5 class="mb-0">Instructor Name</h5>
                                 <small>Designation</small>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
         <!-- Team End -->

    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-light footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s" style="width: 1050px; float: right; margin-right:10px">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-white mb-3">Quick Link</h4>
                    <a class="btn btn-link" href="about.php">About Us</a>
                    <a class="btn btn-link" href="contact.php">Contact Us</a>
                    <a class="btn btn-link" href="">Privacy Policy</a>
                    <a class="btn btn-link" href="">Terms & Condition</a>
                    <a class="btn btn-link" href="">FAQs & Help</a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-white mb-3">Contact</h4>
                    <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>123 Street, Pretoria, RSA</p>
                    <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+012 345 67890</p>
                    <p class="mb-2"><i class="fa fa-envelope me-3"></i>221411@virtualwindow.co.za</p>
                    <div class="d-flex pt-2">
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-twitter"></i></a>
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-youtube"></i></a>
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-white mb-3">Gallery</h4>
                    <div class="row g-2 pt-2">
                        <div class="col-4">
                            <img class="img-fluid bg-light p-1" src="img/course-1.jpg" alt="">
                        </div>
                        <div class="col -4">
                            <img class="img-fluid bg-light p-1" src="img/course-2.jpg" alt="">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid bg-light p-1" src="img/course-3.jpg" alt="">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid bg-light p-1" src="img/course-2.jpg" alt="">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid bg-light p-1" src="img/course-3.jpg" alt="">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid bg-light p-1" src="img/course-1.jpg" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-white mb-3">Newsletter</h4>
                    <p>Dolor amet sit justo amet elitr clita ipsum elitr est.</p>
                    <div class="position-relative mx-auto" style="max-width: 400px;">
                        <input class="form-control border-0 w-100 py-3 ps-4 pe-5" type="text" placeholder="Your email">
                        <button type="button" class="btn btn-primary py-2 position-absolute top-0 end-0 mt-2 me-2">SignUp</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="copyright">
                <div class="row">
                    <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                        &copy; <a class="border-bottom" href="#">TechGeniusAcademy</a>, All Right Reserved.
                        Designed By <a class="border-bottom" href="https://github.com/TshwetsoMo">Tshwetso K Mokgatlhe</a>
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        <div class="footer-menu">
                            <a href="index.php">Home</a>
                            <a href="">Cookies</a>
                            <a href="">Help</a>
                            <a href="">FQAs</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top" style="float: right"><i class="bi bi-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <script>
    (function ($) {
        "use strict";

        // Spinner
        var spinner = function () {
            setTimeout(function () {
                if ($('#spinner').length > 0) {
                    $('#spinner').removeClass('show');
                }
            }, 1);
        };
        spinner();
        
        
        // Initiate the wowjs
        new WOW().init();


        // Sticky Navbar
        $(window).scroll(function () {
            if ($(this).scrollTop() > 300) {
                $('.sticky-top').css('top', '0px');
            } else {
                $('.sticky-top').css('top', '-100px');
            }
        });
        
        
        // Dropdown on mouse hover
        const $dropdown = $(".dropdown");
        const $dropdownToggle = $(".dropdown-toggle");
        const $dropdownMenu = $(".dropdown-menu");
        const showClass = "show";
        
        $(window).on("load resize", function() {
            if (this.matchMedia("(min-width: 992px)").matches) {
                $dropdown.hover(
                function() {
                    const $this = $(this);
                    $this.addClass(showClass);
                    $this.find($dropdownToggle).attr("aria-expanded", "true");
                    $this.find($dropdownMenu).addClass(showClass);
                },
                function() {
                    const $this = $(this);
                    $this.removeClass(showClass);
                    $this.find($dropdownToggle).attr("aria-expanded", "false");
                    $this.find($dropdownMenu).removeClass(showClass);
                }
                );
            } else {
                $dropdown.off("mouseenter mouseleave");
            }
        });
        
        
        // Back to top button
        $(window).scroll(function () {
            if ($(this).scrollTop() > 300) {
                $('.back-to-top').fadeIn('slow');
            } else {
                $('.back-to-top').fadeOut('slow');
            }
        });
        $('.back-to-top').click(function () {
            $('html, body').animate({scrollTop: 0}, 1500, 'easeInOutExpo');
            return false;
        });


        // Header carousel
        $(".header-carousel").owlCarousel({
            autoplay: true,
            smartSpeed: 1500,
            items: 1,
            dots: false,
            loop: true,
            nav : true,
            navText : [
                '<i class="bi bi-chevron-left"></i>',
                '<i class="bi bi-chevron-right"></i>'
            ]
        });


        // Testimonials carousel
        $(".testimonial-carousel").owlCarousel({
            autoplay: true,
            smartSpeed: 1000,
            center: true,
            margin: 24,
            dots: true,
            loop: true,
            nav : false,
            responsive: {
                0:{
                    items:1
                },
                768:{
                    items:2
                },
                992:{
                    items:3
                }
            }
        });
        
    })(jQuery);
</script>
</body>

</html>