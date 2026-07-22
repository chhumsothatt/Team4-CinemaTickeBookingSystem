
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
      <!-- <a href="category.php" class="btn btn-marquee"> Cancel</a> -->
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
  <!-- FORM SECTION -->
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <form id="createCategoryForm">
                            <!-- Alert for error or success -->
                            <div id="alertMessage" class="alert d-none" role="alert"></div>

                            <div class="mb-3">
                                <label for="categoryName" class="form-label fw-bold">Input your category name here:</label>
                                <input type="text" class="form-control form-control-sm" id="categoryName" name="name" placeholder="e.g. Action, Sci-Fi, Drama" required>
                            </div>

                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <a href="category.php" class="btn btn-light border">Cancel</a>
                                <button type="submit" class="btn btn-warning fw-bold px-4" id="btnSave">
                                    <i class="bi bi-save me-1"></i> Save Category
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Scripts -->
<script src="../jquery/jquery-3.7.1.min.js"></script>
<script>
$(document).ready(function () {
    $('#createCategoryForm').on('submit', function (e) {
        e.preventDefault();

        const categoryName = $('#categoryName').val().trim();
        const $btn = $('#btnSave');
        const $alert = $('#alertMessage');

        if (!categoryName) return;

        // Disable button while loading
        $btn.prop('disabled', true).text('Saving...');

        $.ajax({
            url: '../api/category/insert.php',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({ name: categoryName }),
            success: function (res) {
                $btn.prop('disabled', false).html('<i class="bi bi-save me-1"></i> Save Category');

                if (res.status === 'success') {
                    $alert.removeClass('d-none alert-danger').addClass('alert-success')
                          .text('Category added successfully! Redirecting...');
                    
                    // Redirect to category list page after 1 second
                    setTimeout(() => {
                        window.location.href = 'category.php';
                    }, 1000);
                } else {
                    $alert.removeClass('d-none alert-success').addClass('alert-danger')
                          .text(res.message || 'An error occurred.');
                }
            },
            error: function () {
                $btn.prop('disabled', false).html('<i class="bi bi-save me-1"></i> Save Category');
                $alert.removeClass('d-none alert-success').addClass('alert-danger')
                      .text('Server error. Please check your console.');
            }
        });
    });
});
</script>
