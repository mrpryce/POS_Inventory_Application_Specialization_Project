<?php

include_once('../db/connect_db.php');

session_start();
if ($_SESSION['useremail'] == "" or $_SESSION['role'] == "User") {

  header('location: ../index.php');
}

if ($_SESSION['role'] == "Admin" or $_SESSION['role'] == "User") {

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



if (isset($_POST['cat_submit'])) {

  $category = $_POST['txt_cat'];

  //echo $category;


  $category = trim($_POST['txt_cat']);
  $category_pattern = "/^[a-zA-Z0-9]{3,15}$/"; // category should contain only letters and numbers, and length should be between 3 and 15 characters
  if (preg_match($category_pattern, $category)) {
  } else {

    $error = '<script>
        jQuery(function validation(){
         
          swal({
                 title: "ERROR",
                 text:  "category should contain only letters and numbers, and length should be between 3 and 15 characters",
                icon: "error",
              button: "ok",
              });
         
         });
             </script>';
    echo $error;
  }

  if (empty($category)) {

    $error = '<script>
        jQuery(function validation(){
         
          swal({
                 title: "Category Field is Empty",
                 text:  "Please fill category Field",
                icon: "error",
              button: "ok",
              });
         
         });
             </script>';

    echo $error;
  }

  if (!isset($error)) {

    $insert = $pdo->prepare("insert into blos_category(category) values(:category)");

    $insert->bindParam(':category', $category);

    if ($insert->execute()) {
      echo '<script>
        jQuery(function validation(){
         
          swal({
                 title: "Category Added",
                 text:  "Insert Successful",
                icon: "success",
              button: "ok",
              });
         
         });
             </script>';
    } else {

      echo '<script>
        jQuery(function validation(){
         
          swal({
                 title: "Insert Fail",
                 text:  "Category insert Unsuccessful",
                icon: "error",
              button: "ok",
              });
         
         });
             </script>';
    }
  }
} //add button


if (isset($_POST['btn_update'])) {

  $category = $_POST['txt_cat'];
  $id = $_POST['cat_id'];


  if (empty($category)) {

    $errorupdate = '<script type="text/javascript">
        jQuery(function validation(){
         
          swal({
                 title: "Error",
                 text:  "Field is Empty : Please enter category",
                icon: "error",
              button: "ok",
              });
         
         });
             </script>';

    echo $errorupdate;
  }


  if (!isset($errorupdate)) {

    $update = $pdo->prepare("update blos_category set category=:category where catid=" . $id);

    $update->bindParam(':category', $category);

    if ($update->execute()) {

      echo '<script>
        jQuery(function validation(){
         
          swal({
                 title: "Category Updated",
                 text:  "Update Successful",
                icon: "success",
              button: "ok",
              });
         
         });
             </script>';
    } else {

      echo '<script>
        jQuery(function validation(){
         
          swal({
                 title: "Category Failed",
                 text:  "Update Failed",
                icon: "success",
              button: "ok",
              });
         
         });
             </script>';
    }
  }
} //update button

if (isset($_POST['btn_del'])) {

  $delete = $pdo->prepare("delete from blos_category where catid=" . $_POST['btn_del']);

  $delete->execute();

  if ($delete->execute()) {

    echo '<script>
        jQuery(function validation(){
         
          swal({
                 title: "Category Delected",
                 text:  "Delected",
                icon: "success",
              button: "ok",
              });
         
         });
             </script>';
  } else {

    echo '<script>
        jQuery(function validation(){
         
          swal({
                 title: "Not Delected",
                 text:  "Not Delected",
                icon: "success",
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
      Category
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

    <div class="box box-danger">
      <div class="box-header with-border">
        <h3 class="box-title">Create Category</h3>
      </div>
      <!-- /.box-header -->
      <!-- form start -->
      <div class="box-body">
        <form role="form" action="" method="post">

          <?php
          if (isset($_POST['btnedit'])) {
            $select = $pdo->prepare("select * from blos_category where catid=" . $_POST['btnedit']);
            $select->execute();
            if ($select) {
              $row = $select->fetch(PDO::FETCH_OBJ);
              echo '<div class="col-md-4">
                
                <div class="form-group">
                  <label>Category</label>
                   <input type="hidden" class="form-control" name="cat_id" value="' . $row->catid . '" placeholder="Enter your Category">
             
                  <input type="text" class="form-control" name="txt_cat" value="' . $row->category . '" placeholder="Enter your Category">
                </div>
                <button type="submit" class="btn btn-info" name="btn_update">Update</button>
                    </div>';
            }
          } else {

            echo '<div class="col-md-4">
                <div class="form-group">
                  <label>Category Form</label>
                  <input type="text" class="form-control" name="txt_cat" placeholder="Enter your Category">
                </div>
                <button type="submit" class="btn btn-danger" name="cat_submit">Input</button>
                    </div>';
          }


          ?>

          <div class="col-md-8">
            <table id="tableCategory" class="table table-striped">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>CATEGORY</th>
                  <th>EDIT</th>
                  <th>DELETE</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $select = $pdo->prepare("select * from blos_category order by catid desc");

                $select->execute();

                while ($row = $select->fetch(PDO::FETCH_OBJ)) {
                  echo '<tr>
                                  <td>' . $row->catid . '</td>
                                   <td>' . $row->category . '</td>
                                    <td>
                                    <button type="submit" value="' . $row->catid . '" class="btn btn-success" name="btnedit">Edit</button>
                                    </td>
                                     <td>
                                     <button type="submit" value="' . $row->catid . '" class="btn btn-danger" name="btn_del">Delete</button>
                                    </td>     
                                   </tr>';
                }

                ?>
              </tbody>
            </table>
          </div>
        </form>

      </div>
      <!-- /.box-body -->

      <div class="box-footer">

      </div>

    </div>


  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<!-- Call this single function-->
<script>
  $(document).ready(function() {
    $('#tableCategory').DataTable();
  });
</script>


<!-- Main Footer -->
<?php include_once('../include/footer.php'); ?>