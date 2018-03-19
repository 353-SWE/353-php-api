<?php
/**
 * Created by PhpStorm.
 * User: giora
 * Date: 16/02/18
 * Time: 11:26
 */

require_once("../connection.php");

$url ="https://swe353.statusticker.com/services";
//$url = "http://127.0.0.1/edsa-github/353-php-api/metrics/status.json"; just for testing

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => $url,
    CURLOPT_USERAGENT => 'Codular Sample cURL Request'
));

$resp = curl_exec($curl);

curl_close($curl);


$data = json_decode($resp, true)["data"];

foreach ($data as $service){

    $status ["ID"] = $service["id"];
    $status ["name"] = $service["name"];
    $status ["status"] = ($service["latest_event"]["status"] === "clear");
    $status ["at"] = date('Y-m-d H:i:s');

    DB::insert('statusticker',$status);
}
