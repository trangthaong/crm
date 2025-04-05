<!DOCTYPE html>
<html lang="en">

<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title><?= !empty($this->lang->line('label_calendar')) ? $this->lang->line('label_calendar') : 'Calendar'; ?> &mdash; <?= get_compnay_title(); ?></title>
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
                        <h1><?= !empty($this->lang->line('label_calendar')) ? $this->lang->line('label_calendar') : 'Calendar'; ?></h1>
                        <div class="section-header-breadcrumb">
                            <div class="btn-group mr-2 no-shadow">
                                <a href="<?= base_url('calendar/lists') ?>" class="btn"><i class="fas fa-list"></i> <?= !empty($this->lang->line('label_list_view')) ? $this->lang->line('label_list_view') : 'List View'; ?></a>
                            </div>
                            <?php if (check_permissions("event", "create")) { ?>
                                <i class="btn btn-primary btn-rounded no-shadow" id="modal-add-event" data-value="add"><?= !empty($this->lang->line('label_create_event')) ? $this->lang->line('label_create_event') : 'Create Event'; ?></i>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="card p-4">
                            <div class="section-body">
                                <div id="calendar"></div>
                            </div>
                        </div>
                    </div>

                </section>
            </div>
            <?php if (check_permissions("event", "create")) { ?>
                <?= form_open('calendar/create', 'id="modal-add-event-part"', 'class="modal-part"'); ?>
                <div id="modal-event-title" class="d-none"><?= !empty($this->lang->line('label_add_event')) ? $this->lang->line('label_add_event') : 'Add Event'; ?></div>
                <div id="modal-footer-add-title" class="d-none"><?= !empty($this->lang->line('label_add')) ? $this->lang->line('label_add') : 'Add'; ?></div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label><?= !empty($this->lang->line('label_title')) ? $this->lang->line('label_title') : 'Title'; ?></label>
                            <div class="input-group">
                                <?= form_input(['name' => 'title', 'placeholder' => !empty($this->lang->line('label_title')) ? $this->lang->line('label_title') : 'Title', 'class' => 'form-control']) ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="start_date"><?= !empty($this->lang->line('label_start_date')) ? $this->lang->line('label_start_date') : 'Start Date'; ?></label>
                            <input class="form-control datetimepicker" type="text" id="start_date" name="start_date" value="" autocomplete="off">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="end_date"><?= !empty($this->lang->line('label_end_date')) ? $this->lang->line('label_end_date') : 'End Date'; ?></label>
                            <input class="form-control datetimepicker" type="text" id="end_date" name="end_date" value="" autocomplete="off">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label><?= !empty($this->lang->line('label_background_color')) ? $this->lang->line('label_background_color') : 'Background Color'; ?></label>
                            <input type="color" name="background_color" class="form-control" value="#3f0df8">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label><?= !empty($this->lang->line('label_text_color')) ? $this->lang->line('label_text_color') : 'Text Color'; ?></label>
                            <input type="color" name="text_color" class="form-control" value="#ffffff">
                        </div>
                    </div>

                    <div class="col-md-6">

                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="is_public" class="custom-control-input" id="customCheck1">
                            <label class="custom-control-label" for="customCheck1"><?= !empty($this->lang->line('label_is_public')) ? $this->lang->line('label_is_public') : 'Is Public'; ?></label>
                        </div>

                    </div>
                </div>
                </form>
            <?php } ?>
            <div class="modal-edit-event"></div>
            <form action="<?= base_url('calendar/edit'); ?>" method="post" class="modal-part" id="modal-edit-event-part">
                <div id="modal-edit-event-title" class="d-none"><?= !empty($this->lang->line('label_edit')) ? $this->lang->line('label_edit') : 'Edit'; ?><?= !empty($this->lang->line('label_event')) ? ' ' . $this->lang->line('label_event') : ' Event'; ?></div>
                <div id="modal-footer-edit-title" class="d-none"><?= !empty($this->lang->line('label_edit')) ? $this->lang->line('label_edit') : 'Edit'; ?></div>
                <div class="row">
                    <div class="col-md-12">
                        <label><?= !empty($this->lang->line('label_title')) ? $this->lang->line('label_title') : 'Title'; ?></label>
                        <div class="input-group">
                            <input type="hidden" name="update_id" id="update_event_id">
                            <input type="text" class="form-control" placeholder=<?= !empty($this->lang->line('label_title')) ? $this->lang->line('label_title') : 'Title'; ?> name="title" id="update_event_title">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="start_date"><?= !empty($this->lang->line('label_start_date')) ? $this->lang->line('label_start_date') : 'Start Date'; ?></label>
                            <input class="form-control datetimepicker" type="text" id="update_event_start_date" name="start_date" autocomplete="off">
                            <input type="hidden" id="update_event_start_date_1" name="start_date_1">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="end_date"><?= !empty($this->lang->line('label_end_date')) ? $this->lang->line('label_end_date') : 'End Date'; ?></label>
                            <input class="form-control datetimepicker" type="text" id="update_event_end_date" name="end_date" autocomplete="off">
                            <input type="hidden" id="update_event_end_date_1" name="end_date_1">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label><?= !empty($this->lang->line('label_background_color')) ? $this->lang->line('label_background_color') : 'Background Color'; ?></label>
                            <input type="color" id="update_background_color" name="background_color" class="form-control" value="">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label><?= !empty($this->lang->line('label_text_color')) ? $this->lang->line('label_text_color') : 'Text Color'; ?></label>
                            <input type="color" id="update_text_color" name="text_color" class="form-control" value="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="is_public" class="custom-control-input" id="customCheck2">
                            <label class="custom-control-label" for="customCheck2"><?= !empty($this->lang->line('label_is_public')) ? $this->lang->line('label_is_public') : 'Is Public'; ?></label>
                        </div>
                    </div>
                </div>
            </form>

            <?php include('include-footer.php'); ?>

        </div>
    </div>
    <?php include('include-js.php'); ?>
    <?php include('calendar.php'); ?>
</body>

</html>