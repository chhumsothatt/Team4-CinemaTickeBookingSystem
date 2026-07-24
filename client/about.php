<?php

session_start();
include("../include/header.php");
include("../include/navbar.php");

// TODO: replace with real DB query or update photo paths once each member's real photo is ready
$team = [
  [
    "name"  => "ឈំ សុថាត់",
    "role"  => "Team Leader",
    "photo" => "../team/sothatt.png",
  ],
  [
    "name"  => "រី រះស្មី",
    "role"  => "Team Member",
    "photo" => "../team/reaksmey.png",
  ],
  [
    "name"  => "ពុធា",
    "role"  => "Team Member",
    "photo" => "../team/thea.png",
  ],
];
?>

<div class="filmstrip"></div>

<main class="container">

  <!-- PAGE HEADER -->
  <section class="py-5">
    <h2 class="font-display fs-1 mb-2">អំពីយើង</h2>
    <p class="text-muted mb-0">ស្គាល់ក្រុមការងារដែលនៅពីក្រោយ ETEC CINEMA</p>
  </section>

  <!-- ABOUT INTRO -->
  <section class="pb-5">
    <div class="card border shadow-sm p-4 p-md-5" style="border-color:var(--surface-line);">
      <h3 class="font-display fs-2 mb-3">ETEC CINEMA</h3>
      <p class="text-muted mb-0">
        ETEC CINEMA គឺជាប្រព័ន្ធកក់សំបុត្រភាពយន្តអនឡាញ ដែលបង្កើតឡើងដោយ <span class="text-marquee fw-semibold">Team 4</span>
        សម្រាប់ជួយសម្រួលដល់ការកក់សំបុត្រភាពយន្តឲ្យកាន់តែងាយស្រួល រហ័ស និងទាន់សម័យ។
      </p>
    </div>
  </section>

  <!-- TEAM MEMBERS -->
  <section class="pb-5" id="team">
    <h3 class="font-display fs-2 mb-4">ក្រុមការងាររបស់យើង</h3>
    <div class="row g-4">
      <?php foreach ($team as $member): ?>
      <div class="col-12 col-md-4">
        <div class="card border shadow-sm h-100 text-center overflow-hidden" style="border-color:var(--surface-line);">
          <img src="<?= htmlspecialchars($member['photo']) ?>" class="w-100 " salt="<?= htmlspecialchars($member['name']) ?>">
          <div class="p-4">
            <h5 class="font-display fs-3 mb-1"><?= htmlspecialchars($member['name']) ?></h5>
            <span class="badge badge-tag rounded-pill px-3 py-2 font-mono small"><?= htmlspecialchars($member['role']) ?></span>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </section>

  <div class="filmstrip my-2"></div>

</main>

<footer class="text-center text-muted small py-5 border-top" style="border-color:var(--surface-line) !important;">
  © 2026 ETEC CINEMA — Cinema Ticket Booking System · Team 4
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  $(document).ready(function(){
    $('#btnLogout').click(function(){
      $.ajax({
        url: '../api/auth_handler.php',
        method: 'POST',
        dataType: 'json',
        data: {action: 'logout'},
        success: function(){
          window.location.href = '../login.php';
        }
      })

    })
  })
</script>


</body>
</html>