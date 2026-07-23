<?php 
session_start();
include("../include/header.php");
include("../include/navbar.php");
?>

<!-- <div class="filmstrip"></div> -->

<main class="container">
  <!-- BOOKING PANEL -->
  <section class="py" id="booking">
    <h2 class="font-display fs-1 ">ព័ត៌មានលម្អិត</h2>
    <div class="card border shadow-sm p-3 p-md-4" style="border-color:var(--surface-line);">
      <div class="row g-4 mb-4">
        <div class="col-12 col-md-4">
            <div>
                <img id="moviePoster" src="../upload/image.png" class="w-100 object-fit-cover rounded-3" style="height: 400px" alt="Poster">
            </div>
        </div>
        <div class="col-12 col-md-8">
          <h3 class="font-display fs-1" id="movieTitle">កំពុងផ្ទុក...</h3>
          <p class="text-muted mb-3" id="movieDesc"></p>

          <div class="d-flex gap-2 flex-wrap mb-3">
            <span>ប្រភេទ:</span>
            <span class="badge badge-tag rounded-pill px-3 py-2" id="movieCategory">--</span>
            <span>រយៈពេល:</span>
            <span class="badge badge-tag rounded-pill px-3 py-2" id="movieDuration">-- នាទី</span>
            <span>ប្រភេទរោងភាពយន្ត:</span>
            <span class="badge badge-tag rounded-pill px-3 py-2" id="movieRoom">--</span>
          </div>
            <!-- <br> -->
            <span >រឿងនេះចេញនៅថ្ងៃទី</span>
            <p class="text-danger">
                <span id="movierelease"></span>
            </p>
        <div class="text-muted">
                តម្លៃសំបុត្រ:
          <div class="font-mono fs-3 text-marquee fw-bold" id="ticket_price">$0.00</div>
        </div>

        </div>
      </div>

      <div class="d-flex flex-wrap justify-content-end align-items-center border-top pt-4" style="border-color:var(--surface-line) !important;">
        <div></div>
        <button class="btn btn-velvet btn-lg px-4" data-bs-toggle="modal" data-bs-target="#ticketModal" >កក់សំបុត្រឥឡូវនេះ</button>
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
          <h3 class="font-display fs-1 mb-3" id="mModalTitle">--</h3>
          <div class="dashed-row d-flex justify-content-between py-2 small"><span class="text-muted">Room</span><span class="font-mono fw-semibold" id="mModalRoom">--</span></div>
          <div class="dashed-row d-flex justify-content-between py-2 small"><span class="text-muted">Date & Time</span><span class="font-mono fw-semibold" id="tTime">--</span></div>
          <div class="d-flex justify-content-between py-2 small"><span class="text-muted">Price</span><span class="font-mono fw-bold text-marquee" id="tTotal">$0.00</span></div>
        </div>
        <div class="ticket-stub"><span>ADMIT ONE</span></div>
      </div>
    </div>
  </div>
</div>

<!-- <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> -->
<script src="../js/detailmovie.js"></script>
</body>
</html>