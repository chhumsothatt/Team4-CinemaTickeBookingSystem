<?php

session_start();
include("../include/header.php");
include("../include/navbar.php");
?>

<div class="filmstrip"></div>

<main class="container">

  <!-- PAGE HEADER -->
  <section class="py-5">
    <h2 class="font-display fs-1 mb-2">ទំនាក់ទំនង</h2>
    <p class="text-muted mb-0">មានចម្ងល់ ឬត្រូវការជំនួយ? ក្រុមការងារ ETEC CINEMA រង់ចាំទទួលសាររបស់អ្នក។</p>
  </section>

  <!-- CONTACT INFO CARDS -->
  <section class="pb-5">
    <div class="row g-4">
      <div class="col-12 col-md-6">
        <a href="https://t.me/+2gEnLVh7ItxmYTg9" class="nav-link" target="_blank">
          <div class="card border h-100 shadow-sm p-4 text-center" style="border-color:var(--surface-line);">
            <div class="text-marquee fs-2 mb-2">
              <i class="bi bi-telegram"></i>
            </div>
            <h5 class="font-display fs-4 mb-2 nav-link">តេឡេក្រាម</h5>
            <p class="text-muted small mb-0 nav-link">@ETEC-CINEMA-MOVIE</p>
          </div>
        </a>
      </div>
      <div class="col-12 col-md-6">
        <div class="card border h-100 shadow-sm p-4 text-center" style="border-color:var(--surface-line);">
          <div class="text-marquee fs-2 mb-2">
            <i class="bi bi-envelope-fill"></i>
          </div>
          <h5 class="font-display fs-4 mb-2">អ៊ីមែល</h5>
          <p class="text-muted small mb-0 font-mono">etec_cinema@gmail.com</p>
        </div>
      </div>
    </div>
  </section>

  <!-- CONTACT FORM + HOURS -->
  <section class="pb-5" id="contact-form">
    <div class="card border shadow-sm p-3 p-md-4" style="border-color:var(--surface-line);">
      <div class="row g-4">

        <!-- FORM -->
        <div class="col-12 col-md-7">
          <h3 class="font-display fs-2 mb-4">ផ្ញើសារមកកាន់យើង</h3>

          <?php if (isset($_SESSION['contact_success'])): ?>
            <div class="alert alert-success" role="alert">
              សាររបស់អ្នកត្រូវបានផ្ញើដោយជោគជ័យ! យើងនឹងឆ្លើយតបក្នុងពេលឆាប់ៗនេះ។
            </div>
            <?php unset($_SESSION['contact_success']); ?>
          <?php endif; ?>

          <form action="../api/contact_handler.php" method="POST">
            <div class="row g-3">
              <div class="col-12 col-sm-6">
                <label for="cName" class="form-label small text-muted">ឈ្មោះពេញ</label>
                <input type="text" class="form-control" id="cName" name="name" placeholder="សូមបញ្ចូលឈ្មោះ" required>
              </div>
              <div class="col-12 col-sm-6">
                <label for="cEmail" class="form-label small text-muted">អ៊ីមែល</label>
                <input type="email" class="form-control" id="cEmail" name="email" placeholder="you@example.com" required>
              </div>
              <div class="col-12">
                <label for="cSubject" class="form-label small text-muted">ប្រធានបទ</label>
                <input type="text" class="form-control" id="cSubject" name="subject" placeholder="តើអ្នកចង់ជួយអំពីអ្វី?" required>
              </div>
              <div class="col-12">
                <label for="cMessage" class="form-label small text-muted">សារ</label>
                <textarea class="form-control" id="cMessage" name="message" rows="5" placeholder="សរសេរសាររបស់អ្នកនៅទីនេះ..." required></textarea>
              </div>
              <div class="col-12 d-flex justify-content-end">
                <button type="submit" class="btn btn-velvet btn-lg px-4">ផ្ញើសារ</button>
              </div>
            </div>
          </form>
        </div>

        <!-- OPENING HOURS / SOCIAL -->
        <div class="col-12 col-md-5 border-start-md ps-md-4" style="border-color:var(--surface-line);">
          <h3 class="font-display fs-2 mb-4">ម៉ោងបើកសេវា</h3>

          <div class="dashed-row d-flex justify-content-between py-2 small">
            <span class="text-muted">ច័ន្ទ - សុក្រ</span>
            <span class="font-mono fw-semibold">10:00 AM - 11:00 PM</span>
          </div>
          <div class="dashed-row d-flex justify-content-between py-2 small">
            <span class="text-muted">សៅរ៍ - អាទិត្យ</span>
            <span class="font-mono fw-semibold">09:00 AM - 12:00 AM</span>
          </div>
          <div class="d-flex justify-content-between py-2 small">
            <span class="text-muted">ថ្ងៃបុណ្យ</span>
            <span class="font-mono fw-semibold">10:00 AM - 12:00 AM</span>
          </div>

          <h3 class="font-display fs-2 mb-3 mt-4">តាមដានយើង</h3>
          <div class="d-flex gap-2 flex-wrap">
            <a href="#" class="badge badge-tag rounded-pill px-3 py-2 text-decoration-none">
              <i class="bi bi-facebook me-1"></i>Facebook
            </a>
            <a href="#" class="badge badge-tag rounded-pill px-3 py-2 text-decoration-none">
              <i class="bi bi-telegram me-1"></i>Telegram
            </a>
            <a href="#" class="badge badge-tag rounded-pill px-3 py-2 text-decoration-none">
              <i class="bi bi-instagram me-1"></i>Instagram
            </a>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- MAP -->
  <section class="pb-5">
    <div class="card border shadow-sm overflow-hidden" style="border-color:var(--surface-line);">
      <iframe
        src="https://www.google.com/maps?q=Phnom%20Penh&output=embed"
        width="100%"
        height="320"
        style="border:0;"
        allowfullscreen=""
        loading="lazy"
        referrerpolicy="no-referrer-when-downgrade">
      </iframe>
    </div>
  </section>

  <div class="filmstrip my-2"></div>

</main>
<?php include('../include/footer.php'); ?>

<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> -->
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
<!-- <script src="../js/client.js"></script> -->

</body>
</html>