<?php
$baseUrl = '/NovelNest';
require_once $_SERVER['DOCUMENT_ROOT'] . $baseUrl . '/view/layout/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . $baseUrl . '/view/pdfs/pdfsForm.php';
?>
<div class="content-inner container-fluid pb-0" id="page_layout">
    <div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center position-relative">
                        <div class="iq-header-title">
                            <h4 class="mb-0">PDF Lists</h4>
                        </div>
                        <div class="iq-card-header-toolbar d-flex align-items-center">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPdfsModal">Add New Pdf</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="custom-table-effect table-responsive custom-table-search">
                            <table class=" mb-0 table table-bordered custom-datatable-border" id="pdfsTable"  data-toggle="data-table">
                                <thead>
                                    <tr class="bg-white">
                                        <th class="border-bottom bg-primary text-white">No</th>
                                        <th class="border-bottom bg-primary text-white">Name</th>
                                        <th class="border-bottom bg-primary text-white">Description</th>
                                        <th class="border-bottom bg-primary text-white">PDF</th>
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
    </div>
</div>

<!-- <script src="<?= $baseUrl ?>/assets/js/ajax/books.js" defer></script> -->

<?php
require_once $_SERVER['DOCUMENT_ROOT'] . $baseUrl . '/view/layout/footer.php';
?>