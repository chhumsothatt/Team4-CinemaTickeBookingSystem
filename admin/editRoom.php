<?php include("../include/sidebar.php"); ?>

<div class="main-content p-4">
  <div class="d-flex justify-content-between align-items-center mb-2">
    <div>
      <h2 class="font-display fw-bold mb-0 text-uppercase">Edit Cinema Room</h2>
      <div class="text-muted small">កែប្រែព័ត៌មានបន្ទប់ចាំងភាពយន្ត</div>
    </div>
    <a href="room.php" class="btn btn-secondary px-3">&larr; Back</a>
  </div>

  <div class="border-bottom my-3" style="border-style: dashed !important; opacity: 0.3;"></div>

  <div class="card border-0 shadow-sm mx-auto" style="max-width: 600px;">
    <div class="card-body p-4">
      <h4 class="fw-bold mb-3">Update Room Details</h4>

      <form id="editRoomForm">
        <input type="hidden" id="room_id" name="id" value="<?php echo $_GET['id'] ?? ''; ?>">

        <div class="mb-3">
          <label class="form-label text-muted small fw-semibold">Room Name / Number</label>
          <input type="text" class="form-control" id="room_name" name="room_name" required>
        </div>

        <div class="mb-4">
          <label class="form-label text-muted small fw-semibold">Total Seats</label>
          <input type="number" class="form-control" id="total_seats" name="total_seats" required>
        </div>

        <div class="d-flex justify-content-end gap-2">
          <a href="room.php" class="btn btn-secondary px-4">Cancel</a>
          <button type="submit" class="btn btn-warning px-4 text-white" style="background-color: #d97706; border: none;">
            Save Room
          </button>
        </div>
      </form>

    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="../js/room.js"></script>
</body>
</html>