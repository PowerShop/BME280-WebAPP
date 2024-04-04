<!-- Alert Center to Show all alert -->
<!-- Show all alert in table -->
<div class="container">
    <h1 class="mt-4">Alert Center</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="?page=dashboard">Dashboard</a></li>
        <li class="breadcrumb-item active">Alerts Center</li>
    </ol>
    <div class="alert alert-primary" role="alert">
        <h4 class="alert-heading">ศูนย์กลางการแจ้งเตือน</h4>
        <p>คุณสามารถดูการแจ้งเตือนทั้งหมดที่ระบบสร้างขึ้น คุณยังสามารถดูประเภทการแจ้งเตือน ข้อความแจ้งเตือน และวันที่แจ้งเตือนได้</p>
        <hr>
        <?php
        $limit = 20;
        if (isset($_GET['type'])) {
            $type = $_GET['type'];
        } else {
            $type = "all";
        }
        if (isset($_GET['limit'])) {
            $limit = $_GET['limit'];
        }
        ?>
        <div class="mt-2 mb-3">
            <a href="?page=alertcenter&limit=<?php echo $limit + 10; ?>&type=<?php echo $type ?>" class="btn btn-primary"><i class="fa fa-plus-circle" aria-hidden="true"></i> แสดงเพิ่มอีก 10</a>
            <!-- Dropdown filter alert_type -->
            <div class="dropdown d-inline ms-2">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    ประเภทการแจ้งเตือน
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <li><a class="dropdown-item" href="?page=alertcenter&limit=<?php echo $limit; ?>&type=all">ทั้งหมด</a></li>
                    <li><a class="dropdown-item" href="?page=alertcenter&limit=<?php echo $limit; ?>&type=account">บัญชีผู้ใช้</a></li>
                    <li><a class="dropdown-item" href="?page=alertcenter&limit=<?php echo $limit; ?>&type=system">ระบบ</a></li>
                    <li><a class="dropdown-item" href="?page=alertcenter&limit=<?php echo $limit; ?>&type=export">Export ข้อมูล</a></li>
                </ul>
            </div>
        </div>
        <div class="table-responsive" style="overflow-x: auto;">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th style="white-space: nowrap;"><i>#</i></th>
                        <th style="white-space: nowrap;">ประเภท</th>
                        <th style="white-space: nowrap;">เนื้อหาการแจ้งเตือน</th>
                        <th style="white-space: nowrap;">วันที่แจ้งเตือน</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($_GET['type'])) {
                        $type = $_GET['type'];
                        if ($type == "all") {
                            $i = query("SELECT * FROM `alert-center` ORDER BY `alert_date` DESC LIMIT $limit");
                        } else {
                            $i = query("SELECT * FROM `alert-center` WHERE `alert_type` = '$type' ORDER BY `alert_date` DESC LIMIT $limit");
                        }
                    } else {
                        $i = query("SELECT * FROM `alert-center` ORDER BY `alert_date` DESC LIMIT $limit");
                    }

                    while ($row = $i->fetch(PDO::FETCH_ASSOC)) {
                        // map type and color
                        switch ($row['alert_type']) {
                            case "account":
                                $icon = "fa-user";
                                $bg = "bg-primary";
                                break;
                            case "system":
                                $icon = "fa-cogs";
                                $bg = "bg-secondary";
                                break;
                            case "export":
                                $icon = "fa-file-export";
                                $bg = "bg-warning";
                                break;
                            default:
                                $icon = "fa-exclamation-triangle";
                                $bg = "bg-warning";
                                break;
                        }
                        echo '<tr>
                <td style="white-space: nowrap;"><i>' . $row['id'] . '</i></td>
                <td style="white-space: nowrap;"><span class="badge text-' . $bg . '"><i class="fa ' . $icon . '"></i> ' . $row['alert_type'] . '</span></td>
                <td style="white-space: nowrap;">' . $row['alert_text'] . '</td>
                <td style="white-space: nowrap;">' . $row['alert_date'] . '</td>
            </tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>

    </div>
</div>