$(document).ready(function () {
    loadCategories();

    // Fetch and display categories
    function loadCategories() {
        $.ajax({
            url: '../api/category/get.php',
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    let rows = '';
                    if (response.data.length === 0) {
                        rows = `<tr><td colspan="3" class="text-center py-4">No categories found.</td></tr>`;
                    } else {
                        response.data.forEach(cat => {
                            rows += `
                                <tr>
                                    <td class="ps-4">
                                        <span class="badge bg-light text-dark  px-3 py-2 ">${cat.name}</span>
                                    </td>
                                    <td class=" text-black-50" >${cat.movie_count} movies</td>
                                    <td class="text-end pe-4">
                                        <a href="editCategory.php?id=${cat.id}" class="btn btn-sm btn-outline-secondary me-1   ">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button class="btn btn-sm btn-outline-danger btn-delete" data-id="${cat.id}">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            `;
                        });
                    }
                    $('#categoryTableBody').html(rows);
                }
            }
        });
    }

    // Delete category
    $(document).on('click', '.btn-delete', function () {
        const catId = $(this).data('id');
        if (confirm('Are you sure you want to delete this category?')) {
            $.ajax({
                url: '../api/category/delete.php',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({ id: catId }),
                success: function (res) {
                    if (res.status === 'success') {
                        loadCategories();
                    } else {
                        alert(res.message);
                    }
                }
            });
        }
    });
});