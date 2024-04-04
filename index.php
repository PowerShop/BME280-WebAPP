<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Ratchaburi Games 39</title>
    <link rel="icon" type="image/png" sizes="512x512" href="assets/img/dashboard.png">
    <link rel="icon" type="image/png" sizes="512x512" href="assets/img/dashboard.png" media="(prefers-color-scheme: dark)">
    <link rel="icon" type="image/png" sizes="512x512" href="assets/img/dashboard.png">
    <link rel="icon" type="image/png" sizes="512x512" href="assets/img/dashboard.png" media="(prefers-color-scheme: dark)">
    <link rel="icon" type="image/png" sizes="512x512" href="assets/img/dashboard.png">
    <link rel="icon" type="image/png" sizes="512x512" href="assets/img/dashboard.png">
    <link rel="icon" type="image/png" sizes="512x512" href="assets/img/dashboard.png">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/02e207a49a.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Sarabun:wght@200;300;400;600;700;800&display=swap');

        .font {
            font-family: 'Sarabun', sans-serif;
        }
    </style>
</head>

<body id="page-top" class="font">
    <div id="wrapper">
        <?php
        // Timezone
        date_default_timezone_set('Asia/Bangkok');

        // API
        require("_sys/_api.php");
        session_start();
        error_reporting(1);

        // Check login
        if (!isset($_SESSION['admin']) && $_GET['page'] !== 'login') {
            rdr("?page=login", 0);
        }

        // Remember me
        if (isset($_COOKIE['remember'])) {
            $username = $_COOKIE['remember'];
            $_SESSION['admin'] = $username;
            rdr("?page=dashboard", 0);
        }
        ?>

        <?php
        // Sidebar
        include("_pages/sidebar.php");
        ?>

        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">

                <?php
                // Navbar
                include("_pages/navbar.php");
                ?>

                <?php
                // Content
                if ($_GET) {
                } else {
                    rdr("?page=dashboard", 500);
                }

                if (isset($_GET['page'])) {
                    $page = '_pages/' . $_GET['page'] . '.php';
                    if (file_exists($page)) {
                        include $page;
                    } else {
                        swal("ไม่พบหน้านี้", "ไม่พบหน้าที่คุณต้องการ", "error", "ตกลง", 100, "?page=dashboard");
                        // rdr("?page=dashboard", 500);
                    }
                }
                ?>

                <?php
                // Footer
                include("_pages/footer.php");

                ?>
            </div>
            <!-- Go to top -->
            <a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
            <script>
                // call line_check_notify.php every user set
                setInterval(() => {
                    $.ajax({
                        url: '_sys/_line_check_notify.php',
                        type: 'GET',
                        success: function(response) {
                            console.log(response);
                        }
                    });
                }, <?php $data = query("SELECT * FROM `settings` WHERE `id` = 1")->fetch(PDO::FETCH_ASSOC);
                    echo $data['data_rate'] * 1000; ?>);
            </script>
        </div>

    </div>
    <!-- Script -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/theme.js"></script>
    
    <!-- date time picker for export data as excel -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>


</body>

</html>
<?php


?>