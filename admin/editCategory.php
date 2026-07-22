<!-- Scripts -->
<script src="../jquery/jquery-3.7.1.min.js"></script>
<?php
include("../include/sidebar.php");
require_once '../config/database.php';

$id = $_GET['id'] ?? null;
$categoryName = '';

if ($id) {
    $stmt = $pdo->prepare("SELECT * FROM tbl_categories WHERE id = ?");
    $stmt->execute([$id]);
    $category = $stmt->fetch();
    if ($category) {
        $categoryName = $category['name'];
    }
}
?>

<div class="main-content">

  <!-- ===================== DASHBOARD ===================== -->
  <div class="view active" id="view-dashboard">
    <div class="topbar px-4 py-3 d-flex justify-content-between align-items-center">
      <div class="d-flex align-items-center gap-2">
        <button class="btn btn-outline-cinema d-lg-none" onclick="document.getElementById('sidebar').classList.toggle('show')"><i class="bi bi-list"></i></button>
        <div>
          <h1 class="font-display fs-2 mb-0">Edit Category</h1>
          <div class="text-muted small">ព័ត៌មានសង្ខេបប្រព័ន្ធកក់សំបុត្រកុន</div>
        </div>
      </div>
      <!-- <button class="btn btn-marquee"><i class="bi bi-plus-lg"></i> New Cinema Room</button> -->
    </div>

  </div>

  <!-- ===================== MOVIES ===================== -->
  <div class="view" id="view-movies">
    <div class="topbar px-4 py-3 d-flex justify-content-between align-items-center">
      <div class="d-flex align-items-center gap-2">
        <button class="btn btn-outline-cinema d-lg-none" onclick="document.getElementById('sidebar').classList.toggle('show')"><i class="bi bi-list"></i></button>
        <div><h1 class="font-display fs-2 mb-0">Movies</h1><div class="text-muted small">គ្រប់គ្រងព័ត៌មានភាពយន្ត</div></div>
      </div>
      <!-- <button class="btn btn-marquee" data-bs-toggle="modal" data-bs-target="#movieModal"><i class="bi bi-plus-lg"></i> Add Movie</button> -->
    </div>
    <div class="filmstrip-thin"></div>
  </div>
  <div class="row m-3">
        <div class="col-12">
          
          <!-- FORM SECTION -->
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <?php if (!$category): ?>
                            <div class="alert alert-danger">Category not found.</div>
                        <?php else: ?>
                            <form id="editCategoryForm">
                                <input type="hidden" id="categoryId" value="<?= htmlspecialchars($id) ?>">

                                <div id="alertMessage" class="alert d-none" role="alert"></div>

                                <div class="mb-3">
                                    <label for="categoryName" class="form-label fw-bold">Category Name</label>
                                    <input type="text" class="form-control form-control" id="categoryName" name="name" value="<?= htmlspecialchars($categoryName) ?>" required>
                                </div>

                                <div class="d-flex justify-content-end gap-2 mt-4">
                                    <a href="category.php" class="btn btn-light border">Cancel</a>
                                    <button type="submit" class="btn btn-warning fw-bold px-4" id="btnUpdate">
                                        <i class="bi bi-save me-1"></i> Update Category
                                    </button>
                                </div>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>






<script>
$(document).ready(function () {
    $('#editCategoryForm').on('submit', function (e) {
        e.preventDefault();

        const categoryId = $('#categoryId').val();
        const categoryName = $('#categoryName').val().trim();
        const $btn = $('#btnUpdate');
        const $alert = $('#alertMessage');

        if (!categoryName) return;

        $btn.prop('disabled', true).text('Updating...');

        $.ajax({
            url: '../api/category/edit.php',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({ id: categoryId, name: categoryName }),
            success: function (res) {
                $btn.prop('disabled', false).html('<i class="bi bi-save me-1"></i> Update Category');

                if (res.status === 'success') {
                    $alert.removeClass('d-none alert-danger').addClass('alert-success')
                          .text('Category updated successfully! Redirecting...');
                    
                    setTimeout(() => {
                        window.location.href = 'category.php';
                    }, 1000);
                } else {
                    $alert.removeClass('d-none alert-success').addClass('alert-danger')
                          .text(res.message || 'An error occurred.');
                }
            },
            error: function () {
                $btn.prop('disabled', false).html('<i class="bi bi-save me-1"></i> Update Category');
                $alert.removeClass('d-none alert-success').addClass('alert-danger')
                      .text('Server error. Please try again.');
            }
        });
    });
});
</script>
</html>
