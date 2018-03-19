<?
require_once("../connection.php");
$data = $_POST;
$indexes = json_decode($data['indexes'], true);
var_dump($indexes);
DB::insert('gulpease', $indexes);
echo "200 OK";
