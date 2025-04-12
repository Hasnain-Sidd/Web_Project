<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container">
    <a class="navbar-brand" href="homepage.php">
      <i class="fas fa-search-location"></i> Smart Lost & Found
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <?php if(isset($_SESSION['user_id'])): ?>
          <li class="nav-item">
            <a class="nav-link" href="homepage.php"><i class="fas fa-home"></i> Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="report-lost.php"><i class="fas fa-question-circle"></i> Report Lost</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="report-found.php"><i class="fas fa-check-circle"></i> Report Found</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="matches.php"><i class="fas fa-heart"></i> Matches</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
          </li>
        <?php else: ?>
          <li class="nav-item">
            <a class="nav-link" href="login.php"><i class="fas fa-sign-in-alt"></i> Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="register.php"><i class="fas fa-user-plus"></i> Register</a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>