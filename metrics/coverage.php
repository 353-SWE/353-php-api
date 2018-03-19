<?
require_once("../connection.php");
$data = $_POST;
$indexes = json_decode($data['coverage'], true);
var_dump($indexes);
DB::insert('coverage', $indexes);
echo "200 OK";
