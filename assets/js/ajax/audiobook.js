$(document).ready(function () {
    const baseUrl = '/NovelNest';
    // Initialize DataTable
    let table = $('#datatable').DataTable();

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
            data: { action: 'get' },
            success: function (response) {
                console.log("API Response:", response);
    
                try {
                    const data = JSON.parse(response);
                    console.log("Parsed Data:", data);
    
                    if (data.status === 'success' && Array.isArray(data.data)) {
                        table.clear().draw(); // Clear existing table data
    
                        let serialNumber = 1;
                        const timestamp = new Date().getTime(); // Prevent audio caching
    
                        data.data.forEach(audiobook => {
                            table.row.add([
                                serialNumber,
                                audiobook.book_name,
                                audiobook.name,  // Add Audiobook Name
                                audiobook.description,
                                audiobook.narrator,
                                `<audio controls preload="none" class="audiobook-player">
                                    <source src="${baseUrl}/assets/audiobooks/${audiobook.file}?t=${timestamp}" type="audio/mpeg">
                                    Your browser does not support the audio element.
                                </audio>`,
                                `<button class="btn btn-primary btn-sm edit-btn"
                                    data-id="${audiobook.id}"
                                    data-book_name="${audiobook.book_name}"
                                    data-description="${audiobook.description}"
                                    data-narrator="${audiobook.narrator}"
                                    data-name="${audiobook.name}">  <!-- Add name to data attributes -->
                                    <i class="las la-pen"></i>
                                </button>
                                <button class="btn btn-danger btn-sm delete-btn"
                                    data-id="${audiobook.id}">
                                    <i class="las la-trash-alt"></i>
                                </button>`
                            ]).draw(false);
    
                            serialNumber++;
                        });
    
                        // Reload audio players after DataTables update
                        setTimeout(() => {
                            $('.audiobook-player').each(function () {
                                this.load();
                            });
                        }, 500);
    
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
                toastr.error('Error fetching audiobooks data');
            }
        });
    }
    
    
    // Handle form submission (Add/Update)
    $('#audiobookForm').submit(function (e) {
        e.preventDefault();
    
        // Basic validation
        const requiredFields = ['book_id', 'description', 'narrator', 'name'];  // Add name to required fields
        let isValid = true;
    
        requiredFields.forEach(field => {
            if (!$(`#${field}`).val()) {
                toastr.error(`${field.replace('_', ' ')} is required`);
                isValid = false;
            }
        });
    
        if (!isValid) return;
    
        const formData = new FormData(this);
        const id = $('#audiobookId').val();
    
        // Add action type
        formData.append('action', id ? 'update' : 'add');
        if (id) formData.append('id', id);
    
        // Check if a new file is being uploaded
        const fileInput = $('#audio_file')[0];
        if (fileInput.files.length > 0) {
            const audioFile = fileInput.files[0];
            if (!audioFile.type.startsWith('audio/')) {
                toastr.error('Please select a valid audio file');
                return;
            }
        } else {
            // Append existing file name if no new file is uploaded
            formData.append('existing_file', $('#existing_audio_file').val());
        }
    
        $.ajax({
            url: `${baseUrl}/controller/audiobookController.php`,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                try {
                    const data = JSON.parse(response);
                    if (data.status === 'success') {
                        toastr.success(data.message);
                        $('#audiobookModal').modal('hide');
                        $('#audiobookForm')[0].reset();
                        $('#audiobookId').val('');
    
                        setTimeout(() => {
                            loadAudiobooks();
                        }, 500);
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
                toastr.error('Failed to process request');
            }
        });
    });
    

    // Edit button handler
    $(document).on('click', '.edit-btn', function () {
        $('#audiobookForm')[0].reset();
        $('#audiobookId').val('');
        $('#existing_audio_file').val('');
        $('#audio_file').siblings('.text-info').remove();

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
                        $('#existing_audio_file').val(audiobook.file || '');

                        // Show current file info if available
                        if (audiobook.file) {
                            $('#audio_file').after(`
                                <div class="text-info mt-2">
                                    <p>Current audio file: ${audiobook.file}</p>
                                    <audio controls class="mt-2 mb-2">
                                        <source src="${baseUrl}/assets/audiobooks/${audiobook.file}" type="audio/mpeg">
                                    </audio>
                                    <p class="small">Upload a new file only if you want to replace the current audio</p>
                                </div>
                            `);
                        }

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
                data: { action: 'delete', id },
                success: function (response) {
                    const data = JSON.parse(response);
                    toastr[data.status](data.message);
                    if (data.status === 'success') loadAudiobooks();
                }
            });
        }
    });

    $('#audiobookModal').on('hidden.bs.modal', function () {
        $('#audiobookForm')[0].reset();
        $('#audiobookId').val('');
        $('#audio_file').siblings('.text-info').remove();
    });

    // Initialize page
    loadBooks();
    loadAudiobooks();
});

