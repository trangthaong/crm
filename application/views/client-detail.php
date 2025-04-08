
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Quản lý KHHH</title>
    <?php include('include-css.php'); ?>
</head>
<body>
<?php include "include-header.php"; ?>
<?php
// client-detail.php

// Lấy toàn bộ URL từ biến $_SERVER['REQUEST_URI']
$uri = $_SERVER['REQUEST_URI'];
$path_parts = explode('/', $uri);

// Kiểm tra nếu có ít nhất 4 phần trong URL (index.php/clients/detail/MaKH)
if (isset($path_parts[6])) {
    // MaKH nằm ở phần thứ 4 trong URL (0-indexed)
    $maKH = $path_parts[6];
    
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin chi tiết khách hàng</title>
</head>
<body>
    <div class="client-details">
        <h2>Thông tin chi tiết khách hàng</h2>
        
        <?php if ($client_details): ?>
            <p><strong>Mã khách hàng:</strong> <?= htmlspecialchars($client_details['MaKH']); ?></p>
            <p><strong>Tên khách hàng:</strong> <?= htmlspecialchars($client_details['TenKH']); ?></p>
        <?php else: ?>
            <p>Không tìm thấy thông tin khách hàng với mã MaKH: <?= htmlspecialchars($maKH); ?>.</p>
        <?php endif; ?>
        
        <!-- Nút quay lại trang danh sách khách hàng -->
        <a href="client.php">Quay lại danh sách khách hàng</a>
    </div>
</body>
</html>

</body>
</html>
