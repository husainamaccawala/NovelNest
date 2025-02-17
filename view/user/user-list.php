<?php
$baseUrl = '/NovelNest';
require_once $_SERVER['DOCUMENT_ROOT'] . $baseUrl . "/view/layout/header.php";
require_once $_SERVER['DOCUMENT_ROOT'] . $baseUrl . "/view/user/userForm.php";
?>


<div class="content-inner container-fluid pb-0" id="page_layout">
    <div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center position-relative">
                        <div class="iq-header-title">
                            <h4 class="mb-0">User List</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="custom-table-effect table-responsive custom-table-search">
                            <table class="mb-0 table table-bordered custom-datatable-border" id="datatable" data-toggle="data-table">
                                <thead class="">
                                    <tr class="bg-white">
                                        <th scope="col" class="border-bottom bg-primary text-white">Srno.</th>
                                        <th scope="col" class="border-bottom bg-primary text-white">Profile</th>
                                        <th scope="col" class="border-bottom bg-primary text-white">Name </th>
                                        <th scope="col" class="border-bottom bg-primary text-white">Email</th>
                                        <th scope="col" class="border-bottom bg-primary text-white">Gender</th>
                                        <th scope="col" class="border-bottom bg-primary text-white">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Users will be dynamically loaded here -->
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
<script src="<?= $baseUrl ?>/assets/js/ajax/user.js" defer></script>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . $baseUrl . "/view/layout/footer.php"; ?>
