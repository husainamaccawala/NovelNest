$(document).ready(function () {
    const baseUrl = '/NovelNest';
    let table = $('#datatable').DataTable();

    // Function to load books dropdown
    function loadBooksDropdown() {
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
                        $('#books').html(options);
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

    // Function to load PDFs
    function loadPdfs() {
        $.ajax({
            url: `${baseUrl}/controller/pdfsController.php`,
            method: 'GET',
            data: { action: 'get' },
            success: function (response) {
                try {
                    const data = JSON.parse(response);
                    if (data.status === 'success' && Array.isArray(data.data)) {
                        table.clear().draw();

                        let serialNumber = 1;
    
                        data.data.forEach(pdf => {
                            table.row.add([
                                serialNumber,
                                pdf.title || 'N/A',
                                pdf.description || '',
                                `<a href="${baseUrl}/assets/pdfs/${pdf.file}" class="btn btn-info btn-sm view-pdf" 
                                    data-url="${baseUrl}/assets/pdfs/${pdf.file}">
                                    <i class="ri-file-fill"></i>
                                </a>`,
                                `<button class="btn btn-primary btn-sm edit-btn" 
                                    data-id="${pdf.id}" 
                                    data-title="${pdf.title}" 
                                    data-book_id="${pdf.book_id}" 
                                    data-description="${pdf.description}" 
                                    data-file="${pdf.file}">
                                    <i class="las la-pen"></i>
                                </button>
                                <button class="btn btn-danger btn-sm delete-btn" data-id="${pdf.id}">
                                    <i class="las la-trash-alt"></i>
                                </button>`
                            ]).draw(false);
    
                            serialNumber++;
                        });
    
                    } else {
                        toastr.error('Failed to load PDFs');
                    }
                } catch (e) {
                    console.error('Error parsing PDFs:', e);
                    toastr.error('Error loading PDFs');
                }
            },
            error: function (xhr, status, error) {
                console.error('PDF loading error:', error);
                toastr.error('Error fetching PDFs data');
            }
        });
    }
    
     // View PDF in Modal
     $(document).on('click', '.view-pdf', function (e) {
        e.preventDefault();
        const pdfUrl = $(this).data('url');
        $('#pdfViewer').attr('src', pdfUrl);
        $('#pdfModal').modal('show');
    });


    // Function to reset modal
    function resetModal() {
        $('#pdfForm')[0].reset();
        $('#btn').removeData('edit-id');
        $('#existingFile').val('');
        $('.custom-file-label').html('Choose file');
    }

    // Add/Update PDF handler
    $(document).on('click', '#btn', function (e) {
        e.preventDefault();
        const id = $(this).data('edit-id');
        const formData = new FormData($('#pdfForm')[0]);

        // Get selected book details
        const bookSelect = document.getElementById('books');
        const selectedBookTitle = bookSelect.options[bookSelect.selectedIndex].text;

        // Validate required fields
        const name = $('#name').val().trim();
        const bookId = $('#books').val();
        const description = $('#description').val().trim();

        // Clear previous form data
        formData.delete('action');
        formData.delete('id');

        // Add the correct field names
        formData.append('action', id ? 'update' : 'add');
        formData.append('title', name);
        formData.append('book_id', bookId);
        formData.append('books_title', selectedBookTitle);
        formData.append('description', description);

        // Handle update case
        if (id) {
            formData.append('id', id);
            const fileInput = $('#pdfFile')[0];
            // Check if file input exists and has files
            if (fileInput && fileInput.files && fileInput.files.length > 0) {
                formData.append('pdf_file', fileInput.files[0]);
            } else {
                // If no new file is selected, send the existing file path
                formData.append('existing_file', $('#existingFile').val());
            }
        } else {
            // For new entries, append the file if it exists
            const fileInput = $('#pdfFile')[0];
            if (fileInput && fileInput.files && fileInput.files.length > 0) {
                formData.append('pdf_file', fileInput.files[0]);
            }
        }

        $.ajax({
            url: `${baseUrl}/controller/pdfsController.php`,
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
                        $('#addPdfModal').modal('hide');
                        loadPdfs();
                        resetModal();
                    } else {
                        toastr.error(res.message || 'Failed to save PDF');
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
        const pdfId = $(this).data('id');

        $.ajax({
            url: `${baseUrl}/controller/pdfsController.php`,
            method: 'GET',
            data: {
                action: 'get',
                id: pdfId
            },
            success: function (response) {
                try {
                    const data = JSON.parse(response);
                    if (data.status === 'success' && data.data) {
                        const pdf = data.data;

                        // Populate form fields
                        $('#name').val(pdf.title);
                        $('#books').val(pdf.book_id);
                        $('#description').val(pdf.description);
                        $('#existingFile').val(pdf.file);

                        // Store the edit ID
                        $('#btn').data('edit-id', pdfId);

                        // Show the modal
                        $('#addPdfModal').modal('show');
                    } else {
                        toastr.error('Failed to fetch PDF details');
                    }
                } catch (e) {
                    console.error('Error parsing PDF details:', e);
                    toastr.error('Error loading PDF details');
                }
            },
            error: function (xhr, status, error) {
                console.error('Error fetching PDF details:', error);
                toastr.error('Failed to load PDF details');
            }
        });
    });

    // Delete button handler
    $(document).on('click', '.delete-btn', function () {
        const pdfId = $(this).data('id');
        if (confirm('Are you sure you want to delete this PDF?')) {
            $.ajax({
                url: `${baseUrl}/controller/pdfsController.php`,
                method: 'POST',
                data: {
                    action: 'delete',
                    id: pdfId
                },
                success: function (response) {
                    try {
                        const res = JSON.parse(response);
                        toastr[res.status](res.message);
                        if (res.status === 'success') {
                            loadPdfs();
                        }
                    } catch (e) {
                        console.error('Error parsing delete response:', e);
                        toastr.error('Error processing delete response');
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Delete error:', error);
                    toastr.error('Error deleting PDF');
                }
            });
        }
    });

    // Add new PDF button handler
    $('#addNewPdf').click(function () {
        resetModal();
        $('#addPdfModal').modal('show');
    });

    // Modal reset handler
    $('#addPdfModal').on('hidden.bs.modal', function () {
        resetModal();
    });

    // Initialize page
    loadBooksDropdown();
    loadPdfs();
});