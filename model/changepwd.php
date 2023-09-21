<script src="../bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="../plugins/iCheck/icheck.min.js"></script>
 <script src="../dist/js/sweetalert.js"></script>  
<?php 
include_once('../db/connect_db.php');
session_start();
if($_SESSION['useremail']=="" OR $_SESSION['role']==""){
    
    header('location: ../index.php');
}

if($_SESSION['role']=="Admin"){
    
include_once('../include/header.php');
    
}else{
   include_once('../include/headeruser.php');
}


if($_SESSION['role']=="Admin" OR $_SESSION['role']=="User"){
    
    //Expire the session if user is inactive for 30
     //minutes or more.
    $expireAfter = 60;
 
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




if(isset($_POST['btnupdate'])){
    
    $oldpwd =$_POST['oldpwd'];
     $newpwd =$_POST['newpwd'];
     $conpwd =$_POST['conpwd'];
    
    //echo $oldpwd. "-" .$newpwd. "-" .$conpwd;
    
     $email=$_SESSION['useremail'];
    
    $select=$pdo->prepare("SELECT * FROM blos_user WHERE useremail='$email'");
    
    $select->execute();
    $row=$select->fetch(PDO::FETCH_ASSOC);
    
  $usernmae = $row['useremail'];
  $password = $row['password'];
    
    if($oldpwd==$password AND $newpwd==$conpwd){
        
        $update=$pdo->prepare("UPDATE blos_user SET password=:pass WHERE useremail=:email");
        
        $update->bindParam(':pass', $conpwd);
        $update->bindParam(':email',$email);
        
        if($update->execute()){
            
            echo '<script>
         jQuery(function validation(){
         
          swal({
                 title: "Password Update",
                icon: "success",
              button: "ok",
              });
         
         });
             
        </script>';
    }else{
            echo '<script>
         jQuery(function validation(){
         
          swal({
                 title: "Password not Updated",
                icon: "error",
              button: "ok",
              });
         
         });
             
        </script>';
            
    }
        
    }else{
        
        echo '<script>
         jQuery(function validation(){
         
          swal({
                 title: "Password not Matched",
                icon: "warning",
              button: "ok",
              });
         
         });
             
        </script>';
          
         }
    
}


?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Change Password
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

      <!--------------------------
        | Your Page Content Here |
        -------------------------->
        
         <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Change Password</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="" method="post">
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputPassword1">Old Password</label>
                  <input type="text" class="form-control"  placeholder="Password" name="oldpwd" required>
                </div>
                  <div class="form-group">
                  <label for="exampleInputPassword1">New Password</label>
                  <input type="password" class="form-control" placeholder="Password"name="newpwd" required>
                </div>
                  <div class="form-group">
                  <label for="exampleInputPassword1">Confirm Password</label>
                  <input type="password" class="form-control" placeholder="Password" name="conpwd" required>
                </div>
                </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary" name="btnupdate">Update</button>
              </div>
            </form>
          </div>
     
    

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
<?php include_once('../include/footer.php');?>