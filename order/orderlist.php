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

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      OrdertList
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
        <h3 class="box-title"><a href="order.php" class="btn btn-primary" role="button">Back to Create Order</a></h3>
      </div>
      <!-- /.box-header -->
      <!-- form start -->
      <div class="box-body">
        <div style="overflow-x:auto">
          <table id="tableorderList" class="table table-striped">
            <thead>
              <tr>
                <th>Invoice ID</th>
                <th>CustomerName</th>
                <th>OrderDate</th>
                <th>Total</th>
                <th>Paid</th>
                <th>Due</th>
                <th>Payment Type</th>
                <th>Print</th>
                <th>Edit</th>
                <th>Delete</th>
              </tr>
            </thead>
            <tbody>

              <?php
              $select = $pdo->prepare("SELECT * FROM blos_order ORDER by invoice_id desc ");
              $select->execute();
              while ($row = $select->fetch(PDO::FETCH_OBJ)) {


                echo '<tr>
<td>' . $row->invoice_id . '</td>
<td>' . $row->customer_name . '</td>
<td>' . $row->order_date . '</td>
<td>' . $row->total . '</td>
<td>' . $row->paid . '</td>
<td>' . $row->balance . '</td>
<td>' . $row->payment_method . '</td>
<td>
<a href="viewproduct.php?id=' . $row->invoice_id . '" class="btn btn-success" role="button">
<span class="glyphicon glyphicon-print"  style="color:#ffffff" data-toggle="tooltip" title="Print"></span></a>
</td>

<td>
<a href="editorder.php?id=' . $row->invoice_id . '" class="btn btn-primary" role="button">
<span class="glyphicon glyphicon-edit" style="color:#ffffff" data-toggle="tooltip" title="edit Order"></span></a>
</td>

<td>
<button id=' . $row->invoice_id . ' class="btn btn-danger btn_delete" type="disable">
<span class="glyphicon glyphicon-trash" style="color:#ffffff" data-toggle="tooltip" title="delete Order"></span></button>
</td>

</tr>';
              }

              ?>

            </tbody>
          </table>

        </div>
      </div>
    </div>
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script>
  $(document).ready(function() {
    $('#tableorderList').DataTable({
      "order": [
        [0, "desc"]
      ]
    });
  });
</script>

<script>
  $(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();

  });
</script>

<script>
  $(document).ready(function() {

    $('.btn_delete').click(function() {

      var del = $(this);

      var id = $(this).attr("id");
      // alert(id);
      swal({
          title: "Do you want to delete this Order ?",
          text: "Once Order is deleted, you will not be able to recover this Order!",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {

            $.ajax({

              url: 'orderdelete.php',
              type: 'post',
              data: {
                pids: id
              },
              success: function(data) {
                del.parents('tr').hide();
              }



            });

            swal("Your Order has been deleted!", {
              icon: "success",
            });
          } else {
            swal("Your Order is safe!");
          }
        });

    });

  });
</script>


<!-- Main Footer -->
<?php include_once('../include/footer.php'); ?>