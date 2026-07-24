<?php
session_start();
include("../include/header.php");
include("../include/navbar.php");
?>

<style>


    .booking-history-card {
        background: #FFFFFF;
        border-radius: 20px;
        border: 1px solid var(--cinema-border);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    .custom-table {
        margin-bottom: 0;
    }

    .custom-table thead th {
        background-color: #F1F5F9;
        color: #475569;
        font-size: 0.85rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 16px 20px;
        border-bottom: 2px solid #E2E8F0;
    }

    .custom-table tbody td {
        padding: 18px 20px;
        vertical-align: middle;
        color: #1E293B;
        border-bottom: 1px solid #F1F5F9;
    }

    .custom-table tbody tr {
        transition: all 0.2s ease;
    }

    .custom-table tbody tr:hover {
        background-color: #F8FAFC;
    }

    .seat-badge {
        background-color: #EFF6FF;
        color: #2563EB;
        border: 1px solid #BFDBFE;
        padding: 6px 12px;
        border-radius: 8px;
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    .status-badge-confirmed {
        background-color: #DCFCE7;
        color: #15803D;
        border: 1px solid #BBF7D0;
        padding: 6px 14px;
        font-size: 0.825rem;
        font-weight: 600;
        border-radius: 50px;
    }

    .movie-title-text {
        font-weight: 700;
        color: #0F172A;
    }
</style>

<main class="container py-4 py-lg-5">

  <!-- HISTORY SECTION -->
  <section id="history" class="py-3">
    <div class="d-flex align-items-center mb-4">
      <div class="bg-danger rounded-pill me-3" style="width: 6px; height: 32px;"></div>
      <h2 class="fw-bold m-0 text-dark">ប្រវត្តិការកក់សំបុត្រ</h2>
    </div>

    <div class="card booking-history-card">
      <div class="table-responsive">
        <table class="table custom-table table-hover align-middle">
          <thead>
            <tr>
              <th><i class="bi bi-film me-2"></i>ភាពយន្ត</th>
              <th><i class="bi bi-calendar3 me-2"></i>ថ្ងៃបញ្ចាំង</th>
              <th><i class="bi bi-clock me-2"></i>ម៉ោងបញ្ចាំង</th>
              <th><i class="bi bi-grid-3x3-gap-fill me-2"></i>កៅអី</th>
              <th><i class="bi bi-patch-check-fill me-2"></i>ស្ថានភាព</th>
            </tr>
          </thead>
          <tbody id="bookingHistoryTableBody">
            <!-- Dynamic Data Rendered via JS -->
            <tr>
              <td colspan="5" class="text-center py-4">
                <div class="spinner-border text-danger" role="status"></div>
                <div class="mt-2 text-muted">កំពុងទាញយកទិន្នន័យ...</div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </section>

</main>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="../js/booking_history.js"></script>

</body>
</html>