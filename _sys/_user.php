<?php
class User
{
    public function Login($username, $password, $remember_me)
    {
        global $api;
        $Enpassword = encode($password);
        $i = query("SELECT * FROM `users` WHERE `username` = ? AND `password` = ?", array($username, $Enpassword));
        if ($i->rowCount() == 1) {
            // alert("เข้าสู่ระบบสำเร็จ");
            // insert data to alert-center
            // get ip address user
            $ip = getenv("REMOTE_ADDR");
            
            
            query("INSERT INTO `alert-center` (`alert_type`, `alert_text`, `alert_date`) VALUES (?, ?, ?)", array("account", "มีการเข้าสู่ระบบจากไอพีแอดเดรส $ip", date("Y-m-d H:i:s")));

            swal("เข้าสู่ระบบสำเร็จ", "ยินดีต้อนรับคุณ $username", "success", "ตกลง", 100, "?page=dashboard");
            $i = $i->fetch();
            $_SESSION['admin'] = $i['username'];
            if ($remember_me == 1) {
                setcookie("remember", $username, time() + (86400 * 30), "/");
            }
            // rdr("?page=dashboard", 0);
        } else {
            // alert("ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง");
            swal("เข้าสู่ระบบไม่สำเร็จ", "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง", "error", "ตกลง", 100, "?page=login");
            // rdr("?page=login", 0);
        }
    }

    public function Logout()
    {
        session_destroy();
        swal("ออกจากระบบสำเร็จ", "คุณได้ออกจากระบบแล้ว", "success", "ตกลง", 100, "?page=login");
        return true;
    }
}
