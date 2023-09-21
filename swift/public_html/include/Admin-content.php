<?php

function rowCount($pdo, $query)
{
  $stmt = $pdo->prepare($query);
  $stmt->execute();
  return $stmt->rowCount();
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

    <section class="content">
      <!-- Info boxes -->
      <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="icon-tags"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Total Order</span>
              <span class="info-box-number">10</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-product-hunt"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Products</span>
              <span class="info-box-number"><?php echo rowCount($pdo, "select * from blos_product"); ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="ion ion-ios-cart-outline"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Sales</span>
              <span class="info-box-number">760</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Total User</span>
              <span class="info-box-number"><?php echo rowCount($pdo, "select * from blos_user"); ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      </div>
      <div class="row">
        <div class="col-md-6">
          <!-- Info Boxes Style 2 -->
          <div class="info-box bg-yellow">
            <span class="info-box-icon"><i class="ion ion-ios-pricetag-outline"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Total Order</span>
              <span class="info-box-number">5,200</span>
            </div>
            <!-- /.info-box-content -->
          </div>
        </div>
        <div class="col-md-6">
          <!-- /.info-box -->
          <div class="info-box bg-green">
            <span class="info-box-icon"><i class="ion ion-ios-heart-outline"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Total Sale</span>
              <span class="info-box-number">92,050</span>

            </div>
            <!-- /.info-box-content -->
          </div>
        </div>
      </div>


    </section>








    <!-- TABLE: LATEST ORDERS -->

    <div class="col-md-8">
      <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title">Latest Orders</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="table-responsive">
            <table class="table no-margin">
              <thead>
                <tr>
                  <th>Order ID</th>
                  <th>Item</th>
                  <th>Status</th>
                  <th>Popularity</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><a href="pages/examples/invoice.html">OR9842</a></td>
                  <td>Call of Duty IV</td>
                  <td><span class="label label-success">Shipped</span></td>
                  <td>
                    <div class="sparkbar" data-color="#00a65a" data-height="20">90,80,90,-70,61,-83,63</div>
                  </td>
                </tr>
                <tr>
                  <td><a href="pages/examples/invoice.html">OR1848</a></td>
                  <td>Samsung Smart TV</td>
                  <td><span class="label label-warning">Pending</span></td>
                  <td>
                    <div class="sparkbar" data-color="#f39c12" data-height="20">90,80,-90,70,61,-83,68</div>
                  </td>
                </tr>
                <tr>
                  <td><a href="pages/examples/invoice.html">OR7429</a></td>
                  <td>iPhone 6 Plus</td>
                  <td><span class="label label-danger">Delivered</span></td>
                  <td>
                    <div class="sparkbar" data-color="#f56954" data-height="20">90,-80,90,70,-61,83,63</div>
                  </td>
                </tr>
                <tr>
                  <td><a href="pages/examples/invoice.html">OR7429</a></td>
                  <td>Samsung Smart TV</td>
                  <td><span class="label label-info">Processing</span></td>
                  <td>
                    <div class="sparkbar" data-color="#00c0ef" data-height="20">90,80,-90,70,-61,83,63</div>
                  </td>
                </tr>
                <tr>
                  <td><a href="pages/examples/invoice.html">OR1848</a></td>
                  <td>Samsung Smart TV</td>
                  <td><span class="label label-warning">Pending</span></td>
                  <td>
                    <div class="sparkbar" data-color="#f39c12" data-height="20">90,80,-90,70,61,-83,68</div>
                  </td>
                </tr>
                <tr>
                  <td><a href="pages/examples/invoice.html">OR7429</a></td>
                  <td>iPhone 6 Plus</td>
                  <td><span class="label label-danger">Delivered</span></td>
                  <td>
                    <div class="sparkbar" data-color="#f56954" data-height="20">90,-80,90,70,-61,83,63</div>
                  </td>
                </tr>
                <tr>
                  <td><a href="pages/examples/invoice.html">OR9842</a></td>
                  <td>Call of Duty IV</td>
                  <td><span class="label label-success">Shipped</span></td>
                  <td>
                    <div class="sparkbar" data-color="#00a65a" data-height="20">90,80,90,-70,61,-83,63</div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- /.table-responsive -->
        </div>
        <!-- /.box-body -->
        <div class="box-footer clearfix">
          <a href="javascript:void(0)" class="btn btn-sm btn-info btn-flat pull-left">Place New Order</a>
          <a href="javascript:void(0)" class="btn btn-sm btn-default btn-flat pull-right">View All Orders</a>
        </div>
        <!-- /.box-footer -->
      </div>
    </div>
    <div class="col-md-4">
      <!-- PRODUCT LIST -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Recently Added Products</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <ul class="products-list product-list-in-box">
            <li class="item">
              <div class="product-img">
                <img src="dist/img/default-50x50.gif" alt="Product Image">
              </div>
              <div class="product-info">
                <a href="javascript:void(0)" class="product-title">Samsung TV
                  <span class="label label-warning pull-right">$1800</span></a>
                <span class="product-description">
                  Samsung 32" 1080p 60Hz LED Smart HDTV.
                </span>
              </div>
            </li>
            <!-- /.item -->
            <li class="item">
              <div class="product-img">
                <img src="dist/img/default-50x50.gif" alt="Product Image">
              </div>
              <div class="product-info">
                <a href="javascript:void(0)" class="product-title">Bicycle
                  <span class="label label-info pull-right">$700</span></a>
                <span class="product-description">
                  26" Mongoose Dolomite Men's 7-speed, Navy Blue.
                </span>
              </div>
            </li>
            <!-- /.item -->
            <li class="item">
              <div class="product-img">
                <img src="dist/img/default-50x50.gif" alt="Product Image">
              </div>
              <div class="product-info">
                <a href="javascript:void(0)" class="product-title">Xbox One <span class="label label-danger pull-right">$350</span></a>
                <span class="product-description">
                  Xbox One Console Bundle with Halo Master Chief Collection.
                </span>
              </div>
            </li>
            <!-- /.item -->
            <li class="item">
              <div class="product-img">
                <img src="dist/img/default-50x50.gif" alt="Product Image">
              </div>
              <div class="product-info">
                <a href="javascript:void(0)" class="product-title">PlayStation 4
                  <span class="label label-success pull-right">$399</span></a>
                <span class="product-description">
                  PlayStation 4 500GB Console (PS4)
                </span>
              </div>
            </li>
            <!-- /.item -->
          </ul>
        </div>
        <!-- /.box-body -->
        <div class="box-footer text-center">
          <a href="../content/productlist.php" class="uppercase">View All Products</a>
        </div>
        <!-- /.box-footer -->
      </div>
    </div>

  </section>
  <!-- /.content -->


</div>