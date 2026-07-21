
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
      <button class="btn btn-marquee"><i class="bi bi-plus-lg"></i> New Moview</button>
    </div>

  </div>

  <!-- ===================== MOVIES ===================== -->
  <div class="view" id="view-movies">
    <div class="topbar px-4 py-3 d-flex justify-content-between align-items-center">
      <div class="d-flex align-items-center gap-2">
        <button class="btn btn-outline-cinema d-lg-none" onclick="document.getElementById('sidebar').classList.toggle('show')"><i class="bi bi-list"></i></button>
        <div><h1 class="font-display fs-2 mb-0">Movies</h1><div class="text-muted small">គ្រប់គ្រងព័ត៌មានភាពយន្ត</div></div>
      </div>
      <button class="btn btn-marquee" data-bs-toggle="modal" data-bs-target="#movieModal"><i class="bi bi-plus-lg"></i> Add Movie</button>
    </div>
    <div class="filmstrip-thin"></div>
  </div>
  <div class="row m-3">
        <div class="col-12">
          <div class="card p-3">
            <h3>Edit Movie</h3>
          </div>
        </div>
  </div>


</div>


</body>
</html>