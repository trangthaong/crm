<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title><?= !empty($this->lang->line('label_leads')) ? $this->lang->line('label_leads') : 'leads'; ?>
        &mdash; <?= get_compnay_title(); ?></title>
    <?php include('include-css.php'); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"/>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <style>
        .dropdown-container {
            width: 300px;
            margin: 20px;
        }

        .select2-container--default .select2-results__option:hover {
            background-color: #6777ef;
            color: #fff;
        }

        select {
            width: 100%;
            padding: 8px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
    </style>
</head>
<body>
<div id="app">
    <div class="main-wrapper main-wrapper-1">

        <?php include('include-header.php'); ?>

        <!-- Main Content -->
        <div class="main-content">
            <section class="section">
                <div class="section-header">
                    <h1>Phân giao Khách hàng tiềm năng cho đơn vị</h1>
                    <div class="section-header-breadcrumb">


                    </div>
                </div>

                <div class="section-body">
                    <div class="row">
                        <div class='col-md-12'>
                            <div class="card">
                                <div class="card-body">
                                    <form id="search-form" method="POST"
                                          action="<?= base_url('leads/assign_leads_unit_to_user') ?>">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <label for="pgd">Chọn Đơn vị:</label>
                                                    <!-- Dropdown với tính năng tìm kiếm -->
                                                    <select id="pgd" class="select2-dropdown">
                                                        <option value="">Chọn Đơn vị</option>
                                                        <option value="VN0010742">VN0010742 - PGD Pho Noi</option>
                                                        <option value="VN0010660">VN0010660 - PGD Pho Yen</option>
                                                        <option value="VN0010843">VN0010843 - PGD Lam Son</option>
                                                        <option value="VN0010233">VN0010233 - PGD Gia Vien</option>
                                                        <option value="VN0010719">VN0010719 - PGD Tan Hiep</option>
                                                        <option value="VN0010715">VN0010715 - PGD Duc Hoa</option>
                                                        <option value="VN0010332">VN0010332 - PGD Nam Phuoc</option>
                                                    </select>
                                                </div>


                                                <div class="col-md-7">
                                                    <label>Ghi chú</label>
                                                    <textarea id="additional-input" class="form-control"
                                                              placeholder="Nhập ghi chú" rows="4"></textarea>
                                                </div>

                                                <div class="col-md-6">
                                                    <label>Chọn KH phân giao</label>
                                                    <div class="search-container d-flex">
                                                        <?php if (check_permissions("leads", "read")) { ?>
                                                            <button class="btn btn-primary btn-rounded no-shadow"
                                                                    id="modal-search-client">
                                                                <i class="fas fa-search"></i> Tìm kiếm khách hàng
                                                            </button>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Nút Tìm kiếm và Xóa -->
                                        <div class="d-flex justify-content-between">
                                            <button type="reset" class="btn btn-secondary">Xóa</button>
                                            <button type="submit" class="btn btn-primary">Phân giao</button>
                                        </div>
                                    </form>

                                    <!-- Bảng kết quả tìm kiếm -->
                                    <div class="table-responsive mt-4">
                                        <table class='table-striped'
                                               id='leads_list'
                                               data-toggle="table"
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
                                               data-export-options='{"fileName": "leads-list","ignoreColumn": ["state"]}'
                                        >
                                            <thead>
                                            <tr>
                                                <th data-field="stt" data-sortable="false">STT</th>
                                                <th data-field="MaKH"
                                                    data-sortable="true"><?= !empty($this->lang->line('label_id')) ? $this->lang->line('label_id') : 'ID'; ?></th>

                                                <th data-field="TenKH"
                                                    data-sortable="true"><?= !empty($this->lang->line('label_leads_name')) ? $this->lang->line('label_leads_name') : 'Tên khách hàng'; ?></th>

                                                <th data-field="SDT" data-sortable="true">Số điện thoại</th>
                                                <th data-field="Email" data-sortable="true">Email</th>

                                                <th data-field="CNquanly" data-sortable="false">Chi nhánh giao dịch</th>
                                                <?php if (check_permissions("leads", "delete")) { ?>
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
                </div>
            </section>
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

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                    <form method="post" action="<?= base_url('users/set_user_permission') ?>"
                          id="user_permission_module">

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
                                        <th scope="col"><?= !empty($this->lang->line('label_update')) ? $this->lang->line('label_update') : 'Update'; ?>
                                            Update
                                        </th>
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
                                                        <input type="checkbox"
                                                               name="<?= 'permissions[' . $module . '][' . $actions[$i] . ']' ?>">
                                                    </td>
                                                <?php } else { ?>
                                                    <td class="col-sm-2 text-center">
                                                        -
                                                    </td>
                                                <?php }
                                            } ?>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" id="submit_button_update"
                                    class="btn btn-primary"><?= !empty($this->lang->line('label_save')) ? $this->lang->line('label_save') : 'Save'; ?></button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="d-none">
        <!-- Form tìm kiếm khách hàng -->
        <?php if (check_permissions("leads", "read")) { ?>
            <div class="card mt-4">
                <div class="card-body">
                    <!-- Mở Form tìm kiếm -->
                    <?= form_open('auth/search_user', 'id="modal-add-user-part"', 'class="modal-part"'); ?>
                    <?php $context = 'assign_leads'; ?>
                    <?php include('search-client-form.php'); ?>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<script>
    window.clientFilter = {
        unitQuanLy: "IS NULL"
    }

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
<script>
    function submitSelectedClients() {
        // Tìm modal đang mở
        const modal = $('.modal:visible');

        // Tìm bảng clients_list bên trong modal đó
        const clientsTable = modal.find('#clients_list');

        // Lấy danh sách được chọn từ bảng đúng
        const selectedClients = clientsTable.bootstrapTable('getSelections');

        if (selectedClients.length === 0) {
            alert('Vui lòng chọn ít nhất một khách hàng!');
            return;
        }

        selectedClients.forEach(client => {
            addClientToLeadsTable(client);
        });
    }

    function addClientToLeadsTable(client) {
        // Check trùng theo MaKH_raw
        const exists = $('#leads_list').bootstrapTable('getData').some(row => row.MaKH_raw === client.MaKH_raw);
        if (exists) return;

        const currentData = $('#leads_list').bootstrapTable('getData');
        const newIndex = currentData.length + 1;

        $('#leads_list').bootstrapTable('append', {
            stt: newIndex,
            MaKH_raw: client.MaKH_raw, // dùng làm uniqueId
            MaKH: client.MaKH,   // hiển thị link HTML nếu có
            TenKH: client.TenKH,
            SDT: client.SDT,
            Email: client.Email,
            CNquanly: client.CNquanly,
            action: `<button class="btn btn-danger btn-sm" data-makh="${client.MaKH_raw}" onclick="removeClientFromLeadsTable(this)">Xóa</button>`
        });
        // ✅ Đánh lại STT
        resetTableSTT();
    }

    function resetTableSTT() {
        const data = $('#leads_list').bootstrapTable('getData');
        data.forEach((row, index) => {
            row.stt = index + 1;
        });

        $('#leads_list').bootstrapTable('load', data);
    }

    function removeClientFromLeadsTable(button) {
        const maKH = $(button).data('makh');
        console.log("%c 1 --> Line: 305||assign-leads-rm.php\n maKH: ", "color:#f0f;", maKH);

        // Xóa dòng khỏi bảng chính
        $('#leads_list').bootstrapTable('removeByUniqueId', maKH);

        // ✅ Bỏ chọn checkbox trong bảng popup nếu tồn tại
        $('#clients_list').bootstrapTable('uncheckBy', {
            field: 'MaKH_raw',
            values: [maKH]
        });

        // ✅ Đánh lại STT
        resetTableSTT();
    }

    $('#search-form').on('submit', function (e) {
        e.preventDefault();

        // Validate trước
        const pgd = $('#pgd').val()?.trim();
        const data = $('#leads_list').bootstrapTable('getData');
        const maKHList = data.map(item => $('<div>').html(item.MaKH).text());

        if (!pgd) {
            alert('Vui lòng chọn RM trước khi phân giao!');
            return;
        }

        if (maKHList.length === 0) {
            alert('Vui lòng chọn ít nhất 1 khách hàng để phân giao!');
            return;
        }

        // Dữ liệu gửi đi
        const payload = {
            pgd: pgd,
            assigned_clients: JSON.stringify(maKHList),
            note: $('#additional-input').val()?.trim() || '',
            [csrfName]: csrfHash
        };

        const url = $(this).attr('action');

        $.ajax({
            url,
            type: 'POST',
            data: payload,
            dataType: 'json',
            success: function (response) {
                if (response.csrfName && response.csrfHash) {
                    csrfName = response.csrfName;
                    csrfHash = response.csrfHash;
                }

                if (response.error === false) {
                    iziToast.success({
                        title: response['message'],
                        message: '',
                        position: 'topRight'
                    });
                    // ✅ Reset các input sau khi phân giao
                    $('#pgd').val('').trigger('change');
                    $('#additional-input').val('');
                    $('#assigned-clients').val('');

                    // ✅ Xóa toàn bộ dữ liệu KH đã chọn trong bảng
                    $('#leads_list').bootstrapTable('removeAll');

                    // ✅ Làm mới bảng KH trong popup
                    $('#clients_list').bootstrapTable('refresh');
                } else {
                    iziToast.success({
                        title: response['message'],
                        message: '',
                        position: 'topRight'
                    });
                }
            },
            error: function (xhr, status, error) {
                console.error(error);
                iziToast.success({
                    title: 'Đã có lỗi xảy ra khi phân giao.',
                    message: '',
                    position: 'topRight'
                });
            }
        });
    });

    function fetchUnitsAndInitSelect() {
        $.ajax({
            url: '<?= base_url('units/get_units_by_workspace') ?>',
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                console.log("%c 1 --> Line: 419||assign-leads-unit.php\n response: ", "color:#f0f;", response);
                if (response.error === false && Array.isArray(response.data?.rows)) {
                    const options = response.data?.rows.map(unit => ({
                        id: unit.id, // hoặc mã đơn vị: unit.code nếu bạn dùng
                        text: `${unit.id} - ${unit.title}`
                    }));

                    $('#pgd').empty().select2({
                        placeholder: 'Chọn Đơn vị',
                        data: [
                            {id: '', text: 'Chọn Đơn vị'}, // Placeholder
                            ...options
                        ],
                        allowClear: true
                    });
                } else {
                    console.warn('Không có dữ liệu đơn vị.');
                }
            },
            error: function () {
                console.error("Lỗi khi lấy dữ liệu đơn vị.");
            }
        });
    }

    fetchUnitsAndInitSelect();
</script>

<script>
    $(window).on('load', function () { // Đảm bảo mã chỉ chạy sau khi toàn bộ trang đã tải
        $('#pgd').select2({});
    });
</script>

<script src="assets/js/page/components-leads.js"></script>
</body>

</html>