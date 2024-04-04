
<body class="bg-gradient-primary">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9 col-lg-12 col-xl-10">
                <div class="card shadow-lg o-hidden border-0 my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-flex">
                                <?php
                                // Random avatar
                                // Get count avatar start with number.png 
                                $dir = "assets/img/avatars/";
                                $filecount = 0;
                                $files = glob($dir . "*");
                                if ($files) {
                                    $filecount = count($files) - 1;
                                }

                                $randomNumber = rand(1, $filecount); // replace n with the maximum number of images you have
                                $imagePath = "assets/img/avatars/" . $randomNumber . ".png";
                                echo '<div class="flex-grow-1 bg-login-image" style="background-image: url(' . $imagePath . ');"></div>';
                            ?>
                                </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h4 class="text-dark mb-4">ยินดีต้อนรับ</h4>
                                    </div>
                                    <form class="user" action="" method="post">
                                        <div class="mb-3"><input class="form-control form-control-user" type="text" id="username" aria-describedby="emailHelp" placeholder="ชื่อผู้ใช้ของคุณ" name="username" required></div>
                                        <div class="mb-3"><input class="form-control form-control-user" type="password" id="password" placeholder="รหัสผ่าน" name="password" required></div>
                                        <div class="mb-3">
                                            <div class="custom-control custom-checkbox small">
                                                <div class="form-check"><input class="form-check-input custom-control-input" type="checkbox" id="remember_me" name="remember_me"><label class="form-check-label custom-control-label" for="formCheck-1">จำการเข้าสู่ระบบ</label></div>
                                            </div>
                                        </div><button class="btn btn-primary d-block btn-user w-100" type="submit" name="login"><i class="fa fa-sign-in" aria-hidden="true"></i> เข้าสู่ระบบ</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php 
    if (isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Remember me
        $remember_me = $_POST['remember_me'] ? true : false;

        $api->user->Login($username, $password, $remember_me);
    }
?>