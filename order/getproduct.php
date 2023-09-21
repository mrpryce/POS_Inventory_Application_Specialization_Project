<?php 
include_once('../db/connect_db.php');

$id = $_GET["id"];

$select = $pdo->prepare("select * from blos_product where pid = :ppid");
 $select->bindParam(':ppid',$id);
$select->execute();

$row=$select->fetch(PDO::FETCH_ASSOC);

$respone=$row;

header('Content-Type: application/json');

echo json_encode($respone);



?>