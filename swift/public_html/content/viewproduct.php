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
        View Product
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
              <h3 class="box-title"><a href="productlist.php" class="btn btn-primary" role="button">Back to Product List</a></h3>
            </div>
             <div class="box-body">
                 <?php
                 
                 $id=$_GET['id'];
                 
                 $select=$pdo->prepare("select * from blos_product where pid=$id");
                 
                 $select->execute();
                 
                 while($row=$select->fetch(PDO::FETCH_OBJ)){
                     
echo'<div class="col-md-6">
<ul class="list-group">
<center><p class="list-group-item list-group-item-success"><b>Product Detail</b></p></center>
<li class="list-group-item d-flex justify-content-between align-items-center"><b>ID
</b><span class="badge badge-primary badge-pill">'.$row->pid.'</span>
</li>
<li class="list-group-item d-flex justify-content-between align-items-center"><b>Product Name
</b><span class="label label-info pull-right">'.$row->pname.'</span>
</li>
<li class="list-group-item d-flex justify-content-between align-items-center"><b>Category
</b><span class="label label-info pull-right">'.$row->pcategory.'</span>
</li>
<li class="list-group-item d-flex justify-content-between align-items-center"><b>Purchase Price
</b><span class="label label-info pull-right">'.$row->purchaseprice.'</span></li>

<li class="list-group-item d-flex justify-content-between align-items-center"><b>Sale Price
</b><span class="label label-info pull-right">'.$row->saleprice.'</span></li>

<li class="list-group-item d-flex justify-content-between align-items-center"><b>Product Profit
</b><span class="label label-success pull-right">'.($row->saleprice-$row->purchaseprice).'</span></li>

<li class="list-group-item d-flex justify-content-between align-items-center"><b>Product Loss
</b><span class="label label-danger pull-right">'.($row->purchaseprice-$row->saleprice).'</span></li>
<li class="list-group-item d-flex justify-content-between align-items-center"><b>Stock
</b><span class="label label-info pull-right">'.$row->pstock.'</span>
</li>
<li class="list-group-item d-flex justify-content-between align-items-center"><b>Product Description:-
</b><span class="">'.$row->pdescription.'</span>
</li>
</ul>
</div>

<div class="col-md-6">
<ul class="list-group">
<center><p class="list-group-item list-group-item-success"><b>Product Image</b></p></center>
<img src = "../content/product_images/'.$row->pimage.'" class="img-responsive"/>
</ul>
</div>'; 
                     
                     
                     
                     
                     
                 }
                 
                 
                 
                 
                 
                 
                 
                 
                 ?>
                
                
                
                
                
         </div>
        </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
<?php include_once('../include/footer.php');?>
