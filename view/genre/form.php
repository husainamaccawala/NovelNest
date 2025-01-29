<!-- Modal -->
<div class="modal fade" id="addGenreModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add New Category</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row"> 
                    <div class="col-sm-12">
                        <div class="card">
                          
                            <div class="card-body">
                                <form action="" id="genreForm">
                                    <div class="form-group">
                                        <label>Category Name:</label>
                                        <input type="text" class="form-control p-2 bg-white border" id="gname" name="gname">
                                    </div>
                                    <div class="form-group">
                                        <label>Category Description:</label>
                                        <textarea type="text" class="form-control  bg-white border" id="gdescription" name="gdescription"></textarea>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-danger" id="resetbtn">Reset</button>
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
