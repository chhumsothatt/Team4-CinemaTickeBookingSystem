$(document).ready(function() {

    // ១. ប្រសិនបើនៅលើទំព័រ Table (showtime.php)
    if ($('#showtime_table_body').length > 0) {
        loadShowtimes();
    }

    // ២. ប្រសិនបើនៅលើទំព័រ Add/Edit Showtime
    if ($('#movie_select').length > 0 || $('#room_select').length > 0) {
        loadMovieOptions();
        loadRoomOptions();

        // 💡 ប្រសិនបើជាទំព័រ editTime.php (មាន #showtime_id) ឱ្យទាញទិន្នន័យចាស់មកដាក់ក្នុង Form
        if ($('#showtime_id').length > 0 && $('#showtime_id').val() !== '') {
            loadShowtimeDetails($('#showtime_id').val());
        }
    }

    // ៣. Submit Form Add Showtime (createTime.php)
    $(document).on('submit', '#createTimeForm', function(e) {
        e.preventDefault();
        $.ajax({
            url: '../api/showtime/insert.php',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(res) {
                if (res.success || res.status === 'success') {
                    alert(res.message || 'Showtime created successfully!');
                    window.location.href = 'showtime.php';
                } else {
                    alert(res.message || 'Failed to save showtime.');
                }
            },
            error: function(xhr) {
                alert("Error: " + xhr.responseText);
            }
        });
    });

    // 💡 ៤. SUBMIT FORM EDIT SHOWTIME (editTime.php)
    $(document).on('submit', '#editTimeForm', function(e) {
        e.preventDefault(); // ការពារកុំឱ្យលោតទិន្នន័យលើ URL

        // 💡 ពិនិត្យមើលឈ្មោះ file API របស់អ្នក ( edit.php ឬ update.php )
        let apiUrl = '../api/showtime/edit.php'; 

        $.ajax({
            url: apiUrl,
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(res) {
                if (res.success || res.status === 'success') {
                    alert(res.message || 'Showtime updated successfully!');
                    window.location.href = 'showtime.php';
                } else {
                    alert(res.message || 'Failed to update showtime.');
                }
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                alert("Error updating showtime: " + xhr.responseText);
            }
        });
    });

    // Function ទាញយកព័ត៌មាន Showtime ចាស់មកបង្ហាញក្នុង Form Edit
    // Function ទាញយកព័ត៌មាន Showtime ចាស់មកបង្ហាញក្នុង Form Edit
    function loadShowtimeDetails(id) {
        $.ajax({
            url: '../api/showtime/get.php',
            type: 'GET',
            data: { id: id },
            dataType: 'json',
            success: function(response) {
                if ((response.status === 'success' || response.success) && response.data) {
                    let showtime = response.data;

                    // ១. បំពេញ Text Inputs មុន
                    $('#show_date').val(showtime.show_date);
                    $('#start_time').val(showtime.start_time);
                    $('#end_time').val(showtime.end_time);
                    $('#price').val(showtime.price);

                    // ២. រង់ចាំ 300ms ឱ្យ Dropdown Movies & Rooms Load Options ចប់ សឹម Set Value តាមក្រោយ
                    setTimeout(function() {
                        $('#movie_select').val(showtime.movie_id);
                        $('#room_select').val(showtime.room_id);
                    }, 300);
                }
            },
            error: function(xhr) {
                console.error("Error loading showtime details:", xhr.responseText);
            }
        });
    }
    // Function ទាញយក Movies មកដាក់ក្នុង Dropdown
    function loadMovieOptions() {
        $.ajax({
            url: '../api/movie/get.php',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if ((response.status === 'success' || response.success) && response.data) {
                    let options = '<option value="">-- Select Movie --</option>';
                    if (response.data.length > 0) {
                        response.data.forEach(movie => {
                            options += `<option value="${movie.id}">${movie.title}</option>`;
                        });
                    } else {
                        options = '<option value="">No movies found</option>';
                    }
                    $('#movie_select').html(options);
                } else {
                    $('#movie_select').html('<option value="">No movies found</option>');
                }
            },
            error: function() {
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
                if ((response.status === 'success' || response.success) && response.data) {
                    let options = '<option value="">-- Select Cinema Room --</option>';
                    if (response.data.length > 0) {
                        response.data.forEach(room => {
                            options += `<option value="${room.id}">${room.room_name}</option>`;
                        });
                    } else {
                        options = '<option value="">No rooms found</option>';
                    }
                    $('#room_select').html(options);
                } else {
                    $('#room_select').html('<option value="">No rooms found</option>');
                }
            },
            error: function() {
                $('#room_select').html('<option value="">Error loading rooms</option>');
            }
        });
    }

    // Function Load ទិន្នន័យ Showtimes (នៅលើ showtime.php)
    function loadShowtimes() {
        $.ajax({
            url: '../api/showtime/get.php',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if ((response.status === 'success' || response.success) && response.data) {
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
                    alert(res.message || 'Deleted successfully!');
                    if (res.success || res.status === 'success') loadShowtimes();
                }
            });
        }
    });

});