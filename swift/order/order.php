<?php 
include_once('../db/connect_db.php');

session_start();

function fill_product($pdo){
    
    $output='';

$select=$pdo->prepare("select * from blos_product order by pname asc");

$select->execute();

$result=$select->fetchAll();

foreach($result as $row){
    
    $output.='<option value="'.$row["pid"].'">'.$row["pname"].'</option>';
      
}
return $output;
    
}


if(isset($_POST['btn_order'])){
    
     $customer_name=$_POST['c_name'];
     $order_date=date('Y-m-d',strtotime($_POST['order_date']));
     $sub_total=$_POST['c_subTotal'];
     $tax=$_POST['c_tax'];
     $discount=$_POST['c_discount'];
     $total=$_POST['c_total'];
     $paid=$_POST['c_paid'];
     $balance=$_POST['c_due'];
     $payment_method=$_POST['rb'];
    

    
    ///////////Invoice_detail Variabe///////////////
    
        $arr_productid=$_POST['productid'];
        $arr_productname=$_POST['productname'];
        $arr_productstock=$_POST['stock'];
        $arr_productqty=$_POST['qty'];
        $arr_productprice=$_POST['price'];
        $arr_producttotal=$_POST['total'];

 
$insert=$pdo->prepare("insert into 
blos_order(customer_name,order_date,sub_total,tax,discount,total,paid,balance,payment_method)
values(:cust,:orderd,:subt,:tax,:disc,:total,:paid,:bal,:paytype)");

    
      $insert->bindParam(':cust',$customer_name);
      $insert->bindParam(':orderd',$order_date);
      $insert->bindParam(':subt',$sub_total);
      $insert->bindParam(':tax',$tax);
      $insert->bindParam(':disc',$discount);
      $insert->bindParam(':total',$total);
      $insert->bindParam(':paid',$paid);
      $insert->bindParam(':bal',$balance);
      $insert->bindParam(':paytype',$payment_method);
    
       $insert->execute();
    
 ///insert query for invoice details
    
    
    $invoice_id=$pdo->lastInsertId();
    if($invoice_id!=null){
        for($i=0 ; $i<count($arr_productid) ; $i++){
            
         $rem_qty = $arr_productstock[$i]-$arr_productqty[$i]; 
            
        if($rem_qty<0){
            return"Order is not Complete";
        }else{
            
        $update=$pdo->prepare("update blos_product SET pstock ='$rem_qty' where pid='".$arr_productid[$i]."'");
            
            $update->execute();
        }    
            
            
            
            
            
            
            
    $insert=$pdo->prepare("insert into blos_invoice_details(invoice_id,product_id,product_name,product_qty,price,order_date)
    values(:inid,:pid,:pname,:pqty,:oprice,:odate)");
            
      $insert->bindParam(':inid',$invoice_id);
      $insert->bindParam(':pid',$arr_productid[$i]);
      $insert->bindParam(':pname',$arr_productname[$i]);
      $insert->bindParam(':pqty',$arr_productqty[$i]);
      $insert->bindParam(':oprice',$arr_productprice[$i]);
      $insert->bindParam(':odate',$order_date);
            
      $insert->execute();
        }
  
        
        
         //echo"Order Successfully;
        
        header('location:orderlist.php');   
        
        
        
            
        
    }
    
    
       

    
    
    
}

include_once('../include/header.php');

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
<h1>
Create Order
<small></small>
</h1>
<ol class="breadcrumb">
<li><a href="#"><i class="fa fa-dashboard"></i>Level</a></li>
<li class="active">Here</li>
</ol>
</section>

<!-- Main content -->
<section class="content container-fluid">

<!--------------------------
| Your Page Content Here |
-------------------------->


<div class="box box-success">
<form action="" method="post" name="">
<div class="box-header with-border">
<h3 class="box-title">Create Order</h3>
</div>
<div class="box-body">

<div class="col-md-6">
<div class="form-group">
<label>Customer Name</label>
<div class="input-group">
<div class="input-group-addon">
<i class="fa fa-user"></i>
</div>
<input type="text" class="form-control" name="c_name" placeholder="Enter Customer Name" required>
</div></div> 
</div>
<div class="col-md-6">
<div class="form-group">
<label>Date range:</label>

<div class="input-group">
<div class="input-group-addon">
<i class="fa fa-calendar"></i>
</div>
<input type="text" class="form-control pull-right" id="datepicker" name="order_date" value="<?php echo date("Y-m-d");?>" data-date-format="yyyy-mm-dd">
</div>
<!-- /.input group -->
</div>
</div>

</div><!---this is for customer and date-->
<div class="box-body">
<div class="col-md-12">
<div style="overflow-x:auto">
<table id="tableProduct" class="table table-striped table-bordered">
<thead>
<tr>
<th>#</th>
<th>Search Product</th>
<th>Stock</th>
<th>Sale Price</th>
<th>Enter Quanity</th>
<th>Total</th>
<th>
<center><button type="button" name="add" class="btn btn-success btn-sm btnadd"><span class="glyphicon glyphicon-plus"></span></button></center>
</th>
</tr>
</thead>
<tbody>
</tbody>
</table>
    </div>
</div>

</div><!---this is for customer and date-->



<div class="box-body">

<div class="col-md-6">

<div class="form-group">
<label>Sub Total</label>
<div class="input-group">
<div class="input-group-addon">
<i class="fa fa-money"></i>
</div>
<input type="text" class="form-control" name="c_subTotal" placeholder="Sub Total" id="c_subTotal" required readonly>
</div></div> 

<div class="form-group">
<label>Tax (5%)</label>
<div class="input-group">
<div class="input-group-addon">
<i class="fa fa-money"></i>
</div>
<input type="text" class="form-control" name="c_tax" placeholder="Tax" id="c_tax"required readonly>
</div></div>

<div class="form-group">
<label>Disount</label>
<div class="input-group">
<div class="input-group-addon">
<i class="fa fa-money"></i>
</div>
<input type="text" class="form-control" name="c_discount" placeholder="Disount" id="c_discount" required>
</div></div>

</div>

<div class="col-md-6">


<div class="form-group">
<label>Total</label>
<div class="input-group">
<div class="input-group-addon">
<i class="fa fa-money"></i>
</div>
<input type="text" class="form-control" name="c_total" placeholder="Total" id="c_total" required readonly>
</div></div> 


<div class="form-group">
<label>Paid</label>
<div class="input-group">
<div class="input-group-addon">
<i class="fa fa-money"></i>
</div>
<input type="text" class="form-control" name="c_paid" placeholder="Paid" id="c_paid" required>
</div></div>


<div class="form-group">
<label>Balance</label>
<div class="input-group">
<div class="input-group-addon">
<i class="fa fa-money"></i>
</div>
<input type="text" class="form-control" name="c_due" placeholder="Due" id="c_balance" required readonly>
</div></div>

<label>Payment Method</label>
<div class="form-group">
<label>
<input type="radio" name="rb" class="flat-red" value="cash" checked>CASH
</label>
<label>
<input type="radio" name="rb" class="flat-red" value="cheque">CHEQUE
</label>
<label>
<input type="radio" name="rb" class="flat-red" value="pos">POS
</label>
</div>
<hr>
<div>

<!--<input type="submit" name="btnsaveorder" value="Save Order" class="btn btn-success">-->
  <button type="submit" class="btn btn-info" name="btn_order">Submit</button>
</div>

</div>

</div>




</form>

</div>


</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script>
//Date picker
$('#datepicker').datepicker({
autoclose: true
});


//Date picker
$('#datepicker').datepicker({
autoclose: true
});

</script>

<script>
//Flat red color scheme for iCheck//
$('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
checkboxClass: 'icheckbox_flat-green',
radioClass   : 'iradio_flat-green'
});


</script>

<script>


$(document).ready(function(){
$(document).on('click','.btnadd',function(){

var html='';
html+='<tr>';

html+='<td><input type="hidden" class="form-control pname"  name="productname[]" readonly></td>';
    
html+='<td><select class="form-control productid"  name="productid[]" style="width:200px;"><option value="">Select Option</option><?php echo fill_product($pdo);?></select></td>';
    
html+='<td><input type="text" class="form-control stock"  name="stock[]" readonly></td>';
html+='<td><input type="text" class="form-control price"  name="price[]" readonly></td>';
html+='<td><input type="number" class="form-control qty"  name="qty[]" ></td>';
html+='<td><input type="text" class="form-control total"  name="total[]" readonly></td>';
    
html+='<center><td><button type="button"  name="remove"  class="btn btn-danger btn-sm btnremove"><span class="glyphicon glyphicon-remove"></span></button><center></td></center>';
    
$('#tableProduct').append(html);
    
    //Initialize Select2 Elements
    $('.productid').select2()
    
    
     $(".productid").on('change' , function(e){
            
            var productid= this.value;
            var tr= $(this).parent().parent();
            
            $.ajax({
              
              url:"getproduct.php",
              method:"get",
             data:{id:productid},
             success: function(data){
                 
                //console.log(data);
            tr.find(".pname").val(data["pname"]);    
            tr.find(".stock").val(data["pstock"]);
            tr.find(".price").val(data["saleprice"]);
             tr.find(".qty").val(1);
            tr.find(".total").val( tr.find(".qty").val() * tr.find(".price").val());
                 calculate(0,0);
                
            }
                
            })
            
            
        })
    
})
      



    
    $(document).on('click','.btnremove',function(){

        $(this).closest('tr').remove();
           calculate(0,0);
           $('#c_paid').val(0);
        
       
        
    })//btn remove
    
    
    $('#tableProduct').delegate(".qty","keyup" ,function(){
        
    var quantity =$(this);
    var tr=$(this).parent().parent();
    
    if( (quantity.val()-0)>(tr.find(".stock").val()-0) ){
        swal("WARNING!","SORRY! this quantity is not available","warning");
        
        quantity.val(1);
        
          tr.find(".total").val(quantity.val() * tr.find(".price").val());
               calculate(0,0);
       
    }else{
             tr.find(".total").val(quantity.val() * tr.find(".price").val());
                  calculate(0,0);
        
    }

      })
    
    function calculate(dis,paid){
        
        var subtotal=0;
        var tax=0;
        var discount=dis;
        var total_net=0;
        var paid_amt=paid;
        var balance=0;
        
        $(".total").each(function(){
            
            
            subtotal = subtotal+($(this).val()*1);
        })
        
        tax=0.05*subtotal;
        total_net=tax+subtotal;
        total_net=total_net-discount;
        balance=total_net-paid_amt;
        
        
        
        $("#c_subTotal").val(subtotal.toFixed(2));
        $("#c_tax").val(tax.toFixed(2));
         $("#c_discount").val(discount);
         $("#c_total").val(total_net.toFixed(2));
         //("#c_paid").val(paid_amt.toFixed(2));
         $("#c_balance").val(balance.toFixed(2));
        
        
    }
    $('#c_discount').keyup(function(){
        var discount = $(this).val();
        calculate(discount,0);
    })
    
    $('#c_paid').keyup(function(){
        var paid = $(this).val();
         var discount = $('#c_discount').val();
        calculate(discount,paid);
    })
    
    
    
    
    
});
    
    


</script>



<!-- Main Footer -->
<?php include_once('../include/footer.php');?>

