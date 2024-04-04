<?php
require("../_sys/_api.php");

// Set api key to match the key in the ESP8266 code
$api_key_value = "644245001";

// Clear variables first before using them
$api_key = $sensor = $location = $temp = $humidity = $pressure = $altitude = "";

// Check if the request method is POST and if the api key is correct so that the data can be saved to the database
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $api_key = $_POST["api_key"];
    if ($api_key == $api_key_value) {
        $sensor = $_POST["sensor"];
        $location = $_POST["location"];
        $temp = $_POST["temp"];
        $humidity = $_POST["humidity"];
        $pressure = $_POST["pressure"];
        $altitude = $_POST["altitude"];

        // Get time when the data was sent
        // Set timezone to Bankok
        date_default_timezone_set("Asia/Bangkok");
        $time = date("Y-m-d H:i:s");

        query("INSERT INTO `sensor-data` (`sensor`, `location`, `temp`, `humidity`, `pressure`, `altitude`, `time`) VALUES ('" . $sensor . "', '" . $location . "', '" . $temp . "', '" . $humidity . "', '" . $pressure . "','" . $altitude . "' ,'" . $time . "')");

        // Free up memory with PDO
        $api->sql->closeCursor();

        // return 200 - OK
        http_response_code(200);

    } else {
        echo "Wrong API Key provided.";
        http_response_code(403);
    }
    
} else {
    echo "No data posted with HTTP POST.";
}
