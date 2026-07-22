$(document).ready(function () {
    loadCategoryDropdown();
    loadMovies();

    // Fetch categories for filter dropdown
    function loadCategoryDropdown() {
        $.ajax({
            url: '../api/category/get.php',
            type: 'GET',
            dataType: 'json',
            success: function (res) {
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

    // Fetch movies list
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
            success: function (res) {
                console.log("API Response:", res);

                if (res.status === 'success') {
                    let rows = '';

                    if (res.data.length === 0) {
                        rows = `<tr><td colspan="5" class="text-center py-4 text-muted">No movies found in database.</td></tr>`;
                    } else {
                        res.data.forEach(movie => {
                            // Date formatting
                            let formattedDate = 'N/A';
                            if (movie.release_date) {
                                const parts = movie.release_date.split('-');
                                if (parts.length === 3) {
                                    formattedDate = `${parts[2]}/${parts[1]}/${parts[0]}`;
                                }
                            }

                            // Poster image fallback
                            const posterSrc = movie.poster 
                                ? `../upload/${movie.poster}` 
                                : 'https://via.placeholder.com/40x55?text=No+Cover';

                            rows += `
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center gap-3">
                                            <img src="${posterSrc}" alt="${movie.title}" class="rounded" style="width: 40px; height: 55px; object-fit: cover;">
                                            <span class="fw-semibold fs-6">${movie.title}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span >
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
                } else {
                    console.error("Backend Error:", res.message);
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX Failed:", xhr.responseText);
            }
        });
    }

    // Event listeners for search & filter
    $('#searchInput').on('keyup input', loadMovies);
    $('#categoryFilter').on('change', loadMovies);
});