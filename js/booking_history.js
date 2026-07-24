$(document).ready(function () {
    fetchBookingHistory();

    function fetchBookingHistory() {
        $.ajax({
            url: '../api/client/booking_history.php',
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                const tbody = $('#bookingHistoryTableBody');
                tbody.empty();

                if (!response.success) {
                    tbody.html(`
                        <tr>
                            <td colspan="5" class="text-center py-4 text-danger fw-bold">
                                ${response.message}
                            </td>
                        </tr>
                    `);
                    return;
                }

                if (response.data.length === 0) {
                    tbody.html(`
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                អ្នកមិនទាន់មានប្រវត្តិការកក់សំបុត្រនៅឡើយទេ
                            </td>
                        </tr>
                    `);
                    return;
                }

                let html = '';
                response.data.forEach(item => {
                    // បំបែក start_time ទៅជា Date និង Time
                    const datetime = new Date(item.start_time);
                    const formattedDate = datetime.toLocaleDateString('en-GB'); // DD/MM/YYYY
                    const formattedTime = datetime.toLocaleTimeString('en-US', { 
                        hour: '2-digit', 
                        minute: '2-digit', 
                        hour12: true 
                    });

                    // កំណត់ Status Label
                    let statusBadge = '<span class="status-badge-confirmed d-inline-flex align-items-center gap-1"><i class="bi bi-check-circle-fill"></i> Paid</span>';
                    if (item.status === 'pending') {
                        statusBadge = '<span class="badge bg-warning text-dark px-3 py-2 rounded-pill"><i class="bi bi-clock-history"></i> Pending</span>';
                    } else if (item.status === 'cancelled') {
                        statusBadge = '<span class="badge bg-danger px-3 py-2 rounded-pill"><i class="bi bi-x-circle"></i> Cancelled</span>';
                    }

                    html += `
                        <tr>
                            <td>
                                <span class="movie-title-text fs-6">${item.movie_title}</span>
                            </td>
                            <td><span class="text-muted fw-semibold">${formattedDate}</span></td>
                            <td><span class="fw-bold text-dark">${formattedTime}</span></td>
                            <td><span class="seat-badge font-mono">${item.seat}</span></td>
                            <td>${statusBadge}</td>
                        </tr>
                    `;
                });

                tbody.html(html);
            },
            error: function (xhr, status, error) {
                console.error("Fetch Error:", error);
                $('#bookingHistoryTableBody').html(`
                    <tr>
                        <td colspan="5" class="text-center py-4 text-danger fw-bold">
                            មានបញ្ហាក្នុងការទាញយកទិន្នន័យ!
                        </td>
                    </tr>
                `);
            }
        });
    }
});