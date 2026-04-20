/* global echarts, baseUrl */
let charts = {};

$(document).ready(function() {
    loadAllData();
    
    $('#btn-refresh').on('click', function() {
        const btn = $(this);
        btn.html('<i class="fas fa-spinner fa-spin"></i> Refreshing...').prop('disabled', true);
        loadAllData().always(() => {
            btn.html('<i class="fas fa-sync"></i> Refresh All Charts').prop('disabled', false);
        });
    });
    
    // Tab change
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
        const target = $(e.target).attr('href').replace('#', '');
        if (charts[target]) charts[target].resize();
    });

    $('#btn-print').on('click', function() {
        // Lấy tab đang active
        var activeTab = $('#presentationTabs .nav-link.active').attr('href');
        if(!activeTab) return;
        
        var tab = activeTab.replace('#tab-', '');
        var chartId = 'chart-' + tab;
        var tableId = 'table-' + tab;
        var chartEl = document.getElementById(chartId);
        var tableEl = document.getElementById(tableId);

        if (!tableEl) {
            alert('Không tìm thấy bảng: ' + tableId);
            return;
        }
        
        if (!chartEl) {
            alert('Không tìm thấy bieu do: ' + chartId);
            return;
        }

        // Tạo div tạm chứa cả biểu đồ + bảng
        var printDivId = 'temp-print-' + tab;
        var old = document.getElementById(printDivId);
        if (old) old.remove();

        var printDiv = document.createElement('div');
        printDiv.id  = printDivId;
        
        var canvas = chartEl.querySelector('canvas');
        if (canvas) {
            var cloneCanvas = document.createElement('canvas');
            cloneCanvas.width  = canvas.width;
            cloneCanvas.height = canvas.height;
            cloneCanvas.style.cssText = 'width:100%;max-width:700px;display:block;margin-bottom:16px;';
            var ctx = cloneCanvas.getContext('2d');
            ctx.drawImage(canvas, 0, 0);
            printDiv.appendChild(cloneCanvas);
        }

        // Lấy ảnh biểu đồ từ ECharts
        var chartKey = 'tab-' + tab;
        var chartImg = '';
        if (charts[chartKey]) {
            chartImg = charts[chartKey].getDataURL({
                type: 'png',
                pixelRatio: 2,
                backgroundColor: '#fff'
            });
        }
        
        var tableTag = tableEl.querySelector('table');
        if (tableTag) {
            printDiv.appendChild(tableTag.cloneNode(true));
        }

        document.body.appendChild(printDiv);
        printDiv.style.position = 'absolute';
//        printDiv.style.left     = '-9999px';
       
        printJS({
                printable: printDivId,
                type: 'html',
                style: 'canvas{width:100%;max-width:700px;display:block;margin-bottom:16px;} table{width:100%;border-collapse:collapse} th,td{border:1px solid #ddd;padding:8px;text-align:left} thead th{background:#333;color:#fff} tfoot th{background:#eee;font-weight:bold}',
                onPrintDialogClose: function() {
                    var el = document.getElementById(printDivId);
                    if (el) el.remove();
                }
        });
    });
});

function loadAllData() {
    return $.ajax({
        url: baseUrl + 'api/presentations/data',
        method: 'GET',
        success: function(res) {
            if (res.status === 'success') {
                //CHART
                renderQualityChart(res.chart_quality);
                renderRevenueChart(res.chart_revenue);
                renderCategoryChart(res.chart_category);
                renderOutputChart(res.chart_output);
                
                //TABLE
                renderQualityTable(res.quality_trend);
                renderRevenueTable(res.revenue_data);
                renderCategoryTable(res.category_data);
                renderOutputTable(res.monthly_output);
            }
        },
        error: function() {
            $('#alert-container').html('<div class="alert alert-danger">Không thể tải dữ liệu biểu đồ</div>');
        }
    });
}

function renderQualityChart(data) {
    const chart = echarts.init(document.getElementById('chart-quality'));
    chart.setOption({ 
        tooltip: { trigger: 'axis' }, 
        legend: { data: ['Passed', 'Failed'] },
        color: ['#28a745', '#dc3545'],
        xAxis: { type: 'category', data: data.categories },
        yAxis: { type: 'value' },
        series: data.series.map(function(s) {
            return { name: s.name, type: 'line', smooth: true,
                data: s.data, areaStyle: { opacity: 0.1 } };
        })
    });
    charts['tab-quality'] = chart;
}

function renderRevenueChart(data) {
    const chart = echarts.init(document.getElementById('chart-revenue'));
    chart.setOption({ 
        tooltip: {
            trigger: 'item',
            formatter: function(p) {
                return p.name + '<br>' + p.value.toLocaleString() + ' đ (' + p.percent + '%)';
            }
        },
        legend: { orient: 'vertical', right: '5%', top: 'center' },
        series: [{
            type: 'pie', radius: '65%', center: ['40%', '50%'],
            data: data,
            label: { show: true, formatter: '{b}\n{d}%' }
        }]
    });
    charts['tab-revenue'] = chart;
}

function renderCategoryChart(data) {
    const chart = echarts.init(document.getElementById('chart-category'));
    chart.setOption({ 
        tooltip: { trigger: 'item', formatter: '{b}: {c} ({d}%)' },
        legend: { orient: 'vertical', right: '5%', top: 'center' },
        series: [{
            type: 'pie', radius: ['40%', '65%'], center: ['40%', '50%'],
            data: data, label: { show: false }
        }]
    });
    charts['tab-category'] = chart;
}

function renderOutputChart(data) {
    const chart = echarts.init(document.getElementById('chart-output'));
    chart.setOption({ 
        tooltip: { trigger: 'axis' },
        legend: { data: ['Good', 'Defect'] },
        color: ['#28a745', '#dc3545'],
        xAxis: { type: 'category', data: data.categories },
        yAxis: { type: 'value' },
        series: data.series.map(function(s) {
            return { name: s.name, type: 'bar', data: s.data };
        })
    });
    charts['tab-output'] = chart;
}

// ==================== RENDER TABLES ====================
function renderQualityTable(data) {
    let html = '';
    data.forEach(q => {
        const total = q.passed + q.failed;
        const rate = total > 0 ? (q.failed / total * 100).toFixed(1) : 0;
        html += `
            <tr>
                <td>${q.month}</td>
                <td class="text-success font-weight-bold">${Number(q.passed).toLocaleString()}</td>
                <td class="text-danger font-weight-bold">${Number(q.failed).toLocaleString()}</td>
                <td><span class="badge badge-${rate > 10 ? 'danger' : (rate > 5 ? 'warning' : 'success')}">${rate}%</span></td>
            </tr>`;
    });
    $('#table-quality tbody').html(html);
}

function renderRevenueTable(data) {
    let total = data.reduce((sum, item) => sum + parseInt(item.value), 0);
    let html = '';
    data.forEach(r => {
        const pct = total > 0 ? (r.value / total * 100).toFixed(1) : 0;
        console.log(total);
        html += `
            <tr>
                <td>${r.name}</td>
                <td class="text-success font-weight-bold">${Number(r.value).toLocaleString()}</td>
                <td>
                    <div class="progress font-weight-bold" style="height:16px;">
                        <div class="progress-bar bg-success" style="width:${pct}%">${pct}%</div>
                    </div>
                </td>
            </tr>`;
    });
    $('#table-revenue tbody').html(html);
}

function renderCategoryTable(data) {
    let total = data.reduce((sum, item) => sum + parseInt(item.value), 0);
   
    let html = '';
    data.forEach(r => {
        const pct = total > 0 ? (r.value / total * 100).toFixed(1) : 0;
        html += `
            <tr>
                <td>${r.name}</td>
                <td class="text-success font-weight-bold">${Number(r.value).toLocaleString()} đ</td>
                <td>
                    <div class="progress font-weight-bold" style="height:16px;">
                        <div class="progress-bar bg-success" style="width:${pct}%">${pct}%</div>
                    </div>
                </td>
            </tr>`;
    });
    $('#table-category tbody').html(html);
}

function renderOutputTable(data) {
    let total = data.reduce((sum, item) => sum + item.value, 0);
    let html = '';
    let html_footer = '';
    let totalGood = 0, totalDefect = 0;
    data.forEach(m => {
        const good = parseInt(m.good_qty);
        const defect = parseInt(m.defect_qty);
        totalGood += good;
        totalDefect += defect;
        html += `<tr>
            <td>${m.month}</td>
            <td class="text-success font-weight-bold">${good.toLocaleString()}</td>
            <td class="text-danger font-weight-bold">${defect.toLocaleString()}</td>
            <td class="font-weight-bold">${(good + defect).toLocaleString()}</td>
        </tr>`;
    });
    $('#table-output tbody').html(html);
    $('#table-output tfoot').html(html_footer);
}

$(window).resize(() => {
    Object.values(charts).forEach(chart => chart && chart.resize());
});