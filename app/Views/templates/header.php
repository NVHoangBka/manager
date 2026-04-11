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
                      <a class="nav-link d-flex align-items-center dropdown-toggle dropdown-language" id="dropdown-flag" href="javascript:;" data-toggle="dropdown">
                          <img class="langimg selected-flag mr-2" src="<?= base_url('uploads/flag/us.png')?>"">
                          <span class="selected-language d-md-flex d-none">English</span>
                      </a>
                      <div class="dropdown-menu dropdown-menu-right text-left" aria-labelledby="dropdown-flag">
                          <a class="dropdown-item py-3" data-language="en">
                              <img class="langimg mr-2" src="<?= base_url('uploads/flag/us.png')?>">
                              <span class="font-small-3">English</span>
                          </a>
                          <a class="dropdown-item py-3" data-language="korea">
                              <img class="langimg mr-2" src="<?= base_url('uploads/flag/korea.png')?>"">
                              <span class="font-small-3">Korea</span>
                          </a>
                          <a class="dropdown-item py-3" data-language="vn">
                              <img class="langimg mr-2" src="<?= base_url('uploads/flag/vn.png')?>"">
                              <span class="font-small-3">Vietnamese</span>
                          </a>
                      </div>
                  </li>

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
                                      <span class="noti-title">7 New Notification</span>
                                  </div>
                              </div>
                          </li>

                          <li class="scrollable-container ps">
                          </li>
                      <li class="dropdown-menu-footer">
                        <div class="noti-footer text-center cursor-pointer primary border-top text-bold-400 py-1">Read All Notifications</div>
                      </li>
                    </ul>
                  </li>

                  <li class="dropdown mr-1">
                      <a class="nav-link dropdown-toggle user-dropdown d-flex align-items-center" id="dropdownBasic2" data-toggle="dropdown">
                          <div class="user d-md-flex d-none mr-2">
                              <span class="text-right"><?= $user['full_name'] ?? 'User' ?></span>
                          </div>
                      </a>

                      <div class="dropdown-menu text-left dropdown-menu-right m-0 pb-0" aria-labelledby="dropdownBasic2">
                          <a class="dropdown-item" href="page-user-profile.html">
                              <div class="d-flex align-items-center">
                                  <i class="ft-edit mr-2"></i>
                                  <span>Edit Profile</span>
                              </div>
                          </a>
                          <a class="dropdown-item" href="app-email.html">
                              <div class="d-flex align-items-center">
                                  <i class="ft-mail mr-2"></i>
                                  <span>My Inbox</span>
                              </div>
                          </a>
                          <div class="dropdown-divider"></div>
                          <a class="dropdown-item" href="<?= base_url('logout') ?>">
                              <div class="d-flex align-items-center">
                                  <i class="ft-power mr-2"></i>
                                  <span>Logout</span>
                              </div>
                          </a>
                    </div>
                  </li>
                </ul>
            </div>
        </div>
    </div>
  </nav>
