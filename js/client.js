const API = '../api/client/';

// 1. Function ទាញយកភាពយន្ត (Movies)
function getMovie() {
    const keyword = $('#movieSearch').val().trim();
    const categoryId = $('#catFilter').val();

    $.ajax({
        url: API + "get.php",
        method: 'GET',
        data: {
            search: keyword,
            category_id: categoryId
        },
        dataType: 'json',
        success: function(res) {
            const $catebody = $('#catebody');
            $catebody.empty();
            
            if (res.success && res.data && res.data.length > 0) {
                // អាប់ដេតចំនួនភាពយន្ត
                $('#resultCount').text(`${res.data.length} movies`);

                $.each(res.data, function (index, movie) {
                    const posterImg = movie.poster ? `../upload/${movie.poster}` : 'https://i.pinimg.com/736x/3d/b0/6e/3db06e05d7dd29897726c1be94c00d65.jpg';

                    $catebody.append(`
                        <div class="col-md-3 col-sm-6">
                            <div class="card movie-card shadow-sm h-100">
                                <img src="${posterImg}" class="card-img-top"  style="height: 230px; object-fit: cover;">
                                <div class="card-body d-flex flex-column justify-content-between">
                                    <div>
                                        <div class="d-flex align-items-center mb-1">
                                            <h6 class="card-title font-display fs-6 mb-0 text-truncate me-2" title="${movie.title}">${movie.title}</h6>
                                            <span class="font-display fs-6 ms-auto text-danger text-nowrap">${movie.duration_minutes} នាទី</span>
                                        </div>
                                        <span class="badge bg-secondary mb-2">${movie.category_name}</span>
                                    </div>
                                    <a href="#booking" onclick="selectMovie(${movie.id})" class="btn btn-marquee w-100 mt-2">កក់សំបុត្រ</a>
                                </div>
                            </div>
                        </div>
                    `);  
                });
            } else {
                $('#resultCount').text('0 movies');
                $catebody.append(`
                    <div class="col-12 text-center py-5 text-muted">
                        <i class="bi bi-film fs-1 d-block mb-2"></i>
                        <p class="mb-0">មិនមានភាពយន្តដែលអ្នកស្វែងរកឡើយ (No Movies Found)</p>
                    </div>
                `);
            }
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error Details:", xhr.responseText);
            $('#resultCount').text('0 movies');
            $('#catebody').html(`
                <div class="col-12 text-center text-danger py-5">
                    <i class="bi bi-exclamation-triangle fs-1 d-block mb-2"></i>
                    <p class="fw-bold mb-1">មានបញ្ហាក្នុងការទាញយកទិន្នន័យ!</p>
                    <small class="text-muted">សូមពិនិត្យមើល Console (F12) ដើម្បីមើល Error លម្អិត</small>
                </div>
            `);
        }
    });
}

// 2. Trigger Event ពេល Search ឬប្តូរ Category
function liveSearch() {
    getMovie();
}

// 3. Function ទាញយក Categories មកដាក់ក្នុង Select Dropdown
const getCategory = () => {
    $.ajax({
        url: API + 'getcategory.php',
        method: 'GET',
        dataType: 'json',
        success: function(res) {
            let categoryElement = $('#catFilter');
            categoryElement.empty();
            categoryElement.append(`<option value="">All Categories</option>`);
            
            if (res.success && res.data.length > 0) {
                $.each(res.data, function (index, category) {
                    categoryElement.append(`
                        <option value="${category.id}">${category.name}</option>
                    `);
                });
            }
        },
        
    });
};

$(document).ready(function() {
    getCategory();
    getMovie();
});