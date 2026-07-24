$(document).ready(function() {

    // ------------------------------------
    // ១. ទាញទិន្នន័យចាស់មកដាក់ Form Edit (ពេលបើក editRoom.php)
    // ------------------------------------
    if ($('#editRoomForm').length > 0) {
        let roomId = $('#room_id').val();
        if (roomId) {
            $.ajax({
                url: '../api/room/get.php',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.success && response.data) {
                        let room = response.data.find(r => r.id == roomId);
                        if (room) {
                            $('#room_name').val(room.room_name);
                            $('#total_seats').val(room.total_seats);
                        }
                    }
                }
            });
        }
    }

    // ------------------------------------
    // ២. Action ពេល Submit បង្កើតបន្ទប់ (createRoom.php)
    // ------------------------------------
    $(document).on('submit', '#addRoomForm', function(e) {
        e.preventDefault(); //  ការពារកុំឱ្យលោតទិន្នន័យលើ URL

        $.ajax({
            url: '../api/room/insert.php',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(res) {
                alert(res.message);
                if (res.success) {
                    window.location.href = 'room.php'; // ជោគជ័យ ឱ្យរត់ទៅទំព័រ room.php
                }
            },
            error: function(xhr) {
                alert("Error: " + xhr.responseText);
            }
        });
    });

    // ------------------------------------
    // ៣. Action ពេល Submit កែប្រែបន្ទប់ (editRoom.php)
    // ------------------------------------
    $(document).on('submit', '#editRoomForm', function(e) {
        e.preventDefault(); // 💡 សំខាន់បំផុត! ការពារកុំឱ្យលោតទិន្នន័យលើ URL

        $.ajax({
            url: '../api/room/edit.php',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(res) {
                alert(res.message);
                if (res.success) {
                    window.location.href = 'room.php'; // ជោគជ័យ ឱ្យរត់ទៅទំព័រ room.php
                }
            },
            error: function(xhr) {
                alert("Error: " + xhr.responseText);
            }
        });
    });

    // ------------------------------------
    // ៤. ទាញយកបញ្ជីបន្ទប់មកបង្ហាញក្នុង Table (room.php)
    // ------------------------------------
    if ($('#room_table_body').length > 0) {
        loadRooms();
    }

    function loadRooms() {
        $.ajax({
            url: '../api/room/get.php',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    let rows = '';
                    if (response.data && response.data.length > 0) {
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
                        rows = '<tr><td colspan="3" class="text-center py-3 text-muted">No rooms found</td></tr>';
                    }
                    $('#room_table_body').html(rows);
                }
            }
        });
    }

    // ------------------------------------
    //  (Delete Room)
    // ------------------------------------
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