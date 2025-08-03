<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?= $SITE_TITLE; ?> | Log in</title>
  <link rel='shortcut icon' href='<?= base_url('theme/images/favicon.ico') ?>' />
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?= base_url('theme/bootstrap/css/bootstrap.min.css') ?>">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url('theme/dist/css/AdminLTE.min.css') ?>">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?= base_url('theme/plugins/iCheck/square/blue.css') ?>">

</head>
<body class="hold-transition login-page" style="height:0;background-repeat: no-repeat;background: url('<?= base_url('uploads/bg/pos-background.jpeg') ?>') no-repeat center center fixed">

<div class="login-box">
  <div class="login-logo">
    <a href="#"><b>
      <img src="<?= base_url('uploads/'.$LOGO);?>" width="60%" height="70px">
    </b></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>

    <div class="text-danger text-center">
      <?php 
        $this->session = \Config\Services::session();
        echo $this->session->getFlashdata('msg');
      ?>        
    </div>
    
    <form action="<?= base_url('login/verify'); ?>" method="post" id="login">
      <?= csrf_field() ?>
      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="Username" id="username" name="username" autofocus><span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Password" id="pass" name="pass">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox"> Remember Me
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
       
     
    </form>
    <a href="login/forgot_password">I forgot my password</a><br>
    <div class="row">
      <div class="col-md-12 text-right">
        <p style='font-style: italic;'>Version <?= $VERSION; ?></p>   
      </div>
    </div>
    
  </div>
  <!-- /.login-box-body -->
  
</div>

<!-- /.login-box -->




<!-- jQuery 2.2.3 -->
<script src="<?= base_url('theme/plugins/jQuery/jquery-2.2.3.min.js')?>"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?= base_url('theme/bootstrap/js/bootstrap.min.js')?>"></script>
<!-- iCheck -->
<script src="<?= base_url('theme/plugins/iCheck/icheck.min.js')?>"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
</body>
</html>
