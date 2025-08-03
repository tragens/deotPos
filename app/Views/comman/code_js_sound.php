<!-- Notification sound -->
<audio id="failed">
  <source src="<?= base_url('theme/sound/failed.mp3')?>" type="audio/mpeg">
  <source src="<?= base_url('theme/sound/failed.ogg')?>" type="audio/ogg">
</audio>
<audio id="success">
  <source src="<?= base_url('theme/sound/success.mp3')?>" type="audio/mpeg">
  <source src="<?= base_url('theme/sound/success.ogg')?>" type="audio/ogg">
</audio>
<script type="text/javascript">
  var failed_sound = document.getElementById("failed"); 
  var success_sound = document.getElementById("success"); 
</script>

<script type="text/javascript">
<?php if($session->getFlashdata('success')!=''){ ?>
      success_sound.play();
<?php } ?>
<?php if($session->getFlashdata('failed')!=''){ ?>
      failed_sound.play();
<?php } ?>
</script>
<!-- Notification end -->