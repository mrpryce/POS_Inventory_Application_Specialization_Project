<?php 
include_once('../db/connect_db.php');

session_start();

if($_SESSION['useremail']=="" OR $_SESSION['role']=="User"){
    
    header('location: ../index.php');
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


include_once('../include/header.php');

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
<h1>
ProductList
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
    <h3 class="box-title"><a href="product.php" class="btn btn-primary" role="button">Add Product
        </a></h3></div>
<!-- /.box-header -->
<!-- form start -->
<div class="box-body">
    <div style="overflow-x:auto">
<table id="tableProductList" class="table table-striped">
<thead>
<tr>
<th>#</th>
<th>Product Name</th>
<th>Category</th>
<th>Purchase Price</th>
<th>Sale Price</th>
<th>Stock</th>
<th>Description</th>
<th>Image</th>
<th>View</th>
<th>Edit</th>
<th>Delete</th>
</tr>
</thead>
<tbody>

<?php 
$select=$pdo->prepare("SELECT * FROM blos_product ORDER by pid desc ");
$select->execute();
while($row=$select->fetch(PDO::FETCH_OBJ)){


echo'<tr>
<td>'.$row->pid.'</td>
<td>'.$row->pname.'</td>
<td>'.$row->pcategory.'</td>
<td>'.$row->purchaseprice.'</td>
<td>'.$row->saleprice.'</td>
<td>'.$row->pstock.'</td>
<td>'.$row->pdescription.'</td>
<td><img src="../content/product_images/'.$row->pimage.'" class="img-rounded"    width="40px" height="40px"/></td>
<td>
<a href="viewproduct.php?id='.$row->pid.'" class="btn btn-success" role="button">
<span class="glyphicon glyphicon-eye-open"  style="color:#ffffff" data-toggle="tooltip" title="view product"></span></a>
</td>

<td>
<a href="editproduct.php?id='.$row->pid.'" class="btn btn-warning" role="button">
<span class="glyphicon glyphicon-edit" style="color:#ffffff" data-toggle="tooltip" title="edit product"></span></a>
</td>

<td>
<button id='.$row->pid.' class="btn btn-danger btn_delete">
<span class="glyphicon glyphicon-trash" style="color:#ffffff" data-toggle="tooltip" title="delete product"></span></button>
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
$(document).ready( function () {
$('#tableProductList').DataTable({
"order":[[0,"desc"]]
});
} );
</script>

<script>
$(document).ready( function () {
$('[data-toggle="tooltip"]').tooltip();

});
</script>

<script>

$(document).ready(function(){

$('.btn_delete').click(function(){
    
    var del = $(this);
    
    var id = $(this).attr("id");
    // alert(id);
     swal({
  title: "Do you want to delete this product ?",
  text: "Once Product is deleted, you will not be able to recover this Product!",
  icon: "warning",
  buttons: true,
  dangerMode: true,
})
.then((willDelete) => {
  if (willDelete) {
      
        $.ajax({
        
      url:'productdelete.php',
      type:'post',
      data:{
        pids:id
      },
        success:function(data){
          del.parents('tr').hide();
      }
        
        
        
    });
      
    swal("Your Product has been deleted!", {
      icon: "success",
    });
  } else {
    swal("Your Product is safe!");
  }
});
         
});
                                   
});

</script>


<!-- Main Footer -->
<?php include_once('../include/footer.php');?>

