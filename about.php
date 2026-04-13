<?php
$pageTitle = '876JA Digital Online Teaching Resources | About Us';
$activePage = 'about';
function navActive($page, $activePage) { return $page === $activePage ? ' active' : ''; }
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="assets/css/styles.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark site-navbar sticky-top shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="index.php">876JA Digital Resources</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link<?php echo navActive('home', $activePage); ?>" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link<?php echo navActive('about', $activePage); ?>" href="about.php">About Us</a></li>
                <li class="nav-item"><a class="nav-link" href="contact.php">Contact Us</a></li>
                <li class="nav-item"><a class="nav-link<?php echo navActive('faq', $activePage); ?>" href="faq.php">FAQ</a></li>
                <li class="nav-item"><a class="nav-link<?php echo navActive('pricing', $activePage); ?>" href="pricing.php">Pricing</a></li>
                <li class="nav-item"><a class="nav-link<?php echo navActive('library', $activePage); ?>" href="library.php">Library</a></li>
                <li class="nav-item"><a class="nav-login-btn<?php echo navActive('login', $activePage); ?>" href="login.php">Login</a></li>
            </ul>
        </div>
    </div>
</nav>
<section class="page-banner">
    <div class="container">
        <h1>About Us</h1>
    </div>
</section>
<!-- Our Mission Statement frennn -->

<div class="container">

    <section>
        <h2>Our Mission</h2>
        <p>
            Our mission is to provide accessible, structured, and course-focused
            learning resources that support IT students at Northern Caribbean University 
            in both academic and career development. We aim to make IT learning more 
            manageable by helping students understand complex topics, complete assignments, 
            and prepare effectively for both exams and the IT job field through 
            well-organised study materials.
        </p>

</div>

<!-- OUR STORY SECTION
         How the company ! Who nuh love a story time -->
    <section>
        <h2 class="text-center">Our Story</h2>

        
        <div class="row align-items-center mx-5">

            <!-- Story on DA LEFT -->
            <div class="col-6">
                <p>
                    876JA Digital IT Learning Hub was founded by a group of Information 
                    Technology students who experienced firsthand the challenges of 
                    navigating complex courses at Northern Caribbean University.
                </p>
                <p>
                    During our time as students, we often found it difficult to keep up 
                    with certain topics and locate reliable study materials. Recognising 
                    that many other students faced the same struggles, we were inspired 
                    to create a solution.
                </p>
                <p>
                    Our aim is to make IT learning more manageable and accessible for 
                    future students by providing the support we once needed ourselves.
                </p>
            </div>

            <!-- Put the WHATEVER PICTURE TO DA RIGHT -->
            <div class="col-6">
                <!-- Picture of the department building-->
                <img src="assets/css/images/cis_building2.jpg" 
                     class="img-fluid rounded w-75" 
                     alt="Our Team">
            </div>

            <!-- What we offer chrattt -->
    <section>
        <h2>What We Offer</h2>

        <ul>
            <li>Course-based notes and tutorials for Programming, Web Development, Databases, and Systems Analysis.</li>
            <li>Study materials that help with assignments, coursework, and exam preparation.</li>
            <li>Resources organised by course and level which makes learning easier and more structured.</li>
            <li>Content aligned with real NCU IT programme courses including Computer Science, Information Technology, Computer Information Systems, and Cybersecurity.</li>
            <li>Exam prep materials, featured courses, and the latest uploads to keep you up to date.</li>
        </ul>

    </section>
        </div><!-- end of row -->
    </section>
    </section>

   <!-- WHY CHOOSE US SECTION -->
    <section>
        <h2>Why Choose Us</h2>

        <!-- row keeps the image and text side by side
             image on the left, text on the right -->
        <div class="row align-items-center mx-3">

            <!-- left side - the image -->
            <div class="col-6">
                <!-- Pcture of girl -->
                <img src="assets/css/images/young-teenage-girl-sitting-her-bed-studying-using-laptop.jpg" 
                     class="img-fluid rounded w-75" 
                     alt="Why Choose Us">
            </div>

           <!-- Put text on the right side -->
            <div class="col-6">
                <ul>
                    <li>876JA Digital IT Learning Hub is designed specifically with NCU IT students in mind.</li>
                    <li>Our content is aligned with real academic courses, ensuring it is relevant and useful for what students are actually studying.</li>
                    <li>We offer a simple and easy-to-use structure that makes it easy to find learning materials quickly.</li>
                    <li>Our platform supports both academic success and career readiness in the IT field.</li>
                </ul>
            </div>
    </section>

<!-- MEET THE TEAM SECTION-->
    <section>
        <h2 class="text-center">Meet the Team</h2>

        <!-- row displays all team members side by side -->
        <div class="row justify-content-center text-center">

            <!-- coloums for showing the team members-->
            <div class="col">

                <img src="https://placehold.co/90x90?text=JS" 
                     class="rounded-circle" 
                     alt="Jennisha Smith">
                <h5>Jennisha Smith</h5>
                <p>Founder & Project Manager</p>
            </div>

            <div class="col">
                <img src="assets/css/images/chevon.jpg.jpeg" 
                     class="rounded-circle" 
                     alt="Chevon Latty">
                <h5>Chevon Latty</h5>
                <p>Content Coordinator</p>
            </div>

            <div class="col">
                <img src="assets/css/images/nijae.jpg.jpeg" 
                     class="rounded-circle" 
                     alt="Nijae Bennett">
                <h5>Nijae Bennett</h5>
                <p>Systems Administrator</p>
            </div>

            <div class="col">
                <img src="assets/css/images/briana-jo.jpg.jpeg" 
                     class="rounded-circle" 
                     alt="Briana-Jo Eaton">
                <h5>Briana-Jo Eaton</h5>
                <p>User Experience & Support Lead</p>
            </div>

            <div class="col">
                <img src="assets/css/images/milan.jpg.jpeg" 
                     class="rounded-circle" 
                     alt="Milan Purushotam">
                <h5>Milan Purushotam</h5>
                <p>Content Developer</p>
            </div>

        </div><!-- end of row -->
    </section>

    <!-- GET STARTED SECTION -->
    <section>
        <h2 class="text-center">Let's Study Together</h2>

        <!-- row puts the text box and button side by side -->
        <div class="row align-items-center mx-3">

            <!-- left side - the text box -->
            <div class="col-6">
                <div class="border p-3">
                    <p>Explore 876JA Digital IT Learning Hub and access structured 
                    learning resources designed for IT students at the 
                    Northern Caribbean University.</p>
                </div>
            </div>

            <!-- right side - the register button -->
            <div class="col-6 text-center">
                <!-- navigation to the registration page -->
                <a href="register.php" class="btn btn-primary btn-lg">
                    Register Now
                </a>
            </div>

        </div>
    </section>

<footer class="footer-area"><div class="container"><div class="row g-4"><div class="col-md-4"><h5>876JA Digital Resources</h5><p>Online notes, tutorials, and teaching resources for modern classrooms.</p></div><div class="col-md-4"><h5>Quick Links</h5><p><a href="about.php">About Us</a></p><p><a href="library.php">Resource Library</a></p><p><a href="pricing.php">Subscription Plans</a></p></div><div class="col-md-4"><h5>External Links</h5><p><a href="https://www.facebook.com" target="_blank" rel="noopener">Facebook</a></p><p><a href="https://www.youtube.com" target="_blank" rel="noopener">YouTube</a></p><p><a href="https://www.paypal.com" target="_blank" rel="noopener">PayPal</a></p></div></div></div></footer><script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script></body></html>
