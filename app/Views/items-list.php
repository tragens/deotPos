<!DOCTYPE html>
<html>

<head>
<!-- TABLES CSS CODE -->
<?php include"comman/code_css_datatable.php"; ?>

<!-- Lightbox -->
<link rel="stylesheet" href="<?= base_url('theme/plugins/lightbox/ekko-lightbox.css')?>">
</head>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <!-- Left side column. contains the logo and sidebar -->
  
  <?php include"sidebar.php"; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?=$page_title;?>
        <small>View/Search Items</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?= base_url('dashboard')?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?=$page_title;?></li>
      </ol>
    </section>

    <!-- Main content -->
    <form action="#" id="table_form" method="post">
    <input type="hidden" class="txt_csrfname" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
    <input type="hidden" id='base_url' value="<?= base_url() ;?>">

    <section class="content">
      <div class="row">
        <!-- ********** ALERT MESSAGE START******* -->
        <?php include"comman/code_flashdata.php"; ?>
        <!-- ********** ALERT MESSAGE END******* -->
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border">
              <div class="row">
                    <div class="col-md-12">
                    <div class="col-md-3">
                        <label for="brand_id" class=" control-label"><?= lang('app.brand'); ?></label>
                          <select class="form-control select2" id="brand_id" name="brand_id"  style="width: 100%;">
                            <?php
                               if($brands)
                                {  echo '<option value="">-Select-</option>'; 
                                    foreach($brands as $res1)
                                  { 
                                    echo "<option value='".$res1['id']."'>".$res1['brand_name']."</option>";
                                  }
                                }
                                else
                                {
                                   ?>
                            <option value="">No Records Found</option>
                            <?php
                               }
                               ?>
                         </select>
                    </div>
                    <div class="col-md-3">
                        <label for="category_id" class=" control-label"><?= lang('app.category'); ?></label>
                          <select class="form-control select2" id="category_id" name="category_id"  style="width: 100%;">
                            <?php

                               if($category)
                                {  echo '<option value="">-Select-</option>'; 
                                    foreach($category as $res1)
                                  { 
                                    echo "<option value='".$res1['id']."'>".$res1['category_name']."</option>";
                                  }
                                }
                                else
                                {
                                   ?>
                            <option value="">No Records Found</option>
                            <?php
                               }
                               ?>
                         </select>
                    </div>
                    
                  </div>
                </div>

              <?php if(has_permission('items_add')) { ?>
              <div class="box-tools">
                <a class="btn btn-block btn-info " href="<?= base_url('items/add')?>">
                <i class="fa fa-plus " ></i> <?= lang('app.new_item'); ?></a>
              </div>
             <?php } ?>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example2" class="table table-bordered table-striped" width="100%">
                <thead class="bg-primary ">
                <tr>
                  <th class="text-center">
                    <input type="checkbox" class="group_check checkbox" >
                  </th>
                  <th><?= lang('app.image'); ?></th>
                  <th><?= lang('app.item_code'); ?></th>
                  <th><?= lang('app.item_name'); ?></th>
                  <th><?= lang('app.brand'); ?></th>
                  <th><?= lang('app.category'); ?></th>
                  <th><?= lang('app.unit'); ?></th>
                  <th><?= lang('app.stock_qty'); ?></th>
                  <th><?= lang('app.minimum_qty'); ?></th>
                  <th><?= lang('app.purchase_price'); ?></th>
                  <th><?= lang('app.final_sales_price'); ?></th>
                  <th><?= lang('app.tax'); ?></th>
	         	  	  <th><?= lang('app.status'); ?></th>
                  <th><?= lang('app.action'); ?></th>
                </tr>
                </thead>
                <tbody>
				
                </tbody>
               
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
    </form>
  </div>
  <!-- /.content-wrapper -->
  <?php include"footer.php"; ?>
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- SOUND CODE -->
<?php include"comman/code_js_sound.php"; ?>
<!-- TABLES CODE -->
<?php include"comman/code_js_datatable.php"; ?>
<!-- Lightbox -->
<script src="<?= base_url('theme/plugins/lightbox/ekko-lightbox.js')?>"></script>
<script type="text/javascript">
  $(document).on('click', '[data-toggle="lightbox"]', function(event) {
            event.preventDefault();
            $(this).ekkoLightbox();
        });
</script>
<script type="text/javascript">
function load_datatable(){

    const csrfName = $('.txt_csrfname').attr('name');
    const csrfHash = $('.txt_csrfname').val();

    //datatables
   var table = $('#example2').DataTable({ 

      /* FOR EXPORT BUTTONS START*/
  dom:'<"row margin-bottom-12"<"col-sm-12"<"pull-left"l><"pull-right"fr><"pull-right margin-left-10 "B>>>tip',
 /* dom:'<"row"<"col-sm-12"<"pull-left"B><"pull-right">>> <"row margin-bottom-12"<"col-sm-12"<"pull-left"l><"pull-right"fr>>>tip',*/
      buttons: {
        buttons: [
            {
                className: 'btn bg-red color-palette btn-flat hidden delete_btn pull-left',
                text: 'Delete',
                action: function ( e, dt, node, config ) {
                    multi_delete();
                }
            },
            { extend: 'copy', className: 'btn bg-teal color-palette btn-flat',exportOptions: { columns: [2,3,4,5,6,7,8,9,10,11,12]} },
            { extend: 'excel', className: 'btn bg-teal color-palette btn-flat',exportOptions: { columns: [2,3,4,5,6,7,8,9,10,11,12]} },
            { extend: 'pdf', className: 'btn bg-teal color-palette btn-flat',exportOptions: { columns: [2,3,4,5,6,7,8,9,10,11,12]} },
            { extend: 'print', className: 'btn bg-teal color-palette btn-flat',exportOptions: { columns: [2,3,4,5,6,7,8,9,10,11,12]} },
            { extend: 'csv', className: 'btn bg-teal color-palette btn-flat',exportOptions: { columns: [2,3,4,5,6,7,8,9,10,11,12]} },
            { extend: 'colvis', className: 'btn bg-teal color-palette btn-flat',text:'Columns' },  

            ]
        },
        /* FOR EXPORT BUTTONS END */

        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
        "responsive": true,
        language: {
            processing: '<div class="text-primary bg-primary" style="position: relative;z-index:100;overflow: visible;">Processing...</div>'
        },
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?= base_url('items/ajax_list') ?>",
            "type": "POST",
            "data":{
              [csrfName]: csrfHash,
              brand_id : $("#brand_id").val(),
              category_id : $("#category_id").val(),
            },
            
            complete: function (data) {
             $('.column_checkbox').iCheck({
                checkboxClass: 'icheckbox_square-orange',
                /*uncheckedClass: 'bg-white',*/
                radioClass: 'iradio_square-orange',
                increaseArea: '10%' // optional
              });
             call_code();
              //$(".delete_btn").hide();
             },

        },

        //Set column definition initialisation properties.
        "columnDefs": [
        { 
            "targets": [ 0,1,12,13 ], //first column / numbering column
            "orderable": false, //set not orderable
        },
        {
            "targets" :[0],
            "className": "text-center",
        },
        
        ],
    });
    new $.fn.dataTable.FixedHeader( table );
}

$(document).ready(function() {
    //datatables
   load_datatable();
});
$("#brand_id,#category_id").on("change",function(){
    $('#example2').DataTable().destroy();
    load_datatable();
});

</script>


<script src="<?= base_url('theme/js/items.js')?>"></script>

<!-- Make sidebar menu hughlighter/selector -->
<script>$(".<?php echo basename(__FILE__,'.php');?>-active-li").addClass("active");</script>
		
</body>
</html>
