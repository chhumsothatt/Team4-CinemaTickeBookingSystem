$(document).ready(function() {
    let allBookings = []; // រក្សាទុកទិន្នន័យដើមសម្រាប់ Filter

    if ($('#booking_history_table').length > 0) {
        loadBookingHistory();
    }

    function loadBookingHistory() {
        $.ajax({
            url: '../api/booking/get_history.php',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    allBookings = response.data;
                    renderTable(allBookings);
                } else {
                    alert("Error: " + response.message);
                }
            }
        });
    }

    function renderTable(data) {
        let rows = '';
        if (data && data.length > 0) {
            data.forEach(item => {
                // Formatting Showtime (ឧទាហរណ៍: 25/07 - 7:30 PM)
                let showtimeStr = item.show_date ? `${item.show_date} - ${item.start_time}` : 'N/A';
                
                // Status Badge
                let statusBadge = '<span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3">Confirmed</span>';
                if (item.status === 'pending') {
                    statusBadge = '<span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill px-3">Pending</span>';
                } else if (item.status === 'cancelled') {
                    statusBadge = '<span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill px-3">Cancelled</span>';
                }

                rows += `
    <tr>
        <td class="fw-bold">#BK10${item.booking_id}</td>
        <td>${item.user_name || 'N/A'}</td>
        <td class="fw-medium">${item.movie_title || 'N/A'}</td>
        <td class="text-secondary">${item.showtime_formatted || 'N/A'}</td>
        <td>${item.seat_number || 'N/A'}</td>
        <td>${statusBadge}</td>
    </tr>
`;
            });
        } else {
            rows = '<tr><td colspan="6" class="text-center py-4 text-muted">No booking records found</td></tr>';
        }
        $('#booking_history_table').html(rows);
    }

    // Search Box Functionality
    $('#searchInput').on('keyup', function() {
        let value = $(this).val().toLowerCase();
        let filtered = allBookings.filter(item => 
            (item.user_name && item.user_name.toLowerCase().includes(value)) ||
            (item.movie_title && item.movie_title.toLowerCase().includes(value))
        );
        renderTable(filtered);
    });

    // Filter by Status Functionality
    $('#statusFilter').on('change', function() {
        let status = $(this).val();
        if (status === 'all') {
            renderTable(allBookings);
        } else {
            let filtered = allBookings.filter(item => item.status === status);
            renderTable(filtered);
        }
    });
});