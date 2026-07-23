<?php 
  include("../include/sidebar.php");
?>
<div class="main-content">

  <!-- ===================== TOPBAR ===================== -->
  <div class="topbar px-4 py-3 d-flex justify-content-between align-items-center">
    <div class="d-flex align-items-center gap-2">
      <button class="btn btn-outline-cinema d-lg-none" onclick="document.getElementById('sidebar').classList.toggle('show')">
        <i class="bi bi-list"></i>
      </button>
      <div>
        <h1 class="font-display fs-2 mb-0">Create Showtime</h1>
        <div class="text-muted small">បន្ថែមម៉ោង និងកាលវិភាគបញ្ចាំងភាពយន្តថ្មី</div>
      </div>
    </div>
    <a href="showtime.php" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Back to Showtimes</a>
  </div>

  <div class="filmstrip-thin"></div>

  <!-- ===================== FORM CREATE SHOWTIME ===================== -->
  <div class="row m-3">
    <div class="col-12 col-md-8 col-lg-6 mx-auto">
      <div class="card p-4 shadow-sm border-0">
        <h3 class="mb-4">Showtime Details</h3>
        
        <!-- 💡 បន្ថែម method="POST" ការពារ Submit តាម GET -->
        <form id="createTimeForm" method="POST">
          
          <!-- Dropdown Movie -->
          <div class="mb-3">
            <label for="movie_select" class="form-label">Select Movie</label>
            <select class="form-select" id="movie_select" name="movie_id" required>
              <option value="">-- Loading Movies... --</option>
            </select>
          </div>

          <!-- Dropdown Room -->
          <div class="mb-3">
            <label for="room_select" class="form-label">Select Cinema Room</label>
            <select class="form-select" id="room_select" name="room_id" required>
              <option value="">-- Loading Rooms... --</option>
            </select>
          </div>

          <!-- Show Date -->
          <div class="mb-3">
            <label for="show_date" class="form-label">Show Date</label>
            <input type="date" class="form-control" id="show_date" name="show_date" required>
          </div>

          <!-- Start & End Time -->
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="start_time" class="form-label">Start Time</label>
              <input type="time" class="form-control" id="start_time" name="start_time" required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="end_time" class="form-label">End Time</label>
              <input type="time" class="form-control" id="end_time" name="end_time" required>
            </div>
          </div>

          <!-- Ticket Price -->
          <div class="mb-4">
            <label for="price" class="form-label">Ticket Price ($)</label>
            <input type="number" step="0.01" class="form-control" id="price" name="price" placeholder="e.g. 5.00" min="0" required>
          </div>

          <!-- Action Buttons -->
          <div class="d-flex justify-content-end gap-2 mt-4">
            <a href="showtime.php" class="btn btn-outline-secondary">Cancel</a>
            <button type="submit" class="btn btn-marquee">
              <i class="bi bi-save"></i> Save Showtime
            </button>
          </div>

        </form>

      </div>
    </div>
  </div>

</div>

<!-- Include jQuery & Script Showtime -->
<script src="../jquery/jquery-3.7.1.min.js"></script>
<script src="../js/showtime.js"></script>

</body>
</html>