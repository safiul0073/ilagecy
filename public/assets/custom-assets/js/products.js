const userTable = $('#product-datatable').DataTable({
    processing: true,
    serverSide: true,
    order: [[ 0, "desc" ]],
    ajax: {
        url: '/api/products/get'
    },
    columns: [
        {data: 'id', name: 'id'},
        {data: 'name', name: 'name'},
        {data: 'note', name: 'note'},
        {data: 'action', name: 'action'},
    ],
    "fnDrawCallback": function(){
        handleUserDelete();
    }
});

function handleUserDelete(){
    $('.delete-product').on('click',function(e){
        e.preventDefault();

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
            if (result.value) {
                let url = $(this).attr("href");
                $.ajax({
                    type: 'DELETE',
                    url: url,
                    data: {
                        "_token":  $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(result){
                        Swal.fire(
                        'Deleted!',
                        result.success,
                        'success'
                        )
                        setTimeout(() => {
                            location.reload();
                        }, 2000);
                    }
                });
            }
        })
    });
}

setTimeout(function(){
    $('.alert').hide();
},5000);