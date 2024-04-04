<?php
    require("../_sys/_api.php");

    $data = query("SELECT * FROM `sensor-data` ORDER BY `id` DESC LIMIT 1")->fetch();
    $old_data = query("SELECT * FROM `sensor-data` ORDER BY `id` DESC LIMIT 1,1")->fetch();
    $settings = query("SELECT * FROM `settings`")->fetch();

    // Temperature
    $temperature = $data["temp"];

    // Humidity
    $humidity = $data["humidity"];

    // Pressure
    $pressure = $data["pressure"];

    // Altitude
    $altitude = $data["altitude"];

    // 
    $old_temperature = $old_data["temp"];
    $old_humidity = $old_data["humidity"];
    $old_pressure = $old_data["pressure"];
    $old_altitude = $old_data["altitude"];

    // Lastest data
    $time = $data["time"];

    // Convert time to local thai
    $time = date("d/m/Y H:i:s", strtotime($time));

    // Return json
    echo json_encode(array(
        "temperature" => $temperature,
        "humidity" => $humidity,
        "pressure" => $pressure,
        "altitude" => $altitude,
        "old_temperature" => $old_temperature,
        "old_humidity" => $old_humidity,
        "old_pressure" => $old_pressure,
        "old_altitude" => $old_altitude,
        "time" => $time,
        "data_rate" => $settings["data_rate"],
    ));

?>