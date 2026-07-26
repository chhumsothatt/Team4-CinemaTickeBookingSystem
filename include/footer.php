<style>

    .link-light-muted {
  color: var(--bs-secondary-color, #adb5bd);
  transition: color .15s ease;
}
.link-light-muted:hover {
  color: var(--gold, #d4a94c); /* ប្តូរតាមពណ៌ gold branding របស់ project */
}
footer .btn.rounded-circle {
  color: var(--bs-secondary-color, #adb5bd);
  border-color: var(--surface-line);
  transition: all .15s ease;
}
footer .btn.rounded-circle:hover {
  color: #fff;
  background: var(--gold, #d4a94c);
  border-color: var(--gold, #d4a94c);
}
</style>


<footer class="pt-5 mt-5 border-top" style="background:var(--surface-2, #0f0f100d); border-color:var(--surface-line) !important;">
  <div class="container">

    <div class="row gy-4 pb-4">

      <!-- Brand -->
      <div class="col-12 col-md-4">
        <div class="d-flex align-items-center gap-2 mb-3">
          <span class="fs-3">
            <img src="../team/logo.png" class="rounded-circle" style="width:50px;height:50px;" alt="">
          </span>
          <span class="font-display fs-4 text-marquee">ETEC CINEMA</span>
        </div>
        <p class="text-muted small mb-3">
          ប្រព័ន្ធកក់សំបុត្រភាពយន្តអនឡាញ ដែលជួយឲ្យការទស្សនាភាពយន្តរបស់អ្នកកាន់តែងាយស្រួល រហ័ស និងទាន់សម័យ។
        </p>
        <div class="d-flex gap-2">
          <a href="#" class="btn btn-sm rounded-circle border" style="width:38px;height:38px;" aria-label="Facebook">
            <i class="bi bi-facebook"></i>
          </a>
          <a href="#" class="btn btn-sm rounded-circle border" style="width:38px;height:38px;" aria-label="Telegram">
            <i class="bi bi-telegram"></i>
          </a>
          <a href="#" class="btn btn-sm rounded-circle border" style="width:38px;height:38px;" aria-label="Instagram">
            <i class="bi bi-instagram"></i>
          </a>
        </div>
      </div>

      <!-- Quick Links -->
      <div class="col-6 col-md-2">
        <h6 class="font-display mb-3 text-uppercase small">តំណភ្ជាប់</h6>
        <ul class="list-unstyled small d-flex flex-column gap-2">
          <li><a href="../client/index.php" class="link-light-muted text-decoration-none">ភាពយន្ត</a></li>
          <li><a href="../client/booking_history.php" class="link-light-muted text-decoration-none">ប្រវត្តិការកក់</a></li>
          <li><a href="../client/contact.php" class="link-light-muted text-decoration-none">ទំនាក់ទំនង</a></li>
          <li><a href="../client/about.php" class="link-light-muted text-decoration-none">អំពីយើង</a></li>
        </ul>
      </div>

      <!-- Support -->
      <div class="col-6 col-md-3">
        <h6 class="font-display mb-3 text-uppercase small">ជំនួយ</h6>
        <ul class="list-unstyled small d-flex flex-column gap-2">
          <li><a href="#" class="link-light-muted text-decoration-none">សំណួរញឹកញាប់</a></li>
          <li><a href="#" class="link-light-muted text-decoration-none">លក្ខខណ្ឌប្រើប្រាស់</a></li>
          <li><a href="#" class="link-light-muted text-decoration-none">គោលការណ៍ឯកជនភាព</a></li>
        </ul>
      </div>

      <!-- Contact -->
      <div class="col-12 col-md-3">
        <h6 class="font-display mb-3 text-uppercase small">ទំនាក់ទំនង</h6>
        <ul class="list-unstyled small d-flex flex-column gap-2 text-muted">
          <li><i class="bi bi-geo-alt me-2"></i>ភ្នំពេញ, កម្ពុជា</li>
          <li><i class="bi bi-telephone me-2"></i>012 345 678</li>
          <li><i class="bi bi-envelope me-2"></i>support@eteccinema.com</li>
        </ul>
      </div>

    </div>

    <div class="filmstrip"></div>

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2 py-4 text-muted small">
      <span>© <?= date("Y") ?> ETEC CINEMA — Cinema Ticket Booking System · Team 4</span>
      <span>បង្កើតដោយ <span class="text-marquee fw-semibold">Team 4</span> ✦ ETEC Center</span>
    </div>

  </div>
</footer>