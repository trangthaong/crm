<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Quản lý RM</title>
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
                    <h1>Quản lý thông tin RM</h1>
                    <div class="section-header-breadcrumb">
                    
    <?php if (check_permissions("users", "create")) { ?>
        <!-- Thêm chỉ biểu tượng dấu "+" vào nút -->
        <button class="btn btn-primary btn-rounded no-shadow" id="modal-add-user">
            <i class="fa fa-plus"></i>
        </button>
    <?php } ?>
</div>



                    </div>
                    <div class="section-body">
                        <div class="row">
                            <div class="modal-edit-user"></div>
                            <div class='col-md-12'>
                                <div class="card">
                                    <div class="card-body">
                    


</div>

<!-- Search Tools -->
<div class="row mb-3">
    <div class="col-md-6 d-flex">
        <div class="input-group w-100">
            <input type="text" id="searchKeyword" class="form-control" placeholder="Nhập Mã RM..." maxlength="50">
            <div class="input-group-append">
                <button class="btn btn-primary" id="btnSearch">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </div>

    <div class="col-md-6 text-right d-flex justify-content-end gap-2">
    <button class="btn btn-secondary mr-2" id="btnAdvancedSearch">
        <i class="fas fa-filter"></i> Tìm kiếm nâng cao
    </button>
    <!-- Đổi button một xíu để kích hoạt modal -->
<button class="btn btn-info" id="btnImportFromFile" data-toggle="modal" data-target="#importRmModal">
    <i class="fas fa-file-import"></i> Thêm từ file
</button>

</div>

</div>

<div id="advancedSearchForm" class="card p-3 mb-3" style="display: none;">
  <div class="form-row">

    <!-- Mã RM -->
    <div class="form-group col-md-3">
      <label for="rmCode">Mã RM</label>
      <input type="text" class="form-control" id="rmCode" maxlength="50" placeholder="Nhập mã RM">
    </div>

    <!-- Mã HRIS -->
    <div class="form-group col-md-3">
      <label for="hrisCode">Mã HRIS</label>
      <input type="text" class="form-control" id="hrisCode" maxlength="50" placeholder="Nhập mã HRIS">
    </div>

    <!-- Tên RM -->
    <div class="form-group col-md-3">
      <label for="rmName">Tên RM</label>
      <input type="text" class="form-control" id="rmName" maxlength="100" placeholder="Nhập tên RM">
    </div>

    <!-- Đơn vị -->
    <div class="form-group col-md-3">
      <label for="unit">Đơn vị</label>
      <select class="form-control select2" id="unit" multiple>
        <option value="all">Tất cả</option>
        <!-- JS sẽ đổ danh sách đơn vị tùy theo role -->
      </select>
    </div>

    <!-- Email -->
    <div class="form-group col-md-3">
      <label for="email">Email</label>
      <input type="text" class="form-control" id="email" maxlength="100" placeholder="Nhập email">
    </div>

    <!-- Số điện thoại -->
    <div class="form-group col-md-3">
      <label for="phone">Số điện thoại</label>
      <input type="text" class="form-control" id="phone" maxlength="50" placeholder="Nhập số điện thoại">
    </div>

    <!-- Khối -->
    <div class="form-group col-md-3">
      <label for="division">Khối</label>
      <select class="form-control select2" id="division" multiple>
        <!-- Load danh sách khối theo role -->
      </select>
    </div>

    <!-- Tình trạng -->
    <div class="form-group col-md-3">
      <label for="status">Tình trạng</label>
      <select class="form-control" id="status">
        <option value="all">Tất cả</option>
        <option value="active">Hiệu lực</option>
        <option value="inactive">Không hiệu lực</option>
      </select>
    </div>

  </div>
  <div class="text-right">
    <button class="btn btn-primary" id="btnSearch">Tìm kiếm</button>
    <button class="btn btn-secondary" id="btnReset">Đặt lại</button>
  </div>
</div>
        <table id="users_list"
            data-toggle="table"
            data-url="<?= base_url('users/get_users_list') ?>"
            data-side-pagination="server"
            data-pagination="true"
            data-search="true"
            data-show-refresh="true"
            data-page-list="[5, 10, 20, 50]"
            data-sort-name="full_name"
            data-sort-order="asc"
            class="table table-striped">
            <thead>
                <tr>
                    <th data-field="rm_code" data-sortable="true">Mã RM</th>
                    <th data-field="hris_code" data-sortable="true">Mã HRIS</th>
                    <th data-field="full_name" data-sortable="true">Họ và tên</th>
                    <th data-field="phone_number" data-sortable="false">Điện thoại</th>
                    <th data-field="email" data-sortable="false">Email</th>
                    <th data-field="position" data-sortable="false">Chức danh</th>
                    <th data-field="branch_level_2_code">Mã CN cấp 2</th>
                    <th data-field="branch_level_2_name">Tên CN cấp 2</th>
                    <th data-field="branch_level_1_code">Mã CN cấp 1</th>
                    <th data-field="branch_level_1_name">Tên CN cấp 1</th>
                    <th data-field="action" data-sortable="false">Hành động</th>
                </tr>
            </thead>
        </table>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
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
                                <?= !empty($this->lang->line('label_user_specific_permissions')) ? $this->lang->line('label_user_specific_permissions') : 'User specific Permissions'; ?>
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
                                                foreach ($system_modules as $module => $member_permissions) : ?>
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
            <?php if (check_permissions("users", "create")) { ?>
                <?= form_open('auth/create_user', 'id="modal-add-user-part"', 'class="modal-part"'); ?>
                <div class="row">
                <div class="col-md-6">
    <div class="form-group">
        <label>Mã HRIS <span class="text-danger">*</span></label>
        <?= form_input(['name' => 'ma_hris', 'class' => 'form-control', 'maxlength' => '50', 'required' => true]) ?>
    </div>
</div>

<div class="col-md-6">
    <div class="form-group">
        <label>Tên RM <span class="text-danger">*</span></label>
        <?= form_input(['name' => 'ten_rm', 'class' => 'form-control', 'maxlength' => '200', 'required' => true]) ?>
    </div>
</div>

<div class="col-md-6">
    <div class="form-group">
        <label>Phòng <span class="text-danger">*</span></label>
        <?= form_dropdown('phong', $phong_options ?? [], '', ['class' => 'form-control', 'required' => true]) ?>
    </div>
</div>

<div class="col-md-6">
    <div class="form-group">
        <label>Vị trí <span class="text-danger">*</span></label>
        <?= form_dropdown('vi_tri', $vi_tri_options ?? [], '', ['class' => 'form-control', 'required' => true]) ?>
    </div>
</div>

<div class="col-md-6">
    <div class="form-group">
        <label>Chức danh <span class="text-danger">*</span></label>
        <?= form_dropdown('chuc_danh', $chuc_danh_options ?? [], '', ['class' => 'form-control', 'required' => true]) ?>
    </div>
</div>

<div class="col-md-6">
    <div class="form-group">
        <label>Khối HRIS <span class="text-danger">*</span></label>
        <?= form_dropdown('khoi_hris', $khoi_hris_options ?? [], '', ['class' => 'form-control', 'required' => true]) ?>
    </div>
</div>

<div class="col-md-6">
    <div class="form-group">
        <label>Ngày sinh <span class="text-danger">*</span></label>
        <?= form_input(['name' => 'ngay_sinh', 'type' => 'text', 'class' => 'form-control datepicker', 'placeholder' => 'DD/MM/YYYY', 'required' => true]) ?>
    </div>
</div>

<div class="col-md-6">
    <div class="form-group">
        <label>Ngày vào MB <span class="text-danger">*</span></label>
        <?= form_input(['name' => 'ngay_vao_mb', 'type' => 'text', 'class' => 'form-control datepicker', 'placeholder' => 'DD/MM/YYYY', 'required' => true]) ?>
    </div>
</div>

<div class="col-md-6">
    <div class="form-group">
        <label>Giới tính <span class="text-danger">*</span></label>
        <?= form_dropdown('gioi_tinh', ['female' => 'Nữ', 'male' => 'Nam'], '', ['class' => 'form-control', 'required' => true]) ?>
    </div>
</div>

<div class="col-md-6">
    <div class="form-group">
        <label>Số điện thoại <span class="text-danger">*</span></label>
        <?= form_input(['name' => 'so_dien_thoai', 'type' => 'number', 'class' => 'form-control', 'maxlength' => '15', 'required' => true]) ?>
    </div>
</div>

<div class="col-md-6">
    <div class="form-group">
        <label>Email <span class="text-danger">*</span></label>
        <?= form_input(['name' => 'email', 'type' => 'email', 'class' => 'form-control', 'maxlength' => '50', 'required' => true, 'pattern' => '.+@.+\..+']) ?>
    </div>
</div>

<div class="col-md-6">
    <div class="form-group">
        <label>Khối <span class="text-danger">*</span></label>
        <?= form_dropdown('khoi', $khoi_options ?? [], '', ['class' => 'form-control', 'required' => true]) ?>
    </div>
</div>

<div class="col-md-6">
    <div class="form-group">
        <label>Cấp độ RM <span class="text-danger">*</span></label>
        <?= form_dropdown('cap_do_rm', $rm_level_options ?? [], '', ['class' => 'form-control', 'required' => true]) ?>
    </div>
</div>

<!-- Thông tin hệ thống -->
<div class="col-md-6">
    <div class="form-group">
        <label>Mã RM (tự sinh)</label>
        <?= form_input(['name' => 'ma_rm', 'class' => 'form-control', 'readonly' => true, 'placeholder' => 'Tự sinh sau khi thêm']) ?>
    </div>
</div>

<div class="col-md-6">
    <div class="form-group">
        <label>Chi nhánh quản lý</label>
        <?= form_dropdown('chi_nhanh', $chi_nhanh_options ?? [], $default_chi_nhanh ?? '', ['class' => 'form-control', 'disabled' => true]) ?>
    </div>
</div>

<div class="col-md-6">
    <div class="form-group">
        <label>Đơn vị upload</label>
        <?= form_input(['name' => 'don_vi_upload', 'class' => 'form-control', 'readonly' => true, 'value' => $don_vi_upload ?? '']) ?>
    </div>
</div>

<div class="col-md-6">
    <div class="form-group">
        <label>Ngày upload</label>
        <?= form_input(['name' => 'ngay_upload', 'class' => 'form-control', 'readonly' => true, 'value' => date('d/m/Y')]) ?>
    </div>
</div>
            <?php } ?>
            </form>
            <?php include('include-footer.php'); ?>
        </div>
    </div>

    <script>
        not_in_workspace_user = <?php echo json_encode(array_values($not_in_workspace_user)); ?>;
    </script>

    <?php include('include-js.php'); ?>

    <!-- Page Specific JS File -->
    <script src="assets/js/page/components-user.js"></script>
    <script>
    $('#btnSearch').click(function () {
        let keyword = $('#searchKeyword').val().trim();
        if (keyword.length > 50) {
            alert("Tối đa 50 ký tự");
            return;
        }

        // Gửi keyword vào table
        $('#users_list').bootstrapTable('refresh', {
            query: {
                search: keyword
            }
        });
    });

    $('#btnAdvancedSearch').click(function () {
        $('#advanced-search-form').slideToggle();
    });
    $('#btnAdvancedSearch').click(function () {
    $('#advancedSearchForm').slideToggle();
});

$('#btnReset').click(function () {
    $('#advancedSearchForm').find('input, select').val('').trigger('change');
});

$('#btnSearch').click(function () {
    // Gửi thông tin lọc đến bảng hoặc AJAX
    let params = {
        rm_code: $('#rmCode').val(),
        hris_code: $('#hrisCode').val(),
        rm_name: $('#rmName').val(),
        unit: $('#unit').val(),
        email: $('#email').val(),
        phone: $('#phone').val(),
        division: $('#division').val(),
        status: $('#status').val()
    };

    $('#users_list').bootstrapTable('refresh', {
        query: params
    });
});
function indexFormatter(value, row, index) {
  return index + 1;
}

function actionFormatter(value, row, index) {
  return `<a href="edit/${row.id}" class="btn btn-sm btn-warning">Sửa</a>`;
}

</script>

<!-- Modal Thêm RM từ file -->
<div class="modal fade" id="importRmModal" tabindex="-1" role="dialog" aria-labelledby="importRmModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <?= form_open_multipart('rm/import', ['id' => 'import-rm-form']); ?>
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Thêm RM từ file Excel</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label>Tải file mẫu:</label>
          <a href="<?= base_url('assets/sample-rm.xlsx') ?>" class="btn btn-sm btn-outline-info">Tải xuống</a>
        </div>

        <div class="form-group">
          <label>Chọn file Excel (.xlsx, tối đa 1000 bản ghi)</label>
          <input type="file" name="rm_file" accept=".xlsx" class="form-control" required>
        </div>

        <div id="import-result"></div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Nhập dữ liệu</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Bỏ qua</button>
      </div>
    </div>
    <?= form_close(); ?>
  </div>
</div>

<!-- Modal Lịch sử phân giao -->
<div class="modal fade" id="assignHistoryModal" tabindex="-1" role="dialog" aria-labelledby="assignHistoryModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="assignHistoryModalLabel">Lịch sử phân giao RM</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body">
        <!-- Tạo bảng hiển thị lịch sử phân giao -->
        <table class='table-striped' data-toggle="table" data-side-pagination="server" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-show-columns="true" data-show-refresh="true" data-sort-name="MaKH" data-sort-order="asc" data-toolbar="" data-show-export="true" data-maintain-selected="true" data-export-options='{
        "fileName": "clients-list",
                "ignoreColumn": ["state"] 
            }' 
            data-query-params="queryParams"> 
          <thead>
            <tr>
              <th>STT</th>
              <th>Mã KH</th>
              <th>Tên KH</th>
              <th>Ngày bắt đầu</th>
              <th>Ngày kết thúc</th>
              <th>Người phân giao</th>
              <th>Ngày cập nhật</th>
            </tr>
          </thead>
          <tbody id="historyContent">
          <tr>
      <td>1</td>
      <td>KH001</td>
      <td>Nguyễn Văn A</td>
      <td>2025-04-08</td>
      <td>2025-12-31</td>
      <td>Linh</td>
      <td>2025-04-08</td>
    </tr>
    <tr>
      <td>2</td>
      <td>KH002</td>
      <td>Trần Thị B</td>
      <td>2025-04-10</td>
      <td>2025-11-30</td>
      <td>Hùng</td>
      <td>2025-04-10</td>
    </tr>
    <tr>
      <td>3</td>
      <td>KH003</td>
      <td>Phạm Văn C</td>
      <td>2025-04-12</td>
      <td>2025-12-15</td>
      <td>Mai</td>
      <td>2025-04-12</td>
    </tr>
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Bỏ qua</button>
      </div>
    </div>
  </div>
</div>
<script>



</script>



</body>

</html>