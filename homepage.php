<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'includes/db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Lost & Found</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<?php include 'includes/header.php'; ?>

<div class="container mt-4">
    <!-- Single Hero Section -->
    <div class="hero text-center animate-fade mb-5">
        <h1 class="display-4 fw-bold">Smart Lost & Found Portal</h1>
        <p class="lead">Report lost or found items and let our system help reunite them with owners</p>
    </div>

    <!-- Action Cards -->
    <div class="row mt-4 g-4">
        <div class="col-md-6">
            <div class="card card-special h-100">
                <div class="card-body text-center">
                    <i class="fas fa-question-circle display-4 mb-3 text-primary"></i>
                    <h5 class="card-title">Lost an Item?</h5>
                    <p class="card-text">Report it and let our system find a match.</p>
                    <a href="report-lost.php" class="btn btn-primary">Report Lost Item</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card card-special h-100">
                <div class="card-body text-center">
                    <i class="fas fa-check-circle display-4 mb-3 text-success"></i>
                    <h5 class="card-title">Found an Item?</h5>
                    <p class="card-text">Help someone by reporting a found item.</p>
                    <a href="report-found.php" class="btn btn-success">Report Found Item</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Single Matches Button with increased bottom margin -->
    <div class="text-center mt-5 mb-5">  <!-- Changed mt-4 to mt-5 and added mb-5 -->
        <a href="matches.php" class="btn btn-accent">
            <i class="fas fa-heart me-2"></i>View Matches
        </a>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>