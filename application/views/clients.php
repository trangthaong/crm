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
                        <?php $context = 'client_page'; ?>
                        <?php include('search-client-form.php'); ?>

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
                                    </div>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            <?php } ?>

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
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            <?php } ?>

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