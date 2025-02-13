$(document).ready(function () {
    const baseUrl = '/NovelNest';

    // Initialize DataTable
    let table = $('#datatable').DataTable();

    // Reset modal fields and button text
    function resetModal() {
        $('#genreForm')[0].reset(); // Reset form fields
        $('#btn').removeData('edit-id'); // Remove edit ID
        $('#btn').text('Save'); // Reset button text
        $('#exampleModalLabel').text('Add New Category'); // Reset modal title
    }

    // Load genres and populate the table
    function loadGenres() {
        $.ajax({
            url: `${baseUrl}/controller/genreController.php`,
            method: 'GET',
            success: function (response) {
                const data = JSON.parse(response);
                if (data.status === 'success' && Array.isArray(data.data)) {
                    table.clear().draw(); // Clear existing table data

                    let serialNumber = 1; 

                    data.data.forEach(function (genre) {
                        table.row.add([
                            serialNumber,
                            genre.name,
                            genre.description,
                            `<button class="btn btn-primary btn-sm edit-btn" 
                                data-id="${genre.id}" 
                                data-name="${genre.name}" 
                                data-description="${genre.description}">
                                Edit
                            </button>
                            <button class="btn btn-danger btn-sm delete-btn" 
                                data-id="${genre.id}">
                                Delete
                            </button>`
                        ]).draw(false);
                        serialNumber++;
                    });
                } else {
                    toastr.error(data.message || 'No data found.');
                }
            },
            error: function () {
                toastr.error('Error fetching genre data.');
            }
        });
    }

    // Open modal for adding a new genre
    $(document).on('click', '[data-bs-target="#addGenreModal"]', function () {
        resetModal();
    });

    // Open modal for editing a genre
    $(document).on('click', '.edit-btn', function () {
        const id = $(this).data('id');
        const name = $(this).data('name');
        const description = $(this).data('description');

        $('#gname').val(name);
        $('#gdescription').val(description);
        $('#btn').data('edit-id', id);
        $('#btn').text('Update');
        $('#exampleModalLabel').text('Edit Category');

        $('#addGenreModal').modal('show');
    });

    // Handle Save or Update button click
    $(document).on('click', '#btn', function () {
        const id = $(this).data('edit-id');
        const name = $('#gname').val();
        const description = $('#gdescription').val();

        if (!name || !description) {
            toastr.warning('All fields are required!');
            return;
        }

        const action = id ? 'update' : 'add';

        $.ajax({
            url: `${baseUrl}/controller/genreController.php`,
            type: 'POST',
            data: { action, id, name, description },
            success: function (response) {
                try {
                    const res = JSON.parse(response);
                    toastr[res.status](res.message);
                    if (res.status === 'success') {
                        $('#addGenreModal').modal('hide');
                        loadGenres();
                    }
                } catch (e) {
                    console.error('Error parsing JSON response:', response);
                    toastr.error('Unexpected response from the server.');
                }
            },
            error: function () {
                toastr.error('An error occurred while processing the request.');
            }
        });
    });

    // Handle Delete button click
    $(document).on('click', '.delete-btn', function () {
        const id = $(this).data('id');
        if (confirm('Are you sure you want to delete this category?')) {
            $.ajax({
                url: `${baseUrl}/controller/genreController.php`,
                method: 'POST',
                data: { action: 'delete', id },
                success: function (response) {
                    const res = JSON.parse(response);
                    toastr[res.status](res.message);
                    if (res.status === 'success') {
                        loadGenres();
                    }
                },
                error: function () {
                    toastr.error('An error occurred while deleting the genre.');
                }
            });
        }
    });

    // Load genres on page load
    loadGenres();
});
