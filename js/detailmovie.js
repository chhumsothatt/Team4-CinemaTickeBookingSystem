$(document).ready(function () {
    if (window.location.pathname.includes('detail.php')) {
        getMovieDetail();
    }
});

/**
 * Fetch movie details from backend API
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
            console.log("API Response:", response);

            if (response.success && response.movie) {
                const movie = response.movie;
                const showtimes = response.showtimes || [];

                // Populate Movie Info
                $('#movieTitle').text(movie.title || 'No Title');
                $('#mModalTitle').text(movie.title || 'No Title');
                $('#movieDesc').text(movie.description || 'មិនទាន់មានការពិពណ៌នា។');
                $('#movieCategory').text(movie.category_name || 'General');
                $('#movieDuration').text((movie.duration_minutes || '0') + ' នាទី');
                $('#movierelease').text(movie.release_date || 'N/A');

                const posterPath = movie.poster ? `../upload/${movie.poster}` : '../upload/image.png';
                $('#moviePoster').attr('src', posterPath);

                // Render Showtimes
                renderShowtimes(showtimes);
            } else {
                alert(response.message || 'មិនអាចទាញយកទិន្នន័យបានទេ');
            }
        },
        error: function (xhr, status, error) {
            console.error('API Error Response:', xhr.responseText);
            alert('Internal Server Error: មិនអាចភ្ជាប់ទៅកាន់ API បានទេ!');
        }
    });
}

/**
 * Dynamic Render Showtimes
 */
function renderShowtimes(showtimes) {
    const $container = $('#showtimesContainer');
    $container.empty();

    if (!showtimes || showtimes.length === 0) {
        $container.html('<p class="text-muted">មិនទាន់មានម៉ោងបញ្ចាំងសម្រាប់រឿងនេះនៅឡើយទេ។</p>');
        $('#movieRoom').text('N/A');
        $('#mModalRoom').text('N/A');
        $('#ticket_price').text('$0.00');
        $('#tTotal').text('$0.00');
        return;
    }

    showtimes.forEach((st, index) => {
        const isChecked = index === 0 ? 'checked' : '';
        const timeDisplay = st.formatted_time || st.start_time;
        const fullDisplayTime = `${st.formatted_date || ''} - ${timeDisplay}`;
        const priceDisplay = parseFloat(st.ticket_price).toFixed(2);

        const boxHtml = `
            <div>
                <input type="radio" class="showtime-card-input" name="showtime" id="st_${st.id}" value="${st.id}" 
                       data-time="${fullDisplayTime}" 
                       data-room="${st.room_name}" 
                       data-price="${priceDisplay}" ${isChecked}>
                <label class="showtime-card-label" for="st_${st.id}">
                    <div class="fw-bold text-primary fs-5">${timeDisplay}</div>
                    <div class="small text-muted fw-semibold">${st.room_name}</div>
                    <div class="badge bg-light text-dark border mt-1">$${priceDisplay}</div>
                </label>
            </div>
        `;
        $container.append(boxHtml);
    });

    // Update Initial Badge Room and Ticket Price
    updateSelectedShowtimeInfo();
}

// Event handler on showtime selection change
$(document).on('change', 'input[name="showtime"]', function () {
    updateSelectedShowtimeInfo();
});

function updateSelectedShowtimeInfo() {
    const selected = $('input[name="showtime"]:checked');
    if (selected.length > 0) {
        const timeStr = selected.data('time');
        const price = parseFloat(selected.data('price')).toFixed(2);
        const room = selected.data('room');

        $('#tTime').text(timeStr);
        $('#movieRoom').text(room);
        $('#mModalRoom').text(room);
        $('#ticket_price').text(`$${price}`);
        $('#tTotal').text(`$${price}`);
    }
}

// ចាប់ Click Event លើប៊ូតុង កក់សំបុត្រឥឡូវនេះ
$(document).on('click', '#btnGoToBooking', function (e) {
    e.preventDefault();

    const selectedShowtime = $('input[name="showtime"]:checked').val();

    // ពិនិត្យមើលថាតើអ្នកប្រើប្រាស់បានជ្រើសរើសម៉ោងបញ្ចាំងហើយឬនៅ
    if (!selectedShowtime) {
        alert('សូមជ្រើសរើសម៉ោងបញ្ចាំងជាមុនសិន! (ឬមិនទាន់មានម៉ោងបញ្ចាំងសម្រាប់រឿងនេះទេ)');
        return;
    }

    // Redirect ទៅកាន់ទំព័រ booking.php ជាមួយ showtime_id
    window.location.href = `./booking.php?showtime_id=${selectedShowtime}`;
});