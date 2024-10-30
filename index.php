<?php include("assets/include/header.php"); ?>
    <title>Trackit - Stay Organized</title>
<body class="bg-black text-light">

<section class="hero d-flex align-items-center justify-content-center text-center" style="min-height: 100vh; background: linear-gradient(rgba(0, 0, 0, 0.5),rgba(0, 0, 0, 0.5)), url("assets/images/hero.jpg");">
    <div class="container d-flex flex-column flex-md-row align-items-center justify-content-between">
        
        <div class="hero-content">
            <h1 class="display-4 fw-bold mb-4 gradient-text">Manage Your Tasks Easily with Trackit</h1>
            <p class="lead mb-4 text-secondary">Your personal productivity tool to keep track of tasks, stay organized, and achieve more!</p>
            <div>
                <a href="register.php" class="btn btn-gradient btn-lg mx-2">Get Started</a>
                <a href="login.php" class="btn btn-outline-light btn-lg mx-2">Login</a>
            </div>
        </div>

        <div class="features-section text-start mt-5 mt-md-0">
            <h2 class="display-6 mb-4 gradient-text">Why Choose Trackit?</h2>
            <div class="row text-start">
                <div class="col-12 mb-4">
                    <div class="feature-icon mb-2">
                        <i class="bi bi-list-task text-gradient"></i>
                    </div>
                    <h5 class="text-light">Organize Your Tasks</h5>
                    <p class="text-secondary">Easily categorize and organize tasks based on priority or category.</p>
                </div>
                <div class="col-12 mb-4">
                    <div class="feature-icon mb-2">
                        <i class="bi bi-bar-chart-fill text-gradient"></i>
                    </div>
                    <h5 class="text-light">Track Your Progress</h5>
                    <p class="text-secondary">Stay on top of your progress and never miss a deadline.</p>
                </div>
                <div class="col-12 mb-4">
                    <div class="feature-icon mb-2">
                        <i class="bi bi-bell-fill text-gradient"></i>
                    </div>
                    <h5 class="text-light">Set Reminders</h5>
                    <p class="text-secondary">Get timely reminders for tasks to stay productive and focused.</p>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include('assets/include/footer.php')?>