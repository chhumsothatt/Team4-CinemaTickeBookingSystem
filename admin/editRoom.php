<?php 
  include("../include/sidebar.php");
  require_once("../config/database.php");

  // ទាញយក ID បន្ទប់ពី URL (ឧទាហរណ៍: editRoom.php?id=1)
  $id = intval($_GET['id'] ?? 0);
  $room = null;

  if ($id > 0) {
      try {
          $stmt = $pdo->prepare("SELECT * FROM tbl_cinema_rooms WHERE id = :id");
          $stmt->execute([':id' => $id]);
          $room = $stmt->fetch();
      } catch (PDOException $e) {
          // Handle Error ប្រសិនបើមាន
      }
  }

  // បើរកមិនឃើញ ID ក្នុង Database ទេ ឱ្យបង្ហាញសារ ឬ Redirect ទៅ room.php
  if (!$room) {
      echo "<script>alert('Room not found!'); window.location.href='room.php';</script>";
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
        <h1 class="font-display fs-2 mb-0">Edit Cinema Room</h1>
        <div class="text-muted small">កែប្រែព័ត៌មានបន្ទប់បញ្ចាំងភាពយន្ត</div>
      </div>
    </div>
    <a href="room.php" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Back to Rooms</a>
  </div>

  <div class="filmstrip-thin"></div>

  <!-- ===================== FORM EDIT ROOM ===================== -->
  <div class="row m-3">
    <div class="col-12 col-md-8 col-lg-6 mx-auto">
      <div class="card p-4 shadow-sm border-0">
        <h3 class="mb-4">Update Room Details</h3>
        
        <form id="editRoomForm">
          <!-- Hidden Input សម្រាប់បញ្ជូន ID ទៅកាន់ API -->
          <input type="hidden" name="id" value="<?= $room['id'] ?>">

          <div class="mb-3">
            <label for="room_name" class="form-label">Room Name / Number</label>
            <input type="text" class="form-control" id="room_name" name="room_name" value="<?= htmlspecialchars($room['room_name']) ?>" required>
          </div>

          <div class="mb-4">
            <label for="total_seats" class="form-label">Total Seats</label>
            <input type="number" class="form-control" id="total_seats" name="total_seats" value="<?= $room['total_seats'] ?>" min="1" required>
          </div>

          <div class="d-flex justify-content-end gap-2 mt-4">
          <a href="room.php" class="btn btn-outline-secondary">Cancel</a>
          <button type="submit" class="btn btn-marquee">
          <i class="bi bi-save"></i> Save Room
        </button>
</div>
        </form>

      </div>
    </div>
  </div>

</div>

<!-- Include jQuery & Script Room -->
<script src="../jquery/jquery-3.7.1.min.js"></script>
<script src="../js/room.js"></script>

</body>
</html>
