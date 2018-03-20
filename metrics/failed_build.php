<?
/*
$_POST = {
  stage_name,
  commit_message
}
*/
require_once("../connection.php");
DB::insert('failed_builds', $_POST);
echo "200 OK";
