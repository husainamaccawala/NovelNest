<!-- audiobookForm.php -->
<div class="modal fade" id="audiobookModal" tabindex="-1" role="dialog" aria-labelledby="audiobookModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="audiobookModalLabel">Audiobook Form</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="audiobookForm" enctype="multipart/form-data">
          <input type="hidden" id="audiobookId" name="id">
          <!-- Book Title Field -->
          <div class="form-group mb-3">
            <label for="book" class="form-label">Book Title</label>
            <input type="text" class="form-control" id="book" name="book" placeholder="Enter book title" required>
          </div>

          <!-- Narrator Field -->
          <div class="form-group mb-3">
            <label for="narrator" class="form-label">Narrator</label>
            <input type="text" class="form-control" id="narrator" name="narrator" placeholder="Enter narrator name" required>
          </div>

          <!-- Duration Field -->
          <div class="form-group mb-3">
            <label for="duration" class="form-label">Duration</label>
            <input type="time" class="form-control" id="duration" name="duration" step="1" required>
          </div>

          <!-- Language Field -->
          <div class="form-group mb-3">
            <label for="language" class="form-label">Language</label>
            <select class="form-control" id="language" name="language" required>
              <option value="">Select Language</option>
              <option value="English">English</option>
              <option value="Spanish">Spanish</option>
              <option value="French">French</option>
              <option value="German">German</option>
            </select>
          </div>

          <!-- Audiobook File Upload Field -->
          <div class="form-group mb-3">
            <label for="audiobookFile" class="form-label">Audiobook File</label>
            <input type="file" class="form-control" id="audiobookFile" name="audiobookFile" accept="audio/*">
          </div>

          <!-- Submit and Cancel Buttons -->
          <div class="text-end">
            <button type="submit" class="btn btn-primary">Save Audiobook</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
