<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Phân quyền</title>
    <?php
        require_once(APPPATH . 'views/include-css.php');
    ?>
</head>
<body>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <?php require_once(APPPATH . 'views/include-header.php'); ?>
 
            <!-- Main Content -->
            <div class="main-content" style="min-height: 318px;">
                <section class="section">
                    <div class="section-header">
                        <h1>
                            Phân quyền người dùng
                        </h1>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="card mb-0">
                                <div class="alert alert-danger" style="margin-bottom: 0rem">
                                    <b>Quản trị viên có toàn quyền kiểm soát. Thiết lập các quyền tại đây</b>
                                </div>
                            </div>
                        </div>
                    </div> 
                    <div class="section-body">
                        <?php
                             $user_permissions = $client_permissions_data = "";
     
                             $actions = ['create', 'read', 'update', 'delete'];
                             $total_actions = count($actions);
     
                             // /* reading member's permissions from database */
                             $user_permissions = (!empty($modules[0]['member_permissions'])) ? json_decode($modules[0]['member_permissions'],1) : [];
                             $client_permissions_data = (!empty($modules[0]['client_permissions'])) ? json_decode($modules[0]['client_permissions'], 1 ) : [];
                        ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="text-center">Cấp quyền nhóm người dùng</h4>
                                    </div>
                                    <form action="<?= base_url('permissions/update_members_permissions') ?>" id="update_members_permissions_form">
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-striped">
                                                    <tbody>
                                                        <tr>
                                                            <th class="col-sm-4 text-left">Module/Quyền</th>
                                                            <?php foreach ($actions as $action) { ?>
                                                                <th class="col-sm-2 text-center"><?= ucfirst($action) ?></th>
                                                            <?php } ?>
                                                        </tr>
                                                        <?php
                                                        $module_names = [
                                                            'projects' => 'Chiến dịch',
                                                            'leads' => 'Khách hàng tiềm năng',
                                                            'users' => 'Người dùng',
                                                            'clients' => 'Khách hàng hiện hữu'
                                                        ];
                                                        foreach ($system_modules as $module => $member_permissions) : ?>
                                                            <tr>
                                                                <td class="col-sm-4 text-left"><?= $module_names[$module] ?? ucfirst(str_replace("_", " ", $module)); ?></td>
                                                                <?php for ($i = 0; $i < $total_actions; $i++) {
                                                                    $checked = (isset($user_permissions[$module]) && array_key_exists($actions[$i], $user_permissions[$module]) && ($user_permissions[$module][$actions[$i]] == "on" || $user_permissions[$module][$actions[$i]] == 1)) ? "checked" : "";
                                                                    if (array_search($actions[$i], $system_modules[$module]) !== false) { ?>
                                                                        <td class="col-sm-2 text-center"> <input type="checkbox" name="<?= 'member_permissions[' . $module . '][' . $actions[$i] . ']' ?>" <?= $checked ?>></td>
                                                                    <?php } else { ?>
                                                                        <td class="col-sm-2 text-center">-</td>
                                                                <?php }
                                                                } ?>
                                                            </tr>
                                                        <?php endforeach; ?>

                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>
                                        <div class="card-footer text-right">
                                            <button class="btn btn-primary mb-2" id="submit_button">Cập nhật quyền</button>
                                            <div id="result" class="disp-none"></div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <?php require_once(APPPATH . 'views/include-footer.php'); ?>
        </div>
    </div>
    <?php
    require_once(APPPATH . 'views/include-js.php');
    ?>
</body>

</html>