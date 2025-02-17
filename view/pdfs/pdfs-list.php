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
                            <h4 class="mb-0">PDF List</h4>
                        </div>
                        <div class="iq-card-header-toolbar d-flex align-items-center">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPdfModal">Add New Pdf</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="custom-table-effect table-responsive custom-table-search">
                            <table class=" mb-0 table table-bordered custom-datatable-border" id="datatable" data-toggle="data-table">
                                <thead>
                                    <tr class="bg-white">
                                        <th class="border-bottom bg-primary text-white">No</th>
                                        <th class="border-bottom bg-primary text-white">Name</th>
                                        <!-- <th class="border-bottom bg-primary text-white">Book Name</th> -->
                                        <th class="border-bottom bg-primary text-white">Description</th>
                                        <th class="border-bottom bg-primary text-white">PDF</th>
                                        <th class="border-bottom bg-primary text-white">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Dynamic rows populated via AJAX -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- PDF Viewer Modal -->
                    <div class="modal fade" id="pdfModal" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl"> <!-- modal-xl for a larger view -->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="pdfModalLabel">PDF Viewer</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <iframe id="pdfViewer" src="" width="100%" height="600px" style="border: none;"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= $baseUrl ?>/assets/js/ajax/pdfs.js" defer></script>

<?php
require_once $_SERVER['DOCUMENT_ROOT'] . $baseUrl . '/view/layout/footer.php';
?>