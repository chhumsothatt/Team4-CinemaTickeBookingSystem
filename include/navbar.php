<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg sticky-top py-3">
  <div class="container">
    <a class="navbar-brand font-display fs-3 d-flex align-items-center gap-2" href="index.php">
      <span class="bulb"></span><span class="text-marquee">ETEC</span><span class="fs-6 fw-normal ms-1">CINEMA</span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navMain">
<?php 
  // Get the current running PHP filename
  $currentPage = basename($_SERVER['PHP_SELF']); 
?>

<ul class="navbar-nav mx-auto gap-lg-4 fw-semibold text-center">
  <li class="nav-item">
    <a class="nav-link <?= ($currentPage === 'index.php') ? 'active' : '' ?>" href="index.php">ភាពយន្ត</a>
  </li>
  <li class="nav-item">
    <a class="nav-link <?= ($currentPage === 'booking_history.php') ? 'active' : '' ?>" href="booking_history.php">ប្រវត្តិការកក់</a>
  </li>
  <li class="nav-item">
    <a class="nav-link <?= ($currentPage === 'contact.php') ? 'active' : '' ?>" href="contact.php">ទំនាក់ទំនង</a>
  </li>
  <li class="nav-item">
    <a class="nav-link <?= ($currentPage === 'about.php') ? 'active' : '' ?>" href="about.php">អំពីយើង</a>
  </li>
</ul>
<div class="d-flex gap-2 mt-3 mt-lg-0">
  <?php 
  if (!isset($_SESSION['user_id'])) { 
      echo '<a href="../login.php" class="btn btn-outline-cinema px-3">ចូល / Login</a>
            <a href="../register.php" class="btn btn-marquee px-3">ចុះឈ្មោះ</a>';
  } else {
      echo '<a id="btnLogout" class="btn btn-danger px-3">ចេញ / Logout</a>';
      if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') {
          echo '<a href="../admin/dashboard.php" class="btn btn-primary border-0 px-3">Dashboard</a>';
      }
  }
  ?>
</div>
    </div>
  </div>
</nav>

