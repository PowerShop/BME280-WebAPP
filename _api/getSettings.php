<?php
require("../_sys/_api.php");
$settings = query("SELECT * FROM `settings` WHERE `id` = 1")->fetch();

$data = array(
    "data_rate" => $settings['data_rate']
);

// Send data as json format
echo json_encode($data);
?>