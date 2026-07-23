<?php 
session_start();
include("../include/header.php");
include("../include/navbar.php");
?>

<div class="filmstrip"></div>

<!-- HERO -->
<section class="hero" id="top" style="hieght: 50vh; margin-top: -200px;">
  <!-- <span class="ribbon">NOW SHOWING</span> -->
  <div class="container pb-5 pt-5">
    <div class="text-marquee fw-bold small text-uppercase mb-2" style="letter-spacing:2px;">
      <i class="bi bi-circle-fill" style="font-size:8px;"></i> Room A · 7:30 PM Tonight
    </div>
    <h1 class="font-display mb-3">SUPERMAN</h1>
    <div class="d-flex flex-wrap gap-3 align-items-center mb-4 text-muted">
      <span class="badge badge-tag rounded-pill px-3 py-2">Action</span>
      <span><strong class="text-dark">128</strong> នាទី</span>
      <span>Release <strong class="text-dark">25/07/2026</strong></span>
    </div>
    <div class="d-flex gap-2">
      <a href="booking.php" class="btn btn-velvet btn-lg px-4">កក់សំបុត្រឥឡូវនេះ</a>
      <button class="btn btn-outline-cinema btn-lg px-4">មើល Trailer</button>
    </div>
  </div>
</section>

<main class="container">

<div class="row g-3 py-5" >
  <div class="col-md-6">
    <div class="input-group">
      <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
      <input type="text" id="movieSearch" class="form-control border-start-0" placeholder="ស្វែងរកភាពយន្ត... ឧ. Spi" oninput="liveSearch()">
    </div>
  </div>
  <div class="col-md-3">
    <select id="catFilter" class="form-select" onchange="liveSearch()">

    </select>
  </div>

  <div class="col-12"><small class="text-muted" id="search-status"></small></div>
</div>

<!-- MOVIE GRID -->
<div class="d-flex justify-content-between align-items-baseline mb-4">
  <h2 class="font-display fs-1 mb-0">កំពុងបញ្ចាំង</h2>

  <span class="text-muted font-mono small" id="resultCount">0 movies</span>

</div>

<div class="row g-4" id="catebody">
  <div class="col-12 text-center py-5">
    <div class="spinner-border text-warning" role="status">
      <span class="visually-hidden">Loading...</span>
    </div>
  </div>
</div>

  <div class="filmstrip my-2"></div>

  <!-- BOOKING PANEL -->
  <section class="py-5" >
    <h2 class="font-display fs-1 mb-4">ជ្រើសរើសកៅអី</h2>
    <div class="card border shadow-sm p-3 p-md-4" style="border-color:var(--surface-line);">
      <div class="row g-4 mb-4">
        <div class="col-auto">
          <div class="poster-wrap rounded" style="width:150px; background-image:url('https://images.unsplash.com/photo-1478720568477-152d9b164e26?w=400&q=60')"></div>
        </div>
        <div class="col">
          <h3 class="font-display fs-1">Superman</h3>
          <p class="text-muted mb-3" style="max-width:600px;">សុភវីរបុរសមកពី Krypton ត្រូវប្រយុទ្ធដើម្បីការពារពិភពលោក ខណៈគាត់ស្វែងរកអត្តសញ្ញាណពិតរបស់ខ្លួន។</p>
          <div class="d-flex gap-2 flex-wrap mb-3">
            <span class="badge badge-tag rounded-pill px-3 py-2">Action</span>
            <span class="badge badge-tag rounded-pill px-3 py-2">Room A</span>
            <span class="badge badge-tag rounded-pill px-3 py-2">25/07/2026</span>
          </div>
          <div class="btn-group flex-wrap" role="group">
            <input type="radio" class="btn-check" name="showtime" id="st1" checked>
            <label class="btn btn-outline-cinema font-mono" for="st1">1:00 PM</label>
            <input type="radio" class="btn-check" name="showtime" id="st2">
            <label class="btn btn-outline-cinema font-mono" for="st2">4:15 PM</label>
            <input type="radio" class="btn-check" name="showtime" id="st3">
            <label class="btn btn-outline-cinema font-mono" for="st3">7:30 PM</label>
            <input type="radio" class="btn-check" name="showtime" id="st4">
            <label class="btn btn-outline-cinema font-mono" for="st4">10:00 PM</label>
          </div>
        </div>
      </div>

      <div class="screen-arc"></div>
      <p class="text-center small text-muted mb-4" style="letter-spacing:4px;">SCREEN</p>
      <div class="seat-map mb-4" id="seatMap"></div>
      <div class="d-flex justify-content-center gap-4 small text-muted mb-4">
        <span><i class="legend-swatch" style="background:#e9e3d6"></i> ទំនេរ</span>
        <span><i class="legend-swatch" style="background:var(--marquee)"></i> បានជ្រើសរើស</span>
        <span><i class="legend-swatch" style="background:#f0cdd0"></i> បានកក់រួច</span>
      </div>

      <div class="d-flex flex-wrap justify-content-between align-items-center border-top pt-4" style="border-color:var(--surface-line) !important;">
        <div class="text-muted">
          សរុប (<span id="seatCount">0</span> កៅអី)
          <div class="font-mono fs-3 text-marquee fw-bold" id="totalPrice">$0.00</div>
        </div>
        <button class="btn btn-velvet btn-lg px-4" data-bs-toggle="modal" data-bs-target="#ticketModal" onclick="confirmBooking()">បញ្ជាក់ការកក់</button>
      </div>
    </div>
  </section>

  <div class="filmstrip my-2"></div>

  <!-- HISTORY -->
  <section class="py-5" id="history">
    <h2 class="font-display fs-1 mb-4">ប្រវត្តិការកក់</h2>
    <div class="card border shadow-sm" style="border-color:var(--surface-line);">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead>
            <tr class="text-muted small text-uppercase">
              <th>ភាពយន្ត</th><th>ថ្ងៃ</th><th>ម៉ោង</th><th>កៅអី</th><th>ស្ថានភាព</th>
            </tr>
          </thead>
          <tbody>
            <tr><td>Spider-Verse</td><td>18/07/2026</td><td>7:30 PM</td><td class="font-mono">C4, C5</td><td><span class="badge rounded-pill" style="background:rgba(47,157,99,.15); color:#2f9d63;">Confirmed</span></td></tr>
            <tr><td>The Grudge Returns</td><td>12/07/2026</td><td>10:00 PM</td><td class="font-mono">F2</td><td><span class="badge rounded-pill" style="background:rgba(47,157,99,.15); color:#2f9d63;">Confirmed</span></td></tr>
            <tr><td>Only You</td><td>02/07/2026</td><td>4:15 PM</td><td class="font-mono">D6, D7</td><td><span class="badge rounded-pill" style="background:rgba(47,157,99,.15); color:#2f9d63;">Confirmed</span></td></tr>
          </tbody>
        </table>
      </div>
    </div>
  </section>
</main>

<footer class="text-center text-muted small py-5 border-top" style="border-color:var(--surface-line) !important;">
  © 2026 CINÉ MARQUEE — Cinema Ticket Booking System · Team 4
</footer>

<!-- TICKET MODAL -->
<div class="modal fade" id="ticketModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg overflow-hidden" style="border-radius:12px;">
      <div class="d-flex">
        <div class="flex-grow-1 p-4 position-relative">
          <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal"></button>
          <div class="text-marquee fw-bold small mb-2" style="letter-spacing:2px;">BOOKING CONFIRMED</div>
          <h3 class="font-display fs-1 mb-3">Superman</h3>
          <div class="dashed-row d-flex justify-content-between py-2 small"><span class="text-muted">Room</span><span class="font-mono fw-semibold">Room A</span></div>
          <div class="dashed-row d-flex justify-content-between py-2 small"><span class="text-muted">Date</span><span class="font-mono fw-semibold">25/07/2026</span></div>
          <div class="dashed-row d-flex justify-content-between py-2 small"><span class="text-muted">Time</span><span class="font-mono fw-semibold" id="tTime">7:30 PM</span></div>
          <div class="d-flex justify-content-between py-2 small"><span class="text-muted">Seats</span><span class="font-mono fw-semibold" id="tSeats">—</span></div>
          <div class="d-flex justify-content-between py-2 small"><span class="text-muted">Total</span><span class="font-mono fw-bold text-marquee" id="tTotal">$0.00</span></div>
        </div>
        <div class="ticket-stub"><span>ADMIT ONE</span></div>
      </div>
    </div>
  </div>
</div>

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
<script src="../js/client.js"> </script>

</body>
</html>