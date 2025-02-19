$(document).ready(function () {
    console.log("the script is loaded ");

const baseUrl = '/NovelNest';

  // Initialize DataTable
  let table = $('#datatable').DataTable();

// Fetch and display users
   

function loadUsers() {
    $.ajax({
        url: `${baseUrl}/controller/user-handler.php`,
        method: 'GET',
        data: { action: 'get' },
        success: function (response) {

            try {
                const data = JSON.parse(response);
                if (Array.isArray(data) && data.length > 0) {
                    table.clear().draw(); //Clear existing rows

                    let serialNumber = 1;

                    data.forEach(user => {
                        const profilePath = user.profile 
                            ? `${user.profile}` 
                            : `${baseUrl}/assets/images/default-profile.jpg`;

                        table.row.add([
                            serialNumber,
                            `<img src="${profilePath}" alt="Profile Photo" 
                                style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">`,
                            user.name,
                           
                            user.email,
                            user.gender,
                            `<button class="btn btn-primary btn-sm editBtn" 
                                data-id="${user.id}" 
                                data-name="${user.name}" 
                                data-email="${user.email}" 
                                data-gender="${user.gender}">
                                <i class="las la-pen"></i>
                            </button>
                            <button class="btn btn-danger btn-sm deleteBtn" 
                                data-id="${user.id}">
                                <i class="las la-trash-alt"></i>
                            </button>`
                        ]).draw(false);

                        serialNumber++;
                    });

                } else {
                    toastr.warning('No users found');
                }
            } catch (e) {
                console.error('Error parsing users:', e);
                toastr.error('Error loading users');
            }
        },
        error: function (xhr, status, error) {
            console.error('Users loading error:', error);
            toastr.error('Error fetching users data');
        }
    });
}


// Initial fetch
loadUsers();

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
                $(`input[name="gender"][value="${data.gender}"]`).prop('checked', true);
                
                // Fix profile photo preview by adding baseUrl
                if (data.profile) {
                    const profilePath = data.profile;
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
                toastr.success('User deleted successfully!');
                loadUsers(); // Refresh the user list
            },
            error: function(xhr, status, error) {
                toastr.error('Error deleting user. Please try again.');
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
    
    
    formData.set('gender', gender);
   
    
    $.ajax({
        url: baseUrl + '/controller/user-handler.php',
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
            const action = $('#action').val() === 'create' ? 'created' : 'updated';
            toastr.success(`User ${action} successfully!`);
            $('#userModal').modal('hide');
            loadUsers(); // Refresh the user list
        },
        error: function(xhr, status, error) {
            console.error("Form submission error:", error);
            toastr.error('Error saving user data. Please try again.');
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