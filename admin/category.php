<?php
include("../include/sidebar.php");
?>
<!-- jQuery and Custom Script -->
<script src="../jquery/jquery-3.7.1.min.js"></script>
<script src="../js/category.js"></script>

<div class="main-content">

  <!-- ===================== DASHBOARD ===================== -->
  <div class="view active" id="view-dashboard">
    <div class="topbar px-4 py-3 d-flex justify-content-between align-items-center">
      <div class="d-flex align-items-center gap-2">
        <button class="btn btn-outline-cinema d-lg-none" onclick="document.getElementById('sidebar').classList.toggle('show')"><i class="bi bi-list"></i></button>
        <div>
          <h1 class="font-display fs-2 mb-0">category</h1>
          <div class="text-muted small">ព័ត៌មានសង្ខេបប្រព័ន្ធកក់សំបុត្រកុន</div>
        </div>
      </div>
      <a href="createCategory.php" class=" btn btn-marquee">Add new category</a>
    </div>

  </div>

  <!-- ===================== MOVIES ===================== -->
  <div class="view" id="view-movies">
    <div class="topbar px-4 py-3 d-flex justify-content-between align-items-center">
      <div class="d-flex align-items-center gap-2">
        <button class="btn btn-outline-cinema d-lg-none" onclick="document.getElementById('sidebar').classList.toggle('show')"><i class="bi bi-list"></i></button>
        <div>
          <h1 class="font-display fs-2 mb-0">Movies</h1>
          <div class="text-muted small">គ្រប់គ្រងព័ត៌មានភាពយន្ត</div>
        </div>
      </div>
      <button class="btn btn-marquee" data-bs-toggle="modal" data-bs-target="#movieModal"><i class="bi bi-plus-lg"></i> Add Movie</button>
    </div>
    <div class="filmstrip-thin"></div>
  </div>
  <!-- <div class="row m-3"> -->
      <div class="col-12">
        <!-- <div class="card p-3"> -->
          <!-- CATEGORY TABLE -->
          <div class="container-fluid py-4">
            <div class="card shadow-sm border-0">
              <div class="card-body p-0">
                <table class="table table-hover align-middle mb-0">
                  <thead class="table-light">
                    <tr>
                      <th class="ps-4" style="width: 40%;">CATEGORY</th>
                      <th style="width: 40%;">MOVIES</th>
                      <th class="text-end pe-4" style="width: 20%;">ACTIONS</th>
                    </tr>
                  </thead>
                  <tbody id="categoryTableBody">
                    <!-- Dynamically populated by JS -->
                  </tbody>
                </table>
              </div>
            </div>
          </div>

        <!-- </div>
      </div> -->

    
  </div>


</div>


</body>

</html>