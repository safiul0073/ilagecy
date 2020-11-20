let duplicateLeadId ='';
let customerId ='';
const duplicateTable = $('#duplicate_datatable').DataTable({
    processing: true,
    serverSide: true,
    scrollX: true,
    ajax: {
        url: '/api/leads/duplicate/get',
        data: function (d) {
            d.duplicateLeadId = duplicateLeadId;
            d.customerId = customerId;
        }
    },
    columns: [
        { data: 'id', name: 'id'},
        { data: 'product_id', name: 'product_id'},
        { data: 'phone', name: 'phone'},
        { data: 'order_id', name: 'order_id'},
        { data: 'status_admin', name: 'status_admin'},
        { data: 'status_caller', name: 'status_caller'},
        { data: 'created_at', name: 'created_at'}
    ],
    "fnDrawCallback": function () {

    }
});


function handleDuplicate() {
    $('.duplicate_btn').on('click', function (e) {
        e.preventDefault();
        duplicateLeadId = e.currentTarget.dataset.parent
        customerId = e.currentTarget.dataset.customerid

        $('.loadingio-spinner-spinner-e1xmlecchsl').show();

        duplicateTable.on('draw', function () {
            $('.loadingio-spinner-spinner-e1xmlecchsl').hide();
        });
        duplicateTable.draw();
    });
}

