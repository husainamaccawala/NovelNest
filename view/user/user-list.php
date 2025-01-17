<?php require_once __DIR__ . "/../layout/header.php"; ?>


<div class="content-inner container-fluid pb-0" id="page_layout">
    <div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">User List</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="custom-table-effect table-responsive custom-table-search user-table">
                            <table class=" mb-0 table table-bordered" id="datatable" data-toggle="data-table1" border="1">
                                <thead class="">
                                    <tr class="bg-white">
                                        <th scope="col" class="border-bottom bg-primary text-white">Profile</th>
                                        <th scope="col" class="border-bottom bg-primary text-white">Name </th>
                                        <th scope="col" class="border-bottom bg-primary text-white">Contact</th>
                                        <th scope="col" class="border-bottom bg-primary text-white">Email</th>
                                        <th scope="col" class="border-bottom bg-primary text-white">Gender</th>
                                        <th scope="col" class="border-bottom bg-primary text-white">Action</th>

                                    </tr>
                                </thead>
                                <tbody>

                                    

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . "/../layout/footer.php"; ?>