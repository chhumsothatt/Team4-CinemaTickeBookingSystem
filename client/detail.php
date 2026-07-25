<?php 
session_start();
include("../include/header.php");
include("../include/navbar.php");
?>

<style>
/* Modern Cinema UI Styling */
:root {
    --cinema-red: #E50914;
    --cinema-red-hover: #B81D24;
    --cinema-dark: #141414;
    --cinema-card-bg: #ffffff;
    --cinema-border: #E2E8F0;
}

body {
    background-color: #F8FAFC;
}

/* Movie Poster Styling */
.poster-container {
    position: relative;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    transition: transform 0.3s ease;
}

.poster-container:hover {
    transform: translateY(-4px);
}

.poster-img {
    height: 440px;
    object-fit: cover;
    width: 100%;
}

/* Booking Card */
.booking-card {
    background: var(--cinema-card-bg);
    border-radius: 20px;
    border: 1px solid var(--cinema-border);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.05);
}

/* Custom Styled Cards for Showtimes Selection */
.showtime-card-input {
    display: none;
}

.showtime-card-label {
    border: 2px solid #E2E8F0;
    border-radius: 14px;
    padding: 10px 18px;
    cursor: pointer;
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    background-color: #F8FAFC;
    text-align: center;
    min-width: 120px;
    user-select: none;
    font-weight: 600;
}

.showtime-card-label:hover {
    border-color: var(--cinema-red);
    background-color: #FFF5F5;
    transform: translateY(-2px);
}

.showtime-card-input:checked + .showtime-card-label {
    border-color: var(--cinema-red);
    background-color: var(--cinema-red);
    color: #ffffff !important;
    box-shadow: 0 6px 16px rgba(229, 9, 20, 0.3);
}

.showtime-card-input:checked + .showtime-card-label * {
    color: #ffffff !important;
}

/* Badges Styling */
.info-badge {
    background: #F1F5F9;
    color: #475569;
    font-weight: 500;
    padding: 6px 14px;
    border-radius: 50px;
    font-size: 0.875rem;
    border: 1px solid #E2E8F0;
}

.room-badge {
    background: rgba(229, 9, 20, 0.1);
    color: var(--cinema-red);
    font-weight: 700;
    padding: 6px 14px;
    border-radius: 50px;
    font-size: 0.875rem;
    border: 1px solid rgba(229, 9, 20, 0.2);
}

/* Ticket Modal Styling */
.ticket-modal-content {
    border-radius: 20px;
    background: linear-gradient(135deg, #ffffff 0%, #F8FAFC 100%);
}

.ticket-stub {
    background: #1E293B !important;
    color: #FFFFFF !important;
    border-left: 2px dashed #334155 !important;
}

.dashed-row {
    border-bottom: 1px dashed #E2E8F0;
}
</style>

<main class="container py-5">
  <!-- BOOKING PANEL -->
  <section id="booking">
    <div class="d-flex align-items-center mb-4">
      <div class="bg-danger rounded-pill me-3" style="width: 6px; height: 32px;"></div>
      <h2 class="font-display fs-2 fw-bold m-0 text-dark">ព័ត៌មានលម្អិតនៃភាពយន្ត</h2>
    </div>

    <div class="card booking-card p-4 p-lg-5">
      <div class="row g-4 g-lg-5 align-items-start">
        
        <!-- MOVIE POSTER -->
        <div class="col-4 h-100">
          <div class="poster-container h-100">
            <img id="moviePoster" src="../upload/image.png" class="poster-img h-100" alt="Poster">
          </div>
        </div>

        <!-- MOVIE DETAILS -->
        <div class="col-8 h-100">
          <h1 class="font-display display-6 fw-bold mb-3 text-dark" id="movieTitle">កំពុងផ្ទុក...</h1>
          
          <p class="text-muted lh-base mb-4 fs-6" id="movieDesc" style="min-height: 60px;"></p>

          <!-- METADATA BADGES -->
          <div class="d-flex gap-2 flex-wrap mb-4 align-items-center">
            <span class="info-badge">
              <i class="bi bi-tags me-1"></i>
              <span id="movieCategory">--</span>
            </span>
            <span class="info-badge">
              <i class="bi bi-clock me-1"></i>
              <span id="movieDuration">-- នាទី</span>
            </span>
            <span class="room-badge">
              <i class="bi bi-door-open me-1"></i>
              រោង៖ <span id="movieRoom">--</span>
            </span>
          </div>

          <!-- RELEASE DATE -->
          <div class="p-3 bg-light rounded-3 mb-4 d-inline-block border">
            <span class="text-muted small d-block mb-1">ថ្ងៃបញ្ចាំងដំបូង (Release Date)</span>
            <span class="text-dark fw-bold" id="movierelease">--</span>
          </div>

          <hr class="my-4" style="border-color: var(--cinema-border);">

          <!-- SHOWTIMES SELECTION SECTION -->
          <div class="mb-4">
            <h5 class="fw-bold mb-3 text-dark d-flex align-items-center">
              <i class="bi bi-calendar-event text-danger me-2"></i>
              ជ្រើសរើសម៉ោងបញ្ចាំង (Showtimes)
            </h5>
            <div id="showtimesContainer" class="d-flex gap-3 flex-wrap">
               <p class="text-muted italic">កំពុងស្វែងរកម៉ោងបញ្ចាំង...</p>
            </div>
          </div>
<div class="d-flex flex-wrap justify-content-between align-items-center bg-light p-3 rounded-4 mt-4 border">
  <div>
    <span class="text-muted small d-block">តម្លៃសំបុត្រ/១កៅអី</span>
    <div class="font-mono fs-2 text-danger fw-bold lh-1" id="ticket_price">$0.00</div>
  </div>
  
  <button id="btnGoToBooking" type="button" class="btn btn-danger btn-lg px-4 py-3 rounded-3 fw-bold shadow-sm d-flex align-items-center gap-2" style="background-color: var(--cinema-red); border: none;">
    <i class="bi bi-ticket-perforated-fill fs-5"></i>
    កក់សំបុត្រឥឡូវនេះ
  </button>
</div>

        </div>
      </div>
    </div>
  </section>

  <div class="filmstrip my-5"></div>
</main>

<footer class="text-center text-muted small py-4 border-top">
  © 2026 ETEC CINEMA — Cinema Ticket Booking System · Team 4
</footer>


<script src="../js/detailmovie.js"></script>
</body>
</html>