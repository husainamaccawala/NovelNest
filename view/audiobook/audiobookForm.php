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
            <label for="book_id" class="form-label">Book</label>
            <select class="form-select" id="book_id" name="book_id" required>
              <option value="">Select Book</option>
            </select>
          </div>

          <!--description-->
          <div class="form-group mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" placeholder="Enter Description" required></textarea>
          </div>

          <!-- Narrator Field -->
          <div class="form-group mb-3">
            <label for="narrator" class="form-label">Narrator</label>
            <input type="text" class="form-control" id="narrator" name="narrator" placeholder="Enter narrator name" required>
          </div>

          <!-- Audiobook File Upload Field -->
          <div class="form-group mb-3">
            <label for="audio_file" class="form-label">Audiobook File</label>
            <input type="file" class="form-control" id="audio_file" name="audio_file" accept="audio/*">
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

<script src="<?php echo $baseUrl; ?>/assets/js/ajax/audiobook.js"></script>