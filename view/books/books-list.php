<?php
$baseUrl = '/NovelNest';
require_once $_SERVER['DOCUMENT_ROOT'] . $baseUrl . '/view/layout/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . $baseUrl . '/view/books/booksForm.php';
?>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center position-relative">
                <div class="iq-header-title">
                    <h4 class="mb-0">Book Lists</h4>
                </div>
                <div class="iq-card-header-toolbar d-flex align-items-center">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBooksModal">Add New Book</button>
                </div>
            </div>
            <div class="card-body">
                <div class="custom-table-effect table-responsive custom-table-search">
                    <table class=" mb-0 table table-bordered custom-datatable-border" id="booksTable" data-toggle="data-table">
                        <thead>
                            <tr class="bg-white">
                                <th class="border-bottom bg-primary text-white">No</th>
                                <th class="border-bottom bg-primary text-white">Book Image</th>
                                <th class="border-bottom bg-primary text-white">Book Name</th>
                                <th class="border-bottom bg-primary text-white">Book Category</th>
                                <th class="border-bottom bg-primary text-white">Book Author</th>
                                <th class="border-bottom bg-primary text-white description-column">Book Description</th>
                                <th class="border-bottom bg-primary text-white" colspan="2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Dynamic rows populated via AJAX -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= $baseUrl ?>/assets/js/ajax/books.js" defer></script>

<?php
require_once $_SERVER['DOCUMENT_ROOT'] . $baseUrl . '/view/layout/footer.php';
?>