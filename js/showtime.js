$(document).ready(function() {
    loadShowtimes();

    // 💡 ទាញយក URL Params ដើមី្បដឹងថាស្ថិតនៅលើ Page ណា
    let urlParams = new URLSearchParams(window.location.search);
    let showtimeId = urlParams.get('id');

    // ពិនិត្យមើល Page editTime.php (មាន ID)
    if (showtimeId && window.location.pathname.includes('editTime.php')) {
        $.when(loadMoviesDropdown(), loadRoomsDropdown()).done(function() {
            loadShowtimeForEdit(showtimeId);
        });
    } 
    // ប្រសិនបើជា Page createTime.php (គ្មាន ID) ឱ្យ Load តែ Dropdown មកបានហើយ
    else if ($('#createTimeForm').length > 0) {
        loadMoviesDropdown();
        loadRoomsDropdown();
    } else {
        loadMoviesDropdown();
        loadRoomsDropdown();
    }

    // 1. Fetch និង Render Showtimes Table
    function loadShowtimes() {
        if ($('#showtime_table_body').length === 0) return;
        $.ajax({
            url: '../api/showtime/get.php',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    renderShowtimes(response.data);
                }
            }
        });
    }

    function renderShowtimes(data) {
        let rows = '';
        if (data && data.length > 0) {
            data.forEach(item => {
                let rawPoster = item.movie_poster || '';
                let fileName = rawPoster.replace(/^posters\//, '');
                
                let posterSrc = fileName 
                    ? `../upload/${fileName}` 
                    : 'https://via.placeholder.com/45x60?text=No+Img';

                let timeStr = (item.start_time_formatted && item.end_time_formatted) 
                    ? `${item.start_time_formatted} - ${item.end_time_formatted}` 
                    : 'N/A';

                rows += `
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <img src="${posterSrc}" 
                                     alt="${item.movie_title || ''}" 
                                     class="rounded shadow-sm" 
                                     style="width: 45px; height: 60px; object-fit: cover;"
                                     onerror="this.onerror=null; this.src='https://via.placeholder.com/45x60?text=No+Img';">
                                <span class="fw-bold text-dark">${item.movie_title || 'N/A'}</span>
                            </div>
                        </td>
                        <td>${item.room_name || 'N/A'}</td>
                        <td>${item.show_date || 'N/A'}</td>
                        <td class="fw-semibold">${timeStr}</td>
                        <td class="text-end">
                            <div class="d-inline-flex gap-1">
                                <button class="btn btn-sm btn-outline-secondary edit-btn p-2" data-id="${item.id}">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-danger delete-btn p-2" data-id="${item.id}">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
            });
        } else {
            rows = '<tr><td colspan="5" class="text-center py-4 text-muted">មិនទាន់មានទិន្នន័យបង្ហាញឡើយ</td></tr>';
        }
        $('#showtime_table_body').html(rows);
    }

    // 2. Load Movie Dropdown
    function loadMoviesDropdown() {
        return $.ajax({
            url: '../api/movie/get.php',
            type: 'GET',
            dataType: 'json',
            success: function(res) {
                let options = '<option value="">-- Select Movie --</option>';
                let list = res.data ? res.data : res;
                if (Array.isArray(list)) {
                    list.forEach(m => {
                        options += `<option value="${m.id}">${m.title}</option>`;
                    });
                }
                $('#movie_id, #movie_select').html(options);
            }
        });
    }

    // 3. Load Room Dropdown
    function loadRoomsDropdown() {
        return $.ajax({
            url: '../api/room/get.php',
            type: 'GET',
            dataType: 'json',
            success: function(res) {
                let options = '<option value="">-- Select Cinema Room --</option>';
                let list = res.data ? res.data : res;
                if (Array.isArray(list)) {
                    list.forEach(r => {
                        let rName = r.room_name || r.name;
                        options += `<option value="${r.id}">${rName}</option>`;
                    });
                }
                $('#room_id, #room_select').html(options);
            }
        });
    }

    // 4. Fetch ទិន្នន័យចាស់មកដាក់ក្នុង Form ពេល Edit
    function loadShowtimeForEdit(id) {
        $.ajax({
            url: '../api/showtime/get_by_id.php',
            type: 'GET',
            data: { id: id },
            dataType: 'json',
            success: function(res) {
                if (res.success) {
                    let d = res.data;
                    $('#showtime_id').val(d.id);
                    $('#movie_select').val(d.movie_id);
                    $('#room_select').val(d.room_id);
                    $('#show_date').val(d.show_date);
                    $('#start_time').val(d.start_time);
                    $('#end_time').val(d.end_time);
                    $('#price').val(d.price);
                } else {
                    alert('Error: ' + res.message);
                }
            }
        });
    }

    // 5. 💡 SUBMIT FORM ADD / CREATE SHOWTIME (#createTimeForm)
    $(document).on('submit', '#createTimeForm, #addShowtimeForm', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: '../api/showtime/insert.php',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(res) {
                if (res.success) {
                    alert(res.message);
                    window.location.href = 'showtime.php';
                } else {
                    alert(' Error: ' + res.message);
                }
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                alert('មានបញ្ហាក្នុងការ Save Showtime! (សូមពិនិត្យមើល Console)');
            }
        });
    });

    // 6. SUBMIT FORM EDIT SHOWTIME (#editTimeForm)
    $(document).on('submit', '#editTimeForm', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: '../api/showtime/edit.php',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(res) {
                if (res.success) {
                    alert(res.message);
                    window.location.href = 'showtime.php';
                } else {
                    alert(' Error: ' + res.message);
                }
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                alert('មានបញ្ហាក្នុងការ Save Updates!');
            }
        });
    });

    // 7. Click Actions
    $(document).on('click', '.edit-btn', function() {
        let id = $(this).data('id');
        window.location.href = `editTime.php?id=${id}`;
    });

    $(document).on('click', '.delete-btn', function() {
        let id = $(this).data('id');
        if (confirm('តើអ្នកពិតជាចង់លុប Showtime នេះមែនទេ?')) {
            $.ajax({
                url: '../api/showtime/delete.php',
                type: 'POST',
                data: { id: id },
                dataType: 'json',
                success: function(res) {
                    if (res.success) {
                        alert(res.message);
                        loadShowtimes();
                    } else {
                        alert('Error: ' + res.message);
                    }
                }
            });
        }
    });

});