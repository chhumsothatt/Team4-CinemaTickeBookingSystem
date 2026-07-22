<?php 
  include("../include/sidebar.php");
  require_once("../config/database.php");

  // ទាញយក ID ពី URL (ឧទាហរណ៍: editTime.php?id=1)
  $id = intval($_GET['id'] ?? 0);
  $showtime = null;

  if ($id > 0) {
      try {
          // ទាញយកពី tbl_showtimes ដោយបំបែក start_time ជា date & time
          $stmt = $pdo->prepare("SELECT id, movie_id, room_id, 
                                        DATE(start_time) as show_date, 
                                        TIME_FORMAT(start_time, '%H:%i') as start_time, 
                                        TIME_FORMAT(end_time, '%H:%i') as end_time, 
                                        ticket_price as price 
                                 FROM tbl_showtimes 
                                 WHERE id = :id");
          $stmt->execute([':id' => $id]);
          $showtime = $stmt->fetch();
      } catch (PDOException $e) {
          // Handle Exception
      }
  }

  // បើរកមិនឃើញ ID ក្នុង Database ទេ ឱ្យត្រឡប់ទៅ showtime.php វិញ
  if (!$showtime) {
      echo "<script>alert('Showtime not found!'); window.location.href='showtime.php';</script>";
      exit;
  }
?>

<div class="main-content">

  <!-- ===================== TOPBAR ===================== -->
  <div class="topbar px-4 py-3 d-flex justify-content-between align-items-center">
    <div class="d-flex align-items-center gap-2">
      <button class="btn btn-outline-cinema d-lg-none" onclick="document.getElementById('sidebar').classList.toggle('show')">
        <i class="bi bi-list"></i>
      </button>
      <div>
        <h1 class="font-display fs-2 mb-0">Edit Showtime</h1>
        <div class="text-muted small">កែប្រែកាលវិភាគបញ្ចាំងភាពយន្ត</div>
      </div>
    </div>
    <a href="showtime.php" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Back to Showtimes</a>
  </div>

  <div class="filmstrip-thin"></div>

  <!-- ===================== FORM EDIT SHOWTIME ===================== -->
  <div class="row m-3">
    <div class="col-12 col-md-8 col-lg-6 mx-auto">
      <div class="card p-4 shadow-sm border-0">
        <h3 class="mb-4">Update Showtime Details</h3>
        
        <form id="editTimeForm">
          <!-- Hidden Input សម្រាប់បញ្ជូន ID ទៅកាន់ API -->
          <input type="hidden" name="id" value="<?= $showtime['id'] ?>">

          <!-- Dropdown Movie -->
          <div class="mb-3">
            <label for="movie_select" class="form-label">Select Movie</label>
            <select class="form-select" id="movie_select" name="movie_id" data-selected="<?= $showtime['movie_id'] ?>" required>
              <option value="">-- Loading Movies... --</option>
            </select>
          </div>

          <!-- Dropdown Room -->
          <div class="mb-3">
            <label for="room_select" class="form-label">Select Cinema Room</label>
            <select class="form-select" id="room_select" name="room_id" data-selected="<?= $showtime['room_id'] ?>" required>
              <option value="">-- Loading Rooms... --</option>
            </select>
          </div>

          <!-- Show Date -->
          <div class="mb-3">
            <label for="show_date" class="form-label">Show Date</label>
            <input type="date" class="form-control" id="show_date" name="show_date" value="<?= $showtime['show_date'] ?>" required>
          </div>

          <!-- Start & End Time -->
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="start_time" class="form-label">Start Time</label>
              <input type="time" class="form-control" id="start_time" name="start_time" value="<?= $showtime['start_time'] ?>" required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="end_time" class="form-label">End Time</label>
              <input type="time" class="form-control" id="end_time" name="end_time" value="<?= $showtime['end_time'] ?>" required>
            </div>
          </div>

          <!-- Ticket Price -->
          <div class="mb-4">
            <label for="price" class="form-label">Ticket Price ($)</label>
            <input type="number" step="0.01" class="form-control" id="price" name="price" value="<?= $showtime['price'] ?>" min="0" required>
          </div>

          <!-- Action Buttons -->
          <div class="d-flex gap-2">
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
