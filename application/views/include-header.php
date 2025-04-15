<?php //$current_version = get_current_version(); 
?>

<?php
if (!$this->ion_auth->logged_in() || !isset($_SESSION['role'])) {
    redirect('auth', 'refresh');
}
?>

<div class="navbar-bg"></div>
<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
            <!-- <li>
                <span class="badge badge-success">v <?= (isset($current_version) && !empty($current_version)) ? $current_version : '1.0' ?></span>
            </li> -->
            <?php if (defined('ALLOW_MODIFICATION') && ALLOW_MODIFICATION == 0) { ?>
                <li class="ml-2">
                    <span class="badge badge-danger">Demo mode</span>
                </li>
            <?php } ?>
            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i
                        class="fas fa-search"></i></a></li>
        </ul>
        <div class="search-element">
            <input class="form-control" id="search-results" type="search" placeholder="Search" aria-label="Search"
                data-width="250">
            <button class="btn" type="submit"><i class="fas fa-search"></i></button>
            <div class="search-backdrop"></div>
            <div class="search-result">
                <div class="search-results chat-scroll" style="max-height: 350px;">
                    <div class="search-header">Result</div>
                </div>
            </div>
        </div>
    </form>

    <ul class="navbar-nav navbar-right">
        <?php
        if (!empty($workspace)) {
            if (is_admin()) {
                ?>
                <li>
                    <a href="<?= base_url('send-mail'); ?>" title="Send Email" class="nav-link nav-link-lg"
                        aria-expanded="true">
                        <i class="fa fa-envelope"></i>
                    </a>
                </li>
            <?php } ?>
            <?php if (check_permissions("announcements", "read")) { ?>
                <li>
                    <a href="<?= base_url('announcements'); ?>" title="Announcements" class="nav-link nav-link-lg"
                        aria-expanded="true">
                        <i class="fa fa-bullhorn"></i>
                    </a>
                </li>
            <?php } ?>
            <?php $beep = !empty($notifications) ? 'beep' : ''; ?>
            <li class="dropdown dropdown-list-toggle">
                <a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg <?= $beep; ?>"><i
                        class="far fa-bell"></i></a>
                <div class="dropdown-menu dropdown-list dropdown-menu-right">
                    <div class="dropdown-header">
                        <?= !empty($this->lang->line('label_notifications')) ? $this->lang->line('label_notifications') : 'Notifications'; ?>
                        <?php if (!empty($notifications)) { ?>
                            <div class="float-right">
                                <a href="#" class="mark-all-as-read-alert" data-user-id=<?= $this->session->userdata('user_id'); ?>><?= !empty($this->lang->line('label_mark_all_as_read')) ? $this->lang->line('label_mark_all_as_read') : 'Mark all as read'; ?></a>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="dropdown-list-content dropdown-list-icons">
                        <?php if (!empty($notifications)) {
                            foreach ($notifications as $notification) {
                                $notification_url = '#';
                                switch ($notification['type']) {
                                    case 'event':
                                        $notification_url = base_url('calendar/' . $notification['type_id']);
                                        break;
                                    case 'announcement':
                                        $notification_url = base_url('announcements/details/' . $notification['type_id']);
                                        break;
                                    case 'project':
                                        $notification_url = base_url('projects/details/' . $notification['type_id']);
                                        break;
                                    case 'task':
                                        $notification_url = base_url('projects/tasks/' . $notification['type_id']);
                                        break;
                                    default:
                                        $notification_url = '#';
                                        break;
                                } ?>
                                <a href="<?= $notification_url; ?> " class="dropdown-item notification">
                                    <div class="dropdown-item-icon bg-info text-white">
                                        <i class="fas fa-bell"></i>
                                    </div>
                                    <div class="dropdown-item-desc">
                                        <?= $notification['title']; ?>
                                        <div class="time"><?= date("d-M-Y H:i:s", strtotime($notification['date_created'])); ?>
                                        </div>
                                    </div>
                                </a>
                            <?php }
                        } else { ?>
                            <div class="dropdown-footer text-center">
                                <p>
                                    <?= !empty($this->lang->line('label_no_unread_notifications_found')) ? $this->lang->line('label_no_unread_notifications_found') : 'No Unread Notifications Found!!'; ?>
                                </p>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="dropdown-footer text-center">
                        <a href="<?= base_url('notifications') ?>">
                            <?= !empty($this->lang->line('label_view_all')) ? $this->lang->line('label_view_all') : 'View All'; ?>
                            <i class="fas fa-chevron-right"></i></a>
                    </div>
                </div>
            </li>
        <?php } ?>
        <li class="dropdown">
            <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <?php if (isset($user->profile) && !empty($user->profile)) { ?>
                    <img alt="image" src="<?= base_url('assets/profiles/' . $user->profile); ?>"
                        class="rounded-circle mr-1">
                <?php } else { ?>
                    <figure class="avatar mr-1 avatar-sm"
                        data-initial="<?= mb_substr($user->first_name, 0, 1) . '' . mb_substr($user->last_name, 0, 1); ?>">
                    </figure>
                <?php } ?>
                <div class="d-sm-none d-lg-inline-block">
                    <?= !empty($this->lang->line('label_hi')) ? $this->lang->line('label_hi') : 'Hi'; ?>👋,
                    <?= $user->first_name ?></div>
            </a>
            <div class="dropdown-menu dropdown-menu-right dropdown-width">
                <!--workspace code goes here-->
                <a href="<?= base_url('profile'); ?>" class="dropdown-item has-icon">
                    <i class="far fa-user"></i>
                    <?= !empty($this->lang->line('label_profile')) ? $this->lang->line('label_profile') : 'Profile'; ?>
                </a>
                <div class="dropdown-divider"></div>
                <a href="<?= base_url('auth/logout'); ?>" class="dropdown-item has-icon text-danger">
                    <i class="fas fa-sign-out-alt"></i>
                    <?= !empty($this->lang->line('label_logout')) ? $this->lang->line('label_logout') : 'Logout'; ?>
                </a>
            </div>
        </li>
    </ul>
</nav>
<?php
$response = get_system_settings('general');
?>
<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="<?= base_url('home'); ?>">
                <img alt="MBV"
                    src="<?= base_url('assets/icons/logo.png'); ?>" width="200px">
            </a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="<?= base_url('home'); ?>">
            <img alt=MBV"
            src="<?= base_url('assets/icons/logo.png'); ?>" width="40px">
            </a>
        </div>
        <ul class="sidebar-menu" style="margin-top: 50px; display: flex; flex-direction: column; gap: 10px;"> 
            <div class="pb-2 pl-2 pr-2">
            </div>
            <li <?= (current_url() == base_url('home')) ? 'class="active"' : ''; ?>><a class="nav-link"
                    href="<?= base_url('home'); ?>"><i class="fas fa-fire text-danger"></i> <span>
                        <?= !empty($this->lang->line('label_dashboard')) ? $this->lang->line('label_dashboard') : 'Dashboard'; ?>
                    </span></a></li>


            <?php if (check_permissions("clients", "read")) { ?>
            <li class="dropdown <?= (current_url() == base_url('clients') ||
                    current_url() == base_url('clients') ||
                    current_url() == base_url('clients/assign_clients')) ? ' active' : ''; ?>">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i
                            class="fas fa-users text-info"></i><span><?= !empty($this->lang->line('label_clients')) ? $this->lang->line('label_clients') : 'Clients'; ?></span></a>
                    <ul class="dropdown-menu">
                        <li <?= (current_url() == base_url('clients')) ? 'class="active"' : ''; ?>>
                            <a class="nav-link" href="<?= base_url('clients'); ?>">
                                <span>Quản lý KHHH</span>
                            </a>
                        </li>
                        <li <?= (current_url() == base_url('clients/assign_clients')) ? 'class="active"' : ''; ?>>
                            <a class="nav-link" href="<?= base_url('clients/assign_clients'); ?>">
                                <span>Phân giao KH</span>
                            </a>
                        </li>
                        </ul>
                </li>
            <?php } ?>

                <?php if (check_permissions("leads", "read")) { ?>
                <li class="dropdown <?= (current_url() == base_url('leads') ||
                    current_url() == base_url('leads') ||
                    current_url() == base_url('leads/unit') ||
                    current_url() == base_url('leads/assign_leads?module=rm')) ? ' active' : ''; ?>">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i
                            class="fas fa-tty text-danger"></i><span>Khách hàng tiềm năng</span></a>
                    <ul class="dropdown-menu">
                        <li <?= (current_url() == base_url('leads')) ? 'class="active"' : ''; ?>>
                            <a class="nav-link" href="<?= base_url('leads'); ?>">
                                <span>Quản lý KHTN</span>
                            </a>
                        </li>
                        <li <?= (current_url() == base_url('leads/assign_leads_unit')) ? 'class="active"' : ''; ?>>
                            <a class="nav-link" href="<?= base_url('leads/assign_leads?module=unit'); ?>">
                                <span>Phân giao cho đơn vị</span>
                            </a>
                        </li>
                        <li <?= (current_url() == base_url('leads/assign_leads?module=rm')) ? 'class="active"' : ''; ?>>
                            <a class="nav-link" href="<?= base_url('leads/assign_leads?module=rm'); ?>">
                                <span>Phân giao cho RM</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <?php } ?>

                
                <?php if (check_permissions("users", "read")) { ?>
                    <li <?= (current_url() == base_url('users')) ? 'class="active"' : ''; ?>><a class="nav-link"
                            href="<?= base_url('users'); ?>"><i class="fas fa-user text-warning"></i> <span>
                                <?= !empty($this->lang->line('label_users')) ? $this->lang->line('label_users') : 'Users'; ?>
                            </span></a>
                    </li>
                <?php } ?>
                
                <?php if (check_permissions("projects", "read")) {?>
                    <li <?= (current_url() == base_url('projects')) ? 'class="active"' : ''; ?>><a class="nav-link"
                            href="<?= base_url('projects'); ?>"><i class="far fa-file-alt text-info"></i> <span>
                                Chiến dịch
                            </span></a>
                    </li>
                <?php } ?>

            <?php if (is_admin()) { ?>
                <li
                    class="dropdown <?= (current_url() == base_url('settings/setting-detail') || current_url() == base_url('email-templates') || current_url() == base_url('permissions')) ? ' active' : ''; ?>">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-cog"></i>
                        <span><?= !empty($this->lang->line('label_settings')) ? $this->lang->line('label_settings') : 'Settings'; ?></span></a>
                    <ul class="dropdown-menu">
                        <li <?= (current_url() == base_url('settings/setting-detail') || current_url() == base_url('settings/setting-detail')) ? 'class="active"' : ''; ?>>
                            <a class="nav-link" href="<?= base_url('settings/setting-detail'); ?>">
                                <span>
                                    <?= !empty($this->lang->line('label_settings')) ? $this->lang->line('label_settings') : 'Settings'; ?>
                                </span>
                            </a>
                        </li>
                        <li <?= (current_url() == base_url('email-templates') || current_url() == base_url('email-templates')) ? 'class="active"' : ''; ?>>
                            <a class="nav-link" href="<?= base_url('email-templates'); ?>">
                                <span>
                                    Mẫu Email
                                </span>
                            </a>
                        </li>
                        <li <?= (current_url() == base_url('permissions') || current_url() == base_url('permissions')) ? 'class="active"' : ''; ?>>
                            <a class="nav-link" href="<?= base_url('permissions'); ?>">
                                <span>
                                    Phân quyền
                                </span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="menu-header">-</li>
            <?php } ?>
        </ul>
    </aside>
</div>
</div>