function searchRmFormQueryParams(p) {
    return {
        ...queryParams(p),
        customer_code: $('#rm-search-form #customer_code').val(),
        customer_name: $('#rm-search-form #customer_name').val(),
        phone: $('#rm-search-form #phone').val(),
        identity: $('#rm-search-form #identity').val(),
        block: $('#rm-search-form #block').val(),
        frequency: $('#rm-search-form #frequency').val()
    };
}

function rmSearchForm() {
    $('#rm_clients_list').bootstrapTable('refresh');
}

// Đợi DOM được load
function searchClientFormQueryParams(p) {
    const $f = $('#searchClientForm');
    return {
        ...queryParams(p),
        rmQuanLy: "IS NULL",
        customer_code: $f.find('[name="customer_code"]').val().trim(),
        customer_name: $f.find('[name="customer_name"]').val().trim(),
        phone: $f.find('[name="phone"]').val().trim(),
        identity: $f.find('[name="identity"]').val().trim(),
        block: $f.find('[name="block"]').val(),
        frequency: $f.find('[name="frequency"]').val(),

        // ---- các field chỉ tồn tại trong 1 số context ----
        loaiKH: $f.find('[name="loaiKH"]').val(),   // campaigns_clients
        unit: $f.find('[name="unit"]').val(),     // client_page
        rm_manager: $f.find('[name="rm_manager"]').val()// client_page
    };
}

function searchClientForm() {
    $('#clients_list').bootstrapTable('refresh');
}