let newStatusForFilter = '';
// pagination change
$.fn.DataTable.ext.pager.numbers_length = 17;
$('#date-range').datepicker({
    toggleActive: true,
});

$('#date-range input').each(function (){
    $(this).datepicker('setDate', 'now');
});


const table = $('#report-datatable').DataTable({
    processing: true,
    serverSide: true,
    searching: false,
    order: [[ 0, "desc" ]],
    ajax: {
        url: '/api/reports/get',
        data: function (d) {
            d.role = $('#role').val();
            d.from = $('#startDate').val();
            d.to = $('#endDate').val();
            d.status = newStatusForFilter;
            d.phone = $('#phone').val();
            d.orderId = $('#orderId').val();
            d.confirm = true
        }
    },
    columns: [
        {data: 'id', name: 'id'},
        {data: 'order_id', name: 'order_id'},
        {data: 'customer_id', name: 'customer_id'},
        {data: 'caller_id', name: 'caller_id'},
        {data: 'product_id', name: 'product_id'},
        {data: 'updated_at', name: 'updated_at'},
    ],
  //   dom: 'Bfrtip',
  // buttons: [
  // 'copy', 'csv', 'excel', 'pdf', 'print'
  // ],

    "fnDrawCallback": function(){
        handleLongPagination();
        handleGotoPage();
    }
});

$.fn.DataTable.Api.register( 'buttons.exportData()', function( options ) {
    if(this.context.length) {

      var src_keyword = $('.dataTables_filter input').val();

      // make columns for sorting
      var columns = [];
      $.each(this.context[0].aoColumns, function(key, value) {
        columns.push({
          'data' : value.data,
          'name' : value.name,
          'searchable' : value.bSearchable,
          'orderable' : value.bSortable
        });
      });

      // make option for sorting
      var order = [];
      $.each(this.context[0].aaSorting, function(key, value) {
        order.push({
          'column' : value[0],
          'dir' : value[1]
        });
      });

      // make value for search
      var search = {
        'value' : this.context[0].oPreviousSearch.sSearch,
        'regex' : this.context[0].oPreviousSearch.bRegex
      };

      var items = [];
      var status = $('#status').val();
      $.ajax({
        url: "/api/reports/get",
        // data: { columns: columns, order: order, search: search, status: status, page: 'all' },
        success: function (result) {
            console.log(result);

          $.each(result.data, function(key, value) {

            var item = [];

            item.push(key+1);
            item.push(value.username);
            item.push(value.email);
            item.push(value.created_at);
            item.push(value.status);

            items.push(item);
          });
        },
        async: false
      });

      return {
        body: items,
        // skip actions header
        header: $("#report_datatable thead tr th").map(function() {
          if(this.innerHTML!='Actions')
            return this.innerHTML;
        }).get()
      };
    }
  });




function handleLongPagination() {
    document.querySelector('#report-datatable_next').addEventListener('click',function(){
        table.page(table.page() + 14).draw(false)
    });
}

function handleGotoPage(){
    document.querySelector('#gotoPage').addEventListener('click',function(){
        let gotoPageNumber = $('#gotoPageNumber').val();
        table.page(gotoPageNumber - 1).draw(false)
    });
}

function handleFilteringSearch() {
    $('.filter-search-submit').on('click', function (e) {
      e.preventDefault();
        from = $("#startDate").val();
        to = $("#endDate").val();
        phone = $('#phone').val();
        orderId = $('#orderId').val();

        if ((from && to) || status || phone || orderId) {
            $('.loadingio-spinner-spinner-e1xmlecchsl').show();

            table.on('draw', function () {
                $('.loadingio-spinner-spinner-e1xmlecchsl').hide();
            });
            table.draw();
        }
    });

    $('.statuses #changeStatus').on('click', function (e) {
        e.preventDefault();
        newStatusForFilter = e.currentTarget.dataset.status;

        $('.loadingio-spinner-spinner-e1xmlecchsl').show();

        table.on('draw', function () {
            $('.loadingio-spinner-spinner-e1xmlecchsl').hide();
        });
        table.draw();
    });
}


window.addEventListener('load', function () {
    $('.select2.select2-container.select2-container').addClass('w-100');

    handleFilteringSearch();

    $('.loadingio-spinner-spinner-e1xmlecchsl').hide();
});