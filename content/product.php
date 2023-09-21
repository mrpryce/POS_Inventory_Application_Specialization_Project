<?php 
include_once('../db/connect_db.php');

session_start();

include_once('../include/session.php');
include_once('../include/header.php');
include_once('../include/csrf_token.php');

?>

<?php 

$msg = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["s_img"])) {
    
    $productname = $_POST['p_name'];
    $selcategory = $_POST['sel_cat'];
    $purchaseprice = $_POST['p_price'];
    $saleprice = $_POST['s_price'];
    $stock = $_POST['s_stock'];
    $description = $_POST['s_description'];
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif']; //allow Image Extension
    $maxFileSize = 5 * 1024 * 1024; //5MB

    $imageName = $_FILES["s_img"]["name"];
    $imageTmpName = $_FILES["s_img"]["tmp_name"];
    $uploadDirectory = "uploads/"; //Directory for Uploading the Image
    $imageDestination = $uploadDirectory . $imageName;

    $imageExtension = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));
    $imageSize = $_FILES["s_img"]["size"];

    if(in_array($imageExtension, $allowedExtensions)&& $imageSize <= $maxFileSize){

      if(move_uploaded_file($imageTmpName, $imageDestination)){

       $stmt = $pdo->prepare("INSERT INTO blos_product (pname,pcategory,purchaseprice,saleprice,pstock,pdescription,pimage,image_path) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        if ($stmt->execute([$productname, $selcategory, $purchaseprice, $saleprice, $stock, $description, $imageName, $imageDestination])) {
            $msg = '<script>
                      jQuery(function validation(){
                     swal({
                    title: "Successfully",
                   text:  "Product Added",
                    icon: "success",
                button: "ok",
                });
               });
              </script>';
        } else {
            $msg = '<script>
            jQuery(function validation(){
            swal({
          title: "Error",
          text:  "Error in saving to Database",
         icon: "error",
       button: "ok",
       });
  
       });
      </script>';
        }
    } else {
           $msg = '<script>
           jQuery(function validation(){
           swal({
           title: "Error",
           text:  "Error uploading image",
           icon: "error",
           button: "ok",
           });

         });
         </script>';
    }
} else {
         $msg = '<script>
         jQuery(function validation(){
         swal({
         title: "Error",
         text:  "Invalid image Format or image too large",
         icon: "error",
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

<p><?php echo $msg; ?></p>




























