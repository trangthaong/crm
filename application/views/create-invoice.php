<!DOCTYPE html>
<html lang="en">

<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title><?= !empty($this->lang->line('label_add_invoice')) ? $this->lang->line('label_add_invoice') : 'Create Invoice'; ?> &mdash; <?= get_compnay_title(); ?></title>
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
                        <h1><?= !empty($this->lang->line('label_add_invoice')) ? $this->lang->line('label_add_invoice') : 'Create Invoice'; ?></h1>
                        <div class="section-header-breadcrumb">
                            <div class="btn-group mr-2 no-shadow">
                                <a class="btn btn-primary text-white" href="<?= base_url('invoices') ?>" class="btn"><i class="fas fa-list"></i> <?= !empty($this->lang->line('label_invoices')) ? $this->lang->line('label_invoices') : 'Invoices'; ?></a>
                            </div>
                        </div>
                    </div>
                    <div class="section-body">
                        <div class="row mt-sm-4">
                            <div class='col-md-12'>
                                <div class="card">
                                    <div class="card-body">

                                        <form action="<?= base_url('invoices/create') ?>" id="create_invoice_form">

                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label><?= !empty($this->lang->line('label_select_client')) ? $this->lang->line('label_select_client') : 'Select Client'; ?></label><span class="asterisk"> *</span>
                                                        <select class="form-control select2" name="client_id" id="client_id">
                                                            <option value="" selected>Choose...</option>
                                                            <?php foreach ($all_user as $all_users) {
                                                            ?>
                                                                <option value="<?= $all_users->id ?>"><?= $all_users->first_name ?> <?= $all_users->last_name ?></option>
                                                            <?php
                                                            } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label><?= !empty($this->lang->line('label_select_project')) ? $this->lang->line('label_select_project') : 'Select Project'; ?></label>
                                                        <select class="form-control select2" name="project_id" id="project_id">
                                                            <option value="" selected><?= !empty($this->lang->line('label_choose')) ? $this->lang->line('label_choose') : 'Choose'; ?>...</option>
                                                            <?php foreach ($projects as $project) {
                                                            ?>
                                                                <option value="<?= $project['id'] ?>"><?= $project['title'] ?></option>
                                                            <?php
                                                            } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label><?= !empty($this->lang->line('label_status')) ? $this->lang->line('label_status') : 'Status'; ?></label>
                                                        <select class="form-control select2" name="status" id="status">
                                                            <option value="" selected><?= !empty($this->lang->line('label_choose')) ? $this->lang->line('label_choose') : 'Choose'; ?>...</option>
                                                            <option value="1"><?= !empty($this->lang->line('label_fully_paid')) ? $this->lang->line('label_fully_paid') : 'Fully paid'; ?></option>
                                                            <option value="2"><?= !empty($this->lang->line('label_partially_paid')) ? $this->lang->line('label_partially_paid') : 'Partially paid'; ?></option>
                                                            <option value="3"><?= !empty($this->lang->line('label_draft')) ? $this->lang->line('label_draft') : 'Draft'; ?></option>
                                                            <option value="4"><?= !empty($this->lang->line('label_cancelled')) ? $this->lang->line('label_cancelled') : 'Cancelled'; ?></option>
                                                            <option value="5"><?= !empty($this->lang->line('label_due')) ? $this->lang->line('label_due') : 'Due'; ?></option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- </div> -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="billing_details"><?= !empty($this->lang->line('label_billing_details')) ? $this->lang->line('label_billing_details') : 'Billing Details'; ?></label>
                                                        <a href="#" class="btn btn-icon btn-sm" id="modal-edit-billing-address"><i class="far fa-edit"></i></a>
                                                        <address>
                                                            <span class="billing_name">--</span><br>
                                                            <span class="billing_address">--</span><br>
                                                            <span class="billing_city">--</span>,
                                                            <span class="billing_state">--</span>
                                                            <br>
                                                            <span class="billing_country">--</span>,
                                                            <span class="billing_zip">--</span><br>
                                                            <span class="billing_contact">--</span>
                                                        </address>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="name" id="name" value="">
                                                <textarea name="address" id="address" style="display:none;"></textarea>
                                                <input type="hidden" name="city" id="city" value="">
                                                <input type="hidden" name="state" id="state" value="">
                                                <input type="hidden" name="country" id="country" value="">
                                                <input type="hidden" name="zip_code" id="zip_code" value="">
                                                <input type="hidden" name="contact" id="contact" value="">



                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="note"><?= !empty($this->lang->line('label_note')) ? $this->lang->line('label_note') : 'Note'; ?></label>
                                                        <textarea type="textarea" class="form-control" placeholder=<?= !empty($this->lang->line('label_note')) ? $this->lang->line('label_note') : 'Note'; ?> name="note" id="note"></textarea>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="invoice_date"><?= !empty($this->lang->line('label_invoice_date')) ? $this->lang->line('label_invoice_date') : 'Invoice Date'; ?></label>
                                                        <input class="form-control" type="datetime-local" id="invoice_date" name="invoice_date" value="" autocomplete="off">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="due_date"><?= !empty($this->lang->line('label_due_date')) ? $this->lang->line('label_due_date') : 'Due Date'; ?></label>
                                                        <input class="form-control" type="datetime-local" id="due_date" name="due_date" value="" autocomplete="off">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="note"><?= !empty($this->lang->line('label_personal_note')) ? $this->lang->line('label_personal_note') : 'Personal Note'; ?></label>
                                                        <textarea type="textarea" class="form-control" placeholder=<?= !empty($this->lang->line('label_personal_note')) ? $this->lang->line('label_personal_note') : 'Personal Note'; ?> name="personal_note" id="personal_note"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <select class="custom-select select2" id="item_id" name="item_id">
                                                                <option value="" selected><?= !empty($this->lang->line('label_choose_item')) ? $this->lang->line('label_choose_item') : 'Choose Item'; ?>...</option>
                                                                <?php
                                                                foreach ($items as $item) { ?>
                                                                    <option value="<?= $item['id'] ?>"><?= $item['title'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                            <div class="wrapper" id="wrp" style="display: none;">
                                                                <hr><a href="#" id="modal-add-item" style="text-decoration: none;">+ <?= !empty($this->lang->line('label_add_item')) ? $this->lang->line('label_add_item') : 'Add Item'; ?></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="item_ids" id="item_ids">
                                                </div>
                                                <div class="col-md-12">
                                                    <!-- <div class="card"> -->
                                                    <!-- <div class="card-body"> -->

                                                    <div class="container-fluid">
                                                        <div class="row custom-table-header">

                                                            <div class="col-md-3 custom-col">
                                                                <?= !empty($this->lang->line('label_product_service')) ? $this->lang->line('label_product_service') : 'Product / Service'; ?>
                                                            </div>
                                                            <div class="col-md-3 custom-col">
                                                                <?= !empty($this->lang->line('label_description')) ? $this->lang->line('label_description') : 'Description'; ?>
                                                            </div>
                                                            <div class="col-md-1 custom-col">
                                                                <?= !empty($this->lang->line('label_quantity')) ? $this->lang->line('label_quantity') : 'Quantity'; ?>
                                                            </div>
                                                            <div class="col-md-1 custom-col">
                                                                <?= !empty($this->lang->line('label_unit')) ? $this->lang->line('label_unit') : 'Unit'; ?>
                                                            </div>
                                                            <div class="col-md-1 custom-col">
                                                                <?= !empty($this->lang->line('label_rate')) ? $this->lang->line('label_rate') : 'Rate'; ?>
                                                            </div>
                                                            <div class="col-md-1 custom-col">
                                                                <?= !empty($this->lang->line('label_tax')) ? $this->lang->line('label_tax') : 'Tax'; ?> %
                                                            </div>
                                                            <div class="col-md-1 custom-col">
                                                                <?= !empty($this->lang->line('label_amount')) ? $this->lang->line('label_amount') : 'Amount' . '(' . $currency . ')'; ?>
                                                            </div>
                                                            <div class="col-md-1 custom-col">
                                                                <?= !empty($this->lang->line('label_action')) ? $this->lang->line('label_action') : 'Action'; ?>
                                                            </div>
                                                            <!-- </div> -->
                                                        </div><br>

                                                        <div id="estimate_items">
                                                            <div class="estimate-item py-1">
                                                                <div class="row">
                                                                    <div class="col-md-3 custom-col">
                                                                        <input type="text" class="form-control" id="item_0_title" placeholder="Title">
                                                                    </div>
                                                                    <div class="col-md-3 custom-col">
                                                                        <textarea type="textarea" class="form-control" placeholder="Description" id="item_0_description"></textarea>
                                                                    </div>
                                                                    <div class="col-md-1 custom-col">
                                                                        <input type="number" class="form-control" id="item_0_quantity" min="1" placeholder="Qty">

                                                                    </div>
                                                                    <div class="col-md-1 custom-col">
                                                                        <select class="form-control" id="item_0_unit">
                                                                            <option value=""><?= !empty($this->lang->line('label_n_a')) ? $this->lang->line('label_n_a') : 'N/A'; ?></option>
                                                                            <?php

                                                                            foreach ($units as $unit) { ?>
                                                                                <option value="<?= $unit['id'] ?>"><?= $unit['title'] ?></option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-1 custom-col">
                                                                        <input type="number" class="form-control" id="item_0_rate" min="0" placeholder="Rate">
                                                                    </div>
                                                                    <div class="col-md-1 custom-col">
                                                                        <select class="form-control" id="item_0_tax">
                                                                            <option value="">0</option>
                                                                            <?php
                                                                            foreach ($taxes as $tax) { ?>
                                                                                <option value="<?= $tax['id'] ?>"><?= $tax['percentage'] ?></option>
                                                                            <?php } ?>
                                                                        </select>

                                                                    </div>
                                                                    <div class="col-md-1 custom-col">
                                                                        <input type="number" class="form-control" id="item_0_amount" min="0" placeholder="<?= get_currency_symbol(); ?>">
                                                                    </div>
                                                                    <div class="col-md-1 custom-col">
                                                                        <a href="#" class="btn btn-icon btn-success add-estimate-item"><i class="fas fa-check"></i></a>
                                                                    </div>

                                                                </div>

                                                            </div>

                                                        </div>
                                                        <hr>

                                                        <div class="row">
                                                            <div class="col-md-7"></div>
                                                            <div class="col-md-5">
                                                                <div class="form-group row align-items-center">
                                                                    <label for="site-title" class="form-control-label col-sm-3 text-md-right"><?= !empty($this->lang->line('label_subtotal')) ? $this->lang->line('label_subtotal') : 'Subtotal' . '(' . get_currency_symbol() . ')'; ?></label>
                                                                    <div class="col-sm-6 col-md-9">
                                                                        <input type="number" class="form-control" name="sub_total" id="sub_total" placeholder="0.00">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row align-items-center">
                                                                    <label for="site-title" class="form-control-label col-sm-3 text-md-right"><?= !empty($this->lang->line('label_tax')) ? $this->lang->line('label_tax') : 'Tax' . '(' . get_currency_symbol() . ')'; ?></label>
                                                                    <div class="col-sm-6 col-md-9">
                                                                        <input type="number" class="form-control" name="total_tax" id="total_tax" placeholder="0.00">
                                                                        <div class="taxes_applied"></div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row align-items-center">
                                                                    <label for="site-title" class="form-control-label col-sm-3 text-md-right"><?= !empty($this->lang->line('label_total')) ? $this->lang->line('label_total') : 'Total' . '(' . get_currency_symbol() . ')'; ?></label>
                                                                    <div class="col-sm-6 col-md-9">
                                                                        <input type="number" class="form-control" name="final_total" id="final_total" placeholder="0.00">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <hr>
                                                    <div class="row text-center">
                                                        <div class="col-md-3"></div>
                                                        <div class="card-footer col-md-6">
                                                            <button class="btn btn-primary mb-2" id="submit_button"><?= !empty($this->lang->line('label_submit')) ? $this->lang->line('label_submit') : 'Submit'; ?></button>
                                                            <div id="result" style="display: none;"></div>
                                                        </div>
                                                    </div>

                                                    <!-- <div class="row text-left col-md-8">
                                        
                                        </div> -->

                                                    <!-- </div> -->

                                                    <!-- </div> -->
                                                </div>
                                            </div>


                                    </div>

                                </div>

                            </div>



                        </div>

                        </form>
                    </div>


            </div>
        </div>
    </div>

    </section>
    <?= form_open('items/create', 'id="modal-add-item-part"', 'class="modal-part"'); ?>
    <div id="modal-item-title" class="d-none"><?= !empty($this->lang->line('label_add_item')) ? $this->lang->line('label_add_item') : 'Add Item'; ?></div>
    <input type="hidden" name="is_reload" id="is_reload" value="0">
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <div class="form-check form-check-inline">
                    <input class="form-check-input milestone_task" type="radio" name="task_type" value="milestone">
                    <label class="form-check-label"><?= !empty($this->lang->line('label_milestone')) ? $this->lang->line('label_milestone') : 'Milestone'; ?> &amp; <?= !empty($this->lang->line('label_task')) ? $this->lang->line('label_task') : 'Task'; ?></label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input milestone_task" type="radio" name="task_type" value="other">
                    <label class="form-check-label"><?= !empty($this->lang->line('label_other')) ? $this->lang->line('label_other') : 'Other'; ?></label>
                </div>
            </div>
        </div>

        <div class="col-md-6 task d-none">
            <div class="form-group">
                <label for="milestone_id"><?= !empty($this->lang->line('label_select_milestone')) ? $this->lang->line('label_select_milestone') : 'Select Milestone'; ?></label>
                <select name='milestone_id' id='milestone_id' onchange="get_task_milestone_data()" class='form-control select2'>
                    <option value=""><?= !empty($this->lang->line('label_choose')) ? $this->lang->line('label_choose') : 'Choose'; ?>...</option>
                    <?php foreach ($milestones as $milestone) { ?>
                        <option value="<?= $milestone['id'] ?>"><?= $milestone['m_title'] ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="col-md-6 task d-none">
            <div class="form-group">
                <label><?= !empty($this->lang->line('label_select_task')) ? $this->lang->line('label_select_task') : 'Select Task'; ?></label>
                <select class="form-control select2" name="task_id" id="task_id">
                    <option value="" selected><?= !empty($this->lang->line('label_choose')) ? $this->lang->line('label_choose') : 'Choose'; ?>...</option>
                </select>
            </div>
        </div>

        <div class="col-md-12 other d-none">
            <div class="form-group">
                <label><?= !empty($this->lang->line('label_title')) ? $this->lang->line('label_title') : 'Title'; ?> <span class="asterisk"> *</span></label>
                <div class="input-group">
                    <?= form_input(['name' => 'title', 'placeholder' => 'Title', 'class' => 'form-control']) ?>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label><?= !empty($this->lang->line('label_description')) ? $this->lang->line('label_description') : 'Description'; ?></label>
                <div class="input-group">
                    <?= form_textarea(['name' => 'description', 'placeholder' => !empty($this->lang->line('label_description')) ? $this->lang->line('label_description') : 'Description', 'class' => 'form-control']) ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label><?= !empty($this->lang->line('label_unit')) ? $this->lang->line('label_unit') : 'Unit'; ?></label>
                <select class="form-control" name="unit">
                    <option value=""><?= !empty($this->lang->line('label_n_a')) ? $this->lang->line('label_n_a') : 'N/A'; ?></option>
                    <?php
                    foreach ($units as $unit) { ?>
                        <option value="<?= $unit['id'] ?>"><?= $unit['title'] ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label><?= !empty($this->lang->line('label_price')) ? $this->lang->line('label_price') : 'Price'; ?></label><span class="asterisk"> *</span>
                <div class="input-group">
                    <?= form_input(['type' => 'number', 'name' => 'price', 'placeholder' => !empty($this->lang->line('label_price')) ? $this->lang->line('label_price') : 'Price', 'class' => 'form-control']) ?>
                </div>
            </div>
        </div>
    </div>
    </form>

    <form id="modal-edit-billing-address-part" class="modal-part">
        <div class="row">
            <!-- <div class="col-md-12"> -->
            <div class="form-group col-md-6">
                <label for="name"><?= !empty($this->lang->line('label_name')) ? $this->lang->line('label_name') : 'Name'; ?></label>
                <input name="update_name" id="update_name" class="form-control" placeholder=<?= !empty($this->lang->line('label_name')) ? $this->lang->line('label_name') : 'Name'; ?> value="">
            </div>
            <div class="form-group col-md-6">
                <label for="contact"><?= !empty($this->lang->line('label_contact')) ? $this->lang->line('label_contact') : 'Contact'; ?></label>
                <input name="update_contact" id="update_contact" class="form-control" placeholder=<?= !empty($this->lang->line('label_contact')) ? $this->lang->line('label_contact') : 'Contact'; ?> value="">
            </div>
            <div class="form-group col-md-12">
                <label for="address"><?= !empty($this->lang->line('label_address')) ? $this->lang->line('label_address') : 'Address'; ?></label>
                <textarea type="textarea" class="form-control" placeholder=<?= !empty($this->lang->line('label_address')) ? $this->lang->line('label_address') : 'Address'; ?> name="update_address" id="update_address"></textarea>
            </div>
            <!-- </div> -->

            <div class="form-group col-md-6 col-12">
                <label><?= !empty($this->lang->line('label_city')) ? $this->lang->line('label_city') : 'City'; ?></label>
                <input name="update_city" id="update_city" class="form-control" placeholder=<?= !empty($this->lang->line('label_city')) ? $this->lang->line('label_city') : 'City'; ?> value="">
            </div>

            <div class="form-group col-md-6 col-12">
                <label><?= !empty($this->lang->line('label_state')) ? $this->lang->line('label_state') : 'State'; ?></label>
                <input name="update_state" id="update_state" class="form-control" placeholder=<?= !empty($this->lang->line('label_state')) ? $this->lang->line('label_state') : 'State'; ?> value="">
            </div>

            <div class="form-group col-md-6 col-12">
                <label><?= !empty($this->lang->line('label_country')) ? $this->lang->line('label_country') : 'Country'; ?></label>
                <input name="update_country" id="update_country" class="form-control" placeholder=<?= !empty($this->lang->line('label_country')) ? $this->lang->line('label_country') : 'Country'; ?> value="">
            </div>

            <div class="form-group col-md-6 col-12">
                <label><?= !empty($this->lang->line('label_zip_code')) ? $this->lang->line('label_zip_code') : 'Zip Code'; ?></label>
                <input type="number" name="update_zip_code" id="update_zip_code" class="form-control" placeholder=<?= !empty($this->lang->line('label_zip_code')) ? $this->lang->line('label_zip_code') : 'Zip Code'; ?> value="">
            </div>


            <input type="hidden" name="id" id="id">
        </div>
    </form>

    <?php include('include-footer.php'); ?>

    </div>
    </div>
    <?php include('include-js.php'); ?>
</body>

<script>
    taxes = '<?php
                echo "<option value=>0</option>";
                foreach ($taxes as $tax) {

                    echo "<option value=" . $tax['id'] . ">" . $tax['percentage'] . "</option>";
                } ?>';
    units = '<?php
                echo "<option value=>N/A</option>";
                foreach ($units as  $unit) {
                    echo "<option value=" . $unit['id'] . ">" . $unit['title'] . "</option>";
                }
                ?>';
    currency = <?= " '$currency'"; ?>
</script>
<script src="<?= base_url('assets/js/page/components-invoice.js'); ?>"></script>

</html>