<?
require_once("../connection.php");
$data = $_GET;

$data["at"] = date('Y-m-d H:i:s');
preg_match_all('/\[[a-z\-0-9]+\]/i', $data['description'], $matches);
$found = $matches[0];
if(sizeof($found) > 0){
  $data["role"] = str_replace('[', '', $found[0]);
  $data["role"] = str_replace(']', '', $data['role']);
}
if(sizeof($found) > 1){
  $data["detail"] = str_replace('[', '', $found[1]);
  $data["detail"] = str_replace(']', '', $data['detail']);
}


var_dump($data);
DB::insert('toggl', $data);
echo "200 OK";
