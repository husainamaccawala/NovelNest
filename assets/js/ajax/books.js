$(document).ready(function () {
    const baseUrl = '/NovelNest';
    // Initialize DataTable
    let table = $('#datatable').DataTable();

// Function to load genres
function loadGenres() {
    $.ajax({
        url: `${baseUrl}/controller/genreController.php`,
        method: 'GET',
        success: function (response) {
            try {
                const data = JSON.parse(response);
                if (data.status === 'success' && Array.isArray(data.data)) {
                    let options = '<option value="">Select Genre</option>';
                    data.data.forEach(genre => {
                        options += `<option value="${genre.id}">${genre.name}</option>`;
                    });
                    $('#genres').html(options);
                } else {
                    toastr.error('Failed to load genres');
                }
            } catch (e) {
                console.error('Error parsing genres:', e);
                toastr.error('Error loading genres');
            }
        },
        error: function (xhr, status, error) {
            console.error('Genre loading error:', error);
            toastr.error('Failed to load genres');
        }
    });
}


// Function to load books
function loadBooks() {
    $.ajax({
        url: `${baseUrl}/controller/booksController.php`,
        method: 'GET',
        data: { action: 'get' },
        success: function (response) {
            console.log("API Response:", response); // ✅ Debugging

            try {
                const data = JSON.parse(response);
                console.log("Parsed Data:", data); // ✅ Debugging

                if (data.status === 'success' && Array.isArray(data.data)) {
                    table.clear().draw(); // Clear existing table data

                    let serialNumber = 1;
                    data.data.forEach(book => {
                        let coverImage;
                        if (!book.cover_image || book.cover_image === '/') {
                            coverImage = `${baseUrl}/assets/images/default-book-cover.jpg`;
                        } else {
                            // Simple path cleaning
                            let cleanPath = book.cover_image;
                            if (cleanPath.includes('/NovelNest/')) {
                                cleanPath = cleanPath.split('/NovelNest/').pop();
                            }
                            if (!cleanPath.startsWith('assets/')) {
                                cleanPath = 'assets/images/book-cover/' + cleanPath;
                            }
                            coverImage = `${baseUrl}/${cleanPath}`;
                        }

                        // Add row using DataTables
                        table.row.add([
                            serialNumber,
                            `<img src="${coverImage}" alt="${book.title}" 
                                class="book-cover-thumb" 
                                style="width: 50px; height: 70px; object-fit: cover;">`,
                            book.title,
                            book.genre_name,
                            book.author,
                            book.description,
                            `<button class="btn btn-primary btn-sm edit-btn" 
                                data-id="${book.id}" 
                                data-title="${book.title}" 
                                data-genre="${book.genre_name}" 
                                data-author="${book.author}" 
                                data-description="${book.description}">
                                <i class="las la-pen"></i>
                            </button>
                            <button class="btn btn-danger btn-sm delete-btn" 
                                data-id="${book.id}">
                                <i class="las la-trash-alt"></i>
                            </button>`
                        ]).draw(false);

                        serialNumber++;
                    });

                } else {
                    toastr.error('Failed to load books');
                }
            } catch (e) {
                console.error('Error parsing books:', e);
                toastr.error('Error loading books');
            }
        },
        error: function (xhr, status, error) {
            console.error('Books loading error:', error);
            toastr.error('Error fetching books data');
        }
    });
}



// Function to reset modal
function resetModal() {
    $('#booksForm')[0].reset();
    $('#btn').data('edit-id', '');
    $('#previewImage').attr('src', '').hide();
    $('.custom-file-label').html('Choose file');
}


// Handle image preview
$('#cover_image').change(function () {
    const file = this.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            $('#previewImage')
                .attr('src', e.target.result)
                .css({ 'width': '100px', 'height': '150px', 'object-fit': 'cover' })
                .show();
        };
        reader.readAsDataURL(file);
    }
});

// Function to preview uploaded image
function previewPhoto(event) {
    var reader = new FileReader();
    reader.onload = function () {
        var output = document.getElementById('photo-preview');
        output.src = reader.result;
        output.style.display = 'block';
    };
    reader.readAsDataURL(event.target.files[0]);
}

// Add/Update book handler
$(document).on('click', '#btn', function (e) {
    e.preventDefault();
    const id = $(this).data('edit-id');
    const formData = new FormData($('#booksForm')[0]);


    // Validate required fields
    const title = $('#book_name').val().trim();
    const author = $('#author').val().trim();
    const genre = $('#genres').val();
    const description = $('#description').val().trim();

    // Clear previous form data
    formData.delete('action');
    formData.delete('id');
    formData.delete('published_date');

    // Add the correct field names
    formData.append('action', id ? 'update' : 'add');
    formData.append('title', title);
    formData.append('author', author);
    formData.append('genre_id', genre);
    formData.append('description', description);

    // Handle update case
    if (id) {
        formData.append('id', id);
        // If no new image is selected, send the current image path
        if (!$('#cover_image')[0].files[0]) {
            formData.append('existing_cover_image', $('#btn').data('current-cover'));
        }
    } else {
        const currentDate = new Date().toISOString().split('T')[0];
        formData.append('published_date', currentDate);
    }

    $.ajax({
        url: `${baseUrl}/controller/booksController.php`,
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
            console.log('Save response:', response);
            try {
                const res = JSON.parse(response);
                if (res.status === 'success') {
                    toastr.success(res.message);
                    $('#addBooksModal').modal('hide');
                    loadBooks();
                    resetModal();
                } else {
                    toastr.error(res.message || 'Failed to save book');
                }
            } catch (e) {
                console.error('Error parsing save response:', e);
                toastr.error('Unexpected response from the server');
            }
        },
        error: function (xhr, status, error) {
            console.error('Save error:', error);
            toastr.error('An error occurred while processing the request');
        }
    });
});

// Edit button handler
$(document).on('click', '.edit-btn', function () {
    const bookId = $(this).data('id');

    $.ajax({
        url: `${baseUrl}/controller/booksController.php`,
        method: 'GET',
        data: {
            action: 'get',
            id: bookId
        },
        success: function (response) {
            try {
                const data = JSON.parse(response);
                if (data.status === 'success' && data.data) {
                    const book = data.data;

                    // Populate form fields
                    $('#book_name').val(book.title);
                    $('#author').val(book.author);
                    $('#genres').val(book.genre_id);
                    $('#description').val(book.description);

                    // Set the preview image
                    let coverImage;
                    if (!book.cover_image || book.cover_image === '/') {
                        coverImage = `${baseUrl}/assets/images/default-book-cover.jpg`;
                    } else {
                        // Simple path cleaning
                        let cleanPath = book.cover_image;
                        if (cleanPath.includes('/NovelNest/')) {
                            cleanPath = cleanPath.split('/NovelNest/').pop();
                        }
                        if (!cleanPath.startsWith('assets/')) {
                            cleanPath = 'assets/images/book-cover/' + cleanPath;
                        }
                        coverImage = `${baseUrl}/${cleanPath}`;
                    }

                    console.log(`Edit Image URL for ${book.title}: ${coverImage}`); // Debugging line

                    $('#previewImage')
                        .attr('src', coverImage)
                        .css({ 'width': '100px', 'height': '150px', 'object-fit': 'cover' })
                        .show();

                    // Store the current cover image path
                    $('#btn').data('current-cover', book.cover_image);
                    $('#btn').data('edit-id', bookId);

                    // Show the modal
                    $('#addBooksModal').modal('show');
                } else {
                    toastr.error('Failed to fetch book details');
                }
            } catch (e) {
                console.error('Error parsing book details:', e);
                toastr.error('Error loading book details');
            }
        },
        error: function (xhr, status, error) {
            console.error('Error fetching book details:', error);
            toastr.error('Failed to load book details');
        }
    });
});


// Delete button handler
$(document).on('click', '.delete-btn', function () {
    const bookId = $(this).data('id');
    if (confirm('Are you sure you want to delete this book?')) {

        $.ajax({
            url: `${baseUrl}/controller/booksController.php`,
            method: 'POST',
            data: {
                action: 'delete',
                id: bookId
            },
            success: function (response) {
                try {

                    const res = JSON.parse(response);
                    toastr[res.status](res.message);
                    if (res.status === 'success') {
                        loadBooks();
                    }
                } catch (e) {
                    console.error('Error parsing delete response:', e);
                    toastr.error('Error processing delete response');
                }
            },
            error: function (xhr, status, error) {
                console.error('Delete error:', error);
                toastr.error('Error deleting book');
            }
        });

    }
});

// Add new book button handler
$('#addNewBook').click(function () {
    resetModal();
    $('#addBooksModal').modal('show');
});

// Modal reset handler
$('#addBooksModal').on('hidden.bs.modal', function () {
    resetModal();
});


// Initialize page
loadGenres();
loadBooks();
});

