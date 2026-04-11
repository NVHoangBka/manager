/* global echarts, printJS */

$(document).ready(function() {
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
    
    // Doughnut Chart — sản phẩm theo category
    if (document.getElementById('doughnut-chart')) {
        var doughnut = echarts.init(document.getElementById('doughnut-chart'));
        doughnut.setOption({
        tooltip: { trigger: 'item', formatter: '{b}: {c} ({d}%)' },
        legend: { orient: 'vertical', right: '5%', top: 'center' },
        series: [{
            type: 'pie',
            radius: ['35%', '60%'],
            center: ['40%', '50%'],
            data: chartDoughnut,
            label: { show: false }
        }]
    });
    }
    
    // Biểu đồ Bar — sản lượng theo tháng
    if (document.getElementById('bar-chart')) {
        var bar = echarts.init(document.getElementById('bar-chart'));
        bar.setOption({
            tooltip: { trigger: 'axis' },
            legend: { data: chartBar.series.map(function(s){ return s.name; }) },
            xAxis: { type: 'category', data: chartBar.categories },
            yAxis: { type: 'value' },
            color: ['#28a745', '#dc3545'],
            series: chartBar.series.map(function(s) {
                return { name: s.name, type: 'bar', data: s.data };
            })
        });
    }

    // Line Chart: chất lượng theo tháng
    if (document.getElementById('line-chart')) {
        var line = echarts.init(document.getElementById('line-chart'));
        line.setOption({
            tooltip: { trigger: 'axis' },
            legend: { data: ['Passed', 'Failed'] },
            xAxis: { type: 'category',  data: chartLine.categories },
            yAxis: { type: 'value' },
            color: ['#28a745', '#dc3545'],
            series: chartLine.series.map(function(s) {
                return { name: s.name, type: 'line', smooth: true, data: s.data };
            })
        });
    }

    // Pie Chart doanh thu theo sản phẩm
    if (document.getElementById('pie-chart')) {
        var pie = echarts.init(document.getElementById('pie-chart'));
        pie.setOption({
            tooltip: {
                trigger: 'item',
                formatter: function(p) {
                    return p.name + ': ' + p.value.toLocaleString() + ' đ (' + p.percent + '%)';
                }
            },
            legend: { orient: 'vertical', right: '5%', top: 'center' },
            series: [{
                type: 'pie',
                radius: '65%',
                center: ['40%', '50%'],
                data: chartPie,
                label: { show: false }
            }]
        });
    }

    // Resize on window resize
    window.addEventListener('resize', function() {
        doughnut.resize(); bar.resize();
        line.resize(); pie.resize();
    });
    });