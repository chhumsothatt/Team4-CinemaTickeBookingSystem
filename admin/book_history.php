<?php include("../include/sidebar.php"); ?>

<div class="main-content p-4">
  <div class="d-flex justify-content-between align-items-center mb-2">
    <div>
      <h2 class="font-display fw-bold mb-0 text-uppercase">Booking History</h2>
      <div class="text-muted small">គ្រប់គ្រងប្រវត្តិការកក់សំបុត្រទាំងអស់</div>
    </div>
  </div>

  <div class="border-bottom my-3" style="border-style: dashed !important; opacity: 0.3;"></div>

  <!-- Search & Filter Bar -->
  <div class="row g-3 mb-3">
    <div class="col-md-9">
      <input type="text" id="searchInput" class="form-control" placeholder="Search by user or movie...">
    </div>
    <div class="col-md-3">
      <select id="statusFilter" class="form-select">
        <option value="all">All Status</option>
        <option value="paid">Paid / Confirmed</option>
        <option value="pending">Pending</option>
        <option value="cancelled">Cancelled</option>
      </select>
    </div>
  </div>

  <!-- Table Card -->
  <div class="card border-0 shadow-sm">
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead class="table-light">
            <tr>
              <th>BOOKING #</th>
              <th>USER</th>
              <th>MOVIE</th>
              <th>SHOWTIME</th>
              <th>SEATS</th>
              <th>STATUS</th>
            </tr>
          </thead>
          <tbody id="booking_history_table">
            <!-- ទិន្នន័យ Render ចេញពី JS -->
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="../js/book_history.js"></script>
</body>
</html>