<?php include("../include/sidebar.php"); ?>

<div class="main-content p-4">
  <div class="d-flex justify-content-between align-items-center mb-2">
    <div>
      <h2 class="font-display fw-bold mb-0 text-uppercase">SHOWTIMES</h2>
      <div class="text-muted small">គ្រប់គ្រងកាលវិភាគបញ្ចាំងភាពយន្ត</div>
    </div>
    <a href="createTime.php" class="btn btn-warning text-white" style="background-color: #d97706; border: none;">
      <i class="bi bi-plus-lg"></i>  Add Showtime
    </a>
  </div>

  <div class="border-bottom my-3" style="border-style: dashed !important; opacity: 0.3;"></div>

  <div class="card border-0 shadow-sm">
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead class="table-light">
            <tr>
              <th>MOVIE</th>
              <th>ROOM</th>
              <th>DATE</th>
              <th>TIME</th>
              <th class="text-end">ACTIONS</th>
            </tr>
          </thead>
          <tbody id="showtime_table_body">
            </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="../js/showtime.js"></script>
</body>
</html>