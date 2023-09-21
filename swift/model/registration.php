<?php

include_once('../db/connect_db.php');

session_start();

if ($_SESSION['useremail'] == "" or $_SESSION['role'] == "User" or $_SESSION['role'] == "Sale") {

  header('location: ../index.php');
}


if ($_SESSION['role'] == "Admin" or $_SESSION['role'] == "User" or $_SESSION['role'] == "Sale") {

  //Expire the session if user is inactive for 30
  //minutes or more.
  $expireAfter = 60;

  //Check to see if our "last action" session
  //variable has been set.
  if (isset($_SESSION['last_action'])) {

    //Figure out how many seconds have passed
    //since the user was last active.
    $secondsInactive = time() - $_SESSION['last_action'];

    //Convert our minutes into seconds.
    $expireAfterSeconds = $expireAfter * 60;

    //Check to see if they have been inactive for too long.
    if ($secondsInactive >= $expireAfterSeconds) {
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



include_once('../include/header.php');


error_reporting(0);

$id = $_GET['id'];

$delete = $pdo->prepare("delete from blos_user where userid=" . $id);

if ($delete->execute()) {

  echo '<script>
         jQuery(function validation(){
         
          swal({
                 title: "Delected",
                icon: "success",
              button: "ok",
              });
         
         });
             
        </script>';
}

if (isset($_POST['reg_submit'])) {
  $username = $_POST['reg_name'];
  $useremail = $_POST['reg_email'];
  $password = $_POST['reg_pass'];
  $role = $_POST['sel_role'];

  //$username ." - ".$useremail ." - ".$password." - ".$role;

  ////////////Adding Images in Registration Form/////////////////////////////////

  $f_name = $_FILES['s_img']['name'];
  $f_tmp = $_FILES['s_img']['tmp_name'];


  $f_size = $_FILES['s_img']['size'];

  $f_extension = explode('.', $f_name);
  $f_extension = strtolower(end($f_extension));

  $_newfile = uniqid() . '.' . $f_extension;

  $store = "../content/product_images/" . $_newfile;

  if ($f_extension == 'jpg' || $f_extension == 'png' || $f_extension == 'gif' || $f_extension == 'jpeg') {

    if ($f_size > 1000000) {
      $error = '<script>
                   jQuery(function validation(){
                   swal({
                 title: "Error",
                 text:  "File Size must 100kb and above",
                icon: "Warning",
              button: "ok",
              });
         
         });
             </script>';

      echo $error;
    } else {


      if (move_uploaded_file($f_tmp, $store)) {

        $product_images = $_newfile;


        if (isset($_POST['reg_email'])) {

          $select = $pdo->prepare("select useremail from blos_user where useremail='$useremail'");

          $select->execute();

          if ($select->rowCount() > 0) {

            echo '<script>
         jQuery(function validation(){
         
          swal({
                 title: "Email Already Exist",
                icon: "warning",
              button: "ok",
              });
         
         });
             
        </script>';
          } else {

            $insert = $pdo->prepare("insert into blos_user(username,useremail,password,role)values(:name,:email,:pass,:role)");

            $insert->bindParam(':name', $username);
            $insert->bindParam(':email', $useremail);
            $insert->bindParam(':pass', $password);
            $insert->bindParam(':role', $role);


            if ($insert->execute()) {

              echo '<script>
         jQuery(function validation(){
         
          swal({
                 title: "Account Created",
                icon: "success",
              button: "ok",
              });
         
         });
             
        </script>';
            } else {
              echo '<script>
         jQuery(function validation(){
         
          swal({
                 title: "Creation Failed",
                icon: "error",
              button: "ok",
              });
         
         });
             
        </script>';
            }
          }
        }
      }
    }
  }
}



?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Admin Dashboard
      <small></small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
      <li class="active">Here</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content container-fluid">

    <!--Form Creation-->

    <div class="box box-info">
      <div class="box-header with-border">
        <h3 class="box-title">Registration Form</h3>
      </div>
      <!-- /.box-header -->
      <!-- form start -->
      <form role="form" action="" method="post">
        <div class="box-body">
          <div class="col-md-4">
            <div class="form-group">
              <label for="exampleInputEmail1">Name</label>
              <input type="text" class="form-control" name="reg_name" placeholder="Enter your Name" required>
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Email address</label>
              <input type="email" class="form-control" name="reg_email" placeholder="Enter email" required>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Password</label>
              <input type="password" class="form-control" name="reg_pass" placeholder="Password" required>
            </div>
            <div class="form-group">
              <label>Role</label>
              <select class="form-control" name="sel_role" required>
                <option value="" disabled selected>Select role</option>
                <option>Admin</option>
                <option>User</option>
                <option>Sale</option>
              </select>
            </div>
            <div class="form-group">
              <label>User Image</label>
              <input type="file" class="input-group" name="s_img">
              <p>upload image</p>
            </div>
            <button type="submit" class="btn btn-info" name="reg_submit">Submit</button>
          </div>

          <div class="col-md-8">

            <table class="table table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>NAME</th>
                  <th>EMAIL</th>
                  <th>PASSWORD</th>
                  <th>ROLE</th>
                  <th>DELETE</th>
                </tr>
              </thead>
              <tbody>

                <?php
                $select = $pdo->prepare("SELECT * FROM blos_user ORDER by userid desc ");
                $select->execute();
                while ($row = $select->fetch(PDO::FETCH_OBJ)) {


                  echo '<tr>
                                       <td>' . $row->userid . '</td>
                                       <td>' . $row->username . '</td>
                                       <td>' . $row->useremail . '</td>
                                       <td>' . $row->password . '</td>
                                       <td>' . $row->role . '</td>
                                       <td>
                                       <a href="registration.php?id=' . $row->userid . '" class="btn btn-danger" role="button">
                                       <span class="glyphicon glyphicon-trash" title="delete"></span></a>
                                       </td>
                                       </tr>';
                }

                ?>




              </tbody>
            </table>
          </div>

        </div>
        <!-- /.box-body -->

        <div class="box-footer">

        </div>
      </form>
    </div>

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Main Footer -->
<?php include_once('../include/footer.php'); ?>