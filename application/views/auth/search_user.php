<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div class="table-responsive mt-4">
    <table class="table-striped">
        <thead>
            <tr>
                <th>STT</th>
                <th>ID</th>
                <th>Tên khách hàng</th>
                <th>Khối</th>
                <th>Số điện thoại</th>
                <!-- Add more columns as needed -->
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($results)): 
                var_dump($results);  // Print the results to see if the data is fetched
                ?>
                <?php foreach ($results as $index => $result): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= $result->MaKH ?></td>
                        <td><?= $result->TenKH ?></td>
                        <td><?= $result->Khoi ?></td>
                        <td><?= $result->phone ?></td>
                        <!-- Add more data here as needed -->
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">Không tìm thấy kết quả.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>