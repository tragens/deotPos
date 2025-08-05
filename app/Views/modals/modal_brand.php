<div class="modal fade " id="brand_modal" tabindex='-1'>
                <form action="#" class="form" id="brand_form" method="post" enctype='multipart/form-data'>
                <div class="modal-dialog modal-sm">
                  <div class="modal-content">
                    <div class="modal-header header-custom">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title text-center"><?= lang('app.add_brand'); ?></h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                          <div class="col-md-12">
                            <div class="box-body">
                              <div class="form-group">
                                <label for="brand"><?= lang('app.brand_name'); ?>*</label>
                                <span id="brand_msg" class="text-danger text-right pull-right"></span>
                                <input type="text" class="form-control" id="brand" name="brand" placeholder="" >
                              </div>
                            </div>
                          </div>
                          <div class="col-md-12">
                            <div class="box-body">
                              <div class="form-group">
                                <label for="description"><?= lang('app.description'); ?></label>
                                <span id="description_msg" class="text-danger text-right pull-right"></span>
                                <textarea type="text" class="form-control" id="description" name="description" placeholder="" ></textarea>
                              </div>
                            </div>
                          </div>

                        </div>
                       
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                      <button type="button" class="btn btn-primary add_brand">Save</button>
                    </div>
                  </div>
                  <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
              </form>
              </div>
              <!-- /.modal -->