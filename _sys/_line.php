<?php
class Line
{
    public function Notify($text)
    {   
        global $api;
        $url        = 'https://notify-api.line.me/api/notify';
        $token = $api->sql->query("SELECT * FROM `settings` WHERE `id` = 1")->fetch()['line_token'];
        $headers    = [
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: Bearer ' . $token
        ];
        $fields     = 'message=' . urlencode($text);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);

        // var_dump($result);
        // $result = json_decode($result, TRUE);
    }
}
