<?php
    // Return Status Server with HTTP CODE
    http_response_code(200);    
    echo json_encode(array("status" => "success", "message" => "Server is running"));
?>