<?php
require("../_sys/_api.php");

// Set api key to match the key in the ESP8266 code
$api_key_value = "644245001";

$api_key = $data_rate = "";

// Request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $api_key = $_POST["api_key"];
    // Check if the api key is correct
    if ($api_key == $api_key_value) {
        $data_rate = $_POST["dataRate"];
        query("UPDATE `settings` SET `data_rate` = '" . $data_rate . "' WHERE `settings`.`id` = 1");
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
