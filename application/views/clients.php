<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title><?= !empty($this->lang->line('label_clients')) ? $this->lang->line('label_clients') : 'Clients'; ?> &mdash; <?= get_compnay_title(); ?></title>
    <?php include('include-css.php'); ?>

</head>

<body>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">

            <?php include('include-header.php'); ?>

            <!-- Main Content -->
            <div class="main-content">
                <section class="section">
                    <div class="section-header">
                        <h1><?= !empty($this->lang->line('label_client')) ? $this->lang->line('label_client') : 'Quản lý Khách hàng hiện hữu'; ?></h1>
                        <div class="section-header-breadcrumb">
                            
                        </div>
                    </div>

                    <div class="section-body">
                        <div class="row">
                        <div class='col-md-12'>
                        <div class="card">
                        <div class="card-body">
                            <form id="search-form" method="GET" action="<?= base_url('clients/search') ?>">
                                <div class="row">
                                        <!-- Mã khách hàng -->
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="customer_code">Mã khách hàng</label>
                                                <input type="text" class="form-control" id="customer_code" name="customer_code" placeholder="Nhập mã khách hàng">
                                            </div>
                                        </div>

                                        <!-- Tên khách hàng -->
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="customer_name">Tên khách hàng</label>
                                                <input type="text" class="form-control" id="customer_name" name="customer_name" placeholder="Nhập tên khách hàng">
                                            </div>
                                        </div>

                                        <!-- Số điện thoại -->
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="phone">Số điện thoại</label>
                                                <input type="text" class="form-control" id="phone" name="phone" placeholder="Nhập số điện thoại">
                                            </div>
                                        </div>

                                        <!-- Số CMT/hộ chiếu -->
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="identity">Số CMT/Hộ chiếu</label>
                                                <input type="text" class="form-control" id="identity" name="identity" placeholder="Nhập số CMT/Hộ chiếu">
                                            </div>
                                        </div>

                                        <!-- Khối -->
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="block">Khối</label>
                                                <select class="form-control" id="block" name="block">
                                                    <option value="">Chọn khối</option>
                                                    <option value="1">Khối 1</option>
                                                    <option value="2">Khối 2</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Tần suất giao dịch -->
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="frequency">Tần suất giao dịch</label>
                                                <select class="form-control" id="frequency" name="frequency">
                                                    <option value="">Chọn tần suất</option>
                                                    <option value="low">Thấp</option>
                                                    <option value="medium">Trung bình</option>
                                                    <option value="high">Cao</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Đơn vị -->
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="unit">Đơn vị</label>
                                                <select class="form-control" id="unit" name="unit">
                                                    <option value="">Chọn đơn vị</option>
                                                    <option value="unit1">Đơn vị 1</option>
                                                    <option value="unit2">Đơn vị 2</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- RM quản lý -->
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="rm_manager">RM quản lý</label>
                                                <select class="form-control" id="rm_manager" name="rm_manager">
                                                    <option value="">Chọn RM quản lý</option>
                                                    <option value="rm1">RM 1</option>
                                                    <option value="rm2">RM 2</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                    <div class="col-md-12 d-flex justify-content-between align-items-center">
                                    <!-- Nút Tìm kiếm và Xóa -->
                                    <div>
                                        <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                                        <button type="reset" class="btn btn-secondary">Xóa</button>
                                    </div>

                                    <!-- Nút Thêm -->
                                    <div>
                                        <?php if (check_permissions("clients", "create")) { ?>
                                            <i class="btn btn-primary btn-rounded no-shadow" id="modal-add-from-file" style="margin-right: 10px;">
                                                <?= !empty($this->lang->line('label_add_client_2')) ? $this->lang->line('label_add_client_2') : 'Thêm từ file'; ?>
                                            </i>
                                        <?php } ?>
                                        <?php if (check_permissions("clients", "create")) { ?>
                                            <button class="btn btn-primary btn-rounded no-shadow" id="modal-add-user">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                        <?php } ?>
                                    </div>
                                </div>
                                    </div>
                                </form>

                                <!-- Bảng kết quả tìm kiếm -->
                                <div class="table-responsive mt-4">
                                <table class='table-striped' id='clients_list' data-toggle="table" data-url="<?= base_url('clients/get_clients_list') ?>" data-side-pagination="server" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-show-columns="true" data-show-refresh="true" data-sort-name="MaKH" data-sort-order="asc" data-mobile-responsive="true" data-toolbar="" data-show-export="true" data-maintain-selected="true" data-export-options='{
                                "fileName": "clients-list",
                                        "ignoreColumn": ["state"] 
                                    }' 
                                    data-query-params="queryParams">            
                                            <thead>
                                                <tr>
                                                    <th data-field="stt" data-sortable="false">STT</th>
                                                    <th data-field="MaKH" data-sortable="true"><?= !empty($this->lang->line('label_id')) ? $this->lang->line('label_id') : 'ID'; ?></th>

                                                    <th data-field="TenKH" data-sortable="true"><?= !empty($this->lang->line('label_clients_name')) ? $this->lang->line('label_clients_name') : 'Tên khách hàng'; ?></th>

                                                    <th data-field="Khoi" data-sortable="true"><?= !empty($this->lang->line('label_company')) ? $this->lang->line('label_company') : 'Khối'; ?></th>

                                                    <th data-field="CASA" data-sortable="true">CASA hiện tại</th>

                                                    <th data-field="TK" data-sortable="false">Tiết kiệm hiện tại</th>
                                                    <th data-field="TD" data-sortable="false">Tín dụng hiện tại</th>
                                                    <th data-field="SDT" data-sortable="true">Số điện thoại</th>

                                                    <th data-field="CNquanly" data-sortable="false">Sector</th>
                                                    <th data-field="RMquanly" data-sortable="false">RM quản lý</th>
                                                    <th data-field="MaDV" data-sortable="false">Mã đơn vị mở code</th>
                                                    <th data-field="TenDV" data-sortable="false">Tên đơn vị mở code</th>
                                                    <?php if (check_permissions("clients", "delete")) { ?>
                                                        <th data-field="action" data-sortable="false"><?= !empty($this->lang->line('label_action')) ? $this->lang->line('label_action') : 'Action'; ?></th>
                                                        <?php //} 
                                                        ?>
                                                    <?php }
                                                    ?>
                                                </tr>   
                                            </thead>
                                        </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

            <?php
            $user_permissions = $client_permissions_data = "";

            $actions = ['create', 'read', 'update', 'delete'];
            $total_actions = count($actions);

            // /* reading member's permissions from database */
            $user_permissions = (!empty($modules[0]['member_permissions'])) ? json_decode($modules[0]['member_permissions'], 1) : [];
            $client_permissions_data = (!empty($modules[0]['client_permissions'])) ? json_decode($modules[0]['client_permissions'], 1) : [];

            ?>

            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">
                                <?= !empty($this->lang->line('label_client_specific_permissions')) ? $this->lang->line('label_client_specific_permissions') : 'Client specific Permissions'; ?>
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="<?= base_url('users/set_user_permission') ?>" id="user_permission_module">

                                <input type="number" id="id" name="id" hidden readonly>
                                <div class="row">
                                    <div class="col">
                                        <table class="table table-light">
                                            <thead>
                                                <tr>
                                                    <th scope="col">
                                                        <?= !empty($this->lang->line('label_module_permissions')) ? $this->lang->line('label_module_permissions') : 'Module/Permissions'; ?></th>
                                                    <th scope="col"><?= !empty($this->lang->line('label_create')) ? $this->lang->line('label_create') : 'Create'; ?></th>
                                                    <th scope="col"><?= !empty($this->lang->line('label_read')) ? $this->lang->line('label_read') : 'Read'; ?></th>
                                                    <th scope="col"><?= !empty($this->lang->line('label_update')) ? $this->lang->line('label_update') : 'Update'; ?>Update</th>
                                                    <th scope="col"><?= !empty($this->lang->line('label_delete')) ? $this->lang->line('label_delete') : 'Delete'; ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach ($system_modules as $module => $client_permissions_data) : ?>
                                                    <tr>
                                                        <td class="col-sm-4 text-left">
                                                            <?= ucfirst(str_replace("_", " ", $module)); ?>
                                                        </td>
                                                        <?php for ($i = 0; $i < $total_actions; $i++) {

                                                            $checked = (isset($user_permissions[$module]) && array_key_exists($actions[$i], $user_permissions[$module]) && ($user_permissions[$module][$actions[$i]] == "on" || $user_permissions[$module][$actions[$i]] == 1)) ? "checked" : "23";

                                                            if (array_search($actions[$i], $system_modules[$module]) !== false) { ?>
                                                                <td class="col-sm-2 text-center">
                                                                    <input type="checkbox" name="<?= 'permissions[' . $module . '][' . $actions[$i] . ']' ?>">
                                                                </td>
                                                            <?php } else { ?>
                                                                <td class="col-sm-2 text-center">
                                                                    -</td>
                                                        <?php }
                                                        } ?>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>


                        </div>
                        <div class="modal-footer">
                            <button type="submit" id="submit_button_update" class="btn btn-primary"><?= !empty($this->lang->line('label_save')) ? $this->lang->line('label_save') : 'Save'; ?></button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Form tạo KHHH đơn lẻ -->
            <?php if (check_permissions("clients", "create")) { ?>
            <div class="card mt-4">
                <div class="card-body">
                <?= form_open('auth/create_user', 'id="modal-add-user-part"', 'class="modal-part"'); ?>
                <div class="row">
                    <div class="col-md-12">
                        <div id="modal-title" class="d-none">Thêm khách hàng đơn lẻ</div>
                        <div id="modal-footer-add-title" class="d-none"><?= !empty($this->lang->line('label_add')) ? $this->lang->line('label_add') : 'Lưu'; ?></div>
                    <div class="row" >
                        <!-- Tên khách hàng -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><?= !empty($this->lang->line('label_clients_name')) ? $this->lang->line('label_clients_name') : 'Tên khách hàng'; ?></label>
                                <div class="input-group">
                                    <?= form_input(['name' => 'client_name', 'placeholder' => 'Nhập tên khách hàng', 'class' => 'form-control']) ?>
                                </div>
                            </div>
                        </div>
                        <!-- Ngày sinh -->
                        <div class="col-md-3" id="date_of_birth">
                            <div class="form-group">
                                <label>Ngày sinh</label>
                                <div class="input-group">
                                    <?= form_input(['name' => 'date_of_birth', 'type' => 'date', 'placeholder' => 'Nhập ngày sinh', 'class' => 'form-control']) ?>
                                </div>
                            </div>
                        </div>
                        <!-- Email -->
                        <div class="col-md-5">
                            <div class="form-group">
                            <label><?= !empty($this->lang->line('label_email')) ? $this->lang->line('label_email') : 'Email' ?></label>
                                <div class="input-group">
                                    <?= form_input(['name' => 'client_name', 'placeholder' => 'Nhập email', 'class' => 'form-control']) ?>
                                </div>
                            </div>
                        </div>


                        <!-- Quốc tịch -->
                        <div class="col-md-3">
                            <div class="form-group" id="country">
                                <label>Quốc tịch</label>
                                <div class="input-group">
                                    <?= form_input(['name' => 'nationality', 'placeholder' => 'Nhập quốc tịch', 'class' => 'form-control']) ?>
                                </div>
                            </div>
                        </div>
                        <!-- Số CMT/Hộ chiếu -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Số CMT/Hộ chiếu</label>
                                <div class="input-group">
                                    <?= form_input(['name' => 'identity', 'placeholder' => 'Nhập số CMT/Hộ chiếu', 'class' => 'form-control']) ?>
                                </div>
                            </div>
                        </div>
                        <!-- Ngày cấp -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Ngày cấp</label>
                                <div class="input-group">
                                    <?= form_input(['name' => 'issue_date', 'type' => 'date', 'class' => 'form-control']) ?>
                                </div>
                            </div>
                        </div>
                        <!-- Nơi cấp -->
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Nơi cấp</label>
                                <div class="input-group">
                                    <?= form_input(['name' => 'issue_place', 'placeholder' => 'Nơi cấp', 'class' => 'form-control']) ?>
                                </div>
                            </div>
                        </div>


                        <!-- Số điện thoại -->
                        <div class="col-md-4" id="phone">
                            <div class="form-group">
                                <label><?= !empty($this->lang->line('label_phone')) ? $this->lang->line('label_phone') : 'Số điện thoại'; ?></label>
                                <div class="input-group">
                                    <?= form_input(['name' => 'phone', 'placeholder' => !empty($this->lang->line('label_phone')) ? $this->lang->line('label_phone') : 'Phone', 'class' => 'form-control']) ?>
                                </div>
                            </div>
                        </div>
                            <!-- Địa chỉ-->
                            <div class="col-md-8">
                                <div class="form-group">
                                <label>Địa chỉ</label>
                                    <div class="input-group">
                                        <?= form_input(['name' => '', 'placeholder' => 'Nhập địa chỉ', 'class' => 'form-control']) ?>
                                    </div>
                                </div>
                            </div>

                        <!-- Nghề nghiệp -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Nghề nghiệp</label>
                                <div class="input-group">
                                    <?= form_input(['name' => '', 'placeholder' => 'Nhập nghề nghiệp', 'class' => 'form-control']) ?>
                                </div>
                            </div>
                        </div>
                            <!-- Thu nhập-->
                            <div class="col-md-5">
                                <div class="form-group">
                                <label>Thu nhập</label>
                                    <div class="input-group">
                                        <?= form_input(['name' => '', 'placeholder' => 'Nhập thu nhập TB hàng tháng', 'class' => 'form-control']) ?>
                                    </div>
                                </div>
                            </div>

                        <!-- Khối khách hàng -->
                        <div class="form-group col-md-4">
                            <label for="customer_block">Khối khách hàng</label>
                            <?= form_dropdown('customer_block', ['Khách hàng cá nhân', 'Khách hàng doanh nghiệp'], null, ['class' => 'form-control']) ?>
                        </div>
                        <!-- Trạng thái -->
                        <div class="form-group col-md-3">
                            <label for="status">Trạng thái</label>
                            <?= form_dropdown('status', ['Active', 'Inactive'], null, ['class' => 'form-control']) ?>
                        </div>
                        <!-- Tần suất giao dịch -->
                        <div class="form-group col-md-5">
                            <label for="transaction_frequency">Tần suất giao dịch</label>
                            <?= form_dropdown('tansuat', ['Chưa phân nhóm', 'Không hoạt động', 'Giao dịch ít'], null, ['class' => 'form-control']) ?>
                        </div>

                        <!-- Mã Khách hàng -->
                        <div class="form-group col-md-4">
                            <label for="">Mã khách hàng</label>
                            <?= form_input(['name' => '', 'value' => '$generated_code', 'class' => 'form-control', 'readonly' => 'readonly']) ?>
                        </div>
                        <!-- RM quản lý -->
                        <div class="form-group col-md-4">
                            <label for="rm_manager">RM quản lý</label>
                            <?= form_input(['name' => '', 'value' => '$user_code', 'class' => 'form-control', 'readonly' => 'readonly']) ?>
                        </div>
                        <!-- Chi nhánh quản lý -->
                        <div class="form-group col-md-4">
                            <label for="branch">Chi nhánh quản lý</label>
                            <?= form_input(['name' => 'branch',  'value' => '$branch_code', 'class' => 'form-control', 'readonly' => 'readonly']) ?>
                        </div>

                        <!-- Ngày upload -->
                        <div class="form-group col-md-3">
                            <label for="upload_date">Ngày upload</label>
                            <?= form_input(['name' => 'upload_date', 'type' => 'date', 'class' => 'form-control', 'readonly' => 'readonly']) ?>
                        </div>
                        <!-- Đơn vị upload -->
                        <div class="form-group col-md-4">
                            <label for="branch">Chi nhánh quản lý</label>
                            <?= form_input(['name' => 'donvi',  'value' => '$donvi_code', 'class' => 'form-control', 'readonly' => 'readonly']) ?>
                        </div>
                    
                </div>
                </form>
            <?php } ?>

            </div>
        </div>

           <!-- Form thêm khách hàng từ file -->
           <?php if (check_permissions("clients", "create")) { ?>
            <div class="card mt-4">
                <div class="card-body">
                <?= form_open('auth/create_user', 'id="modal-add-user-part"', 'class="modal-part"'); ?>
                <div class="row">
                    <div class="col-md-12">
                        <div id="modal-title" class="d-none">Thêm khách hàng từ file</div>
                        <div id="modal-footer-add-title" class="d-none"><?= !empty($this->lang->line('label_add')) ? $this->lang->line('label_add') : 'Lưu'; ?></div>
                        <div class="row">
                            <div class="col-lg-7">
                            <label for="file" class="mr-3"><?= !empty($this->lang->line('label_file')) ? $this->lang->line('label_file') : 'Upload file danh sách khách hàng (Định dạng .csv)'; ?> <span class='text-danger text-sm'>*</span></label>
                            <div class="form-group d-flex align-items-center">
                                <input type="file" name="upload_file" class="form-control mr-3" accept=".csv" style="max-width: 300px;" />
                                <a href="<?= base_url('assets/project/upload/project-bulk-upload-sample.csv') ?>" class="btn btn-info" download="project-bulk-upload-sample.csv">
                                    <?= !empty($this->lang->line('label_bulk_upload_sample_file')) ? $this->lang->line('label_bulk_upload_sample_file') : 'Tải file mẫu'; ?> <i class="fas fa-download"></i>
                                </a>
                            </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <button class="btn btn-primary mb-2" id="submit_button"><?= !empty($this->lang->line('label_submit')) ? $this->lang->line('label_submit') : 'Import'; ?></button>
                                <div id="result" style="display: none;"></div>
                            </div>
                        </div>
                <?php } ?>
        </div>
    </div>

    <script>
        not_in_workspace_user = <?php echo json_encode(array_values($not_in_workspace_user)); ?>;

        function queryParams(p) {
            return {
                "user_type": 3,
                limit: p.limit,
                sort: p.sort,
                order: p.order,
                offset: p.offset,
                search: p.search
            };
        }
    </script>

    <?php include('include-js.php'); ?>
    <script src="assets/js/page/components-clients.js"></script>

</body>

</html>