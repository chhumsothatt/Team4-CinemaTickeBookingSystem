$(document).ready(function() {

    // ១. ប្រសិនបើនព៌នលើទំព័រ Table (showtime.php)
    if ($('#showtime_table_body').length > 0) {
        loadShowtimes();
    }

    // ២. ប្រសិនបើនព៌នលើទំព័រ Add/Edit Showtime (createTime.php / editTime.php)
    if ($('#movie_select').length > 0 || $('#room_select').length > 0) {
        loadMovieOptions();
        loadRoomOptions();
    }

    // Function ទាញយក Movies មកដាក់ក្នុង Dropdown
    function loadMovieOptions() {
        $.ajax({
            url: '../api/movie/get.php',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success && response.data) {
                    let selectedId = $('#movie_select').attr('data-selected') || '';
                    let options = '<option value="">-- Select Movie --</option>';
                    
                    response.data.forEach(movie => {
                        let isSelected = (movie.id == selectedId) ? 'selected' : '';
                        options += `<option value="${movie.id}" ${isSelected}>${movie.title}</option>`;
                    });

                    $('#movie_select').html(options);
                } else {
                    $('#movie_select').html('<option value="">No movies found</option>');
                }
            },
            error: function(xhr, status, error) {
                console.error("Error loading movies:", error);
                $('#movie_select').html('<option value="">Error loading movies</option>');
            }
        });
    }

    // Function ទាញយក Cinema Rooms មកដាក់ក្នុង Dropdown
    function loadRoomOptions() {
        $.ajax({
            url: '../api/room/get.php',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success && response.data) {
                    let selectedId = $('#room_select').attr('data-selected') || '';
                    let options = '<option value="">-- Select Cinema Room --</option>';
                    
                    response.data.forEach(room => {
                        let isSelected = (room.id == selectedId) ? 'selected' : '';
                        options += `<option value="${room.id}" ${isSelected}>${room.room_name}</option>`;
                    });

                    $('#room_select').html(options);
                } else {
                    $('#room_select').html('<option value="">No rooms found</option>');
                }
            },
            error: function(xhr, status, error) {
                console.error("Error loading rooms:", error);
                $('#room_select').html('<option value="">Error loading rooms</option>');
            }
        });
    }

    // Function Load ទិន្នន័យ Showtimes
    function loadShowtimes() {
        $.ajax({
            url: '../api/showtime/get.php',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success && response.data) {
                    let rows = '';
                    if (response.data.length > 0) {
                        response.data.forEach(item => {
                            rows += `
                                <tr>
                                    <td class="fw-medium">${item.movie_title}</td>
                                    <td>${item.room_name}</td>
                                    <td>${item.formatted_date}</td>
                                    <td class="fw-bold">${item.formatted_time}</td>
                                    <td class="text-end">
                                        <a href="editTime.php?id=${item.id}" class="btn btn-sm btn-outline-secondary me-1">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button class="btn btn-sm btn-outline-danger btn-delete-showtime" data-id="${item.id}">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            `;
                        });
                    } else {
                        rows = '<tr><td colspan="5" class="text-center py-3">No showtimes found</td></tr>';
                    }
                    $('#showtime_table_body').html(rows);
                }
            }
        });
    }

    // Delete Showtime
    $(document).on('click', '.btn-delete-showtime', function() {
        let id = $(this).data('id');
        if (confirm('Are you sure you want to delete this showtime?')) {
            $.ajax({
                url: '../api/showtime/delete.php',
                type: 'POST',
                data: { id: id },
                dataType: 'json',
                success: function(res) {
                    alert(res.message);
                    if (res.success) loadShowtimes();
                }
            });
        }
    });

});
