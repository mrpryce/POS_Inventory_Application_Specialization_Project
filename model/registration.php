<?php 
include_once('../db/connect_db.php');

session_start();

include_once('../include/session.php');
include_once('../include/header.php');
include_once('../include/reg_connect.php');
include_once('../include/csrf_token.php');
include_once('../include/delete.php');

?>
  <div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Registration Dashboard
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
      <form action="" method="post" name="form_reg" enctype="multipart/form-data">
        <div class="box-body">
          <div class="col-md-4">
            <div class="form-group">
              <label for="exampleInputName">Name</label>
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
          </form>
       

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
                  $stmt = $pdo->query("SELECT * FROM blos_user ORDER by userid desc ");
                  while ($row = $stmt->fetch()) {
                    $shortenedPassword = substr($row['password'], 0, 6) . '...' . substr($row['password'], -6);
                      ?>
                    <tr>
                <td><?= $row['userid'] ?></td>
                <td><?= $row['username'] ?></td>
                <td><?= $row['useremail'] ?></td>
                <td><?= $shortenedPassword ?></td>
                <td><?= $row['role'] ?></td>
                <td>

                    <form method="post" action="">
                        <input type="hidden" name="id" value="<?= $row['userid'] ?>">
                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                        <button class="btn btn-danger" type="submit" value="Delete" onclick="return confirm('Are you sure you want to delete this user?');"> <span class="glyphicon glyphicon-trash" title="delete"></span></button>
                    </form>
                </td>
                </tr>
                <?php
                  }
                  ?>
                </tbody>
                </table>

                </div>

</div>
<!-- /.box-body -->

<div class="box-footer">

</div>
</div>

</section>
<!-- /.content -->
</div>
<?php include_once('../include/footer.php');?>