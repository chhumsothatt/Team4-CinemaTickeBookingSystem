const API = '../api/client/';

function getMovie() {
    const keyword = $('#movieSearch').val().trim();
    const categoryId = $('#catFilter').val();

    $.ajax({
        url: API + "get.php",
        method: 'GET',
        data: {
            search: keyword,
            category_id: categoryId
        },
        dataType: 'json',
        success: function (res) {
            const $catebody = $('#catebody');
            $catebody.empty();

            if (res.success && res.data && res.data.length > 0) {
                $('#resultCount').text(`${res.data.length} movies`);

                $.each(res.data, function (index, movie) {
                    const posterImg = movie.poster ? `../upload/${movie.poster}` : 'https://i.pinimg.com/736x/3d/b0/6e/3db06e05d7dd29897726c1be94c00d65.jpg';

                    $catebody.append(`
                        <div class="col-md-3 col-sm-6">
                            <div class="card movie-card shadow-sm h-100">
                                <a href="./detail.php?movie_id=${movie.id}" >
                                    <img src="${posterImg}" class="card-img-top"  style="height: 230px; object-fit: cover;">
                                </a>
                                <div class="card-body d-flex flex-column justify-content-between">
                                    <div>
                                        <div class="d-flex align-items-center mb-1">
                                            <h6 class="card-title font-display fs-6 mb-0 text-truncate me-2" title="${movie.title}">Title : ${movie.title}</h6>
                                            <span class="font-display fs-6 ms-auto text-danger text-nowrap">${movie.duration_minutes} នាទី</span>
                                        </div>
                                        <span class="badge bg-secondary mb-2">${movie.category_name}</span>
                                    </div>
                                    <a href="./detail.php?movie_id=${movie.id}" class="btn btn-marquee w-100 mt-2">កក់សំបុត្រ</a>
                                </div>
                            </div>
                        </div>
                    `);
                });
            } else {
                $('#resultCount').text('0 movies');
                $catebody.append(`
                    <div class="col-12 text-center py-5 text-muted">
                        <i class="bi bi-film fs-1 d-block mb-2"></i>
                        <p class="mb-0">មិនមានភាពយន្តដែលអ្នកស្វែងរកឡើយ (No Movies Found)</p>
                    </div>
                `);
            }
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error Details:", xhr.responseText);
            $('#resultCount').text('0 movies');
            $('#catebody').html(`
                <div class="col-12 text-center text-danger py-5">
                    <i class="bi bi-exclamation-triangle fs-1 d-block mb-2"></i>
                    <p class="fw-bold mb-1">មានបញ្ហាក្នុងការទាញយកទិន្នន័យ!</p>
                    <small class="text-muted">សូមពិនិត្យមើល Console (F12) ដើម្បីមើល Error លម្អិត</small>
                </div>
            `);
        }
    });
}

// 2. Trigger Event ពេល Search ឬប្តូរ Category
function liveSearch() {
    getMovie();
}

// 3. Function ទាញយក Categories មកដាក់ក្នុង Select Dropdown
const getCategory = () => {
    $.ajax({
        url: API + 'getcategory.php',
        method: 'GET',
        dataType: 'json',
        success: function (res) {
            let categoryElement = $('#catFilter');
            categoryElement.empty();
            categoryElement.append(`<option value="">All Categories</option>`);

            if (res.success && res.data.length > 0) {
                $.each(res.data, function (index, category) {
                    categoryElement.append(`
                        <option value="${category.id}">${category.name}</option>
                    `);
                });
            }
        },

    });
};

$(document).ready(function () {
    // Detect if we are on detail.php page
    if (window.location.pathname.includes('detail.php')) {
        getMovieDetail();
    }

    // Logout handling
    $('#btnLogout').click(function () {
        $.ajax({
            url: '../api/auth_handler.php',
            method: 'POST',
            dataType: 'json',
            data: { action: 'logout' },
            success: function () {
                window.location.href = '../login.php';
            }
        });
    });
});

/**
 * Fetch movie details from backend API based on URL parameters
 */
function getMovieDetail() {
    const urlParams = new URLSearchParams(window.location.search);
    const movieId = urlParams.get('movie_id');

    if (!movieId) {
        alert('សូមជ្រើសរើសភាពយន្តជាមុនសិន!');
        window.location.href = './index.php';
        return;
    }

    $.ajax({
        url: '../api/client/getdetail.php',
        method: 'GET',
        data: { movie_id: movieId },
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                const movie = response.movie;
                const showtimes = response.showtimes;

                // Render basic info
                $('#movieTitle').text(movie.title);
                $('#mModalTitle').text(movie.title);
                $('#movieDesc').text(movie.description || 'មិនទាន់មានការពិពណ៌នា។');
                $('#movieCategory').text(movie.category_name || 'General');
                $('#movieDuration').text((movie.duration_minutes || '0') + ' នាទី');

                // Poster Image Fix
                const posterPath = movie.poster ? `../upload/${movie.poster}` : '../upload/image.png';
                $('#moviePoster').attr('src', posterPath);

                // Render Showtimes
                renderShowtimes(showtimes);
            } else {
                alert(response.message);
            }
        },
        error: function (xhr, status, error) {
            console.error('API Error:', error);
            alert('មានបញ្ហាក្នុងការទាញយកទិន្នន័យពី Server!');
        }
    });
}

/**
 * Render dynamic radio buttons for movie showtimes
 */
function renderShowtimes(showtimes) {
    const $container = $('#showtimesContainer');
    $container.empty();

    if (!showtimes || showtimes.length === 0) {
        $container.html('<p class="text-muted">មិនទាន់មានបញ្ចាំងនៅឡើយទេ។</p>');
        return;
    }

    // Update Room tag from first showtime if available
    if (showtimes[0].room_name) {
        $('#movieRoom').text(showtimes[0].room_name);
        $('#mModalRoom').text(showtimes[0].room_name);
    }

    showtimes.forEach((st, index) => {
        const isChecked = index === 0 ? 'checked' : '';
        const radioHtml = `
            <input type="radio" class="btn-check" name="showtime" id="st_${st.id}" value="${st.id}" data-time="${st.show_time}" data-date="${st.show_date}" data-price="${st.price}" ${isChecked}>
            <label class="btn btn-outline-cinema font-mono" for="st_${st.id}">${st.show_time}</label>
        `;
        $container.append(radioHtml);
    });

    // Set initial values for Modal
    const selected = $('input[name="showtime"]:checked');
    if (selected.length > 0) {
        $('#tTime').text(selected.data('time'));
        $('#mModalDate').text(selected.data('date'));
    }
}

// Update modal details on showtime change
$(document).on('change', 'input[name="showtime"]', function () {
    $('#tTime').text($(this).data('time'));
    $('#mModalDate').text($(this).data('date'));
});

function confirmBooking() {
    const selectedShowtime = $('input[name="showtime"]:checked').val();
    if (!selectedShowtime) {
        alert('សូមជ្រើសរើសម៉ោងបញ្ចាំង!');
        return;
    }
    // Perform booking logic here
}

$(document).ready(function () {
    getCategory();
    getMovie();
});


