<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Quản lý Chiến dịch</title>
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
                        <h1>Quản lý Chiến dịch</h1>
                        <div class="section-header-breadcrumb overflow">
                        </div>
                    </div>

                    <div class="section-body">
                    <div class="row">
                    <div class='col-md-12'>
                    <div class="card">
                    <div class="card-body">
                        <form id="search-form" method="GET" action="<?= base_url('auth/search_user') ?>">
                        <div class="row">
                            <div class="col-md-3">    
                                <!-- Khối -->
                                <div class="form-group">
                                    <label for="block">Khối</label>
                                    <select class="form-control" id="block" name="block">
                                        <option value="">Khách hàng cá nhân</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">   
                                <!-- Mã chiến dịch -->
                                <div class="form-group">
                                    <label for="MaCD">Mã chiến dịch</label>
                                    <input type="text" class="form-control" id="MaCD" name="MaCD" placeholder="Nhập mã chiến dịch">
                                </div>
                            </div>    
                            <div class="col-md-3">   
                                <!-- Tên chiến dịch -->
                                <div class="form-group">
                                    <label for="TenCD">Tên chiến dịch</label>
                                    <input type="text" class="form-control" id="TenCD" name="TenCD" placeholder="Nhập tên chiến dịch">
                                </div>
                            </div> 
                            <div class="col-md-3"> 
                                <!-- Mục đích -->
                                <div class="form-group">
                                    <label for="mucdich">Mục đích</label>
                                    <select class="form-control" id="mucdich" name="mucdich">
                                        <option value="">Tất cả</option>
                                        <option value="1">Xúc tiến kinh doanh bên ngoài</option>
                                        <option value="2">Hội nghị khách hàng</option>
                                        <option value="3">Chương trình thi đua</option>
                                        <option value="4">Chương trình khuyến mại</option>
                                        <option value="5">Chiến dịch bán hàng</option>
                                        <option value="6">Quảng cáo sản phẩm</option>
                                        <option value="7">Phát triển khách hàng</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <!-- Hình thức -->
                                <div class="form-group">
                                    <label for="hinhthuc">Hình thức</label>
                                    <select class="form-control" id="hinhthuc" name="hinhthuc">
                                        <option value="">Tất cả</option>
                                        <option value="1">Gặp trực tiếp</option>
                                        <option value="2">Gọi điện</option>
                                        <option value="3">Hội thảo</option>
                                        <option value="4">Roadshow</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <!-- Trạng thái -->
                                <div class="form-group">
                                    <label for="trangthai">Trạng thái</label>
                                    <select class="form-control" id="trangthai" name="trangthai">
                                        <option value="">Tất cả</option>
                                        <option value="1">Đang soạn thảo</option>
                                        <option value="2">Đã kích hoạt</option>
                                        <option value="3">Đã kết thúc</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <!-- Tình trạng -->
                                <div class="form-group">
                                    <label for="tinhtrang">Tình trạng</label>
                                    <select class="form-control" id="tinhtrang" name="tinhtrang">
                                        <option value="">Hiệu lực</option>
                                        <option value="1">Không hiệu lực</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <!-- Ngày bắt đầu -->
                                <div class="form-group">
                                    <label>Từ ngày...</label>
                                    <div class="input-group">
                                        <?= form_input(['name' => 'start_date', 'type' => 'date', 'class' => 'form-control']) ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3"> 
                                <!-- Ngày kết thúc -->
                                <div class="form-group">
                                    <label>Đến ngày...</label>
                                    <div class="input-group">
                                        <?= form_input(['name' => 'end_date', 'type' => 'date', 'class' => 'form-control']) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 d-flex justify-content-between align-items-center">
                            <!-- Nút Tìm kiếm và Xóa -->
                            <div>
                                <button type="submit" class="btn btn-primary" style="margin-right: 10px;">Tìm kiếm</button>
                                <button type="reset" class="btn btn-secondary">Xóa</button>
                            </div>

                            <!-- Hiển thị thêm nút Thêm mới -->
                            <div>
                                <?php if (check_permissions("projects", "create")) { ?>
                                    <button class="btn btn-primary btn-rounded no-shadow" id="modal-add-project">
                                    <i class="fas fa-plus"></i>
                                </button>
                                <?php } ?>
                            </div>
                        </div>
                        </form>

                        <!-- Bảng kết quả tìm kiếm -->
                        <div class="table-responsive mt-4">
                            <table class='table-striped' id='projects_list' data-toggle="table" data-url="<?= base_url('projects/get_projects_list') ?>" data-side-pagination="server" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-show-columns="true" data-show-refresh="true" data-sort-name="Machiendich" data-sort-order="asc" data-mobile-responsive="true" data-toolbar="" data-show-export="true" data-maintain-selected="true" data-export-options='{
                            "fileName": "projects-list",
                                    "ignoreColumn": ["state"] 
                                }' 
                                data-query-params="queryParams">            
                                <thead>
                                    <tr>
                                        <th data-field="stt" data-sortable="false">STT</th>
                                        <th data-field="Machiendich" data-sortable="true">Mã chiến dịch</th>

                                        <th data-field="Tenchiendich" data-sortable="true">Tên chiến dịch</th>

                                        <th data-field="Mucdich" data-sortable="true">Mục đích</th>

                                        <th data-field="Ngaybd" data-sortable="true">Ngày bắt đầu</th>
                                        <th data-field="Ngaykt" data-sortable="false">Ngày kết thúc</th>
                                        <th data-field="Trangthai" data-sortable="false">Trạng thái</th>
                                        <th data-field="CapCD" data-sortable="true">Cấp chiến dịch</th>
                                        <th data-field="Donvi" data-sortable="false">Đơn vị chiến dịch</th>
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

                </section>
            </div>
            <?php if (check_permissions("projects", "create")) { ?>
                <form action="<?= base_url('projects/create'); ?>" method="post" class="modal-part" id="modal-add-project-part">
                    <div id="modal-title" class="d-none">Tạo chiến dịch</div>
                    <div id="modal-footer-add-title" class="d-none"><?= !empty($this->lang->line('label_add')) ? $this->lang->line('label_add') : 'Add'; ?></div>
                    <div class="row">
                    <div class="col-md-12"><h6 style="margin-bottom: 20px; border-bottom: 1px solid;">Thông tin chi tiết</h6></div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Mã chiến dịch</label>
                                <?= form_input(['name' => '', 'value' => '$campaigns_code', 'class' => 'form-control', 'readonly' => 'readonly']) ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Tên chiến dịch</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Nhập tên chiến dịch">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                            <label>Mục đích chiến dịch</label>
                                <select id="mucdich" class="form-control" name="mucdich">
                                    <option value="default"></option>
                                    <option value="1">Xúc tiến kinh doanh bên ngoài</option>
                                    <option value="2">Hội nghị khách hàng</option>
                                    <option value="3">Chương trình thi đua</option>
                                    <option value="4">Chương trình khuyến mại</option>
                                    <option value="5">Chiến dịch bán hàng</option>
                                    <option value="6">Quảng cáo sản phẩm</option>
                                    <option value="7">Phát triển khách hàng</option>
                                    </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                            <label>Hình thức chiến dịch</label>
                                <select id="hinhthuc" class="form-control" name="hinhthuc">
                                    <option value=""></option>
                                    <option value="1">Gặp trực tiếp</option>
                                    <option value="2">Gọi điện</option>
                                    <option value="3">Hội thảo</option>
                                    <option value="4">Roadshow</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                        <label>Khối khai thác chiến dịch</label>
                            <select class="form-control" id="block" name="block">
                                <option value="">Khách hàng cá nhân</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                        <label>Đối tượng khách hàng</label>
                            <select class="form-control" id="KH" name="KH">
                                <option value="">KHCN</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                        <label>Kênh bán</label>
                            <select class="form-control" id="KH" name="KH">
                                <option value="">Tất cả</option>
                                <option value="1">APP CHAT</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                        <label>Sản phẩm</label>
                            <select class="form-control" id="SP" name="SP">
                                <option value=""></option>
                                <option value="1">Tài khoản thanh toán</option>
                                <option value="2">Tiết kiệm</option>
                                <option value="3">Tín dụng</option>
                                <option value="4">Bảo lãnh</option>
                                <option value="5">Trái phiếu</option>
                                <option value="6">Tài trợ thương mại</option>
                                <option value="7">Thẻ</option>
                                <option value="8">Ebanking</option>
                                <option value="9">SMS</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4"><label>Quy trình thực hiện</label>
                            <select class="form-control" id="quytrinh" name="quytrinh">
                                <option value="">Quy trình bán</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4"><label>Nguồn dữ liệu</label>
                            <select class="form-control" id="DL" name="DL">
                                <option value="">Chiến dịch từ HO</option>
                                <option value="1">Chiến dịch từ chi nhánh</option>
                                <option value="2">App MB/Fanpage</option>
                                <option value="3">Telesale</option>
                                <option value="4">247</option>
                                <option value="5">Referral</option>
                                <option value="6">Khác</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="start_date">Ngày bắt đầu</label>
                            <input class="form-control datepicker" type="text" id="start_date" name="start_date" value="" autocomplete="off">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="end_date">Ngày kết thúc</label>
                            <input class="form-control datepicker" type="text" id="end_date" name="end_date" value="" autocomplete="off">
                        </div>
                        <div class="form-group col-md-4"><label>Trạng thái</label>
                            <select class="form-control" id="trangthai" name="trangthai">
                                <option value="1">Đang soạn thảo</option>
                                <option value="2">Đã kích hoạt</option>
                                <option value="3">Đã kết thúc</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                        <label style="margin-bottom: 20px;">Quy mô chiến dịch</label>
                            <div>
                                <label class="radio-inline" style="margin-right: 55px;">
                                    <input type="radio" name="trangthai" value="1">  Toàn hàng
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="trangthai" value="2">  Vùng miền
                                </label>
                            </div>
                        </div>
                        <div class="form-group col-md-4"><label>Ảnh</label>
                            <input type="file" name="upload_file" class="form-control mr-3" accept=".png" style="max-width: 300px;" />
                        </div>

                        <div class="form-group col-md-12">
                            <label>Nội dung</label>
                            <div class="input-group">
                                <textarea type="textarea" class="form-control" placeholder="Nhập nội dung" name="description"></textarea>
                            </div>
                        </div>
                        <div class="form-group col-md-12"><label>Cho phép RM thêm mới KH</label>
                            <div>   
                                <label class="checkbox-inline" style="margin-right: 20px;">
                                    <input type="checkbox" name="" value="1">
                                </label>
                            </div>
                        </div>

                        <div class="form-group col-md-12"><h6 style="border-bottom: 1px solid;">Thêm KH vào chiến dịch</h6>
                        </div>
                        <div class="col-md-6">
                            <label>Chọn KH</label>
                            <div class="search-container d-flex">
                                <?php if (check_permissions("clients", "read")) { ?>
                                <button class="btn btn-primary btn-rounded no-shadow" id="modal-search-client">
                                    <i class="fas fa-search"></i> Tìm kiếm khách hàng
                                </button>
                                <?php } ?>
                            </div>
                        </div>
                        <!-- Bảng kết quả tìm kiếm -->
                        <div class="table-responsive mt-4">
                        <table class='table-striped' id='clients_list' data-toggle="table" data-url="<?= base_url('clients/get_clients_list') ?>" data-side-pagination="server" data-pagination="true" data-page-list="[5,10]" data-show-columns="true" data-show-refresh="true" data-sort-name="MaKH" data-sort-order="asc" data-mobile-responsive="true" data-toolbar="" data-show-export="true" data-maintain-selected="true" data-export-options='{
                        "fileName": "clients-list",
                                "ignoreColumn": ["state"] 
                            }' 
                            data-query-params="queryParams">            
                                <thead>
                                    <tr>
                                        <th data-field="stt" data-sortable="false">STT</th>
                                        <th data-field="MaKH" data-sortable="true"><?= !empty($this->lang->line('label_id')) ? $this->lang->line('label_id') : 'ID'; ?></th>

                                        <th data-field="TenKH" data-sortable="true"><?= !empty($this->lang->line('label_clients_name')) ? $this->lang->line('label_clients_name') : 'Tên khách hàng'; ?></th>

                                        <th data-field="SDT" data-sortable="true">Số điện thoại</th>
                                        <th data-field="Email" data-sortable="true">Email</th>

                                        <th data-field="CNquanly" data-sortable="false">Chi nhánh giao dịch</th>
                                        <?php if (check_permissions("clients", "delete")) { ?>
                                            <th data-field="action" data-sortable="false"><?= !empty($this->lang->line('label_action')) ? $this->lang->line('label_action') : 'Action'; ?></th>
                                         <?php }?>
                                    </tr>   
                                </thead>
                            </table>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="status"><?= !empty($this->lang->line('label_status')) ? $this->lang->line('label_status') : 'Status'; ?></label><span class="asterisk"> *</span>
                                <div class="input-group">
                                    <select class="custom-select select2" id="statuses_project_id" name="status">
                                        <option value="" selected><?= !empty($this->lang->line('label_choose_statuses')) ? $this->lang->line('label_choose_statuses') : 'Choose Statuses'; ?>...</option>
                                        <?php
                                        foreach ($statuses_project as $status) { ?>
                                            <option value="<?= $status['status'] ?>"><?= $status['status'] ?></option>
                                        <?php } ?>
                                    </select>
                                    <div class="wrapper" id="wrp" style="display: none;">
                                        <hr><a href="#" id="modal-add-statuses"> + <?= !empty($this->lang->line('label_add_statuses')) ? $this->lang->line('label_add_statuses') : 'Add Statuses'; ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            <?php } ?>
            <form action="<?= base_url('projects/edit'); ?>" method="post" class="modal-part" id="modal-edit-project-part">
                <div id="modal-edit-project-title" class="d-none"><?= !empty($this->lang->line('label_edit')) ? $this->lang->line('label_edit') : 'Edit'; ?><?= !empty($this->lang->line('label_projects')) ? '  ' . $this->lang->line('label_projects') : '  Projects '; ?></div>
                <div id="modal-footer-edit-title" class="d-none"><?= !empty($this->lang->line('label_edit')) ? $this->lang->line('label_edit') : 'Edit'; ?></div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label><?= !empty($this->lang->line('label_title')) ? $this->lang->line('label_title') : 'Title'; ?></label>
                            <div class="input-group">
                                <input type="hidden" name="update_id" id="update_id">
                                <input type="text" class="form-control" placeholder=<?= !empty($this->lang->line('label_title')) ? $this->lang->line('label_title') : 'Title'; ?> name="title" id="update_title">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="status"><?= !empty($this->lang->line('label_status')) ? $this->lang->line('label_status') : 'Status'; ?></label><span class="asterisk"> *</span>
                            <div class="input-group">
                                <select class="custom-select select2" id="update_status" name="status">
                                    <option value="" selected><?= !empty($this->lang->line('label_choose_statuses')) ? $this->lang->line('label_choose_statuses') : 'Choose Statuses'; ?>...</option>
                                    <?php
                                    foreach ($statuses_project as $status) { ?>
                                        <option value="<?= $status['status'] ?>"><?= $status['status'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="budget"><?= !empty($this->lang->line('label_budget')) ? $this->lang->line('label_budget') : 'Budget'; ?></label>
                            <div class="input-group">
                                <span class="input-group-addon bootstrap-touchspin-prefix input-group-prepend"><span class="input-group-text"><?= get_currency_symbol(); ?></span></span>
                                <input class="form-control" type="number" min="0" id="update_budget" name="budget" value="150" placeholder=<?= !empty($this->lang->line('label_budget')) ? $this->lang->line('label_budget') : 'Budget'; ?>>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="start_date"><?= !empty($this->lang->line('label_start_date')) ? $this->lang->line('label_start_date') : 'Start Date'; ?></label>
                            <input class="form-control datepicker" type="text" id="update_start_date" name="start_date" autocomplete="off">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="end_date"><?= !empty($this->lang->line('label_end_date')) ? $this->lang->line('label_end_date') : 'End Date'; ?></label>
                            <input class="form-control datepicker" type="text" id="update_end_date" name="end_date" autocomplete="off">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label><?= !empty($this->lang->line('label_description')) ? $this->lang->line('label_description') : 'Description'; ?></label>
                            <div class="input-group">
                                <textarea type="textarea" class="form-control" placeholder=<?= !empty($this->lang->line('label_description')) ? $this->lang->line('label_description') : 'Description'; ?> name="description" id="update_description"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="form-group">
                                <?= !empty($this->lang->line('label_priority')) ? $this->lang->line('label_priority') : 'Priority'; ?>
                                <select id="update_priority" class="form-control" name="priority">
                                    <option value="default"><?= !empty($this->lang->line('label_select_priority')) ? $this->lang->line('label_select_priority') : 'Select Priority'; ?></option>
                                    <option value="low"><?= !empty($this->lang->line('label_low_priority')) ? $this->lang->line('label_low_priority') : 'Low Priority'; ?></option>
                                    <option value="medium"><?= !empty($this->lang->line('label_medium_priority')) ? $this->lang->line('label_medium_priority') : 'Medium Priority'; ?></option>
                                    <option value="high"><?= !empty($this->lang->line('label_high_priority')) ? $this->lang->line('label_high_priority') : 'High Priority'; ?></option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label><?= !empty($this->lang->line('label_select_users')) ? $this->lang->line('label_select_users') : 'Select Users'; ?> (Make Sure You Don't Remove Yourself From Project)</label>
                            <select class="form-control select2" multiple="" name="users[]" id="update_users">
                                <?php foreach ($all_user as $all_users) {
                                    if (!is_client($all_users->id)) { ?>
                                        <option value="<?= $all_users->id ?>"><?= $all_users->first_name ?> <?= $all_users->last_name ?></option>
                                <?php }
                                } ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="clients"><?= !empty($this->lang->line('label_select_clients')) ? $this->lang->line('label_select_clients') : 'Select Clients'; ?></label>
                            <select id="update_clients" name="clients[]" class="form-control select2" multiple="">
                                <?php
                                if (is_client($client_ids['id'])) {
                                    foreach ($client_ids as $client_id) {
                                ?>
                                        <option value="<?= $client_id['id'] ?>">
                                            <?= $client_id['first_name'] ?> <?= $client_id['last_name'] ?>
                                        </option>
                                        <?php
                                    }
                                } else {
                                    foreach ($all_user as $all_users) {
                                        if (is_client($all_users->id)) {
                                        ?>
                                            <option value="<?= $all_users->id ?>">
                                                <?= $all_users->first_name ?> <?= $all_users->last_name ?>
                                            </option>
                                <?php
                                        }
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                </div>
            </form>

            <div class="modal fade" id="modal-add-project-task" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"><?= !empty($this->lang->line('label_add_task')) ? $this->lang->line('label_add_task') : 'Add Task'; ?></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="<?= base_url('tasks/create_task'); ?>" method="post" id="add_project_task">
                                <div class="row">
                                    <input type="hidden" name="project_id" id="task-track-id">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><?= !empty($this->lang->line('label_title')) ? $this->lang->line('label_title') : 'Title'; ?></label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="<?= !empty($this->lang->line('label_title')) ? $this->lang->line('label_title') : 'Title'; ?>" name="title">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="milestone_id"><?= !empty($this->lang->line('label_milestone')) ? $this->lang->line('label_milestone') : 'Milestone'; ?></label>
                                            <select id="milestone_id" name="milestone_id" class="form-control">
                                                <option value="" selected><?= !empty($this->lang->line('label_select_milestone')) ? $this->lang->line('label_select_milestone') : 'Select Milestone'; ?></option>
                                                <?php foreach ($milestones as $milestone) { ?>
                                                    <option value="<?= $milestone['id'] ?>"><?= $milestone['title'] ?></option>
                                                <?php } ?>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="priority"><?= !empty($this->lang->line('label_priority')) ? $this->lang->line('label_priority') : 'Priority'; ?></label>
                                            <select id="priority" name="priority" class="form-control">
                                                <option value="low"><?= !empty($this->lang->line('label_low')) ? $this->lang->line('label_low') : 'Low'; ?></option>
                                                <option value="medium"><?= !empty($this->lang->line('label_medium')) ? $this->lang->line('label_medium') : 'Medium'; ?></option>
                                                <option value="high"><?= !empty($this->lang->line('label_high')) ? $this->lang->line('label_high') : 'High'; ?></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="status"><?= !empty($this->lang->line('label_status')) ? $this->lang->line('label_status') : 'Status'; ?></label><span class="asterisk"> *</span>
                                            <div class="input-group">
                                                <select class="custom-select select2" id="statuses_task_id" name="status">
                                                    <option value="" selected><?= !empty($this->lang->line('label_choose_statuses')) ? $this->lang->line('label_choose_statuses') : 'Choose Statuses'; ?>...</option>
                                                    <?php
                                                    foreach ($statuses_task as $status) { ?>
                                                        <option value="<?= $status['status'] ?>"><?= $status['status'] ?></option>
                                                    <?php } ?>
                                                </select>
                                                <div class="wrapper" id="wrp" style="display: none;">
                                                    <hr><a href="#" id="modal-add-statuses"> + <?= !empty($this->lang->line('label_add_statuses')) ? $this->lang->line('label_add_statuses') : 'Add Statuses'; ?></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label><?= !empty($this->lang->line('label_description')) ? $this->lang->line('label_description') : 'Description'; ?></label>
                                            <div class="input-group">
                                                <textarea type="textarea" class="form-control" placeholder="<?= !empty($this->lang->line('label_description')) ? $this->lang->line('label_description') : 'Description'; ?>" name="description"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <?php if (!is_client()) { ?>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label><?= !empty($this->lang->line('label_assign_to')) ? $this->lang->line('label_assign_to') : 'Assign To'; ?></label>
                                                <select class="form-control select2" multiple="" name="user_id[]" id="update_user_id">
                                                    <?php foreach ($all_user as $all_users) { ?>
                                                        <option value="<?= $all_users->id ?>"><?= $all_users->first_name ?> <?= $all_users->last_name ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="start_date"><?= !empty($this->lang->line('label_start_date')) ? $this->lang->line('label_start_date') : 'Start Date'; ?></label>
                                            <input class="form-control datepicker" type="text" id="start_date" name="start_date" value="" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="end_date"><?= !empty($this->lang->line('label_due_date')) ? $this->lang->line('label_due_date') : 'Due Date'; ?></label>
                                            <input class="form-control datepicker" type="text" id="due_date" name="due_date" value="" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary" id="submit_button"><?= !empty($this->lang->line('label_submit')) ? $this->lang->line('label_submit') : 'Submit'; ?></button>
                        </div>
                        </form>

                    </div>
                </div>
            </div>

            <!-- Form tìm kiếm khách hàng -->
            <?php if (check_permissions("clients", "read")) { ?>
                <div class="card mt-4">
                    <div class="card-body">
                        <!-- Mở Form tìm kiếm -->
                        <?= form_open('auth/search_user', 'id="modal-add-user-part"', 'class="modal-part"'); ?>
                            <?php $context = 'campaigns_clients'; ?>
                            <?php include('search-client-form.php'); ?>
                        </form>
                    </div>
                </div>
            <?php } ?>   

            <?php include('include-footer.php'); ?>

        </div>
    </div>

    <?php include('include-js.php'); ?>

    <!-- Page Specific JS File -->

    <script src="<?= base_url('assets/js/page/components-user.js'); ?>"></script>
    <script src="<?= base_url('assets/js/page/components-statuses.js'); ?>"></script>

</body>

</html>