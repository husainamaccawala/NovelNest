<?php
// Include BooksClass
require_once $_SERVER['DOCUMENT_ROOT'] . '/NovelNest/model/BooksClass.php';

$booksClass = new BooksClass();
$books = $booksClass->getAllBooks(); // Fetch genres from the database
?>
<div class="modal fade" id="addPdfModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                <form action="" id="pdfForm" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="book_name"> PDF Name</label>
                                        <input type="text" class="form-control" id="name" name="name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="book">Book Name</label>
                                        <select class="form-control" id="books" name="books" required>
                                            <!-- Options populated dynamically -->
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea class="form-control" id="description" name="description" required></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="pdf_file">Upload PDF</label>
                                        <input type="file" class="form-control" id="pdf_file" name="pdf_file" accept=".pdf" required>
                                    </div>
                                    <div class="form-group">
                                    <input type="hidden" id="existingFile" name="existing_file">
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