<!-- Export Data as CSV -->
<div class="container-fluid">
    <h1 class="mt-4">Export Data</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="?page=dashboard">Dashboard</a></li>
        <li class="breadcrumb-item active">Export Data</li>

    </ol>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Export Data
        </div>
        <div class="card-body">
            <form action="" method="post">
                <!-- Export Type -->
                <div class="mb-3">
                    <select class="form-select" name="export-type" id="export-type">
                        <option value="csv">CSV</option>
                        <option value="json">JSON</option>
                        <option value="xml">XML</option>
                    </select>
                    <small id="helpId" class="form-text text-muted">เลือกประเภทของไฟล์ที่ต้องการ Export</small>
                </div>
                <!-- Date Range -->
                <div class="mb-3">
                    <input type="text" class="form-control" name="datetimes" id="datetimes" aria-describedby="helpId" placeholder="" onchange="debugTime()" required />
                    <small id="helpId" class="form-text text-muted">เลือกช่วงเวลาที่จะ Export ข้อมูล</small>
                </div>


                <script>
                    $(function() {
                        $('input[name="datetimes"]').daterangepicker({
                            timePicker: true,
                            startDate: moment().startOf('hour'),
                            endDate: moment().startOf('hour').add(32, 'hour'),
                            locale: {
                                format: 'M/DD/YYYY HH:mm' // Changed to 24-hour format
                            }
                        });
                    });

                    function debugTime() {
                        var time = $('input[name="datetimes"]').val();
                        console.log(time);
                    }

                    // reset date time picker when page load
                    window.onload = function() {
                        $('input[name="datetimes"]').val('');
                    }
                </script>

                <!-- Check box to open file in new tab or not -->
                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="open-new-tab" id="open-new-tab" checked>
                        <label class="form-check-label" for="open-new-tab">
                            เปิดไฟล์ในแท็บใหม่
                        </label>
                    </div>
                </div>


                <!-- Export Button -->
                <div class="row">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-table" aria-hidden="true"></i> Export Data</button>
                    </div>
                </div>
            </form>
            <br>
        </div>
    </div>
</div>
</div>
<!-- End of Export Data as CSV -->

<?php
if ($_POST) {
    // Timezone
    date_default_timezone_set("Asia/Bangkok");

    // User
    $user = $_SESSION['admin'];
    $export_type = $_POST['export-type'];
    $datetimes = $_POST['datetimes'];

    // convert date time
    // from 9/21/2023 12:00 AM - 10/19/2023 08:00 AM to 2023-09-21 00:00:00 - 2023-10-19 08:00:00
    $datetimes = explode(" - ", $datetimes);
    $start = date("Y-m-d H:i:s", strtotime($datetimes[0]));
    $end = date("Y-m-d H:i:s", strtotime($datetimes[1]));

    // echo $start . " - " . $end;

    $data = query("SELECT * FROM `sensor-data` WHERE `time` BETWEEN ? AND ?", array($start, $end));

    // check empty data
    if ($data->rowCount() == 0) {
        // echo "<script>alert('ไม่พบข้อมูลที่ต้องการ Export');</script>";
        swal("เกิดข้อผิดพลาด", "ไม่พบข้อมูลที่ต้องการ Export", "error", "ตกลง", 100, "?page=export");
        return;
    }

    $filename = "export-" . $user . "-" . date("Y-m-d-H-i-s") . "." . $export_type;
    $file = fopen("export/" . $filename, "w");
    if ($export_type == "csv") {
        fputcsv($file, array('Time', 'Temperature', 'Humidity', 'Pressure'));
        while ($row = $data->fetch()) {
            fputcsv($file, array($row['time'], $row['temp'], $row['humidity'], $row['pressure']));
        }
    } else if ($export_type == "json") {
        $json = array();
        while ($row = $data->fetch()) {
            $json[] = array('Time' => $row['time'], 'Temperature' => $row['temp'], 'Humidity' => $row['humidity'], 'Pressure' => $row['pressure']);
        }
        // fwrite($file, json_encode($json, JSON_PRETTY_PRINT));
        // save to export folder
        $file = fopen("export/" . $filename, "w");
        fwrite($file, json_encode($json, JSON_PRETTY_PRINT));

    } else if ($export_type == "xml") {
        $xml = new SimpleXMLElement('<root/>');
        while ($row = $data->fetch()) {
            $item = $xml->addChild('item');
            $item->addChild('Time', $row['time']);
            $item->addChild('Temperature', $row['temp']);
            $item->addChild('Humidity', $row['humidity']);
            $item->addChild('Pressure', $row['pressure']);
        }
        fwrite($file, $xml->asXML());
    }
    fclose($file);
    // echo "<script>window.location = '$filename';</script>";
    // open file in mew tab

    // ส่งข้อมูลไปที่ alert center
    query("INSERT INTO `alert-center` (`alert_type`, `alert_text`, `alert_date`) VALUES (?, ?, ?)", array("export", "มีการ Export ข้อมูลประเภท $export_type ชุดข้อมูลระหว่าง $start ถึง $end", date("Y-m-d H:i:s")));

    
    // check open new tab
    // wait 1 second before redirect
    sleep(1);
    if (isset($_POST['open-new-tab'])) {
        // echo "<script>window.open('export/$filename', '_blank');</script>"; 
        
        // for linux
        echo "<script>window.open('export/$filename', '_blank');</script>";
    } else {
        echo "<script>window.location = 'export/$filename';</script>";
    }
    swal("Export ข้อมูลสำเร็จ", "ไฟล์ข้อมูลที่ Export ได้สำเร็จ", "success", "ตกลง", 100, "");
}
?>