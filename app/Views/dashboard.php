<!DOCTYPE html>
<html>
<head>
<!-- FORM CSS CODE -->
<?php include"comman/code_css_datatable.php"; ?>
<!-- </copy> -->  
<!-- jvectormap -->
<link rel="stylesheet" href="<?= base_url('theme/plugins/jvectormap/jquery-jvectormap-1.2.2.css')?>">
<style type="text/css"> 
   #chart_container {
   min-width: 320px;
   max-width: 600px;
   margin: 0 auto;
   }
   
</style>

</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
  <!-- Notification sound -->
  <audio id="login">
    <source src="<?= base_url('theme/sound/login.mp3')?>" type="audio/mpeg">
    <source src="<?= base_url('theme/sound/login.ogg')?>" type="audio/ogg">
  </audio>
  <script type="text/javascript">
    var login_sound = document.getElementById("login"); 
  </script>
  <!-- Notification end -->
  <script type="text/javascript">

    <?php 
      if($session->getFlashdata('success')){?>
        login_sound.play();
    <?php } ?>
  </script>
  
  <?php include"sidebar.php"; ?>



  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper ">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?= $page_title;?>
        <small>Overall Information on Single Screen</small>
      </h1>
      <ol class="breadcrumb">
        <li class="active"><i class="fa fa-dashboard"></i> Home</li>
      </ol>
    </section><br/>
    <div class="row">
    <div class="col-md-12">
      <!-- ********** ALERT MESSAGE START******* -->
       <?php include"comman/code_flashdata.php"; ?>
       <!-- ********** ALERT MESSAGE END******* -->
     </div>
     </div>
     
     
      
        

    <!-- Main content -->
    <section class="content">
      <div class="row">
          <div class="col-md-3 col-sm-6 col-xs-12">
             <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="ion ion-bag"></i></span>
                <div class="info-box-content">
                   <span class="text-bold text-uppercase"><?= lang('app.total_purchase_due'); ?></span>
                   <span class="info-box-number">
                    <?= number_format($purchase_due, 2); ?></span>
                </div>
                <!-- /.info-box-content -->
             </div>
             <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <div class="col-md-3 col-sm-6 col-xs-12">
             <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="fa fa-dollar"></i></span>
                <div class="info-box-content">
                   <span class="text-bold text-uppercase"><?= lang('app.total_sales_due'); ?></span>
                   <span class="info-box-number"><?= number_format($sales_due, 2); ?></span>
                </div>
                <!-- /.info-box-content -->
             </div>
             <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-md-3 col-sm-6 col-xs-12">
             <div class="info-box">
                <span class="info-box-icon bg-green"><i class="fa fa-cart-plus"></i></span>
                <div class="info-box-content">
                   <span class="text-bold text-uppercase"><?= lang('app.total_sales_amount'); ?></span>
                   <span class="info-box-number"><?= number_format($tot_sal_grand_total, 2); ?></span>
                </div>
                <!-- /.info-box-content -->
             </div>
             <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-md-3 col-sm-6 col-xs-12">
             <div class="info-box">
                <span class="info-box-icon bg-red "><i class="fa fa-minus-square-o"></i></span>
                <div class="info-box-content">
                   <span class="text-bold text-uppercase"><?= lang('app.total_expense_amount'); ?></span>
                     <span class="info-box-number"><?= number_format($tot_exp, 2); ?></span>
                   </span>
                </div>
                <!-- /.info-box-content -->
             </div>
             <!-- /.info-box -->
          </div>
          <!-- /.col -->
       </div>
       <div class="row">
          <div class="col-md-3 col-sm-6 col-xs-12">
             <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="ion ion-bag"></i></span>
                <div class="info-box-content">
                   <span class="text-bold text-uppercase"><?= lang('app.todays_total_purchase'); ?></span>
                   <span class="info-box-number"><?= number_format($todays_total_purchase, 2); ?></span>
                </div>
                <!-- /.info-box-content -->
             </div>
             <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-md-3 col-sm-6 col-xs-12">
             <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="fa fa-dollar"></i></span>
                <div class="info-box-content">
                   <span class="text-bold text-uppercase"><?= lang('app.today_payment_received'); ?>(Sales)</span>
                   <span class="info-box-number"><?= number_format($today_payment_received, 2); ?></span>
                </div>
                <!-- /.info-box-content -->
             </div>
             <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-md-3 col-sm-6 col-xs-12">
             <div class="info-box">
                <span class="info-box-icon bg-green"><i class="fa fa-cart-plus"></i></span>
                <div class="info-box-content">
                   <span class="text-bold text-uppercase"><?= lang('app.todays_total_sales'); ?></span>
                   <span class="info-box-number"><?= number_format($todays_total_sales, 2); ?></span>
                </div>
                <!-- /.info-box-content -->
             </div>
             <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-md-3 col-sm-6 col-xs-12">
             <div class="info-box">
                <span class="info-box-icon bg-red "><i class="fa fa-minus-square-o"></i></span>
                <div class="info-box-content">
                   <span class="text-bold text-uppercase"><?= lang('app.todays_total_expense'); ?></span>
                     <span class="info-box-number"><?= number_format($todays_total_expense, 2); ?></span>
                   </span>
                </div>
                <!-- /.info-box-content -->
             </div>
             <!-- /.info-box -->
          </div>
          <!-- /.col -->
       </div>
       <!-- /.row -->
      <!-- Info boxes -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-dream-pink">
            <div class="inner text-uppercase">
              <h3><?= $tot_cust;?></h3><p><?= lang('app.customers'); ?></p>
            </div>
            <div class="icon">
              <i class="fa fa-group "></i>
            </div>
            <?php if($session->get('inv_userid')==1){ ?> 
            <a href="<?= base_url('customers') ?>" class="small-box-footer text-uppercase">View <i class="fa fa-arrow-circle-right"></i>
          </a>
          <?php } ?>
          </div>
        </div>
        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-dream-purple">
            <div class="inner text-uppercase">
              <h3><?= $tot_sup;?></h3><p><?= lang('app.suppliers'); ?></p>
            </div>
            <div class="icon">
              <i class="fa fa-group "></i>
            </div>
            <?php if($session->get('inv_userid')==1){ ?> 
            <a href="<?= base_url('suppliers') ?>" class="small-box-footer text-uppercase">View <i class="fa fa-arrow-circle-right"></i>
          </a>
          <?php } ?>
          </div>
        </div>
        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-dream-maroon">
            <div class="inner text-uppercase">
              <h3><?= $tot_pur;?></h3><p><?= lang('app.purchase_invoice'); ?></p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-paper-outline"></i>
            </div>
            <?php if($session->get('inv_userid')==1){ ?> 
            <a href="<?= base_url('purchase') ?>" class="small-box-footer text-uppercase">View <i class="fa fa-arrow-circle-right"></i>
          </a>
          <?php } ?>
          </div>
        </div>
        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-dream-green">
            <div class="inner text-uppercase">
              <h3><?= $tot_sal;?></h3><p><?= lang('app.sales_invoice'); ?></p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-paper-outline"></i>
            </div>
            <?php if($session->get('inv_userid')==1){ ?> 
            <a href="<?= base_url('sales') ?>" class="small-box-footer text-uppercase">View <i class="fa fa-arrow-circle-right"></i>
          </a>
          <?php } ?>
          </div>
        </div>

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>

        <!-- /.col -->
        
      </div>
      <!-- /.row -->
     <div class="row">
     <div class="col-md-8">
      <!-- BAR CHART -->
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title text-uppercase"><?= lang('app.purchase_and_sales_bar_chart'); ?></h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <div class="chart">
                <canvas id="barChart" style="height:230px"></canvas>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-4">


          <!-- PRODUCT LIST -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title text-uppercase"><?= lang('app.recently_added_items'); ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              
              
                      <table class="table table-bordered table-responsive">
                        <tr class='bg-blue'>
                          <td>Sl.No</td>
                          <td><?= lang('app.item_name'); ?></td>
                          <td><?= lang('app.item_sales_price'); ?></td>
                        </tr>
                        <tbody>
                <?php
                    if($recently_added_items){
                      $i=1;
                      foreach($recently_added_items as $res5){
                        ?>
                        <tr>
                          <td><?php echo $i++; ?></td>
                          <td><?php echo $res5['item_name']; ?></td>
                          <td><?php echo currency($res5['sales_price'],$with_comma=true); ?></td>
                        </tr>
                        
                        <?php
                      }
                    }
                    ?>
                    </tbody>
                    <?php if($session->get('inv_userid')==1){ ?> 
                      <tfoot>
                      <tr>
                        <td colspan="3" class="text-center"><a href="<?=base_url('items')?>" class="uppercase"><?= lang('app.view_all'); ?></a></td>
                      </tr>
                    </tfoot>
                    <?php } ?>
                  </table>
                
               
            
            </div>
            <!-- /.box-body -->
          
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
     </div>
     
      <!-- ############################# GRAPHS ############################## -->
     
      <!-- /.row -->
      <div class="row">
        <!-- /.row -->
     
     <div class="col-md-6">
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title text-uppercase"><?= lang('app.expired_items'); ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table id="" class=" datatable table table-bordered table-hover">
                <thead>
                <tr class='bg-blue'>
                  <th>#</th>
                  <th><?= lang('app.item_code'); ?></th>
                  <th><?= lang('app.item_name'); ?></th>
                  <th><?= lang('app.category_name'); ?></th>
                  <th><?= lang('app.expire_date'); ?></th>
                </tr>
                </thead>
                <tbody>
        <?php

        if($expired_items){
          $i=1;
          foreach ($expired_items as $row){
            echo "<tr>";
            echo "<td>".$i++."</td>";
            echo "<td>".$row['item_code']."</td>";
            echo "<td>".$row['item_name']."</td>";
            echo "<td>".$row['category_name']."</td>";
            echo "<td>".show_date($row['expire_date'])."</td>";
            echo "</tr>";
          }
        }
        ?>
        
                </tbody>
                 <tfoot>
                      <tr>
                        <td colspan="5" class="text-center"><a href="<?php base_url('reports/expired_items'); ?>" class="uppercase"><?= lang('app.view_all'); ?></a></td>
                      </tr>
                    </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <!-- /.col (LEFT) -->
        <div class="col-md-6">
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title text-uppercase"><?= lang('app.stock_alert'); ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table id="" class="table table-bordered table-hover">
                <thead>
                <tr class='bg-blue'>
                  <th>#</th>
                  <th><?= lang('app.item_name'); ?></th>
                  <th><?= lang('app.category_name'); ?></th>
                  <th><?= lang('app.stock'); ?></th>
                </tr>
                </thead>
                <tbody>
        <?php
        if ($stock_alert){
          $i=1;
          foreach ($stock_alert as $row){
            echo "<tr>";
            echo "<td>".$i++."</td>";
            echo "<td>".$row['item_name']."</td>";
            echo "<td>".$row['category_name']."</td>";
            echo "<td>".$row['stock']."</td>";
            echo "</tr>";
          }
        }
        ?>
        
                </tbody>
                <tfoot>
                      <tr>
                        <td colspan="4" class="text-center"><a href="<?php base_url('reports/stock'); ?>" class="uppercase"><?= lang('app.view_all'); ?></a></td>
                      </tr>
                    </tfoot>
                
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

        </div>
        <!-- /.col (RIGHT) -->
      </div>
      <div class="row">
          <!-- /.col -->
          <div class=" col-sm-12 col-md-12 col-lg-12 col-xs-12">
             <!-- PRODUCT LIST -->
             <div class="box box-primary">
                <!-- /.box-header -->
                <div class="box-body ">
                   <div id="bar_container" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>
                </div>
                <!-- /.box-body -->
             </div>
             <!-- /.box -->
          </div>
          <!-- /.col -->
       </div>
      <?php 
        //Bar chart information
        $jan_pur=$feb_pur=$mar_pur=$apr_pur=$may_pur=$jun_pur=$jul_pur=$aug_pur=$sep_pur=$oct_pur=$nov_pur=$dec_pur=0;
        $jan_sal=$feb_sal=$mar_sal=$apr_sal=$may_sal=$jun_sal=$jul_sal=$aug_sal=$sep_sal=$oct_sal=$nov_sal=$dec_sal=0;

        if($bar_chart){
          foreach($bar_chart as $res1){
            if($res1['purchase_date'] == '1'){ $jan_pur = $res1['pur_total']; }
            else if($res1['purchase_date'] == '2'){ $feb_pur = $res1['pur_total']; }
            else if($res1['purchase_date'] == '3'){ $mar_pur = $res1['pur_total']; }
            else if($res1['purchase_date'] == '4'){ $apr_pur = $res1['pur_total']; }
            else if($res1['purchase_date'] == '5'){ $may_pur = $res1['pur_total']; }
            else if($res1['purchase_date'] == '6'){ $jun_pur = $res1['pur_total']; }
            else if($res1['purchase_date'] == '7'){ $jul_pur = $res1['pur_total']; }
            else if($res1['purchase_date'] == '8'){ $aug_pur = $res1['pur_total']; }
            else if($res1['purchase_date'] == '9'){ $sep_pur = $res1['pur_total']; }
            else if($res1['purchase_date'] == '10'){ $oct_pur = $res1['pur_total']; }
            else if($res1['purchase_date'] == '11'){ $nov_pur = $res1['pur_total']; }
            else if($res1['purchase_date'] == '12'){ $dec_pur = $res1['pur_total']; }
          }
        }

        //DONUS CHART
        if($donus_chart){
          foreach($donus_chart as $res2){
            if($res2['sales_date'] == '1'){ $jan_sal = $res2['sal_total']; }
            else if($res2['sales_date'] == '2'){ $feb_sal = $res2['sal_total']; }
            else if($res2['sales_date'] == '3'){ $mar_sal = $res2['sal_total']; }
            else if($res2['sales_date'] == '4'){ $apr_sal = $res2['sal_total']; }
            else if($res2['sales_date'] == '5'){ $may_sal = $res2['sal_total']; }
            else if($res2['sales_date'] == '6'){ $jun_sal = $res2['sal_total']; }
            else if($res2['sales_date'] == '7'){ $jul_sal = $res2['sal_total']; }
            else if($res2['sales_date'] == '8'){ $aug_sal = $res2['sal_total']; }
            else if($res2['sales_date'] == '9'){ $sep_sal = $res2['sal_total']; }
            else if($res2['sales_date'] == '10'){ $oct_sal = $res2['sal_total']; }
            else if($res2['sales_date'] == '11'){ $nov_sal = $res2['sal_total']; }
            else if($res2['sales_date'] == '12'){ $dec_sal = $res2['sal_total']; }
          }
        }
      ?>
      <!-- ############################# GRAPHS END############################## -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php require_once 'footer.php'; ?>
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>

</div>
<!-- ./wrapper -->

<!-- SOUND CODE -->
<?php include"comman/code_js_sound.php"; ?>
<!-- TABLES CODE -->
<?php include"comman/code_js_datatable.php"; ?>
<!-- bootstrap datepicker -->

<!-- ChartJS 1.0.1 -->
<script src="<?= base_url('theme/plugins/chartjs/Chart.min.js')?>"></script>


<!-- Sparkline -->
<script src="<?= base_url('theme/plugins/sparkline/jquery.sparkline.min.js')?>"></script>
<!-- jvectormap -->
<script src="<?= base_url('theme/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js')?>"></script>
<script src="<?= base_url('theme/plugins/jvectormap/jquery-jvectormap-world-mill-en.js')?>"></script>

 <!-- BAR CHART -->
<script src="<?= base_url('theme/plugins/highcharts/highcharts.js')?>"></script>
<script src="<?= base_url('theme/plugins/highcharts/highcharts-more.js')?>"></script>
<script src="<?= base_url('theme/plugins/highcharts/exporting.js')?>"></script>
<!-- BAR CHART END -->
<!-- PIE CHART -->
<script src="<?= base_url('theme/plugins/highcharts/export-data.js')?>"></script>
<!-- PIE CHART END -->

<!-- Make sidebar menu hughlighter/selector -->
<script>$(".<?php echo basename(__FILE__,'.php');?>-active-li").addClass("active");</script>
<script>
  $(function () {
    $('#example2,#example3').DataTable({
      "pageLength" : 5,
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });
  });
</script>
<script>
  $(function () {
    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */


    //-------------
    //- BAR CHART -
    //-------------
    var barChartData = {
      labels: ["January", "February", "March", "April", "May", "June", "July","August","September","October","November","December"],
      datasets: [
        {
          label: "Purchase Amt(in <?= currency() ?>)",
          fillColor: "rgba(210, 214, 222, 1)",
          strokeColor: "rgba(210, 214, 222, 1)",
          pointColor: "rgba(210, 214, 222, 1)",
          pointStrokeColor: "#c1c7d1",
          pointHighlightFill: "#fff",
          pointHighlightStroke: "rgba(220,220,220,1)",
          data: [<?php echo $jan_pur; ?>, <?php echo $feb_pur; ?>, <?php echo $mar_pur; ?>, <?php echo $apr_pur; ?>, <?php echo $may_pur; ?>, <?php echo $jun_pur; ?>, <?php echo $jul_pur; ?>, <?php echo $aug_pur; ?>, <?php echo $sep_pur; ?>, <?php echo $oct_pur; ?>, <?php echo $nov_pur; ?>, <?php echo $dec_pur; ?>]
        },
        {
          label: "Sales Amt(in <?= currency();?>)",
          fillColor: "rgba(60,141,188,0.9)",
          strokeColor: "rgba(60,141,188,0.8)",
          pointColor: "#3b8bba",
          pointStrokeColor: "rgba(60,141,188,1)",
          pointHighlightFill: "#fff",
          pointHighlightStroke: "rgba(60,141,188,1)",
          data: [<?php echo $jan_sal; ?>, <?php echo $feb_sal; ?>, <?php echo $mar_sal; ?>, <?php echo $apr_sal; ?>, <?php echo $may_sal; ?>, <?php echo $jun_sal; ?>, <?php echo $jul_sal; ?>, <?php echo $aug_sal; ?>, <?php echo $sep_sal; ?>, <?php echo $oct_sal; ?>, <?php echo $nov_sal; ?>, <?php echo $dec_sal; ?>]
        }
      ]
    };
    var barChartCanvas = $("#barChart").get(0).getContext("2d");
    var barChart = new Chart(barChartCanvas);
    barChartData.datasets[1].fillColor = "#00a65a";
    barChartData.datasets[1].strokeColor = "#00a65a";
    barChartData.datasets[1].pointColor = "#00a65a";
    var barChartOptions = {
      //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
      scaleBeginAtZero: true,
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines: true,
      //String - Colour of the grid lines
      scaleGridLineColor: "rgba(0,0,0,.05)",
      //Number - Width of the grid lines
      scaleGridLineWidth: 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines: true,
      //Boolean - If there is a stroke on each bar
      barShowStroke: true,
      //Number - Pixel width of the bar stroke
      barStrokeWidth: 2,
      //Number - Spacing between each of the X value sets
      barValueSpacing: 5,
      //Number - Spacing between data sets within X values
      barDatasetSpacing: 1,
      //String - A legend template
      legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
      //Boolean - whether to make the chart responsive
      responsive: true,
      maintainAspectRatio: true
    };

    barChartOptions.datasetFill = false;
    barChart.Bar(barChartData, barChartOptions);
  });


  /* PIE CHART*/
         Highcharts.chart('bar_container', {
             chart: {
                 plotBackgroundColor: null,
                 plotBorderWidth: null,
                 plotShadow: false,
                 type: 'pie'
             },
             title: {
                 text: '<?= lang('app.top_10_trending_items'); ?> %'
             },
             tooltip: {
                 /*pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'*/
                 pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
             },
             plotOptions: {
                 pie: {
                     allowPointSelect: true,
                     cursor: 'pointer',
                     dataLabels: {
                         enabled: true,
                         format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                         style: {
                             color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                         }
                     }
                 }
             },
             series: [{
                 name: 'Item',
                 colorByPoint: true,
                 data: [
                 <?php 
            //PIE CHART
           if($pie_chart){ 
              foreach($pie_chart as $res3){
                  //extract($res3);
                  if($res3['sales_qty']>0){
                  echo "{name:'".$res3['item_name']."', y:".$res3['sales_qty']."},";
                  }
              }
            }
            ?>
                 ]
             }]
         });
         /* PIE CHART END*/
</script>
</body>
</html>
