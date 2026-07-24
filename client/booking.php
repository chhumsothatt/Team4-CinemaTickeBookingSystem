<?php
session_start();
require_once '../middleware/authMiddlware.php';
requireAuthPage();
include("../include/header.php");
include("../include/navbar.php");

?>
<style>
    :root {
        --cinema-red: #E50914;
        --cinema-dark: #0F172A;
        --cinema-card-bg: #FFFFFF;
        --cinema-border: #E2E8F0;
        --seat-available: #CBD5E1;
        --seat-vip: #F59E0B;
        --seat-selected: #E50914;
        --seat-booked: #64748B;
    }

    body { background-color: #F8FAFC; }

    .movie-header-card {
        background: #1E293B;
        color: #FFFFFF;
        border-radius: 20px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }

    .screen-container { perspective: 400px; margin-bottom: 2.5rem; }
    .screen-arc {
        height: 12px; width: 80%; margin: 0 auto;
        background: linear-gradient(90deg, rgba(229,9,20,0.1) 0%, rgba(229,9,20,0.8) 50%, rgba(229,9,20,0.1) 100%);
        border-radius: 50% 50% 0 0 / 100% 100% 0 0;
        box-shadow: 0 8px 25px rgba(229, 9, 20, 0.5);
        border-top: 3px solid var(--cinema-red);
    }
    .screen-text { letter-spacing: 6px; font-size: 0.75rem; color: #94A3B8; font-weight: 700; }

    .seat-container {
        display: flex; flex-wrap: wrap; gap: 8px; justify-content: center; max-width: 650px; margin: 0 auto;
    }

    .seat {
        width: 42px; height: 42px; border-radius: 8px 8px 4px 4px;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.8rem; font-weight: 600; cursor: pointer;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1); user-select: none;
    }

    .seat.available { background-color: var(--seat-available); color: #334155; }
    .seat.available:hover { background-color: #94A3B8; transform: scale(1.1); }
    .seat.selected {
        background-color: var(--seat-selected) !important; color: #FFFFFF !important;
        box-shadow: 0 4px 12px rgba(229, 9, 20, 0.4); transform: scale(1.1);
    }
    .seat.booked { background-color: var(--seat-booked); color: #94A3B8; cursor: not-allowed; opacity: 0.5; }

    .summary-card {
        background: #FFFFFF; border-radius: 20px; border: 1px solid var(--cinema-border);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.05); position: sticky; top: 20px;
    }
    .qr-box { background: #ffffff; border: 2px dashed #CBD5E1; border-radius: 16px; padding: 20px; }
</style>

<main class="container py-4 py-lg-5">
    <div class="d-flex align-items-center mb-4">
        <a href="javascript:history.back()" class="btn btn-outline-secondary rounded-circle me-3">
            <i class="bi bi-arrow-left"></i>
        </a>
        <h2 class="fw-bold m-0">ជ្រើសរើសកៅអី (Select Seats)</h2>
    </div>

    <!-- MOVIE HEADER -->
    <div class="movie-header-card p-4 mb-4">
        <div class="row align-items-center g-3">
            <div class="col-auto">
                <img id="moviePoster" src="../upload/image.png" class="rounded-3" style="width: 70px; height: 95px; object-fit: cover;" alt="Poster">
            </div>
            <div class="col">
                <h3 class="fw-bold fs-4 mb-2" id="movieTitle">កំពុងផ្ទុក...</h3>
                <div class="d-flex flex-wrap gap-3 align-items-center small text-light opacity-75">
                    <span class="badge bg-danger rounded-pill"><i class="bi bi-door-open me-1"></i> <span id="movieRoom">--</span></span>
                    <span><i class="bi bi-calendar3 me-1"></i> <span id="showDate">--</span></span>
                    <span><i class="bi bi-clock me-1"></i> <span id="showTime">--</span></span>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- SEAT SELECTION MAP -->
        <div class="col-12 col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 text-center bg-white">
                <div class="screen-container">
                    <div class="screen-arc"></div>
                    <div class="screen-text mt-3">អេក្រង់ចាំង (SCREEN)</div>
                </div>

                <div id="seatMapContainer" class="seat-container mb-5">
                    <p class="text-muted">កំពុងទាញយកទិន្នន័យកៅអី...</p>
                </div>

                <div class="d-flex flex-wrap justify-content-center gap-4 pt-3 border-top">
                    <div class="d-flex align-items-center gap-2 small fw-semibold">
                        <div style="width: 18px; height: 18px; background: var(--seat-available); border-radius: 4px;"></div>
                        <span>ទំនេរ</span>
                    </div>
                    <div class="d-flex align-items-center gap-2 small fw-semibold">
                        <div style="width: 18px; height: 18px; background: var(--seat-selected); border-radius: 4px;"></div>
                        <span>ជ្រើសរើស</span>
                    </div>
                    <div class="d-flex align-items-center gap-2 small fw-semibold">
                        <div style="width: 18px; height: 18px; background: var(--seat-booked); border-radius: 4px;"></div>
                        <span>បានកក់រួច</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- BOOKING SUMMARY SIDEBAR -->
        <div class="col-12 col-lg-4">
            <div class="card summary-card p-4">
                <h4 class="fw-bold mb-4 text-dark border-bottom pb-3">សង្ខេបការកក់</h4>

                <div class="d-flex justify-content-between mb-3">
                    <span class="text-muted">កៅអីដែលបានជ្រើសរើស</span>
                    <span class="fw-bold text-dark text-end" id="selectedSeatsList">មិនទាន់រើស</span>
                </div>

                <div class="d-flex justify-content-between mb-3">
                    <span class="text-muted">ចំនួនកៅអីសរុប</span>
                    <span class="fw-bold text-dark"><span id="seatCount">0</span> កៅអី</span>
                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <span class="text-muted d-block small">តម្លៃសរុប (Total)</span>
                        <div class="fs-2 fw-bold text-danger" id="totalPrice">$0.00</div>
                    </div>
                </div>

                <button class="btn btn-danger btn-lg w-100 py-3 fw-bold rounded-3 shadow-sm" id="btnBookNow" disabled>
                    <i class="bi bi-ticket-perforated-fill me-2"></i> បន្តទៅការទូទាត់
                </button>
            </div>
        </div>
    </div>
</main>

<!-- PAYMENT KHQR MODAL -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">ទូទាត់ប្រាក់តាម KHQR</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center p-4">
                <p class="text-muted small mb-3">សូម Scan QR Code ខាងក្រោមដើម្បីបញ្ចប់ការទូទាត់សំបុត្រ</p>
                <div class="qr-box d-inline-block mb-3">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=KHQR_CINEMA_PAYMENT" alt="KHQR Code" class="img-fluid" style="width: 180px;">
                    <div class="fw-bold text-danger fs-4 mt-2" id="modalTotalPrice">$0.00</div>
                </div>
                <div class="alert alert-info py-2 small mb-0">
                    <i class="bi bi-info-circle me-1"></i> ប្រព័ន្ធនឹងផ្ទៀងផ្ទាត់ដោយស្វ័យប្រវត្តិបន្ទាប់ពីចុចប៊ូតុងខាងក្រោម
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light rounded-3 fw-bold me-2" data-bs-dismiss="modal">បោះបង់</button>
                <button type="button" class="btn btn-danger rounded-3 fw-bold px-4" id="btnConfirmPayment">
                    <i class="bi bi-check-circle me-1"></i> ខ្ញុំបានទូទាត់រួចរាល់
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap 5 JS Bundle (រួមមាន Popper ផងដែរ) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- កូដ booking.js របស់អ្នក -->
<script src="../js/booking.js"></script>
</body>
</html>