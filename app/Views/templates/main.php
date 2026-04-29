<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= csrf_hash() ?>">
    <meta name="csrf-name"  content="<?= csrf_token() ?>">
    <title><?= $title ?? 'Dashboard' ?></title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('css/app.css') ?>">
</head>
<body>
    <div class="wrapper">

        <!-- Navbar / Header -->
        <?= view('templates/header', $data ?? []) ?>

        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar -->
                <?= view('templates/sidebar', $data ?? []) ?>
                <!-- Main Content -->
                <div class="main-content pt-3">
                    <?= view($page ?? 'dashboard/index', $data ?? []) ?>
                </div>
            </div>
        </div>

        <!-- Footer + Scripts -->
        <?= view('templates/footer', $data ?? []) ?>
        
        <div id="overlay"></div>

    </div> <!-- end wrapper -->

    
    <!-- 1. jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- 2. Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
   
    <!-- 3. ECharts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/echarts/5.4.3/echarts.min.js"></script>
      
    <!-- 4. DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
        
    <!-- 5. Print.js -->
    <script src="https://cdn.jsdelivr.net/npm/print-js@1.6.0/dist/print.min.js"></script>
    
    <!-- 6. JExcel -->
    <link rel="stylesheet" href="<?= base_url('css/jspreadsheet.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/jsuites.min.css') ?>">
    <script src="<?= base_url('js/jsuites.min.js') ?>"></script>
    <script src="<?= base_url('js/jspreadsheet.min.js') ?>"></script>
    
    <!-- Lodash (bắt buộc cho edgehandles) -->
    <script src="<?= base_url('js/lodash.min.js') ?>"></script>   
    
    <script src="<?= base_url('js/cytoscape.min.js') ?>"></script>

    <!-- Edgehandles - Dùng version mới nhất -->
     <script src="<?= base_url('js/cytoscape-edgehandles.js') ?>"></script>
    
    <!-- 7. App JS -->
    <script src="<?= base_url('js/app.js') ?>"></script>
    
    <script src="<?= base_url('js/sidebar.js') ?>"></script>
    
    <script src="<?= base_url('js/permissions.js') ?>"></script>


    <script>
        var baseUrl = '<?= base_url() ?>';
    </script>
    
    <!-- SheetJS -->
    <script src="https://cdn.jsdelivr.net/npm/xlsx/dist/xlsx.full.min.js"></script>


    <!-- 8. Page JS -->
    <?php if (isset($page_js)): ?>
        <script src="<?= base_url('js/' . $page_js) ?>"></script>
    <?php endif; ?>
        
        
        
</body>
</html>