<div class="col-md-12">
          <?php
            if($session->getFlashdata('success')!=''):
              ?>
                <div class="alert alert-success alert-dismissable text-center">
                 <a href="javascript:void()" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong><?= $session->getFlashdata('success') ?></strong>
              </div> 
               <?php 
            endif;
            if($session->getFlashdata('error')!=''):
              ?>
                <div class="alert alert-danger alert-dismissable text-center">
                 <a href="javascript:void()" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong><?= $session->getFlashdata('error') ?></strong>
              </div> 
               <?php
            endif;
            if($session->getFlashdata('warning')!=''):
              ?>
                <div class="alert alert-warning alert-dismissable text-center">
                 <a href="javascript:void()" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong><?= $session->getFlashdata('warning') ?></strong>
              </div> 
               <?php
            endif;
            if($session->getFlashdata('info')!=''):
              ?>
                <div class="alert alert-info alert-dismissable text-center">
                 <a href="javascript:void()" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong><?= $session->getFlashdata('info') ?></strong>
              </div> 
               <?php
            endif;
            ?>
            <!-- ********** ALERT MESSAGE END******* -->
     </div>