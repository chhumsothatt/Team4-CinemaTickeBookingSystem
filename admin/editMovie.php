<?php
include("../include/sidebar.php");
require_once '../config/database.php';

$id = $_GET['id'] ?? null;
$movie = null;

if ($id) {
    $stmt = $pdo->prepare("SELECT * FROM tbl_movies WHERE id = ?");
    $stmt->execute([$id]);
    $movie = $stmt->fetch();
}
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
      <button class="btn btn-marquee"><i class="bi bi-plus-lg"></i> New Cinema Room</button>
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
          <!-- FORM SECTION -->
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <?php if (!$movie): ?>
                            <div class="alert alert-danger">Movie not found.</div>
                        <?php else: ?>
                            <form id="editMovieForm" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="<?= htmlspecialchars($movie['id']) ?>">
                                <div id="alertMessage" class="alert d-none" role="alert"></div>

                                <div class="row g-3">
                                    <!-- Title -->
                                    <div class="col-md-12">
                                        <label for="title" class="form-label fw-bold">Movie Title <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control " id="title" name="title" value="<?= htmlspecialchars($movie['title']) ?>" required>
                                    </div>

                                    <!-- Category -->
                                    <div class="col-md-6">
                                        <label for="category_id" class="form-label fw-bold">Category <span class="text-danger">*</span></label>
                                        <select class="form-select " id="category_id" name="category_id" required>
                                            <option value="">Select Category</option>
                                        </select>
                                    </div>

                                    <!-- Duration -->
                                    <div class="col-md-6">
                                        <label for="duration_minutes" class="form-label fw-bold">Duration (Minutes) <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control " id="duration_minutes" name="duration_minutes" value="<?= htmlspecialchars($movie['duration_minutes']) ?>" required min="1">
                                    </div>

                                    <!-- Release Date -->
                                    <div class="col-md-6">
                                        <label for="release_date" class="form-label fw-bold">Release Date</label>
                                        <input type="date" class="form-control " id="release_date" name="release_date" value="<?= htmlspecialchars($movie['release_date']) ?>">
                                    </div>

                                    <!-- Poster File -->
                                    <div class="col-md-6">
                                        <label for="poster" class="form-label fw-bold">Poster Image (Leave empty to keep existing)</label>
                                        <input type="file" class="form-control " id="poster" name="poster" accept="image/*">
                                        
                                        <?php if (!empty($movie['poster'])): ?>
                                            <div class="mt-2 d-flex align-items-center gap-2">
                                                <span class="text-muted small">Current Poster:</span>
                                                <img src="../upload/<?= htmlspecialchars($movie['poster']) ?>" alt="Poster" class="rounded border" style="width: 40px; height: 50px; object-fit: cover;">
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Description -->
                                    <div class="col-md-12">
                                        <label for="description" class="form-label fw-bold">Description</label>
                                        <textarea class="form-control" id="description" name="description" rows="3"><?= htmlspecialchars($movie['description'] ?? '') ?></textarea>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end gap-2 mt-4">
                                    <a href="movie.php" class="btn btn-light border">Cancel</a>
                                    <button type="submit" class="btn btn-warning fw-bold px-4" id="btnUpdate">
                                        <i class="bi bi-save me-1"></i> Update Movie
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
  </div>


</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
$(document).ready(function () {
    const selectedCategoryId = "<?= htmlspecialchars($movie['category_id'] ?? '') ?>";

    // Load categories into select option and set active option
    $.ajax({
        url: '../api/category/get.php',
        type: 'GET',
        dataType: 'json',
        success: function (res) {
            if (res.status === 'success') {
                let options = '<option value="">Select Category</option>';
                res.data.forEach(cat => {
                    const isSelected = String(cat.id) === String(selectedCategoryId) ? 'selected' : '';
                    options += `<option value="${cat.id}" ${isSelected}>${cat.name}</option>`;
                });
                $('#category_id').html(options);
            }
        }
    });

    // Form Submission
    $('#editMovieForm').on('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        const $btn = $('#btnUpdate');
        const $alert = $('#alertMessage');

        $btn.prop('disabled', true).text('Updating...');

        $.ajax({
            url: '../api/movie/edit.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (res) {
                $btn.prop('disabled', false).html('<i class="bi bi-save me-1"></i> Update Movie');

                if (res.status === 'success') {
                    $alert.removeClass('d-none alert-danger').addClass('alert-success')
                          .text('Movie updated successfully! Redirecting...');
                    
                    setTimeout(() => {
                        window.location.href = 'movie.php';
                    }, 1000);
                } else {
                    $alert.removeClass('d-none alert-success').addClass('alert-danger')
                          .text(res.message || 'An error occurred.');
                }
            },
            error: function () {
                $btn.prop('disabled', false).html('<i class="bi bi-save me-1"></i> Update Movie');
                $alert.removeClass('d-none alert-success').addClass('alert-danger')
                      .text('Server error during update.');
            }
        });
    });
});
</script>

</body>
</html>