const table = $('#datatable').DataTable({
    processing: true,
    serverside: true,
    ajax: '/api/leads/get',
    columns: [
        { data: 'product_id', name: 'product_id' },
        { data: 'supplier_id', name: 'supplier_id' },
        { data: 'customer_id', name: 'customer_id' },
        { data: 'customer_phone', name: 'customer_phone' },
        { data: 'customer_address', name: 'customer_address' },
        { data: 'note', name: 'note' },
        { data: 'order_id', name: 'order_id' },
        { data: 'action', name: 'action' },
        { data: 'status_admin', name: 'status_admin' },
        { data: 'status_caller', name: 'status_caller' },
        { data: 'created_at', name: 'created_at' },
    ],
    "fnDrawCallback": function () {
        handleChangeStatus()
        handleNoteButton()
    }
});

function handleChangeStatus() {
    [...document.querySelectorAll('#change-status')].map(elem => {
        elem.addEventListener('click', async function (e) {
            e.preventDefault();
            const height = window.pageYOffset;
            $('.loadingio-spinner-spinner-e1xmlecchsl').show();
            $('.card').hide();
            let lead = await $.ajax({
                method: 'GET',
                url: '/api/leads/changeStatus',
                data: {
                    leadId: e.currentTarget.dataset.leadid,
                    status: e.currentTarget.dataset.status,
                }
            });
            table.ajax.reload(function () {
                $('.loadingio-spinner-spinner-e1xmlecchsl').hide();
                $('.card').show();
                window.scrollTo(0, height);
            }, false);
        })
    });
}


function handleNote() {
    document.querySelector('.saveNoteButton').addEventListener('click', async function () {
        const height = window.pageYOffset;
        currentNote = document.querySelector('textarea.note').value
        leadId = document.querySelector('textarea.note').dataset.leadid
        $('.card').hide();

        $("button[data-dismiss=\"modal\"]").click();
        $('.loadingio-spinner-spinner-e1xmlecchsl').show();

        let lead = await $.ajax({
            method: 'POST',
            url: '/api/leads/changeNote',
            data: {
                currentNote,
                leadId
            }
        });

        table.ajax.reload(function () {
            $('.loadingio-spinner-spinner-e1xmlecchsl').hide();
            $('.card').show();
            window.scrollTo(0, height);
        }, false);
    });
}

function handleNoteButton() {
    let currentNote;
    let leadId;
    [...document.querySelectorAll('.noteButton')].map(function (elem) {
        elem.addEventListener('click', function (e) {
            currentNote = e.currentTarget.dataset.note;
            leadId = e.currentTarget.dataset.leadid;
            document.querySelector('textarea.note').value = currentNote
            document.querySelector('textarea.note').dataset.leadid = leadId
        });
    }, false);
}


window.addEventListener('load', function () {
    $('.loadingio-spinner-spinner-e1xmlecchsl').hide();
    handleNote()
});







// Function rendering after pagination
// function reRenderChangeStatus() {
//     [...document.querySelectorAll('a.paginate_button')].map(elem => {
//         elem.addEventListener('click', function () {
//             handleChangeStatus();
//         });
//     });
// }

// Function rendering after search
// function inputChangeStatus() {
//     document.querySelector('#datatable_filter label input').addEventListener('change', function () {
//         handleChangeStatus();
//     });
// }