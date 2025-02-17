<!-- User Edit Modal -->
<div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="userModalLabel">User Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- User Form Goes Here -->
        <form id="userForm" method="POST" enctype="multipart/form-data">
          <input type="hidden" name="id" id="id" value="">
          <input type="hidden" name="action" id="action" value="create">

          <!-- Photo Upload Field -->
          <div class="form-group">
            <label for="photo">Photo</label>
            <input type="file" class="form-control" id="photo" name="photo" onchange="previewPhoto(event)">
            <img id="photo-preview" src="#" alt="Photo Preview" style="display:none; max-width: 150px; margin-top: 10px;">
          </div>

          <!-- Name Field -->
          <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
          </div>

          

          <!-- Email Field -->
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
          </div>

          <!-- Gender Radio Buttons -->
          <div class="mb-3">
            <label>Gender</label><br>
            <input type="radio" name="gender" value="female" id="gender-f"> Female
            <input type="radio" name="gender" value="male" id="gender-m"> Male
          </div>

          <!-- Password Field -->
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password">
          </div>

          <!-- Submit Button -->
          <button type="submit" id="btn" class="btn btn-primary">Update</button>
        </form>
      </div>
    </div>
  </div>
</div>