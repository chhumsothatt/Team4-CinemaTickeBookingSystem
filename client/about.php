<?php 

session_start();
include("../include/header.php");
include("../include/navbar.php");
?>

<div class="filmstrip"></div>


<main class="container">

  <!-- BOOKING PANEL -->
  <section class="py-5" id="booking">
    <h2 class="font-display fs-1 mb-4">ព័ត៌មានលម្អិត</h2>
    <div class="card border shadow-sm p-3 p-md-4" style="border-color:var(--surface-line);">
      <div class="row g-4 mb-4">
        <div class="col-12 col-md-4">
            <div>
                <img src="../upload/image.png" class="w-100 object-fit-cover rounded-3" alt="">
            </div>
        </div>
        <div class="col-12 col-md-8">
          <h3 class="font-display fs-1">Superman</h3>
          <p class="text-muted mb-3">សុភវីរបុរសមកពី Krypton ត្រូវប្រយុទ្ធដើម្បីការពារពិភពលោក ខណៈគាត់ស្វែងរកអត្តសញ្ញាណពិតរបស់ខ្លួន។</p>
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