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
if(isset($_POST['btn_product'])){
    
    $productname = $_POST['p_name'];
    $selcategory = $_POST['sel_cat'];
    $purchaseprice = $_POST['p_price'];
    $saleprice = $_POST['s_price'];
    $stock = $_POST['s_stock'];
    $description = $_POST['s_description'];
    
    //echo $productname;//
     
   $f_name = $_FILES['s_img']['name'];
    $f_tmp = $_FILES['s_img']['tmp_name'];


    $f_size = $_FILES['s_img']['size'];

    $f_extension = explode('.', $f_name);
    $f_extension = strtolower(end($f_extension));

    $_newfile = uniqid() . '.' . $f_extension;

    $store = "../content/product_images/". $_newfile;

    if($f_extension == 'jpg' || $f_extension == 'png' || $f_extension == 'gif' || $f_extension == 'jpeg'){

        if ($f_size > 1000000) {
            $error= '<script>
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
            
        }else{


            if (move_uploaded_file($f_tmp, $store)) {

               $product_images=$_newfile;
                
                 
    if(!isset($errorr)){
    $insert=$pdo->prepare("insert into blos_product(pname,pcategory,purchaseprice,saleprice,pstock,pdescription,pimage) values(:pname,:pcategory,:purchaseprice,:saleprice,:pstock,:pdescription,:pimage)");
         
        $insert->bindParam(':pname',$productname);
        $insert->bindParam(':pcategory',$selcategory);
        $insert->bindParam(':purchaseprice',$purchaseprice);
        $insert->bindParam(':saleprice',$saleprice);
        $insert->bindParam(':pstock',$stock);
        $insert->bindParam(':pdescription',$description);
        $insert->bindParam(':pimage',$product_images);
        
        if($insert->execute()){
            echo '<script>
                   jQuery(function validation(){
                   swal({
                 title: "Successfully",
                 text:  "Product Added",
                icon: "success",
              button: "ok",
              });
         
         });
             </script>';
        }else{
            echo'<script>
                   jQuery(function validation(){
                   swal({
                 title: "Error",
                 text:  "Product Fail to Add",
                icon: "error",
              button: "ok",
              });
         
         });
             </script>';
        }
        
    }
            }
        }
    }else{

        $error='<script>
                   jQuery(function validation(){
                   swal({
                 title: "File Format is Different",
                 text:  "All file format must be jpg,png,gif,jpeg",
                icon: "error",
              button: "ok",
              });
         
         });
             </script>';
        echo $error;
    }

   

}

?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Product
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
         <div class="box box-info">
              <div class="box-header with-border">
                  <h3 class="box-title"><a href="productlist.php" class="btn btn-primary" role="button">Back to Product List</a></h3>
                  
        <form action="" method="post" name="form_product" enctype="multipart/form-data">
        <div class="box-body">
             <div class="col-md-6">
                 <div class="form-group">
                  <label>Product Name</label>
                  <input type="text" class="form-control" name="p_name" placeholder="Enter......" required>
                </div>
                
                
             <div class="form-group">
                  <label>Category</label>
                  <select class="form-control" name="sel_cat" required>
                 <option value="" disabled selected>Select Category</option>
                    <?php 
                      $select= $pdo->prepare("select * from blos_category order by catid desc");
                      $select->execute();
                       while($row=$select->fetch(PDO::FETCH_ASSOC)){
                          extract($row);
                      ?>
                       <option><?php echo $row['category'];?></option>
                      <?php
                      }
                      ?>
                  </select>
                </div>
                
                
                <div class="form-group">
                  <label>Purchase Price</label>
                  <input type="number" min="1" step="1" class="form-control" name="p_price" placeholder="Enter....." required>
                </div>
                
                
                 
                <div class="form-group">
                  <label>Sale Price</label>
                  <input  type="number" min="1" step="1" class="form-control" name="s_price" placeholder="Enter....." required>
                </div>
                
                
                </div>
            <div class="col-md-6">
                
                <div class="form-group">
                  <label>Stock</label>
                  <input type="number" min="1" step="1" class="form-control" name="s_stock" placeholder="Enter....." required>
                </div>
                
                <div class="form-group">
                  <label>Description</label>
                  <textarea class="form-control" name="s_description" placeholder="Enter....." rows="4" required></textarea>
                </div>
                
                 <div class="form-group">
                  <label>Product Image</label>
                  <input type="file" class="input-group" name="s_img">
                  <p>upload image</p>
                  </div>
              </div>
         </div>
                  <div class="box-footer">
                     
               
                   <button type="submit" class="btn btn-success" name="btn_product">Add Product</button>  
                  </div>
             </form>
        </div>
        </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
<?php include_once('../include/footer.php');?>

