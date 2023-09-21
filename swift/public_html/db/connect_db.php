
<?php

try {
    $pdo = new PDO('mysql:host=localhost;dbname=blos_pos', 'blos', 'None$upp0rt@123.');
    //echo 'connection successfull';

} catch (PDOException $v) {
    echo $v->getmessage();
}
