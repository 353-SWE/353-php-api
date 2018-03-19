<?
require_once("../connection.php");
$data = $_GET;

$data["at"] = date('Y-m-d H:i:s');

var_dump($data);
DB::insert('toggl', $data);
echo "200 OK";
