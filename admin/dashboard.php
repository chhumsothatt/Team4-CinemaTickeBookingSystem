<script src="../jquery/jquery-3.7.1.min.js"></script>
<?php 
  include("../include/sidebar.php");
?>
<div class="main-content">

  <!-- ===================== DASHBOARD ===================== -->
  <div class="view active" id="view-dashboard">
    <div class="topbar px-4 py-3 d-flex justify-content-between align-items-center">
      <div class="d-flex align-items-center gap-2">
        <button class="btn btn-outline-cinema d-lg-none" onclick="document.getElementById('sidebar').classList.toggle('show')"><i class="bi bi-list"></i></button>
        <div>
          <h1 class="font-display fs-2 mb-0">Dashboard</h1>
          <div class="text-muted small">ព័ត៌មានសង្ខេបប្រព័ន្ធកក់សំបុត្រកុន</div>
        </div>
      </div>
      <!-- <button class="btn btn-marquee"><i class="bi bi-plus-lg"></i> New Showtime</button> -->
    </div>
    <div class="filmstrip-thin"></div>

    <div class="p-4">
      <div class="row g-3 mb-4">
        <div class="col-6 col-xl-3">
          <!-- //movie  -->
          <div class="stat-card card p-3" style="--accent:var(--marquee)">
            <div class="text-muted small text-uppercase mb-2">Movies</div>
            <div class="value" id="statTotalMovies">0</div>
            <div class="delta" ><i class="bi bi-arrow-up-short"></i><span id="statMoviesMonth">0</span> this month</div>
          </div>
        </div>
        <div class="col-6 col-xl-3">

        <!-- //User  -->
          <div class="stat-card card p-3" style="--accent:var(--velvet)">
            <div class="text-muted small text-uppercase mb-2">Users</div>
            <div class="value" id="statTotalUsers">0</div>
            <div class="delta"><i class="bi bi-arrow-up-short"></i></i> <span id="statUsersMonth">0</span> this month</div>
          </div>
        </div>

        <!-- //Booking -->
        <div class="col-6 col-xl-3">
          <div class="stat-card card p-3" style="--accent:var(--ok)">
            <div class="text-muted small text-uppercase mb-2">Bookings</div>
            <div class="value"  id="statTotalBookings">0</div>
            <div class="delta"><i class="bi bi-arrow-up-short"></i><span id="statBookingsWeek">0</span>  this week</div>
          </div>
        </div>

        <!-- //Room -->
        <div class="col-6 col-xl-3">
          <div class="stat-card card p-3" style="--accent:#8f7bd6">
            <div class="text-muted small text-uppercase mb-2" >Cinema Rooms</div>
            <div class="value" id="statTotalRooms">0</div>
            <div class="delta text-muted" style="color:var(--ink-muted) !important;"><span id="statVipRooms">0</span> VIP rooms</div>
          </div>
        </div>
      </div>

    </div>
  </div>



</div>


<script>
$(document).ready(function () {
    loadDashboardStats();

    function loadDashboardStats() {
        $.ajax({
            url: '../api/dashboard/stats.php',
            type: 'GET',
            dataType: 'json',
            success: function (res) {
                if (res.status === 'success') {
                    const d = res.data;

                    // Update UI values dynamically
                    $('#statTotalMovies').text(d.total_movies);
                    $('#statMoviesMonth').text(d.movies_this_month);

                    $('#statTotalUsers').text(d.total_users);
                    $('#statUsersMonth').text(d.users_this_month);

                    $('#statTotalBookings').text(d.total_bookings);
                    $('#statBookingsWeek').text(d.bookings_this_week);

                    $('#statTotalRooms').text(d.total_rooms);
                    $('#statVipRooms').text(d.vip_rooms);
                }
            },
            error: function (xhr, status, error) {
                console.error('Failed to load dashboard stats:', error);
            }
        });
    }
});
</script>