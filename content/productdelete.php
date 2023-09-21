<?php 
include_once('../db/connect_db.php');



$id=$_POST['pids'];

$sql="delete from blos_product where pid=$id";

$delete=$pdo->prepare($sql);

if($delete->execute()){
    
}else{
    echo'Error while Deleting';
    
}


?>