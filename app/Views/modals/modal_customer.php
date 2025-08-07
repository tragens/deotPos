<div class="modal fade " id="customer-modal" tabindex='-1'>
                <form action="#" id="customer-form" method="post">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header header-custom">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title text-center"><?= lang('app.add_customer'); ?></h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                          <div class="col-md-4">
                            <div class="box-body">
                              <div class="form-group">
                                <label for="customer_name"><?= lang('app.customer_name'); ?>*</label>
                                <span id="customer_name_msg" class="text-danger text-right pull-right"></span>
                                <input type="text" class="form-control" id="customer_name" name="customer_name" placeholder="" >
                              </div>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="box-body">
                              <div class="form-group">
                                <label for="mobile"><?= lang('app.mobile'); ?></label>
                                <span id="mobile_msg" class="text-danger text-right pull-right"></span>
                                <input type="tel"  class="form-control no_special_char_no_space " id="mobile" name="mobile" placeholder=""  >
                              </div>
                            </div>
                          </div>

                          <div class="col-md-4">
                            <div class="box-body">
                              <div class="form-group">
                                <label for="phone"><?= lang('app.phone'); ?></label>
                                <span id="phone_msg" class="text-danger text-right pull-right"></span>
                                <input type="tel" maxlength="10" class="form-control maxlength no_special_char_no_space " id="phone" name="phone" placeholder=""  >
                              </div>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="box-body">
                              <div class="form-group">
                                <label for="email"><?= lang('app.email'); ?></label>
                                <span id="email_msg" class="text-danger text-right pull-right"></span>
                                <input type="email" class="form-control " id="email" name="email" placeholder=""  >
                              </div>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="box-body">
                              <div class="form-group">
                                <label for="opening_balance"><?= lang('app.previous_due'); ?></label>
                                <span id="opening_balance_msg" class="text-danger text-right pull-right"></span>
                                <input type="text" class="form-control" id="opening_balance" name="opening_balance" placeholder="" >
                              </div>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="box-body">
                              <div class="form-group">
                                <label for="gstin_msg"><?= lang('app.gst_number'); ?></label>
                                <span id="gstin_msg" class="text-danger text-right pull-right"></span>
                                <input type="text" class="form-control maxlength  " id="gstin" name="gstin" placeholder=""  >
                              </div>
                            </div>
                          </div>

                          <div class="col-md-4">
                            <div class="box-body">
                              <div class="form-group">
                                <label for="tax_number"><?= lang('app.tax_number'); ?></label>
                                <span id="tax_number_msg" class="text-danger text-right pull-right"></span>
                                <input type="text"  class="form-control maxlength  " id="tax_number" name="tax_number" placeholder=""  >
                              </div>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="box-body">
                              <div class="form-group">
                                <label for="country"><?= lang('app.country'); ?></label>
                                <span id="country_msg" class="text-danger text-right pull-right"></span>
                               <select class="form-control select2" id="country" name="country"  style="width: 100%;" onkeyup="shift_cursor(event,'state')" value="">
                                  <?php
                                  if($country)
                                   {
                                       foreach($country as $res1)
                                     {
                                       echo "<option value='".$res1['id']."'>".$res1['country']."</option>";
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
                          <div class="col-md-4">
                            <div class="box-body">
                              <div class="form-group">
                                <label for="state"><?= lang('app.state'); ?></label>
                                <span id="state_msg" class="text-danger text-right pull-right"></span>
                               <select class="form-control" id="state" name="state"  style="width: 100%;" onkeyup="shift_cursor(event,'state_code')">
                                  <?php
                                  if($states)
                                   {
                                    echo '<option value="">-Select-</option>'; 
                                    foreach($states as $res1)
                                     {
                                       echo "<option value='".$res1['id']."'>".$res1['state']."</option>";
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
                         <div class="col-md-4">
                          <div class="box-body">
                            <div class="form-group">
                              <label for="city"><?= lang('app.city'); ?></label>
                              <span id="city_msg" class="text-danger text-right pull-right"></span>
                              <input type="text" class="form-control" id="city" name="city" placeholder="" >
                            </div>
                          </div>
                        </div>
                          <div class="col-md-4">
                            <div class="box-body">
                              <div class="form-group">
                                <label for="postcode"><?= lang('app.postcode'); ?></label>
                                <span id="postcode_msg" class="text-danger text-right pull-right"></span>
                                <input type="text" class="form-control" id="postcode" name="postcode" placeholder="" >
                              </div>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="box-body">
                              <div class="form-group">
                                <label for="address"><?= lang('app.address'); ?></label>
                                <span id="address_msg" class="text-danger text-right pull-right"></span>
                                <textarea type="text" class="form-control" id="address" name="address" placeholder="" ></textarea>
                              </div>
                            </div>
                          </div>

                        </div>
                       
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                      <button type="button" class="btn btn-primary add_customer">Save</button>
                    </div>
                  </div>
                  <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
              </form>
              </div>
              <!-- /.modal -->