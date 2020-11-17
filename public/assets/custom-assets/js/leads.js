let editLeadData = [];
const table = $('#datatable').DataTable({
    processing: true,
    serverSide: true,
    scrollX: true,
    searching: false,
    // scrollY: true,
    ajax: {
        url: '/api/leads/get',
        data: function (d) {
            d.from = $('#startDate').val();
            d.to = $('#endDate').val();
            d.status = $('#status_filter').val();
            d.phone = $('#phone').val();
            d.orderId = $('#orderId').val();
        }
    },
    columns: [
        { data: 'product_id', name: 'product_id' },
        { data: 'supplier_id', name: 'supplier_id' },
        { data: 'customer_id', name: 'customer_id' },
        { data: 'customer_phone', name: 'customer_phone' },
        { data: 'customer_address', name: 'customer_address' },
        { data: 'note', name: 'note' },
        { data: 'order_id', name: 'order_id', searchable: false },
        { data: 'action', name: 'action', searchable: false },
        { data: 'status_admin', name: 'status_admin' },
        { data: 'status_caller', name: 'status_caller' },
        { data: 'created_at', name: 'created_at' },
        { data: 'postback', name: 'postback', searchable: false },
    ],
    "fnDrawCallback": function () {
        handleChangeStatus();
        handleNoteButton();
        handleEditButton();
        // reRenderPagination();
        handleDeleteLead();
        handlePostbackButton();
    }
});

function handleChangeStatus() {
    [...document.querySelectorAll('#change-status')].map(elem => {
        elem.addEventListener('click', async function (e) {
            e.preventDefault();
            const height = window.pageYOffset;
            $('.loadingio-spinner-spinner-e1xmlecchsl').show();

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

function handleDeleteLead() {
    [...document.querySelectorAll('#deleteLead')].map(elem => {
        elem.addEventListener('click', async (e) => {
            e.preventDefault();
            const height = window.pageYOffset;
            if (confirm("Are you sure to delete lead?")) {
                const leadId = e.target.dataset.leadid;


                $('.loadingio-spinner-spinner-e1xmlecchsl').show();

                let lead = await $.ajax({
                    method: 'DELETE',
                    url: '/api/leads/delete',
                    data: {
                        leadId
                    }
                });

                table.ajax.reload(function () {
                    alert('Lead Deleted!');
                    $('.loadingio-spinner-spinner-e1xmlecchsl').hide();

                    window.scrollTo(0, height);
                }, false);
            } else {
                return;
            }
        });
    });
}

function handleEditButton() {

    [...document.querySelectorAll('.change-lead')].map(function (elem) {
        elem.addEventListener('click', function (e) {
            const data = Object.entries(e.currentTarget.dataset);
            editLeadData = []

            data.shift();
            data.shift();

            data.map(field => {
                if (document.querySelector(`.${field[0]}`)) {
                    document.querySelector(`.${field[0]}`).value = field[1];
                }
            });

            data.map(field => {
                editLeadData.push({
                    [field[0]]: field[1]
                });
            });

        });
    });
}

function handleEdit() {
    document.querySelector('.saveEditButton').addEventListener('click', async function () {
        const height = window.pageYOffset;
        $("button[data-dismiss=\"modal\"]").click();
        $('.loadingio-spinner-spinner-e1xmlecchsl').show();

        let data = {};
        data.name = document.querySelector('#editFields.name').value
        data.phone = document.querySelector('#editFields.phone').value
        data.email = document.querySelector('#editFields.email').value
        data.address = document.querySelector('#editFields.address').value
        data.callerstatus = document.querySelector('#editFields.callerstatus').value
        data.lead_id = editLeadData[0].leadid

        let lead = await $.ajax({
            method: 'PATCH',
            url: '/api/leads/update',
            data: {
                data
            }
        });


        table.ajax.reload(function () {
            $('.loadingio-spinner-spinner-e1xmlecchsl').hide();

            window.scrollTo(0, height);
        }, false);
    });
}

function handlePostbackButton() {
    [...document.querySelectorAll('.postback-confirm')].map(function (elem) {
        elem.addEventListener('click', async function (e) {
            e.preventDefault();
            const height = window.pageYOffset;

            $('.loadingio-spinner-spinner-e1xmlecchsl').show();

            const data = Object.entries(e.currentTarget.dataset);
            let postbackData = {};
            data.map(field => {
                postbackData[field[0]] = field[1]
            });

            let lead = await $.ajax({
                method: 'POST',
                url: '/api/leads/postback-endpoint',
                data: {
                    data: postbackData
                }
            });

            table.ajax.reload(function () {
                $('.loadingio-spinner-spinner-e1xmlecchsl').hide();

                window.scrollTo(0, height);
            }, false);

        });
    });
}

function handleFilteringSearch() {
    $('.filter-search-submit').on('click', function () {
        from = $("#startDate").val();
        to = $("#endDate").val();
        status = $('#status_filter').val();
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
}

window.addEventListener('load', function () {
    $('#date-range').datepicker({ toggleActive: true });
    $('.select2.select2-container.select2-container').addClass('w-100');

    handleFilteringSearch();
    handleNote();
    handleEdit();
});



// Function rendering after pagination
// function reRenderPagination() {
//     [...document.querySelectorAll('a.paginate_button')].map(elem => {
//         elem.addEventListener('click', function () {
//             // after pagination it will change
//         });
//     });
// }

// Function rendering after search
// function inputChangeStatus() {
//     document.querySelector('#datatable_filter label input').addEventListener('change', function () {
//         handleChangeStatus();
//     });
// }