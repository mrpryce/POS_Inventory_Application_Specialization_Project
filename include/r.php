
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





































<?php

//Getting User ID//
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

///User Registration///

if (isset($_POST['reg_submit'])) {
  $username = $_POST['reg_name'];
  $useremail = $_POST['reg_email'];
  $password = $_POST['reg_pass'];
  $role = $_POST['sel_role'];

  //$username ." - ".$useremail ." - ".$password." - ".$role;

  ////////////Adding Images in Registration Form/////////////////////////////////

 /****  
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
        */
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




    $id = $_GET['id'];

$select = $pdo->prepare("select * from blos_product where pid=$id");

$select->execute();
$row = $select->fetch(PDO::FETCH_ASSOC);
$id_db = $row['pid'];
$id_productname_db = $row['pname'];
$id_productcategory_db = $row['pcategory'];
$id_purchaseprice_db = $row['purchaseprice'];
$id_productsale_db = $row['saleprice'];
$id_productstock_db = $row['pstock'];
$id_productdescription_db = $row['pdescription'];
$id_productimage_db = $row['pimage'];
$id_productimage_db = $row['pimage'];
$id_imagepath_db = $row['image_path'];

///Variables from the blos_Product Database//////

if (isset($_POST['btn_updateProduct'])) {

    $productname_txt = $_POST['p_name'];
    $selcategory_txt = $_POST['sel_cat'];
    $purchaseprice_txt = $_POST['p_price'];
    $saleprice_txt = $_POST['s_price'];
    $stock_txt = $_POST['s_stock'];
    $description_txt = $_POST['s_description'];

    //echo $productname;//

    $imageName = $_FILES["s_img"]["name"];
    $imageTmpName = $_FILES["s_img"]["tmp_name"];
    $uploadDirectory = "uploads/"; //Directory for Uploading the Image
    $imageDestination = $uploadDirectory . $imageName;

    $imageExtension = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));
    $imageSize = $_FILES["s_img"]["size"];

    if(in_array($imageExtension, $allowedExtensions)&& $imageSize <= $maxFileSize){

      if(move_uploaded_file($imageTmpName, $imageDestination)){
 
       $stmt_update = $pdo->prepare("UPDATE blos_product set (pname=:pname, pcategory=:pcategory, purchaseprice=:purchaseprice, saleprice=:saleprice, pstock=:pstock, pdescription=:pdescription, pimage=:pimage, image_path=:image_path where pid = $id ");
        if ($stmt_update->execute([$productname_txt, $selcategory_txt, $purchaseprice_txt, $saleprice_txt, $stock_txt, $description_txt, $imageName, $imageDestination])) {
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

        ///end of update of images////

    } else {

        $stmt_update = $pdo->prepare("UPDATE blos_product set (pname=:pname, pcategory=:pcategory, purchaseprice=:purchaseprice, saleprice=:saleprice, pstock=:pstock, pdescription=:pdescription, pimage=:pimage, image_path=:image_path where pid = $id ");
        if ($stmt_update->execute([$productname_txt, $selcategory_txt, $purchaseprice_txt, $saleprice_txt, $stock_txt, $description_txt, $imageName, $imageDestination])) {
            $error = '<script>
        jQuery(function validation(){
         
          swal({
                 title: "Product Successfully",
                 text:  "Updated",
                icon: "success",
              button: "ok",
              });
         
         });
             </script>';
            echo $error;
        } else {
            $error = '<script>
        jQuery(function validation(){
         
          swal({
                 title: "Error",
                 text:  "Update Failed",
                icon: "error",
              button: "ok",
              });
         
         });
             </script>';
            echo $error;
        }
    }
















  
?>



<div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title"><a href="productlist.php" class="btn btn-primary" role="button">Back to Product List</a></h3>
                <form action="editproduct.php?id<?php echo $id; ?>" method="post" name="form_product" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Product Name</label>
                                <input type="text" class="form-control" name="p_name" value="<?php echo $productData['p_name'];  ?>" placeholder="Enter......" required>
                            </div>


                            <div class="form-group">
                                <label>Category</label>
                                <select class="form-control" name="sel_cat" required>
                                    <option value="" disabled selected>Select Category</option>
                                    <?php
                                    $select = $pdo->prepare("select * from blos_category order by catid desc");
                                    $select->execute();
                                    while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
                                        extract($row);
                                    ?>
                                        <option<?php if ($row['category'] == $id_productcategory_db) { ?> selected="selected" <?php } ?>>
                                            <?php echo $row['category']; ?></option>
                                        <?php
                                    }
                                        ?>
                                </select>
                            </div>


                            <div class="form-group">
                                <label>Purchase Price</label>
                                <input type="number" min="1" step="1" class="form-control" name="p_price" value="<?php echo $id_purchaseprice_db; ?>" placeholder="Enter....." required>
                            </div>



                            <div class="form-group">
                                <label>Sale Price</label>
                                <input type="number" min="1" step="1" class="form-control" name="s_price" value="<?php echo $id_productsale_db; ?>" placeholder="Enter....." required>
                            </div>


                        </div>
                        <div class="col-md-6">

                            <div class="form-group">
                                <label>Stock</label>
                                <input type="number" min="1" step="1" class="form-control" name="s_stock" value="<?php echo $id_productstock_db; ?>" placeholder="Enter....." required>
                            </div>

                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control" name="s_description" placeholder="Enter....." rows="4" required><?php echo $id_productdescription_db; ?></textarea>
                            </div>

                            <div class="form-group">
                                <label>Product Image</label>

                                <img src="../content/product_images/<?php echo $id_productimage_db; ?>" class="img-responsive" width="50px" height="50px" />
                                <input type="file" class="input-group" name="s_img">
                                <p>Upload Image</p>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-danger" name="btn_updateProduct">Update Product</button>
                    </div>
                </form>
            </div>
        </div>

    </section>
    <!-- /.content -->
</div>





























<?php 
include_once('../db/connect_db.php');

session_start();

include_once('../include/session.php');
include_once('../include/header.php');
include_once('../include/csrf_token.php');

?>

<?php

$msg = '';
$allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
$maxFileSize = 5 * 1024 * 1024; // 5MB


$categories = $pdo->query("SELECT * FROM blos_category order by catid desc")->fetchAll();


// Assuming product ID is being passed via GET
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$productData = null;

if ($id) {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$id]);
    $productData = $stmt->fetch();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && $productData) {
    $productname = $_POST['p_name'];
    $selcategory = $_POST['sel_cat'];
    $purchaseprice = $_POST['p_price'];
    $saleprice = $_POST['s_price'];
    $stock = $_POST['s_stock'];
    $description = $_POST['s_description'];
    $imageName = $productData['image_name'];
  
  


    if (isset($_FILES["s_image"]) && $_FILES["s_image"]["size"] > 0) {
        $newImageName = $_FILES["s_img"]["name"];
        $imageTmpName = $_FILES["s_img"]["tmp_name"];
        $uploadDirectory = "uploads/"; //Directory for Uploading the Image
        $imageDestination = $uploadDirectory . $newImageName;
        $imageExtension = strtolower(pathinfo($newImageName, PATHINFO_EXTENSION));
        $imageSize = $_FILES["s_img"]["size"];
        if(in_array($imageExtension, $allowedExtensions)&& $imageSize <= $maxFileSize){
        if(move_uploaded_file($imageTmpName, $imageDestination)){
            $imageName = $newImageName;
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

    // Update the product data in the database
    $stmt = $pdo->prepare("UPDATE blos_product SET pname = ?, pcategory = ?, purchaseprice = ?, saleprice = ?, pstock = ?, pdescription = ?, pimage = ? WHERE id = ?");
    if ($stmt->execute([$productname, $selcategory, $purchaseprice, $saleprice, $stock, $description, $imageName, $id])) {
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
}

if (!$productData) {
    die('<script>
    jQuery(function validation(){
    swal({
  title: "Error",
  text:  "Product Data not Found",
 icon: "error",
button: "ok",
});

});
</script>');
}
?>


<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">

    <!-- Content Header Page header -->

    <section class="content-header">
        <h1>Edit Product<small></small>
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
                <form action="editproduct.php?id<?php echo $id; ?>" method="post" name="form_product" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Product Name</label>
                                <input type="text" class="form-control" name="p_name" value="<?php echo $productData['p_name'];  ?>" placeholder="Enter......" required>
                            </div>


                            <div class="form-group">
                                <label>Category</label>
                                <select class="form-control" name="sel_cat" required>
                                    <option value="" disabled selected>Select Category</option>
                                      <?php foreach ($categories as $category):?>
                                        <option value="<?php echo $category['id']; ?>" <?php if ($productData['sel_cat']== $category['id']) echo 'selected'; ?>>
                                          <?php echo $category['category']; ?>
                                      </option>
                                      <?php endforeach; ?>
                                      </select>
                            </div>


                            <div class="form-group">
                                <label>Purchase Price</label>
                                <input type="number" min="1" step="1" class="form-control" name="p_price" value="<?php echo $productData['p_price']; ?>" placeholder="Enter....." required>
                            </div>



                            <div class="form-group">
                                <label>Sale Price</label>
                                <input type="number" min="1" step="1" class="form-control" name="s_price" value="<?php echo $productData['s_price']; ?>" placeholder="Enter....." required>
                            </div>


                        </div>
                        <div class="col-md-6">

                            <div class="form-group">
                                <label>Stock</label>
                                <input type="number" min="1" step="1" class="form-control" name="s_stock" value="<?php echo $productData['s_stock']; ?>" placeholder="Enter....." required>
                            </div>

                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control" name="s_description" placeholder="Enter....." rows="4" required><?php echo $productData['s_description']; ?></textarea>
                            </div>

                            <div class="form-group">
                                <label>Product Image</label>

                                <img src="../content/uploads<?php echo $productData['s_img']; ?>" class="img-responsive" width="50px" height="50px" />
                                <input type="file" class="input-group" name="s_img">
                                <p>Upload Image</p>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-danger" name="btn_updateProduct">Update Product</button>
                    </div>
                </form>
            </div>
        </div>

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Main Footer -->
<?php include_once('../include/footer.php'); ?>

<p><?php echo $msg; ?></p>































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


$id = $_GET['id'];

$select = $pdo->prepare("select * from blos_product where pid=$id");

$select->execute();
$row = $select->fetch(PDO::FETCH_ASSOC);


$id_db = $row['pid'];
$id_productname_db = $row['pname'];
$id_productcategory_db = $row['pcategory'];
$id_purchaseprice_db = $row['purchaseprice'];
$id_productsale_db = $row['saleprice'];
$id_productstock_db = $row['pstock'];
$id_productdescription_db = $row['pdescription'];
$id_productimage_db = $row['pimage'];

///Variables from the blos_Product Database//////

if (isset($_POST['btn_updateProduct'])) {

    $productname_txt = $_POST['p_name'];
    $selcategory_txt = $_POST['sel_cat'];
    $purchaseprice_txt = $_POST['p_price'];
    $saleprice_txt = $_POST['s_price'];
    $stock_txt = $_POST['s_stock'];
    $description_txt = $_POST['s_description'];

    //echo $productname;//

    $f_name = $_FILES['s_img']['name'];

    if (!empty($f_name)) {

        ///update images
        $f_tmp = $_FILES['s_img']['tmp_name'];
        $f_size = $_FILES['s_img']['size'];

        $f_extension = explode('.', $f_name);
        $f_extension = strtolower(end($f_extension));

        $_newfile = uniqid() . '.' . $f_extension;

        $store = "uploads/" . $_newfile;
        $imageDestination =  $store . $f_name;

        if ($f_extension == 'jpeg' || $f_extension == 'png' || $f_extension == 'jpg' || $f_extension == 'gif') {

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

                    $_newfile;


                    if (!isset($error)) {

                        $update = $pdo->prepare("update blos_product set pname=:pname , pcategory=:pcategory , purchaseprice=:purchaseprice , saleprice=:saleprice , pstock=:pstock , pdescription=:pdescription , pimage=:pimage , image_path=:image_path where pid = $id");

                        $update->bindParam(':pname', $productname_txt);
                        $update->bindParam(':pcategory', $selcategory_txt);
                        $update->bindParam(':purchaseprice', $purchaseprice_txt);
                        $update->bindParam(':saleprice', $saleprice_txt);
                        $update->bindParam(':pstock', $stock_txt);
                        $update->bindParam(':pdescription', $description_txt);
                        $update->bindParam(':pimage', $_newfile);
                        $update->bindParam(':image_path', $imageDestination);



                        if ($update->execute()) {
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
                        } else {
                            echo '<script>
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
        } else {

            $error = '<script>
                   jQuery(function validation(){
                   swal({
                 title: "File Format is Different",
                 text:  "All file format must be jpg,png,gif,jpeg",
                icon: "warning",
              button: "ok",
              });
         
         });
             </script>';
            echo $error;
        }



        ///end of update of images////

    } else {

        $update = $pdo->prepare("update blos_product set pname=:pname,pcategory=:pcategory,purchaseprice=:purchaseprice,saleprice=:saleprice,pstock=:pstock,pdescription=:pdescription,pimage=:pimage where pid = $id");

        $update->bindParam(':pname', $productname_txt);
        $update->bindParam(':pcategory', $selcategory_txt);
        $update->bindParam(':purchaseprice', $purchaseprice_txt);
        $update->bindParam(':saleprice', $saleprice_txt);
        $update->bindParam(':pstock', $stock_txt);
        $update->bindParam(':pdescription', $description_txt);
        $update->bindParam(':pimage', $id_productimage_db);
        $update->bindParam(':image_path', $imageDestination);



        if ($update->execute()) {
            $error = '<script>
        jQuery(function validation(){
         
          swal({
                 title: "Product Successfully",
                 text:  "Updated",
                icon: "success",
              button: "ok",
              });
         
         });
             </script>';
            echo $error;
        } else {
            $error = '<script>
        jQuery(function validation(){
         
          swal({
                 title: "Error",
                 text:  "Update Failed",
                icon: "error",
              button: "ok",
              });
         
         });
             </script>';
            echo $error;
        }
    }
}



?>

<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">

    <!-- Content Header Page header -->

    <section class="content-header">
        <h1>Edit Product<small></small>
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
                <form action="" method="post" name="form_product" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Product Name</label>
                                <input type="text" class="form-control" name="p_name" value="<?php echo $id_productname_db;  ?>" placeholder="Enter......" required>
                            </div>


                            <div class="form-group">
                                <label>Category</label>
                                <select class="form-control" name="sel_cat" required>
                                    <option value="" disabled selected>Select Category</option>
                                    <?php
                                    $select = $pdo->prepare("select * from blos_category order by catid desc");
                                    $select->execute();
                                    while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
                                        extract($row);
                                    ?>
                                        <option<?php if ($row['category'] == $id_productcategory_db) { ?> selected="selected" <?php } ?>>
                                            <?php echo $row['category']; ?></option>
                                        <?php
                                    }
                                        ?>
                                </select>
                            </div>


                            <div class="form-group">
                                <label>Purchase Price</label>
                                <input type="number" min="1" step="1" class="form-control" name="p_price" value="<?php echo $id_purchaseprice_db; ?>" placeholder="Enter....." required>
                            </div>



                            <div class="form-group">
                                <label>Sale Price</label>
                                <input type="number" min="1" step="1" class="form-control" name="s_price" value="<?php echo $id_productsale_db; ?>" placeholder="Enter....." required>
                            </div>


                        </div>
                        <div class="col-md-6">

                            <div class="form-group">
                                <label>Stock</label>
                                <input type="number" min="1" step="1" class="form-control" name="s_stock" value="<?php echo $id_productstock_db; ?>" placeholder="Enter....." required>
                            </div>

                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control" name="s_description" placeholder="Enter....." rows="4" required><?php echo $id_productdescription_db; ?></textarea>
                            </div>

                            <div class="form-group">
                                <label>Product Image</label>

                                <img src="../content/product_images/<?php echo $id_productimage_db; ?>" class="img-responsive" width="50px" height="50px" />
                                <input type="file" class="input-group" name="s_img">
                                <p>Upload Image</p>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-danger" name="btn_updateProduct">Update Product</button>
                    </div>
                </form>
            </div>
        </div>

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Main Footer -->
<?php include_once('../include/footer.php'); ?>