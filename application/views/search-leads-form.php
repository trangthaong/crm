<div class="row">
<div class='col-md-12'>
<div class="card">
<div class="card-body">
    <form id="search-form" method="GET" action="<?= base_url('auth/search_user') ?>">
    <div class="row" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1px 30px; padding: 0 15px;">
                <!-- Mã khách hàng -->
                <div class="form-group">
                    <label for="customer_code">Mã khách hàng</label>
                    <input type="text" class="form-control" id="customer_code" name="customer_code" placeholder="Nhập mã khách hàng">
                </div>

                <!-- Tên khách hàng -->
                <div class="form-group">
                    <label for="customer_name">Tên khách hàng</label>
                    <input type="text" class="form-control" id="customer_name" name="customer_name" placeholder="Nhập tên khách hàng">
                </div>

                <!-- Số điện thoại -->
                <div class="form-group">
                    <label for="phone">Số điện thoại</label>
                    <input type="text" class="form-control" id="phone" name="phone" placeholder="Nhập số điện thoại">
                </div>
                <!-- Email -->
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" class="form-control" id="email" name="email" placeholder="Nhập email">
                </div>
                <!-- Trạng thái -->
                <div class="form-group">
                    <label for="status">Trạng thái</label>
                    <select class="form-control" id="status" name="status">
                        <option value="">Chọn trạng thái</option>
                        <option value="new">Mới</option>
                        <option value="clients">Đã chuyển KHHH</option>
                        <option value="contact">Đã liên lạc</option>
                        <option value="develop">Cần khai thác sâu</option>
                        <option value="lead">Tiềm năng</option>
                        <option value="nocontact">Không cần liên lạc</option>



                    </select>
                </div>

                <?php if (isset($context) && $context === 'client_page') { ?>
                <!-- Đơn vị -->
                <div class="form-group">
                    <label for="unit">Đơn vị</label>
                    <select class="form-control" id="unit" name="unit">
                        <option value="">Chọn đơn vị</option>
                        <option value="unit1">Đơn vị 1</option>
                        <option value="unit2">Đơn vị 2</option>
                    </select>
                </div>

                <!-- RM quản lý -->
                <div class="form-group">
                    <label for="rm_manager">RM quản lý</label>
                    <select class="form-control" id="rm_manager" name="rm_manager">
                        <option value="">Chọn RM quản lý</option>
                        <option value="rm1">RM 1</option>
                        <option value="rm2">RM 2</option>
                    </select>
                </div>
                <?php } ?>
            </div>

            <div class="row">
            <div class="col-md-12 d-flex justify-content-between align-items-center">
            <!-- Nút Tìm kiếm và Xóa -->
            <div>
                <button type="submit" class="btn btn-primary" style="margin-right: 10px;">Tìm kiếm</button>
                <button type="reset" class="btn btn-secondary">Xóa</button>
            </div>

            <!-- Hiển thị thêm nút Thêm từ file và Thêm mới nếu context là client_page -->
            <?php if (isset($context) && $context === 'client_page') { ?>
                <div>
                    <?php if (check_permissions("leads", "create")) { ?>
                        <i class="btn btn-primary btn-rounded no-shadow" id="modal-add-from-file" style="margin-right: 10px;">Thêm từ file</i>
                    <?php } ?>
                    <?php if (check_permissions("leads", "create")) { ?>
                        <button class="btn btn-primary btn-rounded no-shadow" id="modal-add-user">
                        <i class="fas fa-plus"></i>
                    </button>
                    <?php } ?>
                </div>
            <?php } ?>

        </div>
            </div>
        </form>

        <!-- Bảng kết quả tìm kiếm -->
        <div class="table-responsive mt-4">
            <table class="table-striped" id="clients_list" data-toggle="table"
                    data-url="<?= base_url('clients/get_clients_list') ?>"
                    data-side-pagination="server"
                    data-pagination="true"
                    data-page-list="[5, 10, 20, 50, 100, 200]"
                    data-show-columns="true"
                    data-show-refresh="true"
                    data-sort-name="MaKH"
                    data-sort-order="asc"
                    data-mobile-responsive="true"
                    data-toolbar=""
                    data-show-export="true"
                    data-maintain-selected="true"
                    data-export-options='{
                        "fileName": "clients-list",
                        "ignoreColumn": ["state"]
                    }'
                    data-query-params="queryParams">
                <thead>
                    <tr>
                        <th data-field="stt" data-sortable="false">STT</th>
                        <th data-field="MaKH" data-sortable="true">ID</th>
                        <th data-field="TenKH" data-sortable="true">Tên khách hàng</th>
                        <th data-field="SDT" data-sortable="true">Số điện thoại</th>
                        <th data-field="Email" data-sortable="true">Email</th>
                        <th data-field="mucdotiemnang" data-sortable="false">Mức độ tiềm năng</th>
                        <th data-field="nguonKH" data-sortable="false">Nguồn KH</th>
                        <th data-field="RMquanly" data-sortable="false">RM quản lý</th>
                        <th data-field="MaDV" data-sortable="false">Mã đơn vị quản lý</th>
                        <th data-field="TenDV" data-sortable="false">Tên đơn vị quản lý</th>
                        <?php if (check_permissions("clients", "delete")) { ?>
                            <th data-field="action" data-sortable="false">Hành động</th>
                        <?php } ?>
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
