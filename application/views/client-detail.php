<?php
// client-detail.php

// Lấy toàn bộ URL từ biến $_SERVER['REQUEST_URI']
$uri = $_SERVER['REQUEST_URI'];

/* // In ra toàn bộ URL để kiểm tra
echo "URL hiện tại: " . htmlspecialchars($uri) . "<br>"; */

// Phân tách URL bằng dấu '/'
$path_parts = explode('/', $uri);

/* // In ra tất cả các phần tách được từ URL để kiểm tra
echo "Các phần trong URL: <br>";
print_r($path_parts);  // In ra tất cả các phần của URL đã phân tách */

// Kiểm tra nếu có ít nhất 4 phần trong URL (index.php/clients/detail/MaKH)
if (isset($path_parts[5])) {
    // MaKH nằm ở phần thứ 4 trong URL (0-indexed)
    $maKH = $path_parts[5];
    
    /* // In ra giá trị MaKH để kiểm tra
    echo "Mã khách hàng (MaKH) từ URL: " . htmlspecialchars($maKH) . "<br>"; */
    
    // Kết nối cơ sở dữ liệu (thay đổi thông tin kết nối của bạn)
    $conn = new mysqli("localhost", "root", "", "crm");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Truy vấn thông tin chi tiết khách hàng dựa trên MaKH
    $sql = "SELECT * FROM client WHERE MaKH = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die('MySQL prepare error: ' . $conn->error);
    }

    // Liên kết tham số và thực thi câu truy vấn
    $stmt->bind_param("s", $maKH); // "s" là kiểu chuỗi cho MaKH
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Lấy thông tin chi tiết khách hàng
        $client_details = $result->fetch_assoc();
    } else {
        $client_details = null;
    }

    // Đóng kết nối
    $stmt->close();
    $conn->close();
} else {
    echo "Không có tham số MaKH trong URL.";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Quản lý KHHH</title>
    <?php include('include-css.php'); ?>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .tab-disabled {
            opacity: 0.5;
            pointer-events: none;
        }
        .tab-enabled {
            position: relative;
        }
        .tab-enabled::after {
            content: attr(data-count);
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: #3b82f6;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
        }
        .modal {
            transition: opacity 0.3s ease;
        }
        .modal-content {
            max-height: 80vh;
            overflow-y: auto;
        }
        .highlight-row {
            background-color: #f0f9ff;
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
                    <h1>Quản lý Khách hàng hiện hữu/ Thông tin khách hàng</h1>
                    <div class="section-header-breadcrumb">
                    <?php if (check_permissions("clients", "update")) { ?>
                          <button class="btn btn-primary btn-rounded no-shadow" id="modal-edit-client" style="margin-right: 10px;">
                            <i class="fas fa-pen"></i>
                          </button>
                          <?php } ?>
                          <button class="btn btn-secondary btn-rounded no-shadow" id="modal-delete-client">
                            <i class="fas fa-trash"></i>
                          </button>
                    </div>
                </div>

            <div class="section-body">
        <!-- Customer Information Section -->
        <div class="content">
            <!-- Customer Detailed Information Section -->
            <div class="card">
              <div class="card-body">
                <h5 style= "margin-bottom: 40px;">Thông tin khách hàng</h5>
                <div class="row">
                  <div class="col-md-6">
                    <!-- Table 1: Information about the client -->
                    <table class="profile-table w-75" style="width: 100%; margin-bottom: 10px;">
                      <tr>
                        <td style="color:rgba(87, 12, 14, 0.68)" class="font-weight-600">Tên khách hàng</td>
                        <td class="text-muted d-inline font-weight-normal"><?= htmlspecialchars($client_details['TenKH']); ?></td>
                      </tr>
                      <tr>
                        <td style="color:rgba(87, 12, 14, 0.68)" class="font-weight-600">Điện thoại di động</td>
                        <td class="text-muted d-inline font-weight-normal"><?= htmlspecialchars($client_details['SDT']); ?></td>
                      </tr>
                      <tr>
                        <td style="color:rgba(87, 12, 14, 0.68)" class="font-weight-600">Quốc tịch</td>
                        <td class="text-muted d-inline font-weight-normal"><?= htmlspecialchars($client_details['Quoctich']); ?></td>
                      </tr>
                    </table>
                  </div>
                  <div class="col-md-6">
                    <!-- Table 2: More detailed information -->
                    <table class="profile-table w-75" style="width: 100%;">
                      <tr>
                        <td style="color:rgba(87, 12, 14, 0.68)" class="font-weight-600">Email</td>
                        <td class="text-muted d-inline font-weight-normal"><?= htmlspecialchars($client_details['Email']); ?></td>
                      </tr>
                      <tr>
                        <td style="color:rgba(87, 12, 14, 0.68)" class="font-weight-600">Ngày sinh</td>
                        <td class="text-muted d-inline font-weight-normal"><?= htmlspecialchars($client_details['Ngaysinh']); ?></td>
                      </tr>
                      <tr>
                        <td style="color:rgba(87, 12, 14, 0.68)" class="font-weight-600">Ngày mở code</td>
                        <td class="text-muted d-inline font-weight-normal"><?= htmlspecialchars($client_details['Ngayupload']); ?></td>
                      </tr>
                    </table>
                  </div>
                </div>

                <h6 style = "margin-top: 20px">Giấy tờ tùy thân</h6>  
                  <div class="row">
                    <div class="col-md-6">
                      <!-- Table 1: Information about the client -->
                      <table class="profile-table w-75" style="width: 100%;">
                        <tr>
                          <td style="color:rgba(87, 12, 14, 0.68)" class="font-weight-600">Số CMT/hộ chiếu</td>
                          <td><?= htmlspecialchars($client_details['CMT/Hochieu']); ?></td>
                        </tr>
                        <tr>
                          <td style="color:rgba(87, 12, 14, 0.68)" class="font-weight-600">Ngày cấp</td>
                          <td><?= htmlspecialchars($client_details['Ngaycap']); ?></td>
                        </tr>
                      </table>
                    </div>
                    <div class="col-md-6">
                      <!-- Table 2: More detailed information -->
                      <table class="profile-table w-75" style="width: 100%;">
                        <tr>
                          <td style="color:rgba(87, 12, 14, 0.68)" class="font-weight-600">Quốc tịch</td>
                          <td><?= htmlspecialchars($client_details['Quoctich']); ?></td>
                        </tr>
                        <tr>
                          <td style="color:rgba(87, 12, 14, 0.68)" class="font-weight-600">Nơi cấp</td>
                          <td><?= htmlspecialchars($client_details['Noicap']); ?></td>
                        </tr>
                      </table>
                    </div>
                  </div>
                  <h6 style = "margin-top: 20px">Nghề nghiệp và thu nhập</h6>  
                  <div class="row">
                    <div class="col-md-6">
                      <!-- Table 1: Information about the client -->
                      <table class="profile-table w-75" style="width: 100%;">
                        <tr>
                          <td style="color:rgba(87, 12, 14, 0.68)" class="font-weight-600">Nghề nghiệp</td>
                          <td><?= htmlspecialchars($client_details['Nghenghiep']); ?></td>
                        </tr>
                      </table>
                    </div>
                    <div class="col-md-6">
                      <!-- Table 2: More detailed information -->
                      <table class="profile-table w-75" style="width: 100%;">
                        <tr>
                          <td style="color:rgba(87, 12, 14, 0.68)" class="font-weight-600">Thu nhập</td>
                          <td ><?= htmlspecialchars($client_details['Thunhap']); ?></td>
                        </tr>
                      </table>
                    </div>
                  </div>
                  <h6 style = "margin-top: 20px">Hoạt động</h6>  
                  <div class="row">
                    <div class="col-md-6">
                      <!-- Table 1: Information about the client -->
                      <table class="profile-table w-75" style="width: 100%;">
                        <tr>
                          <td style="color:rgba(87, 12, 14, 0.68)" class="font-weight-600">Trạng thái</td>
                          <td><?= htmlspecialchars($client_details['Trangthai']); ?></td>
                        </tr>
                      </table>
                    </div>
                    <div class="col-md-6">
                      <!-- Table 2: More detailed information -->
                      <table class="profile-table w-75" style="width: 100%;">
                        <tr>
                          <td style="color:rgba(87, 12, 14, 0.68)" class="font-weight-600">Tần suất giao dịch</td>
                          <td><?= htmlspecialchars($client_details['Tansuatgiaodich']); ?></td>
                        </tr>
                      </table>
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
                                                <?php foreach ($system_modules as $module => $client_permissions_data) : ?>
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
                                                            </td>
                                                    <?php }
                                                    } ?>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" id="submit_button_update" class="btn btn-primary"><?= !empty($this->lang->line('label_save')) ? $this->lang->line('label_save') : 'Save'; ?></button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                <!-- Form sửa KHHH  -->
                <?php if (check_permissions("clients", "update")) { ?>
                    <div class="card mt-4">
                        <div class="card-body">
                        <?= form_open('auth/edit_user', 'id="modal-add-user-part"', 'class="modal-part"'); ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div id="modal-title" class="d-none">Sửa thông tin khách hàng</div>
                                <div id="modal-footer-add-title" class="d-none">Lưu</div>
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
                        </form>
                      </div>
                  </div>
              <?php } ?>

              <!-- Form xóa KHHH  -->
              <?php if (check_permissions("clients", "delete")) { ?>
                  <div class="card mt-4">
                      <div class="card-body">
                      <?= form_open('auth/edit_user', 'id="modal-add-user-part"', 'class="modal-part"'); ?>
                      <p class="text-gray-700 mb-6">Bạn có chắc chắn muốn xóa thông tin khách hàng này không?</p>
                      </form>
                      </div>
                  </div>
              <?php } ?> 
            </div>     
            
<!-- TAB  -->            
            <div class="card">
              <div class="card-body">
                <h5 style= "margin-bottom: 40px;">Danh sách sản phẩm </h5>
                
<!-- Product Tabs -->
<div class="bg-white rounded-lg shadow-md p-4 mb-6">
            <div class="flex flex-wrap gap-4 mb-6">
                <button id="payment-account-tab" class="tab-enabled px-4 py-2 rounded-lg bg-blue-100 text-blue-800 font-medium flex items-center" data-count="2">
                    <i class="fas fa-wallet mr-2"></i>Tài khoản thanh toán
                </button>
                <button id="saving-account-tab" class="tab-enabled px-4 py-2 rounded-lg bg-green-100 text-green-800 font-medium flex items-center" data-count="3">
                    <i class="fas fa-piggy-bank mr-2"></i>Tiết kiệm
                </button>
                <button id="credit-tab" class="tab-enabled px-4 py-2 rounded-lg bg-purple-100 text-purple-800 font-medium flex items-center" data-count="1">
                    <i class="fas fa-hand-holding-usd mr-2"></i>Tín dụng
                </button>
                <button id="guarantee-tab" class="tab-enabled px-4 py-2 rounded-lg bg-yellow-100 text-yellow-800 font-medium flex items-center" data-count="2">
                    <i class="fas fa-file-signature mr-2"></i>Bảo lãnh
                </button>
                <button id="bond-tab" class="tab-disabled px-4 py-2 rounded-lg bg-gray-100 text-gray-500 font-medium flex items-center">
                    <i class="fas fa-certificate mr-2"></i>Trái phiếu
                </button>
                <button id="trade-finance-tab" class="tab-disabled px-4 py-2 rounded-lg bg-gray-100 text-gray-500 font-medium flex items-center">
                    <i class="fas fa-exchange-alt mr-2"></i>Tài trợ thương mại
                </button>
                <button id="card-tab" class="tab-enabled px-4 py-2 rounded-lg bg-red-100 text-red-800 font-medium flex items-center" data-count="1">
                    <i class="fas fa-credit-card mr-2"></i>Thẻ
                </button>
                <button id="ebanking-tab" class="tab-enabled px-4 py-2 rounded-lg bg-indigo-100 text-indigo-800 font-medium flex items-center" data-count="1">
                    <i class="fas fa-globe mr-2"></i>Ebanking
                </button>
                <button id="sms-tab" class="tab-disabled px-4 py-2 rounded-lg bg-gray-100 text-gray-500 font-medium flex items-center">
                    <i class="fas fa-sms mr-2"></i>SMS
                </button>
            </div>

            <!-- Summary Info -->
            <div class="bg-blue-50 rounded-lg p-4 mb-6">
                <div class="grid grid-cols-4 gap-4">
                    <div class="bg-white p-3 rounded-lg shadow-sm">
                        <div class="text-gray-500 text-sm">Tổng số sản phẩm</div>
                        <div class="text-2xl font-bold text-blue-600">10</div>
                    </div>
                    <div class="bg-white p-3 rounded-lg shadow-sm">
                        <div class="text-gray-500 text-sm">Tổng dư nợ</div>
                        <div class="text-2xl font-bold text-blue-600">1,245,000,000 VND</div>
                    </div>
                    <div class="bg-white p-3 rounded-lg shadow-sm">
                        <div class="text-gray-500 text-sm">Tổng tiền gửi</div>
                        <div class="text-2xl font-bold text-blue-600">3,567,890,000 VND</div>
                    </div>
                    <div class="bg-white p-3 rounded-lg shadow-sm">
                        <div class="text-gray-500 text-sm">Ngày dữ liệu</div>
                        <div class="text-2xl font-bold text-blue-600">15/07/2023</div>
                    </div>
                </div>
            </div>

            <!-- Product Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white rounded-lg overflow-hidden">
                    <thead class="bg-gray-100 text-gray-700">
                        <tr>
                            <th class="py-3 px-4 text-left">STT</th>
                            <th class="py-3 px-4 text-left">Nhóm sản phẩm</th>
                            <th class="py-3 px-4 text-left">Mã sản phẩm</th>
                            <th class="py-3 px-4 text-left">Tên sản phẩm</th>
                            <th class="py-3 px-4 text-left">Số hợp đồng/Tài khoản</th>
                            <th class="py-3 px-4 text-left">Loại tiền tệ</th>
                            <th class="py-3 px-4 text-right">Số dư nguyên tệ</th>
                            <th class="py-3 px-4 text-right">Số dư quy đổi</th>
                            <th class="py-3 px-4 text-left">Ngày mở</th>
                            <th class="py-3 px-4 text-left">Ngày đáo hạn</th>
                            <th class="py-3 px-4 text-left">Ngày dữ liệu</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600" id="product-table-body">
                        <!-- Payment Account Data -->
                        <tr class="border-t hover:bg-gray-50 cursor-pointer payment-account-row" onclick="showDetailModal('payment')">
                            <td class="py-3 px-4">1</td>
                            <td class="py-3 px-4">Tài khoản thanh toán</td>
                            <td class="py-3 px-4">PA001</td>
                            <td class="py-3 px-4">Tài khoản thanh toán cá nhân</td>
                            <td class="py-3 px-4">1234567890</td>
                            <td class="py-3 px-4">VND</td>
                            <td class="py-3 px-4 text-right">245,000,000.00</td>
                            <td class="py-3 px-4 text-right">245,000,000.00</td>
                            <td class="py-3 px-4">15/05/2020</td>
                            <td class="py-3 px-4">-</td>
                            <td class="py-3 px-4">14/07/2023</td>
                        </tr>
                        <tr class="border-t hover:bg-gray-50 cursor-pointer payment-account-row" onclick="showDetailModal('payment')">
                            <td class="py-3 px-4">2</td>
                            <td class="py-3 px-4">Tài khoản thanh toán</td>
                            <td class="py-3 px-4">PA002</td>
                            <td class="py-3 px-4">Tài khoản thanh toán USD</td>
                            <td class="py-3 px-4">9876543210</td>
                            <td class="py-3 px-4">USD</td>
                            <td class="py-3 px-4 text-right">15,000.00</td>
                            <td class="py-3 px-4 text-right">345,000,000.00</td>
                            <td class="py-3 px-4">20/08/2021</td>
                            <td class="py-3 px-4">-</td>
                            <td class="py-3 px-4">14/07/2023</td>
                        </tr>
                        <!-- Add other rows here as needed -->
                    </tbody>
                </table>
            </div>

    </div>
</div>
<!-- Detail Modal -->
<div id="detail-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden modal">
        <div class="bg-white rounded-lg shadow-xl w-11/12 max-w-4xl modal-content">
            <div class="flex justify-between items-center border-b p-4">
                <h3 class="text-xl font-semibold text-gray-800" id="modal-title">Chi tiết sản phẩm</h3>
                <button onclick="closeDetailModal()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-6" id="modal-content">
                <!-- Content will be dynamically inserted here -->
            </div>
            <div class="flex justify-end p-4 border-t">
                <button onclick="closeDetailModal()" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Đóng</button>
            </div>
        </div>
    </div>

    <script>
        // Tab switching functionality
        document.querySelectorAll('[id$="-tab"]').forEach(tab => {
            tab.addEventListener('click', function() {
                const productType = this.id.replace('-tab', '');
                showProductType(productType);
            });
        });

        function showProductType(productType) {
            // Hide all rows
            document.querySelectorAll('#product-table-body tr').forEach(row => {
                row.classList.add('hidden');
            });
            
            // Show only rows of the selected product type
            document.querySelectorAll(`.${productType}-row`).forEach(row => {
                row.classList.remove('hidden');
            });
            
            // Update active tab styling
            document.querySelectorAll('[id$="-tab"]').forEach(tab => {
                tab.classList.remove('ring-2', 'ring-blue-500');
            });
            document.getElementById(`${productType}-tab`).classList.add('ring-2', 'ring-blue-500');
        }

        // Show payment account by default
        document.addEventListener('DOMContentLoaded', function() {
            showProductType('payment-account');
            document.getElementById('payment-account-tab').classList.add('ring-2', 'ring-blue-500');
        });

        // Modal functions
        function showDetailModal(productType) {
            const modal = document.getElementById('detail-modal');
            const modalTitle = document.getElementById('modal-title');
            const modalContent = document.getElementById('modal-content');
            
            // Set title based on product type
            let title = '';
            let content = '';
            
            switch(productType) {
                case 'payment':
                    title = 'Chi tiết tài khoản thanh toán';
                    content = generatePaymentAccountDetail();
                    break;
                case 'saving':
                    title = 'Chi tiết tài khoản tiết kiệm';
                    content = generateSavingAccountDetail();
                    break;
                case 'credit':
                    title = 'Chi tiết tài khoản tín dụng';
                    content = generateCreditDetail();
                    break;
                case 'guarantee':
                    title = 'Chi tiết bảo lãnh';
                    content = generateGuaranteeDetail();
                    break;
                case 'card':
                    title = 'Chi tiết thẻ';
                    content = generateCardDetail();
                    break;
                case 'ebanking':
                    title = 'Chi tiết Ebanking';
                    content = generateEbankingDetail();
                    break;
                default:
                    title = 'Chi tiết sản phẩm';
                    content = '<p>Thông tin chi tiết sản phẩm</p>';
            }
            
            modalTitle.textContent = title;
            modalContent.innerHTML = content;
            modal.classList.remove('hidden');
        }

        function closeDetailModal() {
            document.getElementById('detail-modal').classList.add('hidden');
        }

        // Generate detail content for each product type
        function generatePaymentAccountDetail() {
            return `/* Add your details here */`;
        }

        function generateSavingAccountDetail() {
            return `/* Add your details here */`;
        }

        function generateCreditDetail() {
            return `/* Add your details here */`;
        }

        function generateGuaranteeDetail() {
            return `/* Add your details here */`;
        }

        function generateCardDetail() {
            return `/* Add your details here */`;
        }

        function generateEbankingDetail() {
            return `/* Add your details here */`;
        }

        // Highlight row on hover
        document.querySelectorAll('#product-table-body tr').forEach(row => {
            row.addEventListener('mouseenter', function() {
                this.classList.add('highlight-row');
            });
            row.addEventListener('mouseleave', function() {
                this.classList.remove('highlight-row');
            });
        });
    </script>

              </div>
            </div>


            
      

    <?php include('include-footer.php'); ?>
    </div>
    </div>

    <?php include('include-js.php'); ?>
    <script src="<?= base_url('assets/js/page/components-contracts.js'); ?>"></script>

</body>

</html>