$(document).ready(function() {
    loadRooms();

    function loadRooms() {
        $.ajax({
            url: '../api/room/get.php',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    let rows = '';
                    if (response.data.length > 0) {
                        response.data.forEach(room => {
                            rows += `
                                <tr>
                                    <td class="fw-medium">${room.room_name}</td>
                                    <td>${room.total_seats} seats</td>
                                    <td class="text-end">
                                        <a href="editRoom.php?id=${room.id}" class="btn btn-sm btn-outline-secondary me-1">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button class="btn btn-sm btn-outline-danger btn-delete-room" data-id="${room.id}">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            `;
                        });
                    } else {
                        rows = '<tr><td colspan="3" class="text-center">No rooms found</td></tr>';
                    }
                    $('#room_table_body').html(rows);
                }
            }
        });
    }

    // Delete Room
    $(document).on('click', '.btn-delete-room', function() {
        let id = $(this).data('id');
        if (confirm('Are you sure you want to delete this room?')) {
            $.ajax({
                url: '../api/room/delete.php',
                type: 'POST',
                data: { id: id },
                dataType: 'json',
                success: function(res) {
                    alert(res.message);
                    if (res.success) loadRooms();
                }
            });
        }
    });
});

