$(document).ready(function () {
    console.log("the script is loaded ");

    const baseUrl = '/novelnest';

    // Fetch and display users
    function fetchUsers() {
        $.ajax({
            url: baseUrl + '/controller/user-handler.php',
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                let rows = '';
                if (data && Array.isArray(data)) {
                    let srNo = 1; // Initialize the serial number for rows
                    data.forEach(user => {
                        // Ensure the profile path is complete
                        const profilePath = user.profile ? baseUrl + '/' + user.profile : baseUrl + '/assets/images/default-profile.jpg';
                        rows += `
                        <tr>
                            <td>${srNo++}</td> 
                            <td><img src="${profilePath}" alt="Profile Photo" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;"></td> 
                            <td>${user.name}</td> 
                            <td>${user.contact}</td> 
                            <td>${user.email}</td> 
                            <td>${user.gender}</td> 
                            <td>
                                <button class="btn btn-info btn-sm editBtn" data-id="${user.id}">Edit</button>
                                <button class="btn btn-danger btn-sm deleteBtn" data-id="${user.id}">Delete</button>
                            </td> 
                        </tr>`;
                    });
                    $('#user-table tbody').html(rows);
                }
            }
        });
    }

    // Initial fetch
    fetchUsers();

    // Add User Button: Show modal for creating user
    $('#addUserBtn').click(function () {
        $('#userForm')[0].reset();
        $('#action').val('create');
        $('#id').val('');
        $('#photo-preview').hide();
    });

    // Edit User Button: Show modal for updating user
    $(document).on('click', '.editBtn', function () {
        const userId = $(this).data('id');
        
        $.ajax({
            url: baseUrl + '/controller/user-handler.php',
            method: 'GET',
            data: { action: 'fetch', id: userId },
            dataType: 'json',
            success: function (data) {
                console.log("AJAX success:", data);
                if (data && !data.error) {
                    // Fill the modal form with user data
                    $('#id').val(data.id);
                    $('#name').val(data.name);
                    $('#email').val(data.email);
                    $('#phone-num').val(data.contact);
                    $(`input[name="gender"][value="${data.gender}"]`).prop('checked', true);
                    
                    // Fix profile photo preview by adding baseUrl
                    if (data.profile) {
                        const profilePath = baseUrl + '/' + data.profile;
                        $('#photo-preview').attr('src', profilePath);
                        $('#photo-preview').show();
                    } else {
                        $('#photo-preview').attr('src', baseUrl + '/assets/images/default-profile.jpg');
                        $('#photo-preview').show();
                    }
                    $('#action').val('update');
    
                    $('#userModal').modal('show');
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX error:", error);
            }
        });
    });

    // Delete User Button
    $(document).on('click', '.deleteBtn', function () {
        const userId = $(this).data('id');
        if (confirm('Are you sure you want to delete this user?')) {
            $.ajax({
                url: baseUrl + '/controller/user-handler.php',
                method: 'POST',
                data: { action: 'delete', id: userId },
                success: function (response) {
                    alert('User deleted successfully!');
                    fetchUsers(); // Refresh the user list
                }
            });
        }
    });

    // Handle form submission for insert and update
    $('#userForm').submit(function (e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        // Ensure gender and contact are included in formData
        const gender = $('input[name="gender"]:checked').val();
        const contact = $('#phone-num').val();
        
        formData.set('gender', gender);
        formData.set('contact', contact);
        
        $.ajax({
            url: baseUrl + '/controller/user-handler.php',
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                alert('User ' + ($('#action').val() === 'create' ? 'created' : 'updated') + ' successfully!');
                $('#userModal').modal('hide');
                fetchUsers(); // Refresh the user list
            },
            error: function(xhr, status, error) {
                console.error("Form submission error:", error);
                alert('Error saving user data. Please try again.');
            }
        });
    });

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