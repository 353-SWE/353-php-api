<?php
require_once("meekrodb.php");
DB::$user = 'tullio';
DB::$password = 'testiamoquestoaws';
DB::$dbName = 'metabase';
DB::$host = 'swe353.ctpqhbfy0wwr.eu-west-1.rds.amazonaws.com'; //defaults to localhost if omitted
DB::$port = '3306'; // defaults to 3306 if omitted
DB::$encoding = 'utf8'; // defaults to latin1 if omitted

