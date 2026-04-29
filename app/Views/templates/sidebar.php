<div id='sidebar' 
     class="app-sidebar menu-fixed position-fixed shadow-lg" 
     data-background-color="man-of-steel" 
     data-image="url('/uploads/image/bg.jpg')" 
     data-scroll-to-active="true" 
     style="z-index: 200; top: 0; left: 0; min-width: 280px; transition: all 0.3s ease; touch-action: none; user-select: none; -webkit-user-drag: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);">

    <!-- Sidebar Header starts-->
    <div class="sidebar-header py-3 px-2">
        <div class="logo clearfix d-flex align-items-center justify-content-between">
            <a class="logo-text d-flex align-items-center float-left text-decoration-none text-body font-weight-bold" href="<?= base_url('dashboard') ?>">
                <div class="logo-img">
                    <img src="<?= base_url('/uploads/image/logo.png') ?>" alt="Innoflow Logo" style="height: 30px;">
                </div>
                <h5 id="logo-text" class="text text-white">INNOFLOW TH</h5>
            </a>
            <a class="nav-toggle d-none d-lg-none d-xl-block is-active text-prmary" id="sidebarToggle">
                <i class="toggle-icon bi bi-toggle-on" data-toggle="expanded" style="font-size: 24px"></i>               
            </a>
            <a class="nav-close d-block d-lg-block d-xl-none" id="sidebarClose">
                <i class="bi bi-x" style="font-size: 24px"></i>
            </a>
        </div>
    </div>
    
    <!-- Sidebar Content-->
    <div class="sidebar-content main-menu-content expanded" style="overflow-y: auto; height: 100vh">
        <div class="nav-container">
            <ul class="list-group navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation" >
                <li class="d-block position-relative nav-item <?= ($page === 'dashboard/index') ? 'sidebar-group-active' : '' ?>">
                    <a class="d-block py-3 px-4  bg-transparent text-white text-decoration-none" href="<?= base_url('dashboard') ?>"
                       data-title="Dashboard">
                        <i class="bi bi-house-door"></i>
                        <span class="menu-title ml-2" data-i18n="Dashboard"><?= lang('app.dashboard') ?></span>
                    </a>
                </li>
          
                <li class="d-block position-relative nav-item <?= ($page === 'users/index') ? 'sidebar-group-active' : '' ?>">
                    <a class="d-block py-3 px-4 bg-transparent text-white text-decoration-none" href="<?= base_url('users') ?>">
                        <i class="bi bi-person"></i>
                        <span class="menu-title ml-2" data-i18n="Users"><?= lang('app.users') ?></span>
                    </a>
                </li>
          
                <li class="d-block position-relative nav-item">
                    <div class="d-flex justify-content-between align-items-center py-3 px-4 bg-transparent text-white text-decoration-none">
                        <div>
                            <i class="bi bi-box"></i>
                            <span class="menu-title ml-2" data-i18n="Products"><?= lang('app.products') ?></span>
                        </div>
                        <i class="bi bi-chevron-right menu-arrow float-right mt-1" style="transition: transform 0.2s;"></i>
                    </div>
                    <ul class="menu-content pl-5 d-none">
                <li class="d-block position-relative nav-item <?= ($page === 'products/index') ? 'sidebar-group-active' : '' ?>">
                    <a class="d-block py-3 px-4 bg-transparent text-white text-decoration-none" href="<?= base_url('products') ?>">
                                <i class="bi bi-table"></i>
                                <span class="menu-title ml-2" data-i18n="Products"><?= lang('app.table_product') ?></span>
                    </a>
                </li>
                        <li class="d-block position-relative nav-item <?= ($page === 'products_info/index') ? 'sidebar-group-active' : '' ?>">
                            <a class="d-block py-3 px-4 bg-transparent text-white text-decoration-none" href="<?= base_url('products-info') ?>">
                                <i class="bi bi-info-circle"></i>
                                <span class="menu-title ml-2" data-i18n="ProductsInfo"><?= lang('app.product_info') ?></span>
                            </a>
                        </li>
                    </ul>
                </li>
          
                <li class="d-block position-relative nav-item <?= ($page === 'presentations/index') ? 'sidebar-group-active' : '' ?>">
                    <a class="d-block py-3 px-4 bg-transparent text-white text-decoration-none" href="<?= base_url('presentations') ?>">
                        <i class="bi bi-graph-up-arrow"></i>
                        <span class="menu-title ml-2" data-i18n="Presentations"><?= lang('app.presentations') ?></span>
                    </a>
                </li>
                <li class="d-block position-relative nav-item <?= ($page === 'materials/index') ? 'sidebar-group-active' : '' ?>">
                    <a class="d-block py-3 px-4 bg-transparent text-white text-decoration-none" href="<?= base_url('materials') ?>">
                        <i class="bi bi-boxes"></i>
                        <span class="menu-title ml-2" data-i18n="Materials"><?= lang('app.materials') ?></span>
                    </a>
                </li>
                <li class="d-block position-relative nav-item <?= ($page === 'process/index') ? 'sidebar-group-active' : '' ?>">
                    <a class="d-block py-3 px-4 bg-transparent text-white text-decoration-none" href="<?= base_url('process') ?>">
                        <i class="bi bi-diagram-3"></i>
                        <span class="menu-title ml-2" data-i18n="Process"><?= lang('app.process') ?></span>
                    </a>
                </li>
                <li class="d-block position-relative nav-item <?= ($page === 'permissions') ? 'sidebar-group-active' : '' ?>">
                    <a class="d-block py-3 px-4 bg-transparent text-white text-decoration-none" href="<?= base_url('permissions') ?>">
                        <i class="bi bi-key-fill"></i>
                        <span class="menu-title ml-2" data-i18n="permissions"><?= lang('app.department-permissions') ?></span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
            <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;">
            </div>
        </div>
        <div class="ps__rail-y" style="top: 0px; height: 418px; right: 0px;">
            <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 176px;">
            </div>
        </div>
    </div>
</div>

