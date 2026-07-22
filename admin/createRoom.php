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
        <h1 class="font-display fs-2 mb-0">Create Cinema Room</h1>
        <div class="text-muted small">បន្ថែមបន្ទប់បញ្ចាំងភាពយន្តថ្មី</div>
      </div>
    </div>
    <a href="room.php" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Back to Rooms</a>
  </div>

  <div class="filmstrip-thin"></div>

  <!-- ===================== FORM CREATE ROOM ===================== -->
  <div class="row m-3">
    <div class="col-12 col-md-8 col-lg-6 mx-auto">
      <div class="card p-4 shadow-sm border-0">
        <h3 class="mb-4">Room Details</h3>
        
        <form id="createRoomForm">
          <div class="mb-3">
            <label for="room_name" class="form-label">Room Name / Number</label>
            <input type="text" class="form-control" id="room_name" name="room_name" placeholder="e.g. Hall 01 (VIP)" required>
          </div>

          <div class="mb-4">
            <label for="total_seats" class="form-label">Total Seats</label>
            <input type="number" class="form-control" id="total_seats" name="total_seats" placeholder="e.g. 50" min="1" required>
          </div>

         <div class="d-flex justify-content-end gap-2 mt-4">
  ​​​​​​​​       <a href="room.php" class="btn btn-outline-secondary">Cancel</a>
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