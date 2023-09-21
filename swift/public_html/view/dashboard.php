<?php


include_once('../db/connect_db.php');
session_start();

if($_SESSION['useremail']=="" OR $_SESSION['role']=="User"){
    
    header('location: ../index.php');
}


if($_SESSION['role']=="Admin" OR $_SESSION['role']=="User"){
    
    //Expire the session if user is inactive for 30
     //minutes or more.
    $expireAfter = 30;
 
//Check to see if our "last action" session
//variable has been set.
if(isset($_SESSION['last_action'])){
    
    //Figure out how many seconds have passed
    //since the user was last active.
    $secondsInactive = time() - $_SESSION['last_action'];
    
    //Convert our minutes into seconds.
    $expireAfterSeconds = $expireAfter * 60;
    
    //Check to see if they have been inactive for too long.
    if($secondsInactive >= $expireAfterSeconds){
        //User has been inactive for too long.
        //Kill their session.
        session_unset();
        session_destroy();
        header('location: ../index.php');
    }
    
}
 
//Assign the current timestamp as the user's
//latest activity
$_SESSION['last_action'] = time();
    
   
}

?>

<?php include_once('../include/header.php');?>
<?php include_once('../include/admin-content.php');?>

  

 


  <!-- /.content-wrapper -->

  <!-- Main Footer -->


<?php require_once('../include/footer.php');?>

