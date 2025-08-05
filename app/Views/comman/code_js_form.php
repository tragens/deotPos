<!-- Bootstrap 3.3.6 -->
<script src="<?= base_url('theme/bootstrap/js/bootstrap.min.js')?>"></script>
<!-- AdminLTE App -->
<script>
  var AdminLTEOptions = {
    /*https://adminlte.io/themes/AdminLTE/documentation/index.html*/
    sidebarExpandOnHover: true,
    navbarMenuHeight: "200px", //The height of the inner menu
    animationSpeed: 250,
  };
</script>
<script src="<?= base_url('theme/dist/js/app.js')?>"></script>
<!-- FastClick -->
<script src="<?= base_url('theme/plugins/fastclick/fastclick.js')?>"></script>
<!-- Select2 -->
<script src="<?= base_url('theme/plugins/select2/select2.full.min.js')?>"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?= base_url('theme/dist/js/demo.js')?>"></script>
<!--Toastr notification -->
<script src="<?= base_url('theme/toastr/toastr.js')?>"></script>
<script src="<?= base_url('theme/toastr/toastr_custom.js')?>"></script>
<!-- bootstrap datepicker -->
<script src="<?= base_url('theme/plugins/daterangepicker/moment.min.js')?>"></script>
<script src="<?= base_url('theme/plugins/daterangepicker/daterangepicker.js')?>"></script>
<!-- bootstrap datepicker -->
<script src="<?= base_url('theme/plugins/datepicker/bootstrap-datepicker.js')?>"></script>
<!-- Sweet alert -->
<script src="<?= base_url('theme/js/sweetalert.min.js')?>"></script>
<!-- Shortcut Keys -->
<script src="<?= base_url('theme/plugins/shortcuts/shortcuts.js')?>"></script>
<!-- Custom JS -->
<script src="<?= base_url('theme/js/special_char_check.js')?>"></script>
<script src="<?= base_url('theme/js/custom.js')?>"></script>
<!-- sweet alert -->
<script src="<?= base_url('theme/js/sweetalert.min.js')?>"></script>
<!-- Autocomplete -->      
<script src="<?= base_url('theme/plugins/autocomplete/autocomplete.js')?>"></script>
<!-- Pace Loader -->
<script src="<?= base_url('theme/plugins/pace/pace.min.js')?>"></script>

<!-- iCheck -->
<script src="<?= base_url('theme/plugins/iCheck/icheck.min.js')?>"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-orange',
      /*uncheckedClass: 'bg-white',*/
      radioClass: 'iradio_square-orange',
      increaseArea: '10%' // optional
    });
  });
</script>

<!-- Initialize Select2 Elements -->
<script type="text/javascript"> $(".select2").select2(); </script>
<!-- Initialize date with its Format -->
<script type="text/javascript">
  //Date picker
    $('.datepicker').datepicker({
      autoclose: true,
    format: '<?php echo $VIEW_DATE;?>',
     todayHighlight: true
    });
</script>
<!-- DATE RANGE PICKER -->
<script>
  $(function () {
    //Date range as a button
    $('.daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('.daterange-btn span').html(start.format('<?php echo strtoupper($VIEW_DATE) ;?>') + ' - ' + end.format('<?php echo strtoupper($VIEW_DATE);?>'))
      }
    );


  });

    function get_start_date(input_id){
        return $('#'+input_id).data('daterangepicker').startDate.format('<?php echo strtoupper($VIEW_DATE) ;?>');
    }
    function get_end_date(input_id){
        return $('#'+input_id).data('daterangepicker').endDate.format('<?php echo strtoupper($VIEW_DATE) ;?>');
    }
</script>
<!-- Initialize toggler -->
<script type="text/javascript">
  $(document).ready(function(){
      $('[data-toggle="popover"]').popover();   
  });
</script>
<!-- start pace loader -->
<script type="text/javascript">
$(document).ajaxStart(function() { Pace.restart(); }); 
</script>  
<script type="text/javascript">
$(document).ready(function () { setTimeout(function() {$( ".alert-dismissable" ).fadeOut( 1000, function() {});}, 10000); });
</script>
<script type="text/javascript">
  function round_off(input=0){
    <?php if(is_enabled_round_off()){ ?>
      return Math.round(input);
    <?php }else{?>
      return input;
    <?php }?>
  }
</script>
<script>
  function tax_disabled(){
    <?php if(is_tax_disabled()){ ?>
      return true;
    <?php }else{?>
      return false;
    <?php }?>
  }
</script>