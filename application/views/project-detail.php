<?php
// campaign-detail.php
$cus_list = isset($get_campaign_with_customers) ? $get_campaign_with_customers["customers"] : [];
//var_dump($cus_list);
//die();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Quản lý chiến dịch</title>
    <?php include('include-css.php'); ?>
    <!-- <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: white;
            min-width: 100%;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
            max-height: 200px;
            overflow-y: auto;
        }
        .dropdown:hover .dropdown-content {
            display: block;
        }
        .dropdown-item:hover {
            background-color: #f1f1f1;
        }
        .table-container {
            overflow-x: auto;
        }
        .status-active {
            background-color: #d1fae5;
            color: #065f46;
        }
        .status-inactive {
            background-color: #fee2e2;
            color: #b91c1c;
        }
        .status-pending {
            background-color: #fef3c7;
            color: #92400e;
        }
        .status-success {
            background-color: #dbeafe;
            color: #1e40af;
        }
        .status-waiting {
            background-color: #ede9fe;
            color: #5b21b6;
        }
        .status-rejected {
            background-color: #fee2e2;
            color: #9f1239;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 100;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.4);
        }
        .modal-content {
            background-color: #fff;
            margin: 10% auto;
            padding: 20px;
            border-radius: 8px;
            width: 50%;
            max-width: 600px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        .close:hover {
            color: black;
        }
        .multiselect {
            width: 100%;
        }
        .selectBox {
            position: relative;
        }
        .selectBox select {
            width: 100%;
            font-weight: bold;
        }
        .overSelect {
            position: absolute;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
        }
        #checkboxes {
            display: none;
            border: 1px #dadada solid;
            max-height: 150px;
            overflow-y: auto;
        }
        #checkboxes label {
            display: block;
            padding: 8px;
        }
        #checkboxes label:hover {
            background-color: #f1f1f1;
        }
    </style> -->
</head>

<body>
<div id="app">
    <div class="main-wrapper main-wrapper-1">
        <?php include('include-header.php'); ?>
        <!-- Main Content -->
        <div class="main-content">
            <section class="section">
                <div class="section-header">
                    <h1>Xem chi tiết chiến dịch</h1>
                    <div class="section-header-breadcrumb">
                        <!-- Action Buttons -->
                        <div class="flex justify-end space-x-4 mt-6">
                            <button class="btn btn-primary btn-rounded no-shadow" id="modal-edit-user"
                                    style="margin-right: 10px;">
                                <i class="fas fa-pen"></i>
                            </button>
                            <button class="btn btn-secondary btn-rounded no-shadow" id="modal-delete-user">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="section-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="detail-tab" data-toggle="tab" href="#detail" role="tab"
                               aria-controls="detail" aria-selected="true">
                                <i class="fas fa-info-circle mr-2"></i>Chi tiết chiến dịch</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="cus-tab" data-toggle="tab" href="#cus" role="tab"
                               aria-controls="cus" aria-selected="true">
                                <i class="fas fa-info-circle mr-2"></i>Theo dõi khách hàng</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="detail" role="tabpanel" aria-labelledby="detail-tab">
                            <div class="card">
                                <div id="campaign-detail-box" class="card-body">
                                    <h5 style="margin-bottom: 40px;">Thông tin chi tiết chiến dịch</h5>
                                    <div class="row"
                                         style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1px 30px; padding: 0 15px;">
                                        <div class="form-group">
                                            <label>Mã chiến dịch</label>
                                            <input type="text" class="form-control" id="Machiendich" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Tên chiến dịch</label>
                                            <input type="text" class="form-control" id="Tenchiendich" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Mục đích</label>
                                            <input type="text" class="form-control" id="Mucdich" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Trạng thái</label>
                                            <input type="text" class="form-control" id="Trangthai" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Ngày bắt đầu</label>
                                            <input type="text" class="form-control" id="Ngaybd" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Ngày kết thúc</label>
                                            <input type="text" class="form-control" id="Ngaykt" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Hình thức</label>
                                            <input type="text" class="form-control" id="Hinhthuc" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Kênh bán</label>
                                            <input type="text" class="form-control" id="Kenhban" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Loại sản phẩm</label>
                                            <input type="text" class="form-control" id="LoaiSP" readonly>
                                        </div>
                                    </div>
                                    <div class="row"
                                         style="display: grid; grid-template-columns: repeat(1, 1fr); gap: 1px 30px; padding: 0 15px;">
                                        <div class="form-group">
                                            <label>Mô tả chiến dịch</label>
                                            <input type="text" class="form-control" id="MoTa" readonly>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="tab-pane fade show" id="cus" role="tabpanel" aria-labelledby="cus-tab">
                            <div class="card">
                                <div class="card-body">
                                    <h5 style="margin-bottom: 40px;">Danh sách khách hàng mục tiêu</h5>
                                    <form id="search-form" method="GET" action="<?= base_url('auth/search_user') ?>">
                                        <div class="row"
                                             style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1px 30px; padding: 0 15px;">
                                            <!-- Mã khách hàng -->
                                            <div class="form-group">
                                                <label for="customer_code">Mã khách hàng</label>
                                                <input type="text" class="form-control" id="customer_code"
                                                       name="customer_code" placeholder="Nhập mã khách hàng"
                                                       value="<?= htmlspecialchars($customer_code) ?>">
                                            </div>
                                            <!-- Customer Type -->
                                            <div class="form-group">
                                                <label for="unit">Loại khách hàng</label>
                                                <select class="form-control" id="unit" name="unit">
                                                    <option value="">Tất cả</option>
                                                    <option value="unit1" <?= $unit == 'unit1' ? 'selected' : '' ?>>
                                                        Khách hàng hiện hữu
                                                    </option>
                                                    <option value="unit2" <?= $unit == 'unit2' ? 'selected' : '' ?>>
                                                        Khách hàng tiềm năng
                                                    </option>
                                                </select>
                                            </div>
                                            <!-- Ketqua tiep can -->
                                            <div class="form-group">
                                                <label for="unit">Kết quả tiếp cận</label>
                                                <select class="form-control" id="unit" name="unit">
                                                    <option value="">Tất cả</option>
                                                    <option value="unit1" <?= $unit == 'unit1' ? 'selected' : '' ?>>
                                                        Không liên lạc được
                                                    </option>
                                                    <option value="unit1" <?= $unit == 'unit1' ? 'selected' : '' ?>>Liên
                                                        hệ lại
                                                    </option>
                                                    <option value="unit1" <?= $unit == 'unit1' ? 'selected' : '' ?>>Đồng
                                                        ý hẹn gặp
                                                    </option>
                                                    <option value="unit1" <?= $unit == 'unit1' ? 'selected' : '' ?>>Đang
                                                        chăm sóc
                                                    </option>
                                                    <option value="unit1" <?= $unit == 'unit1' ? 'selected' : '' ?>>Đang
                                                        thu thập hồ sơ
                                                    </option>
                                                    <option value="unit1" <?= $unit == 'unit1' ? 'selected' : '' ?>>Chốt
                                                        bán
                                                    </option>
                                                    <option value="unit1" <?= $unit == 'unit1' ? 'selected' : '' ?>>Tạm
                                                        dừng
                                                    </option>
                                                    <option value="unit2" <?= $unit == 'unit2' ? 'selected' : '' ?>>Từ
                                                        chối
                                                    </option>
                                                </select>
                                            </div>
                                            <!-- Ketqua tiep can -->
                                            <div class="form-group">
                                                <label for="unit">Chi nhánh</label>
                                                <select class="form-control" id="unit" name="unit">
                                                    <option value="">Tất cả</option>
                                                    <option value="unit1" <?= $unit == 'unit1' ? 'selected' : '' ?>>Chi
                                                        nhánh miền Bắc
                                                    </option>
                                                    <option value="unit1" <?= $unit == 'unit1' ? 'selected' : '' ?>>Chi
                                                        nhánh miền Nam
                                                    </option>
                                                    \
                                                </select>
                                            </div>
                                            <!-- RM -->
                                            <div class="form-group">
                                                <label for="unit">RM</label>
                                                <select class="form-control" id="unit" name="unit">
                                                    <option value="">Tất cả</option>
                                                    <option value="unit1" <?= $unit == 'unit1' ? 'selected' : '' ?>>RM
                                                        1
                                                    </option>
                                                    <option value="unit1" <?= $unit == 'unit1' ? 'selected' : '' ?>>RM
                                                        2
                                                    </option>
                                                </select>
                                            </div>

                                        </div>
                                        <div class="flex justify-end space-x-4 mt-6">
                                            <button type="submit" class="btn btn-primary" style="margin-right: 10px;">
                                                Tìm kiếm
                                            </button>
                                            <button type="reset" class="btn btn-secondary">Xóa</button>
                                        </div>
                                    </form>

                                    <!-- Customer Table -->
                                    <div class="table-responsive mt-4">
                                        <table id="campaigns-table"
                                               data-toggle="table"
                                               data-url="<?= site_url('projects/customers_json/'.$maCD) ?>"
                                               data-side-pagination="server"
                                               data-pagination="true"
                                               data-page-list="[5, 10, 20, 50, 100, 200]"
                                               data-show-columns="true"
                                               data-show-refresh="true"
                                               data-sort-order="asc"
                                               data-show-export="true"
                                               data-maintain-selected="true"
                                               data-query-params="queryParams"
                                               data-response-handler="respHandler"
                                        >
                                            <thead>
                                            <tr>
                                                <th data-field="Matiepcan" data-visible="false">Matiepcan</th>
                                                <th data-field="CodeLoaiKH" data-visible="false">CodeLoaiKH</th>
                                                <th data-field="stt">STT</th>
                                                <th data-field="MaKH">Mã KH</th>
                                                <th data-field="TenKH">Tên khách hàng</th>
                                                <th data-field="SDT">Số điện thoại</th>
                                                <th data-field="Email" data-align="right">Email</th>
                                                <th data-field="LoaiKH">Loại KH</th>
                                                <th data-field="Tgiantiepcan">Thời gian tiếp cận</th>
                                                <th data-field="Ketquatiepcan">Kết quả tiếp cận</th>
                                                <th data-field="Ghichu">Ghi chú</th>
                                                <th data-field="RMtiepcan">RM quản lý</th>
                                                <th data-field="ChiNhanh">Chi nhánh quản lý</th>
                                                <th data-field="action" data-formatter="actionFmt" data-events="actionEvt">Action</th>
                                            </tr>
                                            </thead>
                                        </table>

                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <h5 style="margin-bottom: 40px;">Tổng hợp kết quả tiếp cận - CN</h5>
                                    <form id="search-form" method="GET" action="<?= base_url('auth/search_user') ?>">
                                        <div class="row"
                                             style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1px 30px; padding: 0 15px;">
                                            <!-- Chi nhánh-->
                                            <div class="form-group">
                                                <label for="unit">Chi nhánh</label>
                                                <select class="form-control" id="unit" name="unit">
                                                    <option value="">Tất cả</option>
                                                    <option value="unit1" <?= $unit == 'unit1' ? 'selected' : '' ?>>Chi
                                                        nhánh miền Bắc
                                                    </option>
                                                    <option value="unit1" <?= $unit == 'unit1' ? 'selected' : '' ?>>Chi
                                                        nhánh miền Nam
                                                    </option>
                                                    \
                                                </select>
                                            </div>
                                            <!-- Vùng-->
                                            <div class="form-group">
                                                <label for="unit">Chi nhánh</label>
                                                <select class="form-control" id="unit" name="unit">
                                                    <option value="">Tất cả</option>
                                                    <option value="unit1" <?= $unit == 'unit1' ? 'selected' : '' ?>>Miền
                                                        Bắc
                                                    </option>
                                                    <option value="unit1" <?= $unit == 'unit1' ? 'selected' : '' ?>>Miền
                                                        Nam
                                                    </option>
                                                    \
                                                </select>
                                            </div>
                                            <!-- Tỷ lệ tiếp cận -->
                                            <div class="form-group">
                                                <label for="customer_code">Tỷ lệ đã tiếp cận</label>
                                                <input type="text" class="form-control" id="customer_code"
                                                       name="customer_code" placeholder="Nhập tỷ lệ %">
                                            </div>
                                        </div>
                                        <div class="flex justify-end space-x-4 mt-6">
                                            <button type="submit" class="btn btn-primary" style="margin-right: 10px;">
                                                Tìm kiếm
                                            </button>
                                            <button type="reset" class="btn btn-secondary">Xóa</button>
                                        </div>
                                    </form>

                                    <!-- Customer Table -->
                                    <div class="table-responsive mt-4">
                                        <table class="table-striped" data-toggle="table" data-side-pagination="server"
                                               data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]"
                                               data-show-columns="true" data-show-refresh="true" data-sort-order="asc"
                                               data-toolbar="" data-show-export="true" data-maintain-selected="true"
                                               data-export-options='{
                                            "fileName": "campaigns-list",
                                            "ignoreColumn": ["state"] 
                                        }' data-query-params="queryParams">
                                            <thead>
                                            <tr>
                                                <th>STT</th>
                                                <th>Mã chi nhánh</th>
                                                <th>Tên chi nhánh</th>
                                                <th>Vùng</th>
                                                <th>SL KH chưa có code</th>
                                                <th>SL KH đã có code</th>
                                                <th>Tổng KH được PG</th>
                                                <th>SL KH chưa tiếp cận</th>
                                                <th>SL KH đã tiếp cận</th>
                                                <th>Tỷ lệ tiếp cận</th>
                                            </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                            <tr class="cursor-pointer hover:bg-blue-50"
                                                onclick="openBranchDetail('CN001')">
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">1</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-blue-600">
                                                    CN001
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Chi nhánh
                                                    Hà Nội
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Miền Bắc
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">25</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">15</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">40</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">12</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">28</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">70%</td>
                                            </tr>
                                            <tr class="cursor-pointer hover:bg-blue-50"
                                                onclick="openBranchDetail('CN002')">
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">2</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-blue-600">
                                                    CN002
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Chi nhánh
                                                    Hồ Chí Minh
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Miền Nam
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">35</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">25</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">60</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">18</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">42</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">70%</td>
                                            </tr>
                                            <tr class="cursor-pointer hover:bg-blue-50"
                                                onclick="openBranchDetail('CN003')">
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">3</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-blue-600">
                                                    CN003
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Chi nhánh
                                                    Đà Nẵng
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Miền
                                                    Trung
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">15</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">10</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">25</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">8</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">17</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">68%</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <h5 style="margin-bottom: 40px;">Tổng hợp kết quả tiếp cận - RM</h5>
                                    <form id="search-form" method="GET" action="<?= base_url('auth/search_user') ?>">
                                        <div class="row"
                                             style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1px 30px; padding: 0 15px;">
                                            <!-- Chi nhánh-->
                                            <div class="form-group">
                                                <label for="unit">Chi nhánh</label>
                                                <select class="form-control" id="unit" name="unit">
                                                    <option value="">Tất cả</option>
                                                    <option value="unit1" <?= $unit == 'unit1' ? 'selected' : '' ?>>Chi
                                                        nhánh miền Bắc
                                                    </option>
                                                    <option value="unit1" <?= $unit == 'unit1' ? 'selected' : '' ?>>Chi
                                                        nhánh miền Nam
                                                    </option>
                                                    \
                                                </select>
                                            </div>
                                            <!-- Vùng-->
                                            <div class="form-group">
                                                <label for="unit">RM</label>
                                                <select class="form-control" id="unit" name="unit">
                                                    <option value="">Tất cả</option>
                                                    <option value="unit1" <?= $unit == 'unit1' ? 'selected' : '' ?>>Miền
                                                        Bắc
                                                    </option>
                                                    <option value="unit1" <?= $unit == 'unit1' ? 'selected' : '' ?>>Miền
                                                        Nam
                                                    </option>
                                                    \
                                                </select>
                                            </div>
                                            <!-- Tỷ lệ tiếp cận -->
                                            <div class="form-group">
                                                <label for="customer_code">Tỷ lệ đã tiếp cận</label>
                                                <input type="text" class="form-control" id="customer_code"
                                                       name="customer_code" placeholder="Nhập tỷ lệ %">
                                            </div>
                                        </div>
                                        <div class="flex justify-end space-x-4 mt-6">
                                            <button type="submit" class="btn btn-primary" style="margin-right: 10px;">
                                                Tìm kiếm
                                            </button>
                                            <button type="reset" class="btn btn-secondary">Xóa</button>
                                        </div>
                                    </form>

                                    <!-- Customer Table -->
                                    <div class="table-responsive mt-4">
                                        <table class="table-striped" data-toggle="table" data-side-pagination="server"
                                               data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]"
                                               data-show-columns="true" data-show-refresh="true" data-sort-order="asc"
                                               data-toolbar="" data-show-export="true" data-maintain-selected="true"
                                               data-export-options='{
                                            "fileName": "campaigns-list",
                                            "ignoreColumn": ["state"] 
                                        }' data-query-params="queryParams">
                                            <thead>
                                            <tr>
                                                <th>STT</th>
                                                <th>Mã RM</th>
                                                <th>Tên RM</th>
                                                <th>SL KH chưa có code</th>
                                                <th>SL KH đã có code</th>
                                                <th>Tổng KH được PG</th>
                                                <th>SL KH chưa tiếp cận</th>
                                                <th>SL KH đã tiếp cận</th>
                                                <th>Tỷ lệ tiếp cận</th>
                                            </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">1</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-blue-600">
                                                    RM001
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Nguyễn Văn
                                                    A
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">10</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">8</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">18</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">5</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">13</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">72%</td>
                                            </tr>
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">2</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-blue-600">
                                                    RM002
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Trần Thị
                                                    B
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">15</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">10</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">25</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">8</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">17</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">68%</td>
                                            </tr>
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">3</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-blue-600">
                                                    RM003
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Lê Văn C
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">8</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">5</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">13</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">4</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">9</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">69%</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Update Contact Result Modal -->
                    <div id="updateModal" class="modal" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5>Cập nhật kết quả tiếp cận</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Khách hàng</label>
                                    <div class="w-full bg-gray-100 border border-gray-300 rounded-md px-4 py-2"
                                         id="modalCustomerName">
                                        KH001 - Nguyễn Văn A
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Kết quả tiếp cận</label>
                                    <select id="contactResult"
                                            class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-blue-500 focus:border-blue-500"
                                            onchange="showReasons(this.value)">
                                        <option value="">Chọn kết quả tiếp cận</option>
                                        <option value="no_contact">Không liên lạc được</option>
                                        <option value="contact_again">Liên hệ lại</option>
                                        <option value="agree_meeting">Đồng ý hẹn gặp</option>
                                        <option value="in_care">Đang chăm sóc</option>
                                        <option value="collecting_docs">Đang thu thập hồ sơ</option>
                                        <option value="closed">Chốt bán</option>
                                        <option value="paused">Tạm dừng</option>
                                        <option value="rejected">Từ chối</option>
                                    </select>
                                </div>

                                <div id="pauseReasons" class="mb-4 hidden">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Lý do tạm dừng</label>
                                    <select id="pauseReason"
                                            class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">Chọn lý do</option>
                                        <option value="no_need">Không có nhu cầu</option>
                                        <option value="other_bank">Quan hệ TCTD khác</option>
                                        <option value="price_issue">LS/Phí chưa cạnh tranh</option>
                                        <option value="bad_impression">Không thiện cảm với</option>
                                    </select>
                                </div>

                                <div id="rejectReasons" class="mb-4 hidden">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Lý do từ chối</label>
                                    <select id="rejectReason"
                                            class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">Chọn lý do</option>
                                        <option value="bad_debt">Nợ quá hạn/nợ xấu</option>
                                        <option value="stopped">Đã ngừng hoạt động</option>
                                        <option value="warning">Thuộc đối tượng cảnh báo của Nhà nước</option>
                                        <option value="no_support">Đối tượng không tài trợ theo CĐTD</option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Ghi chú</label>
                                    <textarea id="contactNote"
                                              class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-blue-500 focus:border-blue-500 h-24"
                                              placeholder="Nhập ghi chú (tối đa 200 ký tự)"></textarea>
                                </div>

                                <div class="flex justify-end space-x-4">
                                    <button class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-md"
                                            onclick="closeModal('updateModal')">
                                        Hủy
                                    </button>
                                    <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md"
                                            onclick="saveContactResult()">
                                        Lưu
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Branch Detail Modal -->
                    <div id="branchDetailModal" class="modal">
                        <div class="modal-content">
                            <span class="close" onclick="closeModal('branchDetailModal')">&times;</span>
                            <h2 class="text-xl font-bold text-blue-800 mb-4">Chi tiết chi nhánh <span id="branchName">Chi nhánh Hà Nội</span>
                            </h2>

                            <div class="table-container">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            STT
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Mã RM
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Tên RM
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            SL KH chưa có code
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            SL KH đã có code
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Tổng KH được PG
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            SL KH chưa tiếp cận
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            SL KH đã tiếp cận
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Tỷ lệ tiếp cận
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200" id="branchDetailBody">
                                    <!-- Data will be populated by JavaScript -->
                                    </tbody>
                                </table>
                            </div>

                            <div class="flex justify-end mt-4">
                                <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md"
                                        onclick="closeModal('branchDetailModal')">
                                    Đóng
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<!-- Modal cập nhật kết quả -->
<div class="modal fade" id="updateResultModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="updateResultForm" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cập nhật kết quả tiếp cận</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <input type="hidden" name="id" id="record-id">
                <input type="hidden" name="type" id="record-type">

                <div class="form-group">
                    <label>Khách hàng</label>
                    <input type="text" class="form-control" id="record-name" readonly>
                </div>

                <div class="form-group">
                    <label>Kết quả tiếp cận</label>
                    <select class="form-control select2" name="ketqua" id="record-result" required>
                        <option value="" selected>Chọn kết quả tiếp cận</option>
                        <option value="Không liên lạc được">Không liên lạc được</option>
                        <option value="Liên hệ lại">Liên hệ lại</option>
                        <option value="Đồng ý hẹn gặp">Đồng ý hẹn gặp</option>
                        <option value="Đang chăm sóc">Đang chăm sóc</option>
                        <option value="Đang thu thập hồ sơ">Đang thu thập hồ sơ</option>
                        <option value="Chốt bán">Chốt bán</option>
                        <option value="Tạm dừng">Tạm dừng</option>
                        <option value="Từ chối">Từ chối</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Ghi chú</label>
                    <textarea class="form-control" name="ghichu" id="record-note" rows="3"></textarea>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Huỷ</button>
            </div>
        </form>
    </div>
</div>
</body>

<script>
    // Tab functionality
    document.querySelectorAll('[data-tab]').forEach(tab => {
        tab.addEventListener('click', function () {
            // Remove active class from all tabs and contents
            document.querySelectorAll('.tab-button').forEach(t => t.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));

            // Add active class to clicked tab and corresponding content
            this.classList.add('active');
            const tabId = this.getAttribute('data-tab');
            document.getElementById(tabId).classList.add('active');
        });
    });

    // Dropdown functionality
    document.querySelectorAll('.dropdown').forEach(dropdown => {
        const button = dropdown.querySelector('button');
        const content = dropdown.querySelector('.dropdown-content');

        button.addEventListener('click', function () {
            content.style.display = content.style.display === 'block' ? 'none' : 'block';
        });

        dropdown.querySelectorAll('.dropdown-item').forEach(item => {
            item.addEventListener('click', function () {
                button.querySelector('span').textContent = this.textContent;
                content.style.display = 'none';
            });
        });
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function (event) {
        if (!event.target.closest('.dropdown')) {
            document.querySelectorAll('.dropdown-content').forEach(content => {
                content.style.display = 'none';
            });
        }
    });

    // Back button functionality
    document.querySelector('.bg-gray-500').addEventListener('click', function () {
        alert('Quay lại danh sách chiến dịch');
        // In a real app, this would redirect to the campaign list page
    });

    // Edit button functionality
    document.querySelector('.bg-blue-600').addEventListener('click', function () {
        alert('Chuyển đến màn hình chỉnh sửa chiến dịch');
        // In a real app, this would redirect to the edit campaign page
    });

    // Search button functionality
    document.querySelectorAll('.bg-blue-600.text-white').forEach(button => {
        if (button.textContent.includes('Tìm kiếm')) {
            button.addEventListener('click', function () {
                alert('Thực hiện tìm kiếm với các tiêu chí đã chọn');
                // In a real app, this would filter the tables
            });
        }
    });

    // Modal functions
    function openUpdateModal(customerCode, customerName) {
        document.getElementById('modalCustomerName').textContent = `${customerCode} - ${customerName}`;
        document.getElementById('updateModal').style.display = 'block';
    }

    function openBranchDetail(branchCode) {
        const branchName = branchCode === 'CN001' ? 'Chi nhánh Hà Nội' :
            branchCode === 'CN002' ? 'Chi nhánh Hồ Chí Minh' :
                'Chi nhánh Đà Nẵng';

        document.getElementById('branchName').textContent = branchName;

        // Populate branch detail table
        const branchDetailBody = document.getElementById('branchDetailBody');
        branchDetailBody.innerHTML = '';

        // Sample data - in a real app, this would come from an API
        const rmData = [
            {
                code: 'RM001',
                name: 'Nguyễn Văn A',
                noCode: 10,
                hasCode: 8,
                total: 18,
                notContacted: 5,
                contacted: 13,
                rate: '72%'
            },
            {
                code: 'RM002',
                name: 'Trần Thị B',
                noCode: 8,
                hasCode: 5,
                total: 13,
                notContacted: 4,
                contacted: 9,
                rate: '69%'
            },
            {
                code: 'RM003',
                name: 'Lê Văn C',
                noCode: 7,
                hasCode: 6,
                total: 13,
                notContacted: 5,
                contacted: 8,
                rate: '62%'
            }
        ];

        rmData.forEach((rm, index) => {
            const row = document.createElement('tr');
            row.className = 'hover:bg-blue-50';
            row.innerHTML = `
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${index + 1}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-blue-600">${rm.code}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${rm.name}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${rm.noCode}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${rm.hasCode}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${rm.total}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${rm.notContacted}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${rm.contacted}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${rm.rate}</td>
                                            `;
            branchDetailBody.appendChild(row);
        });

        document.getElementById('branchDetailModal').style.display = 'block';
    }

    function closeModal(modalId) {
        document.getElementById(modalId).style.display = 'none';
    }

    function showReasons(result) {
        document.getElementById('pauseReasons').classList.add('hidden');
        document.getElementById('rejectReasons').classList.add('hidden');

        if (result === 'paused') {
            document.getElementById('pauseReasons').classList.remove('hidden');
        } else if (result === 'rejected') {
            document.getElementById('rejectReasons').classList.remove('hidden');
        }
    }

    function saveContactResult() {
        const result = document.getElementById('contactResult').value;
        const note = document.getElementById('contactNote').value;

        if (!result) {
            alert('Vui lòng chọn kết quả tiếp cận');
            return;
        }

        if (note.length > 200) {
            alert('Ghi chú không được vượt quá 200 ký tự');
            return;
        }

        // In a real app, this would save to the database
        alert('Đã lưu kết quả tiếp cận thành công');
        closeModal('updateModal');
    }

    // Close modals when clicking outside
    window.onclick = function (event) {
        if (event.target.className === 'modal') {
            event.target.style.display = 'none';
        }
    }
</script>
</div>
</div>

<?php include('include-js.php'); ?>
<!-- Page Specific JS File -->
<script src="<?= base_url('assets/js/page/components-user.js'); ?>"></script>
<script src="<?= base_url('assets/js/page/project-details.js'); ?>"></script>
<script>
    // Hàm mở modal và điền dữ liệu khách hàng vào modal
    function openUpdateModal(customerId, customerName) {
        // Điền thông tin vào các phần tử trong modal
        document.getElementById("modalCustomerName").innerText = customerId + " - " + customerName;

        // Mở modal
        document.getElementById("updateModal").style.display = "block";
    }

    // Hàm đóng modal
    function closeModal(modalId) {
        document.getElementById(modalId).style.display = "none";
    }

    // Hàm xử lý lưu kết quả tiếp cận
    function saveContactResult() {
        var contactResult = document.getElementById("contactResult").value;
        var contactNote = document.getElementById("contactNote").value;

        // Thực hiện lưu dữ liệu tại đây, ví dụ gửi dữ liệu qua AJAX tới server
        console.log("Kết quả tiếp cận: " + contactResult);
        console.log("Ghi chú: " + contactNote);

        // Đóng modal sau khi lưu
        closeModal('updateModal');
    }

    // Hàm hiển thị lý do (được gọi khi chọn kết quả tiếp cận)
    function showReasons(value) {
        // Ẩn tất cả các lý do
        document.getElementById("pauseReasons").classList.add("hidden");
        document.getElementById("rejectReasons").classList.add("hidden");

        // Hiển thị lý do tương ứng với kết quả tiếp cận
        if (value === 'paused') {
            document.getElementById("pauseReasons").classList.remove("hidden");
        } else if (value === 'rejected') {
            document.getElementById("rejectReasons").classList.remove("hidden");
        }
    }
</script>

<script>
    let currentCampaign = null;

    function respHandler(res) {
        // Lưu lại campaign
        currentCampaign = res.campaign || {};

        // Sau khi dữ liệu bảng được xử lý, cập nhật UI
        updateCampaignDetail(currentCampaign);

        return {
            total: res.customers?.length || 0,
            rows : res.customers || []
        };
    }

    function updateCampaignDetail(data) {
        console.log("%c 1 --> Line: 1050||project-detail.php\n data: ","color:#f0f;", data);
        if (!data || Object.keys(data).length === 0) {
            $('#campaign-detail-box').hide();
            return;
        }

        $('#campaign-detail-box').show(); // ensure hiển thị lại nếu có dữ liệu

        $('#Machiendich').val(data.Machiendich || '');
        $('#Tenchiendich').val(data.Tenchiendich || '');
        $('#Mucdich').val(data.Mucdich || '');
        $('#Trangthai').val(data.Trangthai || '');
        $('#Ngaybd').val(data.Ngaybd || '');
        $('#Ngaykt').val(data.Ngaykt || '');
        $('#Hinhthuc').val(data.Hinhthuc || '');
        $('#Kenhban').val(data.Kenhban || '');
        $('#LoaiSP').val(data.LoaiSP || '');
        $('#MoTa').val(data.ND || '');
    }

    /* formatter tạo nút, nhét record JSON vào data-record */
    function actionFmt(value, row) {
        return '<button class="btn btn-primary btn-update-result">Cập nhật kết quả</button>';
    }
    /* delegated event – bootstrap‑table gọi sự kiện vào đây */
    window.actionEvt = {
        'click .btn-update-result': function (e, value, record) {   // record có sẵn!
            $('#record-id').val(record.Matiepcan);
            $('#record-type').val(record.CodeLoaiKH);
            $('#record-name').val(record.TenKH);
            $('#record-result').val(record.Ketquatiepcan || '').trigger('change');
            $('#record-note').val(record.Ghichu || '');
            $('#updateResultModal').modal('show');
        }
    };

    /* Sau khi UPDATE thành công: */
    $('#campaigns-table').bootstrapTable('refresh');   // tải lại JSON → bảng mới nhất

    $(function () {

        // /* Mở modal */
        // $(document).on('click', '.btn-update-result', function () {
        //     // 1) Lấy chỉ số dòng (Bootstrap‑Table tự thêm data-index cho <tr>)
        //     const index  = $(this).closest('tr').data('index');
        //
        //     // 2) Lấy đúng object theo index
        //     const record = $('#campaigns-table').bootstrapTable('getData')[index];
        //
        //     // 3) Sử dụng như cũ
        //     $('#record-id').val(record.Matiepcan);
        //     $('#record-type').val(record.CodeLoaiKH);
        //     $('#record-name').val(record.TenKH);
        //
        //     $('#record-result').val(record.Ketquatiepcan || '')
        //         .trigger('change');             // nếu dùng Select2
        //     $('#record-note').val(record.Ghichu || '');
        //
        //     $('#updateResultModal').modal('show');
        // });

        /* Submit */
        $('#updateResultForm').on('submit', function (e) {
            e.preventDefault();
            if (!$('#record-result').val()) {
                iziToast.error({message: 'Vui lòng chọn kết quả tiếp cận'});
                return;
            }

            const $form = $(this);
            const formData = $form.serializeArray();          // [{name:'id', value:'..'}, ...]
            formData.push({                                   // thêm CSRF *nếu* bạn muốn thủ công
                name : csrfName,      // biến toàn cục bạn set ở layout
                value: csrfHash
            });

            $.ajax({
                url : '<?= site_url('projects/update_contact_result'); ?>',
                type: 'POST',
                data: $.param(formData),                      // chuyển về chuỗi query
                dataType: 'json',

                beforeSend: () => $(this).find('[type=submit]').prop('disabled', true),

                success: res => {
                    if (res.csrfName && res.csrfHash) {
                        csrfName = res.csrfName;
                        csrfHash = res.csrfHash;
                    }

                    if (!res.error) {
                        iziToast.success({message: res.message});
                        $('#updateResultModal').modal('hide');
                        $('#campaigns-table').bootstrapTable('refresh');
                    } else {
                        iziToast.error({message: res.message});
                    }
                },

                error: () => iziToast.error({message: 'Lỗi máy chủ.'}),

                complete: () => $(this).find('[type=submit]').prop('disabled', false)
            });
        });

    });

</script>

</html>