<?php
$baseUrl = '/NovelNest';
require_once $_SERVER['DOCUMENT_ROOT'] . $baseUrl . "/view/layout/header.php";
require_once $_SERVER['DOCUMENT_ROOT'] . $baseUrl . "/view/audiobook/audiobookForm.php";
?>


<div class="content-inner container-fluid pb-0" id="page_layout">
    <div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center position-relative">
                        <div class="iq-header-title">
                            <h4 class="mb-0">Audiobook List</h4>
                        </div>
                        <div class="iq-card-header-toolbar d-flex align-items-center">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#audiobookModal">Add New AudioBook</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="custom-table-effect table-responsive custom-table-search">
                            <table class="mb-0 table table-bordered custom-datatable-border" id="datatable" data-toggle="data-table">
                                <thead class="">
                                    <tr class="bg-white">
                                        <th scope="col" class="border-bottom bg-primary text-white">Srno.</th>
                                        <th scope="col" class="border-bottom bg-primary text-white">Book</th>
                                        <th scope="col" class="border-bottom bg-primary text-white">Audiobook Name</th> <!-- Add Audiobook Name column -->
                                        <th scope="col" class="border-bottom bg-primary text-white">Description</th>
                                        <th scope="col" class="border-bottom bg-primary text-white">Narrator </th>
                                        <th scope="col" class="border-bottom bg-primary text-white">Audiobook</th>
                                        <th scope="col" class="border-bottom bg-primary text-white">Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <!-- Audiobook rows will be dynamically loaded here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<!--jQuery AJAX-->
<script src="<?= $baseUrl ?>/assets/js/ajax/audiobook.js" defer></script>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . $baseUrl . "/view/layout/footer.php"; ?>