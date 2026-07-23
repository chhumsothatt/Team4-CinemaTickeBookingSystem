//============page detail
$(document).ready(function () {
    // Automatically trigger fetch if viewing detail.php
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
            if (response.success && response.movie) {
                const movie = response.movie;
                const showtimes = response.showtimes || [];

                // Safe text extraction with fallback to prevent undefined trim errors
                const titleText = (movie.title || '').trim();
                const descText = (movie.description || '').trim();

                // Populate Text fields
                $('#movieTitle').text(titleText || 'No Title');
                $('#mModalTitle').text(titleText || 'No Title');
                $('#movieDesc').text(descText || 'មិនទាន់មានការពិពណ៌នា។');
                $('#movieCategory').text((movie.category_name || 'General').trim());
                $('#movieDuration').text((movie.duration_minutes || '0') + ' នាទី');
                $('#movierelease').text((movie.release_date || '0'));
                $('#ticket_price').text((movie.price || '0'));

                // Poster Image Fix (Fallbacks to image.png if missing)
                const posterPath = movie.poster ? `../upload/${movie.poster}` : '../upload/image.png';
                $('#moviePoster').attr('src', posterPath);

                // Populate Showtimes
                // renderShowtimes(showtimes);
            } else {
                alert(response.message || 'មិនអាចទាញយកទិន្នន័យបានទេ');
            }
        },
        error: function (xhr, status, error) {
            console.error('API Error:', error);
            alert('Internal Server Error: មិនអាចភ្ជាប់ទៅកាន់ Server បានទេ!');
        }
    });
}

/**
 * Render dynamic showtimes buttons
 */
function renderShowtimes(showtimes) {
    const $container = $('#showtimesContainer');
    $container.empty();

    if (!showtimes || showtimes.length === 0) {
        $container.html('<p class="text-muted">មិនទាន់មានម៉ោងបញ្ចាំងនៅឡើយទេ។</p>');
        $('#movieRoom').text('N/A');
        $('#mModalRoom').text('N/A');
        $('#ticketPrice').text('$0.00');
        $('#tTotal').text('$0.00');
        return;
    }

    // Set first showtime room name
    if (showtimes[0].room_name) {
        $('#movieRoom').text(showtimes[0].room_name);
        $('#mModalRoom').text(showtimes[0].room_name);
    }

    showtimes.forEach((st, index) => {
        const isChecked = index === 0 ? 'checked' : '';
        const startTime = new Date(st.start_time);
        
        // Format time display (e.g., 07:30 PM)
        const formattedTime = startTime.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        const formattedDateTime = startTime.toLocaleString();

        const radioHtml = `
            <input type="radio" class="btn-check" name="showtime" id="st_${st.id}" value="${st.id}" 
                   data-time="${formattedDateTime}" 
                   data-room="${st.room_name}" 
                   data-price="${st.ticket_price}" ${isChecked}>
            <label class="btn btn-outline-cinema font-mono" for="st_${st.id}">${formattedTime}</label>
        `;
        $container.append(radioHtml);
    });

    // Initialize modal with first selection
    updateSelectedShowtimeInfo();
}

// // Event handler on showtime selection change
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
        $('#ticketPrice').text(`$${price}`);
        $('#tTotal').text(`$${price}`);
    }
}
