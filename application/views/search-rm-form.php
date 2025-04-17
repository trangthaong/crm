<div class="row">
    <div class='col-md-12'>
        <div class="card">
            <div class="card-body">
                <form id="search-form" method="GET" action="<?= base_url('auth/search_user') ?>">
                    <div class="row"
                         style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1px 30px; padding: 0 15px;">
                        <!-- Mã khách hàng -->
                        <div class="form-group">
                            <label for="customer_code">Mã khách hàng</label>
                            <input type="text" class="form-control" id="customer_code" name="customer_code"
                                   placeholder="Nhập mã khách hàng">
                        </div>

                        <!-- Tên khách hàng -->
                        <div class="form-group">
                            <label for="customer_name">Tên khách hàng</label>
                            <input type="text" class="form-control" id="customer_name" name="customer_name"
                                   placeholder="Nhập tên khách hàng">
                        </div>

                        <!-- Số điện thoại -->
                        <div class="form-group">
                            <label for="phone">Số điện thoại</label>
                            <input type="text" class="form-control" id="phone" name="phone"
                                   placeholder="Nhập số điện thoại">
                        </div>

                        <!-- Số CMT/hộ chiếu -->
                        <div class="form-group">
                            <label for="identity">Số CMT/Hộ chiếu</label>
                            <input type="text" class="form-control" id="identity" name="identity"
                                   placeholder="Nhập số CMT/Hộ chiếu">
                        </div>

                        <!-- Khối -->
                        <div class="form-group">
                            <label for="block">Khối</label>
                            <select class="form-control" id="block" name="block">
                                <option value="">Chọn khối</option>
                                <option value="1">Khối 1</option>
                                <option value="2">Khối 2</option>
                            </select>
                        </div>

                        <!-- Tần suất giao dịch -->
                        <div class="form-group">
                            <label for="frequency">Tần suất giao dịch</label>
                            <select class="form-control" id="frequency" name="frequency">
                                <option value="">Chọn tần suất</option>
                                <option value="low">Thấp</option>
                                <option value="medium">Trung bình</option>
                                <option value="high">Cao</option>
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
                                <button type="submit" class="btn btn-primary" style="margin-right: 10px;">Tìm kiếm
                                </button>
                                <button type="reset" class="btn btn-secondary">Xóa</button>
                            </div>

                            <!-- Hiển thị thêm nút Thêm từ file và Thêm mới nếu context là client_page -->
                            <?php if (isset($context) && $context === 'client_page') { ?>
                                <div>
                                    <?php if (check_permissions("clients", "create")) { ?>
                                        <i class="btn btn-primary btn-rounded no-shadow" id="modal-add-from-file"
                                           style="margin-right: 10px;">
                                            <?= !empty($this->lang->line('label_add_client_2')) ? $this->lang->line('label_add_client_2') : 'Thêm từ file'; ?>
                                        </i>
                                    <?php } ?>
                                    <?php if (check_permissions("clients", "create")) { ?>
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
                    <table class='table-striped' id='clients_list'
                           data-toggle="table"
                           data-url="<?= base_url('users/get_users_list') ?>"
                           data-side-pagination="server"
                           data-pagination="true"
                           data-page-list="[5, 10, 20, 50, 100, 200]"
                           data-show-columns="true"
                           data-show-refresh="true"
                           data-sort-name="full_name"
                           data-sort-order="asc"
                           data-mobile-responsive="true"
                           data-toolbar=""
                           data-show-export="true"
                           data-maintain-selected="true"
                           data-export-options='{"fileName": "clients-list","ignoreColumn": ["state"]}'
                           data-query-params="queryParams"
                           data-click-to-select="true"
                           data-single-select="true"
                           data-unique-id="id"
                    >
                        <thead>
                        <tr>
                            <th data-field="state" data-radio="true">Chọn</th>
                            <th data-field="rm_code" data-sortable="true">Mã khách hàng</th>
                            <th data-field="full_name" data-sortable="true">Tên khách hàng</th>
                            <th data-field="email" data-sortable="true">Email</th>
                            <th data-field="phone_number" data-sortable="true">Số điện thoại</th>
<!--                            <th data-field="MaKH"-->
<!--                                data-sortable="true">--><?php //= !empty($this->lang->line('label_id')) ? $this->lang->line('label_id') : 'ID'; ?><!--</th>-->
<!---->
<!--                            <th data-field="TenKH"-->
<!--                                data-sortable="true">--><?php //= !empty($this->lang->line('label_clients_name')) ? $this->lang->line('label_clients_name') : 'Tên khách hàng'; ?><!--</th>-->
<!---->
<!--                            <th data-field="Khoi"-->
<!--                                data-sortable="true">--><?php //= !empty($this->lang->line('label_company')) ? $this->lang->line('label_company') : 'Khối'; ?><!--</th>-->
<!---->
<!--                            <th data-field="CASA" data-sortable="true">CASA hiện tại</th>-->
<!---->
<!--                            <th data-field="TK" data-sortable="false">Tiết kiệm hiện tại</th>-->
<!--                            <th data-field="TD" data-sortable="false">Tín dụng hiện tại</th>-->
<!--                            <th data-field="SDT" data-sortable="true">Số điện thoại</th>-->
<!---->
<!--                            <th data-field="CNquanly" data-sortable="false">Sector</th>-->
<!--                            <th data-field="RMquanly" data-sortable="false">RM quản lý</th>-->
<!--                            <th data-field="MaDV" data-sortable="false">Mã đơn vị mở code</th>-->
<!--                            <th data-field="TenDV" data-sortable="false">Tên đơn vị mở code</th>-->
<!--                            --><?php //if (check_permissions("clients", "delete")) { ?>
<!--                                <th data-field="action"-->
<!--                                    data-sortable="false">--><?php //= !empty($this->lang->line('label_action')) ? $this->lang->line('label_action') : 'Action'; ?><!--</th>-->
<!--                                --><?php ////}
//                                ?>
<!--                            --><?php //}
//                            ?>
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
