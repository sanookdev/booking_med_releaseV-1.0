<?
require_once "userpassDb.php";

$conn = new mysqli($hostDb,$userDb,$passDb,$nameDb);
$conn->set_charset("utf8");
if($conn->connect_error) { alert("can't connect db"); }
?>