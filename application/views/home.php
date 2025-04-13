<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Dashboard — <?= get_compnay_title(); ?></title>
    <?php include('include-css.php'); ?>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        #result-campaign-chart-container, #stage-campaign-chart-container {
    height: 400px;
    width: 100%;
}
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 3px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
        .chart-container {
            transition: all 0.3s ease;
        }
        .chart-container:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
}
.dropdown-content {
    display: none;
    position: absolute;
    z-index: 1000;
}
.dropdown:hover .dropdown-content,
.dropdown-content:not(.hidden) {
    display: block;
}
.slide-in {
    animation: slideIn 0.3s forwards;
}
@keyframes slideIn {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}
        .tab-active {
            border-bottom: 3px solid #3b82f6;
            color: #3b82f6;
            font-weight: 600;
        }
        .customer-row:hover {
            background-color: #f3f4f6;
            cursor: pointer;
        }
      
        .bar-hover:hover {
            opacity: 0.8;
            cursor: pointer;
        }
        .data-tooltip {
            position: absolute;
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 12px;
            pointer-events: none;
            z-index: 100;
            display: none;
        }
        .chart-container {
    display: block !important;
}
    </style>
</head>
<body class="bg-gray-50">
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <?php include('include-header.php'); ?>

            <!-- Main Content -->
            <div class="main-content">
                <section class="section">
                    <div class="container mx-auto px-4 py-6">
                        <!-- Loại Dashboard -->
                        <div class="flex justify-between items-center mb-6">
                            <div>
                               
                            </div>
                            <div class="flex items-center space-x-4">
                                <div class="relative">
                                    <select id="dashboard-type" class="block appearance-none bg-white border border-gray-300 text-gray-700 py-2 px-4 pr-8 rounded leading-tight focus:outline-none focus:border-blue-500" onchange="loadDashboard()">
                                        <option value="customer" selected>Dashboard Khách Hàng</option>
                                        <option value="campaign">Dashboard Chiến Dịch</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                        <i class="fas fa-chevron-down"></i>
                                    </div>
                                </div>
                                <div class="bg-blue-50 text-blue-700 px-4 py-2 rounded-lg flex items-center">
                                    <i class="fas fa-sync-alt mr-2"></i>
                                    <span id="last-updated">Cập nhật: 10:30 15/06/2023</span>
                                </div>
                            </div>
                        </div>

                        <!-- Dashboard Content -->
                        <div id="dashboard-content">
                            <!-- Dashboard Khách Hàng -->
                            <div id="customer-dashboard" class="dashboard-section">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4>Dashboard Khách Hàng</h4>
                                            </div>
                                            <div class="card-body">
                                                <ul class="nav nav-tabs flex border-b mb-6" id="customerTabs" role="tablist">
                                                    <li class="nav-item">
                                                        <a class="nav-link tab-active px-6 py-3 font-medium active" id="casa-tab" data-toggle="tab" href="#casa" role="tab" aria-controls="casa" aria-selected="true">TOP KH Biến động CASA</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link px-6 py-3 text-gray-600 font-medium hover:text-blue-600" id="savings-tab" data-toggle="tab" href="#savings" role="tab" aria-controls="savings" aria-selected="false">TOP KH Biến động Tiết kiệm</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link px-6 py-3 text-gray-600 font-medium hover:text-blue-600" id="overview-tab" data-toggle="tab" href="#overview" role="tab" aria-controls="overview" aria-selected="false">Tổng Quan Khách Hàng</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link px-6 py-3 text-gray-600 font-medium hover:text-blue-600" id="spdv-tab" data-toggle="tab" href="#spdv" role="tab" aria-controls="spdv" aria-selected="false">Tỷ Lệ Sử Dụng SPDV</a>
                                                    </li>
                                                </ul>

                                                <div class="tab-content" id="customerTabContent">
                                                    <!-- Tab CASA -->
                                                    <div class="tab-pane fade show active" id="casa" role="tabpanel" aria-labelledby="casa-tab">
                                                        <!-- Filter Section -->
                                                        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                                                            <h2 class="text-xl font-semibold mb-4 text-gray-800">TOP KH biến động số dư CASA lớn nhất</h2>
                                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                                                                <div>
                                                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="casa-change-type">Biến động</label>
                                                                    <div class="flex space-x-4">
                                                                        <label class="inline-flex items-center">
                                                                            <input type="radio" class="form-radio text-blue-600" name="casa-change-type" value="increase" checked>
                                                                            <span class="ml-2">Tăng</span>
                                                                        </label>
                                                                        <label class="inline-flex items-center">
                                                                            <input type="radio" class="form-radio text-blue-600" name="casa-change-type" value="decrease">
                                                                            <span class="ml-2">Giảm</span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div>
                                                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="casa-time-period">Thời gian biến động</label>
                                                                    <div class="flex space-x-4">
                                                                        <label class="inline-flex items-center">
                                                                            <input type="radio" class="form-radio text-blue-600" name="casa-time-period" value="daily" checked>
                                                                            <span class="ml-2">Theo ngày</span>
                                                                        </label>
                                                                        <label class="inline-flex items-center">
                                                                            <input type="radio" class="form-radio text-blue-600" name="casa-time-period" value="monthly">
                                                                            <span class="ml-2">Theo tháng</span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div>
                                                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="casa-count">Số lượng KH hiển thị</label>
                                                                    <select id="casa-count" class="block appearance-none w-full bg-white border border-gray-300 text-gray-700 py-2 px-4 pr-8 rounded leading-tight focus:outline-none focus:border-blue-500">
                                                                        <option value="10">10 khách hàng</option>
                                                                        <option value="20">20 khách hàng</option>
                                                                        <option value="30">30 khách hàng</option>
                                                                        <option value="40">40 khách hàng</option>
                                                                        <option value="50">50 khách hàng</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="flex justify-between items-center">
                                                                <div class="text-sm text-gray-500">
                                                                    <span id="casa-filter-summary">Hiển thị top 10 KH có biến động tăng CASA lớn nhất theo ngày</span>
                                                                </div>
                                                                <div class="flex space-x-2">
                                                                    <button id="casa-chart-view-btn" class="bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center" onclick="loadCASAChart('chart')">
                                                                        <i class="fas fa-chart-bar mr-2"></i>
                                                                        Biểu đồ
                                                                    </button>
                                                                    <button id="casa-table-view-btn" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg flex items-center" onclick="loadCASAChart('table')">
                                                                        <i class="fas fa-table mr-2"></i>
                                                                        Bảng
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Chart View -->
                                                        <div id="casa-chart-container" class="chart-container bg-white rounded-lg shadow-md p-6 mb-6">
                                                            <div class="flex justify-between items-center mb-4">
                                                                <h3 class="text-lg font-semibold text-gray-800">Biểu đồ TOP KH biến động CASA</h3>
                                                                <div class="text-sm text-gray-500">
                                                                    <span id="casa-chart-filter-summary">Biến động tăng theo ngày</span>
                                                                </div>
                                                            </div>
                                                            <div class="h-96">
                                                                <canvas id="casa-chart"></canvas>
                                                            </div>
                                                        </div>

                                                        <!-- Table View -->
                                                        <div id="casa-table-container" class="chart-container bg-white rounded-lg shadow-md p-6 mb-6" style="display: none;">
                                                            <div class="flex justify-between items-center mb-4">
                                                                <h3 class="text-lg font-semibold text-gray-800">Bảng TOP KH biến động CASA</h3>
                                                                <div class="text-sm text-gray-500">
                                                                    <span id="casa-table-filter-summary">Biến động tăng theo ngày</span>
                                                                </div>
                                                            </div>
                                                            <div class="overflow-x-auto custom-scrollbar">
                                                                <table class="min-w-full divide-y divide-gray-200">
                                                                    <thead class="bg-gray-50">
                                                                        <tr>
                                                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">STT</th>
                                                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Code KH</th>
                                                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tên khách hàng</th>
                                                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Biến động</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="casa-table-body" class="bg-white divide-y divide-gray-200"></tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Tab Tiết kiệm -->
                                                    <div class="tab-pane fade" id="savings" role="tabpanel" aria-labelledby="savings-tab">
                                                        <!-- Filter Section -->
                                                        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                                                            <h2 class="text-xl font-semibold mb-4 text-gray-800">TOP KH biến động số dư Tiết kiệm lớn nhất</h2>
                                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                                                                <div>
                                                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="savings-change-type">Biến động</label>
                                                                    <div class="flex space-x-4">
                                                                        <label class="inline-flex items-center">
                                                                            <input type="radio" class="form-radio text-blue-600" name="savings-change-type" value="increase" checked>
                                                                            <span class="ml-2">Tăng</span>
                                                                        </label>
                                                                        <label class="inline-flex items-center">
                                                                            <input type="radio" class="form-radio text-blue-600" name="savings-change-type" value="decrease">
                                                                            <span class="ml-2">Giảm</span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div>
                                                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="savings-time-period">Thời gian biến động</label>
                                                                    <div class="flex space-x-4">
                                                                        <label class="inline-flex items-center">
                                                                            <input type="radio" class="form-radio text-blue-600" name="savings-time-period" value="daily" checked>
                                                                            <span class="ml-2">Theo ngày</span>
                                                                        </label>
                                                                        <label class="inline-flex items-center">
                                                                            <input type="radio" class="form-radio text-blue-600" name="savings-time-period" value="monthly">
                                                                            <span class="ml-2">Theo tháng</span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div>
                                                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="savings-count">Số lượng KH hiển thị</label>
                                                                    <select id="savings-count" class="block appearance-none w-full bg-white border border-gray-300 text-gray-700 py-2 px-4 pr-8 rounded leading-tight focus:outline-none focus:border-blue-500">
                                                                        <option value="10">10 khách hàng</option>
                                                                        <option value="20">20 khách hàng</option>
                                                                        <option value="30">30 khách hàng</option>
                                                                        <option value="40">40 khách hàng</option>
                                                                        <option value="50">50 khách hàng</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="flex justify-between items-center">
                                                                <div class="text-sm text-gray-500">
                                                                    <span id="savings-filter-summary">Hiển thị top 10 KH có biến động tăng Tiết kiệm lớn nhất theo ngày</span>
                                                                </div>
                                                                <div class="flex space-x-2">
                                                                    <button id="savings-chart-view-btn" class="bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center" onclick="loadSavingsChart('chart')">
                                                                        <i class="fas fa-chart-bar mr-2"></i>
                                                                        Biểu đồ
                                                                    </button>
                                                                    <button id="savings-table-view-btn" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg flex items-center" onclick="loadSavingsChart('table')">
                                                                        <i class="fas fa-table mr-2"></i>
                                                                        Bảng
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Chart View -->
                                                        <div id="savings-chart-container" class="chart-container bg-white rounded-lg shadow-md p-6 mb-6">
                                                            <div class="flex justify-between items-center mb-4">
                                                                <h3 class="text-lg font-semibold text-gray-800">Biểu đồ TOP KH biến động Tiết kiệm</h3>
                                                                <div class="text-sm text-gray-500">
                                                                    <span id="savings-chart-filter-summary">Biến động tăng theo ngày</span>
                                                                </div>
                                                            </div>
                                                            <div class="h-96">
                                                                <canvas id="savings-chart"></canvas>
                                                            </div>
                                                        </div>

                                                        <!-- Table View -->
                                                        <div id="savings-table-container" class="chart-container bg-white rounded-lg shadow-md p-6 mb-6" style="display: none;">
                                                            <div class="flex justify-between items-center mb-4">
                                                                <h3 class="text-lg font-semibold text-gray-800">Bảng TOP KH biến động Tiết kiệm</h3>
                                                                <div class="text-sm text-gray-500">
                                                                    <span id="savings-table-filter-summary">Biến động tăng theo ngày</span>
                                                                </div>
                                                            </div>
                                                            <div class="overflow-x-auto custom-scrollbar">
                                                                <table class="min-w-full divide-y divide-gray-200">
                                                                    <thead class="bg-gray-50">
                                                                        <tr>
                                                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">STT</th>
                                                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Code KH</th>
                                                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tên khách hàng</th>
                                                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Biến động</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="savings-table-body" class="bg-white divide-y divide-gray-200"></tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Tab Tổng Quan Khách Hàng -->
                                                    <div class="tab-pane fade" id="overview" role="tabpanel" aria-labelledby="overview-tab">
                                                        <!-- Filter Section -->
                                                        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                                                            <h2 class="text-xl font-semibold mb-4 text-gray-800">Tổng quan khách hàng</h2>
                                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                                                <div>
                                                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="customer-group">Nhóm khách hàng</label>
                                                                    <div class="relative">
                                                                        <select id="customer-group" class="block appearance-none w-full bg-white border border-gray-300 text-gray-700 py-2 px-4 pr-8 rounded leading-tight focus:outline-none focus:border-blue-500">
                                                                            <option value="all">Tất cả</option>
                                                                            <option value="new">KH mới 1 tháng</option>
                                                                        </select>
                                                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                                                            <i class="fas fa-chevron-down"></i>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div>
                                                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="customer-segment">Phân khúc</label>
                                                                    <div class="relative">
                                                                        <select id="customer-segment" class="block appearance-none w-full bg-white border border-gray-300 text-gray-700 py-2 px-4 pr-8 rounded leading-tight focus:outline-none focus:border-blue-500">
                                                                            <option value="private">Private</option>
                                                                            <option value="vip">VIP</option>
                                                                        </select>
                                                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                                                            <i class="fas fa-chevron-down"></i>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="flex justify-between items-center">
                                                                <div class="text-sm text-gray-500">
                                                                    <span id="overview-filter-summary">Hiển thị tổng quan khách hàng cho tất cả nhóm KH phân khúc Private</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Chart View -->
                                                        <div id="overview-chart-container" class="chart-container bg-white rounded-lg shadow-md p-6 mb-6">
                                                            <div class="flex justify-between items-center mb-4">
                                                                <h3 class="text-lg font-semibold text-gray-800">Biểu đồ tổng quan khách hàng theo nhóm tuổi</h3>
                                                                <div class="text-sm text-gray-500">
                                                                    <span id="overview-chart-filter-summary">Tất cả KH - Private</span>
                                                                </div>
                                                            </div>
                                                            <div class="h-96 relative">
                                                                <canvas id="overview-chart"></canvas>
                                                                <div id="overview-data-tooltip" class="data-tooltip"></div>
                                                            </div>
                                                            <!-- Summary Cards -->
                                                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-6">
                                                                <div class="bg-blue-50 p-4 rounded-lg">
                                                                    <div class="text-sm text-blue-700 font-medium">Tổng số KH</div>
                                                                    <div id="total-customers" class="text-2xl font-bold text-blue-900">0</div>
                                                                </div>
                                                                <div class="bg-green-50 p-4 rounded-lg">
                                                                    <div class="text-sm text-green-700 font-medium">Tổng KH active</div>
                                                                    <div id="total-active" class="text-2xl font-bold text-green-900">0</div>
                                                                </div>
                                                                <div class="bg-purple-50 p-4 rounded-lg">
                                                                    <div class="text-sm text-purple-700 font-medium">Tỷ lệ KH active</div>
                                                                    <div id="active-rate" class="text-2xl font-bold text-purple-900">0%</div>
                                                                </div>
                                                                <div class="bg-yellow-50 p-4 rounded-lg">
                                                                    <div class="text-sm text-yellow-700 font-medium">KH mới 1 tháng</div>
                                                                    <div id="new-customers" class="text-2xl font-bold text-yellow-900">0</div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Data Table -->
                                                        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                                                            <h3 class="text-lg font-semibold mb-4 text-gray-800">Chi tiết theo nhóm tuổi</h3>
                                                            <div class="overflow-x-auto custom-scrollbar">
                                                                <table class="min-w-full divide-y divide-gray-200">
                                                                    <thead class="bg-gray-50">
                                                                        <tr>
                                                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nhóm tuổi</th>
                                                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Số lượng KH</th>
                                                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Số KH active</th>
                                                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tỷ lệ active</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="overview-table-body" class="bg-white divide-y divide-gray-200"></tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Tab Tỷ Lệ Sử Dụng SPDV -->
<div class="tab-pane fade" id="spdv" role="tabpanel" aria-labelledby="spdv-tab">
    <!-- Filter Section -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4 text-gray-800">Tỷ lệ sử dụng sản phẩm dịch vụ</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <!-- Customer group filter -->
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="spdv-group">
                    Nhóm khách hàng
                </label>
                <div class="relative">
                    <select id="spdv-group" class="block appearance-none w-full bg-white border border-gray-300 text-gray-700 py-2 px-4 pr-8 rounded leading-tight focus:outline-none focus:border-blue-500">
                        <option value="all">Tất cả</option>
                        <option value="new">KH mới 1 tháng</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <i class="fas fa-chevron-down"></i>
                    </div>
                </div>
            </div>
            
            <!-- Customer segment filter -->
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="spdv-segment">
                    Phân khúc
                </label>
                <div class="relative">
                    <select id="spdv-segment" class="block appearance-none w-full bg-white border border-gray-300 text-gray-700 py-2 px-4 pr-8 rounded leading-tight focus:outline-none focus:border-blue-500">
                        <option value="private">Private</option>
                        <option value="vip">VIP</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <i class="fas fa-chevron-down"></i>
                    </div>
                </div>
            </div>
            
            <!-- Age group filter -->
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="spdv-age">
                    Nhóm tuổi
                </label>
                <div class="relative">
                    <select id="spdv-age" class="block appearance-none w-full bg-white border border-gray-300 text-gray-700 py-2 px-4 pr-8 rounded leading-tight focus:outline-none focus:border-blue-500">
                        <option value="all">Tất cả</option>
                        <option value="0-18">0-18</option>
                        <option value="18-25">18-25</option>
                        <option value="25-35">25-35</option>
                        <option value="35-50">35-50</option>
                        <option value="50-60">50-60</option>
                        <option value="60+">Trên 60</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <i class="fas fa-chevron-down"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="flex justify-between items-center">
            <div class="text-sm text-gray-500">
                <span id="spdv-filter-summary">Hiển thị tỷ lệ sử dụng SPDV cho tất cả nhóm KH, phân khúc Private, tất cả nhóm tuổi</span>
            </div>
        </div>
    </div>

    <!-- Chart View -->
    <div id="spdv-chart-container" class="chart-container bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Biểu đồ tỷ lệ sử dụng sản phẩm dịch vụ</h3>
            <div class="text-sm text-gray-500">
                <span id="spdv-chart-filter-summary">Tất cả KH - Private - Tất cả nhóm tuổi</span>
            </div>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Pie Chart -->
            <div class="lg:col-span-2 h-96 relative">
                <canvas id="spdv-chart"></canvas>
                <div id="spdv-data-tooltip" class="data-tooltip"></div>
            </div>
            
            <!-- Product List -->
            <div class="bg-gray-50 p-4 rounded-lg overflow-y-auto custom-scrollbar" style="max-height: 400px;">
                <h4 class="text-md font-semibold mb-3 text-gray-700">Danh sách sản phẩm dịch vụ</h4>
                <ul id="spdv-product-list" class="space-y-2">
                    <!-- Product items will be inserted here by JavaScript -->
                </ul>
            </div>
        </div>
        
        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
            <div class="bg-blue-50 p-4 rounded-lg">
                <div class="text-sm text-blue-700 font-medium">Tổng số KH sử dụng SPDV</div>
                <div id="spdv-total-customers" class="text-2xl font-bold text-blue-900">0</div>
            </div>
            <div class="bg-green-50 p-4 rounded-lg">
                <div class="text-sm text-green-700 font-medium">Sản phẩm phổ biến nhất</div>
                <div id="spdv-top-product" class="text-2xl font-bold text-green-900">-</div>
            </div>
            <div class="bg-purple-50 p-4 rounded-lg">
                <div class="text-sm text-purple-700 font-medium">Tỷ lệ sử dụng cao nhất</div>
                <div id="spdv-top-rate" class="text-2xl font-bold text-purple-900">0%</div>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h3 class="text-lg font-semibold mb-4 text-gray-800">Chi tiết tỷ lệ sử dụng sản phẩm dịch vụ</h3>
        
        <div class="overflow-x-auto custom-scrollbar">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sản phẩm dịch vụ</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Số KH sử dụng</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tỷ lệ sử dụng</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Xu hướng</th>
                    </tr>
                </thead>
                <tbody id="spdv-table-body" class="bg-white divide-y divide-gray-200">
                    <!-- Table rows will be inserted here by JavaScript -->
                </tbody>
            </table>
        </div>
    </div>
</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Dashboard Chiến Dịch -->
                            <div id="campaign-dashboard" class="dashboard-section" style="display: none;">
    <div class="flex h-screen overflow-hidden">
        

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="bg-white shadow-sm">
                <div class="flex justify-between items-center p-4">
                    <h2 class="text-xl font-semibold text-gray-800">Dashboard Chiến Dịch</h2>
                    
                </div>
            </header>

            <!-- Content -->
            <!-- Content -->
            <main class="flex-1 overflow-y-auto p-6">
                <!-- Filter Section -->
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <div class="flex flex-wrap items-center gap-4">
                        <!-- Dashboard Dimension (Only for Admin/CBQL) -->
                        <div id="dimensionFilter" class="flex items-center space-x-4">
                            <span class="font-medium text-gray-700">Chiều dashboard:</span>
                            <div class="flex space-x-2">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="dimension" value="branch" checked class="h-4 w-4 text-blue-600">
                                    <span class="ml-2">Chi nhánh</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="dimension" value="rm" class="h-4 w-4 text-blue-600">
                                    <span class="ml-2">RM</span>
                                </label>
                            </div>
                        </div>

                        <!-- Branch Dropdown -->
                    
                        <div class="relative dropdown">
                            <button class="bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium py-2 px-4 rounded inline-flex items-center">
                                <span>Chi nhánh: Tất cả</span>
                                <i class="fas fa-chevron-down ml-2"></i>
                            </button>
                            <div class="dropdown-content mt-1 w-64 bg-white rounded-md shadow-lg hidden">
                                <div class="p-2 max-h-60 overflow-y-auto custom-scrollbar">
                                    <div class="p-2 hover:bg-blue-50 rounded cursor-pointer" data-value="all">Tất cả chi nhánh</div>
                                    <div class="p-2 hover:bg-blue-50 rounded cursor-pointer" data-value="hanoi">Hà Nội</div>
                                    <div class="p-2 hover:bg-blue-50 rounded cursor-pointer" data-value="hcm">Hồ Chí Minh</div>
                                    <div class="p-2 hover:bg-blue-50 rounded cursor-pointer" data-value="danang">Đà Nẵng</div>
                                    <div class="p-2 hover:bg-blue-50 rounded cursor-pointer" data-value="haiphong">Hải Phòng</div>
                                </div>
                            </div>
                        </div>

                        <!-- RM Dropdown -->
                        <div id="rmFilter" class="relative dropdown hidden">
                            <button class="bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium py-2 px-4 rounded inline-flex items-center">
                                <span>RM: RM001 - Nguyễn Văn A</span>
                                <i class="fas fa-chevron-down ml-2"></i>
                            </button>
                            <div class="dropdown-content mt-1 w-64 bg-white rounded-md shadow-lg hidden">
                                <div class="p-2 max-h-60 overflow-y-auto custom-scrollbar">
                                    <div class="p-2 hover:bg-blue-50 rounded cursor-pointer" data-value="rm1">RM001 - Nguyễn Văn A</div>
                                    <div class="p-2 hover:bg-blue-50 rounded cursor-pointer" data-value="rm2">RM002 - Trần Thị B</div>
                                    <div class="p-2 hover:bg-blue-50 rounded cursor-pointer" data-value="rm3">RM003 - Lê Văn C</div>
                                    <div class="p-2 hover:bg-blue-50 rounded cursor-pointer" data-value="rm4">RM004 - Phạm Thị D</div>
                                </div>
                            </div>
                        </div>

                        <!-- Campaign Dropdown -->
                        <div class="relative dropdown">
                            <button class="bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium py-2 px-4 rounded inline-flex items-center">
                                <span>Chiến dịch: Tăng trưởng Q2</span>
                                <i class="fas fa-chevron-down ml-2"></i>
                            </button>
                            <div class="dropdown-content mt-1 w-64 bg-white rounded-md shadow-lg hidden">
                                <div class="p-2 max-h-60 overflow-y-auto custom-scrollbar">
                                    <div class="p-2 hover:bg-blue-50 rounded cursor-pointer" data-value="campaign1">Tăng trưởng Q2</div>
                                    <div class="p-2 hover:bg-blue-50 rounded cursor-pointer" data-value="campaign2">Khách hàng VIP</div>
                                    <div class="p-2 hover:bg-blue-50 rounded cursor-pointer" data-value="campaign3">Mở rộng thị trường</div>
                                    <div class="p-2 hover:bg-blue-50 rounded cursor-pointer" data-value="campaign4">Giữ chân khách hàng</div>
                                </div>
                            </div>
                        </div>

                        <!-- Chart Type Toggle -->
                        <div class="flex items-center space-x-2 ml-auto">
                            <span class="font-medium text-gray-700">Loại biểu đồ:</span>
                            <button id="pieChartBtn" class="p-2 rounded-full bg-blue-100 text-blue-600">
                                <i class="fas fa-chart-pie"></i>
                            </button>
                            <button id="barChartBtn" class="p-2 rounded-full bg-gray-100 text-gray-600">
                                <i class="fas fa-chart-bar"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Overview Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div class="bg-white rounded-lg shadow p-6 flex items-center">
                        <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                            <i class="fas fa-fire text-xl"></i>
                        </div>
                        <div>
                            <div class="text-gray-500">Chiến dịch active</div>
                            <div class="text-2xl font-bold">12</div>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow p-6 flex items-center">
                        <div class="p-3 rounded-full bg-yellow-100 text-yellow-600 mr-4">
                            <i class="fas fa-clock text-xl"></i>
                        </div>
                        <div>
                            <div class="text-gray-500">Sắp hết hạn</div>
                            <div class="text-2xl font-bold">3</div>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow p-6 flex items-center">
                        <div class="p-3 rounded-full bg-red-100 text-red-600 mr-4">
                            <i class="fas fa-users-slash text-xl"></i>
                        </div>
                        <div>
                            <div class="text-gray-500">KH chưa phân giao</div>
                            <div class="text-2xl font-bold">24</div>
                        </div>
                    </div>
                </div>

                <!-- Charts Section -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Kết quả hoạt động bán -->
                    <div class="bg-white rounded-lg shadow p-6 chart-container">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold">Kết quả hoạt động bán</h3>
                            <button class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                Xem chi tiết <i class="fas fa-chevron-right ml-1"></i>
                            </button>
                        </div>
                        <div class="h-64">
                            <canvas id="resultChart"></canvas>
                        </div>
                    </div>

                    <!-- Giai đoạn chiến dịch -->
                    <div class="bg-white rounded-lg shadow p-6 chart-container">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold">Giai đoạn chiến dịch</h3>
                            <button class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                Xem chi tiết <i class="fas fa-chevron-right ml-1"></i>
                            </button>
                        </div>
                        <div class="h-64">
                            <canvas id="stageChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- RM Performance Table (Hidden by default, shown when clicking on chart) -->
                <div id="rmPerformance" class="hidden bg-white rounded-lg shadow p-6 mt-6 slide-in">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Hiệu suất theo RM</h3>
                        <button id="backToDashboard" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            <i class="fas fa-arrow-left mr-1"></i> Quay lại
                        </button>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mã RM</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Số lượng KH</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tỷ lệ (%)</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr class="hover:bg-gray-50 cursor-pointer">
                                    <td class="px-6 py-4 whitespace-nowrap">RM001 - Nguyễn Văn A</td>
                                    <td class="px-6 py-4 whitespace-nowrap">45</td>
                                    <td class="px-6 py-4 whitespace-nowrap">32%</td>
                                </tr>
                                <tr class="hover:bg-gray-50 cursor-pointer">
                                    <td class="px-6 py-4 whitespace-nowrap">RM002 - Trần Thị B</td>
                                    <td class="px-6 py-4 whitespace-nowrap">38</td>
                                    <td class="px-6 py-4 whitespace-nowrap">27%</td>
                                </tr>
                                <tr class="hover:bg-gray-50 cursor-pointer">
                                    <td class="px-6 py-4 whitespace-nowrap">RM003 - Lê Văn C</td>
                                    <td class="px-6 py-4 whitespace-nowrap">25</td>
                                    <td class="px-6 py-4 whitespace-nowrap">18%</td>
                                </tr>
                                <tr class="hover:bg-gray-50 cursor-pointer">
                                    <td class="px-6 py-4 whitespace-nowrap">RM004 - Phạm Thị D</td>
                                    <td class="px-6 py-4 whitespace-nowrap">20</td>
                                    <td class="px-6 py-4 whitespace-nowrap">14%</td>
                                </tr>
                                <tr class="hover:bg-gray-50 cursor-pointer">
                                    <td class="px-6 py-4 whitespace-nowrap">RM005 - Hoàng Văn E</td>
                                    <td class="px-6 py-4 whitespace-nowrap">12</td>
                                    <td class="px-6 py-4 whitespace-nowrap">9%</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>

        </div>
    </div>
</div>
                                
                                    <!-- Kết Quả Chiến Dịch -->
                                    <div id="result-campaign" class="campaign-tab-pane" style="display: none;">
                                        <div class="chart-container">
                                            <canvas id="result-campaign-chart"></canvas>
                                        </div>
                                        <div id="result-campaign-table" style="display: none;">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>STT</th>
                                                        <th>Kết Quả</th>
                                                        <th>Số lượng KH</th>
                                                        <th>Tỷ lệ (%)</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="result-campaign-table-body"></tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <!-- Giai Đoạn Chiến Dịch -->
                                    <div id="stage-campaign" class="campaign-tab-pane" style="display: none;">
                                        <div class="chart-container">
                                            <canvas id="stage-campaign-chart"></canvas>
                                        </div>
                                        <div id="stage-campaign-table" style="display: none;">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>STT</th>
                                                        <th>Giai Đoạn</th>
                                                        <th>Số lượng KH</th>
                                                        <th>Tỷ lệ (%)</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="stage-campaign-table-body"></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <?php include('include-footer.php'); ?>
        </div>
    </div>

    <!-- Script -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        let casaChart, savingsChart, overviewChart, spdvChart, resultCampaignChart, stageCampaignChart;

        // Dữ liệu mẫu cho CASA
        const casaData = [
            { code: "KH001", name: "Nguyễn Văn A", daily: 125000000, monthly: 8000000 },
            { code: "KH002", name: "Trần Thị B", daily: 98000000, monthly: 7000000 },
            { code: "KH003", name: "Lê Văn C", daily: 87500000, monthly: 6000000 },
            { code: "KH004", name: "Phạm Thị D", daily: 76500000, monthly: 5000000 },
            { code: "KH005", name: "Hoàng Văn E", daily: 65400000, monthly: 4000000 },
            { code: "KH006", name: "Ngô Thị F", daily: 54300000, monthly: 3000000 },
            { code: "KH007", name: "Đinh Văn G", daily: 43200000, monthly: 2000000 },
            { code: "KH008", name: "Bùi Thị H", daily: 32100000, monthly: 1000000 },
            { code: "KH009", name: "Vũ Văn I", daily: 21000000, monthly: 500000 },
            { code: "KH010", name: "Lý Thị K", daily: 10900000, monthly: 0 }
        ];

        // Dữ liệu mẫu cho Tiết kiệm
        const savingsData = [
            { code: "KH011", name: "Nguyễn Văn X", daily: 12000000, monthly: 9000000 },
            { code: "KH012", name: "Trần Thị Y", daily: 11000000, monthly: 8000000 },
            { code: "KH013", name: "Lê Văn Z", daily: 10000000, monthly: 7000000 },
            { code: "KH014", name: "Phạm Thị W", daily: 9000000, monthly: 6000000 },
            { code: "KH015", name: "Hoàng Văn V", daily: 8000000, monthly: 5000000 },
            { code: "KH016", name: "Ngô Thị U", daily: 7000000, monthly: 4000000 },
            { code: "KH017", name: "Đinh Văn T", daily: 6000000, monthly: 3000000 },
            { code: "KH018", name: "Bùi Thị S", daily: 5000000, monthly: 2000000 },
            { code: "KH019", name: "Vũ Văn R", daily: 4000000, monthly: 1000000 },
            { code: "KH020", name: "Lý Thị Q", daily: 3000000, monthly: 0 }
        ];

        // Dữ liệu mẫu cho Tổng Quan Khách Hàng
        const overviewData = {
            all: {
                private: {
                    total: [450, 1200, 1850, 1250, 550, 120],
                    active: [280, 850, 1450, 950, 380, 80],
                    new: [15, 45, 120, 80, 40, 20]
                },
                vip: {
                    total: [120, 350, 680, 420, 180, 50],
                    active: [90, 300, 580, 380, 150, 40],
                    new: [5, 15, 40, 30, 10, 5]
                }
            },
            new: {
                private: {
                    total: [15, 45, 120, 80, 40, 20],
                    active: [10, 35, 90, 60, 30, 15],
                    new: [15, 45, 120, 80, 40, 20]
                },
                vip: {
                    total: [5, 15, 40, 30, 10, 5],
                    active: [4, 12, 35, 25, 8, 4],
                    new: [5, 15, 40, 30, 10, 5]
                }
            }
        };

        // Dữ liệu mẫu cho Tỷ Lệ Sử Dụng SPDV
const products = [
    "Tài khoản thanh toán", 
    "Thẻ ghi nợ", 
    "Thẻ tín dụng", 
    "Tiết kiệm có kỳ hạn", 
    "Tiết kiệm không kỳ hạn",
    "Bảo hiểm nhân thọ",
    "Vay tiêu dùng",
    "Vay thế chấp",
    "Chuyển tiền nhanh",
    "Thanh toán hóa đơn"
];

const spdvData = {
    all: {
        private: {
            all: [4200, 3800, 3500, 3200, 2800, 2500, 1800, 1500, 4200, 3800],
            '0-18': [120, 100, 80, 60, 40, 30, 20, 15, 120, 100],
            '18-25': [850, 750, 650, 550, 400, 350, 250, 200, 850, 750],
            '25-35': [1450, 1300, 1200, 1000, 850, 700, 500, 400, 1450, 1300],
            '35-50': [950, 900, 850, 800, 750, 650, 450, 350, 950, 900],
            '50-60': [380, 350, 300, 250, 200, 180, 120, 100, 380, 350],
            '60+': [80, 70, 60, 50, 40, 35, 25, 20, 80, 70]
        },
        vip: {
            all: [1200, 1100, 950, 850, 750, 650, 500, 400, 1200, 1100],
            '0-18': [35, 30, 25, 20, 15, 10, 8, 5, 35, 30],
            '18-25': [300, 280, 250, 220, 180, 150, 100, 80, 300, 280],
            '25-35': [580, 550, 500, 450, 400, 350, 250, 200, 580, 550],
            '35-50': [380, 350, 300, 280, 250, 220, 180, 150, 380, 350],
            '50-60': [150, 140, 120, 100, 80, 70, 50, 40, 150, 140],
            '60+': [40, 35, 30, 25, 20, 18, 12, 10, 40, 35]
        }
    },
    new: {
        private: {
            all: [320, 280, 250, 220, 180, 150, 100, 80, 320, 280],
            '0-18': [15, 12, 10, 8, 6, 4, 3, 2, 15, 12],
            
            '18-25': [45, 40, 35, 30, 25, 20, 15, 12, 45, 40],
            '25-35': [120, 110, 100, 90, 80, 70, 50, 40, 120, 110],
            '35-50': [80, 75, 70, 65, 60, 55, 40, 30, 80, 75],
            '50-60': [40, 38, 35, 30, 25, 20, 15, 12, 40, 38],
            '60+': [20, 18, 15, 12, 10, 8, 5, 4, 20, 18]
        },
        vip: {
            all: [120, 110, 95, 85, 75, 65, 50, 40, 120, 110],
            '0-18': [5, 4, 3, 2, 1, 1, 1, 0, 5, 4],
            '18-25': [15, 14, 12, 10, 8, 7, 5, 4, 15, 14],
            '25-35': [40, 38, 35, 32, 30, 28, 20, 15, 40, 38],
            '35-50': [30, 28, 25, 22, 20, 18, 15, 12, 30, 28],
            '50-60': [10, 9, 8, 7, 6, 5, 4, 3, 10, 9],
            '60+': [5, 4, 3, 2, 2, 1, 1, 1, 5, 4]
        }
    }
};

        // Campaign Dashboard Data

const resultCampaignData = [
    { label: "Khách hàng quan tâm", value: 45 },
    { label: "Chưa liên hệ được", value: 30 },
    { label: "Khách hàng từ chối", value: 25 },
    { label: "MBV từ chối khách hàng", value: 15 },
    { label: "Khác", value: 10 },
    { label: "Khách hàng chưa có hoạt động", value: 15 }
];

const stageCampaignData = [
    { label: "Chưa tiếp cận", value: 30 },
    { label: "Đang tiếp cận", value: 40 },
    { label: "Chốt sale", value: 25 },
    { label: "Xử lý hồ sơ", value: 15 },
    { label: "Thành công", value: 20 },
    { label: "Không thành công", value: 10 }
];
const overviewCampaignData = {
    active: 12,
    expiring: 3,
    unassigned: 24
};

const rmPerformanceData = [
    { rm: "RM001 - Nguyễn Văn A", customers: 45, percentage: 32 },
    { rm: "RM002 - Trần Thị B", customers: 38, percentage: 27 },
    { rm: "RM003 - Lê Văn C", customers: 25, percentage: 18 },
    { rm: "RM004 - Phạm Thị D", customers: 20, percentage: 14 },
    { rm: "RM005 - Hoàng Văn E", customers: 12, percentage: 9 }
];

function loadCampaignDashboard() {
    loadCampaignOverview();
    loadResultCampaignChart();
    loadStageCampaignChart();

    // Dimension filter toggle
    const dimensionRadios = document.querySelectorAll('input[name="campaign-dimension"]');
    const rmFilter = document.getElementById('rmFilter');
    dimensionRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            rmFilter.classList.toggle('hidden', this.value !== 'rm');
            loadResultCampaignChart();
            loadStageCampaignChart();
        });
    });

    // Chart type toggle
    const pieChartBtn = document.getElementById('pieChartBtn');
    const barChartBtn = document.getElementById('barChartBtn');
    pieChartBtn.addEventListener('click', function() {
        this.classList.add('bg-blue-100', 'text-blue-600');
        this.classList.remove('bg-gray-100', 'text-gray-600');
        barChartBtn.classList.add('bg-gray-100', 'text-gray-600');
        barChartBtn.classList.remove('bg-blue-100', 'text-blue-600');
        loadResultCampaignChart('pie');
        loadStageCampaignChart('pie');
    });
    barChartBtn.addEventListener('click', function() {
        this.classList.add('bg-blue-100', 'text-blue-600');
        this.classList.remove('bg-gray-100', 'text-gray-600');
        pieChartBtn.classList.add('bg-gray-100', 'text-gray-600');
        pieChartBtn.classList.remove('bg-blue-100', 'text-blue-600');
        loadResultCampaignChart('bar');
        loadStageCampaignChart('bar');
    });

    // Dropdown functionality
    document.querySelectorAll('.dropdown').forEach(dropdown => {
        const button = dropdown.querySelector('button');
        const content = dropdown.querySelector('.dropdown-content');
        const items = content.querySelectorAll('div');
        
        button.addEventListener('click', () => {
            content.classList.toggle('hidden');
        });
        
        items.forEach(item => {
            item.addEventListener('click', () => {
                button.querySelector('span').textContent = item.textContent;
                content.classList.add('hidden');
                loadResultCampaignChart();
                loadStageCampaignChart();
            });
        });
        
        document.addEventListener('click', (e) => {
            if (!dropdown.contains(e.target)) {
                content.classList.add('hidden');
            }
        });
    });

    // Back to dashboard
    document.getElementById('backToDashboard').addEventListener('click', () => {
        document.getElementById('rmPerformance').classList.add('hidden');
        document.querySelector('.charts-section').classList.remove('hidden');
    });
}


function loadCampaignDashboard() {
    console.log('Loading Campaign Dashboard');
    document.querySelector('.charts-section').classList.remove('hidden');
    document.getElementById('rmPerformance').classList.add('hidden');

    console.log('Calling loadCampaignOverview');
    loadCampaignOverview();
    console.log('Calling loadResultCampaignChart');
    loadResultCampaignChart();
    console.log('Calling loadStageCampaignChart');
    loadStageCampaignChart();

    // Dimension filter toggle
    const dimensionRadios = document.querySelectorAll('input[name="campaign-dimension"]');
    const rmFilter = document.getElementById('rmFilter');
    dimensionRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            rmFilter.classList.toggle('hidden', this.value !== 'rm');
            loadResultCampaignChart();
            loadStageCampaignChart();
        });
    });

    // Chart type toggle
    const pieChartBtn = document.getElementById('pieChartBtn');
    const barChartBtn = document.getElementById('barChartBtn');
    pieChartBtn.addEventListener('click', function() {
        this.classList.add('bg-blue-100', 'text-blue-600');
        this.classList.remove('bg-gray-100', 'text-gray-600');
        barChartBtn.classList.add('bg-gray-100', 'text-gray-600');
        barChartBtn.classList.remove('bg-blue-100', 'text-blue-600');
        loadResultCampaignChart('pie');
        loadStageCampaignChart('pie');
    });
    barChartBtn.addEventListener('click', function() {
        this.classList.add('bg-blue-100', 'text-blue-600');
        this.classList.remove('bg-gray-100', 'text-gray-600');
        pieChartBtn.classList.add('bg-gray-100', 'text-gray-600');
        pieChartBtn.classList.remove('bg-blue-100', 'text-blue-600');
        loadResultCampaignChart('bar');
        loadStageCampaignChart('bar');
    });

    // Dropdown functionality
    document.querySelectorAll('.dropdown').forEach(dropdown => {
        const button = dropdown.querySelector('button');
        const content = dropdown.querySelector('.dropdown-content');
        const items = content.querySelectorAll('div');
        
        button.addEventListener('click', () => {
            content.classList.toggle('hidden');
        });
        
        items.forEach(item => {
            item.addEventListener('click', () => {
                button.querySelector('span').textContent = item.textContent;
                content.classList.add('hidden');
                loadResultCampaignChart();
                loadStageCampaignChart();
            });
        });
        
        document.addEventListener('click', (e) => {
            if (!dropdown.contains(e.target)) {
                content.classList.add('hidden');
            }
        });
    });

    // Back to dashboard
    document.getElementById('backToDashboard').addEventListener('click', () => {
        document.getElementById('rmPerformance').classList.add('hidden');
        document.querySelector('.charts-section').classList.remove('hidden');
    });
}

function loadResultCampaignChart(type = 'pie') {
    console.log('Initializing result-campaign-chart');
    const canvas = document.getElementById('result-campaign-chart');
    if (!canvas) {
        console.error('Canvas element not found');
        return;
    }
    
    const ctx = canvas.getContext('2d');
    if (resultCampaignChart) resultCampaignChart.destroy();

    resultCampaignChart = new Chart(ctx, {
        type: type,
        data: {
            labels: resultCampaignData.map(item => item.label),
            datasets: [{
                label: type === 'bar' ? 'Số lượng KH' : undefined,
                data: resultCampaignData.map(item => item.value),
                backgroundColor: ['#4F46E5', '#10B981', '#EF4444', '#F59E0B', '#8B5CF6', '#64748B'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: type === 'bar' ? {
                y: { beginAtZero: true }
            } : undefined,
            plugins: {
                legend: {
                    position: type === 'pie' ? 'right' : 'top'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const total = resultCampaignData.reduce((sum, item) => sum + item.value, 0);
                            const percentage = ((context.raw / total) * 100).toFixed(2);
                            return `${context.label}: ${context.raw} (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });
}
function loadStageCampaignChart(type = 'pie') {
    console.log('Initializing stage-campaign-chart');
    const dimension = document.querySelector('input[name="campaign-dimension"]:checked')?.value || 'branch';
    const branchDropdown = document.querySelector('.dropdown [data-value="all"]');
    const branch = branchDropdown 
        ? branchDropdown.parentElement.parentElement.previousElementSibling.querySelector('span')?.textContent.split(': ')[1] || 'Tất cả'
        : 'Tất cả';
    const rmElement = document.querySelector('#rmFilter:not(.hidden) .dropdown span');
    const rm = rmElement ? rmElement.textContent.split(': ')[1] : '';
    const campaignElement = document.querySelector('.dropdown:last-of-type span');
    const campaign = campaignElement ? campaignElement.textContent.split(': ')[1] : 'Tăng trưởng Q2';

    if (stageCampaignChart) stageCampaignChart.destroy();
    const canvas = document.getElementById('stage-campaign-chart');
    canvas.parentElement.style.display = 'block';
    const ctx = canvas.getContext('2d');
    const colors = ['#6366F1', '#3B82F6', '#10B981', '#F59E0B', '#8B5CF6', '#EF4444'];

    stageCampaignChart = new Chart(ctx, {
        type: type,
        data: {
            labels: stageCampaignData.map(item => item.label),
            datasets: [{
                label: type === 'bar' ? 'Số lượng KH' : undefined,
                data: stageCampaignData.map(item => item.value),
                backgroundColor: colors,
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: type === 'bar' ? {
                y: { beginAtZero: true }
            } : undefined,
            plugins: {
                legend: {
                    position: type === 'pie' ? 'right' : 'top'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const total = stageCampaignData.reduce((sum, item) => sum + item.value, 0);
                            const percentage = ((context.raw / total) * 100).toFixed(2);
                            return `${context.label}: ${context.raw} (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });
    stageCampaignChart.resize();
}

function showRmPerformance() {
    document.getElementById('rmPerformance').classList.remove('hidden');
    document.querySelector('.charts-section').classList.add('hidden');

    const tbody = document.getElementById('rm-performance-table-body');
    tbody.innerHTML = rmPerformanceData.map(item => `
        <tr class="hover:bg-gray-50 cursor-pointer">
            <td class="px-6 py-4 whitespace-nowrap">${item.rm}</td>
            <td class="px-6 py-4 whitespace-nowrap">${item.customers}</td>
            <td class="px-6 py-4 whitespace-nowrap">${item.percentage}%</td>
        </tr>
    `).join('');
}

        const ageGroups = ['0-18', '18-25', '25-35', '35-50', '50-60', 'Trên 60'];

        function loadDashboard() {
    const dashboardType = document.getElementById('dashboard-type').value;
    document.querySelectorAll('.dashboard-section').forEach(section => section.style.display = 'none');
    if (dashboardType === 'customer') {
        document.getElementById('customer-dashboard').style.display = 'block';
        loadCASAChart();
        loadSavingsChart();
        loadOverviewChart();
        loadSPDVChart();
    } else if (dashboardType === 'campaign') {
        document.getElementById('campaign-dashboard').style.display = 'block';
        loadCampaignDashboard();
    }

    const now = new Date();
    document.getElementById('last-updated').textContent = `Cập nhật: ${now.getHours()}:${now.getMinutes()} ${now.getDate()}/${now.getMonth() + 1}/${now.getFullYear()}`;
}
        function loadCASAChart(displayType = 'chart') {
            const changeType = document.querySelector('input[name="casa-change-type"]:checked').value;
            const timePeriod = document.querySelector('input[name="casa-time-period"]:checked').value;
            const count = parseInt(document.getElementById('casa-count').value);
            
            let filteredData = [...casaData];
            filteredData.sort((a, b) => timePeriod === 'daily' ? b.daily - a.daily : b.monthly - a.monthly);
            filteredData = filteredData.slice(0, count);

            if (changeType === 'decrease') {
                filteredData = filteredData.map(item => ({
                    ...item,
                    daily: -item.daily,
                    monthly: -item.monthly
                }));
            }

            const timeLabel = timePeriod === 'daily' ? 'ngày' : 'tháng';
            document.getElementById('casa-filter-summary').textContent = `Hiển thị top ${count} KH có biến động ${changeType === 'increase' ? 'tăng' : 'giảm'} CASA lớn nhất theo ${timeLabel}`;
            document.getElementById('casa-chart-filter-summary').textContent = `Biến động ${changeType === 'increase' ? 'tăng' : 'giảm'} theo ${timeLabel}`;
            document.getElementById('casa-table-filter-summary').textContent = `Biến động ${changeType === 'increase' ? 'tăng' : 'giảm'} theo ${timeLabel}`;

            if (displayType === 'chart') {
                document.getElementById('casa-chart-container').style.display = 'block';
                document.getElementById('casa-table-container').style.display = 'none';

                if (casaChart) casaChart.destroy();
                const ctx = document.getElementById('casa-chart').getContext('2d');
                casaChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: filteredData.map(item => item.name),
                        datasets: [{
                            label: `Biến động (${changeType === 'increase' ? 'tăng' : 'giảm'}) theo ${timeLabel}`,
                            data: filteredData.map(item => timePeriod === 'daily' ? Math.abs(item.daily) : Math.abs(item.monthly)),
                            backgroundColor: filteredData.map(() => changeType === 'increase' ? 'rgba(59, 130, 246, 0.7)' : 'rgba(239, 68, 68, 0.7)'),
                            borderColor: filteredData.map(() => changeType === 'increase' ? 'rgba(59, 130, 246, 1)' : 'rgba(239, 68, 68, 1)'),
                            borderWidth: 1
                        }]
                    },
                    options: {
                        indexAxis: 'y',
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            x: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return new Intl.NumberFormat('vi-VN').format(value) + ' VND';
                                    }
                                }
                            }
                        },
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return `${context.dataset.label}: ${new Intl.NumberFormat('vi-VN').format(context.raw)} VND`;
                                    }
                                }
                            }
                        },
                        onClick: (e, elements) => {
                            if (elements.length > 0) {
                                const index = elements[0].index;
                                const customer = filteredData[index];
                                window.location.href = `<?= base_url('customers/detail/') ?>${customer.code}`;
                            }
                        }
                    }
                });
            } else {
                document.getElementById('casa-chart-container').style.display = 'none';
                document.getElementById('casa-table-container').style.display = 'block';
                const tbody = document.getElementById('casa-table-body');
                tbody.innerHTML = filteredData.map((item, index) => `
                    <tr class="customer-row">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${index + 1}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-blue-600"><a href="<?= base_url('customers/detail/') ?>${item.code}">${item.code}</a></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${item.name}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm ${changeType === 'increase' ? 'text-green-600' : 'text-red-600'}">
                            ${changeType === 'increase' ? '+' : '-'}${new Intl.NumberFormat('vi-VN').format(timePeriod === 'daily' ? Math.abs(item.daily) : Math.abs(item.monthly))} VND
                        </td>
                    </tr>
                `).join('');
                document.querySelectorAll('#casa-table-body .customer-row').forEach(row => {
                    row.addEventListener('click', () => {
                        const code = row.cells[1].textContent;
                        window.location.href = `<?= base_url('customers/detail/') ?>${code}`;
                    });
                });
            }
        }

        function loadSavingsChart(displayType = 'chart') {
            const changeType = document.querySelector('input[name="savings-change-type"]:checked').value;
            const timePeriod = document.querySelector('input[name="savings-time-period"]:checked').value;
            const count = parseInt(document.getElementById('savings-count').value);
            
            let filteredData = [...savingsData];
            filteredData.sort((a, b) => timePeriod === 'daily' ? b.daily - a.daily : b.monthly - a.monthly);
            filteredData = filteredData.slice(0, count);

            if (changeType === 'decrease') {
                filteredData = filteredData.map(item => ({
                    ...item,
                    daily: -item.daily,
                    monthly: -item.monthly
                }));
            }

            const timeLabel = timePeriod === 'daily' ? 'ngày' : 'tháng';
            document.getElementById('savings-filter-summary').textContent = `Hiển thị top ${count} KH có biến động ${changeType === 'increase' ? 'tăng' : 'giảm'} Tiết kiệm lớn nhất theo ${timeLabel}`;
            document.getElementById('savings-chart-filter-summary').textContent = `Biến động ${changeType === 'increase' ? 'tăng' : 'giảm'} theo ${timeLabel}`;
            document.getElementById('savings-table-filter-summary').textContent = `Biến động ${changeType === 'increase' ? 'tăng' : 'giảm'} theo ${timeLabel}`;

            if (displayType === 'chart') {
                document.getElementById('savings-chart-container').style.display = 'block';
                document.getElementById('savings-table-container').style.display = 'none';

                if (savingsChart) savingsChart.destroy();
                const ctx = document.getElementById('savings-chart').getContext('2d');
                savingsChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: filteredData.map(item => item.name),
                        datasets: [{
                            label: `Biến động (${changeType === 'increase' ? 'tăng' : 'giảm'}) theo ${timeLabel}`,
                            data: filteredData.map(item => timePeriod === 'daily' ? Math.abs(item.daily) : Math.abs(item.monthly)),
                            backgroundColor: filteredData.map(() => changeType === 'increase' ? 'rgba(59, 130, 246, 0.7)' : 'rgba(239, 68, 68, 0.7)'),
                            borderColor: filteredData.map(() => changeType === 'increase' ? 'rgba(59, 130, 246, 1)' : 'rgba(239, 68, 68, 1)'),
                            borderWidth: 1
                        }]
                    },
                    options: {
                        indexAxis: 'y',
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            x: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return new Intl.NumberFormat('vi-VN').format(value) + ' VND';
                                    }
                                }
                            }
                        },
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return `${context.dataset.label}: ${new Intl.NumberFormat('vi-VN').format(context.raw)} VND`;
                                    }
                                }
                            }
                        },
                        onClick: (e, elements) => {
                            if (elements.length > 0) {
                                const index = elements[0].index;
                                const customer = filteredData[index];
                                window.location.href = `<?= base_url('customers/detail/') ?>${customer.code}`;
                            }
                        }
                    }
                });
            } else {
                document.getElementById('savings-chart-container').style.display = 'none';
                document.getElementById('savings-table-container').style.display = 'block';
                const tbody = document.getElementById('savings-table-body');
                tbody.innerHTML = filteredData.map((item, index) => `
                    <tr class="customer-row">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${index + 1}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-blue-600"><a href="<?= base_url('customers/detail/') ?>${item.code}">${item.code}</a></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${item.name}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm ${changeType === 'increase' ? 'text-green-600' : 'text-red-600'}">
                            ${changeType === 'increase' ? '+' : '-'}${new Intl.NumberFormat('vi-VN').format(timePeriod === 'daily' ? Math.abs(item.daily) : Math.abs(item.monthly))} VND
                        </td>
                    </tr>
                `).join('');
                document.querySelectorAll('#savings-table-body .customer-row').forEach(row => {
                    row.addEventListener('click', () => {
                        const code = row.cells[1].textContent;
                        window.location.href = `<?= base_url('customers/detail/') ?>${code}`;
                    });
                });
            }
        }

        function loadOverviewChart() {
    const group = document.getElementById('customer-group').value;
    const segment = document.getElementById('customer-segment').value;
    const filteredData = overviewData[group][segment];
    const dataTooltip = document.getElementById('overview-data-tooltip');

    if (overviewChart) overviewChart.destroy();
    const ctx = document.getElementById('overview-chart').getContext('2d');
    const totalCustomers = filteredData.total;
    const activeCustomers = filteredData.active;
    const activeRates = filteredData.active.map((val, i) => (val / totalCustomers[i] * 100).toFixed(2));

    overviewChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ageGroups,
            datasets: [
                {
                    label: 'Tổng số KH',
                    data: totalCustomers,
                    backgroundColor: 'rgba(59, 130, 246, 0.7)',
                    borderColor: 'rgba(59, 130, 246, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Số KH active',
                    data: activeCustomers,
                    backgroundColor: 'rgba(16, 185, 129, 0.7)',
                    borderColor: 'rgba(16, 185, 129, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value.toLocaleString('vi-VN');
                        }
                    }
                }
            },
            plugins: {
                // Tắt tooltip mặc định của Chart.js để dùng custom tooltip
                tooltip: {
                    enabled: false // Vô hiệu hóa tooltip mặc định
                }
            },
            onClick: (e) => {
                const points = overviewChart.getElementsAtEventForMode(e, 'nearest', { intersect: true }, true);
                if (points.length) {
                    const firstPoint = points[0];
                    const datasetIndex = firstPoint.datasetIndex;
                    const index = firstPoint.index;
                    const datasetLabel = overviewChart.data.datasets[datasetIndex].label;
                    const value = overviewChart.data.datasets[datasetIndex].data[index];
                    const ageGroup = overviewChart.data.labels[index];
                    alert(`Bạn đã chọn ${datasetLabel} của nhóm ${ageGroup}: ${value.toLocaleString('vi-VN')} KH`);
                }
            },
            onHover: (e, chartElements) => {
                e.native.target.style.cursor = chartElements.length ? 'pointer' : 'default'; // Thay đổi con trỏ chuột
                if (chartElements.length) {
                    const element = chartElements[0];
                    const datasetIndex = element.datasetIndex;
                    const index = element.index;
                    const datasetLabel = overviewChart.data.datasets[datasetIndex].label;
                    const value = overviewChart.data.datasets[datasetIndex].data[index];
                    const ageGroup = overviewChart.data.labels[index];

                    // Tính toán vị trí tooltip
                    const canvasPosition = Chart.helpers.getRelativePosition(e, overviewChart);
                    const x = canvasPosition.x + 10; // Dịch sang phải một chút để không che cột
                    const y = canvasPosition.y - 10; // Dịch lên trên để không che con trỏ

                    // Hiển thị tooltip tùy chỉnh
                    dataTooltip.style.display = 'block';
                    dataTooltip.style.left = `${x}px`;
                    dataTooltip.style.top = `${y}px`;
                    dataTooltip.innerHTML = `
                        <div><strong>${ageGroup}</strong></div>
                        <div>${datasetLabel}: ${value.toLocaleString('vi-VN')}</div>
                        ${datasetIndex === 0 ? `<div>Tỷ lệ active: ${activeRates[index]}%</div>` : ''}
                    `;
                } else {
                    dataTooltip.style.display = 'none';
                }
            }
        }
    });

    // Update summary cards
    const totalSum = totalCustomers.reduce((a, b) => a + b, 0);
    const activeSum = activeCustomers.reduce((a, b) => a + b, 0);
    const activeRate = (activeSum / totalSum * 100).toFixed(2);
    const newSum = filteredData.new.reduce((a, b) => a + b, 0);
    document.getElementById('total-customers').textContent = totalSum.toLocaleString('vi-VN');
    document.getElementById('total-active').textContent = activeSum.toLocaleString('vi-VN');
    document.getElementById('active-rate').textContent = `${activeRate}%`;
    document.getElementById('new-customers').textContent = newSum.toLocaleString('vi-VN');

    // Update table
    const tableBody = document.getElementById('overview-table-body');
    tableBody.innerHTML = '';
    ageGroups.forEach((ageGroup, index) => {
        const row = document.createElement('tr');
        row.className = 'hover:bg-gray-50';
        row.innerHTML = `
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${ageGroup}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${totalCustomers[index].toLocaleString('vi-VN')}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${activeCustomers[index].toLocaleString('vi-VN')}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium ${activeRates[index] > 70 ? 'text-green-600' : activeRates[index] > 50 ? 'text-yellow-600' : 'text-red-600'}">
                ${activeRates[index]}%
            </td>
        `;
        tableBody.appendChild(row);
    });

    // Update filter summaries
    const groupText = group === 'all' ? 'tất cả nhóm KH' : 'KH mới 1 tháng';
    const segmentText = segment === 'private' ? 'Private' : 'VIP';
    document.getElementById('overview-filter-summary').textContent = `Hiển thị tổng quan khách hàng cho ${groupText} phân khúc ${segmentText}`;
    document.getElementById('overview-chart-filter-summary').textContent = `${group === 'all' ? 'Tất cả KH' : 'KH mới'} - ${segmentText}`;
}

function loadSPDVChart() {
    const customerGroup = document.getElementById('spdv-group').value;
    const customerSegment = document.getElementById('spdv-segment').value;
    const ageGroup = document.getElementById('spdv-age').value;
    
    const filteredData = spdvData[customerGroup][customerSegment][ageGroup];
    const dataTooltip = document.getElementById('spdv-data-tooltip');
    
    // Color palette for products
    const productColors = [
        '#3B82F6', '#10B981', '#F59E0B', '#6366F1', 
        '#EC4899', '#14B8A6', '#F97316', '#8B5CF6',
        '#EF4444', '#84CC16'
    ];
    
    // Update chart
    if (spdvChart) spdvChart.destroy();
    const ctx = document.getElementById('spdv-chart').getContext('2d');
    
    // Calculate total customers for rate calculation
    const totalCustomers = filteredData.reduce((a, b) => a + b, 0);
    const usageRates = filteredData.map(val => (val / totalCustomers * 100).toFixed(2));
    
    spdvChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: products,
            datasets: [{
                data: filteredData,
                backgroundColor: productColors,
                borderColor: '#fff',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right',
                    labels: {
                        boxWidth: 12,
                        padding: 20,
                        font: {
                            size: 11
                        }
                    }
                },
                tooltip: {
                    enabled: false // Use custom tooltip
                }
            },
            onClick: (e) => {
                const points = spdvChart.getElementsAtEventForMode(
                    e, 'nearest', { intersect: true }, true
                );
                if (points.length) {
                    const firstPoint = points[0];
                    const index = firstPoint.index;
                    const product = spdvChart.data.labels[index];
                    const value = spdvChart.data.datasets[0].data[index];
                    const rate = usageRates[index];
                    alert(`Bạn đã chọn sản phẩm ${product}: ${value.toLocaleString('vi-VN')} KH (${rate}%)`);
                }
            },
            onHover: () => {
                // Không làm gì khi hover
            }
        }
    });
    
    // Update product list
    const productList = document.getElementById('spdv-product-list');
    productList.innerHTML = '';
    products.forEach((product, index) => {
        const li = document.createElement('li');
        li.className = 'flex items-center';
        li.innerHTML = `
            <span class="inline-block w-3 h-3 rounded-full mr-2" style="background-color: ${productColors[index]}"></span>
            <span class="text-sm font-medium text-gray-700">${product}</span>
            <span class="ml-auto text-sm font-medium text-gray-900">${usageRates[index]}%</span>
        `;
        productList.appendChild(li);
    });
    
    // Update table
    const tableBody = document.getElementById('spdv-table-body');
    tableBody.innerHTML = '';
    const maxRate = Math.max(...usageRates.map(rate => parseFloat(rate)));
    products.forEach((product, index) => {
        const row = document.createElement('tr');
        row.className = 'hover:bg-gray-50';
        const trend = Math.random() > 0.5 ? 'up' : 'down';
        const trendColor = trend === 'up' ? 'text-green-600' : 'text-red-600';
        const trendIcon = trend === 'up' ? 'fa-arrow-up' : 'fa-arrow-down';
        row.innerHTML = `
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${product}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${filteredData[index].toLocaleString('vi-VN')}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium ${usageRates[index] == maxRate ? 'text-purple-600' : 'text-gray-700'}">
                ${usageRates[index]}%
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm ${trendColor}">
                <i class="fas ${trendIcon} mr-1"></i> ${trend === 'up' ? 'Tăng' : 'Giảm'}
            </td>
        `;
        tableBody.appendChild(row);
    });
    
    // Update summary cards
    const totalSum = filteredData.reduce((a, b) => a + b, 0);
    let maxRateValue = 0;
    let topProduct = '';
    usageRates.forEach((rate, index) => {
        if (parseFloat(rate) > maxRateValue) {
            maxRateValue = parseFloat(rate);
            topProduct = products[index];
        }
    });
    document.getElementById('spdv-total-customers').textContent = totalSum.toLocaleString('vi-VN');
    document.getElementById('spdv-top-product').textContent = topProduct;
    document.getElementById('spdv-top-rate').textContent = `${maxRateValue}%`;
    
    // Update filter summaries
    const groupText = customerGroup === 'all' ? 'tất cả nhóm KH' : 'KH mới 1 tháng';
    const segmentText = customerSegment === 'private' ? 'Private' : 'VIP';
    const ageText = ageGroup === 'all' ? 'tất cả nhóm tuổi' : `nhóm tuổi ${ageGroup}`;
    document.getElementById('spdv-filter-summary').textContent = `Hiển thị tỷ lệ sử dụng SPDV cho ${groupText}, phân khúc ${segmentText}, ${ageText}`;
    document.getElementById('spdv-chart-filter-summary').textContent = 
        `${customerGroup === 'all' ? 'Tất cả KH' : 'KH mới'} - ${segmentText} - ${ageGroup === 'all' ? 'Tất cả nhóm tuổi' : ageGroup}`;
}
        function switchCampaignTab(tabId) {
            document.querySelectorAll('.campaign-tab-pane').forEach(pane => pane.style.display = 'none');
            document.getElementById(tabId).style.display = 'block';
            document.querySelectorAll('#campaign-dashboard .flex.border-b button').forEach(btn => {
                btn.classList.remove('tab-active');
                btn.classList.add('text-gray-600', 'hover:text-blue-600');
            });
            const activeBtn = Array.from(document.querySelectorAll('#campaign-dashboard .flex.border-b button')).find(btn => btn.onclick.toString().includes(tabId));
            activeBtn.classList.add('tab-active');
            activeBtn.classList.remove('text-gray-600', 'hover:text-blue-600');
        }

        function loadCampaignOverview() {
            document.getElementById('active-campaigns').textContent = overviewCampaignData.active;
            document.getElementById('expiring-campaigns').textContent = overviewCampaignData.expiring;
            document.getElementById('unassigned-customers').textContent = overviewCampaignData.unassigned;
        }

        function loadResultCampaignChart(displayType = 'chart') {
            const dimension = document.querySelector('input[name="campaign-dimension"]:checked').value;
            const branch = document.getElementById('campaign-branch').value;
            const rm = document.getElementById('campaign-rm').value;
            const campaign = document.getElementById('campaign-list').value;

            if (displayType === 'chart') {
                document.getElementById('result-campaign-chart').style.display = 'block';
                document.getElementById('result-campaign-table').style.display = 'none';

                if (resultCampaignChart) resultCampaignChart.destroy();
                const ctx = document.getElementById('result-campaign-chart').getContext('2d');
                resultCampaignChart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: resultCampaignData.map(item => item.label),
                        datasets: [{
                            data: resultCampaignData.map(item => item.value),
                            backgroundColor: ['#28a745', '#ffc107', '#dc3545', '#6f42c1', '#17a2b8', '#adb5bd']
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const total = resultCampaignData.reduce((sum, item) => sum + item.value, 0);
                                        const percentage = ((context.raw / total) * 100).toFixed(2);
                                        return `${context.label}: ${context.raw} (${percentage}%)`;
                                    }
                                }
                            }
                        },
                        onClick: (e, elements) => {
                            if (elements.length > 0) {
                                const index = elements[0].index;
                                const label = resultCampaignData[index].label;
                                window.location.href = `<?= base_url('campaigns/detail/') ?>${label}`;
                            }
                        }
                    }
                });
            } else {
                document.getElementById('result-campaign-chart').style.display = 'none';
                document.getElementById('result-campaign-table').style.display = 'block';
                const tbody = document.getElementById('result-campaign-table-body');
                const total = resultCampaignData.reduce((sum, item) => sum + item.value, 0);
                tbody.innerHTML = resultCampaignData.map((item, index) => `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${item.label}</td>
                        <td>${item.value}</td>
                        <td>${((item.value / total) * 100).toFixed(2)}%</td>
                    </tr>
                `).join('');
            }
        }

        function loadStageCampaignChart(displayType = 'chart') {
            const dimension = document.querySelector('input[name="campaign-dimension"]:checked').value;
            const branch = document.getElementById('campaign-branch').value;
            const rm = document.getElementById('campaign-rm').value;
            const campaign = document.getElementById('campaign-list').value;

            if (displayType === 'chart') {
                document.getElementById('stage-campaign-chart').style.display = 'block';
                document.getElementById('stage-campaign-table').style.display = 'none';

                if (stageCampaignChart) stageCampaignChart.destroy();
                const ctx = document.getElementById('stage-campaign-chart').getContext('2d');
                stageCampaignChart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: stageCampaignData.map(item => item.label),
                        datasets: [{
                            data: stageCampaignData.map(item => item.value),
                            backgroundColor: ['#007bff', '#28a745', '#dc3545', '#ffc107', '#6f42c1', '#adb5bd']
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const total = stageCampaignData.reduce((sum, item) => sum + item.value, 0);
                                        const percentage = ((context.raw / total) * 100).toFixed(2);
                                        return `${context.label}: ${context.raw} (${percentage}%)`;
                                    }
                                }
                            }
                        },
                        onClick: (e, elements) => {
                            if (elements.length > 0) {
                                const index = elements[0].index;
                                const label = stageCampaignData[index].label;
                                window.location.href = `<?= base_url('campaigns/stage/') ?>${label}`;
                            }
                        }
                    }
                });
            } else {
                document.getElementById('stage-campaign-chart').style.display = 'none';
                document.getElementById('stage-campaign-table').style.display = 'block';
                const tbody = document.getElementById('stage-campaign-table-body');
                const total = stageCampaignData.reduce((sum, item) => sum + item.value, 0);
                tbody.innerHTML = stageCampaignData.map((item, index) => `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${item.label}</td>
                        <td>${item.value}</td>
                        <td>${((item.value / total) * 100).toFixed(2)}%</td>
                    </tr>
                `).join('');
            }
        }
        
        // Event listeners for CASA filters and view toggles
        document.querySelectorAll('input[name="casa-change-type"], input[name="casa-time-period"]').forEach(input => {
            input.addEventListener('change', () => loadCASAChart());
        });
        document.getElementById('casa-count').addEventListener('change', () => loadCASAChart());
        document.getElementById('casa-chart-view-btn').addEventListener('click', () => {
            document.getElementById('casa-chart-view-btn').classList.remove('bg-gray-200', 'text-gray-700');
            document.getElementById('casa-chart-view-btn').classList.add('bg-blue-600', 'text-white');
            document.getElementById('casa-table-view-btn').classList.remove('bg-blue-600', 'text-white');
            document.getElementById('casa-table-view-btn').classList.add('bg-gray-200', 'text-gray-700');
            loadCASAChart('chart');
        });
        document.getElementById('casa-table-view-btn').addEventListener('click', () => {
            document.getElementById('casa-table-view-btn').classList.remove('bg-gray-200', 'text-gray-700');
            document.getElementById('casa-table-view-btn').classList.add('bg-blue-600', 'text-white');
            document.getElementById('casa-chart-view-btn').classList.remove('bg-blue-600', 'text-white');
            document.getElementById('casa-chart-view-btn').classList.add('bg-gray-200', 'text-gray-700');
            loadCASAChart('table');
        });

        // Event listeners for Savings filters and view toggles
        document.querySelectorAll('input[name="savings-change-type"], input[name="savings-time-period"]').forEach(input => {
            input.addEventListener('change', () => loadSavingsChart());
        });
        document.getElementById('savings-count').addEventListener('change', () => loadSavingsChart());
        document.getElementById('savings-chart-view-btn').addEventListener('click', () => {
            document.getElementById('savings-chart-view-btn').classList.remove('bg-gray-200', 'text-gray-700');
            document.getElementById('savings-chart-view-btn').classList.add('bg-blue-600', 'text-white');
            document.getElementById('savings-table-view-btn').classList.remove('bg-blue-600', 'text-white');
            document.getElementById('savings-table-view-btn').classList.add('bg-gray-200', 'text-gray-700');
            loadSavingsChart('chart');
        });
        document.getElementById('savings-table-view-btn').addEventListener('click', () => {
            document.getElementById('savings-table-view-btn').classList.remove('bg-gray-200', 'text-gray-700');
            document.getElementById('savings-table-view-btn').classList.add('bg-blue-600', 'text-white');
            document.getElementById('savings-chart-view-btn').classList.remove('bg-blue-600', 'text-white');
            document.getElementById('savings-chart-view-btn').classList.add('bg-gray-200', 'text-gray-700');
            loadSavingsChart('table');
        });
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle RM filter based on dimension selection
            const dimensionRadios = document.querySelectorAll('input[name="dimension"]');
            const rmFilter = document.getElementById('rmFilter');
            
            dimensionRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.value === 'rm') {
                        rmFilter.classList.remove('hidden');
                    } else {
                        rmFilter.classList.add('hidden');
                    }
                });
            });

            // Chart type toggle
            const pieChartBtn = document.getElementById('pieChartBtn');
            const barChartBtn = document.getElementById('barChartBtn');
            
            pieChartBtn.addEventListener('click', function() {
                this.classList.add('bg-blue-100', 'text-blue-600');
                this.classList.remove('bg-gray-100', 'text-gray-600');
                barChartBtn.classList.add('bg-gray-100', 'text-gray-600');
                barChartBtn.classList.remove('bg-blue-100', 'text-blue-600');
                updateCharts('pie');
            });
            
            barChartBtn.addEventListener('click', function() {
                this.classList.add('bg-blue-100', 'text-blue-600');
                this.classList.remove('bg-gray-100', 'text-gray-600');
                pieChartBtn.classList.add('bg-gray-100', 'text-gray-600');
                pieChartBtn.classList.remove('bg-blue-100', 'text-blue-600');
                updateCharts('bar');
            });

            // Initialize charts
            const resultCtx = document.getElementById('resultChart').getContext('2d');
            const stageCtx = document.getElementById('stageChart').getContext('2d');
            
            let resultChart, stageChart;
            
            function createPieChart(ctx, data, colors) {
                return new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            data: data.values,
                            backgroundColor: colors,
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'right',
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const label = context.label || '';
                                        const value = context.raw || 0;
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const percentage = Math.round((value / total) * 100);
                                        return `${label}: ${value} (${percentage}%)`;
                                    }
                                }
                            }
                        },
                        onClick: function(evt, elements) {
                            if (elements.length > 0) {
                                showRmPerformance();
                            }
                        }
                    }
                });
            }
            
            function createBarChart(ctx, data, colors) {
                return new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            label: 'Số lượng KH',
                            data: data.values,
                            backgroundColor: colors,
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        },
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const label = context.dataset.label || '';
                                        const value = context.raw || 0;
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const percentage = Math.round((value / total) * 100);
                                        return `${label}: ${value} (${percentage}%)`;
                                    }
                                }
                            }
                        },
                        onClick: function(evt, elements) {
                            if (elements.length > 0) {
                                showRmPerformance();
                            }
                        }
                    }
                });
            }
            
            function updateCharts(type) {
                // Destroy existing charts if they exist
                if (resultChart) resultChart.destroy();
                if (stageChart) stageChart.destroy();
                
                // Result data
                const resultData = {
                    labels: ['Khách hàng quan tâm', 'Chưa liên hệ được', 'Khách hàng từ chối', 'MBV từ chối KH', 'Khác', 'Chưa có hoạt động'],
                    values: [45, 30, 25, 15, 10, 15]
                };
                
                const resultColors = ['#4F46E5', '#10B981', '#EF4444', '#F59E0B', '#8B5CF6', '#64748B'];
                
                // Stage data
                const stageData = {
                    labels: ['Chưa tiếp cận', 'Đang tiếp cận', 'Chốt sale', 'Xử lý hồ sơ', 'Thành công', 'Không thành công'],
                    values: [30, 40, 25, 15, 20, 10]
                };
                
                const stageColors = ['#6366F1', '#3B82F6', '#10B981', '#F59E0B', '#8B5CF6', '#EF4444'];
                
                // Create new charts based on selected type
                if (type === 'pie') {
                    resultChart = createPieChart(resultCtx, resultData, resultColors);
                    stageChart = createPieChart(stageCtx, stageData, stageColors);
                } else {
                    resultChart = createBarChart(resultCtx, resultData, resultColors);
                    stageChart = createBarChart(stageCtx, stageData, stageColors);
                }
            }
            
            // Initialize with pie charts
            updateCharts('pie');
            
            // Show RM performance table
            function showRmPerformance() {
                document.getElementById('rmPerformance').classList.remove('hidden');
                document.querySelector('.grid-cols-1.lg\\:grid-cols-2').classList.add('hidden');
            }
            
            // Back to dashboard
            document.getElementById('backToDashboard').addEventListener('click', function() {
                document.getElementById('rmPerformance').classList.add('hidden');
                document.querySelector('.grid-cols-1.lg\\:grid-cols-2').classList.remove('hidden');
            });
            
            // Dropdown functionality
            document.querySelectorAll('.dropdown').forEach(dropdown => {
                const button = dropdown.querySelector('button');
                const content = dropdown.querySelector('.dropdown-content');
                
                // Close when clicking outside
                document.addEventListener('click', function(event) {
                    if (!dropdown.contains(event.target)) {
                        content.style.display = 'none';
                    }
                });
                
                // Toggle on button click
                button.addEventListener('click', function(e) {
                    e.stopPropagation();
                    if (content.style.display === 'block') {
                        content.style.display = 'none';
                    } else {
                        content.style.display = 'block';
                    }
                });
                
                // Select item
                content.querySelectorAll('div').forEach(item => {
                    item.addEventListener('click', function() {
                        button.querySelector('span').textContent = this.textContent;
                        content.style.display = 'none';
                    });
                });
            });
        });
        // Event listeners for Overview filters
        document.getElementById('customer-group').addEventListener('change', loadOverviewChart);
        document.getElementById('customer-segment').addEventListener('change', loadOverviewChart);
        // Event listeners for SPDV filters
document.getElementById('spdv-group').addEventListener('change', loadSPDVChart);
document.getElementById('spdv-segment').addEventListener('change', loadSPDVChart);
document.getElementById('spdv-age').addEventListener('change', loadSPDVChart);
        // Load mặc định
        document.addEventListener('DOMContentLoaded', () => {
            loadDashboard();
        });
    </script>

    <?php include('include-js.php'); ?>
</body>
</html>
