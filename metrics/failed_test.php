<?
/*
$_POST = {
  test_type,
  at
}
*/
require_once("../connection.php");
DB::insert('failed_tests', $_POST);
echo "200 OK";
