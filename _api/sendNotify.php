<?php
require("../_sys/_api.php");
// Send Notify to Line
// Request: POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get Data
    $data = $_POST['text'];
    // Check Data
    if (isset($data)) {
        // Send Notify
        $api->line->Notify($data);
        // Return Status Server with HTTP CODE
        http_response_code(200);
    } else {
        // Return Status Server with HTTP CODE
        http_response_code(400);
    }
} else {
    // Return Status Server with HTTP CODE
    http_response_code(405);
}
