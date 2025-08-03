<!-- Change the theme color if it is set -->
   <script type="text/javascript">
    if(theme_skin!='skin-blue'){
      $("body").addClass(theme_skin);
      $("body").removeClass('skin-blue');
    }
    if(sidebar_collapse=='true'){
      $("body").addClass('sidebar-collapse');
    }
  </script> 
  <!-- end -->

<header class="main-header">

    <!-- Logo -->
    <a href="<?= base_url('dashboard')?>" class="logo">
      <span class="logo-mini"><b>POS</b></span>
      <span class="logo-lg"><b><?=  $SITE_TITLE;?></b></span>
    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <div class="btn-group hidden-xs">
            <a href="#" class="btn navbar-btn btn-success dropdown-toggle "   data-toggle="dropdown" aria-expanded="false">
                <i class="fa fa-plus"></i> 
            </a>
            <ul class="dropdown-menu" >
                  <?php if(has_permission('sales_add')) { ?>
                  <li class="border_bottom">
                    <a href="<?= base_url('sales/add')?>')?>" ><h4><i class="fa fa-plus text-green"></i> <?= lang('sales'); ?></h4></a>
                  </li> 
                  <?php } ?>
                  <?php if(has_permission('purchase_add')) { ?>
                  <li class="border_bottom">
                    <a href="<?= base_url('purchase/add')?>" ><h4><i class="fa fa-plus text-green"></i> <?= lang('purchase'); ?></h4></a>
                  </li> 
                  <?php } ?>
                  <?php if(has_permission('customers_add')) { ?>
                  <li class="border_bottom">
                    <a href="<?= base_url('customers/add')?>" ><h4><i class="fa fa-plus text-green"></i> <?= lang('customer'); ?></h4></a>
                  </li> 
                  <?php } ?>
                  <?php if(has_permission('suppliers_add')) { ?>
                  <li class="border_bottom">
                    <a href="<?= base_url('suppliers/add')?>" ><h4><i class="fa fa-plus text-green"></i> <?= lang('supplier'); ?></h4></a>
                  </li>
                  <?php } ?>
                  <?php if(has_permission('items_add')) { ?>
                  <li class="border_bottom">
                    <a href="<?= base_url('items/add')?>" ><h4><i class="fa fa-plus text-green"></i> <?= lang('item'); ?></h4></a>
                  </li> 
                  <?php } ?>
                  <?php if(has_permission('expense_add')) { ?>
                  <li class="border_bottom">
                    <a href="<?= base_url('expense/add')?>" ><h4><i class="fa fa-plus text-green"></i> <?= lang('expense'); ?></h4></a>
                  </li>  
                  <?php } ?>
            </ul>
        </div>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
       
        <ul class="nav navbar-nav">
          <!-- <li class="text-center hidden-xs" id="">
            <form class="navbar-form navbar-left" role="search">
            <div class="form-group">
              <input type="text" class="form-control" id="navbar-search-input" placeholder="Search Sales Invoice">
            </div>
          </form> 
          </li> -->
          <!-- User Account Menu -->
            
            <li class="dropdown tasks-menu">
            <a href="#" class="dropdown-toggle text-right" data-toggle="dropdown" title="App Language" data-toggle='tooltip'>
              <i class="fa fa-language "></i>
                    <?= $session->get('language'); ?>
            </a>
            <ul class="dropdown-menu " style="width: auto;height: auto;">
              <li>
                <ul class="menu">
                  <?php 
                  // $lang_query=$this->db->query('select * from db_languages where status=1 order by language asc');
                  // foreach ($lang_query->result() as $res) { 
                  //   $selected='';
                  //   if($session->get('language')==$res->language){
                  //     $selected ='text-blue';
                  //   }
                    ?>
                    <li>
                    <!-- <a href="< ?= $base_url;?>site/langauge/< ?= $res->id;?>" ><h3 class='< ?=$selected;?>'>< ?= $res->language;?></h3></a> -->
                  </li>  
                  <?php //} ?>
                </ul>
              </li>
            </ul>
          </li>
          
          <?php if(has_permission('pos')) { ?>
          <li class="text-center" id="">
            <a title="POS [Shift+P]" href="<?= base_url('pos')?>')?>"><i class="fa fa-plus-square " ></i> POS </a>   
          </li>
          <?php } ?>

          <li class="text-center hidden-xs" id="">
            <a title="Dashboard" href="<?= base_url('dashboard')?>"><i class="fa fa-dashboard " ></i> <?= lang('dashboard'); ?></a>
          </li>
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?= $profile_picture; ?>" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php print ucfirst($session->get('inv_username')); ?></span>
            </a>

            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?= $profile_picture; ?>" class="img-circle" alt="User Image">

                <p>
                 <?php print ucfirst($session->get('inv_username')); ?>
                  <small>Year <?=date("Y");?></small>
                </p>
              </li>
              <!-- Menu Body -->
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="<?= base_url('users/edit/'. $session->get('inv_userid')); ?>" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="<?= base_url('Login/logout')?>" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          <li class="hidden-xs">
            <a href="#" data-toggle="control-sidebar')?>"><i class="fa fa-gears"></i></a>
          </li>
        </ul>
      </div>

    </nav>
  </header>
 
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?= $profile_picture; ?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php print ucfirst($session->get('inv_username')); ?><i class="fa fa-fw fa-check-circle text-aqua"></i></p>
          <a href="#')?>"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <!--<li class="header">MAIN NAVIGATION</li>-->
		<li class="dashboard-active-li "><a href="<?= base_url('dashboard')?>"><i class="fa fa-dashboard text-aqua"></i> <span><?= lang('dashboard'); ?></span></a></li>
		
		
		<!--<li class="header">SALES</li>-->
    <?php if(has_permission('sales_add')  || $permission('pos')  || $permission('sales_view') || $permission('sales_return_view') || $permission('sales_return_add')) { ?>
		<li class="pos-active-li sales-list-active-li sales-active-li sales-return-active-li sales-return-list-active-li treeview">
          <a href="#">
            <i class=" fa fa-shopping-cart text-aqua"></i> <span><?= lang('sales'); ?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
        <?php if(has_permission('pos')) { ?>
        <li class="pos-active-li"><a href="<?= base_url('pos')?>"><i class="fa fa-calculator "></i> <span>POS</span></a></li>
        <?php } ?>
        <?php if(has_permission('sales_add')) { ?>
		    <li class="sales-active-li"><a href="<?= base_url('sales/add')?>"><i class="fa fa-plus-square-o "></i> <span><?= lang('new_sales'); ?></span></a></li>
        <?php } ?>
        
        <?php if(has_permission('sales_view')) { ?>
        <li class="sales-list-active-li"><a href="<?= base_url('sales')?>"><i class="fa fa-list "></i> <span><?= lang('sales_list'); ?></span></a></li>
        <?php } ?>

        <?php if(has_permission('sales_return_add')) { ?>
        <li class="sales-return-active-li"><a href="<?= base_url('sales_return/create')?>"><i class="fa fa-plus-square-o "></i> <span><?= lang('new_sales_return'); ?></span></a></li>
        <?php } ?>

        <?php if(has_permission('sales_return_view')) { ?>
        <li class="sales-return-list-active-li"><a href="<?= base_url('sales_return')?>"><i class="fa fa-list "></i> <span><?= lang('sales_returns_list'); ?></span></a></li>
        <?php } ?>

          </ul>
        </li>
    <?php } ?>

		<!--<li class="header">CUSTOMERS</li>-->
    <?php if(has_permission('customers_add') || $permission('customers_view') || $permission('import_customers')) { ?>
    <li class="customers-view-active-li customers-active-li import_customers-active-li treeview">
          <a href="#">
            <i class="fa fa-group text-aqua"></i> <span><?= lang('customers'); ?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
         <?php if(has_permission('customers_add')) { ?>
        <li class="customers-active-li"><a href="<?= base_url('customers/add')?>"><i class="fa fa-plus-square-o "></i> <span><?= lang('new_customer'); ?></span></a></li>
        <?php } ?>
        <?php if(has_permission('customers_view')) { ?>
         <li class="customers-view-active-li"><a href="<?= base_url('customers')?>"><i class="fa fa-list "></i> <span><?= lang('customers_list'); ?></span></a></li>
         <?php } ?>

         <?php if(has_permission('import_customers')) { ?>
         <li class="import_customers-active-li"><a href="<?= base_url('import/customers')?>"><i class="fa fa-arrow-circle-o-left "></i> <span><?= lang('import_customers'); ?></span></a></li>
         <?php } ?>

          </ul>
        </li>    
    <?php } ?>

    <?php if(has_permission('purchase_add') || $permission('purchase_view') || $permission('purchase_return_view') || $permission('new_purchase_return')) { ?>
		<li class="purchase-list-active-li purchase-active-li purchase-returns-list-active-li purchase-returns-active-li treeview">
          <a href="#">
            <i class="fa fa-th-large text-aqua"></i> <span><?= lang('purchase'); ?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <?php if(has_permission('purchase_add')) { ?>
    		    <li class="purchase-active-li"><a href="<?= base_url('purchase/add')?>"><i class="fa fa-plus-square-o "></i> <span><?= lang('new_purchase'); ?></span></a></li>
            <?php } ?>
            <?php if(has_permission('purchase_view')) { ?>
            <li class="purchase-list-active-li"><a href="<?= base_url('purchase')?>"><i class="fa fa-list "></i> <span><?= lang('purchase_list'); ?></span></a></li>
            <?php } ?>
            <?php if(has_permission('purchase_return_view')) { ?>
            <li class="purchase-returns-active-li"><a href="<?= base_url('purchase_return/create')?>"><i class="fa fa-plus-square-o "></i> <span><?= lang('new_purchase_return'); ?></span></a></li>
            <?php } ?>
            <?php if(has_permission('purchase_return_view')) { ?>
            <li class="purchase-returns-list-active-li"><a href="<?= base_url('purchase_return')?>"><i class="fa fa-list "></i> <span><?= lang('purchase_returns_list'); ?></span></a></li>
            <?php } ?>
          </ul>
        </li>
        <?php } ?>
        <?php if(has_permission('suppliers_add') || $permission('suppliers_view') || $permission('import_suppliers')) { ?>
        <li class="suppliers-list-active-li suppliers-active-li import_suppliers-active-li treeview">
          <a href="#">
            <i class="fa fa-user-plus text-aqua"></i> <span><?= lang('suppliers'); ?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
              <?php if(has_permission('suppliers_add')) { ?>
              <li class="suppliers-active-li"><a href="<?= base_url('suppliers/add')?>"><i class="fa fa-plus-square-o "></i> <span><?= lang('new_supplier'); ?></span></a></li>
              <?php } ?>
              <?php if(has_permission('suppliers_view')) { ?>
              <li class="suppliers-list-active-li"><a href="<?= base_url('suppliers')?>"><i class="fa fa-list "></i> <span><?= lang('suppliers_list'); ?></span></a></li>
              <?php } ?>

              <?php if(has_permission('import_suppliers')) { ?>
               <li class="import_suppliers-active-li"><a href="<?= base_url('import/suppliers')?>"><i class="fa fa-arrow-circle-o-left "></i> <span><?= lang('import_suppliers'); ?></span></a></li>
               <?php } ?>
         
          </ul>
        </li>
        <?php } ?>
        
        <?php if(has_permission('items_add') || $permission('items_view') || $permission('items_category_add') || $permission('items_category_view') || $permission('brand_add') || $permission('brand_view') || $permission('print_labels')) { ?>
        <li class="items-list-active-li items-active-li  category-view-active-li category-active-li brand-active-li brand-view-active-li labels-active-li import_items-active-li treeview">
          <a href="#">
            <i class="fa fa-cubes text-aqua"></i> <span><?= lang('items'); ?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <?php if(has_permission('items_add')) { ?>
            <li class="items-active-li"><a href="<?= base_url('items/add')?>"><i class="fa fa-plus-square-o "></i> <span><?= lang('new_item'); ?></span></a></li>
            <?php } ?>
            <?php if(has_permission('items_view')) { ?>
            <li class="items-list-active-li"><a href="<?= base_url('items')?>"><i class="fa fa-list "></i> <span><?= lang('items_list'); ?></span></a></li>
            <?php } ?>
            <?php if(has_permission('items_category_add')) { ?>
            <li class="category-active-li"><a href="<?= base_url('category/add')?>"><i class="fa fa-plus-square-o "></i> <span><?= lang('new_category'); ?></span></a></li>
            <?php } ?>
            <?php if(has_permission('items_category_view')) { ?>
            <li class="category-view-active-li"><a href="<?= base_url('category/view')?>"><i class="fa fa-list "></i> <span><?= lang('categories_list'); ?></span></a></li>
            <?php } ?>
            <?php if(has_permission('brand_add')) { ?>
            <li class="brand-active-li"><a href="<?= base_url('brands/add')?>"><i class="fa fa-plus-square-o "></i> <span><?= lang('new_brand'); ?></span></a></li>
            <?php } ?>
            <?php if(has_permission('brand_view')) { ?>
            <li class="brand-view-active-li"><a href="<?= base_url('brands/view')?>"><i class="fa fa-list "></i> <span><?= lang('brands_list'); ?></span></a></li>
            <?php } ?>
            <?php if(has_permission('print_labels')) { ?>
            <li class="labels-active-li"><a href="<?= base_url('items/labels')?>"><i class="fa fa-barcode "></i> <span><?= lang('print_labels'); ?></span></a></li>
            <?php } ?>

            <?php if(has_permission('import_items')) { ?>
               <li class="import_items-active-li"><a href="<?= base_url('import/items')?>"><i class="fa fa-arrow-circle-o-left "></i> <span><?= lang('import_items'); ?></span></a></li>
               <?php } ?>


          </ul>
        </li>
        <?php } ?>

        <?php if(has_permission('expense_add') || $permission('expense_view') || $permission('expense_category_add') || $permission('expense_category_view')) { ?>
       <li class="expense-list-active-li expense-active-li expense-category-active-li expense-category-list-active-li treeview">
          <a href="#">
            <i class="fa fa-minus-circle text-aqua"></i> <span><?= lang('expenses'); ?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <?php if(has_permission('expense_add')) { ?>
            <li class="expense-active-li"><a href="<?= base_url('expense/add')?>"><i class="fa fa-plus-square-o "></i> <span><?= lang('new_expense'); ?></span></a></li>
            <?php } ?>
            <?php if(has_permission('expense_view')) { ?>
            <li class="expense-list-active-li"><a href="<?= base_url('expense')?>"><i class="fa fa-list "></i> <span><?= lang('expenses_list'); ?></span></a></li>
            <?php } ?>
            <?php if(has_permission('expense_category_add')) { ?>
            <li class="expense-category-active-li"><a href="<?= base_url('expense/category_add')?>"><i class="fa fa-plus-square-o "></i> <span><?= lang('new_category'); ?></span></a></li>
            <?php } ?>
            <?php if(has_permission('expense_category_view')) { ?>
            <li class="expense-category-list-active-li "><a href="<?= base_url('expense/category')?>"><i class="fa fa-list "></i> <span><?= lang('categories_list'); ?></span></a></li>
            <?php } ?>

          </ul>
        </li>
        <?php } ?>
		

        
		

		<?php if(has_permission('places_add') || $permission('places_view')) { ?>
		<li class="country-active-li city-list-active-li country-list-active-li state-active-li state-list-active-li city-active-li treeview">
          <a href="#">
            <i class="fa fa-paper-plane-o text-aqua"></i> <span><?= lang('places'); ?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <?php if(has_permission('places_add')) { ?>
            <li class="country-active-li"><a href="<?= base_url('country/add')?>"><i class="fa fa-plus-square-o "></i> <span><?= lang('new_country'); ?></span></a></li>
            <?php } ?>
            <?php if(has_permission('places_view')) { ?>
            <li class="country-list-active-li "><a href="<?= base_url('country')?>"><i class="fa fa-list "></i> <span><?= lang('countries_list'); ?></span></a></li>
            <?php } ?>
            <?php if(has_permission('places_add')) { ?>
            <li class="state-active-li"><a href="<?= base_url('state/add')?>"><i class="fa fa-plus-square-o "></i> <span><?= lang('new_state'); ?></span></a></li>
            <?php } ?>
            <?php if(has_permission('places_view')) { ?>
            <li class="state-list-active-li "><a href="<?= base_url('state')?>"><i class="fa fa-list "></i> <span><?= lang('states_list'); ?></span></a></li>
            <?php } ?>
    </ul>
        </li>
    <?php } ?>

   
		<!--<li class="header">REPORTS</li>-->
    <?php if(has_permission('item_purchase_report') ||$permission('sales_report') || $permission('item_sales_report') || $permission('purchase_report') || $permission('purchase_return_report') || $permission('expense_report') || $permission('profit_report') || $permission('stock_report') || $permission('purchase_payments_report') || $permission('sales_payments_report') || $permission('expired_items_report')) { ?>
		<li class="report-sales-active-li report-sales-return-active-li report-purchase-active-li report-purchase-return-active-li report-expense-active-li report-profit-loss-active-li report-stock-active-li report-purchase-payments-active-li report-sales-item-active-li report-sales-payments-active-li report-expired-items-active-li report-purchase-item-active-li treeview">
          <a href="#">
            <i class="fa fa-bar-chart text-aqua"></i> <span><?= lang('reports'); ?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">

            <?php if(has_permission('profit_report')) { ?>
            <li class="report-profit-loss-active-li"><a href="<?= base_url('reports/profit_loss')?>" ><i class="fa fa-files-o "></i> <span><?= lang('profit_and_loss_report'); ?></span></a></li>
            <?php } ?>

            <?php if(has_permission('purchase_report')) { ?>
            <li class="report-purchase-active-li"><a href="<?= base_url('reports/purchase')?>" ><i class="fa fa-files-o "></i> <span><?= lang('purchase_report'); ?></span></a></li>
            <?php } ?>
            <?php if(has_permission('purchase_return_report')) { ?>
            <li class="report-purchase-return-active-li"><a href="<?= base_url('reports/purchase_return')?>" ><i class="fa fa-files-o "></i> <span><?= lang('purchase_return_report'); ?></span></a></li>
            <?php } ?>

            <?php if(has_permission('purchase_payments_report')) { ?>
            <li class="report-purchase-payments-active-li"><a href="<?= base_url('reports/purchase_payments')?>" ><i class="fa fa-files-o "></i> <span><?= lang('purchase_payments_report'); ?></span></a></li>
            <?php } ?>

            <?php if(has_permission('item_sales_report')) { ?>
            <li class="report-sales-item-active-li"><a href="<?= base_url('reports/item_sales')?>" ><i class="fa fa-files-o "></i> <span><?= lang('item_sales_report'); ?></span></a></li>
            <?php } ?>
            <?php if(has_permission('item_purchase_report')) { ?>
            <li class="report-purchase-item-active-li"><a href="<?= base_url('reports/item_purchase')?>" ><i class="fa fa-files-o "></i> <span><?= lang('item_purchase_report'); ?></span><span class="pull-right-container">
              <span class="label label-success pull-right">New</span>
            </span></a></li>
            <?php } ?>
            <?php if(has_permission('sales_report')) { ?>
            <li class="report-sales-active-li"><a href="<?= base_url('reports/sales')?>" ><i class="fa fa-files-o "></i> <span><?= lang('sales_report'); ?></span></a></li>
            <?php } ?>
            <?php if(has_permission('sales_return_report')) { ?>
            <li class="report-sales-return-active-li"><a href="<?= base_url('reports/sales_return')?>" ><i class="fa fa-files-o "></i> <span><?= lang('sales_return_report'); ?></span></a></li>
            <?php } ?>
            
            <?php if(has_permission('sales_payments_report')) { ?>
            <li class="report-sales-payments-active-li"><a href="<?= base_url('reports/sales_payments')?>" ><i class="fa fa-files-o "></i> <span><?= lang('sales_payments_report'); ?></span></a></li>  
            <?php } ?>


            <?php if(has_permission('stock_report')) { ?>
            <li class="report-stock-active-li"><a href="<?= base_url('reports/stock')?>" ><i class="fa fa-files-o "></i> <span><?= lang('stock_report'); ?></span>
              </a></li>
            <?php } ?>

            <?php if(has_permission('expense_report')) { ?>
            <li class="report-expense-active-li"><a href="<?= base_url('reports/expense')?>" ><i class="fa fa-files-o "></i> <span><?= lang('expense_report'); ?></span></a></li>
            <?php } ?>
            
            
            
            
            
            <?php if(has_permission('expired_items_report')) { ?>
            <li class="report-expired-items-active-li"><a href="<?= base_url('reports/expired_items')?>" ><i class="fa fa-files-o "></i> <span><?= lang('expired_items_report'); ?></span></a></li>  
            <?php } ?>
	       </ul>
      </li>
      <?php } ?>

	   <!-- Users -->
     <?php if(has_permission('users_add') || $permission('users_view') || $permission('roles_view')) { ?>
     <li class="users-view-active-li users-active-li roles-list-active-li role-active-li treeview">
          <a href="#">
            <i class="fa fa-users text-aqua"></i> <span><?= lang('users'); ?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <?php if(has_permission('users_add')) { ?>
            <li class="users-active-li"><a href="<?= base_url('users/')?>"><i class="fa fa-plus-square-o "></i> <span><?= lang('new_user'); ?></span></a></li>
            <?php } ?>
            <?php if(has_permission('users_view')) { ?>
            <li class="users-view-active-li"><a href="<?= base_url('users/view')?>"><i class="fa fa-list "></i> <span><?= lang('users_list'); ?></span></a></li>
            <?php } ?>
            <?php if(has_permission('roles_view')) { ?>
            <li class="roles-list-active-li role-active-li">
              <a href="<?= base_url('roles/view')?>">
                <i class="fa fa-list "></i> 
                <span><?= lang('roles_list'); ?></span></a>
            </li>
            <?php } ?>
          </ul>
        </li>
        <?php } ?>
    <!-- SMS -->
     <?php if(has_permission('send_sms') || $permission('sms_template_view') || $permission('sms_api_view')) { ?>
     <li class="sms-active-li sms-api-active-li sms-template-active-li sms-templates-list-active-li treeview">
          <a href="#">
            <i class="fa fa-envelope text-aqua"></i> <span><?= lang('sms'); ?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <?php if(has_permission('send_sms')) { ?>
            <li class="sms-active-li"><a href="<?= base_url('sms')?>"><i class="fa fa-envelope-o "></i> <span><?= lang('send_sms'); ?></span></a></li>
            <?php } ?>
            <?php if(has_permission('sms_template_view')) { ?>
            <li class="sms-templates-list-active-li sms-template-active-li"><a href="<?= base_url('templates/sms')?>"><i class="fa fa-list "></i> <span><?= lang('sms_templates'); ?></span></a></li>
            <?php } ?>
            <?php if(has_permission('sms_api_view')) { ?>
            <li class="sms-api-active-li"><a href="<?= base_url('sms/api')?>"><i class="fa fa-cube "></i> <span><?= lang('sms_api'); ?></span></a></li>
            <?php } ?>
          </ul>
        </li>
        <?php } ?>
		<!--<li class="header">SETTINGS</li>-->
    <?php if($change_password=true) { ?>
		<li class=" company-profile-active-li site-settings-active-li  change-pass-active-li dbbackup-active-li warehouse-active-li warehouse-list-active-li tax-active-li currency-view-active-li currency-active-li  database_updater-active-li tax-list-active-li units-list-active-li unit-active-li payment_types_list-active-li payment_types-active-li treeview">
          <a href="#">
            <i class="fa fa-gears text-aqua"></i> <span><?= lang('settings'); ?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <?php if(has_permission('company_edit')) { ?>
            <li class="company-profile-active-li"><a href="<?= base_url('company')?>"><i class="fa fa-suitcase "></i> <span><?= lang('company_profile'); ?></span></a></li>
            <?php } ?>
            <?php if(has_permission('site_edit')) { ?>
            <li class="site-settings-active-li"><a href="<?= base_url('site')?>"><i class="fa fa-shield  "></i> <span><?= lang('site_settings'); ?></span></a></li>
            <?php } ?>

            
            <?php if(has_permission('tax_view')) { ?>
            <li class="tax-active-li  tax-list-active-li"><a href="<?= base_url('tax')?>"><i class="fa fa-percent  "></i> <span><?= lang('tax_list'); ?></span></a></li>
            <?php } ?>
            <?php if(has_permission('units_view')) { ?>
            <li class="units-list-active-li unit-active-li"><a href="<?= base_url('units/')?>"><i class="fa fa-list "></i> <span><?= lang('units_list'); ?></span></a></li>
            <?php } ?>

            <?php if(has_permission('payment_types_view')) { ?>
            <li class="payment_types_list-active-li payment_types-active-li"><a href="<?= base_url('payment_types/')?>"><i class="fa fa-list "></i> <span><?= lang('payment_types_list'); ?></span></a></li>
            <?php } ?>

            <?php if(has_permission('currency_view')) { ?>
            <li class="currency-view-active-li currency-active-li"><a href="<?= base_url('currency/view')?>"><i class="fa fa-gg "></i> <span><?= lang('currency_list'); ?></span></a></li>
            <?php } ?>
            <li class="change-pass-active-li"><a href="<?= base_url('users/password_reset')?>"><i class="fa fa-lock "></i> <span><?= lang('change_password'); ?></span></a></li>


            <?php if(has_permission('database_backup')) { ?>
            <li class="dbbackup-active-li"><a href="<?= base_url('users/dbbackup')?>"><i class="fa fa-database "></i> <span><?= lang('database_backup'); ?></span></a></li>
            <?php } ?>
            
		   </ul>
        </li>
        <?php } ?>
        <?php if(has_permission('help')) { ?>
        <li><a href="<?= base_url('help/')?>" target="_blank"  ><i class="fa fa-book "></i> <span><?= lang('help'); ?></span></a></li>

        <?php } ?>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
