
<?php
// client-detail.php

// Lấy toàn bộ URL từ biến $_SERVER['REQUEST_URI']
$uri = $_SERVER['REQUEST_URI'];

/* // In ra toàn bộ URL để kiểm tra
echo "URL hiện tại: " . htmlspecialchars($uri) . "<br>"; */

// Phân tách URL bằng dấu '/'
$path_parts = explode('/', $uri);

// In ra tất cả các phần tách được từ URL để kiểm tra
/* echo "Các phần trong URL: <br>";
print_r($path_parts);  // In ra tất cả các phần của URL đã phân tách */

// Kiểm tra nếu có ít nhất 4 phần trong URL (index.php/users/detail/rm_code)
if (isset($path_parts[6])) {
    // rm_code nằm ở phần thứ 4 trong URL (0-indexed)
    $rm_code = $path_parts[5];
    
    /* // In ra giá trị MaKH để kiểm tra
    echo "Mã RM (rm_code) từ URL: " . htmlspecialchars($rm_code) . "<br>"; */

    
    // Kết nối cơ sở dữ liệu (thay đổi thông tin kết nối của bạn)
    $conn = new mysqli("localhost", "root", "", "crm");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Truy vấn thông tin chi tiết khách hàng dựa trên MaKH
    $sql = "SELECT * FROM rms WHERE rm_code = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die('MySQL prepare error: ' . $conn->error);
    }

    // Liên kết tham số và thực thi câu truy vấn
    $stmt->bind_param("s", $rm_code); // "s" là kiểu chuỗi cho rm_code
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Lấy thông tin chi tiết RM
        $user_details = $result->fetch_assoc();
    } else {
        $user_details = null;
    }


   // Xử lý loại khách hàng khi tab được chọn
    $loaiKH = isset($_GET['loaiKH']) ? $_GET['loaiKH'] : 'client'; // Mặc định là 'client'

    // Lấy MaKH từ URL
    $maKH = isset($_GET['MaKH']) ? $_GET['MaKH'] : '';

    // Khởi tạo mảng lưu trữ dữ liệu khách hàng
    $customer_details = [];

    if ($loaiKH == 'client') {
        // Truy vấn từ bảng client
        $sql_client = "SELECT * FROM client WHERE RMquanly = ?";
        $stmt_client = $conn->prepare($sql_client);
        $stmt_client->bind_param("s", $rm_code);
        $stmt_client->execute();
        $result_client = $stmt_client->get_result();

        while ($row = $result_client->fetch_assoc()) {
            $customer_details[] = $row;
        }
        $stmt_client->close();
    } elseif ($loaiKH == 'leads') {
        // Truy vấn từ bảng leads
        $sql_leads = "SELECT * FROM leads WHERE MaKH = ? ";
        $stmt_leads = $conn->prepare($sql_leads);
        $stmt_leads->bind_param("s", $maKH);
        $stmt_leads->execute();
        $result_leads = $stmt_leads->get_result();

        while ($row = $result_leads->fetch_assoc()) {
            $customer_details[] = $row;
        }
        $stmt_leads->close();
    } else {
        echo "Loại khách hàng không hợp lệ.";
        exit;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Không có tham số MaRM trong URL.";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Quản lý RM</title>
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
                    <h1>Quản lý RM/ Thông tin RM</h1>
                    <div class="section-header-breadcrumb">
                    <?php if (check_permissions("users", "update")) { ?>
                          <button class="btn btn-primary btn-rounded no-shadow" id="modal-edit-user" style="margin-right: 10px;">
                            <i class="fas fa-pen"></i>
                          </button>
                          <?php } ?>
                          <button class="btn btn-secondary btn-rounded no-shadow" id="modal-delete-user">
                            <i class="fas fa-trash"></i>
                          </button>
                    </div>
                </div>

            <div class="section-body">
        <!-- RM Information Section -->
        <div class="content">
            <!-- RM Detailed Information Section -->
            <div class="card">
              <div class="card-body">
                <h5 style= "margin-bottom: 40px;">Thông tin RM</h5>
                <div class="row">
                  <div class="col-md-6">
                    <!-- Table 1: Information about the RM -->
                    <table class="profile-table w-75" style="width: 100%; margin-bottom: 10px;">
                      <tr>
                        <td style="color:rgba(87, 12, 14, 0.68)" class="font-weight-600">Mã RM</td>
                        <td class="text-muted d-inline font-weight-normal"><?= htmlspecialchars($user_details['rm_code']); ?></td>
                      </tr>
                      <tr>
                        <td style="color:rgba(87, 12, 14, 0.68)" class="font-weight-600">Chi nhánh</td>
                        <td class="text-muted d-inline font-weight-normal"><?= htmlspecialchars($user_details['branch_lv2_code'].' - '. $user_details['branch_lv2_name']); ?></td>
                      </tr>
                      <tr>
                        <td style="color:rgba(87, 12, 14, 0.68)" class="font-weight-600">Họ và tên</td>
                        <td class="text-muted d-inline font-weight-normal"><?= htmlspecialchars($user_details['full_name']); ?></td>
                      </tr>
                      <tr>
                        <td style="color:rgba(87, 12, 14, 0.68)" class="font-weight-600">Vị trí</td>
                        <td class="text-muted d-inline font-weight-normal"><?= htmlspecialchars($user_details['position']); ?></td>
                      </tr>
                    </table>
                  </div>
                  <div class="col-md-6">
                    <!-- Table 2: More detailed information -->
                    <table class="profile-table w-75" style="width: 100%;">
                      <tr>
                        <td style="color:rgba(87, 12, 14, 0.68)" class="font-weight-600">Mã nhân viên (HRIS)</td>
                        <td class="text-muted d-inline font-weight-normal"><?= htmlspecialchars($user_details['hris_code']); ?></td>
                      </tr>
                      <tr>
                        <td style="color:rgba(87, 12, 14, 0.68)" class="font-weight-600">Số điện thoại</td>
                        <td class="text-muted d-inline font-weight-normal"><?= htmlspecialchars($user_details['phone']); ?></td>
                      </tr>
                      <tr>
                        <td style="color:rgba(87, 12, 14, 0.68)" class="font-weight-600">Email</td>
                        <td class="text-muted d-inline font-weight-normal"><?= htmlspecialchars($user_details['email']); ?></td>
                      </tr>
                      <tr>
                        <td style="color:rgba(87, 12, 14, 0.68)" class="font-weight-600">Ngày bắt đầu vị trí</td>
                        <td class="text-muted d-inline font-weight-normal"><?= htmlspecialchars($user_details['created_at']); ?></td>
                      </tr>
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
                <!-- Form sửa RM -->
                <?php if (check_permissions("users", "update")) { ?>
                    <div class="card mt-4">
                        <div class="card-body">
                        <?= form_open('auth/edit_user', 'id="modal-edit-user-part"', 'class="modal-part"'); ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div id="modal-title" class="d-none">Sửa thông tin RM</div>
                                <div id="modal-footer-add-title" class="d-none">Lưu</div>
                            <div class="row" >
                                <!-- Tên RM -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Họ và tên RM</label>
                                        <div class="input-group">
                                            <?= form_input(['name' => 'full_name', 'value' => $user_details['full_name'] ?? '', 'placeholder' => 'Nhập tên RM', 'class' => 'form-control']) ?>
                                        </div>
                                    </div>
                                </div>

                                <!-- Ngày sinh -->
                                <div class="col-md-3" id="date_of_birth">
                                    <div class="form-group">
                                        <label>Ngày sinh</label>
                                        <div class="input-group">
                                            <?= form_input(['name' => 'Ngaysinh', 'value' => $user_details['Ngaysinh'] ?? '', 'type' => 'date', 'placeholder' => 'Nhập ngày sinh', 'class' => 'form-control']) ?>
                                        </div>
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <div class="input-group">
                                            <?= form_input(['name' => 'Email', 'value' => $user_details['email'] ?? '', 'placeholder' => 'Nhập email', 'class' => 'form-control']) ?>
                                        </div>
                                    </div>
                                </div>

                                <!-- Số điện thoại -->
                                <div class="col-md-4" id="phone">
                                    <div class="form-group">
                                        <label>Số điện thoại</label>
                                        <div class="input-group">
                                            <?= form_input(['name' => 'phone', 'value' => $user_details['phone'] ?? '', 'placeholder' => 'Số điện thoại', 'class' => 'form-control']) ?>
                                        </div>
                                    </div>
                                </div>

                                <!-- VỊ trí -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Vị trí</label>
                                        <div class="input-group">
                                            <?= form_input(['name' => 'vitri', 'value' => $user_details['position'] ?? '', 'placeholder' => 'Nhập vị trí', 'class' => 'form-control']) ?>
                                        </div>
                                    </div>
                                </div>

                                <!-- Ngay bd VỊ trí -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Ngày bắt đầu</label>
                                        <div class="input-group">
                                            <?= form_input(['name' => 'upload_date', 'value' => $user_details['created_at'] ?? '', 'type' => 'datetime', 'placeholder' => 'Nhập vị trí', 'class' => 'form-control']) ?>
                                        </div>
                                    </div>
                                </div>

                                <!-- Khối khách hàng -->
                                <div class="form-group col-md-4">
                                    <label for="customer_block">Khối khách hàng</label>
                                    <?= form_dropdown('Khoi', ['Khách hàng cá nhân', 'Khách hàng doanh nghiệp'], $user_details['Khoi'] ?? null, ['class' => 'form-control']) ?>
                                </div>


                                <!-- Mã RM -->
                                <div class="form-group col-md-4">
                                    <label for="">Mã RM</label>
                                    <?= form_input(['name' => 'MảM', 'value' => $user_details['rm_code'] ?? '', 'class' => 'form-control', 'readonly' => 'readonly']) ?>
                                </div>

                                <!-- Mã hris -->
                                <div class="form-group col-md-4">
                                    <label for="">Mã HRIS</label>
                                    <?= form_input(['name' => 'MaHRIS', 'value' => $user_details['hris_code'] ?? '', 'class' => 'form-control', 'readonly' => 'readonly']) ?>
                                </div>

                                <!-- Chi nhánh -->
                                <div class="form-group col-md-4">
                                    <label for="branch">Chi nhánh</label>
                                    <?= form_input(['name' => 'branch', 'value' => $user_details['branch_lv2_code'].' - '. $user_details['branch_lv2_name'] ?? '', 'class' => 'form-control', 'readonly' => 'readonly']) ?>
                                </div>

                                <!-- Ngày upload -->
                                <div class="form-group col-md-3">
                                    <label for="upload_date">Ngày upload</label>
                                    <?= form_input(['name' => 'created_at', 'value' => $user_details['created_at'] ?? '', 'type' => 'datetime', 'class' => 'form-control', 'readonly' => 'readonly']) ?>
                                </div>

                                <!-- Ngày sửa đổi -->
                                <div class="form-group col-md-3">
                                    <label for="upload_date">Ngày sửa đổi</label>
                                    <?= form_input(['name' => 'update_date', 'value' => date('Y-m-d'), 'type' => 'date', 'class' => 'form-control', 'readonly' => 'readonly']) ?>
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
              <?php if (check_permissions("users", "delete")) { ?>
                  <div class="card mt-4">
                      <div class="card-body">
                      <?= form_open('auth/edit_user', 'id="modal-delete-user-part"', 'class="modal-part"'); ?>
                      <p class="text-gray-700 mb-6">Bạn có chắc chắn muốn xóa thông tin RM này không?</p>
                      </form>
                      </div>
                  </div>
              <?php } ?> 
            </div>     
            
<!-- TAB  -->            
            <div class="card">
              <div class="card-body">
                
                <!-- Product Tabs -->
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link <?php echo ($loaiKH == 'client') ? 'active' : ''; ?>" href="?loaiKH=client&MaKH=<?php echo $maKH; ?>" role="tab" aria-controls="client" aria-selected="true">
                          Danh sách Khách hàng hiện hữu</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link <?php echo ($loaiKH == 'leads') ? 'active' : ''; ?>" href="?loaiKH=leads&MaKH=<?php echo $maKH; ?>" role="tab" aria-controls="leads" aria-selected="false">
                          Danh sách Khách hàng tiềm năng</a>
                    </li>
                </ul>


           
            <!-- Product Table -->
        <div class="bg-white rounded-lg shadow-md">
            <!-- Table Header, remains the same for all tabs -->
            <table class="table-striped" id="product-table" data-toggle="table" data-click-to-select="true" data-side-pagination="server" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-search="false" data-show-columns="false" data-show-refresh="false" data-trim-on-search="false" data-sort-name="id" data-sort-order="desc" data-mobile-responsive="true" data-toolbar="" data-maintain-selected="true" data-query-params="queryParams">
              <thead>
                  <tr>
                      <th class="py-3 px-4 text-left">STT</th>
                      <th class="py-3 px-4 text-left">Mã khách hàng</th>
                      <th class="py-3 px-4 text-left">Tên khách hàng</th>
                      <th class="py-3 px-4 text-left">Số điện thoại</th>
                      <th class="py-3 px-4 text-right">Email</th>
                      <th class="py-3 px-4 text-right">Sector</th>
                      <th class="py-3 px-4 text-left">Tiết kiệm hiện tại</th>
                      <th class="py-3 px-4 text-left">Tín dụng hiện tại</th>
                      <th class="py-3 px-4 text-left">Đơn vị quản lý</th>
                      <th class="py-3 px-4 text-left">Ngày nhận bàn giao</th>
                  </tr>
              </thead>
              <tbody id="product-data">
                  <?php
                  $stt = 1;
                  // Duyệt qua mảng $customer_details và hiển thị dữ liệu trong bảng
                  foreach ($customer_details as $customer) {
                      echo "<tr>";
                      echo "<td>" . $stt++ . "</td>";
                      echo "<td>" . htmlspecialchars($customer['MaKH']) . "</td>";
                      echo "<td>" . htmlspecialchars($customer['TenKH']) . "</td>";
                      echo "<td>" . htmlspecialchars($customer['SDT']) . "</td>";
                      echo "<td class='text-right'>" . htmlspecialchars($customer['Email']) . "</td>";
                      echo "<td class='text-right'>" . htmlspecialchars($user_details['branch_lv2_code'].' - '. $user_details['branch_lv2_name']) . "</td>";
                      echo "<td>". (isset($customer['Tietkiem']) ? number_format($customer['Tietkiem'], 2) : ''). "</td>";
                      echo "<td>" . (isset($customer['Tietkiem']) ? number_format($customer['Tietkiem'], 2) : '') . "</td>";
                      echo "<td>" . (isset($customer['Tietkiem']) ? number_format($customer['Tietkiem'], 2) : '') . "</td>";
                      echo "<td>" . htmlspecialchars($customer['Ngayupload']) . "</td>";
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


            
      

    <?php include('include-footer.php'); ?>
    </div>
    </div>

    <?php include('include-js.php'); ?>
    <script src="<?= base_url('assets/js/page/components-contracts.js'); ?>"></script>

</body>

</html>