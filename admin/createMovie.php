<!-- Scripts -->
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
            <!-- <a href="createTime.php" class="btn btn-marquee"><i class="bi bi-plus-lg"></i> New Showtime</a> -->
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
    <div class="row m-3">
        <div class="col-12">
           
            <!-- FORM SECTION -->
            <div class="container-fluid py-4">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card shadow-sm border-0">
                            <div class="card-body p-4">
                                <form id="createMovieForm" enctype="multipart/form-data">
                                    <div id="alertMessage" class="alert d-none" role="alert"></div>

                                    <div class="row g-3">
                                        <!-- Movie Title -->
                                        <div class="col-md-12">
                                            <label for="title" class="form-label fw-bold">Movie Title <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control " id="title" name="title" required placeholder="e.g. Superman">
                                        </div>

                                        <!-- Category Dropdown -->
                                        <div class="col-md-6">
                                            <label for="category_id" class="form-label fw-bold">Category <span class="text-danger">*</span></label>
                                            <select class="form-select " id="category_id" name="category_id" required>
                                                <option value="">Select Category</option>
                                            </select>
                                        </div>

                                        <!-- Duration in Minutes -->
                                        <div class="col-md-6">
                                            <label for="duration_minutes" class="form-label fw-bold">Duration (Minutes) <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control " id="duration_minutes" name="duration_minutes" required min="1" placeholder="e.g. 120">
                                        </div>

                                        <!-- Release Date -->
                                        <div class="col-md-6">
                                            <label for="release_date" class="form-label fw-bold">Release Date</label>
                                            <input type="date" class="form-control " id="release_date" name="release_date">
                                        </div>

                                        <!-- Poster Upload -->
                                        <div class="col-md-6">
                                            <label for="poster" class="form-label fw-bold">Poster Image</label>
                                            <input type="file" class="form-control " id="poster" name="poster" accept="image/*">
                                        </div>

                                        <!-- Description -->
                                        <div class="col-md-12">
                                            <label for="description" class="form-label fw-bold">Description</label>
                                            <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter movie synopsis..."></textarea>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-end gap-2 mt-4">
                                        <a href="movie.php" class="btn btn-light border">Cancel</a>
                                        <button type="submit" class="btn btn-warning fw-bold px-4" id="btnSave">
                                            <i class="bi bi-save me-1"></i> Save Movie
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>

<script>
    $(document).ready(function() {
        // Load categories into select option
        $.ajax({
            url: '../api/category/get.php',
            type: 'GET',
            dataType: 'json',
            success: function(res) {
                if (res.status === 'success') {
                    let options = '<option value="">Select Category</option>';
                    res.data.forEach(cat => {
                        options += `<option value="${cat.id}">${cat.name}</option>`;
                    });
                    $('#category_id').html(options);
                }
            }
        });

        // Form Submission
        $('#createMovieForm').on('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const $btn = $('#btnSave');
            const $alert = $('#alertMessage');

            $btn.prop('disabled', true).text('Saving...');

            $.ajax({
                url: '../api/movie/insert.php',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(res) {
                    $btn.prop('disabled', false).html('<i class="bi bi-save me-1"></i> Save Movie');

                    if (res.status === 'success') {
                        $alert.removeClass('d-none alert-danger').addClass('alert-success')
                            .text('Movie added successfully! Redirecting...');

                        setTimeout(() => {
                            window.location.href = 'movie.php';
                        }, 1000);
                    } else {
                        $alert.removeClass('d-none alert-success').addClass('alert-danger')
                            .text(res.message || 'An error occurred.');
                    }
                },
                error: function() {
                    $btn.prop('disabled', false).html('<i class="bi bi-save me-1"></i> Save Movie');
                    $alert.removeClass('d-none alert-success').addClass('alert-danger')
                        .text('Server error during upload.');
                }
            });
        });
    });
</script>