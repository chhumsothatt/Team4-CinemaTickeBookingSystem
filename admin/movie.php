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
                    <h1 class="font-display fs-2 mb-0">movie</h1>
                    <div class="text-muted small">ព័ត៌មានសង្ខេបប្រព័ន្ធកក់សំបុត្រកុន</div>
                </div>
            </div>
            <a href="createMovie.php" class="btn btn-marquee">Add new movie</a>
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

            <!-- MOVIE TABLE & FILTERS -->
            <div class="container-fluid py-4">
                <div class="card shadow-sm border-0">
                    <!-- SEARCH & FILTER BAR -->
                    <div class="card-body border-bottom">
                        <div class="row g-3">
                            <div class="col-lg-9">
                                <input type="text" id="searchInput" class="form-control " placeholder="Search movies....">
                            </div>
                            <div class="col-lg-3">
                                <select id="categoryFilter" class="form-select ">
                                    <option value="all">All Categories</option>
                                    <!-- Populated dynamically -->
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- TABLE -->
                    <div class="card-body p-0">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4" style="width: 35%;">MOVIE</th>
                                    <th style="width: 20%;">CATEGORY</th>
                                    <th style="width: 15%;">DURATION</th>
                                    <th style="width: 15%;">RELEASE DATE</th>
                                    <th class="text-end pe-4" style="width: 15%;">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody id="movieTableBody">
                                <!-- Movie rows render here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

        <!-- Scripts -->
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        <script>
            $(document).ready(function() {
                loadCategoryDropdown();
                loadMovies();

                // Fetch and populate category filter
                function loadCategoryDropdown() {
                    $.ajax({
                        url: '../api/category/get.php',
                        type: 'GET',
                        dataType: 'json',
                        success: function(res) {
                            if (res.status === 'success') {
                                let options = '<option value="all">All Categories</option>';
                                res.data.forEach(cat => {
                                    options += `<option value="${cat.id}">${cat.name}</option>`;
                                });
                                $('#categoryFilter').html(options);
                            }
                        }
                    });
                }

                // Fetch and render movies table
                function loadMovies() {
                    const search = $('#searchInput').val() ? $('#searchInput').val().trim() : '';
                    const categoryId = $('#categoryFilter').val() || 'all';

                    $.ajax({
                        url: '../api/movie/get.php',
                        type: 'GET',
                        data: {
                            search: search,
                            category_id: categoryId
                        },
                        dataType: 'json',
                        success: function(res) {
                            if (res.status === 'success') {
                                let rows = '';

                                if (!res.data || res.data.length === 0) {
                                    rows = `<tr><td colspan="5" class="text-center py-4 text-muted">No movies found.</td></tr>`;
                                } else {
                                    res.data.forEach(movie => {
                                        // Date formatting (YYYY-MM-DD -> DD/MM/YYYY)
                                        let formattedDate = 'N/A';
                                        if (movie.release_date) {
                                            const parts = movie.release_date.split('-');
                                            if (parts.length === 3) {
                                                formattedDate = `${parts[2]}/${parts[1]}/${parts[0]}`;
                                            }
                                        }

                                        // Poster thumbnail
                                        const posterSrc = movie.poster ?
                                            `../upload/${movie.poster}` :
                                            'https://via.placeholder.com/40x55?text=No+Cover';

                                        rows += `
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center gap-3">
                                            <img src="${posterSrc}" alt="${movie.title}" class="rounded" style="width: 40px; height: 55px; object-fit: cover;">
                                            <span class="fw-semibold fs-6">${movie.title}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-warning-subtle text-warning-emphasis border px-3 py-2 fs-6">
                                            ${movie.category_name || 'Uncategorized'}
                                        </span>
                                    </td>
                                    <td class="fw-medium">${movie.duration_minutes || 0} min</td>
                                    <td class="text-muted">${formattedDate}</td>
                                    <td class="text-end pe-4">
                                        <a href="editMovie.php?id=${movie.id}" class="btn btn-sm btn-outline-secondary me-1">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button class="btn btn-sm btn-outline-danger btn-delete-movie" data-id="${movie.id}">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            `;
                                    });
                                }
                                $('#movieTableBody').html(rows);
                            }
                        }
                    });
                }

                // Dynamic search and filter listeners
                $('#searchInput').on('keyup input', loadMovies);
                $('#categoryFilter').on('change', loadMovies);

                // Delete movie handling
                $(document).on('click', '.btn-delete-movie', function() {
                    const movieId = $(this).data('id');
                    if (confirm('Are you sure you want to delete this movie?')) {
                        $.ajax({
                            url: '../api/movie/delete.php',
                            type: 'POST',
                            contentType: 'application/json',
                            data: JSON.stringify({
                                id: movieId
                            }),
                            success: function(res) {
                                if (res.status === 'success') {
                                    loadMovies();
                                } else {
                                    alert(res.message || 'Error deleting movie.');
                                }
                            }
                        });
                    }
                });
            });
        </script>

        

       
    </div>
</div>







</html>