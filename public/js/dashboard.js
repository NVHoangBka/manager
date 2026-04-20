/* global echarts, baseUrl, printJS */
let barChart, lineChart, doughnutChart, pieChart;

$(document).ready(function() {
    loadDashboardData();
    
    // Refresh button
   $('#btn-refresh').on('click', function() {
        const btn = $(this);
        btn.html('<i class="fas fa-spinner fa-spin"></i> Đang tải...').prop('disabled', true);
        
        loadDashboardData().always(() => {
            btn.html('<i class="fas fa-sync"></i> Refresh Data').prop('disabled', false);
        });
    });
    
    // DataTables
    if ($('#data-table').length) {
        $('#data-table').DataTable({
            language: {
                search: "Search",
                lengthMenu: "Length Menu",
                info: "",
                paginate: { previous: "Pre", next: "Next" }
            }
        });
    }
    
    // Print.js
    if ($('#btn-print').length) {
        $('#btn-print').on('click', function() {
            printJS({
                printable: 'printable-table',
                type: 'html',
                style: 'table{width:100%;border-collapse:collapse} th,td{border:1px solid #ddd;padding:8px}'
            });
        });
    }
});

function loadDashboardData() {

    //LOAD CARDS
    $.ajax({
        url: baseUrl + 'api/dashboard/cards',
        method: 'GET',
        success: function(res) {
            if (res.status === 'success') {
                $('#new-orders').text(Number(res.data.new_orders).toLocaleString());
                $('#defect-rate').text(res.data.bounce_rate);
                $('#active-users').text(Number(res.data.user_registrations).toLocaleString());
                $('#total-products').text(Number(res.data.products_length).toLocaleString());
            }
        }
    });
    
    // LOAD CHARTS
    $.ajax({
        url: baseUrl + 'api/dashboard/charts',
        method: 'GET',
        success: function(res) {
            if (res.status === 'success') {
                renderBarChart(res.data.bar);
                renderLineChart(res.data.line);
                renderDoughnutChart(res.data.doughnut);
                renderPieChart(res.data.pie);
            }
            $('#btn-refresh').html('<i class="fas fa-sync"></i> Refresh Data');
        },
        error: function() {
            $('#btn-refresh').html('<i class="fas fa-sync"></i> Refresh Data');
        }
    });
}

// ==================== RENDER CHARTS ====================
function renderBarChart(data) {
    if (!document.getElementById('bar-chart')) return;
    if (barChart) barChart.dispose();
    barChart = echarts.init(document.getElementById('bar-chart'));
    barChart.setOption({
        tooltip: { trigger: 'axis' },
        legend: { data: ['Good', 'Defect'] },
        xAxis: { type: 'category', data: data.map(item => item.month) },
        yAxis: { type: 'value' },
        series: [
            { name: 'Good', type: 'bar', data: data.map(item => parseInt(item.good_qty)), color: '#28a745' },
            { name: 'Defect', type: 'bar', data: data.map(item => parseInt(item.defect_qty)), color: '#dc3545' }
        ]
    });
}

function renderLineChart(data) {
    if (!document.getElementById('line-chart')) return;
    if (lineChart) lineChart.dispose();
    
    lineChart = echarts.init(document.getElementById('line-chart'));
    lineChart.setOption({
        tooltip: { trigger: 'axis' },
        legend: { data: ['Passed', 'Failed'] },
        xAxis: { type: 'category', data: data.map(item => item.month) },
        yAxis: { type: 'value' },
        series: [
            { name: 'Passed', type: 'line', smooth: true, data: data.map(item => parseInt(item.passed)), color: '#28a745' },
            { name: 'Failed', type: 'line', smooth: true, data: data.map(item => parseInt(item.failed)), color: '#dc3545' }
        ]
    });
}

function renderDoughnutChart(data) {
    if (!document.getElementById('doughnut-chart')) return;
    if (doughnutChart) doughnutChart.dispose();
    
    doughnutChart = echarts.init(document.getElementById('doughnut-chart'));
    doughnutChart.setOption({
        tooltip: { trigger: 'item', formatter: '{b}: {c} ({d}%)' },
        legend: { orient: 'vertical', right: '10%', top: 'center' },
        series: [{
            type: 'pie',
            radius: ['40%', '70%'],
            data: data.map(item => ({ value: parseInt(item.value), name: item.name }))
        }]
    });
}

function renderPieChart(data) {
    if (!document.getElementById('pie-chart')) return;
    if (pieChart) pieChart.dispose();
    
    pieChart = echarts.init(document.getElementById('pie-chart'));
    pieChart.setOption({
        tooltip: { trigger: 'item', formatter: '{b}: {c} ({d}%)' },
        legend: { orient: 'vertical', right: '10%', top: 'center' },
        series: [{
            type: 'pie',
            radius: '65%',
            data: data.map(item => ({ value: parseInt(item.value), name: item.name }))
        }]
    });
}

// Resize charts when window resizes
$(window).on('resize', function() {
    if (barChart) barChart.resize();
    if (lineChart) lineChart.resize();
    if (doughnutChart) doughnutChart.resize();
    if (pieChart) pieChart.resize();
});