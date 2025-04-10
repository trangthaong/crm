<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Quản lý chiến dịch</title>
    <?php include('include-css.php'); ?>
    <script src="https://cdn.tailwindcss.com"></script>
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
                        <h1>Xem chi tiết chiến dịch</h1>
                        <div class="section-header-breadcrumb">
                            <!-- Action Buttons -->
                            <div class="flex justify-end space-x-4 mt-6">
                            <button class="btn btn-primary btn-rounded no-shadow" id="modal-edit-user" style="margin-right: 10px;">
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
                                <a class="nav-link active" id="detail-tab" data-toggle="tab" href="#detail" role="tab" aria-controls="detail" aria-selected="true">
                                <i class="fas fa-info-circle mr-2"></i>Chi tiết chiến dịch</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="cus-tab" data-toggle="tab" href="#cus" role="tab" aria-controls="cus" aria-selected="true">
                                <i class="fas fa-info-circle mr-2"></i>Theo dõi khách hàng</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="detail" role="tabpanel" aria-labelledby="detail-tab">
                            <div class="card">
                                <div class="card-body">
                                    <h5 style= "margin-bottom: 40px;">Thông tin chi tiết chiến dịch</h5>
                                    <div class="row">
                                    <div class="col-md-4">
                                        <!-- Campaign Code -->
                                        <div class="form-group">
                                            <label >Mã chiến dịch</label>
                                            <div class="w-full bg-gray-100 border border-gray-300 rounded-md px-4 py-2">CD001</div>
                                        </div>
                                        <!-- Status -->
                                        <div class="form-group">
                                            <label>Trạng thái</label>
                                            <div class="w-full bg-gray-100 border border-gray-300 rounded-md px-4 py-2">Đang hoạt động</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <!-- Campaign Name -->
                                        <div class="form-group">
                                            <label>Tên chiến dịch</label>
                                            <div class="w-full bg-gray-100 border border-gray-300 rounded-md px-4 py-2">
                                                Chương trình khuyến mại tháng 8
                                            </div>
                                        </div>
                                        <!-- Start Date -->
                                        <div class="form-group">
                                            <label>Ngày bắt đầu</label>
                                            <div class="w-full bg-gray-100 border border-gray-300 rounded-md px-4 py-2">
                                                12/08/2022
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <!-- Purpose -->
                                        <div class="form-group">
                                            <label>Mục đích</label>
                                            <div class="w-full bg-gray-100 border border-gray-300 rounded-md px-4 py-2">
                                                Xúc tiến kinh doanh
                                            </div>
                                        </div>
                                        <!-- End Date -->
                                        <div class="form-group">
                                            <label>Ngày kết thúc</label>
                                            <div class="w-full bg-gray-100 border border-gray-300 rounded-md px-4 py-2">
                                                12/09/2022
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <!-- Description -->
                                        <div class="md:col-span-2 lg:col-span-3">
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Mô tả chiến dịch</label>
                                            <div class="w-full bg-gray-100 border border-gray-300 rounded-md px-4 py-2 h-24" style = "margin-bottom: 20px;">
                                                Chiến dịch khuyến mại dành cho khách hàng mới với nhiều ưu đãi hấp dẫn. Áp dụng từ ngày 12/08 đến 12/09/2022.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <h5 style= "margin-bottom: 40px;">Danh sách khách hàng mục tiêu</h5>
                                    <form id="search-form" method="GET" action="<?= base_url('auth/search_user') ?>">
                                        <div class="row" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1px 30px; padding: 0 15px;">
                                            <!-- Mã khách hàng -->
                                            <div class="form-group">
                                                <label for="customer_code">Mã khách hàng</label>
                                                <input type="text" class="form-control" id="customer_code" name="customer_code" placeholder="Nhập mã khách hàng">
                                            </div>
                                            <!-- Customer Type -->
                                            <div class="form-group">
                                                <label for="unit">Loại khách hàng</label>
                                                <select class="form-control" id="unit" name="unit">
                                                    <option value="">Tất cả</option>
                                                    <option value="unit1">Khách hàng hiện hữu</option>
                                                    <option value="unit2">Khách hàng tiềm năng</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="flex justify-end space-x-4 mt-6">
                                            <button type="submit" class="btn btn-primary" style="margin-right: 10px;">Tìm kiếm</button>
                                            <button type="reset" class="btn btn-secondary">Xóa</button>
                                        </div>
                                    </form>
                                    <!-- Customer Table -->
                                    <div class="table-responsive mt-4">
                                        <table class='table-striped' data-toggle="table" data-side-pagination="server" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-show-columns="true" data-show-refresh="true" data-sort-order="asc" data-toolbar="" data-show-export="true" data-maintain-selected="true" data-export-options='{
                                        "fileName": "clients-list",
                                                "ignoreColumn": ["state"] 
                                            }' 
                                            data-query-params="queryParams">            
                                            <thead>
                                                <tr>
                                                    <th>STT</th>
                                                    <th>Mã KH</th>
                                                    <th>Tên khách hàng</th>
                                                    <th>Số điện thoại</th>
                                                    <th>Email</th>
                                                    <th>Loại KH</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td >KH001</td>
                                                    <td >Nguyễn Văn A</td>
                                                    <td>0912345678</td>
                                                    <td>nguyenvana@example.com</td>
                                                    <td>Mục tiêu</td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td >KH002</td>
                                                    <td >Trần Thị B</td>
                                                    <td>0987654321</td>
                                                    <td>tranthib@example.com</td>
                                                    <td>Mục tiêu</td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td >KH003</td>
                                                    <td >Lê Văn C</td>
                                                    <td>0901234567</td>
                                                    <td>levanc@example.com</td>
                                                    <td>Không mục tiêu</td>
                                                </tr>
                                                <tr>
                                                    <td>4</td>
                                                    <td >KH004</td>
                                                    <td >Phạm Thị D</td>
                                                    <td>0978123456</td>
                                                    <td>phamthid@example.com</td>
                                                    <td>Mục tiêu</td>
                                                </tr>
                                                <tr>
                                                    <td>5</td>
                                                    <td >KH005</td>
                                                    <td >Hoàng Văn E</td>
                                                    <td>0965432198</td>
                                                    <td>hoangvane@example.com</td>
                                                    <td>Không mục tiêu</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            </div>
                            </div>

                            <div class="tab-pane fade show active" id="cus" role="tabpanel" aria-labelledby="cus-tab">
                            <div class="card">
                                <div class="card-body">
                                <h2 class="text-lg font-medium text-blue-700 mb-4">Danh sách khách hàng mục tiêu</h2>
                    
                    

            <!-- Customer Tracking Tab -->
            <div id="customer-tracking" class="tab-content">
                <!-- Customer Tracking Section -->
                <div class="bg-blue-50 p-4 rounded-lg mb-6">
                    <h2 class="text-lg font-medium text-blue-700 mb-4">Theo dõi khách hàng</h2>
                    
                    <!-- Search Filters -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                        <!-- Customer Type -->
                        <div class="dropdown relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Loại KH</label>
                            <button type="button" class="w-full bg-white border border-gray-300 rounded-md px-4 py-2 text-left flex justify-between items-center">
                                <span>Tất cả</span>
                                <i class="fas fa-chevron-down text-gray-500"></i>
                            </button>
                            <div class="dropdown-content rounded-md mt-1">
                                <div class="dropdown-item px-4 py-2 cursor-pointer hover:bg-blue-100">Tất cả</div>
                                <div class="dropdown-item px-4 py-2 cursor-pointer hover:bg-blue-100">KH chưa có code</div>
                                <div class="dropdown-item px-4 py-2 cursor-pointer hover:bg-blue-100">KH đã có code</div>
                            </div>
                        </div>
                        
                        <!-- ID/Passport -->
                        <div>
                            <label for="customerId" class="block text-sm font-medium text-gray-700 mb-1">CMT/Hộ chiếu</label>
                            <input type="text" id="customerId" class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Nhập số CMT/Hộ chiếu">
                        </div>
                        
                        <!-- Customer Code -->
                        <div>
                            <label for="customerCode" class="block text-sm font-medium text-gray-700 mb-1">Code KH</label>
                            <input type="text" id="customerCode" class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Nhập mã KH">
                        </div>
                        
                        <!-- Contact Result -->
                        <div class="dropdown relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kết quả tiếp cận</label>
                            <button type="button" class="w-full bg-white border border-gray-300 rounded-md px-4 py-2 text-left flex justify-between items-center">
                                <span>Tất cả</span>
                                <i class="fas fa-chevron-down text-gray-500"></i>
                            </button>
                            <div class="dropdown-content rounded-md mt-1">
                                <div class="dropdown-item px-4 py-2 cursor-pointer hover:bg-blue-100">Tất cả</div>
                                <div class="dropdown-item px-4 py-2 cursor-pointer hover:bg-blue-100">Không liên lạc được</div>
                                <div class="dropdown-item px-4 py-2 cursor-pointer hover:bg-blue-100">Liên hệ lại</div>
                                <div class="dropdown-item px-4 py-2 cursor-pointer hover:bg-blue-100">Đồng ý hẹn gặp</div>
                                <div class="dropdown-item px-4 py-2 cursor-pointer hover:bg-blue-100">Đang chăm sóc</div>
                                <div class="dropdown-item px-4 py-2 cursor-pointer hover:bg-blue-100">Đang thu thập hồ sơ</div>
                                <div class="dropdown-item px-4 py-2 cursor-pointer hover:bg-blue-100">Chốt bán</div>
                                <div class="dropdown-item px-4 py-2 cursor-pointer hover:bg-blue-100">Tạm dừng</div>
                                <div class="dropdown-item px-4 py-2 cursor-pointer hover:bg-blue-100">Từ chối</div>
                            </div>
                        </div>
                        
                        <!-- Branch -->
                        <div class="dropdown relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Chi nhánh</label>
                            <button type="button" class="w-full bg-white border border-gray-300 rounded-md px-4 py-2 text-left flex justify-between items-center">
                                <span>Tất cả</span>
                                <i class="fas fa-chevron-down text-gray-500"></i>
                            </button>
                            <div class="dropdown-content rounded-md mt-1">
                                <div class="dropdown-item px-4 py-2 cursor-pointer hover:bg-blue-100">Tất cả</div>
                                <div class="dropdown-item px-4 py-2 cursor-pointer hover:bg-blue-100">Chi nhánh Hà Nội</div>
                                <div class="dropdown-item px-4 py-2 cursor-pointer hover:bg-blue-100">Chi nhánh Hồ Chí Minh</div>
                                <div class="dropdown-item px-4 py-2 cursor-pointer hover:bg-blue-100">Chi nhánh Đà Nẵng</div>
                                <div class="dropdown-item px-4 py-2 cursor-pointer hover:bg-blue-100">Chi nhánh Cần Thơ</div>
                            </div>
                        </div>
                        
                        <!-- RM -->
                        <div class="dropdown relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1">RM</label>
                            <button type="button" class="w-full bg-white border border-gray-300 rounded-md px-4 py-2 text-left flex justify-between items-center">
                                <span>Tất cả</span>
                                <i class="fas fa-chevron-down text-gray-500"></i>
                            </button>
                            <div class="dropdown-content rounded-md mt-1">
                                <div class="dropdown-item px-4 py-2 cursor-pointer hover:bg-blue-100">Tất cả</div>
                                <div class="dropdown-item px-4 py-2 cursor-pointer hover:bg-blue-100">RM001 - Nguyễn Văn A</div>
                                <div class="dropdown-item px-4 py-2 cursor-pointer hover:bg-blue-100">RM002 - Trần Thị B</div>
                                <div class="dropdown-item px-4 py-2 cursor-pointer hover:bg-blue-100">RM003 - Lê Văn C</div>
                            </div>
                        </div>
                        
                        <!-- Search Button -->
                        <div class="flex items-end">
                            <button class="btn btn-primary btn-rounded no-shadow">
                                <i class="fas fa-search mr-2"></i> Tìm kiếm
                            </button>
                        </div>
                    </div>
                    
                    <!-- Customer Table -->
                    <div class="table-container">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">STT</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CMT/Hộ chiếu</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mã KH</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tên khách hàng</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Thời gian tiếp cận</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kết quả tiếp cận</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ghi chú</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">RM quản lý</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Chi nhánh quản lý</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hành động</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">1</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">123456789</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-blue-600">KH001</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Nguyễn Văn A</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">15/08/2022 10:30</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="status-pending px-2 py-1 rounded-full text-xs font-medium">Đang chăm sóc</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Khách hàng quan tâm đến sản phẩm A</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">RM001 - Nguyễn Văn A</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Chi nhánh Hà Nội</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button class="text-blue-600 hover:text-blue-900 mr-3" onclick="openUpdateModal('KH001', 'Nguyễn Văn A')">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">2</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">987654321</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-blue-600">KH002</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Trần Thị B</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">14/08/2022 14:15</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="status-success px-2 py-1 rounded-full text-xs font-medium">Chốt bán</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Đã mua sản phẩm B</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">RM002 - Trần Thị B</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Chi nhánh Hồ Chí Minh</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button class="text-blue-600 hover:text-blue-900 mr-3" onclick="openUpdateModal('KH002', 'Trần Thị B')">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">3</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">456789123</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-blue-600">KH003</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Lê Văn C</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">16/08/2022 09:45</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="status-waiting px-2 py-1 rounded-full text-xs font-medium">Liên hệ lại</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Khách hàng bận, hẹn gọi lại</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">RM003 - Lê Văn C</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Chi nhánh Đà Nẵng</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button class="text-blue-600 hover:text-blue-900 mr-3" onclick="openUpdateModal('KH003', 'Lê Văn C')">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">4</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">789123456</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-blue-600">KH004</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Phạm Thị D</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">13/08/2022 16:20</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="status-rejected px-2 py-1 rounded-full text-xs font-medium">Từ chối</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Không có nhu cầu</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">RM001 - Nguyễn Văn A</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Chi nhánh Hà Nội</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button class="text-blue-600 hover:text-blue-900 mr-3" onclick="openUpdateModal('KH004', 'Phạm Thị D')">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">5</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">321654987</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-blue-600">KH005</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Hoàng Văn E</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">17/08/2022 11:10</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="status-success px-2 py-1 rounded-full text-xs font-medium">Đang thu thập hồ sơ</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Đang chờ hồ sơ từ khách hàng</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">RM002 - Trần Thị B</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Chi nhánh Hồ Chí Minh</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button class="text-blue-600 hover:text-blue-900 mr-3" onclick="openUpdateModal('KH005', 'Hoàng Văn E')">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="flex items-center justify-between mt-4">
                        <div class="text-sm text-gray-500">
                            Hiển thị <span class="font-medium">1</span> đến <span class="font-medium">5</span> của <span class="font-medium">12</span> kết quả
                        </div>
                        <div class="flex space-x-2">
                            <button class="px-3 py-1 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                                Trước
                            </button>
                            <button class="px-3 py-1 border border-blue-500 rounded-md text-sm font-medium text-white bg-blue-600">
                                1
                            </button>
                            <button class="px-3 py-1 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                                2
                            </button>
                            <button class="px-3 py-1 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                                3
                            </button>
                            <button class="px-3 py-1 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                                Sau
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Contact Results Summary Section -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h2 class="text-lg font-medium text-blue-700 mb-4">Tổng hợp kết quả tiếp cận</h2>
                    
                    <!-- Search Filters -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <!-- Branch -->
                        <div class="dropdown relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Chi nhánh</label>
                            <button type="button" class="w-full bg-white border border-gray-300 rounded-md px-4 py-2 text-left flex justify-between items-center">
                                <span>Tất cả</span>
                                <i class="fas fa-chevron-down text-gray-500"></i>
                            </button>
                            <div class="dropdown-content rounded-md mt-1">
                                <div class="dropdown-item px-4 py-2 cursor-pointer hover:bg-blue-100">Tất cả</div>
                                <div class="dropdown-item px-4 py-2 cursor-pointer hover:bg-blue-100">Chi nhánh Hà Nội</div>
                                <div class="dropdown-item px-4 py-2 cursor-pointer hover:bg-blue-100">Chi nhánh Hồ Chí Minh</div>
                                <div class="dropdown-item px-4 py-2 cursor-pointer hover:bg-blue-100">Chi nhánh Đà Nẵng</div>
                                <div class="dropdown-item px-4 py-2 cursor-pointer hover:bg-blue-100">Chi nhánh Cần Thơ</div>
                            </div>
                        </div>
                        
                        <!-- Region -->
                        <div class="dropdown relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Vùng</label>
                            <button type="button" class="w-full bg-white border border-gray-300 rounded-md px-4 py-2 text-left flex justify-between items-center">
                                <span>Tất cả</span>
                                <i class="fas fa-chevron-down text-gray-500"></i>
                            </button>
                            <div class="dropdown-content rounded-md mt-1">
                                <div class="dropdown-item px-4 py-2 cursor-pointer hover:bg-blue-100">Tất cả</div>
                                <div class="dropdown-item px-4 py-2 cursor-pointer hover:bg-blue-100">Miền Bắc</div>
                                <div class="dropdown-item px-4 py-2 cursor-pointer hover:bg-blue-100">Miền Trung</div>
                                <div class="dropdown-item px-4 py-2 cursor-pointer hover:bg-blue-100">Miền Nam</div>
                            </div>
                        </div>
                        
                        <!-- Contact Rate -->
                        <div>
                            <label for="contactRate" class="block text-sm font-medium text-gray-700 mb-1">Tỷ lệ đã tiếp cận</label>
                            <input type="text" id="contactRate" class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Nhập tỷ lệ %">
                        </div>
                    </div>
                    
                    <!-- Summary Table -->
                    <div class="table-container">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">STT</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mã chi nhánh</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tên chi nhánh</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vùng</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SL KH chưa có code</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SL KH đã có code</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tổng KH được PG</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SL KH chưa tiếp cận</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SL KH đã tiếp cận</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tỷ lệ tiếp cận</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hành động</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr class="cursor-pointer hover:bg-blue-50" onclick="openBranchDetail('CN001')">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">1</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-blue-600">CN001</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Chi nhánh Hà Nội</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Miền Bắc</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">25</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">15</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">40</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">12</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">28</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">70%</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button class="text-blue-600 hover:text-blue-900">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr class="cursor-pointer hover:bg-blue-50" onclick="openBranchDetail('CN002')">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">2</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-blue-600">CN002</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Chi nhánh Hồ Chí Minh</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Miền Nam</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">35</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">25</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">60</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">18</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">42</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">70%</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button class="text-blue-600 hover:text-blue-900">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr class="cursor-pointer hover:bg-blue-50" onclick="openBranchDetail('CN003')">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">3</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-blue-600">CN003</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Chi nhánh Đà Nẵng</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Miền Trung</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">15</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">10</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">25</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">8</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">17</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">68%</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button class="text-blue-600 hover:text-blue-900">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- RM Performance Section -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-lg font-medium text-blue-700 mb-4">Hiệu suất RM</h2>
                    
                    <!-- Search Filters -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <!-- RM -->
                        <div class="dropdown relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1">RM</label>
                            <button type="button" class="w-full bg-white border border-gray-300 rounded-md px-4 py-2 text-left flex justify-between items-center">
                                <span>Tất cả</span>
                                <i class="fas fa-chevron-down text-gray-500"></i>
                            </button>
                            <div class="dropdown-content rounded-md mt-1">
                                <div class="dropdown-item px-4 py-2 cursor-pointer hover:bg-blue-100">Tất cả</div>
                                <div class="dropdown-item px-4 py-2 cursor-pointer hover:bg-blue-100">RM001 - Nguyễn Văn A</div>
                                <div class="dropdown-item px-4 py-2 cursor-pointer hover:bg-blue-100">RM002 - Trần Thị B</div>
                                <div class="dropdown-item px-4 py-2 cursor-pointer hover:bg-blue-100">RM003 - Lê Văn C</div>
                            </div>
                        </div>
                        
                        <!-- Branch -->
                        <div class="dropdown relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Chi nhánh</label>
                            <button type="button" class="w-full bg-white border border-gray-300 rounded-md px-4 py-2 text-left flex justify-between items-center">
                                <span>Tất cả</span>
                                <i class="fas fa-chevron-down text-gray-500"></i>
                            </button>
                            <div class="dropdown-content rounded-md mt-1">
                                <div class="dropdown-item px-4 py-2 cursor-pointer hover:bg-blue-100">Tất cả</div>
                                <div class="dropdown-item px-4 py-2 cursor-pointer hover:bg-blue-100">Chi nhánh Hà Nội</div>
                                <div class="dropdown-item px-4 py-2 cursor-pointer hover:bg-blue-100">Chi nhánh Hồ Chí Minh</div>
                                <div class="dropdown-item px-4 py-2 cursor-pointer hover:bg-blue-100">Chi nhánh Đà Nẵng</div>
                            </div>
                        </div>
                        
                        <!-- Contact Rate -->
                        <div>
                            <label for="rmContactRate" class="block text-sm font-medium text-gray-700 mb-1">Tỷ lệ tiếp cận</label>
                            <input type="text" id="rmContactRate" class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Nhập tỷ lệ %">
                        </div>
                    </div>
                    
                    <!-- RM Performance Table -->
                    <div class="table-container">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">STT</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mã RM</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tên RM</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SL KH chưa có code</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SL KH đã có code</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tổng KH được PG</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SL KH chưa tiếp cận</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SL KH đã tiếp cận</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tỷ lệ tiếp cận</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">1</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-blue-600">RM001</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Nguyễn Văn A</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">10</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">8</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">18</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">5</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">13</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">72%</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">2</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-blue-600">RM002</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Trần Thị B</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">15</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">10</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">25</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">8</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">17</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">68%</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">3</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-blue-600">RM003</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Lê Văn C</td>
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
    <div id="updateModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('updateModal')">&times;</span>
            <h2 class="text-xl font-bold text-blue-800 mb-4">Cập nhật kết quả tiếp cận</h2>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Khách hàng</label>
                <div class="w-full bg-gray-100 border border-gray-300 rounded-md px-4 py-2" id="modalCustomerName">
                    KH001 - Nguyễn Văn A
                </div>
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Kết quả tiếp cận</label>
                <select id="contactResult" class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-blue-500 focus:border-blue-500" onchange="showReasons(this.value)">
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
                <select id="pauseReason" class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Chọn lý do</option>
                    <option value="no_need">Không có nhu cầu</option>
                    <option value="other_bank">Quan hệ TCTD khác</option>
                    <option value="price_issue">LS/Phí chưa cạnh tranh</option>
                    <option value="bad_impression">Không thiện cảm với</option>
                </select>
            </div>
            
            <div id="rejectReasons" class="mb-4 hidden">
                <label class="block text-sm font-medium text-gray-700 mb-1">Lý do từ chối</label>
                <select id="rejectReason" class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Chọn lý do</option>
                    <option value="bad_debt">Nợ quá hạn/nợ xấu</option>
                    <option value="stopped">Đã ngừng hoạt động</option>
                    <option value="warning">Thuộc đối tượng cảnh báo của Nhà nước</option>
                    <option value="no_support">Đối tượng không tài trợ theo CĐTD</option>
                </select>
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Ghi chú</label>
                <textarea id="contactNote" class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-blue-500 focus:border-blue-500 h-24" placeholder="Nhập ghi chú (tối đa 200 ký tự)"></textarea>
            </div>
            
            <div class="flex justify-end space-x-4">
                <button class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-md" onclick="closeModal('updateModal')">
                    Hủy
                </button>
                <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md" onclick="saveContactResult()">
                    Lưu
                </button>
            </div>
        </div>
    </div>

    <!-- Branch Detail Modal -->
    <div id="branchDetailModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('branchDetailModal')">&times;</span>
            <h2 class="text-xl font-bold text-blue-800 mb-4">Chi tiết chi nhánh <span id="branchName">Chi nhánh Hà Nội</span></h2>
            
            <div class="table-container">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">STT</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mã RM</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tên RM</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SL KH chưa có code</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SL KH đã có code</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tổng KH được PG</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SL KH chưa tiếp cận</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SL KH đã tiếp cận</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tỷ lệ tiếp cận</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200" id="branchDetailBody">
                        <!-- Data will be populated by JavaScript -->
                    </tbody>
                </table>
            </div>
            
            <div class="flex justify-end mt-4">
                <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md" onclick="closeModal('branchDetailModal')">
                    Đóng
                </button>
            </div>
        </div>
    </div>

    <script>
        // Tab functionality
        document.querySelectorAll('[data-tab]').forEach(tab => {
            tab.addEventListener('click', function() {
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
            
            button.addEventListener('click', function() {
                content.style.display = content.style.display === 'block' ? 'none' : 'block';
            });
            
            dropdown.querySelectorAll('.dropdown-item').forEach(item => {
                item.addEventListener('click', function() {
                    button.querySelector('span').textContent = this.textContent;
                    content.style.display = 'none';
                });
            });
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            if (!event.target.closest('.dropdown')) {
                document.querySelectorAll('.dropdown-content').forEach(content => {
                    content.style.display = 'none';
                });
            }
        });
        
        // Back button functionality
        document.querySelector('.bg-gray-500').addEventListener('click', function() {
            alert('Quay lại danh sách chiến dịch');
            // In a real app, this would redirect to the campaign list page
        });
        
        // Edit button functionality
        document.querySelector('.bg-blue-600').addEventListener('click', function() {
            alert('Chuyển đến màn hình chỉnh sửa chiến dịch');
            // In a real app, this would redirect to the edit campaign page
        });
        
        // Search button functionality
        document.querySelectorAll('.bg-blue-600.text-white').forEach(button => {
            if (button.textContent.includes('Tìm kiếm')) {
                button.addEventListener('click', function() {
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
                { code: 'RM001', name: 'Nguyễn Văn A', noCode: 10, hasCode: 8, total: 18, notContacted: 5, contacted: 13, rate: '72%' },
                { code: 'RM002', name: 'Trần Thị B', noCode: 8, hasCode: 5, total: 13, notContacted: 4, contacted: 9, rate: '69%' },
                { code: 'RM003', name: 'Lê Văn C', noCode: 7, hasCode: 6, total: 13, notContacted: 5, contacted: 8, rate: '62%' }
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
        window.onclick = function(event) {
            if (event.target.className === 'modal') {
                event.target.style.display = 'none';
            }
        }
    </script>
                                </div>
                            </div>    
                            </div>
                            
                        </div>
                        </div>
                    </div>

                    
    <?php include('include-js.php'); ?>
    <!-- Page Specific JS File -->
    <script src="<?= base_url('assets/js/page/components-user.js'); ?>"></script>
    <script src="<?= base_url('assets/js/page/project-details.js'); ?>"></script>

</body>

</html>