<?php
$baseUrl = '/NovelNest';
require_once $_SERVER['DOCUMENT_ROOT'] . $baseUrl . '/view/layout/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . $baseUrl . '/view/genre/form.php';
?>

<div class="content-inner container-fluid pb-0" id="page_layout">
    <div>
        <div class="row ">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center position-relative">
                        <div class="iq-header-title">
                            <h4 class="mb-0">Category Lists</h4>
                        </div>
                        <div class="iq-card-header-toolbar d-flex align-items-center">
                            <a href="<?= $baseUrl ?>/view/genre/form.php" class="btn btn-primary" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addGenreModal">Add New
                                Category</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="custom-table-effect table-responsive custom-table-search ">
                            <table class=" mb-0 table table-bordered custom-datatable-border" id="datatable"
                                data-toggle="data-table">
                                <thead class="">
                                    <tr class="bg-white">
                                        <th scope="col" class="border-bottom bg-primary text-white">No</th>
                                        <th scope="col" class="border-bottom bg-primary text-white">Category Name</th>
                                        <th scope="col" class="border-bottom bg-primary text-white custom-column-width">Category
                                            Description</th>
                                        <th scope="col" class="border-bottom bg-primary text-white" colspan="2">Action</th>
                                    </tr>
                                </thead>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>



<script src="<?= $baseUrl ?>/assets/js/ajax/genre.js" defer></script>

<?php

require_once $_SERVER['DOCUMENT_ROOT'] . $baseUrl . '/view/layout/footer.php';
?>