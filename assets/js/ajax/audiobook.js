$(document).ready(function() {
    console.log("the script is loaded ");

    const baseUrl = '/NovelNest';
    // Load audiobooks
    function loadAudiobooks() {
        $.ajax({
            url: baseUrl + '/controller/audiobookhandler.php',
            method: 'POST',
            data: { action: 'read' },
            success: function(response) {
                let audiobooks = JSON.parse(response);
                let tableBody = $('#user-table tbody');
                tableBody.empty();
                audiobooks.forEach(function(audiobook, index) {
                    tableBody.append(`
                        <tr>
                            <td>${index + 1}</td>
                            <td>${audiobook.book}</td>
                            <td>${audiobook.narrator}</td>
                            <td>${audiobook.duration}</td>
                            <td>${audiobook.language}</td>
                            <td>${audiobook.audiobook}</td>
                            <td>
                                <button class="btn btn-warning btn-sm edit-btn" data-id="${audiobook.id}">Edit</button>
                                <button class="btn btn-danger btn-sm delete-btn" data-id="${audiobook.id}">Delete</button>
                            </td>
                        </tr>
                    `);
                });
            }
        });
    }

    // Add/Edit audiobook
    $('#audiobookForm').submit(function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        let id = $('#audiobookId').val();
        let action = id ? 'update' : 'create';
        formData.append('action', action);
        
        // Enhanced logging of form data
        console.log('Form Data Contents:');
        for (let pair of formData.entries()) {
            console.log(pair[0] + ': ' + pair[1]);
        }

        $.ajax({
            url: baseUrl + '/controller/audiobookhandler.php',
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                // Enhanced logging of server response
                console.log('Raw server response:', response);
                console.log('Response type:', typeof response);
                console.log('Response length:', response.length);
                
                try {
                    let result = JSON.parse(response);
                    if (result.success) {
                        $('#audiobookModal').modal('hide');
                        loadAudiobooks();
                    } else {
                        console.error('Server reported failure:', result);
                        alert(result.message || 'Failed to save audiobook');
                    }
                } catch (e) {
                    console.error('JSON parsing error:', e);
                    console.error('Failed to parse response:', response);
                    alert('Error processing server response. Check console for details.');
                }
            },
            error: function(xhr, status, error) {
                console.error('Ajax error details:', {
                    status: status,
                    error: error,
                    responseText: xhr.responseText,
                    statusCode: xhr.status
                });
                alert('Error saving audiobook: ' + error);
            }
        });
    });

    // Delete audiobook
    $(document).on('click', '.delete-btn', function() {
        let id = $(this).data('id');
        $.ajax({
            url:  baseUrl + '/controller/audiobookhandler.php',
            method: 'POST',
            data: { action: 'delete', id: id },
            success: function(response) {
                let result = JSON.parse(response);
                if (result.success) {
                    loadAudiobooks();
                }
            }
        });
    });

    // Edit audiobook
    $(document).on('click', '.edit-btn', function() {
        let id = $(this).data('id');
        $.ajax({
            url:  baseUrl + '/controller/audiobookhandler.php',
            method: 'POST',
            data: { action: 'read', id: id },
            success: function(response) {
                let audiobook = JSON.parse(response)[0];
                $('#audiobookId').val(audiobook.id);
                $('#book').val(audiobook.book);
                $('#narrator').val(audiobook.narrator);
                $('#duration').val(audiobook.duration);
                $('#language').val(audiobook.language);
                $('#audiobookModal').modal('show');
            }
        });
    });

    // Load audiobooks on page load
    loadAudiobooks();
});
