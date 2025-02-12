
<div class="modal fade" id="addPdfsModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add New PDF</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="" id="pdf sForm" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="cover_image">Cover Image</label>
                                        <input type="file" class="form-control" id="cover_image" name="cover_image">
                                        <img id="previewImage" src="" alt="Preview" style="display: none; margin-top: 10px;">
                                    </div>
                                    <div class="form-group">
                                        <label for="book_name">Book Name</label>
                                        <input type="text" class="form-control" id="book_name" name="book_name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="genres">Genre</label>
                                        <select class="form-control" id="genres" name="genres" required>
                                           
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="author">Author</label>
                                        <input type="text" class="form-control" id="author" name="author" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Description *</label>
                                        <textarea class="form-control" id="description" name="description" required></textarea>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <button type="reset" class="btn btn-danger">Reset</button>
                                        <button type="button" class="btn btn-primary" id="btn">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>