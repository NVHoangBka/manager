<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light header-navbar navbar-fixed border-bottom">
    <div class="container-fluid navbar-wrapper justify-content-end align-items-center">
        <div class="navbar-left">
            <div class="navbar-toggle menu-toggle d-xl-none d-block float-left align-items-center justify-content-center" data-toggle="collapse">
                <i class="bi bi-list"></i>
            </div>
        </div>
        <div class="navbar-container">
            <div class="collapse navbar-collapse d-block" id="navbarSupportedContent">
                <ul class="navbar-nav d-flex align-items-center gap-2">
                    <li class="i18n-dropdown dropdown mr-2">
                        <button class="btn btn-light dropdown-toggle" type="button" data-toggle="dropdown">
                            <?php
                                $currentLang = session('lang') ?? 'en';
                                $flags = [
                                    'vi' => base_url('uploads/flag/vi.png'),
                                    'en' => base_url('uploads/flag/us.png'),
                                    'ko' => base_url('uploads/flag/korea.png')
                                ];
                                $langNames = [
                                    'vi' => 'Tiếng Việt',
                                    'en' => 'English',
                                    'ko' => '한국어'
                                ];
                            ?>
                            <img src="<?= $flags[$currentLang] ?>" class="mr-2 rounded" alt="">
                            <span><?= $langNames[$currentLang] ?></span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-flag">
                            <a class="dropdown-item py-3" href="<?= base_url('switch-lang/vi') ?>">
                                <img class="langimg mr-2" src="<?= base_url('uploads/flag/vi.png') ?>" width="20">
                                <span><?= lang('app.vietnamese') ?></span>
                            </a>
                            <a class="dropdown-item py-3" href="<?= base_url('switch-lang/en') ?>">
                                <img class="langimg mr-2" src="<?= base_url('uploads/flag/us.png') ?>" width="20">
                                <span><?= lang('app.english') ?></span>
                            </a>
                            <a class="dropdown-item py-3" href="<?= base_url('switch-lang/ko') ?>">
                                <img class="langimg mr-2" src="<?= base_url('uploads/flag/korea.png') ?>" width="20">
                                <span><?= lang('app.korean') ?></span>
                            </a>
                        </div>
                    </li>

                    <!-- Notification -->
                    <li class="dropdown">
                        <a class="nav-link dropdown-notification p-0 mt-2 position-relative" id="dropdownBasic1" data-toggle="dropdown">
                            <i class="bi bi-bell" style="font-size: 20px;"></i>
                            <span class="notification badge badge-pill badge-danger position-absolute" style="top: 0;right: 0;transform: translateY(-25%) translateX(25%)">4</span>
                        </a>
                        <ul class="notification-dropdown dropdown-menu dropdown-menu-right m-0 p-0 overflow-hidden w-auto">
                            <li class="dropdown-menu-header">
                                <div class="dropdown-header d-flex justify-content-between m-0 p-3 bg-dark text-white">
                                    <div class="d-flex">
                                        <i class="bi bi-bell d-flex align-items-center mr-2"></i>
                                        <span class="noti-title"><?= lang('app.notifications') ?></span>
                                    </div>
                                </div>
                            </li>
                            <!-- Notifications content -->
                        </ul>
                    </li>

                    <!-- User Dropdown -->
                    <li class="dropdown mr-1">
                        <a class="nav-link dropdown-toggle user-dropdown d-flex align-items-center" id="dropdownBasic2" data-toggle="dropdown">
                            <div class="user d-md-flex d-none mr-2">
                                  <span class="text-right"><?= esc($user['full_name'] ?? 'User') ?></span>
                            </div>
                        </a>
                        <div class="dropdown-menu text-left dropdown-menu-right m-0 pb-0" aria-labelledby="dropdownBasic2">
                            <a class="dropdown-item" href="#">
                                <div class="d-flex align-items-center">
                                    <i class="ft-edit mr-2"></i>
                                    <span><?= lang('app.edit_profile') ?></span>
                                </div>
                            </a>
                            <a class="dropdown-item" href="#">
                                <div class="d-flex align-items-center">
                                    <i class="ft-mail mr-2"></i>
                                    <span><?= lang('app.my_inbox') ?></span>
                                </div>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-danger" href="<?= base_url('logout') ?>">
                                <div class="d-flex align-items-center">
                                    <i class="ft-power mr-2"></i>
                                    <span><?= lang('app.logout') ?></span>
                                </div>
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
  </nav>
