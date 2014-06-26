<?php
//database config
define('HOST', 'localhost');
define('DBNAME', 'testsql');
define('DBUSER', 'root');
define('DBPASS', '');
try{
	$db=new PDO('mysql:host='.HOST.';dbname='.DBNAME.';charset=utf8',DBUSER,DBPASS);
}
catch (Exception $e)
{
 	throw new Exception( 'Something wrong', 0, $e);
}


// example part
require_once 'dt.class.php';
use saiful\datatable;
$order = $_REQUEST['order'];
$test = new datatable\DThelper();
$test -> db = $db; // must for databse connection
$test -> table = 'test';
$test -> limit = [(int) $_REQUEST['start'], (int)$_REQUEST['length']]; //Must for pagination
$test -> order = [$order[0]['column'],$order[0]['dir']]; //Must for sorting
$test -> search = $_REQUEST['search']['value']; // must for searching 
$test -> sql = "SELECT * FROM test" ; // must, you need to write any valid query here
//$test -> where = ["type='1000'"]; // if needed
$test -> columns = array('id','data1','data2','data3'); // must for columns to display
echo json_encode($test->show()); // must for getting data

?>