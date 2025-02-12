$(document).ready(function () {
    const baseUrl = '/NovelNest';

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
                    let tableContent = '';
                    let serialNumber = 1; // Initialize serial number counter
                    
                    data.data.forEach(function (genre) {
                        tableContent += `
                            <tr>
                                <td>${serialNumber}</td> <!-- Display serial number instead of ID -->
                                <td>${genre.name}</td>
                                <td>${genre.description}</td>
                                <td>
                                    <button class="btn btn-primary btn-sm edit-btn" 
                                        data-id="${genre.id}" 
                                        data-name="${genre.name}" 
                                        data-description="${genre.description}">
                                        Edit
                                    </button>
                                </td>
                                <td>
                                    <button class="btn btn-danger btn-sm delete-btn" 
                                        data-id="${genre.id}">
                                        Delete
                                    </button>
                                </td>
                            </tr>`;
                        serialNumber++; // Increment serial number
                    });
    
                    $('#datatable tbody').html(tableContent); // Populate table
                } else {
                    toastr.error(data.message || 'No data found.'); // Toastr error message
                }
            },
            error: function () {
                toastr.error('Error fetching genre data.'); // Toastr error message
            }
        });
    }
    

    // Delegated event listener for "Add New Category" button
    $(document).on('click', '[data-bs-target="#addGenreModal"]', function () {
        resetModal();
    });

    // Delegated event listener for "Edit" button
    $(document).on('click', '.edit-btn', function () {
        const id = $(this).data('id');
        const name = $(this).data('name');
        const description = $(this).data('description');

        // Pre-fill modal fields with existing data
        $('#gname').val(name);
        $('#gdescription').val(description);
        $('#btn').data('edit-id', id); // Save ID for editing
        $('#btn').text('Update'); // Change button text to "Update"
        $('#exampleModalLabel').text('Edit Category'); // Change modal title

        // Show the modal
        $('#addGenreModal').modal('show');
    });

    // Handle Save or Update button click
    $(document).on('click', '#btn', function () {
        const id = $(this).data('edit-id'); // Get edit ID, if any
        const name = $('#gname').val();
        const description = $('#gdescription').val();

        if (!name || !description) {
            toastr.warning('All fields are required!'); // Toastr warning message
            return;
        }

        const action = id ? 'update' : 'add'; // Determine action based on ID presence

        $.ajax({
            url: `${baseUrl}/controller/genreController.php`,
            type: 'POST',
            data: {
                action,
                id,
                name,
                description
            },
            success: function (response) {
                try {
                    const res = JSON.parse(response);
                    toastr[res.status](res.message); // Toastr success or error message
                    if (res.status === 'success') {
                        $('#addGenreModal').modal('hide'); // Hide the modal after success
                        loadGenres(); // Reload the genres list
                    }
                } catch (e) {
                    console.error('Error parsing JSON response:', response);
                    toastr.error('Unexpected response from the server.'); // Toastr error message
                }
            },
            error: function () {
                toastr.error('An error occurred while processing the request.'); // Toastr error message
            }
        });
    });

    // Delegated event listener for "Delete" button
    $(document).on('click', '.delete-btn', function () {
        const id = $(this).data('id');
        if (confirm('Are you sure you want to delete this category?')) {
            $.ajax({
                url: `${baseUrl}/controller/genreController.php`,
                method: 'POST',
                data: {
                    action: 'delete',
                    id: id
                },
                success: function (response) {
                    const res = JSON.parse(response);
                    toastr[res.status](res.message); // Toastr success or error message
                    if (res.status === 'success') {
                        loadGenres(); // Reload the genres list
                    }
                },
                error: function () {
                    toastr.error('An error occurred while deleting the genre.'); // Toastr error message
                }
            });
        }
    });

    // Initialize page
    loadGenres();
});
