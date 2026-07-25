let selectedSeats = [];
let ticketPrice = 0;
let showtimeId = null;

$(document).ready(function () {
    const urlParams = new URLSearchParams(window.location.search);
    showtimeId = urlParams.get('showtime_id');

    if (!showtimeId) {
        alert('សូមជ្រើសរើសម៉ោងបញ្ចាំងជាមុនសិន!');
        window.location.href = './index.php';
        return;
    }

    loadBookingData(showtimeId);

    // Toggle seat selection
    $(document).on('click', '.seat.available', function () {
        const seatId = $(this).data('id');
        const seatName = $(this).data('name');

        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
            selectedSeats = selectedSeats.filter(s => s.id !== seatId);
        } else {
            $(this).addClass('selected');
            selectedSeats.push({ id: seatId, name: seatName });
        }

        updateSummary();
    });

// Open Payment Modal
$('#btnBookNow').click(function () {
    if (selectedSeats.length === 0) return;
    
    const total = (selectedSeats.length * ticketPrice).toFixed(2);
    $('#modalTotalPrice').text(`$${total}`);
    
    // បើក Modal តាមរយៈ jQuery (មិនចេញ Error ទៀតទេ)
    $('#paymentModal').modal('show');
});

    // Submit Payment to backend API
// Submit Payment to backend API
$('#btnConfirmPayment').click(function () {
    const btn = $(this);
    btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>កំពុងដំណើរការ...');

    const seatIds = selectedSeats.map(s => s.id);

    $.ajax({
        url: '../api/client/booking.php',
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({
            showtime_id: showtimeId,
            seat_ids: seatIds
        }),
        success: function (response) {
            btn.prop('disabled', false).html('<i class="bi bi-check-circle me-1"></i> ខ្ញុំបានទូទាត់រួចរាល់');
            
            if (response.success) {
                // 📍 ដាក់$('#paymentModal').modal('hide'); នៅត្រង់នេះដើម្បីបិទ Modal
                $('#paymentModal').modal('hide');

                alert('🎉 ការកក់សំបុត្រជោគជ័យ! សូមអរគុណ។');
                window.location.href = './index.php';
            } else {
                alert('បរាជ័យ: ' + response.message);
            }
        },
        error: function (xhr) {
            btn.prop('disabled', false).html('<i class="bi bi-check-circle me-1"></i> ខ្ញុំបានទូទាត់រួចរាល់');
            console.error(xhr.responseText);
            alert('Internal Server Error: មិនអាចកក់សំបុត្របានទេ!');
        }
    });
});
});

/**
 * Fetch booking info and seat layout
 */
function loadBookingData(id) {
    $.ajax({
        url: '../api/client/booking.php',
        method: 'GET',
        data: { showtime_id: id },
        dataType: 'json',
        success: function (res) {
            if (res.success) {
                const st = res.showtime;
                ticketPrice = parseFloat(st.ticket_price);

                $('#movieTitle').text(st.movie_title);
                $('#movieRoom').text(st.room_name);
                $('#showDate').text(st.formatted_date);
                $('#showTime').text(st.formatted_time);
                
                if (st.poster) {
                    $('#moviePoster').attr('src', `../upload/${st.poster}`);
                }

                renderSeats(res.seats || [], res.booked_seat_ids || []);
            } else {
                alert(res.message);
            }
        },
        error: function (xhr) {
            console.error(xhr.responseText);
            alert('មិនអាចទាញយកទិន្នន័យកៅអីបានទេ!');
        }
    });
}

/**
 * Render dynamic seat grid
 */
function renderSeats(seats, bookedIds) {
    const $container = $('#seatMapContainer');
    $container.empty();

    if (seats.length === 0) {
        $container.html('<p class="text-muted">មិនទាន់មានកៅអីនៅក្នុងបន្ទប់នេះទេ។</p>');
        return;
    }

    seats.forEach(seat => {
        const isBooked = bookedIds.includes(seat.id) || bookedIds.includes(String(seat.id));
        const seatName = `${seat.seat_row}${seat.seat_number}`;
        const statusClass = isBooked ? 'booked' : 'available';

        const seatHtml = `
            <div class="seat ${statusClass}" 
                 data-id="${seat.id}" 
                 data-name="${seatName}">
                ${seatName}
            </div>
        `;
        $container.append(seatHtml);
    });
}

/**
 * Update aggregate counts and totals in UI
 */
function updateSummary() {
    const count = selectedSeats.length;
    const total = (count * ticketPrice).toFixed(2);

    $('#seatCount').text(count);
    $('#totalPrice').text(`$${total}`);

    if (count > 0) {
        const names = selectedSeats.map(s => s.name).join(', ');
        $('#selectedSeatsList').text(names);
        $('#btnBookNow').prop('disabled', false);
    } else {
        $('#selectedSeatsList').text('មិនទាន់រើស');
        $('#btnBookNow').prop('disabled', true);
    }
}