<?php include("../include/sidebar.php"); ?>

<div class="main-content p-4">

  <!-- Header Section -->
  <div class="d-flex justify-content-between align-items-center mb-2">
    <div>
      <h2 class="font-display fw-bold mb-0 text-uppercase">Showtimes</h2>
      <div class="text-muted small">គ្រប់គ្រងកាលវិភាគបញ្ចាំងភាពយន្ត</div>
    </div>
    <a href="createTime.php" class="btn btn-warning fw-semibold px-3" style="background-color: #e7810c; color: white; border: none;">
      + Add Showtime
    </a>
  </div>

  <div class="border-bottom my-3" style="border-style: dashed !important; opacity: 0.3;"></div>

  <!-- Table Section -->
  <div class="card border-0 shadow-sm">
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead class="table-light">
            <tr class="text-uppercase small text-muted">
              <th>Movie</th>
              <th>Room</th>
              <th>Date</th>
              <th>Time</th>
              <th class="text-end">Actions</th>
            </tr>
          </thead>
          <tbody id="showtime_table_body">
            <!-- Data loaded via AJAX -->
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>

<script src="../jquery/jquery-3.7.1.min.js"></script>
<script src="../js/showtime.js"></script>
</body>
</html>