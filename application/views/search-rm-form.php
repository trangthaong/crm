<div class="row">
    <div class='col-md-12'>
        <div class="card">
            <div class="card-body">
                <div id="rm-search-form">
<!--                <form id="rm-search-form" method="GET" action="--><?php //= base_url('users/get_users_list') ?><!--">-->

                    <div class="row"
                         style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1px 30px; padding: 0 15px;">
                        <!-- Search -->
                        <div class="form-group">
                            <label for="search">Search</label>
                            <input type="text" class="form-control" id="search" name="search"
                                   placeholder="Nhập search">
                        </div>

                        <!-- Mã khách hàng -->
                        <div class="form-group">
                            <label for="rm_code">Mã khách hàng</label>
                            <input type="text" class="form-control" id="rm_code" name="rm_code"
                                   placeholder="Nhập mã khách hàng">
                        </div>

                        <!-- hris code -->
                        <div class="form-group">
                            <label for="hris_code">Hris code</label>
                            <input type="text" class="form-control" id="hris_code" name="hris_code"
                                   placeholder="Nhập hris code">
                        </div>

                        <!-- Tên khách hàng -->
                        <div class="form-group">
                            <label for="full_name">Tên khách hàng</label>
                            <input type="text" class="form-control" id="full_name" name="full_name"
                                   placeholder="Nhập tên khách hàng">
                        </div>

                        <!-- Số điện thoại -->
                        <div class="form-group">
                            <label for="phone">Số điện thoại</label>
                            <input type="text" class="form-control" id="phone" name="phone"
                                   placeholder="Nhập số điện thoại">
                        </div>

                        <!-- Email -->
                        <div class="form-group">
                            <label for="email_search">Email</label>
                            <input type="text" class="form-control" id="email_search" name="email_search"
                                   placeholder="Nhập email">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 d-flex justify-content-between align-items-center">
                            <!-- Nút Tìm kiếm và Xóa -->
                            <div>
                                <button onclick="rmSearchForm()" class="btn btn-primary" style="margin-right: 10px;">
                                    Tìm kiếm
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
<!--                </form>-->
                </div>

                <!-- Bảng kết quả tìm kiếm -->
                <div class="table-responsive mt-4">
                    <table class='table-striped' id='rm_clients_list'
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
                           data-query-params="searchRmFormQueryParams"
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
                            <th data-field="MaKH"
                                data-sortable="true"><?= !empty($this->lang->line('label_id')) ? $this->lang->line('label_id') : 'ID'; ?></th>

                            <th data-field="TenKH"
                                data-sortable="true"><?= !empty($this->lang->line('label_clients_name')) ? $this->lang->line('label_clients_name') : 'Tên khách hàng'; ?></th>

                            <th data-field="Khoi"
                                data-sortable="true"><?= !empty($this->lang->line('label_company')) ? $this->lang->line('label_company') : 'Khối'; ?></th>

                            <th data-field="CASA" data-sortable="true">CASA hiện tại</th>

                            <th data-field="TK" data-sortable="false">Tiết kiệm hiện tại</th>
                            <th data-field="TD" data-sortable="false">Tín dụng hiện tại</th>
                            <th data-field="SDT" data-sortable="true">Số điện thoại</th>

                            <th data-field="CNquanly" data-sortable="false">Sector</th>
                            <th data-field="RMquanly" data-sortable="false">RM quản lý</th>
                            <th data-field="MaDV" data-sortable="false">Mã đơn vị mở code</th>
                            <th data-field="TenDV" data-sortable="false">Tên đơn vị mở code</th>
                            <?php if (check_permissions("clients", "delete")) { ?>
                                <th data-field="action"
                                    data-sortable="false"><?= !empty($this->lang->line('label_action')) ? $this->lang->line('label_action') : 'Action'; ?></th>
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
