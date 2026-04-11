/* global echarts, chartQuality, chartRevenue, chartCategory, chartOutput */

$(document).ready(function() {

    var charts = {};

    function initChart(tabId) {
        if (charts[tabId]) {
            charts[tabId].resize();
            return;
        }

        if (tabId === 'tab-quality' && document.getElementById('chart-quality')) {
            charts[tabId] = echarts.init(document.getElementById('chart-quality'));
            charts[tabId].setOption({
                tooltip: { trigger: 'axis' },
                legend: { data: ['Passed', 'Failed'] },
                color: ['#28a745', '#dc3545'],
                xAxis: { type: 'category', data: chartQuality.categories },
                yAxis: { type: 'value' },
                series: chartQuality.series.map(function(s) {
                    return { name: s.name, type: 'line', smooth: true,
                             data: s.data, areaStyle: { opacity: 0.1 } };
                })
            });
        }

        if (tabId === 'tab-revenue' && document.getElementById('chart-revenue')) {
            charts[tabId] = echarts.init(document.getElementById('chart-revenue'));
            charts[tabId].setOption({
                tooltip: {
                    trigger: 'item',
                    formatter: function(p) {
                        return p.name + '<br>' + p.value.toLocaleString() + ' đ (' + p.percent + '%)';
                    }
                },
                legend: { orient: 'vertical', right: '5%', top: 'center' },
                series: [{
                    type: 'pie', radius: '65%', center: ['40%', '50%'],
                    data: chartRevenue,
                    label: { show: true, formatter: '{b}\n{d}%' }
                }]
            });
        }

        if (tabId === 'tab-category' && document.getElementById('chart-category')) {
            charts[tabId] = echarts.init(document.getElementById('chart-category'));
            charts[tabId].setOption({
                tooltip: { trigger: 'item', formatter: '{b}: {c} ({d}%)' },
                legend: { orient: 'vertical', right: '5%', top: 'center' },
                series: [{
                    type: 'pie', radius: ['40%', '65%'], center: ['40%', '50%'],
                    data: chartCategory, label: { show: false }
                }]
            });
        }

        if (tabId === 'tab-output' && document.getElementById('chart-output')) {
            charts[tabId] = echarts.init(document.getElementById('chart-output'));
            charts[tabId].setOption({
                tooltip: { trigger: 'axis' },
                legend: { data: ['Good', 'Defect'] },
                color: ['#28a745', '#dc3545'],
                xAxis: { type: 'category', data: chartOutput.categories },
                yAxis: { type: 'value' },
                series: chartOutput.series.map(function(s) {
                    return { name: s.name, type: 'bar', data: s.data };
                })
            });
        }
    }

    // Init tab đầu tiên
    initChart('tab-quality');

    // Chuyển tab
    $(document).on('shown.bs.tab', 'a[data-toggle="tab"]', function(e) {
        var href = $(e.target).attr('href');
        if (href) {
            var tabId = href.replace('#', '');
            initChart(tabId);
        }
    });

    // Resize
    window.addEventListener('resize', function() {
        Object.keys(charts).forEach(function(key) {
            charts[key].resize();
        });
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