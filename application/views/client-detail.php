
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
if (isset($path_parts[6])) {
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

    // Khởi tạo mảng để lưu số lượng sản phẩm cho mỗi loại sản phẩm
    $product_counts = [
        'Tài khoản thanh toán' => 0,
        'Tiết kiệm' => 0,
        'Tín dụng' => 0,
        'Bảo lãnh' => 0,
        'Trái phiếu' => 0,
        'Tài trợ thương mại' => 0,
        'Thẻ' => 0,
        'Ebanking' => 0,
        'SMS' => 0
    ];

    // Truy vấn số lượng sản phẩm cho từng loại sản phẩm theo MaKH
    $sql = "SELECT LoaiSP, COUNT(*) AS product_count FROM product WHERE MaKH = ? GROUP BY LoaiSP";
    $stmt_product_count = $conn->prepare($sql);

    if ($stmt_product_count === false) {
        die('MySQL prepare error: ' . $conn->error);
    }

    $stmt_product_count->bind_param("s", $maKH);
    $stmt_product_count->execute();
    $result_product_count = $stmt_product_count->get_result();

    if ($result_product_count->num_rows > 0) {
        while ($row = $result_product_count->fetch_assoc()) {
            $product_counts[$row['LoaiSP']] = $row['product_count'];
        }
    }

    // Xử lý loại sản phẩm khi tab được chọn
    $loaiSP = isset($_GET['loaiSP']) ? $_GET['loaiSP'] : 'Tai khoan thanh toan'; // Mặc định là 'Tài khoản thanh toán'

    // Truy vấn danh sách sản phẩm cho loại sản phẩm đã chọn theo MaKH
    $sql_product = "SELECT * FROM product WHERE LoaiSP = ? AND MaKH = ?";
    $stmt_product = $conn->prepare($sql_product);

    if ($stmt_product === false) {
        die('MySQL prepare error: ' . $conn->error);
    }

    $stmt_product->bind_param("ss", $loaiSP, $maKH);
    $stmt_product->execute();
    $result_product = $stmt_product->get_result();

    // Lưu danh sách sản phẩm vào biến $product_details
    $product_details = [];
    while ($row = $result_product->fetch_assoc()) {
        $product_details[] = $row;
    }

    // Đóng kết nối
    $stmt_product->close();
    $stmt_product_count->close();
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
                          <td><?= htmlspecialchars($client_details['CMT_Hochieu']); ?></td>
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
                        <?= form_open('auth/edit_user', 'id="modal-edit-user-part"', 'class="modal-part"'); ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div id="modal-title" class="d-none">Sửa thông tin khách hàng</div>
                                <div id="modal-footer-add-title" class="d-none">Lưu</div>
                            <div class="row" >
                                <!-- Tên khách hàng -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Họ và tên khách hàng</label>
                                        <div class="input-group">
                                            <?= form_input(['name' => 'TenKH', 'value' => $client_details['TenKH'] ?? '', 'placeholder' => 'Nhập tên khách hàng', 'class' => 'form-control']) ?>
                                        </div>
                                    </div>
                                </div>

                                <!-- Ngày sinh -->
                                <div class="col-md-3" id="date_of_birth">
                                    <div class="form-group">
                                        <label>Ngày sinh</label>
                                        <div class="input-group">
                                            <?= form_input(['name' => 'Ngaysinh', 'value' => $client_details['Ngaysinh'] ?? '', 'type' => 'date', 'placeholder' => 'Nhập ngày sinh', 'class' => 'form-control']) ?>
                                        </div>
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <div class="input-group">
                                            <?= form_input(['name' => 'Email', 'value' => $client_details['Email'] ?? '', 'placeholder' => 'Nhập email', 'class' => 'form-control']) ?>
                                        </div>
                                    </div>
                                </div>

                                <!-- Quốc tịch -->
                                <div class="col-md-3">
                                    <div class="form-group" id="country">
                                        <label>Quốc tịch</label>
                                        <div class="input-group">
                                            <?= form_input(['name' => 'Quoctich', 'value' => $client_details['Quoctich'] ?? '', 'placeholder' => 'Nhập quốc tịch', 'class' => 'form-control']) ?>
                                        </div>
                                    </div>
                                </div>

                                <!-- Số CMT/Hộ chiếu -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Số CMT/Hộ chiếu</label>
                                        <div class="input-group">
                                            <?= form_input(['name' => 'CMT_Hochieu', 'value' => $client_details['CMT_Hochieu'] ?? '', 'placeholder' => 'Nhập số CMT/Hộ chiếu', 'class' => 'form-control']) ?>
                                        </div>
                                    </div>
                                </div>

                                <!-- Ngày cấp -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Ngày cấp</label>
                                        <div class="input-group">
                                            <?= form_input(['name' => 'Ngaycap', 'value' => $client_details['Ngaycap'] ?? '', 'type' => 'date', 'class' => 'form-control']) ?>
                                        </div>
                                    </div>
                                </div>

                                <!-- Nơi cấp -->
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Nơi cấp</label>
                                        <div class="input-group">
                                            <?= form_input(['name' => 'Noicap', 'value' => $client_details['Noicap'] ?? '', 'placeholder' => 'Nơi cấp', 'class' => 'form-control']) ?>
                                        </div>
                                    </div>
                                </div>

                                <!-- Số điện thoại -->
                                <div class="col-md-4" id="phone">
                                    <div class="form-group">
                                        <label>Số điện thoại</label>
                                        <div class="input-group">
                                            <?= form_input(['name' => 'SDT', 'value' => $client_details['SDT'] ?? '', 'placeholder' => 'Số điện thoại', 'class' => 'form-control']) ?>
                                        </div>
                                    </div>
                                </div>

                                <!-- Địa chỉ-->
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>Địa chỉ</label>
                                        <div class="input-group">
                                            <?= form_input(['name' => 'Diachi', 'value' => $client_details['Diachi'] ?? '', 'placeholder' => 'Nhập địa chỉ', 'class' => 'form-control']) ?>
                                        </div>
                                    </div>
                                </div>

                                <!-- Nghề nghiệp -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Nghề nghiệp</label>
                                        <div class="input-group">
                                            <?= form_input(['name' => 'Nghenghiep', 'value' => $client_details['Nghenghiep'] ?? '', 'placeholder' => 'Nhập nghề nghiệp', 'class' => 'form-control']) ?>
                                        </div>
                                    </div>
                                </div>

                                <!-- Thu nhập-->
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>Thu nhập</label>
                                        <div class="input-group">
                                            <?= form_input(['name' => 'Thunhap', 'value' => $client_details['Thunhap'] ?? '', 'placeholder' => 'Nhập thu nhập TB hàng tháng', 'class' => 'form-control']) ?>
                                        </div>
                                    </div>
                                </div>

                                <!-- Khối khách hàng -->
                                <div class="form-group col-md-4">
                                    <label for="customer_block">Khối khách hàng</label>
                                    <?= form_dropdown('Khoi', ['Khách hàng cá nhân', 'Khách hàng doanh nghiệp'], $client_details['Khoi'] ?? null, ['class' => 'form-control']) ?>
                                </div>

                                <!-- Trạng thái -->
                                <div class="form-group col-md-3">
                                    <label for="status">Trạng thái</label>
                                    <?= form_dropdown('Trangthai', ['Active', 'Inactive'], $client_details['Trangthai'] ?? null, ['class' => 'form-control']) ?>
                                </div>

                                <!-- Tần suất giao dịch -->
                                <div class="form-group col-md-5">
                                    <label for="transaction_frequency">Tần suất giao dịch</label>
                                    <?= form_dropdown('Tansuatgiaodich', ['Chưa phân nhóm', 'Không hoạt động', 'Giao dịch ít'], $client_details['Tansuatgiaodich'] ?? null, ['class' => 'form-control']) ?>
                                </div>

                                <!-- Mã Khách hàng -->
                                <div class="form-group col-md-4">
                                    <label for="">Mã khách hàng</label>
                                    <?= form_input(['name' => 'MaKH', 'value' => $client_details['MaKH'] ?? '', 'class' => 'form-control', 'readonly' => 'readonly']) ?>
                                </div>

                                <!-- RM quản lý -->
                                <div class="form-group col-md-4">
                                    <label for="rm_manager">RM quản lý</label>
                                    <?= form_input(['name' => 'RMquanly', 'value' => $client_details['RMquanly'] ?? '', 'class' => 'form-control', 'readonly' => 'readonly']) ?>
                                </div>

                                <!-- Chi nhánh quản lý -->
                                <div class="form-group col-md-4">
                                    <label for="branch">Chi nhánh quản lý</label>
                                    <?= form_input(['name' => 'branch', 'value' => $client_details['ChiNhanh'] ?? '', 'class' => 'form-control', 'readonly' => 'readonly']) ?>
                                </div>

                                <!-- Ngày upload -->
                                <div class="form-group col-md-3">
                                    <label for="upload_date">Ngày upload</label>
                                    <?= form_input(['name' => 'upload_date', 'value' => $client_details['Ngayupload'] ?? '', 'type' => 'date', 'class' => 'form-control', 'readonly' => 'readonly']) ?>
                                </div>
                                </div>
                            </div>
                            </div>
                          </div>
                      </div>
                  </div>
              <?php } ?>

              <!-- Form xóa KHHH  -->
              <?php if (check_permissions("clients", "delete")) { ?>
                  <div class="card mt-4">
                      <div class="card-body">
                      <?= form_open('auth/edit_user', 'id="modal-add-user-part"', 'class="modal-part"'); ?>
                      <p class="text-gray-700 mb-6">Bạn có chắc chắn muốn xóa thông tin khách hàng này không?</p>
                      </div>
                  </div>
              <?php } ?> 
            </div>     
            
<!-- TAB  -->            
            <div class="card">
              <div class="card-body">
                <h5 style= "margin-bottom: 40px;">Danh sách sản phẩm </h5>
                
                <!-- Product Tabs -->
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($loaiSP == 'Tai khoan thanh toan') ? 'active' : ''; ?>" href="?loaiSP=Tai khoan thanh toan&MaKH=<?php echo $maKH; ?>" role="tab" aria-controls="payment" aria-selected="true">
                            <i class="fas fa-wallet mr-2"></i>Tài khoản thanh toán (<span><?php echo $product_counts['Tài khoản thanh toán']; ?></span>)</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($loaiSP == 'Tiet kiem') ? 'active' : ''; ?>" href="?loaiSP=Tiet kiem&MaKH=<?php echo $maKH; ?>" role="tab" aria-controls="saving" aria-selected="false">
                            <i class="fas fa-piggy-bank mr-2"></i>Tiết kiệm (<span><?php echo $product_counts['Tiết kiệm']; ?></span>)</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($loaiSP == 'Tin dung') ? 'active' : ''; ?>" href="?loaiSP=Tin dung&MaKH=<?php echo $maKH; ?>" role="tab" aria-controls="credit" aria-selected="false">
                            <i class="fas fa-hand-holding-usd mr-2"></i>Tín dụng (<span><?php echo $product_counts['Tín dụng']; ?></span>)</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($loaiSP == 'Bao lanh') ? 'active' : ''; ?>" href="?loaiSP=Bao lanh&MaKH=<?php echo $maKH; ?>" role="tab" aria-controls="guarantee" aria-selected="false">
                            <i class="fas fa-file-signature mr-2"></i>Bảo lãnh (<span><?php echo $product_counts['Bảo lãnh']; ?></span>)</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($loaiSP == 'Trai phieu') ? 'active' : ''; ?>" href="?loaiSP=Trai phieu&MaKH=<?php echo $maKH; ?>" role="tab" aria-controls="bond" aria-selected="false">
                            <i class="fas fa-certificate mr-2"></i>Trái phiếu (<span><?php echo $product_counts['Trái phiếu']; ?></span>)</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($loaiSP == 'Tai tro thuong mai') ? 'active' : ''; ?>" href="?loaiSP=Tai tro thuong mai&MaKH=<?php echo $maKH; ?>" role="tab" aria-controls="trade" aria-selected="false">
                            <i class="fas fa-exchange-alt mr-2"></i>Tài trợ thương mại (<span><?php echo $product_counts['Tài trợ thương mại']; ?></span>)</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($loaiSP == 'The') ? 'active' : ''; ?>" href="?loaiSP=The&MaKH=<?php echo $maKH; ?>" role="tab" aria-controls="card" aria-selected="false">
                            <i class="fas fa-credit-card mr-2"></i>Thẻ (<span><?php echo $product_counts['Thẻ']; ?></span>)</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($loaiSP == 'Ebanking') ? 'active' : ''; ?>" href="?loaiSP=Ebanking&MaKH=<?php echo $maKH; ?>" role="tab" aria-controls="ebanking" aria-selected="false">
                            <i class="fas fa-globe mr-2"></i>Ebanking (<span><?php echo $product_counts['Ebanking']; ?></span>)</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($loaiSP == 'SMS') ? 'active' : ''; ?>" href="?loaiSP=SMS&MaKH=<?php echo $maKH; ?>" role="tab" aria-controls="sms" aria-selected="false">
                            <i class="fas fa-sms mr-2"></i>SMS (<span><?php echo $product_counts['SMS']; ?></span>)</a>
                    </li>
                </ul>


           
            <!-- Product Table -->
        <div class="bg-white rounded-lg shadow-md">
            <!-- Table Header, remains the same for all tabs -->
            <table class="table-striped" id="product-table" data-toggle="table" data-click-to-select="true" data-side-pagination="server" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-search="false" data-show-columns="false" data-show-refresh="false" data-trim-on-search="false" data-sort-name="id" data-sort-order="desc" data-mobile-responsive="true" data-toolbar="" data-maintain-selected="true" data-query-params="queryParams">
                <thead>
                    <tr>
                        <th class="py-3 px-4 text-left">STT</th>
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
                <tbody id="product-data">
                    <?php
                    $stt = 1;
                    // Lấy danh sách sản phẩm theo loại sản phẩm từ PHP và hiển thị chúng trong bảng
                    foreach ($product_details as $product) {
                        echo "<tr>";
                        echo "<td>" . $stt++ . "</td>";
                        echo "<td>" . htmlspecialchars($product['MaSP'] . '-' . $product['LoaiSP']) . "</td>";
                        echo "<td>" . htmlspecialchars($product['SoHD']) . "</td>";
                        echo "<td>" . htmlspecialchars($product['Loaitien']) . "</td>";
                        echo "<td class='text-right'>" . number_format($product['Sodu'], 2) . "</td>";
                        echo "<td class='text-right'>" . number_format($product['Sodu'] * $product['Tygia'], 2) . "</td>";
                        echo "<td>" . htmlspecialchars($product['Ngaymo']) . "</td>";
                        echo "<td>" . htmlspecialchars($product['Ngaydaohan']) . "</td>";
                        echo "<td>" . htmlspecialchars($product['Ngayupload']) . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

    </div>
</div>
              </div>
            </div>
            </div>

            </div>
      

    <?php include('include-footer.php'); ?>
    </div>
    </div>

    <?php include('include-js.php'); ?>
    <script src="<?= base_url('assets/js/page/components-contracts.js'); ?>"></script>

</body>

</html>