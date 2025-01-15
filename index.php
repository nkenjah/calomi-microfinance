<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CALOMI Microfinance</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: NiceAdmin
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Updated: Apr 20 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
  <style>
    .carousel-caption {
      background: rgba(0, 0, 0, 0.5);
      padding: 20px;
      border-radius: 10px;
    }
    .sticky-top {
      position: sticky;
      top: 0;
      z-index: 1020;
    }
    .card {
      transition: transform 0.3s ease;
    }
    .card:hover {
      transform: translateY(-10px);
    }
    .bg-success-tuble {
      background-color: #d4edda; /* Example color */
    }
    .bg-info-subtle {
      background-color: #e2f0f5; /* Example color */
    }
    .bg-success-subtle {
      background-color: #c3e6cb; /* Example color */
    }
  </style>
</head>
<body>
  <!-- Header -->
  <header class="sticky-top">
    <nav class="navbar navbar-expand-lg navbar-dark bg-success shadow-sm">
      <div class="container">
        <a class="navbar-brand" href="#">
          <img src="Artboard 1@720x-8-2.png" alt="CALOMI Microfinance Logo" style="width: 280px; max-height: 120px;">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item"><a class="nav-link" href="#about">About Us</a></li>
            <li class="nav-item"><a class="nav-link" href="#services">Services</a></li>
            <li class="nav-item"><a class="nav-link" href="#eligibility">Eligibility</a></li>
            <li class="nav-item"><a class="nav-link" href="#contact">Contact Us</a></li>
          </ul>
        </div>
      </div>
    </nav>
  </header>

  <!-- Carousel Section -->
  <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
    <div class="carousel-inner">
      <!-- Slide 1 -->
      <div class="carousel-item active">
        <img src="assets/img/hero1.jpg" class="d-block w-100" alt="Empowering your financial growth">
        <div class="carousel-caption d-none d-md-block">
          <h2 class="display-4 fw-bold text-white">CALOMI Microfinance</h2>
          <p class="lead fw-bold text-white">Empowering your financial growth with tailored solutions.</p>
        </div>
      </div>
      <!-- Slide 2 -->
      <div class="carousel-item">
        <img src="assets/img/hero.jpg" class="d-block w-100" alt="Your Financial Partner">
        <div class="carousel-caption d-none d-md-block">
          <h2 class="display-4 fw-bold text-white">Your Financial Partner</h2>
          <p class="lead fw-bold text-white">Flexible loans for your business needs.</p>
        </div>
      </div>
    </div>
    <!-- Carousel Controls -->
    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>

  <!-- About Us -->
  <section id="about" class="py-5" style="background-color:rgb(231, 114, 18);">
    <div class="container">
      <h2 class="text-center mb-4 text-white">About Us</h2>
      <div class="card">
        <div class="card-body">
          <p class="text-justify">Established on December 9, 2022, CALOMI Microfinance is a registered financial institution dedicated to providing non-deposit-taking microfinance services. We cater to entrepreneurs, business owners, and employees in both governmental and non-governmental sectors.</p>
          <h4 class="mt-4">Mission Statement:</h4>
          <p class="text-justify">"At CALOMI Microfinance, our mission is to empower our clients by providing tailored financial solutions and fostering growth through flexibility, professionalism, and customer focus."</p>
          <h4 class="mt-4">Registration and Certification:</h4>
          <p class="text-justify">BRELA Registration Number: <strong>530871</strong><br>Bank of Tanzania (BOT) License: <strong>FD.56/377/01/2266</strong></p>
        </div>
      </div>
    </div>
  </section>

  <!-- Our Services -->
  <section id="services" class="bg-success py-5">
    <div class="container">
      <h2 class="text-center mb-4 text-white">Our Services</h2>
      <div class="row">
        <div class="col-md-4">
          <div class="card mb-4">
            <div class="card-body">
              <h5 class="card-title">Daily Loan (One Month)</h5>
              <p class="card-text">Loan Range: <strong>50,000 TZS to 5,000,000 TZS</strong> | Repayment Period: <strong>One month</strong></p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card mb-4">
            <div class="card-body">
              <h5 class="card-title">Weekly Loan</h5>
              <p class="card-text">Loan Range: <strong>1,000,000 TZS to 10,000,000 TZS</strong> | Repayment Period: <strong>From 12 weeks and above</strong></p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card mb-4">
            <div class="card-body">
              <h5 class="card-title">Daily Loan (Two Months)</h5>
              <p class="card-text">Loan Range: <strong>1,000,000 TZS to 10,000,000 TZS</strong> | Repayment Period: <strong>Two months</strong></p>
            </div>
          </div>
        </div>
      </div>
      <p class="mt-3 text-white"><em>Note: Registration fees vary depending on the loan amount taken by the client.</em></p>
    </div>
  </section>

  <!-- Eligibility Criteria -->
<section id="eligibility" class="py-5 bg-success-subtle">
    <div class="container">
      <h2 class="text-center mb-4 text-success">Eligibility Criteria</h2>
      <div class="row">
        <div class="col-md-9 offset-md-2">
          <p class="text-justify">To qualify for a loan, borrowers and guarantors must meet the following requirements:</p>
          <ul class="list-group">
            <li class="list-group-item">Both the borrower and guarantor must have an active business.</li>
            <li class="list-group-item">Both must possess a valid national ID or voter’s ID card.</li>
            <li class="list-group-item">Both must provide two recent passport-sized photos.</li>
            <li class="list-group-item">Both must present an introduction letter from their local government authority.</li>
            <li class="list-group-item">Both must provide an endorsement letter from their area leadership.</li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  <!-- Contact Us -->
  <section id="contact" class="py-5">
    <div class="container">
      <h2 class="text-center mb-4 text-ligth">Contact Us</h2>
      <p class="mt-4">For inquiries or to apply for a loan, please contact us:</p>
      <p>Phone: <strong>+255 742 789 424</strong></p>
      <p>With Whatsapp: <a href="https://wa.me//+255742789424">Whatsapp Us</a></p>
      <ul class="list-inline text-center">
        <li class="list-inline-item">
          <a href="https://instagram.com/calomimicrofinance" target="_blank">
            <i class="fab fa-instagram"></i> Instagram
          </a>
        </li>
        <li class="list-inline-item">
          <a href="https://facebook.com/calomimicrofinance" target="_blank">
            <i class="fab fa-facebook"></i> Facebook
          </a>
        </li>
        <li class="list-inline-item">
          <a href="https://tiktok.com/@calomimicrofinance" target="_blank">
            <i class="fab fa-tiktok"></i> TikTok
          </a>
        </li>
      </ul>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-dark text-white text-center py-3">
    <div class="container">
      <p class="mb-0">© <span id="currentYear"></span> CALOMI Microfinance. All rights reserved.</p>
      <div class="social-icons mt-2">
        <a href="https://instagram.com/calomimicrofinance" target="_blank" class="text-white">Instagram</a> |
        <a href="https://facebook.com/calomimicrofinance" target="_blank" class="text-white">Facebook</a> |
        <a href="https://tiktok.com/@calomimicrofinance" target="_blank" class="text-white">TikTok</a>
      </div>
    </div>
  </footer>

  <!-- Scripts -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
  <script>
    document.getElementById('currentYear').textContent = new Date().getFullYear();
  </script>
</body>
</html>