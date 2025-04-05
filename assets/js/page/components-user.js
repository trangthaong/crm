"use strict";

function queryParams1(p){
  return {
    "user_id": $('#user_id').val(),
    "client_id": $('#client_id').val(),
    "type": $('#projects_type').val(),
    limit:p.limit,
    sort:p.sort,
    order:p.order,
    offset:p.offset,
    search:p.search
  };
}
function queryParams(p){
  return {
    "user_id": $('#user_id').val(),
    "client_id": $('#client_id').val(),
    "status": $('#projects_status').val(),
    limit:p.limit,
    sort:p.sort,
    order:p.order,
    offset:p.offset,
    search:p.search
  };
}

$('#fillter').on('click',function(e){
  e.preventDefault();
  $('#projects_list').bootstrapTable('refresh');
});

