$(document).ready(function () {
    const baseUrl = '/NovelNest';

    // Load books for select dropdown
    function loadBooks() {
        $.ajax({
            url: `${baseUrl}/controller/booksController.php`,
            method: 'GET',
            data: { action: 'get' },
            success: function (response) {
                try {
                    const data = JSON.parse(response);
                    if (data.status === 'success' && Array.isArray(data.data)) {
                        let options = '<option value="">Select Book</option>';
                        data.data.forEach(book => {
                            options += `<option value="${book.id}">${book.title}</option>`;
                        });
                        $('#book_id').html(options);
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
                toastr.error('Failed to load books');
            }
        });
    }

    // Load audiobooks
    function loadAudiobooks() {
        $.ajax({
            url: `${baseUrl}/controller/audiobookController.php`,
            method: 'GET',
            success: function (response) {
                try {
                    const data = JSON.parse(response);
                    if (data.status === 'success' && Array.isArray(data.data)) {
                        let tableBody = '';
                        data.data.forEach((audiobook, index) => {
                            tableBody += `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${audiobook.book_name}</td>
                                    <td>${audiobook.description}</td>
                                    <td>${audiobook.narrator}</td>
                                    <td>
                                        <audio controls preload="none">
                                            <source src="${baseUrl}/assets/audiobooks/${audiobook.file}" type="audio/mpeg">
                                            Your browser does not support the audio element.
                                        </audio>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-primary edit-btn" data-id="${audiobook.id}">
                                            Edit
                                        </button>
                                        <button class="btn btn-sm btn-danger delete-btn" data-id="${audiobook.id}">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            `;
                        });
                        $('#user-table tbody').html(tableBody);
                        
                        // Debug: Log the first audio source
                        if (data.data.length > 0) {
                            console.log('First audio source:', `${baseUrl}/assets/audiobooks/${data.data[0].file}`);
                        }
                    } else {
                        toastr.error('Failed to load audiobooks');
                    }
                } catch (e) {
                    console.error('Error parsing audiobooks:', e);
                    toastr.error('Error loading audiobooks');
                }
            },
            error: function (xhr, status, error) {
                console.error('Audiobooks loading error:', error);
                toastr.error('Failed to load audiobooks');
            }
        });
    }

    // Handle form submission (Add/Update)
    $('#audiobookForm').submit(function (e) {
        e.preventDefault();
        
        // Basic validation
        const requiredFields = ['book_id', 'description', 'narrator'];
        let isValid = true;
        
        requiredFields.forEach(field => {
            if (!$(`#${field}`).val()) {
                toastr.error(`${field.replace('_', ' ')} is required`);
                isValid = false;
            }
        });
        
        if (!isValid) return;

        // File validation
        const fileInput = $('#audio_file')[0];
        if (!fileInput || !fileInput.files || fileInput.files.length === 0) {
            toastr.error('Please select an audio file');
            return;
        }

        const audioFile = fileInput.files[0];
        if (!audioFile.type.startsWith('audio/')) {
            toastr.error('Please select a valid audio file');
            return;
        }

        const formData = new FormData(this);
        const id = $('#audiobookId').val();
        
        // Add action type
        formData.append('action', id ? 'update' : 'add');
        if (id) formData.append('id', id);

        // Debug: Log form data
        console.log('Form Data:');
        for (let pair of formData.entries()) {
            console.log(pair[0] + ': ' + pair[1]);
        }

        $.ajax({
            url: `${baseUrl}/controller/audiobookController.php`,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                console.log('Raw response:', response);
                try {
                    const data = JSON.parse(response);
                    if (data.status === 'success') {
                        toastr.success(data.message);
                        $('#audiobookModal').modal('hide');
                        $('#audiobookForm')[0].reset();
                        loadAudiobooks();
                    } else {
                        toastr.error(data.message || 'Operation failed');
                    }
                } catch (e) {
                    console.error('Error parsing response:', e);
                    toastr.error('Unexpected response from server');
                }
            },
            error: function (xhr, status, error) {
                console.error('Submit error:', error);
                console.error('Status:', status);
                console.error('Response:', xhr.responseText);
                toastr.error('Failed to process request');
            }
        });
    });

    // Edit button handler
    $(document).on('click', '.edit-btn', function () {
        // Clear previous state first
        $('#audiobookForm')[0].reset();
        $('#audiobookId').val('');
        $('.text-info, #audiobookModal audio').remove();
        
        const id = $(this).data('id');
        $.ajax({
            url: `${baseUrl}/controller/audiobookController.php`,
            method: 'GET',
            data: { action: 'get', id: id },
            success: function (response) {
                try {
                    const data = JSON.parse(response);
                    if (data.status === 'success' && data.data) {
                        const audiobook = data.data;
                        $('#audiobookId').val(audiobook.id);
                        $('#book_id').val(audiobook.book_id);
                        $('#description').val(audiobook.description);
                        $('#narrator').val(audiobook.narrator);
                        $('#audiobookModal').modal('show');
                    } else {
                        toastr.error('Failed to load audiobook details');
                    }
                } catch (e) {
                    console.error('Error parsing audiobook details:', e);
                    toastr.error('Error loading audiobook details');
                }
            },
            error: function (xhr, status, error) {
                console.error('Error fetching audiobook details:', error);
                toastr.error('Failed to load audiobook details');
            }
        });
    });

    // Delete button handler
    $(document).on('click', '.delete-btn', function () {
        const id = $(this).data('id');
        if (confirm('Are you sure you want to delete this audiobook?')) {
            $.ajax({
                url: `${baseUrl}/controller/audiobookController.php`,
                method: 'POST',
                data: {
                    action: 'delete',
                    id: id
                },
                success: function (response) {
                    try {
                        const data = JSON.parse(response);
                        toastr[data.status](data.message);
                        if (data.status === 'success') {
                            loadAudiobooks();
                        }
                    } catch (e) {
                        console.error('Error parsing delete response:', e);
                        toastr.error('Error processing delete response');
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Delete error:', error);
                    toastr.error('Error deleting audiobook');
                }
            });
        }
    });

    // Add a handler for the Add Audiobook button
    $(document).on('click', '#addAudiobookBtn', function() {
        // Clear the form completely
        $('#audiobookForm')[0].reset();
        $('#audiobookId').val('');
        // Remove any existing audio preview and file info
        $('.text-info, #audiobookModal audio').remove();
        // Show the modal
        $('#audiobookModal').modal('show');
    });

    // Modify modal hidden handler to ensure clean state
    $('#audiobookModal').on('hidden.bs.modal', function () {
        $('#audiobookForm')[0].reset();
        $('#audiobookId').val('');
        $('.text-info, #audiobookModal audio').remove();
    });

    // Initialize page
    loadBooks();
    loadAudiobooks();
});
