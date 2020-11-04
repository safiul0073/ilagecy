const backgroundColor =["#FF0000", "#008000", "#FFA500", "#800000"];

(async function (params) {
    $('#date-range').datepicker({ toggleActive: true });

    let statuses = await $.ajax({ url: '/api/leads/count-status' });
    let labels = statuses.map(obj => obj.status_admin)
    let total = statuses.map(obj => obj.total)
    renderPieChart(labels, total, backgroundColor);
})();

$('.date-submit').on('click', async function (e) {
    e.preventDefault();
    const startDate = $('#start').val();
    const endDate = $('#end').val();
    if (startDate && endDate) {
        let statuses = await $.post('/api/leads/date-search', {
            startDate,
            endDate
        });

        let labels = statuses.map(obj => obj.status_admin);
        let total = statuses.map(obj => obj.total);

        renderPieChart(labels, total, backgroundColor);
    }
});

function renderPieChart(labels, total , backgroundColor) {
    new Chart(document.getElementById("pie-chart"), {
        type: 'pie',
        data: {
            labels: labels.map(label => label.replace(/\b\w/, v => v.toUpperCase())),
            datasets: [{
                label: "Leads Status",
                backgroundColor: backgroundColor,
                data: total
            }]
        }
    });
}





