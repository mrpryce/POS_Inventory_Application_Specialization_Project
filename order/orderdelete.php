<?php
include_once('../db/connect_db.php');



$id = $_POST['pids'];

//$sql = "delete from blos_product where pid=$id";

$sql = "delete blos_order , blos_invoice_details FROM blos_order INNER JOIN blos_invoice_details ON blos_order.invoice_id = blos_invoice_details.invoice_id where blos_order.invoice_id=$id";

$delete = $pdo->prepare($sql);

if ($delete->execute()) {
} else {
    echo 'Error while Deleting';
}
