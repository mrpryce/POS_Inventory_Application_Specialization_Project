<?php

try {
    $pdo = new PDO('mysql:host=localhost;dbname=snowlink_blos_pos', 'root', 'root@123...');
    //echo 'connection successfull';

} catch (PDOException $v) {
    echo $v->getmessage();
}
