/**
 * Chuyển mảng [{name, value}] → object { name:value, ... }
 */
const toObject = arr =>
    arr.reduce((o, { name, value }) => {
        value = $.trim(value);
        if (value !== '') o[name] = value;   // không đưa key nếu value rỗng
        return o;
    }, {});

function searchRmFormQueryParams(p) {
    const $f   = $('#rm-search-form');              // div bọc vùng lọc
    // lấy tất cả input/select/textarea có thuộc tính name
    const data = toObject($f.find(':input[name]').serializeArray());
    console.log("%c 1 --> Line: 11||components-assign-form-search.js\n data: ","color:#f0f;", data);

    return {
        ...queryParams(p),    // limit, offset, sort ...
        ...data               // customer_code, customer_name, phone ...
    };
}

function rmSearchForm() {
    $('#rm_clients_list').bootstrapTable('refresh');
}

function searchClientFormQueryParams(p) {
    const data = toObject(
        $('#searchClientForm').find(':input[name]').serializeArray()
    );
    console.log("%c 1 --> Line: 31||components-assign-form-search.js\n data: ","color:#f0f;", data);

    return {
        ...queryParams(p),   // limit, offset, sort …
        rmQuanLy : 'IS NULL',
        ...data              // customer_code, customer_name, phone, ...
    };
}

function searchClientForm() {
    $('#clients_list').bootstrapTable('refresh');
}