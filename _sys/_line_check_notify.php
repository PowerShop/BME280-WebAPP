<?php
require dirname(__FILE__) . '/_api.php';
$data = query("SELECT * FROM `settings` WHERE `id` = 1")->fetch(PDO::FETCH_ASSOC);
$sensor = query("SELECT * FROM `sensor-data` ORDER BY `id` DESC LIMIT 1")->fetch(PDO::FETCH_ASSOC);
// always run this code in server side
// Check Condition Notify
if ($data['condition_notify'] == 1) {
    // Replace condition
    $condition = $data['modify_notify'];
    $condition = str_replace("if", "", $condition);
    $condition = str_replace("then notify", "", $condition);
    $condition = str_replace("and", "&&", $condition);
    $condition = str_replace("or", "||", $condition);
    $condition = str_replace("{temp}", $sensor['temp'], $condition);
    $condition = str_replace("{humidity}", $sensor['humidity'], $condition);
    $condition = str_replace("{pressure}", $sensor['pressure'], $condition);
    $condition = str_replace("{altitude}", $sensor['altitude'], $condition);
    $condition = str_replace("!=", "!==", $condition);
    $condition = str_replace("=", "==", $condition);
    $condition = str_replace(">", ">", $condition);
    $condition = str_replace("<", "<", $condition);
    $condition = str_replace(">=", ">=", $condition);
    $condition = str_replace("<=", "<=", $condition);



    // Replace line_notify_message
    $unex_text = $data['line_notify_message'];
    $unex_text = str_replace("{temp}", $sensor['temp'], $unex_text);
    $unex_text = str_replace("{humidity}", $sensor['humidity'], $unex_text);
    $unex_text = str_replace("{pressure}", $sensor['pressure'], $unex_text);
    $unex_text = str_replace("{altitude}", $sensor['altitude'], $unex_text);

    // {time} and {date} replace (thai date)
    // {time} format: 24 hour e.g. 5:59:00
    date_default_timezone_set('Asia/Bangkok');
    $unex_text = str_replace("{time}", date("H:i:s"), $unex_text);
    $unex_text = str_replace("{date}", date("d/m/Y"), $unex_text);


    // Check condition and notify with LINE Notify
    (eval("return $condition;")) ? $api->line->Notify($unex_text) : '';
}
