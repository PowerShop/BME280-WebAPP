<nav class="navbar navbar-expand bg-white shadow mb-4 topbar static-top navbar-light">
    <div class="container-fluid"><button class="btn btn-link d-md-none rounded-circle me-3" id="sidebarToggleTop" type="button"><i class="fas fa-bars"></i></button>
        <ul class="navbar-nav flex-nowrap ms-auto">

            <li class="nav-item dropdown no-arrow mx-1">
                <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#"><span class="badge bg-danger badge-counter">5+</span><i class="fas fa-bell fa-fw fa-lg"></i></a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-list animated--grow-in">
                        <h5 class="dropdown-header">ศูนย์การแจ้งเตือน</h5>

                        <!-- Account Alert -->
                        <?php
                        $icon;
                        $i = query("SELECT * FROM `alert-center` ORDER BY `id` DESC LIMIT 5");

                        // Check empty data
                        if ($i->rowCount() == 0) {
                            echo '<a class="dropdown-item d-flex align-items-center" href="#"><div class="me-3">
                                <div class="bg-primary icon-circle"><i class="fas fa-exclamation-triangle text-white"></i></div>
                            </div>
                            <div>
                                <span class="small text-gray-500">ไม่พบการแจ้งเตือน</span>
                                <p>ไม่พบการแจ้งเตือนใหม่</p>
                            </div>
                        </a>';
                        } else {
                            while ($row = $i->fetch(PDO::FETCH_ASSOC)) {
                                if ($row['alert_type'] == "account") {
                                    $icon = "fa-user";
                                    $bg = "bg-primary";
                                } else if ($row['alert_type'] == "system") {
                                    $icon = "fa-cogs";
                                    $bg = "bg-secondary";
                                } else if ($row['alert_type'] == "sensor") {
                                    $icon = "fa-thermometer-half";
                                    $bg = "bg-info";
                                } else if ($row['alert_type'] == "line") {
                                    $icon = "fa-comment";
                                    $bg = "bg-success";
                                } else if ($row['alert_type'] == "export") {
                                    $icon = "fa-file-export";
                                    $bg = "bg-warning";
                                }
                                else {
                                    $icon = "fa-exclamation-triangle";
                                    $bg = "bg-warning";
                                }
                                echo '<a class="dropdown-item d-flex align-items-center" href="#"><div class="me-3">
                                <div class="'.$bg.' icon-circle"><i class="fas '.$icon.' text-white"></i></div>
                            </div>
                            <div>
                                <span class="small text-gray-500">' . $row['alert_date'] . '</span>
                                <p>' . $row['alert_text'] . '</p>
                            </div>
                        </a>';
                            }
                        }
                        ?>
                        <!-- <a class="dropdown-item d-flex align-items-center" href="#"><div class="me-3">
                                <div class="bg-primary icon-circle"><i class="fas fa-file-alt text-white"></i></div>
                            </div>
                            <div>
                                <span class="small text-gray-500">December 12, 2019</span>
                                <p>A new monthly report is ready to download!</p>
                            </div>
                        </a><a class="dropdown-item d-flex align-items-center" href="#">
                            <div class="me-3">
                                <div class="bg-success icon-circle"><i class="fas fa-donate text-white"></i></div>
                            </div>
                            <div>
                                <span class="small text-gray-500">December 7, 2019</span>
                                <p>$290.29 has been deposited into your account!</p>
                            </div>
                        </a><a class="dropdown-item d-flex align-items-center" href="#">
                            <div class="me-3">
                                <div class="bg-warning icon-circle"><i class="fas fa-exclamation-triangle text-white"></i></div>
                            </div>
                            <div>
                                <span class="small text-gray-500">December 2, 2019</span>
                                <p>Spending Alert: We've noticed unusually high spending for your account.</p>
                            </div> -->
                        </a><a class="dropdown-item text-center small text-gray-500" href="?page=alertcenter">ดูการแจ้งเตือนทั้งหมด</a>
                    </div>
                </div>
            </li>
            <li class="nav-item dropdown no-arrow">
                <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#"><span class="d-none d-lg-inline me-2 text-gray-600 small"><?php echo $_SESSION['admin']; ?></span><img class="border rounded-circle img-profile" src="assets\img\avatars\it_was_me_min!.jpg"></a>
                    <div class="dropdown-menu shadow dropdown-menu-end animated--grow-in">
                        <a class="dropdown-item" href="?page=about"><i class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Profile</a>
                        <a class="dropdown-item" href="?page=settings"><i class="fas fa-cogs fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Settings</a>
                        <!-- <a class="dropdown-item" href="?page=activity"><i class="fas fa-list fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Activity log</a> -->
                        <div class="dropdown-divider"></div><a class="dropdown-item" href="?page=logout"><i class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Logout</a>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</nav>