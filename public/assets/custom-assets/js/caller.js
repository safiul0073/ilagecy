const backgroundColor =["#FF0000", "#008000", "#FFA500", "#800000"];

(async function (params) {
    $('#date-range').datepicker({ toggleActive: true });
    $('.select2.select2-container.select2-container').addClass('w-100');

    let statuses = await $.ajax({ url: '/api/leads/count-status' });
    let labels = statuses.map(obj => obj.status_admin);
    let total = statuses.map(obj => obj.total);

    generateStats(statuses,total);

    renderPieChart(labels, total, backgroundColor);
})();

$('.filter-submit').on('click', async function (e) {
    e.preventDefault();
    const startDate = $('#start').val();
    const endDate = $('#end').val();
    const callerFilter = $('#caller_filter').val();

    let statuses = await $.post('/api/callers/filter-search', {
        startDate,
        endDate,
        callerFilter
    });
    if (statuses.length === 0) {
        renderNewChart();
        [...document.querySelectorAll('#stats ul li')].map(elem => elem.remove())
        document.querySelector('.chart-div').innerHTML = `<h1>Nothing Found</h1>`;
        return;
    }

    let labels = statuses.map(obj => obj.status_admin);
    let total = statuses.map(obj => obj.total);

    renderNewChart();
    generateStats(statuses,total);
    renderPieChart(labels, total, backgroundColor);
});

function renderNewChart() {
    $('#pie-chart').remove();
    $('.chartjs-size-monitor').remove();
    let newChart = document.createElement('canvas');
    newChart.id = 'pie-chart';
    document.querySelector('.chart-div').innerHTML = newChart.outerHTML;
}

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

function generateStats(statuses , total, ) {
    let allTotals = total.reduce((a, b) => a + b, 0);
    let stat = statuses.map(obj => `<li>${Math.ceil(obj.total/allTotals *100)}% ${obj.status_admin}</li>`);
    document.querySelector('#stats ul').innerHTML = stat.join("");
}





